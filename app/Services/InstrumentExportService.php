<?php

namespace App\Services;

use App\Models\Instrument;
use App\Exports\InstrumentsExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InstrumentExportService
{
    /**
     * Export instruments to Excel
     */
    public function exportToExcel(Request $request)
    {
        $instruments = $this->getFilteredInstruments($request);
        
        return Excel::download(new InstrumentsExcelExport($instruments), 'instruments_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export instruments to PDF
     */
    public function exportToPdf(Request $request)
    {
        $instruments = $this->getFilteredInstruments($request);
        
        $pdf = Pdf::loadView('admin.instruments.exports.pdf', [
            'instruments' => $instruments,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('instruments_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered instruments based on request parameters
     */
    private function getFilteredInstruments(Request $request)
    {
        $query = Instrument::query();

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