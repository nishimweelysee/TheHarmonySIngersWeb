@extends('layouts.admin')

@section('title', 'Sponsors')
@section('page-title', 'Manage Sponsors')

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
                <i class="fas fa-handshake"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Sponsors Management</h2>
                <p class="header-subtitle">Manage sponsors and partners with ease</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $sponsors->total() }}</span>
                        <span class="stat-label">Total Sponsors</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $sponsors->where('status', 'active')->count() }}</span>
                        <span class="stat-label">Active</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $sponsors->where('sponsorship_level', 'platinum')->count() }}</span>
                        <span class="stat-label">Platinum</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <div class="export-buttons">
                <a href="{{ route('admin.sponsors.export.excel', request()->query()) }}" class="btn btn-success enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-file-excel"></i>
                        <span>Export Excel</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
                <a href="{{ route('admin.sponsors.export.pdf', request()->query()) }}" class="btn btn-danger enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-file-pdf"></i>
                        <span>Export PDF</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
            </div>
            @permission('create_sponsors')
            <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Add New Sponsor</span>
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

        <form method="GET" action="{{ route('admin.sponsors.index') }}" class="filters-form" id="filtersForm">
            <div class="filters-grid">
                <div class="search-group">
                    <div class="search-box enhanced-search">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by name, contact person, or description..."
                            class="search-input enhanced-input">
                        <div class="search-glow"></div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-item">
                        <label class="filter-label">Sponsor Type</label>
                        <select name="type" class="filter-select enhanced-select">
                            <option value="">All Types</option>
                            <option value="corporate" {{ request('type') === 'corporate' ? 'selected' : '' }}>Corporate</option>
                            <option value="individual" {{ request('type') === 'individual' ? 'selected' : '' }}>Individual</option>
                            <option value="foundation" {{ request('type') === 'foundation' ? 'selected' : '' }}>Foundation</option>
                            <option value="government" {{ request('type') === 'government' ? 'selected' : '' }}>Government</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Sponsorship Level</label>
                        <select name="sponsorship_level" class="filter-select enhanced-select">
                            <option value="">All Levels</option>
                            <option value="platinum" {{ request('sponsorship_level') === 'platinum' ? 'selected' : '' }}>Platinum</option>
                            <option value="gold" {{ request('sponsorship_level') === 'gold' ? 'selected' : '' }}>Gold</option>
                            <option value="silver" {{ request('sponsorship_level') === 'silver' ? 'selected' : '' }}>Silver</option>
                            <option value="bronze" {{ request('sponsorship_level') === 'bronze' ? 'selected' : '' }}>Bronze</option>
                            <option value="patron" {{ request('sponsorship_level') === 'patron' ? 'selected' : '' }}>Patron</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Status</label>
                        <select name="status" class="filter-select enhanced-select">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary filter-btn">
                        <i class="fas fa-search"></i>
                        <span>Apply Filters</span>
                    </button>
                    <a href="{{ route('admin.sponsors.index') }}" class="btn btn-outline clear-btn">
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
                Sponsors Directory
            </h3>
            <div class="header-meta">
                <span class="results-count">{{ $sponsors->count() }} of {{ $sponsors->total() }} sponsors</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($sponsors->count() > 0)
        <div class="table-container">
            <table class="data-table enhanced-table">
                <thead>
                    <tr>
                        <th class="th-name">Name & Contact</th>
                        <th class="th-type">Type</th>
                        <th class="th-level">Sponsorship Level</th>
                        <th class="th-amount">Annual Contribution</th>
                        <th class="th-partnership">Partnership Date</th>
                        <th class="th-status">Status</th>
                        @permission('view_sponsors')
                        <th class="th-actions">Actions</th>
                        @endpermission
                    </tr>
                </thead>
                <tbody>
                    @foreach($sponsors as $sponsor)
                    <tr class="sponsor-row">
                        <td data-label="Name & Contact" class="td-info">
                            <div class="sponsor-info enhanced-info">
                                <div class="sponsor-name">{{ $sponsor->name }}</div>
                                @if($sponsor->contact_person)
                                <div class="sponsor-contact">{{ $sponsor->contact_person }}</div>
                                @endif
                                @if($sponsor->contact_email)
                                <div class="sponsor-email">{{ $sponsor->contact_email }}</div>
                                @endif
                                @if($sponsor->contact_phone)
                                <div class="sponsor-phone">
                                    <i class="fas fa-phone"></i>
                                    {{ $sponsor->contact_phone }}
                                </div>
                                @endif
                            </div>
                        </td>

                        <td data-label="Type" class="td-type">
                            <span class="type-badge enhanced-badge type-{{ $sponsor->type }}">
                                <i class="fas fa-{{ $sponsor->type === 'corporate' ? 'building' : ($sponsor->type === 'individual' ? 'user' : ($sponsor->type === 'foundation' ? 'university' : 'landmark')) }}"></i>
                                {{ ucfirst($sponsor->type) }}
                            </span>
                        </td>

                        <td data-label="Sponsorship Level" class="td-level">
                            @if($sponsor->sponsorship_level)
                            <span class="level-badge enhanced-badge level-{{ $sponsor->sponsorship_level }}">
                                <i class="fas fa-star"></i>
                                {{ ucfirst($sponsor->sponsorship_level) }}
                            </span>
                            @else
                            <span class="no-level">-</span>
                            @endif
                        </td>

                        <td data-label="Annual Contribution" class="td-amount">
                            @if($sponsor->annual_contribution)
                            <div class="amount-display">
                                <div class="amount-icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div class="amount-text">
                                    <span class="amount-value">{{ number_format($sponsor->annual_contribution, 2) }}</span>
                                    <span class="amount-label">per year</span>
                                </div>
                            </div>
                            @else
                            <span class="no-amount">-</span>
                            @endif
                        </td>

                        <td data-label="Partnership Date" class="td-partnership">
                            @if($sponsor->partnership_start_date)
                            <div class="partnership-date">
                                <div class="date-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="date-text">
                                    <span class="date-day">{{ $sponsor->partnership_start_date->format('M j') }}</span>
                                    <span class="date-year">{{ $sponsor->partnership_start_date->format('Y') }}</span>
                                </div>
                            </div>
                            @else
                            <span class="no-date">-</span>
                            @endif
                        </td>

                        <td data-label="Status" class="td-status">
                            <span class="status-badge enhanced-badge {{ $sponsor->status }}">
                                <div class="status-dot"></div>
                                {{ ucfirst($sponsor->status) }}
                            </span>
                        </td>

                        @permission('view_sponsors')
                        <td data-label="Actions" class="td-actions">
                            <div class="action-buttons enhanced-actions">
                                @permission('view_sponsors')
                                <a href="{{ route('admin.sponsors.show', $sponsor) }}"
                                    class="btn btn-sm btn-secondary action-btn" title="View Sponsor">
                                    <i class="fas fa-eye"></i>
                                    <span class="btn-tooltip">View</span>
                                </a>
                                @endpermission

                                @permission('edit_sponsors')
                                <a href="{{ route('admin.sponsors.edit', $sponsor) }}"
                                    class="btn btn-sm btn-primary action-btn" title="Edit Sponsor">
                                    <i class="fas fa-edit"></i>
                                    <span class="btn-tooltip">Edit</span>
                                </a>
                                @endpermission

                                @permission('delete_sponsors')
                                <form method="POST" action="{{ route('admin.sponsors.destroy', $sponsor) }}"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger action-btn delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this sponsor?')"
                                        title="Delete Sponsor">
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

        <div class="pagination-wrapper enhanced-pagination">
            {{ $sponsors->links() }}
        </div>
        @else
        <div class="empty-state enhanced-empty-state">
            <div class="empty-icon">
                <i class="fas fa-handshake"></i>
                <div class="icon-pulse"></div>
            </div>
            <h3>No Sponsors Found</h3>
            <p>Get started by adding your first sponsor to build partnerships.</p>
            <div class="empty-actions">
                @permission('create_sponsors')
                <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Your First Sponsor
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