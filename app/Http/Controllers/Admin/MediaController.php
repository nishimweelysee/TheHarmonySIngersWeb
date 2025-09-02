<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Album;
use App\Models\Concert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::with(['concert', 'album']);

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', strtolower($request->type));
        }

        // Filter by album
        if ($request->filled('album')) {
            $query->where('album_id', $request->album);
        }

        // Filter by featured status
        if ($request->filled('featured')) {
            if ($request->featured === 'Featured') {
                $query->where('is_featured', true);
            } elseif ($request->featured === 'Not Featured') {
                $query->where('is_featured', false);
            }
        }

        // Search by title or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $media = $query->latest()->paginate(20)->withQueryString();
        $concerts = Concert::orderBy('date', 'desc')->get();
        $albums = Album::orderBy('name', 'asc')->get();
        return view('admin.media.index', compact('media', 'concerts', 'albums'));
    }

    public function create()
    {
        $concerts = Concert::orderBy('date', 'desc')->get();
        $albums = Album::orderBy('name', 'asc')->get();

        // Get album_id from query parameter if provided
        $selectedAlbumId = request()->query('album_id');

        return view('admin.media.create', compact('concerts', 'albums', 'selectedAlbumId'));
    }

    public function store(Request $request)
    {
        // Set PHP limits for this request
        ini_set('upload_max_filesize', '100M');
        ini_set('post_max_size', '200M');
        ini_set('max_execution_time', 300);
        ini_set('max_input_time', 300);
        ini_set('memory_limit', '512M');

        // Validate basic fields
        $validated = $request->validate([
            'type' => 'required|in:photo,video,audio',
            'album_id' => 'required|exists:albums,id',
            'concert_id' => 'nullable|exists:concerts,id',
            'event_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'files.*' => 'required|file|max:102400', // 100MB max per file (to stay within post_max_size)
        ]);

        // Set default values
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_public'] = $request->has('is_public');

        $uploadedCount = 0;
        $errors = [];
        // Handle multiple file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                // Validate file type based on selected media type
                $fileValidation = $this->validateFileType($file, $validated['type']);

                if (!$fileValidation['valid']) {
                    $errors[] = "File {$file->getClientOriginalName()}: {$fileValidation['message']}";
                    \Illuminate\Support\Facades\Log::warning('File validation failed in store method', [
                        'filename' => $file->getClientOriginalName(),
                        'error' => $fileValidation['message']
                    ]);
                    continue;
                }

                \Illuminate\Support\Facades\Log::info('File validation passed in store method', [
                    'filename' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension()
                ]);

                try {
                    // Generate unique filename
                    $filename = time() . '_' . $index . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('media', $filename, 'public');

                    // Create media record
                    Media::create([
                        'title' => $request->input("titles.{$index}", $file->getClientOriginalName()),
                        'description' => $request->input("descriptions.{$index}"),
                        'type' => $validated['type'],
                        'album_id' => $validated['album_id'],
                        'concert_id' => $validated['concert_id'] ?? null,
                        'event_date' => $validated['event_date'] ?? null,
                        'is_featured' => $validated['is_featured'],
                        'is_public' => $validated['is_public'],
                        'file_path' => $path,
                        'file_name' => $filename,
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'sort_order' => $index,
                    ]);

                    $uploadedCount++;
                } catch (\Exception $e) {
                    $errors[] = "File {$file->getClientOriginalName()}: Upload failed - " . $e->getMessage();
                }
            }
        }

        // Prepare response message
        $message = "Successfully uploaded {$uploadedCount} file(s).";
        if (!empty($errors)) {
            $message .= " Errors: " . implode('; ', $errors);
        }

        return redirect()->route('admin.media.index')
            ->with('success', $message)
            ->with('errors', $errors);
    }

    /**
     * Store large media files with enhanced limits
     */
    public function storeLarge(Request $request)
    {
        // Debug: Log the request data
        \Illuminate\Support\Facades\Log::info('Media upload request received', [
            'has_files' => $request->hasFile('files'),
            'file_count' => $request->hasFile('files') ? count($request->file('files')) : 0,
            'album_id' => $request->input('album_id'),
            'type' => $request->input('type'),
            'titles' => $request->input('titles'),
            'descriptions' => $request->input('descriptions'),
            'all_input' => $request->all(),
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'content_length' => $request->header('Content-Length'),
            'files_array' => $request->allFiles(),
            'has_file_files' => $request->hasFile('files'),
            'files_input' => $request->file('files')
        ]);

        // Force PHP limits for large uploads - try multiple approaches
        @ini_set('upload_max_filesize', '100M');
        @ini_set('post_max_size', '200M');
        @ini_set('max_execution_time', 300);
        @ini_set('max_input_time', 300);
        @ini_set('memory_limit', '512M');

        // Also try setting via putenv
        @putenv('upload_max_filesize=100M');
        @putenv('post_max_size=200M');

        // Debug: Log request data
        \Illuminate\Support\Facades\Log::info('Request data before validation', [
            'has_files' => $request->hasFile('files'),
            'file_count' => $request->hasFile('files') ? count($request->file('files')) : 0,
            'album_id' => $request->input('album_id'),
            'type' => $request->input('type'),
            'titles' => $request->input('titles'),
            'descriptions' => $request->input('descriptions')
        ]);

        // Validate basic fields
        $validated = $request->validate([
            'type' => 'required|in:photo,video,audio',
            'album_id' => 'required|exists:albums,id',
            'concert_id' => 'nullable|exists:concerts,id',
            'event_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'files.*' => 'required|file|max:102400', // 100MB max per file (to stay within post_max_size)
            'titles.*' => 'nullable|string|max:255',
            'descriptions.*' => 'nullable|string',
        ]);

        // Debug: Log after validation
        \Illuminate\Support\Facades\Log::info('After validation', [
            'validated' => $validated,
            'has_files' => $request->hasFile('files'),
            'file_count' => $request->hasFile('files') ? count($request->file('files')) : 0
        ]);

        // Set default values
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_public'] = $request->has('is_public');

        \Illuminate\Support\Facades\Log::info('Default values set', [
            'is_featured' => $validated['is_featured'],
            'is_public' => $validated['is_public']
        ]);

        $uploadedCount = 0;
        $errors = [];

        \Illuminate\Support\Facades\Log::info('About to check for files', [
            'hasFile_files' => $request->hasFile('files'),
            'files_input' => $request->file('files'),
            'all_files' => $request->allFiles(),
            'request_keys' => array_keys($request->all()),
            'files_key_exists' => array_key_exists('files', $request->allFiles())
        ]);

        // Handle multiple file uploads
        $files = $request->file('files');
        \Illuminate\Support\Facades\Log::info('Files from request', [
            'files' => $files,
            'is_array' => is_array($files),
            'count' => is_array($files) ? count($files) : 'not array',
            'hasFile_files' => $request->hasFile('files')
        ]);

        if ($files && is_array($files) && count($files) > 0) {
            \Illuminate\Support\Facades\Log::info('Starting file processing', [
                'file_count' => count($files)
            ]);

            foreach ($files as $index => $file) {
                \Illuminate\Support\Facades\Log::info('Processing file', [
                    'index' => $index,
                    'filename' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension()
                ]);

                // Validate file type based on selected media type
                $fileValidation = $this->validateFileType($file, $validated['type']);

                if (!$fileValidation['valid']) {
                    $errors[] = "File {$file->getClientOriginalName()}: {$fileValidation['message']}";
                    \Illuminate\Support\Facades\Log::warning('File validation failed', [
                        'filename' => $file->getClientOriginalName(),
                        'error' => $fileValidation['message']
                    ]);
                    continue;
                }

                \Illuminate\Support\Facades\Log::info('File validation passed', [
                    'filename' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension()
                ]);

                try {
                    // Generate unique filename
                    $filename = time() . '_' . $index . '_' . $file->getClientOriginalName();
                    \Illuminate\Support\Facades\Log::info('Storing file', [
                        'original_name' => $file->getClientOriginalName(),
                        'generated_filename' => $filename
                    ]);

                    $path = $file->storeAs('media', $filename, 'public');
                    \Illuminate\Support\Facades\Log::info('File stored successfully', [
                        'path' => $path,
                        'full_path' => storage_path('app/public/' . $path)
                    ]);

                    // Create media record
                    $mediaData = [
                        'title' => $request->input("titles.{$index}", $file->getClientOriginalName()),
                        'description' => $request->input("descriptions.{$index}"),
                        'type' => $validated['type'],
                        'album_id' => $validated['album_id'],
                        'concert_id' => $validated['concert_id'] ?? null,
                        'event_date' => $validated['event_date'] ?? null,
                        'is_featured' => $validated['is_featured'],
                        'is_public' => $validated['is_public'],
                        'file_path' => $path,
                        'file_name' => $filename,
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'sort_order' => $index,
                    ];

                    \Illuminate\Support\Facades\Log::info('Creating media record', $mediaData);

                    $media = Media::create($mediaData);
                    \Illuminate\Support\Facades\Log::info('Media record created successfully', [
                        'media_id' => $media->id,
                        'title' => $media->title
                    ]);

                    $uploadedCount++;
                } catch (\Exception $e) {
                    $errorMsg = "File {$file->getClientOriginalName()}: Upload failed - " . $e->getMessage();
                    $errors[] = $errorMsg;
                    \Illuminate\Support\Facades\Log::error('File upload failed', [
                        'filename' => $file->getClientOriginalName(),
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }
        } else {
            \Illuminate\Support\Facades\Log::warning('No files found in request');
        }

        // Prepare response message
        $message = "Successfully uploaded {$uploadedCount} file(s).";
        if (!empty($errors)) {
            $message .= " Errors: " . implode('; ', $errors);
        }

        \Illuminate\Support\Facades\Log::info('Upload process completed', [
            'uploaded_count' => $uploadedCount,
            'error_count' => count($errors),
            'errors' => $errors,
            'message' => $message
        ]);

        return redirect()->route('admin.media.index')
            ->with('success', $message)
            ->with('errors', $errors);
    }

    /**
     * Validate file type based on selected media type
     */
    private function validateFileType($file, $mediaType)
    {
        $allowedTypes = [
            'photo' => ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'],
            'video' => ['video/mp4', 'video/avi', 'video/mov', 'video/wmv', 'video/flv', 'video/webm'],
            'audio' => [
                'audio/mpeg',
                'audio/mp3',
                'audio/wav',
                'audio/x-wav',
                'audio/flac',
                'audio/aac',
                'audio/ogg',
                'audio/wave',
                'audio/x-pn-wav',
                'audio/vnd.wave'
            ],
        ];

        $fileMimeType = $file->getMimeType();
        $fileExtension = strtolower($file->getClientOriginalExtension());

        // First check MIME type
        if (in_array($fileMimeType, $allowedTypes[$mediaType])) {
            return ['valid' => true, 'message' => ''];
        }

        // If MIME type fails, check file extension as fallback
        $allowedExtensions = [
            'photo' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            'video' => ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm'],
            'audio' => ['mp3', 'wav', 'flac', 'aac', 'ogg', 'm4a', 'wma'],
        ];

        if (in_array($fileExtension, $allowedExtensions[$mediaType])) {
            \Illuminate\Support\Facades\Log::info('File validation passed via extension fallback', [
                'filename' => $file->getClientOriginalName(),
                'mime_type' => $fileMimeType,
                'extension' => $fileExtension,
                'media_type' => $mediaType
            ]);
            return ['valid' => true, 'message' => ''];
        }

        return [
            'valid' => false,
            'message' => "File type {$fileMimeType} (extension: .{$fileExtension}) is not allowed for {$mediaType} media. Allowed types: " . implode(', ', $allowedTypes[$mediaType])
        ];
    }

    /**
     * Get human-readable upload error message
     */
    private function getUploadErrorMessage($errorCode)
    {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
        ];

        return $errorMessages[$errorCode] ?? 'Unknown upload error occurred.';
    }

    public function show(Media $media)
    {
        // Get previous and next media for navigation
        $previousMedia = Media::where('id', '<', $media->id)->orderBy('id', 'desc')->first();
        $nextMedia = Media::where('id', '>', $media->id)->orderBy('id', 'asc')->first();

        return view('admin.media.show', compact('media', 'previousMedia', 'nextMedia'));
    }

    public function edit(Media $media)
    {
        $concerts = Concert::orderBy('date', 'desc')->get();
        $albums = Album::orderBy('name', 'asc')->get();
        return view('admin.media.edit', compact('media', 'concerts', 'albums'));
    }

    public function update(Request $request, Media $media)
    {
        // Set PHP limits for this request - try multiple approaches
        @ini_set('upload_max_filesize', '100M');
        @ini_set('post_max_size', '200M');
        @ini_set('max_execution_time', 300);
        @ini_set('max_input_time', 300);
        @ini_set('memory_limit', '512M');

        // Also try setting via putenv
        @putenv('upload_max_filesize=100M');
        @putenv('post_max_size=200M');
        @putenv('max_execution_time=300');
        @putenv('max_input_time=300');
        @putenv('memory_limit=512M');

        // Log current limits for debugging
        \Illuminate\Support\Facades\Log::info('PHP limits in update method', [
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'max_execution_time' => ini_get('max_execution_time'),
            'memory_limit' => ini_get('memory_limit')
        ]);

        // Check if request is too large before processing (100MB limit)
        $contentLength = $request->header('Content-Length');
        $maxSize = 100 * 1024 * 1024; // 100MB in bytes

        if ($contentLength && $contentLength > $maxSize) {
            \Illuminate\Support\Facades\Log::error('Request too large for media update', [
                'content_length' => $contentLength,
                'max_allowed' => $maxSize,
                'media_id' => $media->id
            ]);

            return back()->withErrors([
                'file' => 'File size too large. Maximum allowed size is 100MB. Please try a smaller file or contact administrator to increase limits.'
            ])->withInput();
        }

        // Debug: Log the request data
        \Illuminate\Support\Facades\Log::info('Media update request received', [
            'media_id' => $media->id,
            'has_file' => $request->hasFile('file'),
            'file_size' => $request->hasFile('file') ? $request->file('file')->getSize() : null,
            'content_length' => $contentLength,
            'all_input' => $request->all()
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:photo,video,audio',
            'description' => 'nullable|string',
            'album_id' => 'nullable|exists:albums,id',
            'concert_id' => 'nullable|exists:concerts,id',
            'event_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'file' => 'nullable|file|max:102400', // 100MB max for file replacement
        ]);

        // Set default values
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_public'] = $request->has('is_public');

        // Handle file upload if provided
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Check for upload errors
            if ($file->getError() !== UPLOAD_ERR_OK) {
                $errorMessage = $this->getUploadErrorMessage($file->getError());
                \Illuminate\Support\Facades\Log::error('File upload error', [
                    'error_code' => $file->getError(),
                    'error_message' => $errorMessage,
                    'file_name' => $file->getClientOriginalName()
                ]);
                return back()->withErrors(['file' => $errorMessage])->withInput();
            }

            // Debug: Log file information
            \Illuminate\Support\Facades\Log::info('File upload detected', [
                'original_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'media_type' => $validated['type']
            ]);

            // Validate file type based on selected media type
            $fileValidation = $this->validateFileType($file, $validated['type']);

            if (!$fileValidation['valid']) {
                \Illuminate\Support\Facades\Log::warning('File validation failed', [
                    'error' => $fileValidation['message']
                ]);
                return back()->withErrors(['file' => $fileValidation['message']])->withInput();
            }

            // Delete old file if it exists
            if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
                \Illuminate\Support\Facades\Log::info('Old file deleted', ['path' => $media->file_path]);
            }

            // Generate unique filename
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('media', $filename, 'public');

            // Update file-related fields
            $validated['file_path'] = $path;
            $validated['file_name'] = $filename;
            $validated['file_size'] = $file->getSize();
            $validated['mime_type'] = $file->getMimeType();

            \Illuminate\Support\Facades\Log::info('New file uploaded', [
                'path' => $path,
                'filename' => $filename,
                'size' => $file->getSize()
            ]);
        }

        $media->update($validated);

        \Illuminate\Support\Facades\Log::info('Media updated successfully', [
            'media_id' => $media->id,
            'file_updated' => $request->hasFile('file')
        ]);

        return redirect()->route('admin.media.show', $media)->with('success', 'Media updated successfully.');
    }

    public function destroy(Media $media)
    {
        // Delete the file from storage
        if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        return redirect()->route('admin.media.index')->with('success', 'Media deleted successfully.');
    }
}
