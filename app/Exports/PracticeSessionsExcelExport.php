<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PracticeSessionsExcelExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    protected $practicesessions;

    public function __construct($practicesessions)
    {
        $this->practicesessions = $practicesessions;
    }

    public function collection()
    {
        return $this->practicesessions;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Title',
            'Date',
            'Start Time',
            'End Time',
            'Location',
            'Description',
            'Status',
            'Created At',
            'Updated At',
        ];
    }

    public function map($practicesession): array
    {
        return [
            $practicesession->id ?? 'N/A',
            $practicesession->title ?? 'N/A',
            $practicesession->date ?? 'N/A',
            $practicesession->start_time ?? 'N/A',
            $practicesession->end_time ?? 'N/A',
            $practicesession->location ?? 'N/A',
            $practicesession->description ?? 'N/A',
            $practicesession->status ?? 'N/A',
            $practicesession->created_at->format('Y-m-d H:i:s'),
            $practicesession->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    public function title(): string
    {
        return 'PracticeSessions Export';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Add title and export date at the top
                $sheet->insertNewRowBefore(1, 3);
                
                // Add title
                $sheet->setCellValue('A1', 'THE HARMONY SINGERS CHOIR');
                $sheet->mergeCells('A1:J1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                
                // Add subtitle
                $sheet->setCellValue('A2', 'PracticeSessions Export Report');
                $sheet->mergeCells('A2:J2');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                
                // Add export date
                $sheet->setCellValue('A3', 'Exported on: ' . now()->format('F j, Y \a\t g:i A'));
                $sheet->mergeCells('A3:J3');
                $sheet->getStyle('A3')->getFont()->setSize(12);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
                
                // Add empty row
                $sheet->insertNewRowBefore(5, 1);
                
                // Style the headers (now in row 5)
                $headerRange = 'A5:J5';
                $sheet->getStyle($headerRange)->getFont()->setBold(true);
                $sheet->getStyle($headerRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('3B82F6');
                $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal('center');
                
                // Auto-fit columns
                foreach (range('A', 'J') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}