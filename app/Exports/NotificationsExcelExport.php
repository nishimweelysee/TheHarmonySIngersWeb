<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NotificationsExcelExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    protected $notifications;

    public function __construct($notifications)
    {
        $this->notifications = $notifications;
    }

    public function collection()
    {
        return $this->notifications;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Message',
            'Type',
            'Status',
            'Recipient',
            'Recipient Type',
            'Sent At',
            'Read At',
        ];
    }

    public function map($notification): array
    {
        return [
            $notification->id ?? 'N/A',
            $notification->title ?? 'N/A',
            $notification->message ?? 'N/A',
            $notification->type ?? 'N/A',
            ucfirst($notification->status ?? 'N/A'),
            $notification->notifiable ? $notification->notifiable->name ?? $notification->notifiable->email : 'N/A',
            $notification->notifiable_type ? class_basename($notification->notifiable_type) : 'N/A',
            $notification->created_at->format('M j, Y H:i:s'),
            $notification->read_at ? $notification->read_at->format('M j, Y H:i:s') : 'Not Read',
        ];
    }

    public function title(): string
    {
        return 'Notifications Export';
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
                $sheet->setCellValue('A2', 'Notifications Export Report');
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
