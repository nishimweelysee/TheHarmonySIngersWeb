@extends('layouts.admin')

@section('title', 'Media Details')
@section('page-title', 'Media Details')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-{{ $media->type === 'photo' ? 'image' : ($media->type === 'video' ? 'video' : 'music') }}"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">{{ $media->title ?: 'Untitled Media' }}</h2>
                <p class="header-subtitle">{{ $media->description ?: 'Media Details & Information' }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-tag"></i>
                        </span>
                        <span class="stat-label">{{ ucfirst($media->type) }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-images"></i>
                        </span>
                        <span class="stat-label">{{ $media->album ? $media->album->name : 'No Album' }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-calendar"></i>
                        </span>
                        <span class="stat-label">{{ $media->created_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <!-- Navigation Controls -->
            @if($previousMedia)
            <a href="{{ route('admin.media.show', $previousMedia) }}" class="btn btn-outline enhanced-btn" title="Previous Media">
                <div class="btn-content">
                    <i class="fas fa-chevron-left"></i>
                    <span>Previous</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endif

            @if($nextMedia)
            <a href="{{ route('admin.media.show', $nextMedia) }}" class="btn btn-outline enhanced-btn" title="Next Media">
                <div class="btn-content">
                    <i class="fas fa-chevron-right"></i>
                    <span>Next</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endif

            @permission('edit_media')
            <a href="{{ route('admin.media.edit', $media) }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-edit"></i>
                    <span>Edit Media</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
            <a href="{{ route('admin.media.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Media</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Media Details -->
<div class="media-details enhanced-details">
    <div class="details-grid enhanced-grid">
        <!-- Media Information -->
        <div class="detail-card enhanced-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Media Information
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Basic Details
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-heading"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Title</span>
                            <span class="info-value">{{ $media->title ?: 'Untitled' }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Type</span>
                            <span class="info-value">
                                <span class="type-badge enhanced-badge type-{{ $media->type }}">
                                    <i class="fas fa-{{ $media->type === 'photo' ? 'image' : ($media->type === 'video' ? 'video' : 'music') }}"></i>
                                    {{ ucfirst($media->type) }}
                                </span>
                            </span>
                        </div>
                    </div>

                    @if($media->description)
                    <div class="info-item enhanced-item full-width">
                        <div class="info-icon">
                            <i class="fas fa-align-left"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Description</span>
                            <span class="info-value">{{ $media->description }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Created</span>
                            <span class="info-value">{{ $media->created_at->format('M j, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Media Status -->
        <div class="detail-card enhanced-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-cog"></i>
                        Media Status
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Settings
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Featured</span>
                            <span class="info-value">
                                <span class="status-badge enhanced-badge {{ $media->is_featured ? 'success' : 'secondary' }}">
                                    <div class="status-dot"></div>
                                    {{ $media->is_featured ? 'Yes' : 'No' }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Visibility</span>
                            <span class="info-value">
                                <span class="status-badge enhanced-badge {{ $media->is_public ? 'success' : 'warning' }}">
                                    <div class="status-dot"></div>
                                    {{ $media->is_public ? 'Public' : 'Private' }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-sort"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Sort Order</span>
                            <span class="info-value">{{ $media->sort_order ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Album Association -->
        @if($media->album)
        <div class="detail-card enhanced-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-images"></i>
                        Album Association
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Collection
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Album Name</span>
                            <span class="info-value">
                                <a href="{{ route('admin.albums.show', $media->album) }}" class="link-enhanced">
                                    {{ $media->album->name }}
                                </a>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Album Type</span>
                            <span class="info-value">
                                <span class="type-badge enhanced-badge type-{{ $media->album->type }}">
                                    <i class="fas fa-{{ $media->album->type === 'photo' ? 'image' : ($media->album->type === 'video' ? 'video' : ($media->album->type === 'audio' ? 'music' : 'layer-group')) }}"></i>
                                    {{ ucfirst($media->album->type) }}
                                </span>
                            </span>
                        </div>
                    </div>

                    @if($media->album->concert)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Related Concert</span>
                            <span class="info-value">
                                <a href="{{ route('admin.concerts.show', $media->album->concert) }}" class="link-enhanced">
                                    {{ $media->album->concert->title }}
                                </a>
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- File Information -->
        <div class="detail-card enhanced-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-file"></i>
                        File Information
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Technical Details
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">File Name</span>
                            <span class="info-value">{{ basename($media->file_path) }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">File Type</span>
                            <span class="info-value">{{ strtoupper(pathinfo($media->file_path, PATHINFO_EXTENSION)) }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-weight"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">File Size</span>
                            <span class="info-value">{{ $media->file_size_formatted ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Uploaded</span>
                            <span class="info-value">{{ $media->created_at->format('M j, Y \a\t g:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Media Preview Section -->
<div class="media-preview-section enhanced-section">
    <div class="content-card enhanced-card">
        <div class="card-header enhanced-header">
            <div class="header-content">
                <h3 class="card-title">
                    <i class="fas fa-eye"></i>
                    Media Preview
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    View & Download
                </div>
            </div>
        </div>

        <div class="card-content">
            <div class="media-preview-container">
                @if($media->type === 'photo')
                <div class="photo-preview enhanced-photo-preview">
                    <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->title }}" class="preview-image">
                    <div class="preview-overlay">
                        <div class="preview-actions">
                            <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" class="btn btn-primary enhanced-btn">
                                <i class="fas fa-expand"></i>
                                <span>View Full Size</span>
                            </a>
                            <a href="{{ asset('storage/' . $media->file_path) }}" download class="btn btn-outline enhanced-btn">
                                <i class="fas fa-download"></i>
                                <span>Download</span>
                            </a>
                        </div>
                    </div>
                </div>
                @elseif($media->type === 'video')
                <div class="video-preview enhanced-video-preview">
                    @if($media->file_path)
                    <video class="video-player" controls preload="metadata" style="max-width: 100%; height: auto; border-radius: 12px;">
                        <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                        <source src="{{ asset('storage/' . $media->file_path) }}" type="video/webm">
                        <source src="{{ asset('storage/' . $media->file_path) }}" type="video/ogg">
                        Your browser does not support video playback.
                    </video>
                    @else
                    <div class="video-placeholder">
                        <i class="fas fa-video fa-4x"></i>
                        <span class="video-label">Video File</span>
                        <p class="video-description">No video file available</p>
                    </div>
                    @endif
                    <div class="video-actions">
                        @if($media->file_path)
                        <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" class="btn btn-primary enhanced-btn">
                            <i class="fas fa-play"></i>
                            <span>Play Video</span>
                        </a>
                        <a href="{{ asset('storage/' . $media->file_path) }}" download class="btn btn-outline enhanced-btn">
                            <i class="fas fa-download"></i>
                            <span>Download</span>
                        </a>
                        @else
                        <span class="text-muted">No file available</span>
                        @endif
                    </div>
                </div>
                @elseif($media->type === 'audio')
                <div class="audio-preview enhanced-audio-preview">
                    @if($media->file_path)
                    <audio class="audio-player" controls preload="metadata" style="width: 100%; max-width: 400px;">
                        <source src="{{ asset('storage/' . $media->file_path) }}" type="audio/mpeg">
                        <source src="{{ asset('storage/' . $media->file_path) }}" type="audio/ogg">
                        <source src="{{ asset('storage/' . $media->file_path) }}" type="audio/wav">
                        Your browser does not support audio playback.
                    </audio>
                    @else
                    <div class="audio-placeholder">
                        <i class="fas fa-music fa-4x"></i>
                        <span class="audio-label">Audio File</span>
                        <p class="audio-description">No audio file available</p>
                    </div>
                    @endif
                    <div class="audio-actions">
                        @if($media->file_path)
                        <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" class="btn btn-primary enhanced-btn">
                            <i class="fas fa-play"></i>
                            <span>Play Audio</span>
                        </a>
                        <a href="{{ asset('storage/' . $media->file_path) }}" download class="btn btn-outline enhanced-btn">
                            <i class="fas fa-download"></i>
                            <span>Download</span>
                        </a>
                        @else
                        <span class="text-muted">No file available</span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Keyboard navigation for media items
    document.addEventListener('DOMContentLoaded', function() {
        // Get navigation URLs from data attributes
        const previousUrl = '{{ $previousMedia ? route("admin.media.show", $previousMedia) : "" }}';
        const nextUrl = '{{ $nextMedia ? route("admin.media.show", $nextMedia) : "" }}';
        const indexUrl = '{{ route("admin.media.index") }}';

        document.addEventListener('keydown', function(event) {
            switch (event.key) {
                case 'ArrowLeft':
                    // Navigate to previous media if available
                    if (previousUrl) {
                        window.location.href = previousUrl;
                    }
                    break;
                case 'ArrowRight':
                    // Navigate to next media if available
                    if (nextUrl) {
                        window.location.href = nextUrl;
                    }
                    break;
                case 'Escape':
                    // Go back to media index
                    window.location.href = indexUrl;
                    break;
            }
        });

        // Show keyboard navigation help
        console.log('Keyboard Navigation:');
        console.log('- Left Arrow: Previous Media');
        console.log('- Right Arrow: Next Media');
        console.log('- Escape: Back to Media List');
    });
</script>
@endpush