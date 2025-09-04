@extends('layouts.admin')

@section('title', 'Songs')
@section('page-title', 'Manage Songs')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header songs-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-music"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Songs Management</h2>
                <p class="header-subtitle">Manage choir repertoire and musical pieces with precision</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $songs->total() }}</span>
                        <span class="stat-label">Total Songs</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $songs->where('genre', 'classical')->count() }}</span>
                        <span class="stat-label">Classical</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $songs->where('genre', 'gospel')->count() }}</span>
                        <span class="stat-label">Gospel</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('create_songs')
            <a href="{{ route('admin.songs.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Add New Song</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission

            <!-- Export Actions -->
            <div class="export-actions">
                <a href="{{ route('admin.songs.export.excel', request()->query()) }}"
                    class="btn btn-success enhanced-btn"
                    title="Export to Excel">
                    <div class="btn-content">
                        <i class="fas fa-file-excel"></i>
                        <span>Excel</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>

                <a href="{{ route('admin.songs.export.pdf', request()->query()) }}"
                    class="btn btn-danger enhanced-btn"
                    title="Export to PDF">
                    <div class="btn-content">
                        <i class="fas fa-file-pdf"></i>
                        <span>PDF</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
            </div>
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
                <button class="toggle-btn" onclick="toggleSongFilters()">
                    <i class="fas fa-chevron-down"></i>
                    <span>Show Filters</span>
                </button>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.songs.index') }}" class="filters-form" id="songFiltersForm">
            <div class="filters-grid">
                <div class="search-group">
                    <div class="search-box enhanced-search">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search songs by title, description, or composer..."
                            class="search-input enhanced-input">
                        <div class="search-glow"></div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-item">
                        <label class="filter-label">Genre</label>
                        <select name="genre" class="filter-select enhanced-select">
                            <option value="">All Genres</option>
                            <option value="classical" {{ request('genre') === 'classical' ? 'selected' : '' }}>Classical</option>
                            <option value="gospel" {{ request('genre') === 'gospel' ? 'selected' : '' }}>Gospel</option>
                            <option value="folk" {{ request('genre') === 'folk' ? 'selected' : '' }}>Folk</option>
                            <option value="contemporary" {{ request('genre') === 'contemporary' ? 'selected' : '' }}>Contemporary</option>
                            <option value="traditional" {{ request('genre') === 'traditional' ? 'selected' : '' }}>Traditional</option>
                            <option value="pop" {{ request('genre') === 'pop' ? 'selected' : '' }}>Pop</option>
                            <option value="jazz" {{ request('genre') === 'jazz' ? 'selected' : '' }}>Jazz</option>
                            <option value="other" {{ request('genre') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Difficulty</label>
                        <select name="difficulty" class="filter-select enhanced-select">
                            <option value="">All Difficulties</option>
                            <option value="beginner" {{ request('difficulty') === 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ request('difficulty') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ request('difficulty') === 'advanced' ? 'selected' : '' }}>Advanced</option>
                            <option value="expert" {{ request('difficulty') === 'expert' ? 'selected' : '' }}>Expert</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Composer</label>
                        <select name="composer" class="filter-select enhanced-select">
                            <option value="">All Composers</option>
                            @foreach($songs->pluck('composer')->unique()->filter() as $composer)
                            <option value="{{ $composer }}" {{ request('composer') === $composer ? 'selected' : '' }}>{{ $composer }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Media</label>
                        <select name="media" class="filter-select enhanced-select">
                            <option value="">All Songs</option>
                            <option value="with_audio" {{ request('media') === 'with_audio' ? 'selected' : '' }}>With Audio</option>
                            <option value="with_sheet_music" {{ request('media') === 'with_sheet_music' ? 'selected' : '' }}>With Sheet Music</option>
                            <option value="with_lyrics" {{ request('media') === 'with_lyrics' ? 'selected' : '' }}>With Lyrics</option>
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary filter-btn">
                        <i class="fas fa-search"></i>
                        <span>Apply Filters</span>
                    </button>
                    <a href="{{ route('admin.songs.index') }}" class="btn btn-outline clear-btn">
                        <i class="fas fa-times"></i>
                        <span>Clear All</span>
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
                Songs Repertoire
            </h3>
            <div class="header-meta">
                <span class="results-count">{{ $songs->count() }} of {{ $songs->total() }} songs</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($songs->count() > 0)
        <div class="table-container">
            <table class="data-table enhanced-table">
                <thead>
                    <tr>
                        <th class="th-title">Song Details</th>
                        <th class="th-composer">Composer</th>
                        <th class="th-genre">Genre</th>
                        <th class="th-difficulty">Difficulty</th>
                        <th class="th-duration">Duration</th>
                        <th class="th-media">Media</th>
                        @permission('view_songs')
                        <th class="th-actions">Actions</th>
                        @endpermission
                    </tr>
                </thead>
                <tbody>
                    @foreach($songs as $song)
                    <tr class="song-row">
                        <td data-label="Song Details" class="td-details">
                            <div class="song-info enhanced-info">
                                <div class="song-title">{{ $song->title }}</div>
                                @if($song->description)
                                <div class="song-description">{{ Str::limit($song->description, 80) }}</div>
                                @endif
                                <div class="song-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-music"></i>
                                        {{ $song->genre ? ucfirst($song->genre) : 'No genre' }}
                                    </span>
                                    @if($song->composer)
                                    <span class="meta-item">
                                        <i class="fas fa-user"></i>
                                        {{ $song->composer }}
                                    </span>
                                    @endif
                                    @if($song->key_signature)
                                    <span class="meta-item">
                                        <i class="fas fa-music"></i>
                                        {{ $song->key_signature }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td data-label="Composer" class="td-composer">
                            @if($song->composer)
                            <div class="composer-display">
                                <div class="composer-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="composer-text">
                                    <span class="composer-name">{{ $song->composer }}</span>
                                </div>
                            </div>
                            @else
                            <div class="no-composer">
                                <i class="fas fa-user-slash"></i>
                                <span>Unknown</span>
                            </div>
                            @endif
                        </td>

                        <td data-label="Genre" class="td-genre">
                            <span class="genre-badge enhanced-badge genre-{{ $song->genre ?? 'unknown' }}">
                                <i class="fas fa-{{ $song->genre === 'classical' ? 'violin' : ($song->genre === 'gospel' ? 'church' : 'music') }}"></i>
                                {{ ucfirst($song->genre ?? 'Unknown') }}
                            </span>
                        </td>

                        <td data-label="Difficulty" class="td-difficulty">
                            @if($song->difficulty)
                            <span class="difficulty-badge enhanced-badge difficulty-{{ $song->difficulty }}">
                                <i class="fas fa-star"></i>
                                {{ ucfirst($song->difficulty) }}
                            </span>
                            @else
                            <span class="no-difficulty">
                                <i class="fas fa-question"></i>
                                <span>Not set</span>
                            </span>
                            @endif
                        </td>

                        <td data-label="Duration" class="td-duration">
                            @if($song->duration)
                            <div class="duration-display">
                                <div class="duration-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="duration-text">
                                    <span class="duration-value">{{ $song->formatted_duration ?? $song->duration }}</span>
                                </div>
                            </div>
                            @else
                            <div class="no-duration">
                                <i class="fas fa-clock"></i>
                                <span>N/A</span>
                            </div>
                            @endif
                        </td>

                        <td data-label="Media" class="td-media">
                            <div class="media-indicators">
                                @if($song->audio_file)
                                <span class="media-indicator audio-indicator" title="Has Audio File">
                                    <i class="fas fa-music"></i>
                                </span>
                                @endif
                                @if($song->sheet_music_file)
                                <span class="media-indicator sheet-music-indicator" title="Has Sheet Music">
                                    <i class="fas fa-file-pdf"></i>
                                </span>
                                @endif
                                @if($song->lyrics)
                                <span class="media-indicator lyrics-indicator" title="Has Lyrics">
                                    <i class="fas fa-align-left"></i>
                                </span>
                                @endif
                                @if(!$song->audio_file && !$song->sheet_music_file && !$song->lyrics)
                                <span class="no-media">
                                    <i class="fas fa-minus"></i>
                                    <span>No media</span>
                                </span>
                                @endif
                            </div>
                        </td>

                        @permission('view_songs')
                        <td data-label="Actions" class="td-actions">
                            <div class="action-buttons enhanced-actions">
                                @permission('view_songs')
                                <a href="{{ route('admin.songs.show', $song) }}"
                                    class="btn btn-sm btn-secondary action-btn" title="View Song">
                                    <i class="fas fa-eye"></i>
                                    <span class="btn-tooltip">View</span>
                                </a>
                                @endpermission

                                @permission('edit_songs')
                                <a href="{{ route('admin.songs.edit', $song) }}"
                                    class="btn btn-sm btn-primary action-btn" title="Edit Song">
                                    <i class="fas fa-edit"></i>
                                    <span class="btn-tooltip">Edit</span>
                                </a>
                                @endpermission

                                @permission('delete_songs')
                                <form method="POST" action="{{ route('admin.songs.destroy', $song) }}"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger action-btn delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this song?')"
                                        title="Delete Song">
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
            :paginator="$songs"
            :show-per-page-selector="true"
            :per-page-options="[5, 10, 20, 50, 100]"
            :show-page-info="true"
            :show-jump-to-page="true"
            :max-visible-pages="7" />
        @else
        <div class="empty-state enhanced-empty-state">
            <div class="empty-icon">
                <i class="fas fa-music"></i>
                <div class="icon-pulse"></div>
            </div>
            <h3>No Songs Found</h3>
            <p>Start building your choir repertoire by adding your first musical piece.</p>
            <div class="empty-actions">
                @permission('create_songs')
                <a href="{{ route('admin.songs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Your First Song
                </a>
                @endpermission
                <button class="btn btn-outline refresh-btn" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i>
                    Refresh
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    function toggleSongFilters() {
        const form = document.getElementById('songFiltersForm');
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
        const form = document.getElementById('songFiltersForm');
        form.style.display = 'none';
    });
</script>

@endsection