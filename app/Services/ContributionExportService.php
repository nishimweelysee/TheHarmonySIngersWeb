<?php

namespace App\Services;

use App\Models\Contribution;
use App\Exports\ContributionsExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ContributionExportService
{
    /**
     * Export contributions to Excel
     */
    public function exportToExcel(Request $request)
    {
        $contributions = $this->getFilteredContributions($request);
        
        return Excel::download(new ContributionsExcelExport($contributions), 'contributions_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export contributions to PDF
     */
    public function exportToPdf(Request $request)
    {
        $contributions = $this->getFilteredContributions($request);
        
        $pdf = Pdf::loadView('admin.contributions.exports.pdf', [
            'contributions' => $contributions,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('contributions_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered contributions based on request parameters
     */
    private function getFilteredContributions(Request $request)
    {
        $query = Contribution::query();

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