<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PlansExcelExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    protected $plans;

    public function __construct($plans)
    {
        $this->plans = $plans;
    }

    public function collection()
    {
        return $this->plans;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Name',
            'Description',
            'Price',
            'Duration',
            'Features',
            'Status',
            'Created At',
            'Updated At',
        ];
    }

    public function map($plan): array
    {
        return [
            $plan->id ?? 'N/A',
            $plan->name ?? 'N/A',
            $plan->description ?? 'N/A',
            $plan->price ?? 'N/A',
            $plan->duration ?? 'N/A',
            $plan->features ?? 'N/A',
            $plan->status ?? 'N/A',
            $plan->created_at->format('Y-m-d H:i:s'),
            $plan->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    public function title(): string
    {
        return 'Plans Export';
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
                $sheet->mergeCells('A1:I1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                
                // Add subtitle
                $sheet->setCellValue('A2', 'Plans Export Report');
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