<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concert;
use App\Services\ConcertExportService;
use Illuminate\Http\Request;

class ConcertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Concert::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', strtolower($request->status));
        }

        // Search by title or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by venue
        if ($request->filled('venue')) {
            $query->where('venue', $request->venue);
        }

        $perPage = $request->get('per_page', 10);
        $concerts = $query->orderBy('date', 'desc')->paginate($perPage)->withQueryString();

        return view('admin.concerts.index', compact('concerts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.concerts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required|string',
            'venue' => 'required|string|max:255',
            'type' => 'required|in:regular,special,festival,competition',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'ticket_price' => 'nullable|numeric|min:0',
            'max_attendees' => 'nullable|integer|min:1',
            'is_featured' => 'boolean',
        ]);

        // Handle checkbox value - unchecked checkboxes don't get sent, so we need to explicitly set false
        $validated['is_featured'] = $request->boolean('is_featured');

        Concert::create($validated);

        return redirect()->route('admin.concerts.index')->with('success', 'Concert created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Concert $concert)
    {
        return view('admin.concerts.show', compact('concert'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Concert $concert)
    {
        return view('admin.concerts.edit', compact('concert'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Concert $concert)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required|string',
            'venue' => 'required|string|max:255',
            'type' => 'required|in:regular,special,festival,competition',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'ticket_price' => 'nullable|numeric|min:0',
            'max_attendees' => 'nullable|integer|min:1',
            'is_featured' => 'boolean',
        ]);

        // Handle checkbox value - unchecked checkboxes don't get sent, so we need to explicitly set false
        $validated['is_featured'] = $request->boolean('is_featured');

        $concert->update($validated);

        return redirect()->route('admin.concerts.index')->with('success', 'Concert updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Concert $concert)
    {
        $concert->delete();

        return redirect()->route('admin.concerts.index')->with('success', 'Concert deleted successfully.');
    }

    /**
     * Export concerts to Excel
     */
    public function exportExcel(Request $request)
    {
        $exportService = new ConcertExportService();
        return $exportService->exportToExcel($request);
    }

    /**
     * Export concerts to PDF
     */
    public function exportPdf(Request $request)
    {
        $exportService = new ConcertExportService();
        return $exportService->exportToPdf($request);
    }
}
