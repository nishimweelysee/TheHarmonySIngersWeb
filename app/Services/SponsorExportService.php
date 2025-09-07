<?php

namespace App\Services;

use App\Models\Sponsor;
use App\Exports\SponsorsExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SponsorExportService
{
    /**
     * Export sponsors to Excel
     */
    public function exportToExcel(Request $request)
    {
        $sponsors = $this->getFilteredSponsors($request);
        
        return Excel::download(new SponsorsExcelExport($sponsors), 'sponsors_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export sponsors to PDF
     */
    public function exportToPdf(Request $request)
    {
        $sponsors = $this->getFilteredSponsors($request);
        
        $pdf = Pdf::loadView('admin.sponsors.exports.pdf', [
            'sponsors' => $sponsors,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('sponsors_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered sponsors based on request parameters
     */
    private function getFilteredSponsors(Request $request)
    {
        $query = Sponsor::query();

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