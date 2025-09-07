<?php

namespace App\Services;

use App\Models\ContributionCampaign;
use App\Exports\ContributionCampaignsExcelExport;
use App\Exports\ContributorsExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ContributionCampaignExportService
{
    /**
     * Export contributioncampaigns to Excel
     */
    public function exportToExcel(Request $request)
    {
        $contributioncampaigns = $this->getFilteredContributionCampaigns($request);

        return Excel::download(new ContributionCampaignsExcelExport($contributioncampaigns), 'contributioncampaigns_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export contributioncampaigns to PDF
     */
    public function exportToPdf(Request $request)
    {
        $contributioncampaigns = $this->getFilteredContributionCampaigns($request);

        $pdf = Pdf::loadView('admin.contribution-campaigns.exports.pdf', [
            'contributionCampaigns' => $contributioncampaigns,
            'exportDate' => now(),
            'filters' => $this->getAppliedFilters($request)
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('contributioncampaigns_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered contributioncampaigns based on request parameters
     */
    private function getFilteredContributionCampaigns(Request $request)
    {
        $query = ContributionCampaign::query();

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

    /**
     * Export contributors to Excel
     */
    public function exportContributorsToExcel(ContributionCampaign $contributionCampaign)
    {
        $contributors = $contributionCampaign->individualContributions()->orderBy('contribution_date', 'desc')->get();

        return Excel::download(new ContributorsExcelExport($contributors, $contributionCampaign), 'contributors_' . $contributionCampaign->name . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export contributors to PDF
     */
    public function exportContributorsToPdf(ContributionCampaign $contributionCampaign)
    {
        $contributors = $contributionCampaign->individualContributions()->orderBy('contribution_date', 'desc')->get();

        $pdf = Pdf::loadView('admin.contribution-campaigns.exports.contributors-pdf', [
            'contributors' => $contributors,
            'contributionCampaign' => $contributionCampaign,
            'exportDate' => now()
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('contributors_' . $contributionCampaign->name . '_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
