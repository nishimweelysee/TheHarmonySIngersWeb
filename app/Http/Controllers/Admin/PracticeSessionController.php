<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PracticeSession;
use App\Models\PracticeAttendance;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PracticeSessionController extends Controller
{
    /**
     * Display a listing of practice sessions.
     */
    public function index(Request $request)
    {
        $query = PracticeSession::with('attendances');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('venue', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date filter
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->today();
                    break;
                case 'this_week':
                    $query->thisWeek();
                    break;
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'past':
                    $query->where('practice_date', '<', now()->toDateString());
                    break;
            }
        }

        $practiceSessions = $query->orderBy('practice_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.practice-sessions.index', compact('practiceSessions'));
    }

    /**
     * Show the form for creating a new practice session.
     */
    public function create()
    {
        return view('admin.practice-sessions.create');
    }

    /**
     * Store a newly created practice session.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'practice_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'venue' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $practiceSession = PracticeSession::create($request->all());

            // Create attendance records for all active singers
            $activeSingers = Member::active()->singers()->get();
            foreach ($activeSingers as $singer) {
                PracticeAttendance::create([
                    'practice_session_id' => $practiceSession->id,
                    'member_id' => $singer->id,
                    'status' => 'absent' // Default status
                ]);
            }

            DB::commit();

            Log::info('Practice session created', [
                'session_id' => $practiceSession->id,
                'title' => $practiceSession->title,
                'date' => $practiceSession->practice_date,
                'attendees_count' => $activeSingers->count()
            ]);

            return redirect()->route('admin.practice-sessions.index')
                ->with('success', 'Practice session created successfully with ' . $activeSingers->count() . ' singers added.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create practice session', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return back()->withInput()
                ->with('error', 'Failed to create practice session. Please try again.');
        }
    }

    /**
     * Display the specified practice session.
     */
    public function show(PracticeSession $practiceSession)
    {
        $practiceSession->load(['attendances.member']);

        $attendanceStats = $practiceSession->attendance_count;
        $attendancePercentage = $practiceSession->attendance_percentage;

        return view('admin.practice-sessions.show', compact('practiceSession', 'attendanceStats', 'attendancePercentage'));
    }

    /**
     * Show the form for editing the specified practice session.
     */
    public function edit(PracticeSession $practiceSession)
    {
        return view('admin.practice-sessions.edit', compact('practiceSession'));
    }

    /**
     * Update the specified practice session.
     */
    public function update(Request $request, PracticeSession $practiceSession)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'practice_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'venue' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => ['required', Rule::in(['scheduled', 'in_progress', 'completed', 'cancelled'])]
        ]);

        try {
            $practiceSession->update($request->all());

            Log::info('Practice session updated', [
                'session_id' => $practiceSession->id,
                'title' => $practiceSession->title,
                'status' => $practiceSession->status
            ]);

            return redirect()->route('admin.practice-sessions.show', $practiceSession)
                ->with('success', 'Practice session updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update practice session', [
                'session_id' => $practiceSession->id,
                'error' => $e->getMessage()
            ]);

            return back()->withInput()
                ->with('error', 'Failed to update practice session. Please try again.');
        }
    }

    /**
     * Remove the specified practice session.
     */
    public function destroy(PracticeSession $practiceSession)
    {
        try {
            $title = $practiceSession->title;
            $practiceSession->delete();

            Log::info('Practice session deleted', [
                'session_title' => $title
            ]);

            return redirect()->route('admin.practice-sessions.index')
                ->with('success', 'Practice session deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete practice session', [
                'session_id' => $practiceSession->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to delete practice session. Please try again.');
        }
    }

    /**
     * Show attendance management for a practice session.
     */
    public function attendance(PracticeSession $practiceSession)
    {
        $practiceSession->load(['attendances.member']);

        // Get all active singers and merge with existing attendance
        $activeSingers = Member::active()->singers()->orderBy('first_name')->get();
        $existingAttendances = $practiceSession->attendances->keyBy('member_id');

        // Ensure all active singers have attendance records
        foreach ($activeSingers as $singer) {
            if (!$existingAttendances->has($singer->id)) {
                PracticeAttendance::create([
                    'practice_session_id' => $practiceSession->id,
                    'member_id' => $singer->id,
                    'status' => 'absent'
                ]);
            }
        }

        // Reload to get the updated attendance records
        $practiceSession->load(['attendances.member']);

        // Calculate current attendance statistics for preview
        $currentAttendance = $practiceSession->attendances;
        $attendanceStats = [
            'present' => $currentAttendance->where('status', 'present')->count(),
            'late' => $currentAttendance->where('status', 'late')->count(),
            'absent' => $currentAttendance->where('status', 'absent')->count(),
            'excused' => $currentAttendance->where('status', 'excused')->count(),
        ];

        // Calculate voice part statistics
        $voicePartStats = [
            'soprano' => $activeSingers->where('voice_part', 'soprano')->count(),
            'alto' => $activeSingers->where('voice_part', 'alto')->count(),
            'tenor' => $activeSingers->where('voice_part', 'tenor')->count(),
            'bass' => $activeSingers->where('voice_part', 'bass')->count(),
        ];

        return view('admin.practice-sessions.attendance', compact('practiceSession', 'activeSingers', 'attendanceStats', 'voicePartStats'));
    }

    /**
     * Update attendance for a practice session.
     */
    public function updateAttendance(Request $request, PracticeSession $practiceSession)
    {
        // Debug logging
        Log::info('Attendance update request received', [
            'session_id' => $practiceSession->id,
            'request_data' => $request->all(),
            'attendance_data' => $request->attendance ?? 'No attendance data'
        ]);

        // Validate the attendance data structure
        $request->validate([
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:present,absent,late,excused',
            'attendance.*.reason' => 'nullable|string|max:500',
            'attendance.*.notes' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->attendance as $memberId => $attendanceData) {
                // Debug logging for each member
                Log::info('Processing attendance for member', [
                    'member_id' => $memberId,
                    'attendance_data' => $attendanceData,
                    'member_id_type' => gettype($memberId)
                ]);

                // Find or create attendance record
                $attendance = PracticeAttendance::where('practice_session_id', $practiceSession->id)
                    ->where('member_id', $memberId)
                    ->first();

                if ($attendance) {
                    $attendance->update([
                        'status' => $attendanceData['status'],
                        'reason' => $attendanceData['reason'] ?? null,
                        'notes' => $attendanceData['notes'] ?? null
                    ]);

                    // Record arrival time for present/late status
                    if (in_array($attendanceData['status'], ['present', 'late']) && !$attendance->arrival_time) {
                        $attendance->update(['arrival_time' => now()]);
                    }
                } else {
                    // Create new attendance record if it doesn't exist
                    PracticeAttendance::create([
                        'practice_session_id' => $practiceSession->id,
                        'member_id' => $memberId,
                        'status' => $attendanceData['status'],
                        'reason' => $attendanceData['reason'] ?? null,
                        'notes' => $attendanceData['notes'] ?? null,
                        'arrival_time' => in_array($attendanceData['status'], ['present', 'late']) ? now() : null
                    ]);
                }
            }

            DB::commit();

            Log::info('Practice attendance updated', [
                'session_id' => $practiceSession->id,
                'attendances_count' => count($request->attendance)
            ]);

            return redirect()->route('admin.practice-sessions.attendance', $practiceSession)
                ->with('success', 'Attendance updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update practice attendance', [
                'session_id' => $practiceSession->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to update attendance. Please try again.');
        }
    }

    /**
     * Export attendance data for a practice session.
     */
    public function exportAttendance(PracticeSession $practiceSession)
    {
        $practiceSession->load(['attendances.member']);

        $filename = 'practice_attendance_' . $practiceSession->practice_date->format('Y-m-d') . '_' . $practiceSession->id . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($practiceSession) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'Member Name',
                'Voice Part',
                'Status',
                'Reason',
                'Arrival Time',
                'Departure Time',
                'Notes'
            ]);

            // CSV data
            foreach ($practiceSession->attendances as $attendance) {
                fputcsv($file, [
                    $attendance->member->full_name,
                    $attendance->member->voice_part ?? 'N/A',
                    $attendance->status_label,
                    $attendance->reason ?? '',
                    $attendance->arrival_time ? $attendance->arrival_time->format('H:i') : '',
                    $attendance->departure_time ? $attendance->departure_time->format('H:i') : '',
                    $attendance->notes ?? ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
