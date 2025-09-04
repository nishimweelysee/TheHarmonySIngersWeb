<?php

namespace App\Services;

use App\Models\PracticeSession;
use App\Models\Member;
use App\Exports\AttendanceExcelExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceExportService
{
    /**
     * Export attendance to Excel
     */
    public function exportToExcel(PracticeSession $practiceSession)
    {
        $practiceSession->load('attendances.member');

        // Get all active singers for comparison
        $allMembers = Member::active()->singers()->orderBy('first_name')->get();

        $filename = 'practice_session_' . $practiceSession->id . '_attendance_' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new AttendanceExcelExport($practiceSession, $allMembers), $filename);
    }

    /**
     * Export attendance to PDF
     */
    public function exportToPdf(PracticeSession $practiceSession)
    {
        $practiceSession->load('attendances.member');

        // Get all active singers for comparison
        $allMembers = Member::active()->singers()->orderBy('first_name')->get();

        // Calculate statistics
        $stats = $this->calculateAttendanceStats($practiceSession, $allMembers);

        $pdf = Pdf::loadView('admin.practice-sessions.exports.attendance-pdf', [
            'practiceSession' => $practiceSession,
            'allMembers' => $allMembers,
            'stats' => $stats,
            'exportDate' => now(),
        ]);

        $filename = 'practice_session_' . $practiceSession->id . '_attendance_' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export attendance to CSV
     */
    public function exportToCsv(PracticeSession $practiceSession)
    {
        $practiceSession->load('attendances.member');

        // Get all active singers for comparison
        $allMembers = Member::active()->singers()->orderBy('first_name')->get();

        $filename = 'practice_session_' . $practiceSession->id . '_attendance_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($practiceSession, $allMembers) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'Member Name',
                'Email',
                'Phone',
                'Voice Part',
                'Status',
                'Reason',
                'Notes',
                'Arrival Time',
                'Recorded At'
            ]);

            // Create a map of attendance records by member ID
            $attendanceMap = $practiceSession->attendances->keyBy('member_id');

            // CSV data - include all members
            foreach ($allMembers as $member) {
                $attendance = $attendanceMap->get($member->id);

                fputcsv($file, [
                    $member->first_name . ' ' . $member->last_name,
                    $member->email,
                    $member->phone,
                    $member->voice_part ?? 'N/A',
                    $attendance ? ucfirst($attendance->status) : 'Not Recorded',
                    $attendance ? $attendance->reason : '',
                    $attendance ? $attendance->notes : '',
                    $attendance && $attendance->arrival_time ? $attendance->arrival_time->format('Y-m-d H:i:s') : '',
                    $attendance ? $attendance->created_at->format('Y-m-d H:i:s') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calculate attendance statistics
     */
    private function calculateAttendanceStats(PracticeSession $practiceSession, $allMembers)
    {
        $attendanceMap = $practiceSession->attendances->keyBy('member_id');

        $stats = [
            'total_members' => $allMembers->count(),
            'present' => 0,
            'absent' => 0,
            'late' => 0,
            'excused' => 0,
            'not_recorded' => 0,
            'by_voice_part' => [
                'soprano' => ['present' => 0, 'absent' => 0, 'late' => 0, 'excused' => 0, 'not_recorded' => 0],
                'alto' => ['present' => 0, 'absent' => 0, 'late' => 0, 'excused' => 0, 'not_recorded' => 0],
                'tenor' => ['present' => 0, 'absent' => 0, 'late' => 0, 'excused' => 0, 'not_recorded' => 0],
                'bass' => ['present' => 0, 'absent' => 0, 'late' => 0, 'excused' => 0, 'not_recorded' => 0],
            ]
        ];

        foreach ($allMembers as $member) {
            $attendance = $attendanceMap->get($member->id);
            $status = $attendance ? $attendance->status : 'not_recorded';

            $stats[$status]++;

            $voicePart = $member->voice_part ?? 'unknown';
            if (isset($stats['by_voice_part'][$voicePart])) {
                $stats['by_voice_part'][$voicePart][$status]++;
            }
        }

        return $stats;
    }
}
