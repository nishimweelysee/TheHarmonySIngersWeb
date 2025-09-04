<?php

namespace App\Services;

use App\Models\Media;
use App\Exports\MediasExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MediaExportService
{
    /**
     * Export medias to Excel
     */
    public function exportToExcel(Request $request)
    {
        $medias = $this->getFilteredMedias($request);
        
        return Excel::download(new MediasExcelExport($medias), 'medias_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export medias to PDF
     */
    public function exportToPdf(Request $request)
    {
        $medias = $this->getFilteredMedias($request);
        
        $pdf = Pdf::loadView('admin.media.exports.pdf', [
            'medias' => $medias,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('medias_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered medias based on request parameters
     */
    private function getFilteredMedias(Request $request)
    {
        $query = Media::query();

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