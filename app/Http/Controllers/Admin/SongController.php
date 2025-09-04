<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Services\SongExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Song::query();

        // Filter by genre
        if ($request->filled('genre')) {
            $query->where('genre', strtolower($request->genre));
        }

        // Filter by difficulty
        if ($request->filled('difficulty')) {
            $query->where('difficulty', strtolower($request->difficulty));
        }

        // Search by title or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%")
                    ->orWhere('lyrics', 'like', "%{$search}%");
            });
        }

        // Filter by composer
        if ($request->filled('composer')) {
            $query->where('composer', strtolower($request->composer));
        }

        // Filter by media
        if ($request->filled('media')) {
            switch ($request->media) {
                case 'with_audio':
                    $query->whereNotNull('audio_file');
                    break;
                case 'with_sheet_music':
                    $query->whereNotNull('sheet_music_file');
                    break;
                case 'with_lyrics':
                    $query->whereNotNull('lyrics');
                    break;
            }
        }

        $perPage = $request->get('per_page', 10);
        $songs = $query->orderBy('title', 'asc')->paginate($perPage)->withQueryString();

        return view('admin.songs.index', compact('songs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.songs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'composer' => 'nullable|string|max:255',
            'arranger' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'year_composed' => 'nullable|integer|min:1000|max:' . (date('Y') + 10),
            'difficulty' => 'nullable|in:beginner,intermediate,advanced,expert',
            'duration' => 'nullable|numeric|min:0.5|max:60',
            'key_signature' => 'nullable|string|max:50',
            'time_signature' => 'nullable|string|max:50',
            'lyrics' => 'nullable|string',
            'notes' => 'nullable|string',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:10240', // 10MB max
            'sheet_music_file' => 'nullable|file|mimes:pdf,doc,docx|max:20480', // 20MB max
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Handle checkbox values
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        // Handle file uploads
        if ($request->hasFile('audio_file')) {
            $audioPath = $request->file('audio_file')->store('songs/audio', 'public');
            $validated['audio_file'] = $audioPath;
        }

        if ($request->hasFile('sheet_music_file')) {
            $sheetMusicPath = $request->file('sheet_music_file')->store('songs/sheet-music', 'public');
            $validated['sheet_music_file'] = $sheetMusicPath;
        }

        Song::create($validated);

        return redirect()->route('admin.songs.index')->with('success', 'Song created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Song $song)
    {
        return view('admin.songs.show', compact('song'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Song $song)
    {
        return view('admin.songs.edit', compact('song'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Song $song)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'composer' => 'nullable|string|max:255',
            'arranger' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'year_composed' => 'nullable|integer|min:1000|max:' . (date('Y') + 10),
            'difficulty' => 'nullable|in:beginner,intermediate,advanced,expert',
            'duration' => 'nullable|numeric|min:0.5|max:60',
            'key_signature' => 'nullable|string|max:50',
            'time_signature' => 'nullable|string|max:50',
            'lyrics' => 'nullable|string',
            'notes' => 'nullable|string',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:10240', // 10MB max
            'sheet_music_file' => 'nullable|file|mimes:pdf,doc,docx|max:20480', // 20MB max
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Handle checkbox values
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        // Handle file uploads
        if ($request->hasFile('audio_file')) {
            // Delete old audio file if exists
            if ($song->audio_file) {
                Storage::disk('public')->delete($song->audio_file);
            }
            $audioPath = $request->file('audio_file')->store('songs/audio', 'public');
            $validated['audio_file'] = $audioPath;
        }

        if ($request->hasFile('sheet_music_file')) {
            // Delete old sheet music file if exists
            if ($song->sheet_music_file) {
                Storage::disk('public')->delete($song->sheet_music_file);
            }
            $sheetMusicPath = $request->file('sheet_music_file')->store('songs/sheet-music', 'public');
            $validated['sheet_music_file'] = $sheetMusicPath;
        }

        $song->update($validated);

        return redirect()->route('admin.songs.index')->with('success', 'Song updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Song $song)
    {
        $song->delete();

        return redirect()->route('admin.songs.index')->with('success', 'Song deleted successfully.');
    }

    /**
     * Export songs to Excel
     */
    public function exportExcel(Request $request)
    {
        $exportService = new SongExportService();
        return $exportService->exportToExcel($request);
    }

    /**
     * Export songs to PDF
     */
    public function exportPdf(Request $request)
    {
        $exportService = new SongExportService();
        return $exportService->exportToPdf($request);
    }
}
