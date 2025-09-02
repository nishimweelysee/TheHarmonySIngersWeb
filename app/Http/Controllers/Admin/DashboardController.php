<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Concert;
use App\Models\Contribution;
use App\Models\Sponsor;
use App\Models\Media;
use App\Models\Plan;
use App\Models\Song;
use App\Models\Instrument;
use App\Models\PracticeSession;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_members' => Member::count(),
            'active_singers' => Member::active()->singers()->count(),
            'upcoming_concerts' => Concert::upcoming()->count(),
            'active_contributions' => Contribution::active()->count(),
            'total_sponsors' => Sponsor::active()->count(),
            'featured_media' => Media::featured()->public()->count(),
            'current_year_plans' => Plan::currentYear()->count(),
            'total_songs' => Song::count(),
            'available_instruments' => Instrument::available()->count(),
        ];

        // Get recent activities
        $recentConcerts = Concert::upcoming()->orderBy('date', 'asc')->limit(3)->get();
        $recentMembers = Member::latest()->limit(5)->get();
        $activeContributions = Contribution::active()->with('donations')->limit(3)->get();
        $recentMedia = Media::latest()->limit(4)->get();

        // Get practice sessions
        $upcomingPracticeSessions = PracticeSession::upcoming()->orderBy('practice_date', 'asc')->limit(3)->get();
        $todayPracticeSessions = PracticeSession::today()->get();

        // Get financial summary
        $financialSummary = [
            'total_contributions' => Contribution::sum('current_amount'),
            'monthly_contributions' => Contribution::monthly()->active()->sum('current_amount'),
            'project_contributions' => Contribution::project()->active()->sum('current_amount'),
            'total_sponsor_contributions' => Sponsor::sum('total_contributed'),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recentConcerts',
            'recentMembers',
            'activeContributions',
            'recentMedia',
            'financialSummary',
            'upcomingPracticeSessions',
            'todayPracticeSessions'
        ));
    }
}
