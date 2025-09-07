<?php

namespace App\Services;

use App\Models\Permission;
use App\Exports\PermissionsExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PermissionExportService
{
    /**
     * Export permissions to Excel
     */
    public function exportToExcel(Request $request)
    {
        $permissions = $this->getFilteredPermissions($request);
        
        return Excel::download(new PermissionsExcelExport($permissions), 'permissions_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export permissions to PDF
     */
    public function exportToPdf(Request $request)
    {
        $permissions = $this->getFilteredPermissions($request);
        
        $pdf = Pdf::loadView('admin.permissions.exports.pdf', [
            'permissions' => $permissions,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('permissions_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered permissions based on request parameters
     */
    private function getFilteredPermissions(Request $request)
    {
        $query = Permission::query();

        // Apply basic search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
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

        return $filters;
    }
}