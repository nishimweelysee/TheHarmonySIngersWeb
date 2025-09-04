<?php

namespace App\Services;

use App\Models\Concert;
use App\Exports\ConcertsExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ConcertExportService
{
    /**
     * Export concerts to Excel
     */
    public function exportToExcel(Request $request)
    {
        $concerts = $this->getFilteredConcerts($request);
        
        return Excel::download(new ConcertsExcelExport($concerts), 'concerts_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export concerts to PDF
     */
    public function exportToPdf(Request $request)
    {
        $concerts = $this->getFilteredConcerts($request);
        
        $pdf = Pdf::loadView('admin.concerts.exports.pdf', [
            'concerts' => $concerts,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('concerts_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered concerts based on request parameters
     */
    private function getFilteredConcerts(Request $request)
    {
        $query = Concert::query();

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