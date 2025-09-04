<?php

namespace App\Services;

use App\Models\Song;
use App\Exports\SongsExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SongExportService
{
    /**
     * Export songs to Excel
     */
    public function exportToExcel(Request $request)
    {
        $songs = $this->getFilteredSongs($request);

        return Excel::download(new SongsExcelExport($songs), 'songs_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export songs to PDF
     */
    public function exportToPdf(Request $request)
    {
        $songs = $this->getFilteredSongs($request);

        $pdf = Pdf::loadView('admin.songs.exports.pdf', [
            'songs' => $songs,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('songs_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered songs based on request parameters
     */
    private function getFilteredSongs(Request $request)
    {
        $query = Song::query();

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
