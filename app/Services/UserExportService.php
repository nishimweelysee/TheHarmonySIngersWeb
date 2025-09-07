<?php

namespace App\Services;

use App\Models\User;
use App\Exports\UsersExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class UserExportService
{
    /**
     * Export users to Excel
     */
    public function exportToExcel(Request $request)
    {
        $users = $this->getFilteredUsers($request);

        return Excel::download(new UsersExcelExport($users), 'users_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export users to PDF
     */
    public function exportToPdf(Request $request)
    {
        $users = $this->getFilteredUsers($request);

        $pdf = Pdf::loadView('admin.users.exports.pdf', [
            'users' => $users,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('users_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered users based on request parameters
     */
    private function getFilteredUsers(Request $request)
    {
        $query = User::with('role');

        // Apply the same filters as the index method
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->orderBy('name', 'asc')->get();
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

        if ($request->filled('role')) {
            $filters['Role'] = ucfirst($request->role);
        }

        if ($request->filled('status')) {
            $filters['Status'] = ucfirst($request->status);
        }

        return $filters;
    }
}
