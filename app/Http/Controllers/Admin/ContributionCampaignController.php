<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContributionCampaign;
use App\Services\ContributionCampaignExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContributionCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ContributionCampaign::query()->with(["yearPlan", "individualContributions"]);

        // Apply filters based on request
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $perPage = $request->get('per_page', 10);
        $contributionCampaigns = $query->paginate($perPage);

        return view('admin.contribution-campaigns.index', compact('contributionCampaigns'));
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        $exportService = new ContributionCampaignExportService();
        return $exportService->exportToExcel($request);
    }

    /**
     * Export to PDF
     */
    public function exportPdf(Request $request)
    {
        $exportService = new ContributionCampaignExportService();
        return $exportService->exportToPdf($request);
    }

    /**
     * Export contributors to Excel
     */
    public function exportContributorsExcel(ContributionCampaign $contributionCampaign)
    {
        $exportService = new ContributionCampaignExportService();
        return $exportService->exportContributorsToExcel($contributionCampaign);
    }

    /**
     * Export contributors to PDF
     */
    public function exportContributorsPdf(ContributionCampaign $contributionCampaign)
    {
        $exportService = new ContributionCampaignExportService();
        return $exportService->exportContributorsToPdf($contributionCampaign);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $yearPlans = \App\Models\Plan::all();
        return view('admin.contribution-campaigns.create', compact('yearPlans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year_plan_id' => 'required|exists:plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'target_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,inactive,completed',
        ]);

        $contributionCampaign = ContributionCampaign::create($validated);

        return redirect()->route('admin.contribution-campaigns.show', $contributionCampaign)
            ->with('success', 'Contribution campaign created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContributionCampaign $contributionCampaign)
    {
        $contributionCampaign->load(['yearPlan', 'individualContributions']);
        return view('admin.contribution-campaigns.show', compact('contributionCampaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContributionCampaign $contributionCampaign)
    {
        return view('admin.contribution-campaigns.edit', compact('contributionCampaign'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContributionCampaign $contributionCampaign)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year_plan_id' => 'required|exists:plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'target_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,inactive,completed',
        ]);

        $contributionCampaign->update($validated);

        return redirect()->route('admin.contribution-campaigns.show', $contributionCampaign)
            ->with('success', 'Contribution campaign updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContributionCampaign $contributionCampaign)
    {
        $contributionCampaign->delete();

        return redirect()->route('admin.contribution-campaigns.index')
            ->with('success', 'Contribution campaign deleted successfully.');
    }

    /**
     * Show the form for adding a contribution to the campaign.
     */
    public function showAddContributionForm(ContributionCampaign $contributionCampaign)
    {
        $contributionCampaign->load(['yearPlan']);
        $members = \App\Models\Member::active()->get();
        return view('admin.contribution-campaigns.add-contribution', compact('contributionCampaign', 'members'));
    }

    /**
     * Add a contribution to the campaign.
     */
    public function addContribution(Request $request, ContributionCampaign $contributionCampaign)
    {
        $validated = $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'contributor_name' => 'required|string|max:255',
            'contributor_email' => 'nullable|email|max:255',
            'contributor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|in:RWF,USD,EUR,GBP,CAD,AUD',
            'contribution_date' => 'required|date',
            'payment_method' => 'required|string|in:cash,bank_transfer,check,mobile_money,other',
            'reference_number' => 'nullable|string|max:255',
            'status' => 'required|string|in:pending,confirmed,completed',
            'notes' => 'nullable|string',
        ]);

        // If member_id is provided, get member details
        if ($validated['member_id']) {
            $member = \App\Models\Member::find($validated['member_id']);
            $validated['contributor_name'] = $member->full_name;
            $validated['contributor_email'] = $member->email;
            $validated['contributor_phone'] = $member->phone;
        }

        // Remove member_id from the data to be saved (it's not in the database schema)
        unset($validated['member_id']);

        $contribution = $contributionCampaign->individualContributions()->create($validated);

        // Send notification if contribution is added with confirmed or completed status
        if (($validated['status'] === 'confirmed' || $validated['status'] === 'completed') &&
            $contribution->contributor_email
        ) {

            // Send notification using route method for email
            Notification::route('mail', $contribution->contributor_email)
                ->notify(new \App\Notifications\ContributionConfirmedNotification($contribution, $contributionCampaign));
        }

        return redirect()->route('admin.contribution-campaigns.show', $contributionCampaign)
            ->with('success', 'Contribution added successfully.');
    }

    /**
     * Show the form for editing a contribution.
     */
    public function editContribution(ContributionCampaign $contributionCampaign, $contribution)
    {
        $contribution = $contributionCampaign->individualContributions()->findOrFail($contribution);
        $members = \App\Models\Member::active()->get();
        return view('admin.contribution-campaigns.edit-contribution', compact('contributionCampaign', 'contribution', 'members'));
    }

    /**
     * Update a contribution.
     */
    public function updateContribution(Request $request, ContributionCampaign $contributionCampaign, $contribution)
    {
        $contribution = $contributionCampaign->individualContributions()->findOrFail($contribution);

        $validated = $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'contributor_name' => 'required|string|max:255',
            'contributor_email' => 'nullable|email|max:255',
            'contributor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|in:RWF,USD,EUR,GBP,CAD,AUD',
            'contribution_date' => 'required|date',
            'payment_method' => 'required|string|in:cash,bank_transfer,check,mobile_money,other',
            'reference_number' => 'nullable|string|max:255',
            'status' => 'required|string|in:pending,confirmed,completed',
            'notes' => 'nullable|string',
        ]);

        // If member_id is provided, get member details
        if ($validated['member_id']) {
            $member = \App\Models\Member::find($validated['member_id']);
            $validated['contributor_name'] = $member->full_name;
            $validated['contributor_email'] = $member->email;
            $validated['contributor_phone'] = $member->phone;
        }

        // Remove member_id from the data to be saved (it's not in the database schema)
        unset($validated['member_id']);

        // Store the old status to check if we need to send notification
        $oldStatus = $contribution->status;
        $newStatus = $validated['status'];

        $contribution->update($validated);

        // Send notification if status changed to confirmed or completed
        if (($newStatus === 'confirmed' || $newStatus === 'completed') &&
            $oldStatus !== $newStatus &&
            $contribution->contributor_email
        ) {

            // Send notification using route method for email
            Notification::route('mail', $contribution->contributor_email)
                ->notify(new \App\Notifications\ContributionConfirmedNotification($contribution, $contributionCampaign));
        }

        return redirect()->route('admin.contribution-campaigns.show', $contributionCampaign)
            ->with('success', 'Contribution updated successfully.');
    }

    /**
     * Remove a contribution from the campaign.
     */
    public function removeContribution(ContributionCampaign $contributionCampaign, $contribution)
    {
        $contribution = $contributionCampaign->individualContributions()->findOrFail($contribution);
        $contribution->delete();

        return redirect()->route('admin.contribution-campaigns.show', $contributionCampaign)
            ->with('success', 'Contribution removed successfully.');
    }
}
