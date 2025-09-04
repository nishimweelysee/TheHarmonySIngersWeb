<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instrument;
use App\Services\InstrumentExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstrumentController extends Controller
{
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
            } elseif ($request->availability === 'Unavailable') {
                $query->where('is_available', false);
            }
        }

        $perPage = $request->get('per_page', 10);
        $instruments = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.instruments.index', compact('instruments'));
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        $exportService = new InstrumentExportService();
        return $exportService->exportToExcel($request);
    }

    /**
     * Export to PDF
     */
    public function exportPdf(Request $request)
    {
        $exportService = new InstrumentExportService();
        return $exportService->exportToPdf($request);
    }

    public function create()
    {
        return view('admin.instruments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:instruments',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'condition' => 'required|string|in:excellent,good,fair,poor',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['is_available'] = $request->has('is_available');

        Instrument::create($validated);

        return redirect()->route('admin.instruments.index')
            ->with('success', 'Instrument created successfully.');
    }

    public function show(Instrument $instrument)
    {
        return view('admin.instruments.show', compact('instrument'));
    }

    public function edit(Instrument $instrument)
    {
        return view('admin.instruments.edit', compact('instrument'));
    }

    public function update(Request $request, Instrument $instrument)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:instruments,serial_number,' . $instrument->id,
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'condition' => 'required|string|in:excellent,good,fair,poor',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['is_available'] = $request->has('is_available');

        $instrument->update($validated);

        return redirect()->route('admin.instruments.index')
            ->with('success', 'Instrument updated successfully.');
    }

    public function destroy(Instrument $instrument)
    {
        $instrument->delete();

        return redirect()->route('admin.instruments.index')
            ->with('success', 'Instrument deleted successfully.');
    }
}
