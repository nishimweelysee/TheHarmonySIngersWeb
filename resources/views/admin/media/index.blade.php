@extends('layouts.admin')

@section('title', 'Media Management')
@section('page-title', 'Media Management')

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
                <i class="fas fa-photo-video"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Media Management</h2>
                <p class="header-subtitle">Manage photos, videos, and audio files with ease</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $media->total() }}</span>
                        <span class="stat-label">Total Media</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $media->where('type', 'photo')->count() }}</span>
                        <span class="stat-label">Photos</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $media->where('type', 'video')->count() }}</span>
                        <span class="stat-label">Videos</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $media->where('type', 'audio')->count() }}</span>
                        <span class="stat-label">Audio</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('upload_media')
            <a href="{{ route('admin.media.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Add New Media</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission

            <!-- Slideshow Button -->
            <button class="btn btn-outline enhanced-btn" onclick="testSlideshow()" title="Start Photo Slideshow">
                <div class="btn-content">
                    <i class="fas fa-images"></i>
                    <span>Slideshow</span>
                </div>
                <div class="btn-glow"></div>
            </button>
        </div>
    </div>
</div>

<!-- Enhanced Search and Filters -->
<div class="search-filters-section">
    <div class="filters-card">
        <div class="filters-header">
            <h3 class="filters-title">
                <i class="fas fa-filter"></i>
                Search & Filters
            </h3>
            <div class="filters-toggle">
                <button class="toggle-btn" onclick="toggleFilters()">
                    <i class="fas fa-chevron-down"></i>
                    <span>Show Filters</span>
                </button>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.media.index') }}" class="filters-form" id="filtersForm">
            <div class="filters-grid">
                <div class="search-group">
                    <div class="search-box enhanced-search">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search media by title, description, or album..."
                            class="search-input enhanced-input">
                        <div class="search-glow"></div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-item">
                        <label class="filter-label">Media Type</label>
                        <select name="type" class="filter-select enhanced-select">
                            <option value="">All Types</option>
                            <option value="photo" {{ request('type') === 'photo' ? 'selected' : '' }}>Photos</option>
                            <option value="video" {{ request('type') === 'video' ? 'selected' : '' }}>Videos</option>
                            <option value="audio" {{ request('type') === 'audio' ? 'selected' : '' }}>Audio</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Album</label>
                        <select name="album" class="filter-select enhanced-select">
                            <option value="">All Albums</option>
                            @foreach($albums as $album)
                            <option value="{{ $album->id }}" {{ request('album') == $album->id ? 'selected' : '' }}>
                                {{ $album->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Featured Status</label>
                        <select name="featured" class="filter-select enhanced-select">
                            <option value="">All Media</option>
                            <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Featured Only</option>
                            <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>Not Featured</option>
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary enhanced-btn filter-btn">
                        <div class="btn-content">
                            <i class="fas fa-filter"></i>
                            <span>Apply Filters</span>
                        </div>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.media.index') }}" class="btn btn-outline enhanced-btn clear-btn">
                        <div class="btn-content">
                            <i class="fas fa-times"></i>
                            <span>Clear All</span>
                        </div>
                        <div class="btn-glow"></div>
                    </a>
                    @permission('view_media')
                    <button type="button" class="btn btn-info enhanced-btn" onclick="testSlideshow()">
                        <div class="btn-content">
                            <i class="fas fa-play"></i>
                            <span>Slideshow</span>
                        </div>
                        <div class="btn-glow"></div>
                    </button>
                    @endpermission
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Enhanced Content Card -->
<div class="content-card enhanced-card">
    <div class="card-header enhanced-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-list"></i>
                Media Collection
            </h3>
            <div class="header-meta">
                <span class="results-count">{{ $media->count() }} of {{ $media->total() }} media items</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($media->count() > 0)
        <div class="media-grid enhanced-media-grid">
            @foreach($media as $item)
            <div class="media-card enhanced-media-card" data-type="{{ $item->type }}" data-media-id="{{ $item->id }}">
                <div class="media-preview">
                    @if($item->type === 'photo' && $item->file_path)
                    <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->title }}" class="media-image"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="media-preview-fallback" style="display: none;">
                        <i class="fas fa-image fa-2x"></i>
                        <span class="media-type-label">Photo</span>
                    </div>
                    @elseif($item->type === 'photo')
                    <div class="media-preview-fallback">
                        <i class="fas fa-image fa-2x"></i>
                        <span class="media-type-label">Photo</span>
                    </div>
                    @elseif($item->type === 'video' && $item->file_path)
                    <video class="media-video" controls preload="metadata">
                        <source src="{{ asset('storage/' . $item->file_path) }}" type="video/mp4">
                        <source src="{{ asset('storage/' . $item->file_path) }}" type="video/webm">
                        <source src="{{ asset('storage/' . $item->file_path) }}" type="video/ogg">
                        Your browser does not support video playback.
                    </video>
                    @elseif($item->type === 'video')
                    <div class="media-preview-fallback">
                        <i class="fas fa-video fa-2x"></i>
                        <span class="media-type-label">Video</span>
                    </div>
                    @elseif($item->type === 'audio' && $item->file_path)
                    <audio class="media-audio" controls preload="metadata">
                        <source src="{{ asset('storage/' . $item->file_path) }}" type="audio/mpeg">
                        <source src="{{ asset('storage/' . $item->file_path) }}" type="audio/ogg">
                        <source src="{{ asset('storage/' . $item->file_path) }}" type="audio/wav">
                        Your browser does not support audio playback.
                    </audio>
                    @elseif($item->type === 'audio')
                    <div class="media-preview-fallback">
                        <i class="fas fa-music fa-2x"></i>
                        <span class="media-type-label">Audio</span>
                    </div>
                    @else
                    <div class="media-preview-fallback">
                        <i class="fas fa-file fa-2x"></i>
                        <span class="media-type-label">File</span>
                    </div>
                    @endif
                    <div class="media-overlay"></div>
                </div>

                <div class="media-info">
                    <h4 class="media-title">{{ $item->title ?: 'Untitled' }}</h4>
                    @if($item->description)
                    <p class="media-description">{{ Str::limit($item->description, 80) }}</p>
                    @endif
                    @if($item->concert)
                    <div class="media-concert">
                        <i class="fas fa-calendar"></i>
                        {{ $item->concert->title }}
                    </div>
                    @endif
                    <div class="media-date">
                        <i class="fas fa-clock"></i>
                        {{ $item->created_at->format('M j, Y') }}
                    </div>
                </div>

                <div class="media-actions">
                    @permission('view_media')
                    <a href="{{ route('admin.media.show', $item) }}" class="btn btn-sm btn-secondary action-btn"
                        title="View Media">
                        <i class="fas fa-eye"></i>
                        <span class="btn-tooltip">View</span>
                    </a>
                    @endpermission

                    <!-- Fullscreen Button for Media -->
                    <button class="btn btn-sm btn-outline action-btn fullscreen-btn" data-media-id="{{ $item->id }}"
                        data-media-type="{{ $item->type }}" data-file-path="{{ asset('storage/' . $item->file_path) }}"
                        data-title="{{ $item->title }}" data-description="{{ $item->description }}"
                        title="Fullscreen View">
                        <i class="fas fa-expand"></i>
                        <span class="btn-tooltip">Fullscreen</span>
                    </button>

                    @permission('edit_media')
                    <a href="{{ route('admin.media.edit', $item) }}" class="btn btn-sm btn-primary action-btn"
                        title="Edit Media">
                        <i class="fas fa-edit"></i>
                        <span class="btn-tooltip">Edit</span>
                    </a>
                    @endpermission

                    @permission('delete_media')
                    <form method="POST" action="{{ route('admin.media.destroy', $item) }}" class="inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger action-btn delete-btn" title="Delete Media"
                            onclick="return confirm('Are you sure you want to delete this media item? This action cannot be undone.')">
                            <i class="fas fa-trash"></i>
                            <span class="btn-tooltip">Delete</span>
                        </button>
                    </form>
                    @endpermission
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrapper enhanced-pagination">
            {{ $media->links() }}
        </div>
        @else
        <div class="empty-state enhanced-empty-state">
            <div class="empty-icon">
                <i class="fas fa-photo-video"></i>
                <div class="icon-pulse"></div>
            </div>
            <h3>No Media Found</h3>
            <p>Start by adding some photos, videos, or audio files to your collection.</p>
            <div class="empty-actions">
                @permission('upload_media')
                <a href="{{ route('admin.media.create') }}" class="btn btn-primary enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-plus"></i>
                        <span>Add First Media</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
                @endpermission
                <button class="btn btn-outline enhanced-btn refresh-btn" onclick="location.reload()">
                    <div class="btn-content">
                        <i class="fas fa-sync-alt"></i>
                        <span>Refresh</span>
                    </div>
                    <div class="btn-glow"></div>
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Slideshow Modal -->
<div id="slideshowModal" class="slideshow-modal">
    <div class="slideshow-content">
        <div class="slideshow-header">
            <h3 class="slideshow-title">Image Slideshow</h3>
            <div class="header-actions">
                <button class="btn btn-sm btn-secondary" onclick="toggleDescription()" title="Toggle Description (D)">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-secondary" onclick="toggleFullscreen()" title="Toggle Fullscreen (F)">
                    <i class="fas fa-expand"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="exitFullscreen()" title="Force Exit Fullscreen">
                    <i class="fas fa-compress"></i>
                </button>
                <button class="close-btn" onclick="closeSlideshow()" title="Close (Esc)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="slideshow-main">
            <button class="nav-btn prev-btn" onclick="previousSlide()">
                <i class="fas fa-chevron-left"></i>
            </button>

            <div class="slide-container">
                <div class="slide-loading" id="slideLoading">
                    <i class="fas fa-spinner fa-spin"></i>
                    <span>Loading...</span>
                </div>
                <img id="slideImage" src="" alt="" class="slide-image" style="display: none;">
                <div class="slide-info">
                    <h4 id="slideTitle" class="slide-title"></h4>
                    <p id="slideDescription" class="slide-description"></p>
                    <div class="slide-meta">
                        <span id="slideAlbum" class="slide-album"></span>
                        <span id="slideDate" class="slide-date"></span>
                    </div>
                </div>
            </div>

            <button class="nav-btn next-btn" onclick="nextSlide()">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <div class="slideshow-footer">
            <div class="slide-counter">
                <span id="currentSlide">1</span> of <span id="totalSlides">0</span>
            </div>
            <div class="slide-actions">
                <button class="btn btn-secondary" onclick="openMediaEdit()">
                    <i class="fas fa-edit"></i>
                    Edit
                </button>
                <button class="btn btn-primary" onclick="openMediaView()">
                    <i class="fas fa-external-link-alt"></i>
                    View Details
                </button>
            </div>
        </div>

        <!-- Navigation Help -->
        <div class="navigation-help">
            <div class="help-text">
                <span><i class="fas fa-keyboard"></i> Use arrow keys or click thumbnails to navigate</span>
                <span><i class="fas fa-eye"></i> Press D to toggle description</span>
                <span><i class="fas fa-expand"></i> Press F for fullscreen</span>
                <span><i class="fas fa-times"></i> Press Esc to close</span>
            </div>
        </div>

        <!-- Thumbnail Navigation -->
        <div class="thumbnail-navigation">
            <div class="thumbnail-container" id="thumbnailContainer">
                <!-- Thumbnails will be populated by JavaScript -->
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function toggleFilters() {
    const form = document.getElementById('filtersForm');
    const toggleBtn = document.querySelector('.toggle-btn');
    const icon = toggleBtn.querySelector('i');
    const text = toggleBtn.querySelector('span');

    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
        icon.className = 'fas fa-chevron-up';
        text.textContent = 'Hide Filters';
        toggleBtn.classList.add('active');
    } else {
        form.style.display = 'none';
        icon.className = 'fas fa-chevron-down';
        text.textContent = 'Show Filters';
        toggleBtn.classList.remove('active');
    }
}

// Initialize filters as hidden by default
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filtersForm');
    form.style.display = 'none';

    // Add event listeners for fullscreen buttons
    console.log('Setting up fullscreen button event listeners...');
    const fullscreenButtons = document.querySelectorAll('.fullscreen-btn');
    console.log('Found fullscreen buttons:', fullscreenButtons.length);

    fullscreenButtons.forEach((btn, index) => {
        console.log(`Button ${index}:`, {
            mediaId: btn.dataset.mediaId,
            mediaType: btn.dataset.mediaType,
            filePath: btn.dataset.filePath,
            title: btn.dataset.title,
            description: btn.dataset.description
        });

        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            console.log('Fullscreen button clicked!', {
                mediaId: this.dataset.mediaId,
                mediaType: this.dataset.mediaType,
                filePath: this.dataset.filePath,
                title: this.dataset.title,
                description: this.dataset.description
            });

            const mediaId = this.dataset.mediaId;
            const mediaType = this.dataset.mediaType;
            const filePath = this.dataset.filePath;
            const title = this.dataset.title;
            const description = this.dataset.description;

            if (!mediaId || !mediaType) {
                console.error('Missing required data attributes');
                alert('Error: Missing media information');
                return;
            }

            openMediaFullscreen(mediaId, mediaType, filePath, title, description);
        });
    });

    console.log('Fullscreen button setup complete');
});

// Slideshow functionality
let slideshowModal;
let slideshowMedia = [];
let currentSlideIndex = 0;

function testSlideshow() {
    // Get all media items from the new card layout (not just photos)
    const allMedia = Array.from(document.querySelectorAll('.enhanced-media-card')).map(card => {
        const mediaId = card.dataset.mediaId;
        const mediaType = card.dataset.type;
        const title = card.querySelector('.media-title')?.textContent || 'Untitled';
        const description = card.querySelector('.media-description')?.textContent || '';
        const date = card.querySelector('.media-date')?.textContent || '';
        const filePath = card.querySelector('.media-image')?.src ||
            card.querySelector('.media-video source')?.src ||
            card.querySelector('.media-audio source')?.src || '';

        return {
            id: mediaId,
            type: mediaType,
            title: title,
            description: description,
            date: date,
            filePath: filePath,
            element: card
        };
    });

    if (allMedia.length === 0) {
        alert('No media found to display in slideshow.');
        return;
    }

    slideshowMedia = allMedia;
    createSlideshowModal();
    showSlide(0);
    document.addEventListener('keydown', handleSlideshowKeydown);
}

function createSlideshowModal() {
    // Remove existing modal if any
    if (slideshowModal) {
        slideshowModal.remove();
    }

    slideshowModal = document.createElement('div');
    slideshowModal.className = 'slideshow-modal';
    slideshowModal.innerHTML = `
        <div class="slideshow-content">
            <div class="slideshow-header">
                <h3>Photo Slideshow</h3>
                <div class="slideshow-counter">
                    <span id="currentSlide">1</span> / <span id="totalSlides">${slideshowMedia.length}</span>
                </div>
                <button class="slideshow-close" onclick="closeSlideshow()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="slideshow-body">
                <div class="slideshow-controls">
                    <button class="slideshow-btn" onclick="previousSlide()">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="slideshow-btn" onclick="nextSlide()">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                
                <div class="slide-container">
                    <!-- Media content will be inserted here -->
                </div>
                
                <div class="slideshow-info">
                    <h4 id="slideTitle"></h4>
                    <p id="slideDescription"></p>
                    <p id="slideDate"></p>
                    <p id="slideAlbum"></p>
                </div>
            </div>
            
            <div class="slideshow-footer">
                <div class="slideshow-actions">
                    <button class="control-btn play-btn" onclick="toggleFullscreen()">
                        <i class="fas fa-expand"></i>
                        <span>Fullscreen</span>
                    </button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(slideshowModal);
    slideshowModal.style.display = 'block';
}

function showSlide(index) {
    if (index < 0 || index >= slideshowMedia.length) return;

    currentSlideIndex = index;
    const media = slideshowMedia[index];

    // Update slide content based on media type
    const slideContainer = slideshowModal.querySelector('.slide-container');
    const slideTitle = document.getElementById('slideTitle');
    const slideDescription = document.getElementById('slideDescription');
    const slideDate = document.getElementById('slideDate');
    const slideAlbum = document.getElementById('slideAlbum');
    const currentSlide = document.getElementById('currentSlide');
    const totalSlides = document.getElementById('totalSlides');

    // Check if elements exist before proceeding
    if (!slideContainer || !slideTitle || !slideDescription || !slideDate || !slideAlbum || !currentSlide || !
        totalSlides) {
        console.error('Required slideshow elements not found');
        return;
    }

    // Clear previous content
    slideContainer.innerHTML = '';

    // Create media content based on type
    let mediaContent = '';
    if (media.filePath) {
        switch (media.type) {
            case 'photo':
                mediaContent =
                    `<img src="${media.filePath}" alt="${media.title}" class="slide-image" style="display: block;">`;
                break;
            case 'video':
                mediaContent = `<video controls preload="metadata" class="slide-video">
                    <source src="${media.filePath}" type="video/mp4">
                    <source src="${media.filePath}" type="video/webm">
                    <source src="${media.filePath}" type="video/ogg">
                    Your browser does not support video playback.
                </video>`;
                break;
            case 'audio':
                mediaContent = `<audio controls preload="metadata" class="slide-audio">
                    <source src="${media.filePath}" type="audio/mpeg">
                    <source src="${media.filePath}" type="audio/ogg">
                    <source src="${media.filePath}" type="audio/wav">
                    Your browser does not support audio playback.
                </audio>`;
                break;
            default:
                mediaContent = `<div class="file-preview">
                    <i class="fas fa-file fa-3x"></i>
                    <p>File Type: ${media.type}</p>
                    <a href="${media.filePath}" target="_blank" class="btn btn-primary">Open File</a>
                </div>`;
        }
    } else {
        mediaContent = `<div class="no-file-available">
            <i class="fas fa-exclamation-triangle fa-3x"></i>
            <p>No file available</p>
        </div>`;
    }

    // Add media content to container
    slideContainer.innerHTML = mediaContent;

    // Update info
    slideTitle.textContent = media.title || 'Untitled';
    slideDescription.textContent = media.description || '';
    slideDate.textContent = media.date || '';

    // Try to get album info if available
    if (media.element) {
        const albumInfo = media.element.querySelector('.media-concert');
        if (albumInfo) {
            slideAlbum.textContent = albumInfo.textContent.trim();
        } else {
            slideAlbum.textContent = '';
        }
    } else {
        slideAlbum.textContent = '';
    }

    // Update counter
    currentSlide.textContent = index + 1;
    totalSlides.textContent = slideshowMedia.length;
}

function previousSlide() {
    if (currentSlideIndex > 0) {
        showSlide(currentSlideIndex - 1);
    } else {
        showSlide(slideshowMedia.length - 1); // Loop to last slide
    }
}

function nextSlide() {
    if (currentSlideIndex < slideshowMedia.length - 1) {
        showSlide(currentSlideIndex + 1);
    } else {
        showSlide(0); // Loop to first slide
    }
}

function closeSlideshow() {
    if (slideshowModal) {
        slideshowModal.style.display = 'none';
        document.removeEventListener('keydown', handleSlideshowKeydown);
    }
}

function handleSlideshowKeydown(event) {
    switch (event.key) {
        case 'ArrowLeft':
            previousSlide();
            break;
        case 'ArrowRight':
            nextSlide();
            break;
        case 'Escape':
            closeSlideshow();
            break;
    }
}

function toggleFullscreen() {
    if (!document.fullscreenElement) {
        if (slideshowModal.requestFullscreen) {
            slideshowModal.requestFullscreen();
        } else if (slideshowModal.webkitRequestFullscreen) {
            slideshowModal.webkitRequestFullscreen();
        } else if (slideshowModal.msRequestFullscreen) {
            slideshowModal.msRequestFullscreen();
        }
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}

// Function to open individual media in fullscreen
function openMediaFullscreen(mediaId, mediaType, filePath, title, description) {
    console.log('openMediaFullscreen called with:', {
        mediaId,
        mediaType,
        filePath,
        title,
        description
    });

    // Create fullscreen modal
    const fullscreenModal = document.createElement('div');
    fullscreenModal.className = 'fullscreen-modal';
    fullscreenModal.innerHTML = `
        <div class="fullscreen-content">
            <div class="fullscreen-header">
                <h3>${title}</h3>
                <div class="fullscreen-actions">
                    <button class="btn btn-sm btn-secondary" onclick="toggleFullscreenView()" title="Toggle Fullscreen (F)">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="close-btn" onclick="closeFullscreenView()" title="Close (Esc)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <div class="fullscreen-body">
                <div class="fullscreen-media">
                    ${getMediaHTML(mediaType, filePath, title)}
                </div>
                
                <div class="fullscreen-info">
                    <h4>${title}</h4>
                    <p>${description || 'No description available'}</p>
                </div>
            </div>
            
            <div class="fullscreen-footer">
                <div class="fullscreen-controls">
                    <button class="btn btn-outline" onclick="downloadMedia('${filePath}')">
                        <i class="fas fa-download"></i>
                        Download
                    </button>
                </div>
            </div>
        </div>
    `;

    console.log('Fullscreen modal created, adding to DOM...');
    document.body.appendChild(fullscreenModal);
    fullscreenModal.style.display = 'block';
    console.log('Fullscreen modal should now be visible');

    // Add keyboard event listener
    document.addEventListener('keydown', handleFullscreenKeydown);

    // Store reference for cleanup
    window.currentFullscreenModal = fullscreenModal;
}

// Helper function to get media HTML based on type
function getMediaHTML(type, filePath, title) {
    if (!filePath) {
        return `<div class="no-file-available">
            <i class="fas fa-exclamation-triangle fa-3x"></i>
            <p>No file available</p>
        </div>`;
    }

    switch (type) {
        case 'photo':
            return `<img src="${filePath}" alt="${title}" class="fullscreen-image">`;
        case 'video':
            return `<video controls preload="metadata" class="fullscreen-video">
                <source src="${filePath}" type="video/mp4">
                <source src="${filePath}" type="video/webm">
                <source src="${filePath}" type="video/ogg">
                Your browser does not support video playback.
            </video>`;
        case 'audio':
            return `<audio controls preload="metadata" class="fullscreen-audio">
                <source src="${filePath}" type="audio/mpeg">
                <source src="${filePath}" type="audio/ogg">
                <source src="${filePath}" type="audio/wav">
                Your browser does not support audio playback.
            </audio>`;
        default:
            return `<div class="file-preview">
                <i class="fas fa-file fa-3x"></i>
                <p>File Type: ${type}</p>
                <a href="${filePath}" target="_blank" class="btn btn-primary">Open File</a>
            </div>`;
    }
}

// Function to close fullscreen view
function closeFullscreenView() {
    if (window.currentFullscreenModal) {
        window.currentFullscreenModal.remove();
        window.currentFullscreenModal = null;
        document.removeEventListener('keydown', handleFullscreenKeydown);
    }
}

// Function to toggle fullscreen view
function toggleFullscreenView() {
    if (!document.fullscreenElement) {
        if (window.currentFullscreenModal.requestFullscreen) {
            window.currentFullscreenModal.requestFullscreen();
        } else if (window.currentFullscreenModal.webkitRequestFullscreen) {
            window.currentFullscreenModal.webkitRequestFullscreen();
        } else if (window.currentFullscreenModal.msRequestFullscreen) {
            window.currentFullscreenModal.msRequestFullscreen();
        }
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}

// Function to handle fullscreen keyboard events
function handleFullscreenKeydown(event) {
    switch (event.key) {
        case 'Escape':
            closeFullscreenView();
            break;
        case 'f':
        case 'F':
            toggleFullscreenView();
            break;
    }
}

// Function to download media
function downloadMedia(filePath) {
    if (filePath) {
        const link = document.createElement('a');
        link.href = filePath;
        link.download = filePath.split('/').pop();
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}
</script>
@endpush

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