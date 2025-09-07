<?php

namespace App\Services;

use App\Models\Plan;
use App\Exports\PlansExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PlanExportService
{
    /**
     * Export plans to Excel
     */
    public function exportToExcel(Request $request)
    {
        $plans = $this->getFilteredPlans($request);
        
        return Excel::download(new PlansExcelExport($plans), 'plans_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export plans to PDF
     */
    public function exportToPdf(Request $request)
    {
        $plans = $this->getFilteredPlans($request);
        
        $pdf = Pdf::loadView('admin.plans.exports.pdf', [
            'plans' => $plans,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('plans_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered plans based on request parameters
     */
    private function getFilteredPlans(Request $request)
    {
        $query = Plan::query();

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