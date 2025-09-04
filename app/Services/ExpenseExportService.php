<?php

namespace App\Services;

use App\Models\Expense;
use App\Exports\ExpensesExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExpenseExportService
{
    /**
     * Export expenses to Excel
     */
    public function exportToExcel(Request $request)
    {
        $expenses = $this->getFilteredExpenses($request);
        
        return Excel::download(new ExpensesExcelExport($expenses), 'expenses_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export expenses to PDF
     */
    public function exportToPdf(Request $request)
    {
        $expenses = $this->getFilteredExpenses($request);
        
        $pdf = Pdf::loadView('admin.expenses.exports.pdf', [
            'expenses' => $expenses,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('expenses_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered expenses based on request parameters
     */
    private function getFilteredExpenses(Request $request)
    {
        $query = Expense::query();

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