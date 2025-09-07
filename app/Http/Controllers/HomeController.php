<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;
use App\Models\Media;
use App\Models\Member;
use App\Models\Album; // Added this import for the new code

class HomeController extends Controller
{
    public function index()
    {
        // Get upcoming concerts
        $upcomingConcerts = Concert::upcoming()
            ->orderBy('date', 'asc')
            ->limit(3)
            ->get();

        // Get featured media
        $featuredMedia = Media::featured()
            ->public()
            ->limit(6)
            ->get();

        // Get slideshow images from the "slideshow" album
        $slideshowAlbum = Album::where('name', 'slideshow')
            ->where('is_public', true)
            ->first();

        $slideshowImages = collect();
        if ($slideshowAlbum) {
            $slideshowImages = $slideshowAlbum->media()
                ->where('type', 'photo')
                ->where('is_public', true)
                ->orderBy('sort_order', 'asc')
                ->get();
        }

        // Get choir stats
        $stats = [
            'total_members' => Member::active()->count(),
            'singers' => Member::active()->singers()->count(),
            'upcoming_concerts' => Concert::upcoming()->count(),
            'years_active' => now()->year - 2022 // Assuming choir started in 2022
        ];

        return view('home', compact('upcomingConcerts', 'featuredMedia', 'stats', 'slideshowImages'));
    }
}