<?php

namespace App\Services;

use App\Models\Notification;
use App\Exports\NotificationsExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class NotificationExportService
{
    /**
     * Export notifications to Excel
     */
    public function exportToExcel(Request $request)
    {
        $notifications = $this->getFilteredNotifications($request);

        return Excel::download(new NotificationsExcelExport($notifications), 'notifications_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export notifications to PDF
     */
    public function exportToPdf(Request $request)
    {
        $notifications = $this->getFilteredNotifications($request);

        $pdf = Pdf::loadView('admin.notifications.exports.pdf', [
            'notifications' => $notifications,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('notifications_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered notifications based on request parameters
     */
    private function getFilteredNotifications(Request $request)
    {
        $query = Notification::query()->with(['notifiable']);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get applied filters for display in exports
     */
    private function getAppliedFilters(Request $request)
    {
        $filters = [];

        if ($request->filled('search')) {
            $filters['Search'] = $request->search;
        }

        if ($request->filled('status')) {
            $filters['Status'] = $request->status;
        }

        if ($request->filled('type')) {
            $filters['Type'] = $request->type;
        }

        if ($request->filled('date_from')) {
            $filters['Date From'] = $request->date_from;
        }

        if ($request->filled('date_to')) {
            $filters['Date To'] = $request->date_to;
        }

        return $filters;
    }
}
