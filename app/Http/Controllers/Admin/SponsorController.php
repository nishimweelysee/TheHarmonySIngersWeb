<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sponsor::query();

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

        $sponsors = $query->latest()->paginate(20)->withQueryString();
        return view('admin.sponsors.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sponsors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:corporate,individual,foundation,government',
            'category' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'sponsorship_level' => 'nullable|in:platinum,gold,silver,bronze,patron',
            'partnership_start_date' => 'nullable|date',
            'partnership_end_date' => 'nullable|date|after:partnership_start_date',
            'annual_contribution' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive,pending',
            'notes' => 'nullable|string',
        ]);

        Sponsor::create($validated);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sponsor $sponsor)
    {
        return view('admin.sponsors.show', compact('sponsor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sponsor $sponsor)
    {
        return view('admin.sponsors.edit', compact('sponsor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:corporate,individual,foundation,government',
            'category' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'sponsorship_level' => 'nullable|in:platinum,gold,silver,bronze,patron',
            'partnership_start_date' => 'nullable|date',
            'partnership_end_date' => 'nullable|date|after:partnership_start_date',
            'annual_contribution' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive,pending',
            'notes' => 'nullable|string',
        ]);

        $sponsor->update($validated);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsor $sponsor)
    {
        $sponsor->delete();

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor deleted successfully.');
    }
}
