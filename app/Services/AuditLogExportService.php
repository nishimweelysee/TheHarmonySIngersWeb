<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Exports\AuditLogsExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AuditLogExportService
{
    /**
     * Export auditlogs to Excel
     */
    public function exportToExcel(Request $request)
    {
        $auditlogs = $this->getFilteredAuditLogs($request);

        return Excel::download(new AuditLogsExcelExport($auditlogs), 'auditlogs_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export auditlogs to PDF
     */
    public function exportToPdf(Request $request)
    {
        $auditlogs = $this->getFilteredAuditLogs($request);

        $pdf = Pdf::loadView('admin.audit-logs.exports.pdf', [
            'auditLogs' => $auditlogs,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('auditlogs_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }


    /**
     * Get filtered auditlogs based on request parameters
     */
    private function getFilteredAuditLogs(Request $request)
    {
        $query = AuditLog::query()->with(['user']);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('event', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by event type
        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by auditable type
        if ($request->filled('auditable_type')) {
            $query->where('auditable_type', $request->auditable_type);
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

        if ($request->filled('event')) {
            $filters['Event'] = $request->event;
        }

        if ($request->filled('user_id')) {
            $user = \App\Models\User::find($request->user_id);
            $filters['User'] = $user ? $user->name : 'Unknown';
        }

        if ($request->filled('auditable_type')) {
            $filters['Model Type'] = class_basename($request->auditable_type);
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
