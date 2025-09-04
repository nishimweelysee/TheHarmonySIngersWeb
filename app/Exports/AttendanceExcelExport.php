<?php

namespace App\Exports;

use App\Models\PracticeSession;
use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AttendanceExcelExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    protected $practiceSession;
    protected $allMembers;

    public function __construct(PracticeSession $practiceSession, $allMembers)
    {
        $this->practiceSession = $practiceSession;
        $this->allMembers = $allMembers;
    }

    public function collection()
    {
        return $this->allMembers;
    }

    public function headings(): array
    {
        return [
            'Member Name',
            'Email',
            'Phone',
            'Voice Part',
            'Status',
            'Reason',
            'Notes',
            'Arrival Time',
            'Recorded At'
        ];
    }

    public function map($member): array
    {
        $attendance = $this->practiceSession->attendances->where('member_id', $member->id)->first();
        
        return [
            $member->first_name . ' ' . $member->last_name,
            $member->email,
            $member->phone,
            $member->voice_part ?? 'N/A',
            $attendance ? ucfirst($attendance->status) : 'Not Recorded',
            $attendance ? $attendance->reason : '',
            $attendance ? $attendance->notes : '',
            $attendance && $attendance->arrival_time ? $attendance->arrival_time->format('Y-m-d H:i:s') : '',
            $attendance ? $attendance->created_at->format('Y-m-d H:i:s') : ''
        ];
    }

    public function title(): string
    {
        return 'Attendance Report';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Insert title rows
                $sheet->insertNewRowBefore(1, 3);
                $sheet->setCellValue('A1', 'THE HARMONY SINGERS CHOIR');
                $sheet->mergeCells('A1:I1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                
                $sheet->setCellValue('A2', 'Practice Session Attendance Report');
                $sheet->mergeCells('A2:I2');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                
                $sheet->setCellValue('A3', 'Session: ' . $this->practiceSession->title . ' - ' . $this->practiceSession->practice_date->format('F j, Y'));
                $sheet->mergeCells('A3:I3');
                $sheet->getStyle('A3')->getFont()->setSize(12);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
                
                $sheet->insertNewRowBefore(5, 1);
                
                // Style headers
                $headerRange = 'A5:I5';
                $sheet->getStyle($headerRange)->getFont()->setBold(true);
                $sheet->getStyle($headerRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('3B82F6');
                $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal('center');
                
                // Auto-size columns
                foreach (range('A', 'I') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
                
                // Add conditional formatting for status
                $statusColumn = 'E'; // Status column
                $lastRow = $sheet->getHighestRow();
                
                for ($row = 6; $row <= $lastRow; $row++) {
                    $status = $sheet->getCell($statusColumn . $row)->getValue();
                    $fillColor = match(strtolower($status)) {
                        'present' => 'D1FAE5', // Green
                        'absent' => 'FEE2E2', // Red
                        'late' => 'FEF3C7',   // Yellow
                        'excused' => 'E0E7FF', // Blue
                        default => 'F3F4F6'   // Gray
                    };
                    
                    $sheet->getStyle($statusColumn . $row)->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setRGB($fillColor);
                }
            },
        ];
    }
}
