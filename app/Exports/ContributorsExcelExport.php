<?php

namespace App\Exports;

use App\Models\ContributionCampaign;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ContributorsExcelExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    protected $contributors;
    protected $contributionCampaign;

    public function __construct($contributors, ContributionCampaign $contributionCampaign)
    {
        $this->contributors = $contributors;
        $this->contributionCampaign = $contributionCampaign;
    }

    public function collection()
    {
        return $this->contributors;
    }

    public function headings(): array
    {
        return [
            'Contributor Name',
            'Email',
            'Phone',
            'Amount',
            'Currency',
            'Contribution Date',
            'Payment Method',
            'Reference Number',
            'Status',
            'Notes'
        ];
    }

    public function map($contributor): array
    {
        return [
            $contributor->contributor_name,
            $contributor->contributor_email,
            $contributor->contributor_phone,
            $contributor->amount,
            $contributor->currency,
            $contributor->contribution_date->format('Y-m-d'),
            ucwords(str_replace('_', ' ', $contributor->payment_method)),
            $contributor->reference_number,
            ucfirst($contributor->status),
            $contributor->notes
        ];
    }

    public function title(): string
    {
        return 'Contributors - ' . $this->contributionCampaign->name;
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
                $sheet->mergeCells('A1:J1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // Add subtitle
                $sheet->setCellValue('A2', 'Contributors Export Report - ' . $this->contributionCampaign->name);
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
                    ->getStartColor()->setRGB('2E86AB');
                $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal('center');

                // Auto-size columns
                foreach (range('A', 'J') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            }
        ];
    }
}
