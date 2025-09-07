<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PracticeSession;
use App\Models\PracticeAttendance;
use App\Models\Member;
use App\Services\PracticeSessionExportService;
use App\Services\AttendanceExportService;
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
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 10);
        $practiceSessions = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.practice-sessions.index', compact('practiceSessions'));
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        $exportService = new PracticeSessionExportService();
        return $exportService->exportToExcel($request);
    }

    /**
     * Export to PDF
     */
    public function exportPdf(Request $request)
    {
        $exportService = new PracticeSessionExportService();
        return $exportService->exportToPdf($request);
    }

    /**
     * Show the form for creating a new practice session.
     */
    public function create()
    {
        $members = Member::active()->orderBy('first_name')->get();
        return view('admin.practice-sessions.create', compact('members'));
    }

    /**
     * Store a newly created practice session.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'practice_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attendees' => 'nullable|array',
            'attendees.*' => 'exists:members,id',
        ]);

        $practiceSession = PracticeSession::create([
            'title' => $validated['title'],
            'practice_date' => $validated['practice_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'location' => $validated['location'],
            'description' => $validated['description'],
        ]);

        // Create attendance records
        if (!empty($validated['attendees'])) {
            foreach ($validated['attendees'] as $memberId) {
                PracticeAttendance::create([
                    'practice_session_id' => $practiceSession->id,
                    'member_id' => $memberId,
                    'attended' => true,
                ]);
            }
        }

        return redirect()->route('admin.practice-sessions.index')
            ->with('success', 'Practice session created successfully.');
    }

    /**
     * Display the specified practice session.
     */
    public function show(PracticeSession $practiceSession)
    {
        $practiceSession->load('attendances.member');
        return view('admin.practice-sessions.show', compact('practiceSession'));
    }

    /**
     * Show the form for editing the specified practice session.
     */
    public function edit(PracticeSession $practiceSession)
    {
        $members = Member::active()->orderBy('first_name')->get();
        $practiceSession->load('attendances');
        return view('admin.practice-sessions.edit', compact('practiceSession', 'members'));
    }

    /**
     * Update the specified practice session.
     */
    public function update(Request $request, PracticeSession $practiceSession)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'practice_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attendees' => 'nullable|array',
            'attendees.*' => 'exists:members,id',
        ]);

        $practiceSession->update([
            'title' => $validated['title'],
            'practice_date' => $validated['practice_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'location' => $validated['location'],
            'description' => $validated['description'],
        ]);

        // Update attendance records
        $practiceSession->attendances()->delete();
        if (!empty($validated['attendees'])) {
            foreach ($validated['attendees'] as $memberId) {
                PracticeAttendance::create([
                    'practice_session_id' => $practiceSession->id,
                    'member_id' => $memberId,
                    'attended' => true,
                ]);
            }
        }

        return redirect()->route('admin.practice-sessions.index')
            ->with('success', 'Practice session updated successfully.');
    }

    /**
     * Remove the specified practice session.
     */
    public function destroy(PracticeSession $practiceSession)
    {
        $practiceSession->attendances()->delete();
        $practiceSession->delete();

        return redirect()->route('admin.practice-sessions.index')
            ->with('success', 'Practice session deleted successfully.');
    }

    /**
     * Show attendance for a specific practice session.
     */
    public function attendance(PracticeSession $practiceSession)
    {
        $practiceSession->load('attendances.member');
        $members = Member::active()->orderBy('first_name')->get();
        $activeSingers = Member::active()->singers()->orderBy('first_name')->get();

        // Calculate voice part statistics
        $voicePartStats = [
            'soprano' => $activeSingers->where('voice_part', 'soprano')->count(),
            'alto' => $activeSingers->where('voice_part', 'alto')->count(),
            'tenor' => $activeSingers->where('voice_part', 'tenor')->count(),
            'bass' => $activeSingers->where('voice_part', 'bass')->count(),
        ];

        // Calculate attendance statistics
        $attendanceStats = [
            'present' => $practiceSession->attendances()->where('attended', true)->count(),
            'late' => $practiceSession->attendances()->where('attended', true)->where('is_late', true)->count(),
            'excused' => $practiceSession->attendances()->where('attended', false)->where('is_excused', true)->count(),
            'absent' => $activeSingers->count() - $practiceSession->attendances()->where('attended', true)->count(),
            'total' => $activeSingers->count(),
        ];

        return view('admin.practice-sessions.attendance', compact('practiceSession', 'members', 'activeSingers', 'voicePartStats', 'attendanceStats'));
    }

    /**
     * Update attendance for a practice session.
     */
    public function updateAttendance(Request $request, PracticeSession $practiceSession)
    {
        $validated = $request->validate([
            'selected_members' => 'nullable|array',
            'selected_members.*' => 'exists:members,id',
            'attendance' => 'nullable|array',
            'attendance.*.reason' => 'nullable|string|max:255',
            'attendance.*.notes' => 'nullable|string|max:500',
            'attendance.*.status' => 'nullable|string|in:present,absent,late,excused',
            'attendance.*.arrival_time' => 'nullable|date',
        ]);

        // Delete existing attendance records
        $practiceSession->attendances()->delete();

        // Process selected members (for checkbox selection)
        if (!empty($validated['selected_members'])) {
            foreach ($validated['selected_members'] as $memberId) {
                $attendanceData = $validated['attendance'][$memberId] ?? [];

                PracticeAttendance::create([
                    'practice_session_id' => $practiceSession->id,
                    'member_id' => $memberId,
                    'status' => $attendanceData['status'] ?? 'present',
                    'reason' => $attendanceData['reason'] ?? null,
                    'notes' => $attendanceData['notes'] ?? null,
                    'arrival_time' => $attendanceData['arrival_time'] ?? now(),
                ]);
            }
        }

        // Process attendance data for all members (including those not selected)
        if (!empty($validated['attendance'])) {
            foreach ($validated['attendance'] as $memberId => $attendanceData) {
                // Skip if already processed in selected_members
                if (in_array($memberId, $validated['selected_members'] ?? [])) {
                    continue;
                }

                // Create attendance record for non-selected members with their status
                if (!empty($attendanceData['status'])) {
                    PracticeAttendance::create([
                        'practice_session_id' => $practiceSession->id,
                        'member_id' => $memberId,
                        'status' => $attendanceData['status'],
                        'reason' => $attendanceData['reason'] ?? null,
                        'notes' => $attendanceData['notes'] ?? null,
                        'arrival_time' => $attendanceData['arrival_time'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.practice-sessions.attendance', $practiceSession)
            ->with('success', 'Attendance updated successfully.');
    }

    /**
     * Export attendance for a practice session (CSV).
     */
    public function exportAttendance(PracticeSession $practiceSession)
    {
        $exportService = new AttendanceExportService();
        return $exportService->exportToCsv($practiceSession);
    }

    /**
     * Export attendance to Excel for a practice session.
     */
    public function exportAttendanceExcel(PracticeSession $practiceSession)
    {
        $exportService = new AttendanceExportService();
        return $exportService->exportToExcel($practiceSession);
    }

    /**
     * Export attendance to PDF for a practice session.
     */
    public function exportAttendancePdf(PracticeSession $practiceSession)
    {
        $exportService = new AttendanceExportService();
        return $exportService->exportToPdf($practiceSession);
    }
}
