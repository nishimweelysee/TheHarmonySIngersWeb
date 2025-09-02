@extends('layouts.admin')

@section('title', 'Album Details')
@section('page-title', 'Album Details')

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
                <i class="fas fa-images"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">{{ $album->name }}</h2>
                <p class="header-subtitle">{{ $album->description ?: 'Album Details & Media Collection' }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-tag"></i>
                        </span>
                        <span class="stat-label">{{ ucfirst($album->type) }} Album</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $album->media->count() }}</span>
                        <span class="stat-label">Media Items</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-calendar"></i>
                        </span>
                        <span class="stat-label">{{ $album->created_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('edit_albums')
            <a href="{{ route('admin.albums.edit', $album) }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-edit"></i>
                    <span>Edit Album</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
            @permission('upload_media')
            <a href="{{ route('admin.media.create') }}?album_id={{ $album->id }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Add Media</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
            <a href="{{ route('admin.albums.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Albums</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Album Details -->
<div class="album-details enhanced-details">
    <div class="details-grid enhanced-grid">
        <!-- Album Information -->
        <div class="detail-card enhanced-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Album Information
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
                            <span class="info-label">Album Name</span>
                            <span class="info-value">{{ $album->name }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Type</span>
                            <span class="info-value">
                                <span class="type-badge enhanced-badge type-{{ $album->type }}">
                                    <i class="fas fa-{{ $album->type === 'photo' ? 'image' : ($album->type === 'video' ? 'video' : ($album->type === 'audio' ? 'music' : 'layer-group')) }}"></i>
                                    {{ ucfirst($album->type) }}
                                </span>
                            </span>
                        </div>
                    </div>

                    @if($album->description)
                    <div class="info-item enhanced-item full-width">
                        <div class="info-icon">
                            <i class="fas fa-align-left"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Description</span>
                            <span class="info-value">{{ $album->description }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Media Count</span>
                            <span class="info-value">{{ $album->media->count() }} items</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Album Status -->
        <div class="detail-card enhanced-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-cog"></i>
                        Album Status
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
                                <span class="status-badge enhanced-badge {{ $album->is_featured ? 'success' : 'secondary' }}">
                                    <div class="status-dot"></div>
                                    {{ $album->is_featured ? 'Yes' : 'No' }}
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
                                <span class="status-badge enhanced-badge {{ $album->is_public ? 'success' : 'warning' }}">
                                    <div class="status-dot"></div>
                                    {{ $album->is_public ? 'Public' : 'Private' }}
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
                            <span class="info-value">{{ $album->sort_order ?? 0 }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Created</span>
                            <span class="info-value">{{ $album->created_at->format('M j, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Associations -->
        @if($album->concert || $album->event_date)
        <div class="detail-card enhanced-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-link"></i>
                        Associations
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Related Events
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    @if($album->concert)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Related Concert</span>
                            <span class="info-value">
                                <a href="{{ route('admin.concerts.show', $album->concert) }}" class="link-enhanced">
                                    {{ $album->concert->title }}
                                </a>
                            </span>
                        </div>
                    </div>
                    @endif
                    @if($album->event_date)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Event Date</span>
                            <span class="info-value">{{ $album->event_date->format('F j, Y') }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Cover Image -->
        @if($album->cover_image_url)
        <div class="detail-card enhanced-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-image"></i>
                        Cover Image
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Album Cover
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="cover-image-display">
                    <img src="{{ $album->cover_image_url }}" alt="{{ $album->name }} Cover" class="album-cover-image" style="max-width: 200px; max-height: 200px; width: auto; height: auto; object-fit: cover;">
                    <div class="cover-actions">
                        <a href="{{ $album->cover_image_url }}" target="_blank" class="btn btn-sm btn-outline enhanced-btn">
                            <i class="fas fa-eye"></i>
                            <span>View Full Size</span>
                        </a>
                        <a href="{{ $album->cover_image_url }}" download class="btn btn-sm btn-outline enhanced-btn">
                            <i class="fas fa-download"></i>
                            <span>Download</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Media Collection -->
<div class="media-collection enhanced-section">
    <div class="content-card enhanced-card">
        <div class="card-header enhanced-header">
            <div class="header-content">
                <h3 class="card-title">
                    <i class="fas fa-images"></i>
                    Media Collection
                </h3>
                <div class="header-meta">
                    <span class="media-count">{{ $album->media->count() }} items</span>
                </div>
            </div>
        </div>

        <div class="card-content">
            @if($album->media->count() > 0)
            <div class="media-grid enhanced-media-grid">
                @foreach($album->media as $media)
                <div class="media-item enhanced-media-item">
                    <div class="media-preview">
                        @if($media->type === 'photo' && $media->file_path)
                        <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->title }}" class="media-image">
                        @elseif($media->type === 'photo')
                        <div class="photo-preview">
                            <i class="fas fa-image fa-3x"></i>
                            <span class="media-type-label">Photo</span>
                        </div>
                        @elseif($media->type === 'video' && $media->file_path)
                        <div class="video-preview">
                            <video class="media-video" controls preload="metadata">
                                <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                                <source src="{{ asset('storage/' . $media->file_path) }}" type="video/webm">
                                <source src="{{ asset('storage/' . $media->file_path) }}" type="video/ogg">
                                Your browser does not support video playback.
                            </video>
                        </div>
                        @elseif($media->type === 'video')
                        <div class="video-preview">
                            <i class="fas fa-video fa-3x"></i>
                            <span class="media-type-label">Video</span>
                        </div>
                        @elseif($media->type === 'audio' && $media->file_path)
                        <div class="audio-preview">
                            <audio class="media-audio" controls preload="metadata">
                                <source src="{{ asset('storage/' . $media->file_path) }}" type="audio/mpeg">
                                <source src="{{ asset('storage/' . $media->file_path) }}" type="audio/ogg">
                                <source src="{{ asset('storage/' . $media->file_path) }}" type="audio/wav">
                                Your browser does not support audio playback.
                            </audio>
                        </div>
                        @elseif($media->type === 'audio')
                        <div class="audio-preview">
                            <i class="fas fa-music fa-3x"></i>
                            <span class="media-type-label">Audio</span>
                        </div>
                        @else
                        <div class="file-preview">
                            <i class="fas fa-file fa-3x"></i>
                            <span class="media-type-label">File</span>
                        </div>
                        @endif
                    </div>
                    <div class="media-info">
                        <h4 class="media-title">{{ $media->title ?: 'Untitled' }}</h4>
                        @if($media->description)
                        <p class="media-description">{{ Str::limit($media->description, 100) }}</p>
                        @endif
                        <div class="media-meta">
                            <span class="meta-item">
                                <i class="fas fa-calendar"></i>
                                {{ $media->created_at->format('M j, Y') }}
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-file"></i>
                                {{ $media->file_size_formatted ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                    <div class="media-actions">
                        @if($media->type === 'photo' && $media->file_path)
                        <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" class="btn btn-sm btn-primary enhanced-btn">
                            <i class="fas fa-eye"></i>
                            <span>View</span>
                        </a>
                        @elseif($media->type === 'video' && $media->file_path)
                        <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" class="btn btn-sm btn-primary enhanced-btn">
                            <i class="fas fa-play"></i>
                            <span>Play</span>
                        </a>
                        @elseif($media->type === 'audio' && $media->file_path)
                        <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" class="btn btn-sm btn-primary enhanced-btn">
                            <i class="fas fa-play"></i>
                            <span>Play</span>
                        </a>
                        @endif
                        @if($media->file_path)
                        <a href="{{ asset('storage/' . $media->file_path) }}" download class="btn btn-sm btn-outline enhanced-btn">
                            <i class="fas fa-download"></i>
                            <span>Download</span>
                        </a>
                        @endif
                        @permission('edit_media')
                        <a href="{{ route('admin.media.edit', $media) }}" class="btn btn-sm btn-outline enhanced-btn">
                            <i class="fas fa-edit"></i>
                            <span>Edit</span>
                        </a>
                        @endpermission
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state enhanced-empty-state">
                <div class="empty-icon">
                    <i class="fas fa-images"></i>
                    <div class="icon-pulse"></div>
                </div>
                <h3>No Media Items</h3>
                <p>This album doesn't have any media items yet. Start building your collection!</p>
                <div class="empty-actions">
                    @permission('upload_media')
                    <a href="{{ route('admin.media.create') }}?album_id={{ $album->id }}" class="btn btn-primary enhanced-btn">
                        <div class="btn-content">
                            <i class="fas fa-plus"></i>
                            <span>Add First Media Item</span>
                        </div>
                        <div class="btn-glow"></div>
                    </a>
                    @endpermission
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

<script>
    // Ensure videos maintain proper fitting after loading
    document.addEventListener('DOMContentLoaded', function() {
        const videos = document.querySelectorAll('.media-video');

        videos.forEach(video => {
            // Force video sizing after load
            video.addEventListener('loadedmetadata', function() {
                this.style.width = '100%';
                this.style.height = '100%';
                this.style.objectFit = 'cover';
            });

            // Force video sizing after play
            video.addEventListener('play', function() {
                this.style.width = '100%';
                this.style.height = '100%';
                this.style.objectFit = 'cover';
            });

            // Force video sizing after pause
            video.addEventListener('pause', function() {
                this.style.width = '100%';
                this.style.height = '100%';
                this.style.objectFit = 'cover';
            });

            // Force video sizing after seeking
            video.addEventListener('seeked', function() {
                this.style.width = '100%';
                this.style.height = '100%';
                this.style.objectFit = 'cover';
            });

            // Force video sizing after time update
            video.addEventListener('timeupdate', function() {
                this.style.width = '100%';
                this.style.height = '100%';
                this.style.objectFit = 'cover';
            });
        });

        // Also handle window resize
        window.addEventListener('resize', function() {
            videos.forEach(video => {
                video.style.width = '100%';
                video.style.height = '100%';
                video.style.objectFit = 'cover';
            });
        });
    });
</script>