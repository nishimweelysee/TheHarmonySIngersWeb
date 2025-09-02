<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Plan::query();

        // Filter by year
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', strtolower($request->status));
        }

        // Filter by quarter
        if ($request->filled('quarter')) {
            $query->where('quarter', $request->quarter);
        }

        // Search by title or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $plans = $query->orderBy('year', 'desc')->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'period_type' => 'required|in:yearly,quarterly,monthly',
            'year' => 'required|integer|min:2020|max:2030',
            'quarter' => 'nullable|in:Q1,Q2,Q3,Q4',
            'month' => 'nullable|string|size:2',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'category' => 'nullable|in:performance,training,fundraising,community,administration',
            'status' => 'required|in:planned,in_progress,completed,cancelled',
            'estimated_budget' => 'nullable|numeric|min:0',
            'budget' => 'nullable|string',
            'objectives' => 'nullable|string',
            'activities' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Plan::create($validated);

        return redirect()->route('admin.plans.index')->with('success', 'Year plan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        return view('admin.plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'period_type' => 'required|in:yearly,quarterly,monthly',
            'year' => 'required|integer|min:2020|max:2030',
            'quarter' => 'nullable|in:Q1,Q2,Q3,Q4',
            'month' => 'nullable|string|size:2',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'category' => 'nullable|in:performance,training,fundraising,community,administration',
            'status' => 'required|in:planned,in_progress,completed,cancelled',
            'estimated_budget' => 'nullable|numeric|min:0',
            'budget' => 'nullable|string',
            'objectives' => 'nullable|string',
            'activities' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $plan->update($validated);

        return redirect()->route('admin.plans.index')->with('success', 'Year plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Year plan deleted successfully.');
    }
}
