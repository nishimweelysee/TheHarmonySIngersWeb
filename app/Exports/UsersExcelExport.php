<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExcelExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Role',
            'Status',
            'Email Verified',
            'Created At',
            'Updated At'
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name ?? 'N/A',
            $user->email ?? 'N/A',
            $user->role ? $user->role->name : 'N/A',
            ucfirst($user->status ?? 'N/A'),
            $user->email_verified_at ? 'Yes' : 'No',
            $user->created_at->format('Y-m-d H:i:s'),
            $user->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    public function title(): string
    {
        return 'Users Export';
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
                $sheet->mergeCells('A1:H1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // Add subtitle
                $sheet->setCellValue('A2', 'Users Export Report');
                $sheet->mergeCells('A2:H2');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                // Add export date
                $sheet->setCellValue('A3', 'Exported on: ' . now()->format('F j, Y \a\t g:i A'));
                $sheet->mergeCells('A3:H3');
                $sheet->getStyle('A3')->getFont()->setSize(12);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');

                // Add empty row
                $sheet->insertNewRowBefore(5, 1);

                // Style the headers (now in row 5)
                $headerRange = 'A5:H5';
                $sheet->getStyle($headerRange)->getFont()->setBold(true);
                $sheet->getStyle($headerRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('3B82F6');
                $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal('center');

                // Auto-fit columns
                foreach (range('A', 'H') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
