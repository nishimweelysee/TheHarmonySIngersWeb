<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Album;
use App\Models\Concert;
use App\Services\MediaExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $query = Media::with(['concert', 'album']);

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', strtolower($request->type));
        }

        $media = $query->latest()->paginate($perPage)->withQueryString();
        $albums = Album::all();
        $concerts = Concert::all();

        return view('admin.media.index', compact('media', 'albums', 'concerts'));
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        $exportService = new MediaExportService();
        return $exportService->exportToExcel($request);
    }

    /**
     * Export to PDF
     */
    public function exportPdf(Request $request)
    {
        $exportService = new MediaExportService();
        return $exportService->exportToPdf($request);
    }

    public function create()
    {
        $albums = Album::all();
        $concerts = Concert::all();
        return view('admin.media.create', compact('albums', 'concerts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:audio,video,image,document',
            'file' => 'required|file|max:102400', // 100MB max
            'description' => 'nullable|string',
            'album_id' => 'nullable|exists:albums,id',
            'concert_id' => 'nullable|exists:concerts,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('media', $filename, 'public');

        $media = Media::create([
            'title' => $request->title,
            'type' => $request->type,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'description' => $request->description,
            'album_id' => $request->album_id,
            'concert_id' => $request->concert_id,
        ]);

        return redirect()->route('admin.media.index')
            ->with('success', 'Media uploaded successfully.');
    }

    public function show(Media $media)
    {
        // Get previous and next media for navigation
        $previousMedia = Media::where('id', '<', $media->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextMedia = Media::where('id', '>', $media->id)
            ->orderBy('id', 'asc')
            ->first();

        // Load relationships
        $media->load(['concert', 'album']);

        return view('admin.media.show', compact('media', 'previousMedia', 'nextMedia'));
    }

    public function edit(Media $media)
    {
        $albums = Album::all();
        $concerts = Concert::all();
        return view('admin.media.edit', compact('media', 'albums', 'concerts'));
    }

    public function update(Request $request, Media $media)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:audio,video,image,document',
            'description' => 'nullable|string',
            'album_id' => 'nullable|exists:albums,id',
            'concert_id' => 'nullable|exists:concerts,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $media->update([
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'album_id' => $request->album_id,
            'concert_id' => $request->concert_id,
        ]);

        return redirect()->route('admin.media.index')
            ->with('success', 'Media updated successfully.');
    }

    public function destroy(Media $media)
    {
        // Delete the file from storage
        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        return redirect()->route('admin.media.index')
            ->with('success', 'Media deleted successfully.');
    }
}
