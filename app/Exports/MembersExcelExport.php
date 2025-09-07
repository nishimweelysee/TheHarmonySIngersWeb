<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MembersExcelExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    protected $members;

    public function __construct($members)
    {
        $this->members = $members;
    }

    public function collection()
    {
        return $this->members;
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Type',
            'Voice Part',
            'Status',
            'Joined Date',
            'Date of Birth',
            'Address',
            'Created At',
            'Updated At'
        ];
    }

    public function map($member): array
    {
        // Format phone number properly
        $phone = $member->phone ?? 'N/A';
        if ($phone !== 'N/A' && !empty($phone)) {
            // Convert to string and clean up
            $phoneStr = (string) $phone;

            // Remove any existing + and spaces
            $phoneStr = str_replace(['+', ' ', '-', '(', ')'], '', $phoneStr);

            // Format if it starts with 250 (with or without +)
            if (strpos($phoneStr, '250') === 0) {
                // Format as +250 XXX XXX XXX
                if (strlen($phoneStr) >= 12) {
                    $phoneStr = '+250 ' . substr($phoneStr, 3, 3) . ' ' . substr($phoneStr, 6, 3) . ' ' . substr($phoneStr, 9);
                } else {
                    $phoneStr = '+250 ' . substr($phoneStr, 3);
                }
            }
            // Add a single quote prefix to force Excel to treat as text
            $phone = "'" . $phoneStr;
        }

        return [
            $member->id,
            $member->first_name ?? 'N/A',
            $member->last_name ?? 'N/A',
            $member->email ?? 'N/A',
            $phone,
            ucfirst($member->type ?? 'N/A'),
            ucfirst($member->voice_part ?? 'N/A'),
            ucfirst($member->status ?? 'N/A'),
            $member->joined_date ? $member->joined_date->format('Y-m-d') : 'N/A',
            $member->date_of_birth ? $member->date_of_birth->format('Y-m-d') : 'N/A',
            $member->address ?? 'N/A',
            $member->created_at->format('Y-m-d H:i:s'),
            $member->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    public function title(): string
    {
        return 'Members Export';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Add title and export date at the top
                $sheet->insertNewRowBefore(1, 3);

                // Add title
                $sheet->setCellValue('A1', 'THE HARMONY SINGERS CHOIR');
                $sheet->mergeCells('A1:M1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // Add subtitle
                $sheet->setCellValue('A2', 'Members Export Report');
                $sheet->mergeCells('A2:M2');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                // Add export date
                $sheet->setCellValue('A3', 'Exported on: ' . now()->format('F j, Y \a\t g:i A'));
                $sheet->mergeCells('A3:M3');
                $sheet->getStyle('A3')->getFont()->setSize(12);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');

                // Add empty row
                $sheet->insertNewRowBefore(5, 1);

                // Style the headers (now in row 5)
                $headerRange = 'A5:M5';
                $sheet->getStyle($headerRange)->getFont()->setBold(true);
                $sheet->getStyle($headerRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('3B82F6');
                $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal('center');

                // Auto-fit columns
                foreach (range('A', 'M') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Format phone column as text to prevent scientific notation
                $phoneColumn = 'E'; // Phone is in column E
                $sheet->getStyle($phoneColumn . '6:' . $phoneColumn . $sheet->getHighestRow())
                    ->getNumberFormat()
                    ->setFormatCode('@'); // @ format code forces text format
            },
        ];
    }
}
