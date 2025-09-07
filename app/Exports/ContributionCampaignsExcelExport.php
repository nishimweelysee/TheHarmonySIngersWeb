<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContributionCampaignsExcelExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    protected $contributioncampaigns;

    public function __construct($contributioncampaigns)
    {
        $this->contributioncampaigns = $contributioncampaigns;
    }

    public function collection()
    {
        return $this->contributioncampaigns;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Title',
            'Description',
            'Target Amount',
            'Current Amount',
            'Min Amount Per Person',
            'Start Date',
            'End Date',
            'Status',
            'Created At',
            'Updated At',
        ];
    }

    public function map($contributioncampaign): array
    {
        return [
            $contributioncampaign->id ?? 'N/A',
            $contributioncampaign->title ?? 'N/A',
            $contributioncampaign->description ?? 'N/A',
            $contributioncampaign->target_amount ?? 'N/A',
            $contributioncampaign->current_amount ?? 'N/A',
            $contributioncampaign->min_amount_per_person ?? 'N/A',
            $contributioncampaign->start_date ?? 'N/A',
            $contributioncampaign->end_date ?? 'N/A',
            $contributioncampaign->status ?? 'N/A',
            $contributioncampaign->created_at->format('Y-m-d H:i:s'),
            $contributioncampaign->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    public function title(): string
    {
        return 'ContributionCampaigns Export';
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
                $sheet->mergeCells('A1:K1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // Add subtitle
                $sheet->setCellValue('A2', 'ContributionCampaigns Export Report');
                $sheet->mergeCells('A2:K2');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                // Add export date
                $sheet->setCellValue('A3', 'Exported on: ' . now()->format('F j, Y \a\t g:i A'));
                $sheet->mergeCells('A3:K3');
                $sheet->getStyle('A3')->getFont()->setSize(12);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');

                // Add empty row
                $sheet->insertNewRowBefore(5, 1);

                // Style the headers (now in row 5)
                $headerRange = 'A5:K5';
                $sheet->getStyle($headerRange)->getFont()->setBold(true);
                $sheet->getStyle($headerRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('3B82F6');
                $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal('center');

                // Auto-fit columns
                foreach (range('A', 'K') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
