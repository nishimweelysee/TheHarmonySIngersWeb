<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AuditLogsExcelExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    protected $auditlogs;

    public function __construct($auditlogs)
    {
        $this->auditlogs = $auditlogs;
    }

    public function collection()
    {
        return $this->auditlogs;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Event',
            'User Name',
            'User Email',
            'Model Type',
            'Model ID',
            'Description',
            'IP Address',
            'Date & Time',
        ];
    }

    public function map($auditlog): array
    {
        return [
            $auditlog->id ?? 'N/A',
            ucfirst($auditlog->event ?? 'N/A'),
            $auditlog->user ? $auditlog->user->name : 'System',
            $auditlog->user ? $auditlog->user->email : 'Automated Action',
            $auditlog->auditable_type ? class_basename($auditlog->auditable_type) : 'N/A',
            $auditlog->auditable_id ?? 'N/A',
            $auditlog->description ?? 'N/A',
            $auditlog->ip_address ?? 'N/A',
            $auditlog->created_at->format('M j, Y H:i:s'),
        ];
    }

    public function title(): string
    {
        return 'AuditLogs Export';
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
                $sheet->mergeCells('A1:I1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // Add subtitle
                $sheet->setCellValue('A2', 'Audit Logs Export Report');
                $sheet->mergeCells('A2:I2');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                // Add export date
                $sheet->setCellValue('A3', 'Exported on: ' . now()->format('F j, Y \a\t g:i A'));
                $sheet->mergeCells('A3:I3');
                $sheet->getStyle('A3')->getFont()->setSize(12);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');

                // Add empty row
                $sheet->insertNewRowBefore(5, 1);

                // Style the headers (now in row 5)
                $headerRange = 'A5:I5';
                $sheet->getStyle($headerRange)->getFont()->setBold(true);
                $sheet->getStyle($headerRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('3B82F6');
                $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal('center');

                // Auto-fit columns
                foreach (range('A', 'I') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
