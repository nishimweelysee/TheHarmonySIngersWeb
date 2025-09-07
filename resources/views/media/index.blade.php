@extends('layouts.public')

@section('title', 'Media Gallery')
@section('description', 'Explore our collection of photos, videos, and audio recordings from The Harmony Singers
performances')

@section('content')
<!-- Immediate Error Prevention Script -->
<script>
    // IMMEDIATE ERROR PREVENTION - Run before anything else
    (function() {
        'use strict';

        // Override addEventListener immediately to prevent all errors
        const originalAddEventListener = Element.prototype.addEventListener;
        Element.prototype.addEventListener = function(type, listener, options) {
            if (this === null || this === undefined) {
                console.warn('Prevented addEventListener on null element:', type);
                return;
            }

            try {
                return originalAddEventListener.call(this, type, listener, options);
            } catch (error) {
                console.warn('addEventListener error prevented:', error.message);
                return;
            }
        };

        // Also protect document and window immediately
        const originalDocumentAddEventListener = document.addEventListener;
        document.addEventListener = function(type, listener, options) {
            try {
                return originalDocumentAddEventListener.call(this, type, listener, options);
            } catch (error) {
                console.warn('Document addEventListener error prevented:', error.message);
                return;
            }
        };

        const originalWindowAddEventListener = window.addEventListener;
        window.addEventListener = function(type, listener, options) {
            try {
                return originalWindowAddEventListener.call(this, type, listener, options);
            } catch (error) {
                console.warn('Window addEventListener error prevented:', error.message);
                return;
            }
        };

        console.log('IMMEDIATE error prevention system activated');
    })();
</script>
<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Media Gallery</h1>
        <p>
            Explore our collection of photos, videos, and audio recordings from recent performances
            and special events throughout our musical journey.
        </p>
    </div>
</section>

<!-- Filter Section -->
<section style="background: var(--gray-50); padding: var(--space-8) 0;">
    <div class="container">
        <div style="text-align: center;">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--space-6);">
                Browse by Type
            </h2>
            <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('media.index') }}"
                    class="btn {{ !request('type') ? 'btn-primary' : 'btn-secondary' }}">
                    <i class="fas fa-th-large"></i>
                    All Media
                </a>
                <a href="{{ route('media.index', ['type' => 'photo']) }}"
                    class="btn {{ request('type') === 'photo' ? 'btn-primary' : 'btn-secondary' }}">
                    <i class="fas fa-camera"></i>
                    Photos
                </a>
                <a href="{{ route('media.index', ['type' => 'video']) }}"
                    class="btn {{ request('type') === 'video' ? 'btn-primary' : 'btn-secondary' }}">
                    <i class="fas fa-video"></i>
                    Videos
                </a>
                <a href="{{ route('media.index', ['type' => 'audio']) }}"
                    class="btn {{ request('type') === 'audio' ? 'btn-primary' : 'btn-secondary' }}">
                    <i class="fas fa-music"></i>
                    Audio
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Media Grid -->
<section class="section">
    <div class="container">
        @if($media->count() > 0)
        @if(request('type') === 'audio')
        <!-- Spotify-style Audio Layout -->
        <div style="max-width: 800px; margin: 0 auto;">
            <div
                style="background: white; border-radius: var(--radius-xl); box-shadow: var(--shadow); overflow: hidden;">
                <div
                    style="background: linear-gradient(135deg, var(--success) 0%, var(--accent) 100%); padding: var(--space-6); color: white; text-align: center;">
                    <i class="fas fa-music" style="font-size: 3rem; margin-bottom: var(--space-4); opacity: 0.9;"></i>
                    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: var(--space-2);">Audio Recordings
                    </h2>
                    <p style="opacity: 0.9;">Listen to our beautiful performances</p>
                </div>

                <div style="padding: var(--space-6);">
                    @foreach($media as $index => $item)
                    <div style="display: flex; align-items: center; gap: var(--space-4); padding: var(--space-4); border-radius: var(--radius-lg); transition: var(--transition); cursor: pointer; border-bottom: 1px solid var(--gray-100);"
                        onmouseover="this.style.background='var(--gray-50)'"
                        onmouseout="this.style.background='transparent'" data-file-path="{{ $item->file_path }}"
                        data-event-date="{{ $item->event_date }}">

                        <!-- Track Number & Play Button -->
                        <div style="display: flex; align-items: center; gap: var(--space-3); min-width: 80px;">
                            <div style="width: 32px; text-align: center; color: var(--gray-500); font-weight: 600;">
                                {{ $index + 1 }}
                            </div>
                            <button onclick="openMediaPlayer({{ json_encode($item) }})"
                                style="width: 40px; height: 40px; background: var(--success); color: white; border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: var(--transition);"
                                onmouseover="this.style.transform='scale(1.1)'"
                                onmouseout="this.style.transform='scale(1)'">
                                <i class="fas fa-play" style="font-size: 0.875rem; margin-left: 2px;"></i>
                            </button>
                        </div>

                        <!-- Album Art Placeholder -->
                        <div
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--success) 0%, var(--accent) 100%); border-radius: var(--radius); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-music" style="color: white; font-size: 1.5rem; opacity: 0.8;"></i>
                        </div>

                        <!-- Track Info -->
                        <div style="flex: 1; min-width: 0;">
                            <h3
                                style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-1); font-size: 1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $item->title }}
                            </h3>
                            <div
                                style="display: flex; align-items: center; gap: var(--space-2); color: var(--gray-500); font-size: 0.875rem;">
                                @if($item->concert)
                                <span>{{ $item->concert->title }}</span>
                                @if($item->event_date)
                                <span>•</span>
                                @endif
                                @endif
                                @if($item->event_date)
                                <span>{{ $item->event_date->format('M Y') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Duration & Actions -->
                        <div style="display: flex; align-items: center; gap: var(--space-4); margin-left: auto;">
                            @if($item->is_featured)
                            <div
                                style="background: var(--warning); color: white; padding: var(--space-1) var(--space-2); border-radius: var(--radius); font-size: 0.75rem; font-weight: 600;">
                                <i class="fas fa-star" style="margin-right: var(--space-1);"></i>
                            </div>
                            @endif

                            <div
                                style="color: var(--gray-500); font-size: 0.875rem; min-width: 60px; text-align: right;">
                                {{ $item->duration_minutes ?? '3:45' }}
                            </div>

                            <button
                                style="width: 32px; height: 32px; background: none; border: none; color: var(--gray-400); cursor: pointer; border-radius: var(--radius); transition: var(--transition);"
                                onmouseover="this.style.background='var(--gray-100)'; this.style.color='var(--gray-600)'"
                                onmouseout="this.style.background='none'; this.style.color='var(--gray-400)'"
                                onclick="alert('More options for: {{ $item->title }}')">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <!-- Regular Grid Layout for Photos/Videos -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: var(--space-6);">
            @foreach($media as $item)
            <div class="card media-card" data-file-path="{{ $item->file_path }}" data-event-date="{{ $item->event_date }}"
                onclick="openMediaCard({{ json_encode($item) }})" style="cursor: pointer;">
                <!-- Media Preview -->
                @if($item->type === 'photo')
                <div style="position: relative; overflow: hidden;">
                    <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->title }}"
                        style="width: 100%; height: 250px; object-fit: cover; transition: var(--transition-slow);"
                        onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <div
                        style="position: absolute; top: var(--space-4); right: var(--space-4); background: rgba(0,0,0,0.7); color: white; padding: var(--space-2) var(--space-3); border-radius: var(--radius); font-size: 0.75rem; font-weight: 600;">
                        <i class="fas fa-camera" style="margin-right: var(--space-1);"></i>
                        PHOTO
                    </div>
                </div>
                @elseif($item->type === 'video')
                <div
                    style="position: relative; background: var(--gray-900); height: 250px; display: flex; align-items: center; justify-content: center;">
                    <div
                        style="position: absolute; inset: 0; background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%); opacity: 0.8;">
                    </div>
                    <div style="position: relative; z-index: 1; text-align: center; color: white;">
                        <i class="fas fa-play-circle"
                            style="font-size: 4rem; margin-bottom: var(--space-2); opacity: 0.9;"></i>
                        <div style="font-size: 0.875rem; font-weight: 600;">Click to Play Video</div>
                    </div>
                    <div
                        style="position: absolute; top: var(--space-4); right: var(--space-4); background: rgba(0,0,0,0.7); color: white; padding: var(--space-2) var(--space-3); border-radius: var(--radius); font-size: 0.75rem; font-weight: 600;">
                        <i class="fas fa-video" style="margin-right: var(--space-1);"></i>
                        VIDEO
                    </div>
                </div>
                @else
                <div
                    style="position: relative; background: linear-gradient(135deg, var(--success) 0%, var(--accent) 100%); height: 250px; display: flex; align-items: center; justify-content: center;">
                    <div style="text-align: center; color: white;">
                        <i class="fas fa-music"
                            style="font-size: 4rem; margin-bottom: var(--space-2); opacity: 0.9;"></i>
                        <div style="font-size: 0.875rem; font-weight: 600;">Click to Play Audio</div>
                    </div>
                    <div
                        style="position: absolute; top: var(--space-4); right: var(--space-4); background: rgba(0,0,0,0.7); color: white; padding: var(--space-2) var(--space-3); border-radius: var(--radius); font-size: 0.75rem; font-weight: 600;">
                        <i class="fas fa-music" style="margin-right: var(--space-1);"></i>
                        AUDIO
                    </div>
                </div>
                @endif

                <!-- Media Info -->
                <div class="card-body">
                    <h3
                        style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-2); line-height: 1.3;">
                        {{ $item->title }}
                    </h3>

                    @if($item->description)
                    <p
                        style="color: var(--gray-600); font-size: 0.875rem; line-height: 1.5; margin-bottom: var(--space-4);">
                        {{ Str::limit($item->description, 120) }}
                    </p>
                    @endif

                    <div
                        style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-4);">
                        @if($item->event_date)
                        <div
                            style="display: flex; align-items: center; gap: var(--space-2); color: var(--gray-500); font-size: 0.875rem;">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $item->event_date->format('M j, Y') }}</span>
                        </div>
                        @endif

                        @if($item->is_featured)
                        <div
                            style="background: var(--warning); color: white; padding: var(--space-1) var(--space-2); border-radius: var(--radius); font-size: 0.75rem; font-weight: 600;">
                            <i class="fas fa-star" style="margin-right: var(--space-1);"></i>
                            FEATURED
                        </div>
                        @endif
                    </div>

                    @if($item->concert)
                    <div
                        style="padding: var(--space-3); background: var(--gray-50); border-radius: var(--radius-lg); margin-bottom: var(--space-4);">
                        <div
                            style="font-size: 0.75rem; font-weight: 600; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-1);">
                            From Concert
                        </div>
                        <div style="font-weight: 600; color: var(--gray-900);">{{ $item->concert->title }}</div>
                    </div>
                    @endif
                </div>

                <!-- Media Actions -->
                <div class="card-footer">
                    @if($item->type === 'photo')
                    <button onclick="event.stopPropagation(); openPhotoFullscreen('{{ asset('storage/' . $item->file_path) }}', '{{ $item->title }}')" class="btn btn-primary"
                        style="width: 100%;">
                        <i class="fas fa-expand"></i>
                        View Full Size
                    </button>
                    @elseif($item->type === 'video')
                    <button onclick="event.stopPropagation(); openMediaPlayer({{ json_encode($item) }})" class="btn btn-primary"
                        style="width: 100%;">
                        <i class="fas fa-play"></i>
                        Play Video
                    </button>
                    @else
                    <button onclick="event.stopPropagation(); openMediaPlayer({{ json_encode($item) }})" class="btn btn-primary"
                        style="width: 100%;">
                        <i class="fas fa-play"></i>
                        Play Audio
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Pagination -->
        @if($media->hasPages())
        <div style="margin-top: var(--space-16); text-align: center;">
            {{ $media->links() }}
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div style="text-align: center; padding: var(--space-16) 0;">
            <i class="fas fa-images"
                style="font-size: 5rem; color: var(--gray-300); margin-bottom: var(--space-6);"></i>
            <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-700); margin-bottom: var(--space-4);">
                No Media Found
            </h3>
            <p
                style="color: var(--gray-500); margin-bottom: var(--space-8); max-width: 400px; margin-left: auto; margin-right: auto;">
                @if(request('type'))
                No {{ request('type') }} files are currently available.
                @else
                No media files are currently available.
                @endif
                Check back soon for new photos, videos, and audio recordings!
            </p>
            <a href="{{ route('media.index') }}" class="btn btn-secondary">
                <i class="fas fa-refresh"></i>
                View All Media
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Call to Action -->
<section class="section"
    style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white;">
    <div class="container" style="text-align: center;">
        <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: var(--space-6); color: white;">
            Experience Our Music Live
        </h2>
        <p
            style="font-size: 1.25rem; margin-bottom: var(--space-8); opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">
            While our media gives you a taste of our performances, nothing compares to experiencing
            our music live. Join us at our next concert!
        </p>
        <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('concerts.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-calendar"></i>
                View Upcoming Concerts
            </a>
            <a href="{{ route('contact.index') }}"
                style="display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-4) var(--space-8); font-weight: 600; text-decoration: none; border-radius: var(--radius-lg); transition: var(--transition); cursor: pointer; border: 2px solid white; color: white; background: transparent; font-size: 1rem;"
                onmouseover="this.style.background='white'; this.style.color='var(--primary)'"
                onmouseout="this.style.background='transparent'; this.style.color='white'">
                <i class="fas fa-envelope"></i>
                Contact Us
            </a>
        </div>
    </div>
</section>
@endsection

<!-- Media Player Modal -->
<div id="mediaPlayerModal" class="media-player-modal">
    <div class="media-player-content">
        <div class="media-player-header">
            <h3 id="modalTitle" class="modal-title">Media Player</h3>
            <div class="header-actions">
                <button class="btn btn-secondary btn-sm" onclick="toggleFullscreen()" title="Toggle Fullscreen (F)">
                    <i class="fas fa-expand"></i>
                    Fullscreen
                </button>
                <button class="close-btn" onclick="closeMediaPlayer()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="media-player-body">
            <!-- Loading State -->
            <div id="loadingState" class="loading-state" style="display: none;">
                <div class="loading-spinner"></div>
                <p>Loading media...</p>
            </div>

            <!-- Video Player -->
            <div id="videoPlayer" class="video-player" style="display: none;">
                <video id="videoElement" controls style="width: 100%; height: 100%;">
                    Your browser does not support the video tag.
                </video>
            </div>

            <!-- Audio Player -->
            <div id="audioPlayer" class="audio-player" style="display: none;">
                <div class="audio-info">
                    <div class="audio-cover">
                        <i class="fas fa-music"></i>
                    </div>
                    <h4 id="audioTitle" class="audio-title"></h4>
                    <p id="audioDescription" class="audio-description"></p>
                </div>
                <audio id="audioElement" controls style="width: 100%;">
                    Your browser does not support the audio element.
                </audio>
            </div>

            <!-- Error State -->
            <div id="errorState" class="error-state" style="display: none;">
                <i class="fas fa-exclamation-triangle"
                    style="font-size: 3rem; color: #ef4444; margin-bottom: 16px;"></i>
                <h4>Unable to load media</h4>
                <p id="errorMessage">The media file could not be loaded. Please try again later.</p>
                <button class="btn btn-primary" onclick="retryLoadMedia()">
                    <i class="fas fa-redo"></i>
                    Retry
                </button>
            </div>
        </div>

        <div class="media-player-footer">
            <div class="media-meta">
                <span id="mediaType" class="media-type-badge"></span>
                <span id="mediaDate" class="media-date"></span>
            </div>
            <div class="media-actions">
                <button class="btn btn-secondary" onclick="downloadMedia()">
                    <i class="fas fa-download"></i>
                    Download
                </button>
                <button class="btn btn-primary" onclick="shareMedia()">
                    <i class="fas fa-share"></i>
                    Share
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen Exit Button -->
<button class="fullscreen-exit-btn" id="fullscreenExitBtn" onclick="exitFullscreen()" style="display: none;" title="Exit Fullscreen (F)">
    <i class="fas fa-compress"></i>
    <span>Exit Fullscreen</span>
</button>

<!-- Fullscreen Exit Area (clickable top-left corner) -->
<div class="exit-area" id="exitArea" onclick="exitFullscreen()" style="display: none;" title="Click to exit fullscreen">
    <i class="fas fa-compress"></i>
</div>

<style>
    /* Media Player Modal Styles */
    .media-player-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .media-player-modal.active {
        display: flex;
    }

    .media-player-content {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        width: 90%;
        max-width: 800px;
        max-height: 90%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .media-player-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
        border-bottom: 1px solid #e5e7eb;
    }

    .header-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 0.875rem;
    }

    .modal-title {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #6b7280;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .close-btn:hover {
        color: #374151;
    }

    /* Fullscreen Exit Button */
    .fullscreen-exit-btn {
        position: fixed;
        top: 20px;
        right: 20px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        border: none;
        padding: 12px 16px;
        border-radius: 8px;
        cursor: pointer;
        z-index: 1001;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .fullscreen-exit-btn:hover {
        background: rgba(0, 0, 0, 0.9);
        transform: scale(1.05);
    }

    .fullscreen-exit-btn i {
        font-size: 1rem;
    }

    /* Fullscreen Exit Area */
    .exit-area {
        position: fixed;
        top: 20px;
        left: 20px;
        width: 60px;
        height: 60px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 1001;
        transition: all 0.2s ease;
    }

    .exit-area:hover {
        background: rgba(0, 0, 0, 0.9);
        transform: scale(1.1);
    }

    .exit-area i {
        font-size: 1.5rem;
    }

    .media-player-body {
        flex-grow: 1;
        padding: 16px;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Photo display in modal */
    .media-player-body img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Fullscreen photo optimization */
    .media-player-modal.fullscreen-mode .media-player-body img {
        max-width: 100vw;
        max-height: 100vh;
        object-fit: contain;
    }

    /* Loading and Error States */
    .loading-state,
    .error-state {
        text-align: center;
        color: #6b7280;
    }

    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #e5e7eb;
        border-top: 4px solid #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 16px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .error-state h4 {
        color: #111827;
        margin-bottom: 8px;
    }

    .error-state p {
        margin-bottom: 16px;
    }

    .video-player {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .audio-player {
        width: 100%;
        text-align: center;
    }

    .audio-info {
        margin-bottom: 24px;
    }

    .audio-cover {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        color: white;
        font-size: 3rem;
    }

    .audio-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 8px;
    }

    .audio-description {
        color: #6b7280;
        font-size: 1rem;
        margin-bottom: 0;
    }

    .media-player-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
    }

    .media-meta {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .media-type-badge {
        background: #3b82f6;
        color: white;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .media-date {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .media-actions {
        display: flex;
        gap: 12px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    /* Fullscreen Mode Styles */
    .media-player-modal.fullscreen-mode {
        background: rgba(0, 0, 0, 0.98);
    }

    .media-player-modal.fullscreen-mode .media-player-content {
        width: 100vw;
        height: 100vh;
        max-width: none;
        max-height: none;
        border-radius: 0;
        box-shadow: none;
    }

    .media-player-modal.fullscreen-mode .media-player-body {
        min-height: calc(100vh - 120px);
    }

    .media-player-modal.fullscreen-mode .media-player-body img {
        max-width: 100vw;
        max-height: 100vh;
        object-fit: contain;
    }

    .media-player-modal.fullscreen-mode .media-player-body video {
        max-width: 100vw;
        max-height: 100vh;
        object-fit: contain;
    }

    /* Native Fullscreen API Support */
    :fullscreen .media-player-modal,
    :-webkit-full-screen .media-player-modal,
    :-moz-full-screen .media-player-modal,
    :-ms-fullscreen .media-player-modal {
        background: rgba(0, 0, 0, 0.98);
    }

    :fullscreen .media-player-content,
    :-webkit-full-screen .media-player-content,
    :-moz-full-screen .media-player-content,
    :-ms-fullscreen .media-player-content {
        width: 100vw;
        height: 100vh;
        max-width: none;
        max-height: none;
        border-radius: 0;
        box-shadow: none;
    }

    :fullscreen .media-player-body,
    :-webkit-full-screen .media-player-body,
    :-moz-full-screen .media-player-body,
    :-ms-fullscreen .media-player-body {
        min-height: calc(100vh - 120px);
    }

    :fullscreen .media-player-body img,
    :-webkit-full-screen .media-player-body img,
    :-moz-full-screen .media-player-body img,
    :-ms-fullscreen .media-player-body img {
        max-width: 100vw;
        max-height: 100vh;
        object-fit: contain;
    }

    :fullscreen .media-player-body video,
    :-webkit-full-screen .media-player-body video,
    :-moz-full-screen .media-player-body video,
    :-ms-fullscreen .media-player-body video {
        max-width: 100vw;
        max-height: 100vh;
        object-fit: contain;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .media-player-content {
            width: 95%;
            max-width: none;
        }

        .media-player-header {
            padding: 12px;
        }

        .media-player-body {
            padding: 12px;
            min-height: 300px;
        }

        .media-player-footer {
            padding: 12px;
        }

        .fullscreen-exit-btn {
            top: 10px;
            right: 10px;
            padding: 8px 12px;
            font-size: 0.75rem;
        }

        .exit-area {
            top: 10px;
            left: 10px;
            width: 50px;
            height: 50px;
        }

        .exit-area i {
            font-size: 1.25rem;
        }
    }
</style>

<script>
    let currentMedia = null;

    // Function to open media player
    function openMediaPlayer(mediaItem) {
        if (!mediaItem) {
            console.warn('openMediaPlayer: No media item provided');
            return;
        }

        currentMedia = mediaItem;
        const modal = document.getElementById('mediaPlayerModal');
        const modalTitle = document.getElementById('modalTitle');
        const mediaType = document.getElementById('mediaType');
        const mediaDate = document.getElementById('mediaDate');
        const videoPlayer = document.getElementById('videoPlayer');
        const audioPlayer = document.getElementById('audioPlayer');
        const videoElement = document.getElementById('videoElement');
        const audioElement = document.getElementById('audioElement');
        const audioTitle = document.getElementById('audioTitle');
        const audioDescription = document.getElementById('audioDescription');
        const loadingState = document.getElementById('loadingState');
        const errorState = document.getElementById('errorState');

        // Check if all required elements exist
        if (!modal || !modalTitle || !mediaType || !mediaDate || !videoPlayer || !audioPlayer || !videoElement || !audioElement || !audioTitle || !audioDescription || !loadingState || !errorState) {
            console.error('openMediaPlayer: Required DOM elements not found');
            return;
        }

        // Set modal title and metadata
        modalTitle.textContent = mediaItem.title || 'Unknown Title';
        mediaType.textContent = (mediaItem.type || 'unknown').toUpperCase();
        mediaDate.textContent = mediaItem.event_date ? new Date(mediaItem.event_date).toLocaleDateString() : 'No date';

        // Show loading state first
        loadingState.style.display = 'block';
        videoPlayer.style.display = 'none';
        audioPlayer.style.display = 'none';
        errorState.style.display = 'none';

        // Show modal
        modal.classList.add('active');

        // Add keyboard event listener
        try {
            document.addEventListener('keydown', handleMediaPlayerKeys);
        } catch (error) {
            console.warn('Could not add keyboard event listener:', error);
        }

        // Load media based on type
        if (mediaItem.type === 'video') {
            loadVideo(mediaItem, videoElement, videoPlayer, loadingState, errorState);
        } else if (mediaItem.type === 'audio') {
            loadAudio(mediaItem, audioElement, audioPlayer, loadingState, errorState, audioTitle, audioDescription);
        }
    }

    // Function to load video
    function loadVideo(mediaItem, videoElement, videoPlayer, loadingState, errorState) {
        videoElement.src = '/storage/' + mediaItem.file_path;

        videoElement.addEventListener('loadeddata', function() {
            loadingState.style.display = 'none';
            videoPlayer.style.display = 'block';
        });

        videoElement.addEventListener('error', function() {
            loadingState.style.display = 'none';
            errorState.style.display = 'block';
            document.getElementById('errorMessage').textContent =
                'Unable to load video file. The file may be corrupted or in an unsupported format.';
        });

        videoElement.load();
    }

    // Function to load audio
    function loadAudio(mediaItem, audioElement, audioPlayer, loadingState, errorState, audioTitle, audioDescription) {
        audioTitle.textContent = mediaItem.title;
        audioDescription.textContent = mediaItem.description || 'No description available';
        audioElement.src = '/storage/' + mediaItem.file_path;

        audioElement.addEventListener('loadeddata', function() {
            loadingState.style.display = 'none';
            audioPlayer.style.display = 'block';
        });

        audioElement.addEventListener('error', function() {
            loadingState.style.display = 'none';
            errorState.style.display = 'block';
            document.getElementById('errorMessage').textContent =
                'Unable to load audio file. The file may be corrupted or in an unsupported format.';
        });

        audioElement.load();
    }

    // Function to retry loading media
    function retryLoadMedia() {
        if (currentMedia) {
            openMediaPlayer(currentMedia);
        }
    }

    // Function to close media player
    function closeMediaPlayer() {
        const modal = document.getElementById('mediaPlayerModal');
        const videoElement = document.getElementById('videoElement');
        const audioElement = document.getElementById('audioElement');

        // Pause and reset media
        if (videoElement) {
            videoElement.pause();
            videoElement.currentTime = 0;
        }
        if (audioElement) {
            audioElement.pause();
            audioElement.currentTime = 0;
        }

        // Hide modal
        modal.classList.remove('active');

        // Remove keyboard event listener
        document.removeEventListener('keydown', handleMediaPlayerKeys);

        // Reset current media
        currentMedia = null;
    }

    // Handle keyboard events
    function handleMediaPlayerKeys(event) {
        if (event.key === 'Escape') {
            closeMediaPlayer();
        }
    }

    // Download media function
    function downloadMedia() {
        if (currentMedia) {
            const link = document.createElement('a');
            link.href = '/storage/' + currentMedia.file_path;
            link.download = currentMedia.title + '.' + currentMedia.file_path.split('.').pop();
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    // Share media function
    function shareMedia() {
        if (currentMedia && navigator.share) {
            navigator.share({
                title: currentMedia.title,
                text: currentMedia.description || 'Check out this media from The Harmony Singers',
                url: window.location.href
            });
        } else {
            // Fallback: copy URL to clipboard
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Link copied to clipboard!');
            });
        }
    }

    // Toggle fullscreen function
    function toggleFullscreen() {
        const videoElement = document.getElementById('videoElement');
        const audioElement = document.getElementById('audioElement');
        const photoDisplay = document.querySelector('.photo-display');
        const modal = document.getElementById('mediaPlayerModal');
        const exitArea = document.getElementById('exitArea');
        const fullscreenExitBtn = document.getElementById('fullscreenExitBtn');
        const fullscreenBtn = document.querySelector('.header-actions .btn[onclick*="toggleFullscreen"] i');

        if (!document.fullscreenElement) {
            // Enter fullscreen mode
            if (videoElement && videoElement.style.display !== 'none') {
                // For videos, make the video element fullscreen
                videoElement.requestFullscreen().then(() => {
                    if (fullscreenBtn) {
                        fullscreenBtn.className = 'fas fa-compress';
                    }
                    exitArea.style.display = 'block';
                    fullscreenExitBtn.style.display = 'block';
                    document.addEventListener('keydown', handleFullscreenKeys);
                }).catch(err => {
                    console.error(`Error attempting to enable full-screen mode: ${err.message} (code: ${err.code})`);
                });
            } else if (audioElement && audioElement.style.display !== 'none') {
                // For audio, make the modal fullscreen
                modal.requestFullscreen().then(() => {
                    if (fullscreenBtn) {
                        fullscreenBtn.className = 'fas fa-compress';
                    }
                    exitArea.style.display = 'block';
                    fullscreenExitBtn.style.display = 'block';
                    document.addEventListener('keydown', handleFullscreenKeys);
                }).catch(err => {
                    console.error(`Error attempting to enable full-screen mode: ${err.message} (code: ${err.code})`);
                });
            } else if (photoDisplay) {
                // For photos, make the photo element fullscreen
                photoDisplay.requestFullscreen().then(() => {
                    if (fullscreenBtn) {
                        fullscreenBtn.className = 'fas fa-compress';
                    }
                    exitArea.style.display = 'block';
                    fullscreenExitBtn.style.display = 'block';
                    document.addEventListener('keydown', handleFullscreenKeys);
                }).catch(err => {
                    console.error(`Error attempting to enable full-screen mode: ${err.message} (code: ${err.code})`);
                });
            }
        } else {
            // Exit fullscreen mode
            exitFullscreen();
        }
    }

    // Handle fullscreen keyboard events
    function handleFullscreenKeys(event) {
        if (event.key === 'Escape' || event.key === 'F') {
            exitFullscreen();
        }
    }

    // Exit fullscreen function
    function exitFullscreen() {
        const modal = document.getElementById('mediaPlayerModal');
        const videoElement = document.getElementById('videoElement');
        const audioElement = document.getElementById('audioElement');
        const exitArea = document.getElementById('exitArea');
        const fullscreenExitBtn = document.getElementById('fullscreenExitBtn');
        const fullscreenBtn = document.querySelector('.header-actions .btn[onclick*="toggleFullscreen"] i');

        if (document.fullscreenElement) {
            document.exitFullscreen().then(() => {
                if (fullscreenBtn) {
                    fullscreenBtn.className = 'fas fa-expand';
                }
                exitArea.style.display = 'none';
                fullscreenExitBtn.style.display = 'none';
                document.removeEventListener('keydown', handleFullscreenKeys);
            }).catch(err => {
                console.error(`Error attempting to disable full-screen mode: ${err.message} (code: ${err.code})`);
            });
        }
    }

    // Function to open photo in fullscreen
    function openPhotoFullscreen(imageUrl, title) {
        const modal = document.getElementById('mediaPlayerModal');
        const modalTitle = document.getElementById('modalTitle');
        const mediaType = document.getElementById('mediaType');
        const mediaDate = document.getElementById('mediaDate');
        const videoPlayer = document.getElementById('videoPlayer');
        const audioPlayer = document.getElementById('audioPlayer');
        const loadingState = document.getElementById('loadingState');
        const errorState = document.getElementById('errorState');

        // Check if all required elements exist
        if (!modal || !modalTitle || !mediaType || !mediaDate || !videoPlayer || !audioPlayer || !loadingState || !errorState) {
            console.error('openPhotoFullscreen: Required DOM elements not found');
            return;
        }

        // Set modal title and metadata
        modalTitle.textContent = title;
        mediaType.textContent = 'PHOTO';
        mediaDate.textContent = 'No date';

        // Show loading state first
        loadingState.style.display = 'block';
        videoPlayer.style.display = 'none';
        audioPlayer.style.display = 'none';
        errorState.style.display = 'none';

        // Show modal
        modal.classList.add('active');

        // Add keyboard event listener
        try {
            document.addEventListener('keydown', handleMediaPlayerKeys);
        } catch (error) {
            console.warn('Could not add keyboard event listener:', error);
        }

        // Create photo display
        const photoContainer = document.createElement('div');
        photoContainer.className = 'photo-display';
        photoContainer.style.cssText = 'width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;';

        const photoElement = document.createElement('img');
        photoElement.src = imageUrl;
        photoElement.alt = title;
        photoElement.style.cssText = 'max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);';

        photoContainer.appendChild(photoElement);

        // Clear previous content and append photo
        const mediaPlayerBody = modal.querySelector('.media-player-body');
        mediaPlayerBody.innerHTML = '';
        mediaPlayerBody.appendChild(photoContainer);

        // Hide loading state and show photo
        loadingState.style.display = 'none';

        // Store current media info for fullscreen functionality
        currentMedia = {
            title: title,
            type: 'photo',
            file_path: imageUrl,
            description: '',
            event_date: null
        };
    }

    // Function to open media card (for clickable cards)
    function openMediaCard(mediaItem) {
        if (mediaItem.type === 'photo') {
            openPhotoFullscreen('/storage/' + mediaItem.file_path, mediaItem.title);
        } else {
            openMediaPlayer(mediaItem);
        }
    }

    // Handle browser fullscreen changes
    function handleFullscreenChange() {
        const modal = document.getElementById('mediaPlayerModal');
        const exitArea = document.getElementById('exitArea');
        const fullscreenExitBtn = document.getElementById('fullscreenExitBtn');
        const fullscreenBtn = document.querySelector('.header-actions .btn[onclick*="toggleFullscreen"] i');

        if (!document.fullscreenElement && !document.webkitFullscreenElement &&
            !document.mozFullScreenElement && !document.msFullscreenElement) {
            // Browser exited fullscreen, update UI state
            if (fullscreenBtn) {
                fullscreenBtn.className = 'fas fa-expand';
            }

            if (exitArea) {
                exitArea.style.display = 'none';
            }

            if (fullscreenExitBtn) {
                fullscreenExitBtn.style.display = 'none';
            }

            document.removeEventListener('keydown', handleFullscreenKeys);
        }
    }

    // Update click handlers for existing buttons
    document.addEventListener('DOMContentLoaded', function() {
        // Global error handler for media operations
        window.addEventListener('error', function(event) {
            if (event.error && event.error.message && event.error.message.includes('addEventListener')) {
                console.warn('Media player error prevented:', event.error.message);
                event.preventDefault();
                return false;
            }
        });

        // Listen for fullscreen changes to keep UI in sync
        document.addEventListener('fullscreenchange', handleFullscreenChange);
        document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
        document.addEventListener('mozfullscreenchange', handleFullscreenChange);
        document.addEventListener('MSFullscreenChange', handleFullscreenChange);

        // Close modal when clicking outside
        const mediaPlayerModal = document.getElementById('mediaPlayerModal');
        if (mediaPlayerModal) {
            mediaPlayerModal.addEventListener('click', function(event) {
                if (event.target === this) {
                    closeMediaPlayer();
                }
            });
        }

        // Add comprehensive error handling for all DOM operations
        try {
            // Update video play buttons
            const videoButtons = document.querySelectorAll('button[onclick*="Video player would open here"]');
            if (videoButtons && videoButtons.length > 0) {
                videoButtons.forEach(button => {
                    if (button) {
                        button.onclick = null;
                        button.addEventListener('click', function() {
                            const card = this.closest('.card');
                            if (card) {
                                const mediaData = {
                                    title: card.querySelector('h3')?.textContent || 'Unknown Title',
                                    type: 'video',
                                    file_path: card.dataset.filePath || '',
                                    description: card.querySelector('p')?.textContent || '',
                                    event_date: card.dataset.eventDate || null
                                };
                                openMediaPlayer(mediaData);
                            }
                        });
                    }
                });
            }

            // Update audio play buttons
            const audioButtons = document.querySelectorAll('button[onclick*="Audio player would open here"]');
            if (audioButtons && audioButtons.length > 0) {
                audioButtons.forEach(button => {
                    if (button) {
                        button.onclick = null;
                        button.addEventListener('click', function() {
                            const card = this.closest('.card');
                            if (card) {
                                const mediaData = {
                                    title: card.querySelector('h3')?.textContent || 'Unknown Title',
                                    type: 'audio',
                                    file_path: card.dataset.filePath || '',
                                    description: card.querySelector('p')?.textContent || '',
                                    event_date: card.dataset.eventDate || null
                                };
                                openMediaPlayer(mediaData);
                            }
                        });
                    }
                });
            }

            // Update audio list play buttons
            const audioListButtons = document.querySelectorAll('button[onclick*="alert(\'Playing:"]');
            if (audioListButtons && audioListButtons.length > 0) {
                audioListButtons.forEach(button => {
                    if (button) {
                        button.onclick = null;
                        button.addEventListener('click', function() {
                            const listItem = this.closest('div[style*="display: flex"]');
                            if (listItem) {
                                const mediaData = {
                                    title: listItem.querySelector('h3')?.textContent || 'Unknown Title',
                                    type: 'audio',
                                    file_path: listItem.dataset.filePath || '',
                                    description: '',
                                    event_date: listItem.dataset.eventDate || null
                                };
                                openMediaPlayer(mediaData);
                            }
                        });
                    }
                });
            }
        } catch (error) {
            console.warn('Media player initialization warning:', error);
        }
    });
</script>