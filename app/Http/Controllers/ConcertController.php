<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;

class ConcertController extends Controller
{
    public function index()
    {
        $upcomingConcerts = Concert::upcoming()
            ->orderBy('date', 'asc')
            ->get();

        $pastConcerts = Concert::completed()
            ->orderBy('date', 'desc')
            ->limit(6)
            ->get();

        return view('concerts.index', compact('upcomingConcerts', 'pastConcerts'));
    }

    public function show(Concert $concert)
    {
        $concert->load('media');

        // Get related concerts (other upcoming concerts)
        $relatedConcerts = Concert::upcoming()
            ->where('id', '!=', $concert->id)
            ->orderBy('date', 'asc')
            ->limit(3)
            ->get();

        return view('concerts.show', compact('concert', 'relatedConcerts'));
    }
}
