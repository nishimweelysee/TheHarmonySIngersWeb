<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::public();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $media = $query->latest()->paginate(12);

        $photos = Media::photos()->public()->count();
        $videos = Media::videos()->public()->count();
        $audios = Media::audios()->public()->count();

        return view('media.index', compact('media', 'photos', 'videos', 'audios'));
    }
}
