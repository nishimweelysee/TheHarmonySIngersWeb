@extends('layouts.admin')

@section('title', 'Concerts')
@section('page-title', 'Manage Concerts')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header concerts-header">
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
                <h2 class="header-title">Concerts Management</h2>
                <p class="header-subtitle">Manage upcoming and past concerts with precision</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $concerts->total() }}</span>
                        <span class="stat-label">Total Concerts</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $concerts->where('status', 'upcoming')->count() }}</span>
                        <span class="stat-label">Upcoming</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $concerts->where('status', 'completed')->count() }}</span>
                        <span class="stat-label">Completed</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('create_concerts')
            <a href="{{ route('admin.concerts.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Add New Concert</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission

            <!-- Export Actions -->
            <div class="export-actions">
                <a href="{{ route('admin.concerts.export.excel', request()->query()) }}"
                    class="btn btn-success enhanced-btn"
                    title="Export to Excel">
                    <div class="btn-content">
                        <i class="fas fa-file-excel"></i>
                        <span>Excel</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>

                <a href="{{ route('admin.concerts.export.pdf', request()->query()) }}"
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
                <button class="toggle-btn" onclick="toggleConcertFilters()">
                    <i class="fas fa-chevron-down"></i>
                    <span>Show Filters</span>
                </button>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.concerts.index') }}" class="filters-form" id="concertFiltersForm">
            <div class="filters-grid">
                <div class="search-group">
                    <div class="search-box enhanced-search">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search concerts by title, description, or venue..."
                            class="search-input enhanced-input">
                        <div class="search-glow"></div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-item">
                        <label class="filter-label">Concert Status</label>
                        <select name="status" class="filter-select enhanced-select">
                            <option value="">All Status</option>
                            <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Venue</label>
                        <select name="venue" class="filter-select enhanced-select">
                            <option value="">All Venues</option>
                            @foreach($concerts->pluck('venue')->unique()->filter() as $venue)
                            <option value="{{ $venue }}" {{ request('venue') === $venue ? 'selected' : '' }}>{{ $venue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary filter-btn">
                        <i class="fas fa-search"></i>
                        <span>Apply Filters</span>
                    </button>
                    <a href="{{ route('admin.concerts.index') }}" class="btn btn-outline clear-btn">
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
                Concerts Directory
            </h3>
            <div class="header-meta">
                <span class="results-count">{{ $concerts->count() }} of {{ $concerts->total() }} concerts</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($concerts->count() > 0)
        <div class="table-container">
            <table class="data-table enhanced-table">
                <thead>
                    <tr>
                        <th class="th-title">Concert Details</th>
                        <th class="th-date">Date & Time</th>
                        <th class="th-venue">Venue</th>
                        <th class="th-status">Status</th>
                        @permission('view_concerts')
                        <th class="th-actions">Actions</th>
                        @endpermission
                    </tr>
                </thead>
                <tbody>
                    @foreach($concerts as $concert)
                    <tr class="concert-row">
                        <td data-label="Concert Details" class="td-details">
                            <div class="concert-info enhanced-info">
                                <div class="concert-title">{{ $concert->title }}</div>
                                @if($concert->description)
                                <div class="concert-description">{{ Str::limit($concert->description, 80) }}</div>
                                @endif
                                <div class="concert-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $concert->date ? $concert->date->format('M j, Y') : 'No date set' }}
                                    </span>
                                    @if($concert->time)
                                    <span class="meta-item">
                                        <i class="fas fa-clock"></i>
                                        {{ $concert->time }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td data-label="Date & Time" class="td-date">
                            @if($concert->date)
                            <div class="date-display enhanced-date">
                                <div class="date-icon">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                                <div class="date-content">
                                    <div class="date-main">{{ $concert->date->format('M j') }}</div>
                                    <div class="date-year">{{ $concert->date->format('Y') }}</div>
                                    @if($concert->time)
                                    <div class="time-display">
                                        <i class="fas fa-clock"></i>
                                        {{ $concert->time }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @else
                            <div class="no-date">
                                <i class="fas fa-calendar-times"></i>
                                <span>No date set</span>
                            </div>
                            @endif
                        </td>

                        <td data-label="Venue" class="td-venue">
                            <div class="venue-display">
                                <div class="venue-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="venue-text">
                                    <span class="venue-name">{{ $concert->venue ?: 'No venue set' }}</span>
                                </div>
                            </div>
                        </td>

                        <td data-label="Status" class="td-status">
                            <span class="status-badge enhanced-badge status-{{ $concert->status }}">
                                <div class="status-dot"></div>
                                <span class="status-text">{{ ucfirst($concert->status) }}</span>
                            </span>
                        </td>

                        @permission('view_concerts')
                        <td data-label="Actions" class="td-actions">
                            <div class="action-buttons enhanced-actions">
                                @permission('view_concerts')
                                <a href="{{ route('admin.concerts.show', $concert) }}"
                                    class="btn btn-sm btn-secondary action-btn" title="View Concert">
                                    <i class="fas fa-eye"></i>
                                    <span class="btn-tooltip">View</span>
                                </a>
                                @endpermission

                                @permission('edit_concerts')
                                <a href="{{ route('admin.concerts.edit', $concert) }}"
                                    class="btn btn-sm btn-primary action-btn" title="Edit Concert">
                                    <i class="fas fa-edit"></i>
                                    <span class="btn-tooltip">Edit</span>
                                </a>
                                @endpermission

                                @permission('delete_concerts')
                                <form method="POST" action="{{ route('admin.concerts.destroy', $concert) }}"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger action-btn delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this concert?')"
                                        title="Delete Concert">
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
            :paginator="$concerts"
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
            <h3>No Concerts Found</h3>
            <p>Start building your concert schedule by creating your first event.</p>
            <div class="empty-actions">
                @permission('create_concerts')
                <a href="{{ route('admin.concerts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Create Your First Concert
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
    function toggleConcertFilters() {
        const form = document.getElementById('concertFiltersForm');
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
        const form = document.getElementById('concertFiltersForm');
        form.style.display = 'none';
    });
</script>

@endsection