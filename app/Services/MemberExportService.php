<?php

namespace App\Services;

use App\Models\Member;
use App\Exports\MembersExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MemberExportService
{
    /**
     * Export members to Excel
     */
    public function exportToExcel(Request $request)
    {
        $members = $this->getFilteredMembers($request);

        return Excel::download(new MembersExcelExport($members), 'members_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export members to PDF
     */
    public function exportToPdf(Request $request)
    {
        $members = $this->getFilteredMembers($request);

        $pdf = Pdf::loadView('admin.members.exports.pdf', [
            'members' => $members,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('members_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered members based on request parameters
     */
    private function getFilteredMembers(Request $request)
    {
        $query = Member::query();

        // Apply the same filters as the index method
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('voice_part')) {
            $query->where('voice_part', $request->voice_part);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('joined_from')) {
            $query->whereDate('joined_date', '>=', $request->joined_from);
        }

        if ($request->filled('joined_to')) {
            $query->whereDate('joined_date', '<=', $request->joined_to);
        }

        return $query->orderBy('last_name', 'asc')->orderBy('first_name', 'asc')->get();
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

        if ($request->filled('type')) {
            $filters['Type'] = ucfirst($request->type);
        }

        if ($request->filled('voice_part')) {
            $filters['Voice Part'] = ucfirst($request->voice_part);
        }

        if ($request->filled('status')) {
            $filters['Status'] = ucfirst($request->status);
        }

        if ($request->filled('joined_from')) {
            $filters['Joined From'] = $request->joined_from;
        }

        if ($request->filled('joined_to')) {
            $filters['Joined To'] = $request->joined_to;
        }

        return $filters;
    }
}
