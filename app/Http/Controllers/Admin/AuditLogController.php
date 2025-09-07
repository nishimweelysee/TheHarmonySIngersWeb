<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Services\AuditLogExportService;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AuditLog::query()->with(["user"]);

        // Apply filters based on request
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', '%' . $search . '%')
                    ->orWhere('event', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
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

        // Get filter data
        $events = AuditLog::distinct()->pluck('event')->filter()->sort()->values();
        $users = \App\Models\User::whereHas('auditLogs')->orderBy('name')->get();
        $auditableTypes = AuditLog::distinct()->pluck('auditable_type')->filter()->sort()->values();

        $perPage = $request->get('per_page', 10);
        $auditLogs = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.audit-logs.index', compact('auditLogs', 'events', 'users', 'auditableTypes'));
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        $exportService = new AuditLogExportService();
        return $exportService->exportToExcel($request);
    }


    /**
     * Show a specific audit log
     */
    public function show(AuditLog $auditLog)
    {
        $auditLog->load(['user', 'auditable']);
        return view('admin.audit-logs.show', compact('auditLog'));
    }

    /**
     * Show audit logs for a specific model
     */
    public function forModel($modelType, $modelId)
    {
        $auditLogs = AuditLog::where('auditable_type', $modelType)
            ->where('auditable_id', $modelId)
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.audit-logs.model', compact('auditLogs', 'modelType', 'modelId'));
    }

    /**
     * Show audit logs for a specific user
     */
    public function forUser(\App\Models\User $user)
    {
        $auditLogs = $user->auditLogs()
            ->with(['auditable'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.audit-logs.user', compact('auditLogs', 'user'));
    }

    /**
     * Show audit logs statistics
     */
    public function statistics()
    {
        $stats = [
            'total_logs' => AuditLog::count(),
            'today_logs' => AuditLog::whereDate('created_at', today())->count(),
            'yesterday_logs' => AuditLog::whereDate('created_at', today()->subDay())->count(),
            'this_week_logs' => AuditLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month_logs' => AuditLog::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'user_actions' => AuditLog::whereNotNull('user_id')->count(),
            'system_actions' => AuditLog::whereNull('user_id')->count(),
            'unique_users' => AuditLog::whereNotNull('user_id')->distinct('user_id')->count(),
            'events' => AuditLog::selectRaw('event, COUNT(*) as count')
                ->groupBy('event')
                ->orderBy('count', 'desc')
                ->get(),
            'top_users' => AuditLog::selectRaw('user_id, COUNT(*) as count')
                ->whereNotNull('user_id')
                ->with('user')
                ->groupBy('user_id')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
            'hourly_activity' => AuditLog::selectRaw('strftime("%H", created_at) as hour, COUNT(*) as count')
                ->whereDate('created_at', today())
                ->groupBy('hour')
                ->orderBy('hour')
                ->get(),
            'daily_activity' => AuditLog::selectRaw('strftime("%Y-%m-%d", created_at) as date, COUNT(*) as count')
                ->whereBetween('created_at', [now()->subDays(30), now()])
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
            'most_active_models' => AuditLog::selectRaw('auditable_type, COUNT(*) as count')
                ->whereNotNull('auditable_type')
                ->groupBy('auditable_type')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
            'recent_activity' => AuditLog::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get(),
        ];

        return view('admin.audit-logs.statistics', compact('stats'));
    }

    /**
     * Export audit logs to PDF
     */
    public function exportPdf(Request $request)
    {
        $exportService = new AuditLogExportService();
        return $exportService->exportToPdf($request);
    }
}
