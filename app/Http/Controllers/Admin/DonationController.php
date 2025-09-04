<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Donation::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', strtolower($request->status));
        }

        // Search by donor name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', "%{$search}%")
                    ->orWhere('donor_email', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 10);
        $donations = $query->latest()->paginate($perPage)->withQueryString();
        return view('admin.donations.index', compact('donations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.donations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'nullable|string|max:3',
            'donation_date' => 'required|date',
            'status' => 'required|in:pending,received,acknowledged',
            'notes' => 'nullable|string',
            'payment_method' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
        ]);

        // Set default currency if not provided
        if (empty($validated['currency'])) {
            $validated['currency'] = 'RWF';
        }

        Donation::create($validated);

        return redirect()->route('admin.donations.index')->with('success', 'Donation recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        return view('admin.donations.show', compact('donation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        return view('admin.donations.edit', compact('donation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'nullable|string|max:3',
            'donation_date' => 'required|date',
            'status' => 'required|in:pending,received,acknowledged',
            'notes' => 'nullable|string',
            'payment_method' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
        ]);

        $donation->update($validated);

        return redirect()->route('admin.donations.index')->with('success', 'Donation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();

        return redirect()->route('admin.donations.index')->with('success', 'Donation deleted successfully.');
    }
}
