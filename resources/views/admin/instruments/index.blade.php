@extends('layouts.admin')

@section('title', 'Instruments')
@section('page-title', 'Manage Instruments')

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
                <i class="fas fa-guitar"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Instruments Management</h2>
                <p class="header-subtitle">Manage choir instruments and equipment with ease</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $instruments->total() }}</span>
                        <span class="stat-label">Total Instruments</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $instruments->where('is_available', true)->count() }}</span>
                        <span class="stat-label">Available</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $instruments->where('condition', 'excellent')->count() }}</span>
                        <span class="stat-label">Excellent</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <div class="export-buttons">
                <a href="{{ route('admin.instruments.export.excel', request()->query()) }}" class="btn btn-success enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-file-excel"></i>
                        <span>Export Excel</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
                <a href="{{ route('admin.instruments.export.pdf', request()->query()) }}" class="btn btn-danger enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-file-pdf"></i>
                        <span>Export PDF</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
            </div>
            @permission('create_instruments')
            <a href="{{ route('admin.instruments.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Add New Instrument</span>
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

        <form method="GET" action="{{ route('admin.instruments.index') }}" class="filters-form" id="filtersForm">
            <div class="filters-grid">
                <div class="search-group">
                    <div class="search-box enhanced-search">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search instruments by name, brand, or description..."
                            class="search-input enhanced-input">
                        <div class="search-glow"></div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-item">
                        <label class="filter-label">Instrument Type</label>
                        <select name="type" class="filter-select enhanced-select">
                            <option value="">All Types</option>
                            <option value="string" {{ request('type') === 'string' ? 'selected' : '' }}>String</option>
                            <option value="wind" {{ request('type') === 'wind' ? 'selected' : '' }}>Wind</option>
                            <option value="percussion" {{ request('type') === 'percussion' ? 'selected' : '' }}>Percussion</option>
                            <option value="keyboard" {{ request('type') === 'keyboard' ? 'selected' : '' }}>Keyboard</option>
                            <option value="electronic" {{ request('type') === 'electronic' ? 'selected' : '' }}>Electronic</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Availability</label>
                        <select name="availability" class="filter-select enhanced-select">
                            <option value="">All Availability</option>
                            <option value="Available" {{ request('availability') === 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Not Available" {{ request('availability') === 'Not Available' ? 'selected' : '' }}>Not Available</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Condition</label>
                        <select name="condition" class="filter-select enhanced-select">
                            <option value="">All Conditions</option>
                            <option value="excellent" {{ request('condition') === 'excellent' ? 'selected' : '' }}>Excellent</option>
                            <option value="good" {{ request('condition') === 'good' ? 'selected' : '' }}>Good</option>
                            <option value="fair" {{ request('condition') === 'fair' ? 'selected' : '' }}>Fair</option>
                            <option value="poor" {{ request('condition') === 'poor' ? 'selected' : '' }}>Poor</option>
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary filter-btn">
                        <i class="fas fa-search"></i>
                        <span>Apply Filters</span>
                    </button>
                    <a href="{{ route('admin.instruments.index') }}" class="btn btn-outline clear-btn">
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
                Instruments Directory
            </h3>
            <div class="header-meta">
                <span class="results-count">{{ $instruments->count() }} of {{ $instruments->total() }} instruments</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($instruments->count() > 0)
        <div class="table-container">
            <table class="data-table enhanced-table">
                <thead>
                    <tr>
                        <th class="th-instrument">Instrument</th>
                        <th class="th-type">Type</th>
                        <th class="th-brand">Brand/Model</th>
                        <th class="th-condition">Condition</th>
                        <th class="th-availability">Availability</th>
                        @permission('view_instruments')
                        <th class="th-actions">Actions</th>
                        @endpermission
                    </tr>
                </thead>
                <tbody>
                    @foreach($instruments as $instrument)
                    <tr class="instrument-row">
                        <td data-label="Instrument" class="td-info">
                            <div class="instrument-info enhanced-info">
                                <div class="instrument-name">{{ $instrument->name }}</div>
                                @if($instrument->description)
                                <div class="instrument-description">{{ Str::limit($instrument->description, 50) }}</div>
                                @endif
                            </div>
                        </td>

                        <td data-label="Type" class="td-type">
                            <span class="type-badge enhanced-badge type-{{ $instrument->type }}">
                                <i class="fas fa-{{ $instrument->type === 'string' ? 'guitar' : ($instrument->type === 'wind' ? 'wind' : ($instrument->type === 'percussion' ? 'drum' : ($instrument->type === 'keyboard' ? 'piano' : 'microchip'))) }}"></i>
                                {{ ucfirst($instrument->type) }}
                            </span>
                        </td>

                        <td data-label="Brand/Model" class="td-brand">
                            <div class="brand-info">
                                @if($instrument->brand)
                                <div class="brand">{{ $instrument->brand }}</div>
                                @endif
                                @if($instrument->model)
                                <div class="model">{{ $instrument->model }}</div>
                                @endif
                            </div>
                        </td>

                        <td data-label="Condition" class="td-condition">
                            @if($instrument->condition)
                            <span class="condition-badge enhanced-badge condition-{{ $instrument->condition }}">
                                <i class="fas fa-circle"></i>
                                {{ ucfirst($instrument->condition) }}
                            </span>
                            @else
                            <span class="condition-badge enhanced-badge condition-unknown">
                                <i class="fas fa-question-circle"></i>
                                Unknown
                            </span>
                            @endif
                        </td>

                        <td data-label="Availability" class="td-availability">
                            <span class="availability-badge enhanced-badge {{ $instrument->is_available ? 'available' : 'unavailable' }}">
                                <div class="status-dot"></div>
                                {{ $instrument->is_available ? 'Available' : 'Not Available' }}
                            </span>
                        </td>

                        @permission('view_instruments')
                        <td data-label="Actions" class="td-actions">
                            <div class="action-buttons enhanced-actions">
                                @permission('view_instruments')
                                <a href="{{ route('admin.instruments.show', $instrument) }}"
                                    class="btn btn-sm btn-secondary action-btn" title="View Instrument">
                                    <i class="fas fa-eye"></i>
                                    <span class="btn-tooltip">View</span>
                                </a>
                                @endpermission

                                @permission('edit_instruments')
                                <a href="{{ route('admin.instruments.edit', $instrument) }}"
                                    class="btn btn-sm btn-primary action-btn" title="Edit Instrument">
                                    <i class="fas fa-edit"></i>
                                    <span class="btn-tooltip">Edit</span>
                                </a>
                                @endpermission

                                @permission('delete_instruments')
                                <form method="POST" action="{{ route('admin.instruments.destroy', $instrument) }}"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger action-btn delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this instrument?')"
                                        title="Delete Instrument">
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
            :paginator="$instruments"
            :show-per-page-selector="true"
            :per-page-options="[5, 10, 20, 50, 100]"
            :show-page-info="true"
            :show-jump-to-page="true"
            :max-visible-pages="7" />
        @else
        <div class="empty-state enhanced-empty-state">
            <div class="empty-icon">
                <i class="fas fa-guitar"></i>
                <div class="icon-pulse"></div>
            </div>
            <h3>No Instruments Found</h3>
            <p>Get started by adding your first instrument to the inventory.</p>
            <div class="empty-actions">
                @permission('create_instruments')
                <a href="{{ route('admin.instruments.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Your First Instrument
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