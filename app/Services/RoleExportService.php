<?php

namespace App\Services;

use App\Models\Role;
use App\Exports\RolesExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RoleExportService
{
    /**
     * Export roles to Excel
     */
    public function exportToExcel(Request $request)
    {
        $roles = $this->getFilteredRoles($request);
        
        return Excel::download(new RolesExcelExport($roles), 'roles_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export roles to PDF
     */
    public function exportToPdf(Request $request)
    {
        $roles = $this->getFilteredRoles($request);
        
        $pdf = Pdf::loadView('admin.roles.exports.pdf', [
            'roles' => $roles,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('roles_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered roles based on request parameters
     */
    private function getFilteredRoles(Request $request)
    {
        $query = Role::query();

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