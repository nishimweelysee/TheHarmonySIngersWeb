@extends('layouts.admin')

@section('title', 'Practice Sessions')
@section('page-title', 'Manage Practice Sessions')

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
                <i class="fas fa-calendar-alt"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Practice Sessions Management</h2>
                <p class="header-subtitle">Manage choir practice sessions and attendance with ease</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $practiceSessions->total() }}</span>
                        <span class="stat-label">Total Sessions</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $practiceSessions->where('status', 'scheduled')->count() }}</span>
                        <span class="stat-label">Scheduled</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $practiceSessions->where('status', 'completed')->count() }}</span>
                        <span class="stat-label">Completed</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('create_practice_sessions')
            <a href="{{ route('admin.practice-sessions.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Create New Session</span>
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

        <form method="GET" action="{{ route('admin.practice-sessions.index') }}" class="filters-form" id="filtersForm">
            <div class="filters-grid">
                <div class="search-group">
                    <div class="search-box enhanced-search">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search sessions by title, description, or venue..."
                            class="search-input enhanced-input">
                        <div class="search-glow"></div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-item">
                        <label class="filter-label">Status</label>
                        <select name="status" class="filter-select enhanced-select">
                            <option value="">All Status</option>
                            <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Date Filter</label>
                        <select name="date_filter" class="filter-select enhanced-select">
                            <option value="">All Dates</option>
                            <option value="today" {{ request('date_filter') === 'today' ? 'selected' : '' }}>Today</option>
                            <option value="this_week" {{ request('date_filter') === 'this_week' ? 'selected' : '' }}>This Week</option>
                            <option value="upcoming" {{ request('date_filter') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="past" {{ request('date_filter') === 'past' ? 'selected' : '' }}>Past</option>
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary filter-btn">
                        <i class="fas fa-search"></i>
                        <span>Apply Filters</span>
                    </button>
                    <a href="{{ route('admin.practice-sessions.index') }}" class="btn btn-outline clear-btn">
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
                Practice Sessions Directory
            </h3>
            <div class="header-meta">
                <span class="results-count">{{ $practiceSessions->count() }} of {{ $practiceSessions->total() }} sessions</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
        @endif

        @if($practiceSessions->count() > 0)
        <div class="table-container">
            <table class="data-table enhanced-table">
                <thead>
                    <tr>
                        <th class="th-details">Session Details</th>
                        <th class="th-datetime">Date & Time</th>
                        <th class="th-venue">Venue</th>
                        <th class="th-status">Status</th>
                        <th class="th-attendance">Attendance</th>
                        @permission('view_practice_sessions')
                        <th class="th-actions">Actions</th>
                        @endpermission
                    </tr>
                </thead>
                <tbody>
                    @foreach($practiceSessions as $session)
                    <tr class="session-row">
                        <td data-label="Session Details" class="td-details">
                            <div class="session-info enhanced-info">
                                <div class="session-title">{{ $session->title }}</div>
                                @if($session->description)
                                <div class="session-description">{{ Str::limit($session->description, 100) }}</div>
                                @endif
                            </div>
                        </td>

                        <td data-label="Date & Time" class="td-datetime">
                            <div class="datetime-info">
                                <div class="date-display">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $session->practice_date->format('M j, Y') }}
                                </div>
                                <div class="time-display">
                                    <i class="fas fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('g:i A') }}
                                </div>
                                <div class="duration-badge">
                                    <i class="fas fa-hourglass-half"></i>
                                    {{ $session->duration }}
                                </div>
                            </div>
                        </td>

                        <td data-label="Venue" class="td-venue">
                            @if($session->venue)
                            <div class="venue-info">
                                <div class="venue-name">{{ $session->venue }}</div>
                                @if($session->venue_address)
                                <div class="venue-address">{{ Str::limit($session->venue_address, 50) }}</div>
                                @endif
                            </div>
                            @else
                            <span class="no-venue">-</span>
                            @endif
                        </td>

                        <td data-label="Status" class="td-status">
                            @php
                            $statusClasses = [
                            'scheduled' => 'status-badge enhanced-badge status-scheduled',
                            'in_progress' => 'status-badge enhanced-badge status-in_progress',
                            'completed' => 'status-badge enhanced-badge status-completed',
                            'cancelled' => 'status-badge enhanced-badge status-cancelled'
                            ];
                            $statusLabels = [
                            'scheduled' => 'Scheduled',
                            'in_progress' => 'In Progress',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled'
                            ];
                            @endphp
                            <span class="{{ $statusClasses[$session->status] }}">
                                <div class="status-dot"></div>
                                {{ $statusLabels[$session->status] }}
                            </span>
                        </td>

                        <td data-label="Attendance" class="td-attendance">
                            @php
                            $stats = $session->attendance_count;
                            $percentage = $session->attendance_percentage;
                            @endphp
                            <div class="attendance-stats">
                                <div class="stats-row">
                                    <span class="stat-present">{{ $stats['present'] }}</span>
                                    <span class="stat-late">{{ $stats['late'] }}</span>
                                    <span class="stat-absent">{{ $stats['absent'] }}</span>
                                    <span class="stat-excused">{{ $stats['excused'] }}</span>
                                </div>
                                <div class="attendance-percentage">
                                    <i class="fas fa-chart-pie"></i>
                                    {{ $percentage }}% attendance
                                </div>
                            </div>
                        </td>

                        @permission('view_practice_sessions')
                        <td data-label="Actions" class="td-actions">
                            <div class="action-buttons enhanced-actions">
                                @permission('view_practice_sessions')
                                <a href="{{ route('admin.practice-sessions.show', $session) }}"
                                    class="btn btn-sm btn-secondary action-btn" title="View Session">
                                    <i class="fas fa-eye"></i>
                                    <span class="btn-tooltip">View</span>
                                </a>
                                @endpermission

                                @permission('manage_practice_attendance')
                                <a href="{{ route('admin.practice-sessions.attendance', $session) }}"
                                    class="btn btn-sm btn-success action-btn" title="Manage Attendance">
                                    <i class="fas fa-clipboard-check"></i>
                                    <span class="btn-tooltip">Attendance</span>
                                </a>
                                @endpermission

                                @permission('edit_practice_sessions')
                                <a href="{{ route('admin.practice-sessions.edit', $session) }}"
                                    class="btn btn-sm btn-primary action-btn" title="Edit Session">
                                    <i class="fas fa-edit"></i>
                                    <span class="btn-tooltip">Edit</span>
                                </a>
                                @endpermission

                                @permission('delete_practice_sessions')
                                <form method="POST" action="{{ route('admin.practice-sessions.destroy', $session) }}"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger action-btn delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this practice session?')"
                                        title="Delete Session">
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
            :paginator="$practiceSessions"
            :show-per-page-selector="true"
            :per-page-options="[5, 10, 20, 50, 100]"
            :show-page-info="true"
            :show-jump-to-page="true"
            :max-visible-pages="7" />
        @else
        <div class="empty-state enhanced-empty-state">
            <div class="empty-icon">
                <i class="fas fa-calendar-alt"></i>
                <div class="icon-pulse"></div>
            </div>
            <h3>No Practice Sessions Found</h3>
            <p>Get started by creating your first practice session to organize choir rehearsals.</p>
            <div class="empty-actions">
                @permission('create_practice_sessions')
                <a href="{{ route('admin.practice-sessions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Create Your First Session
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

@endsection