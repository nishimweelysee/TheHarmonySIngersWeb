<?php

namespace App\Services;

use App\Models\Album;
use App\Exports\AlbumsExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AlbumExportService
{
    /**
     * Export albums to Excel
     */
    public function exportToExcel(Request $request)
    {
        $albums = $this->getFilteredAlbums($request);
        
        return Excel::download(new AlbumsExcelExport($albums), 'albums_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export albums to PDF
     */
    public function exportToPdf(Request $request)
    {
        $albums = $this->getFilteredAlbums($request);
        
        $pdf = Pdf::loadView('admin.albums.exports.pdf', [
            'albums' => $albums,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('albums_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered albums based on request parameters
     */
    private function getFilteredAlbums(Request $request)
    {
        $query = Album::query();

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