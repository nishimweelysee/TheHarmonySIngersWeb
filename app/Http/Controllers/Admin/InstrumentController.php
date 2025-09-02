<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instrument;
use Illuminate\Http\Request;

class InstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Instrument::query();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', strtolower($request->type));
        }

        // Filter by availability
        if ($request->filled('availability')) {
            if ($request->availability === 'Available') {
                $query->where('is_available', true);
            } elseif ($request->availability === 'Not Available') {
                $query->where('is_available', false);
            }
        }

        // Filter by condition
        if ($request->filled('condition')) {
            $query->where('condition', strtolower($request->condition));
        }

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $instruments = $query->orderBy('name', 'asc')->paginate(20)->withQueryString();

        return view('admin.instruments.index', compact('instruments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.instruments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'is_available' => 'boolean',
            'condition' => 'nullable|in:excellent,good,fair,poor',
            'notes' => 'nullable|string',
        ]);

        Instrument::create($validated);

        return redirect()->route('admin.instruments.index')->with('success', 'Instrument created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Instrument $instrument)
    {
        return view('admin.instruments.show', compact('instrument'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instrument $instrument)
    {
        return view('admin.instruments.edit', compact('instrument'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instrument $instrument)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'is_available' => 'boolean',
            'condition' => 'nullable|in:excellent,good,fair,poor',
            'notes' => 'nullable|string',
        ]);

        $instrument->update($validated);

        return redirect()->route('admin.instruments.index')->with('success', 'Instrument updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instrument $instrument)
    {
        $instrument->delete();

        return redirect()->route('admin.instruments.index')->with('success', 'Instrument deleted successfully.');
    }
}
