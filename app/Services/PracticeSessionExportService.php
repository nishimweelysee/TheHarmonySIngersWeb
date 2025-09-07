<?php

namespace App\Services;

use App\Models\PracticeSession;
use App\Exports\PracticeSessionsExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PracticeSessionExportService
{
    /**
     * Export practicesessions to Excel
     */
    public function exportToExcel(Request $request)
    {
        $practicesessions = $this->getFilteredPracticeSessions($request);
        
        return Excel::download(new PracticeSessionsExcelExport($practicesessions), 'practicesessions_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export practicesessions to PDF
     */
    public function exportToPdf(Request $request)
    {
        $practicesessions = $this->getFilteredPracticeSessions($request);
        
        $pdf = Pdf::loadView('admin.practice-sessions.exports.pdf', [
            'practicesessions' => $practicesessions,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('practicesessions_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered practicesessions based on request parameters
     */
    private function getFilteredPracticeSessions(Request $request)
    {
        $query = PracticeSession::query();

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