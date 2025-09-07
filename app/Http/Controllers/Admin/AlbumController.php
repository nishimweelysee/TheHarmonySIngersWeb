<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Concert;
use App\Services\AlbumExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        $query = Album::with(['concert', 'media']);

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', strtolower($request->type));
        }

        // Filter by featured status
        if ($request->filled('featured')) {
            if ($request->featured === 'Featured') {
                $query->where('is_featured', true);
            } elseif ($request->featured === 'Not Featured') {
                $query->where('is_featured', false);
            }
        }

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 10);
        $albums = $query->latest()->paginate($perPage)->withQueryString();
        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        $concerts = Concert::orderBy('date', 'desc')->get();
        return view('admin.albums.create', compact('concerts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:photo,video,audio,mixed',
            'concert_id' => 'nullable|exists:concerts,id',
            'event_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Set default values
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_public'] = $request->has('is_public');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Album::create($validated);

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album created successfully.');
    }

    public function show(Album $album)
    {
        $album->load(['media' => function ($query) {
            $query->orderBy('sort_order', 'asc');
        }, 'concert']);

        return view('admin.albums.show', compact('album'));
    }

    public function edit(Album $album)
    {
        $concerts = Concert::orderBy('date', 'desc')->get();
        return view('admin.albums.edit', compact('album', 'concerts'));
    }

    public function update(Request $request, Album $album)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:photo,video,audio,mixed',
            'concert_id' => 'nullable|exists:concerts,id',
            'event_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Set default values
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_public'] = $request->has('is_public');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $album->update($validated);

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album updated successfully.');
    }

    public function destroy(Album $album)
    {
        // Check if album has media
        if ($album->media()->count() > 0) {
            return redirect()->route('admin.albums.index')
                ->with('error', 'Cannot delete album with existing media. Please delete media first.');
        }

        $album->delete();

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album deleted successfully.');
    }

    /**
     * Export albums to Excel
     */
    public function exportExcel(Request $request)
    {
        $exportService = new AlbumExportService();
        return $exportService->exportToExcel($request);
    }

    /**
     * Export albums to PDF
     */
    public function exportPdf(Request $request)
    {
        $exportService = new AlbumExportService();
        return $exportService->exportToPdf($request);
    }
}
