<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Notifications\MemberRegisteredNotification;
use App\Services\MemberExportService;
use App\Services\CertificatePrintService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Member::query();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', strtolower($request->type));
        }

        // Filter by voice part
        if ($request->filled('voice')) {
            $query->where('voice_part', strtolower($request->voice));
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'Active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'Inactive') {
                $query->where('is_active', false);
            }
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 10);
        $members = $query->orderBy('last_name', 'asc')->paginate($perPage)->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'type' => 'required|in:singer,general',
            'voice_part' => 'nullable|string|max:255',
            'join_date' => 'required|date',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $photoPath;
        }

        $member = Member::create($validated);

        // Send welcome notification
        $this->sendMemberWelcomeNotification($member);

        return redirect()->route('admin.members.index')->with('success', 'Member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $member->load(['donations', 'instruments']);
        return view('admin.members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'type' => 'required|in:singer,general',
            'voice_part' => 'nullable|string|max:255',
            'join_date' => 'required|date',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($member->profile_photo) {
                Storage::disk('public')->delete($member->profile_photo);
            }
            $photoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $photoPath;
        }

        $member->update($validated);

        return redirect()->route('admin.members.index')->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Member deleted successfully.');
    }


    /**
     * Generate and download PDF certificate for the specified member.
     */
    public function downloadCertificate(Member $member)
    {
        $data = [
            'member' => $member,
            'currentDate' => now()->format('F j, Y'),
            'bibleVerse' => [
                'text' => 'Sing to the Lord a new song; sing to the Lord, all the earth. Sing to the Lord, praise his name; proclaim his salvation day after day.',
                'reference' => 'Psalm 96:1-2'
            ],
            'additionalVerse' => [
                'text' => 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters.',
                'reference' => 'Colossians 3:23'
            ]
        ];

        $pdf = Pdf::loadView('admin.members.certificate-pdf', $data);

        return $pdf->download("certificate-{$member->first_name}-{$member->last_name}.pdf");
    }




    /**
     * Search members for autocomplete
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (strlen($query) < 2) {
            return response()->json(['members' => []]);
        }

        $members = Member::where(function ($q) use ($query) {
            $q->where('first_name', 'like', "%{$query}%")
                ->orWhere('last_name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%");
        })
            ->select('id', 'first_name', 'last_name', 'email', 'phone')
            ->limit(10)
            ->get()
            ->map(function ($member) {
                return [
                    'id' => $member->id,
                    'name' => $member->first_name . ' ' . $member->last_name,
                    'email' => $member->email,
                    'phone' => $member->phone,
                ];
            });

        return response()->json(['members' => $members]);
    }

    /**
     * Send welcome notification to new member.
     */
    private function sendMemberWelcomeNotification(Member $member): void
    {
        try {
            // Send email notification
            if ($member->email) {
                $member->notify(new MemberRegisteredNotification($member));
            }

            // Create inbox notification for admins
            $this->createAdminMemberNotification($member);
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Illuminate\Support\Facades\Log::error('Failed to send member welcome notification', [
                'member_id' => $member->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Create admin notification for new member.
     */
    private function createAdminMemberNotification(Member $member): void
    {
        // Get admin users
        $adminUsers = \App\Models\User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->get();

        foreach ($adminUsers as $admin) {
            $admin->inboxNotifications()->create([
                'type' => 'inbox',
                'title' => '🎵 New THS Member Registered',
                'message' => "🎉 A new member {$member->full_name} has joined The Harmony Singers Choir!\n\n" .
                    "🌟 Member Details:\n" .
                    "• Name: {$member->full_name}\n" .
                    "• Type: " . ucfirst($member->type) . "\n" .
                    "• Join Date: " . $member->join_date->format('M j, Y') . "\n" .
                    "• Voice Part: " . ($member->voice_part ? ucfirst($member->voice_part) : 'Not specified') . "\n\n" .
                    "🎭 Welcome them to our musical family!",
                'notifiable_type' => \App\Models\User::class,
                'notifiable_id' => $admin->id,
                'status' => 'unread',
                'sent_at' => now()
            ]);
        }
    }

    /**
     * Export members to Excel
     */
    public function exportExcel(Request $request)
    {
        $exportService = new MemberExportService();
        return $exportService->exportToExcel($request);
    }

    /**
     * Export members to PDF
     */
    public function exportPdf(Request $request)
    {
        $exportService = new MemberExportService();
        return $exportService->exportToPdf($request);
    }

    /**
     * Print certificates for selected members
     */
    public function printCertificates(Request $request)
    {
        try {
            $printService = new CertificatePrintService();
            return $printService->printCertificates($request);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Print certificates for filtered members
     */
    public function printFilteredCertificates(Request $request)
    {
        try {
            $printService = new CertificatePrintService();
            return $printService->printFilteredCertificates($request);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Get certificate printing statistics
     */
    public function getCertificateStats(Request $request)
    {
        $printService = new CertificatePrintService();
        return response()->json($printService->getCertificateStats($request));
    }
}
