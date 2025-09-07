@extends('layouts.admin')

@section('title', 'Albums')
@section('page-title', 'Media Albums')

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
                <h2 class="header-title">Media Albums Management</h2>
                <p class="header-subtitle">Organize your media into beautiful collections with ease</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $albums->total() }}</span>
                        <span class="stat-label">Total Albums</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $albums->where('is_featured', true)->count() }}</span>
                        <span class="stat-label">Featured</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $albums->where('type', 'photo')->count() }}</span>
                        <span class="stat-label">Photo Albums</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('create_albums')
            <a href="{{ route('admin.albums.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Add New Album</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
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

        <form method="GET" action="{{ route('admin.albums.index') }}" class="filters-form" id="filtersForm">
            <div class="filters-grid">
                <div class="search-group">
                    <div class="search-box enhanced-search">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search albums by name, description, or concert..."
                            class="search-input enhanced-input">
                        <div class="search-glow"></div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-item">
                        <label class="filter-label">Album Type</label>
                        <select name="type" class="filter-select enhanced-select">
                            <option value="">All Types</option>
                            <option value="photo" {{ request('type') === 'photo' ? 'selected' : '' }}>Photos</option>
                            <option value="video" {{ request('type') === 'video' ? 'selected' : '' }}>Videos</option>
                            <option value="audio" {{ request('type') === 'audio' ? 'selected' : '' }}>Audio</option>
                            <option value="mixed" {{ request('type') === 'mixed' ? 'selected' : '' }}>Mixed</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Featured Status</label>
                        <select name="featured" class="filter-select enhanced-select">
                            <option value="">All Albums</option>
                            <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Featured Only</option>
                            <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>Not Featured</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Visibility</label>
                        <select name="visibility" class="filter-select enhanced-select">
                            <option value="">All Albums</option>
                            <option value="1" {{ request('visibility') === '1' ? 'selected' : '' }}>Public</option>
                            <option value="0" {{ request('visibility') === '0' ? 'selected' : '' }}>Private</option>
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
                    <a href="{{ route('admin.albums.index') }}" class="btn btn-outline enhanced-btn clear-btn">
                        <div class="btn-content">
                            <i class="fas fa-times"></i>
                            <span>Clear All</span>
                        </div>
                        <div class="btn-glow"></div>
                    </a>
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
                Albums Collection
            </h3>
            <div class="header-meta">
                <span class="results-count">{{ $albums->count() }} of {{ $albums->total() }} albums</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($albums->count() > 0)
        <div class="table-container">
            <table class="data-table enhanced-table">
                <thead>
                    <tr class="table-header">
                        <th class="th-cover">Cover</th>
                        <th class="th-info">Album Information</th>
                        <th class="th-type">Type</th>
                        <th class="th-media">Media Items</th>
                        <th class="th-status">Status</th>
                        @permission('view_albums')
                        <th class="th-actions">Actions</th>
                        @endpermission
                    </tr>
                </thead>
                <tbody>
                    @foreach($albums as $album)
                    <tr class="album-row">
                        <td data-label="Cover" class="td-cover">
                            @if($album->cover_image_url)
                            <div class="album-cover enhanced-photo">
                                <img src="{{ $album->cover_image_url }}" alt="{{ $album->name }}">
                                <div class="cover-overlay"></div>
                            </div>
                            @else
                            <div class="album-cover-placeholder enhanced-placeholder">
                                <i class="fas fa-images"></i>
                                <div class="placeholder-glow"></div>
                            </div>
                            @endif
                        </td>

                        <td data-label="Album Information" class="td-info">
                            <div class="album-info enhanced-info">
                                <div class="album-name">{{ $album->name }}</div>
                                @if($album->description)
                                <div class="album-description">{{ Str::limit($album->description, 80) }}</div>
                                @endif
                                @if($album->concert)
                                <div class="album-concert">
                                    <i class="fas fa-calendar"></i>
                                    {{ $album->concert->title }}
                                </div>
                                @endif
                                @if($album->event_date)
                                <div class="album-event-date">
                                    <i class="fas fa-clock"></i>
                                    {{ $album->event_date->format('M j, Y') }}
                                </div>
                                @endif
                            </div>
                        </td>

                        <td data-label="Type" class="td-type">
                            <span class="type-badge enhanced-badge type-{{ $album->type }}">
                                <i class="fas fa-{{ $album->type === 'photo' ? 'image' : ($album->type === 'video' ? 'video' : ($album->type === 'audio' ? 'music' : 'layer-group')) }}"></i>
                                {{ ucfirst($album->type) }}
                            </span>
                        </td>

                        <td data-label="Media Items" class="td-media">
                            <div class="media-count">
                                <div class="count-icon">
                                    <i class="fas fa-images"></i>
                                </div>
                                <div class="count-text">
                                    <span class="count-number">{{ $album->media->count() }}</span>
                                    <span class="count-label">items</span>
                                </div>
                            </div>
                        </td>

                        <td data-label="Status" class="td-status">
                            <div class="status-indicators">
                                @if($album->is_featured)
                                <span class="status-badge enhanced-badge featured">
                                    <div class="status-dot"></div>
                                    Featured
                                </span>
                                @endif
                                <span class="status-badge enhanced-badge {{ $album->is_public ? 'public' : 'private' }}">
                                    <div class="status-dot"></div>
                                    {{ $album->is_public ? 'Public' : 'Private' }}
                                </span>
                            </div>
                        </td>

                        @permission('view_albums')
                        <td data-label="Actions" class="td-actions">
                            <div class="action-buttons enhanced-actions">
                                @permission('view_albums')
                                <a href="{{ route('admin.albums.show', $album) }}"
                                    class="btn btn-sm btn-secondary action-btn" title="View Album">
                                    <i class="fas fa-eye"></i>
                                    <span class="btn-tooltip">View</span>
                                </a>
                                @endpermission

                                @permission('edit_albums')
                                <a href="{{ route('admin.albums.edit', $album) }}"
                                    class="btn btn-sm btn-primary action-btn" title="Edit Album">
                                    <i class="fas fa-edit"></i>
                                    <span class="btn-tooltip">Edit</span>
                                </a>
                                @endpermission

                                @permission('upload_media')
                                <a href="{{ route('admin.media.create') }}?album_id={{ $album->id }}"
                                    class="btn btn-sm btn-info action-btn" title="Add Media">
                                    <i class="fas fa-plus"></i>
                                    <span class="btn-tooltip">Add Media</span>
                                </a>
                                @endpermission

                                @permission('delete_albums')
                                <form method="POST" action="{{ route('admin.albums.destroy', $album) }}" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger action-btn delete-btn"
                                        title="Delete Album"
                                        onclick="return confirm('Are you sure you want to delete this album? This action cannot be undone.')">
                                        <i class="fas fa-trash"></i>
                                        <span class="btn-tooltip">Delete</span>
                                    </button>
                                </form>
                                @endpermission
                            </div>
                        </td>
                        @endpermission
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-enhanced-pagination
            :paginator="$albums"
            :show-per-page-selector="true"
            :per-page-options="[5, 10, 20, 50, 100]"
            :show-page-info="true"
            :show-jump-to-page="true"
            :max-visible-pages="7" />
        @else
        <div class="empty-state enhanced-empty-state">
            <div class="empty-icon">
                <i class="fas fa-images"></i>
                <div class="icon-pulse"></div>
            </div>
            <h3>No Albums Found</h3>
            <p>Start organizing your media by creating your first album collection.</p>
            <div class="empty-actions">
                @permission('create_albums')
                <a href="{{ route('admin.albums.create') }}" class="btn btn-primary enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-plus"></i>
                        <span>Create Your First Album</span>
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
    });
</script>
@endpush