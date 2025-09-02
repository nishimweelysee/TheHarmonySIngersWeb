<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContributionCampaign;
use App\Models\IndividualContribution;
use App\Models\Plan;
use Illuminate\Http\Request;

class ContributionCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ContributionCampaign::with(['yearPlan', 'individualContributions']);

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', strtolower($request->type));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', strtolower($request->status));
        }

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $campaigns = $query->latest()->paginate(20)->withQueryString();

        // Update current amounts for all campaigns
        foreach ($campaigns as $campaign) {
            $campaign->updateCurrentAmount();
        }

        return view('admin.contribution-campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $yearPlans = Plan::currentYear()->orderBy('quarter')->get();
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
            'type' => 'required|in:monthly,project,event,special',
            'year_plan_id' => 'nullable|exists:plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'target_amount' => 'nullable|numeric|min:0.01',
            'min_amount_per_person' => 'nullable|numeric|min:0.01',
            'currency' => 'nullable|string|max:3',
            'campaign_notes' => 'nullable|string',
        ]);

        // Set default currency if not provided
        if (empty($validated['currency'])) {
            $validated['currency'] = 'RWF';
        }

        $validated['current_amount'] = 0;
        $validated['status'] = 'active';

        ContributionCampaign::create($validated);

        return redirect()->route('admin.contribution-campaigns.index')
            ->with('success', 'Contribution campaign created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContributionCampaign $contributionCampaign)
    {
        // Update current amount before displaying
        $contributionCampaign->updateCurrentAmount();

        $contributionCampaign->load(['yearPlan', 'individualContributions' => function ($query) {
            $query->latest();
        }]);

        return view('admin.contribution-campaigns.show', compact('contributionCampaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContributionCampaign $contributionCampaign)
    {
        $yearPlans = Plan::currentYear()->orderBy('quarter')->get();
        return view('admin.contribution-campaigns.edit', compact('contributionCampaign', 'yearPlans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContributionCampaign $contributionCampaign)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:monthly,project,event,special',
            'year_plan_id' => 'nullable|exists:plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'target_amount' => 'nullable|numeric|min:0.01',
            'min_amount_per_person' => 'nullable|numeric|min:0.01',
            'currency' => 'nullable|string|max:3',
            'status' => 'required|in:active,completed,cancelled',
            'campaign_notes' => 'nullable|string',
        ]);

        $contributionCampaign->update($validated);

        return redirect()->route('admin.contribution-campaigns.index')
            ->with('success', 'Contribution campaign updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContributionCampaign $contributionCampaign)
    {
        // Check if campaign has contributions
        if ($contributionCampaign->individualContributions()->count() > 0) {
            return redirect()->route('admin.contribution-campaigns.index')
                ->with('error', 'Cannot delete campaign with existing contributions. Please delete contributions first.');
        }

        $contributionCampaign->delete();

        return redirect()->route('admin.contribution-campaigns.index')
            ->with('success', 'Contribution campaign deleted successfully.');
    }

    /**
     * Show the form for adding a new contribution
     */
    public function showAddContributionForm(ContributionCampaign $contributionCampaign)
    {
        $members = \App\Models\Member::orderBy('first_name')->orderBy('last_name')->get();
        return view('admin.contribution-campaigns.add-contribution', compact('contributionCampaign', 'members'));
    }

    /**
     * Add individual contribution to campaign
     */
    public function addContribution(Request $request, ContributionCampaign $contributionCampaign)
    {
        $validated = $request->validate([
            'contributor_name' => 'required|string|max:255',
            'contributor_email' => 'nullable|email|max:255',
            'contributor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'nullable|string|max:3',
            'contribution_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,check,mobile_money,other',
            'reference_number' => 'nullable|string|max:255',
            'status' => 'required|in:pending,confirmed,completed',
            'notes' => 'nullable|string',
        ]);

        $validated['campaign_id'] = $contributionCampaign->id;
        $validated['currency'] = $validated['currency'] ?? $contributionCampaign->currency;

        // Check if contribution meets minimum amount
        if (!$contributionCampaign->meetsMinimumAmount($validated['amount'])) {
            return back()->withErrors([
                'amount' => "Contribution amount must be at least {$contributionCampaign->minimum_amount_formatted} for this campaign."
            ])->withInput();
        }

        IndividualContribution::create($validated);

        // Update campaign current amount
        $contributionCampaign->updateCurrentAmount();

        return redirect()->route('admin.contribution-campaigns.show', $contributionCampaign)
            ->with('success', 'Contribution added successfully.');
    }

    /**
     * Show the form for editing an individual contribution
     */
    public function editContribution(ContributionCampaign $contributionCampaign, IndividualContribution $contribution)
    {
        if ($contribution->campaign_id !== $contributionCampaign->id) {
            abort(404);
        }

        $members = \App\Models\Member::orderBy('first_name')->orderBy('last_name')->get();
        return view('admin.contribution-campaigns.edit-contribution', compact('contributionCampaign', 'contribution', 'members'));
    }

    /**
     * Update an individual contribution
     */
    public function updateContribution(Request $request, ContributionCampaign $contributionCampaign, IndividualContribution $contribution)
    {
        if ($contribution->campaign_id !== $contributionCampaign->id) {
            abort(404);
        }

        $validated = $request->validate([
            'contributor_name' => 'required|string|max:255',
            'contributor_email' => 'nullable|email|max:255',
            'contributor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'nullable|string|max:3',
            'contribution_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,check,mobile_money,other',
            'reference_number' => 'nullable|string|max:255',
            'status' => 'required|in:pending,confirmed,completed',
            'notes' => 'nullable|string',
        ]);

        $validated['currency'] = $validated['currency'] ?? $contributionCampaign->currency;

        // Check if contribution meets minimum amount
        if (!$contributionCampaign->meetsMinimumAmount($validated['amount'])) {
            return back()->withErrors([
                'amount' => "Contribution amount must be at least {$contributionCampaign->minimum_amount_formatted} for this campaign."
            ])->withInput();
        }

        $contribution->update($validated);

        // Update campaign current amount
        $contributionCampaign->updateCurrentAmount();

        return redirect()->route('admin.contribution-campaigns.show', $contributionCampaign)
            ->with('success', 'Contribution updated successfully.');
    }

    /**
     * Remove individual contribution from campaign
     */
    public function removeContribution(ContributionCampaign $contributionCampaign, IndividualContribution $contribution)
    {
        if ($contribution->campaign_id !== $contributionCampaign->id) {
            abort(404);
        }

        $contribution->delete();

        // Update campaign current amount
        $contributionCampaign->updateCurrentAmount();

        return redirect()->route('admin.contribution-campaigns.show', $contributionCampaign)
            ->with('success', 'Contribution removed successfully.');
    }
}
