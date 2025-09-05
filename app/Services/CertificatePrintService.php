<?php

namespace App\Services;

use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CertificatePrintService
{
    /**
     * Print certificates for selected members
     */
    public function printCertificates(Request $request)
    {
        $members = $this->getSelectedMembers($request);

        if ($members->isEmpty()) {
            throw new \Exception('No members selected for certificate printing.');
        }

        // If only one member, return single certificate
        if ($members->count() === 1) {
            return $this->printSingleCertificate($members->first());
        }

        // For multiple members, create a combined PDF
        return $this->printMultipleCertificates($members);
    }

    /**
     * Print a single certificate
     */
    public function printSingleCertificate(Member $member)
    {
        $data = [
            'member' => $member,
            'currentDate' => now()->format('F j, Y'),
            'bibleVerse' => [
                'text' => 'O COME, LET US SING UNTO THE LORD: LET US MAKE A JOYFUL NOISE TO THE ROCK OF OUR SALVATION.',
                'reference' => 'PSALMS 95:1'
            ],
            'additionalVerse' => [
                'text' => 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters.',
                'reference' => 'Colossians 3:23'
            ]
        ];

        $pdf = Pdf::loadView('admin.members.certificate-pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download("certificate-{$member->first_name}-{$member->last_name}.pdf");
    }

    /**
     * Print multiple certificates in a single PDF
     */
    public function printMultipleCertificates(Collection $members)
    {
        $certificates = [];

        foreach ($members as $member) {
            $certificates[] = [
                'member' => $member,
                'currentDate' => now()->format('F j, Y'),
                'bibleVerse' => [
                    'text' => 'O COME, LET US SING UNTO THE LORD: LET US MAKE A JOYFUL NOISE TO THE ROCK OF OUR SALVATION.',
                    'reference' => 'PSALMS 95:1'
                ],
                'additionalVerse' => [
                    'text' => 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters.',
                    'reference' => 'Colossians 3:23'
                ]
            ];
        }

        $pdf = Pdf::loadView('admin.members.certificates-bulk-pdf', [
            'certificates' => $certificates,
            'printDate' => now(),
            'totalCount' => $members->count()
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('certificates_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Print certificates for filtered members
     */
    public function printFilteredCertificates(Request $request)
    {
        $members = $this->getFilteredMembers($request);

        if ($members->isEmpty()) {
            throw new \Exception('No members found matching the selected criteria.');
        }

        return $this->printMultipleCertificates($members);
    }

    /**
     * Get selected members from request
     */
    private function getSelectedMembers(Request $request): Collection
    {
        if ($request->filled('member_ids')) {
            $memberIds = is_array($request->member_ids)
                ? $request->member_ids
                : explode(',', $request->member_ids);

            return Member::whereIn('id', $memberIds)->get();
        }

        return collect();
    }

    /**
     * Get filtered members based on request parameters
     */
    private function getFilteredMembers(Request $request): Collection
    {
        $query = Member::query();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('voice_part')) {
            $query->where('voice_part', $request->voice_part);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('joined_from')) {
            $query->whereDate('join_date', '>=', $request->joined_from);
        }

        if ($request->filled('joined_to')) {
            $query->whereDate('join_date', '<=', $request->joined_to);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }

        return $query->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->get();
    }

    /**
     * Get applied filters for display in exports
     */
    public function getAppliedFilters(Request $request): array
    {
        $filters = [];

        if ($request->filled('search')) {
            $filters['Search'] = $request->search;
        }

        if ($request->filled('type')) {
            $filters['Type'] = ucfirst($request->type);
        }

        if ($request->filled('voice_part')) {
            $filters['Voice Part'] = ucfirst($request->voice_part);
        }

        if ($request->filled('status')) {
            $filters['Status'] = ucfirst($request->status);
        }

        if ($request->filled('joined_from')) {
            $filters['Joined From'] = $request->joined_from;
        }

        if ($request->filled('joined_to')) {
            $filters['Joined To'] = $request->joined_to;
        }

        if ($request->filled('is_active')) {
            $filters['Active Status'] = $request->is_active === '1' ? 'Active' : 'Inactive';
        }

        return $filters;
    }

    /**
     * Get certificate statistics
     */
    public function getCertificateStats(Request $request): array
    {
        $members = $this->getFilteredMembers($request);

        return [
            'total_members' => $members->count(),
            'active_members' => $members->where('is_active', true)->count(),
            'inactive_members' => $members->where('is_active', false)->count(),
            'by_type' => $members->groupBy('type')->map->count(),
            'by_voice_part' => $members->groupBy('voice_part')->map->count(),
        ];
    }
}
