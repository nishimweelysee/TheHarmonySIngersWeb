<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PermissionsExcelExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    protected $permissions;

    public function __construct($permissions)
    {
        $this->permissions = $permissions;
    }

    public function collection()
    {
        return $this->permissions;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Name',
            'Description',
            'Module',
            'Created At',
            'Updated At',
        ];
    }

    public function map($permission): array
    {
        return [
            $permission->id ?? 'N/A',
            $permission->name ?? 'N/A',
            $permission->description ?? 'N/A',
            $permission->module ?? 'N/A',
            $permission->created_at->format('Y-m-d H:i:s'),
            $permission->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    public function title(): string
    {
        return 'Permissions Export';
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
                $sheet->mergeCells('A1:F1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                
                // Add subtitle
                $sheet->setCellValue('A2', 'Permissions Export Report');
                $sheet->mergeCells('A2:F2');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                
                // Add export date
                $sheet->setCellValue('A3', 'Exported on: ' . now()->format('F j, Y \a\t g:i A'));
                $sheet->mergeCells('A3:F3');
                $sheet->getStyle('A3')->getFont()->setSize(12);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
                
                // Add empty row
                $sheet->insertNewRowBefore(5, 1);
                
                // Style the headers (now in row 5)
                $headerRange = 'A5:F5';
                $sheet->getStyle($headerRange)->getFont()->setBold(true);
                $sheet->getStyle($headerRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('3B82F6');
                $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal('center');
                
                // Auto-fit columns
                foreach (range('A', 'F') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}