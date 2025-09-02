<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Notifications\ContributionReceivedNotification;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contribution::query();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', strtolower($request->type));
        }

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

        $contributions = $query->latest()->paginate(20)->withQueryString();
        return view('admin.contributions.index', compact('contributions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contributions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contributor_name' => 'required|string|max:255',
            'contributor_email' => 'required|email|max:255',
            'contributor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'nullable|string|max:3',
            'type' => 'required|in:monthly,project,donation,event',
            'contribution_date' => 'required|date',
            'status' => 'required|in:active,completed,cancelled',
            'project_name' => 'nullable|string|max:255',
            'project_type' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'payment_method' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
        ]);

        // Set default currency if not provided
        if (empty($validated['currency'])) {
            $validated['currency'] = 'RWF';
        }

        $contribution = Contribution::create($validated);

        // Send notifications
        $this->sendContributionNotifications($contribution);

        return redirect()->route('admin.contributions.index')->with('success', 'Contribution recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contribution $contribution)
    {
        return view('admin.contributions.show', compact('contribution'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contribution $contribution)
    {
        return view('admin.contributions.edit', compact('contribution'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contribution $contribution)
    {
        $validated = $request->validate([
            'contributor_name' => 'required|string|max:255',
            'contributor_email' => 'required|email|max:255',
            'contributor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'nullable|string|max:3',
            'type' => 'required|in:monthly,project,donation,event',
            'contribution_date' => 'required|date',
            'status' => 'required|in:active,completed,cancelled',
            'project_name' => 'nullable|string|max:255',
            'project_type' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'payment_method' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
        ]);

        $contribution->update($validated);

        return redirect()->route('admin.contributions.index')->with('success', 'Contribution updated successfully.');
    }

    /**
     * Send notifications for contribution received.
     */
    private function sendContributionNotifications(Contribution $contribution): void
    {
        try {
            // Send email notification
            if ($contribution->contributor_email) {
                // Create a temporary notifiable object for the contributor
                $notifiable = new class($contribution->contributor_email) {
                    public $email;
                    public function __construct($email)
                    {
                        $this->email = $email;
                    }

                    public function routeNotificationForMail()
                    {
                        return $this->email;
                    }
                };

                Notification::route('mail', $notifiable->email)
                    ->notify(new ContributionReceivedNotification($contribution));
            }

            // Send SMS notification if phone is provided
            if ($contribution->contributor_phone) {
                $smsService = app(SmsService::class);
                $smsService->sendContributionSms(
                    $contribution->contributor_phone,
                    $contribution->contributor_name,
                    $contribution->amount,
                    $contribution->currency
                );
            }

            // Create inbox notification for admins
            $this->createAdminNotification($contribution);
        } catch (\Exception $e) {
            // Log error but don't fail the request
            Log::error('Failed to send contribution notifications', [
                'contribution_id' => $contribution->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Create admin notification for new contribution.
     */
    private function createAdminNotification(Contribution $contribution): void
    {
        // Get admin users
        $adminUsers = \App\Models\User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->get();

        foreach ($adminUsers as $admin) {
            $admin->inboxNotifications()->create([
                'type' => 'inbox',
                'title' => '💰 New THS Contribution Received',
                'message' => "🎉 A new contribution has been received for The Harmony Singers Choir!\n\n" .
                    "🌟 Contribution Details:\n" .
                    "• Amount: {$contribution->currency} " . number_format($contribution->amount, 2) . "\n" .
                    "• Contributor: {$contribution->contributor_name}\n" .
                    "• Type: " . ucfirst($contribution->type) . "\n" .
                    "• Date: " . $contribution->contribution_date->format('M j, Y') . "\n\n" .
                    "🎭 This support helps us continue creating beautiful music!",
                'notifiable_type' => \App\Models\User::class,
                'notifiable_id' => $admin->id,
                'status' => 'unread',
                'sent_at' => now()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contribution $contribution)
    {
        $contribution->delete();

        return redirect()->route('admin.contributions.index')->with('success', 'Contribution deleted successfully.');
    }
}
