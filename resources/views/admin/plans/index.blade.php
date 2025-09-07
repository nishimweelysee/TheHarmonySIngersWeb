@extends('layouts.admin')

@section('title', 'Year Plans')
@section('page-title', 'Manage Year Plans')

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
                <h2 class="header-title">Year Plans Management</h2>
                <p class="header-subtitle">Manage annual planning and objectives with ease</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $plans->total() }}</span>
                        <span class="stat-label">Total Plans</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $plans->where('status', 'active')->count() }}</span>
                        <span class="stat-label">Active</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $plans->where('status', 'completed')->count() }}</span>
                        <span class="stat-label">Completed</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <div class="export-buttons">
                <a href="{{ route('admin.plans.export.excel', request()->query()) }}" class="btn btn-success enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-file-excel"></i>
                        <span>Export Excel</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
                <a href="{{ route('admin.plans.export.pdf', request()->query()) }}" class="btn btn-danger enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-file-pdf"></i>
                        <span>Export PDF</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
            </div>
            @permission('create_plans')
            <a href="{{ route('admin.plans.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Create New Plan</span>
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

        <form method="GET" action="{{ route('admin.plans.index') }}" class="filters-form" id="filtersForm">
            <div class="filters-grid">
                <div class="search-group">
                    <div class="search-box enhanced-search">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search plans by title or description..."
                            class="search-input enhanced-input">
                        <div class="search-glow"></div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-item">
                        <label class="filter-label">Year</label>
                        <select name="year" class="filter-select enhanced-select">
                            <option value="">All Years</option>
                            @for($year = date('Y') + 2; $year >= date('Y') - 2; $year--)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Status</label>
                        <select name="status" class="filter-select enhanced-select">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Quarter</label>
                        <select name="quarter" class="filter-select enhanced-select">
                            <option value="">All Quarters</option>
                            <option value="Q1" {{ request('quarter') === 'Q1' ? 'selected' : '' }}>Q1 (Jan-Mar)</option>
                            <option value="Q2" {{ request('quarter') === 'Q2' ? 'selected' : '' }}>Q2 (Apr-Jun)</option>
                            <option value="Q3" {{ request('quarter') === 'Q3' ? 'selected' : '' }}>Q3 (Jul-Sep)</option>
                            <option value="Q4" {{ request('quarter') === 'Q4' ? 'selected' : '' }}>Q4 (Oct-Dec)</option>
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary filter-btn">
                        <i class="fas fa-search"></i>
                        <span>Apply Filters</span>
                    </button>
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-outline clear-btn">
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
                Year Plans Directory
            </h3>
            <div class="header-meta">
                <span class="results-count">{{ $plans->count() }} of {{ $plans->total() }} plans</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($plans->count() > 0)
        <div class="table-container">
            <table class="data-table enhanced-table">
                <thead>
                    <tr>
                        <th class="th-plan">Plan</th>
                        <th class="th-year">Year</th>
                        <th class="th-duration">Duration</th>
                        <th class="th-status">Status</th>
                        <th class="th-budget">Estimated Budget</th>
                        @permission('view_plans')
                        <th class="th-actions">Actions</th>
                        @endpermission
                    </tr>
                </thead>
                <tbody>
                    @foreach($plans as $plan)
                    <tr class="plan-row">
                        <td data-label="Plan" class="td-info">
                            <div class="plan-info enhanced-info">
                                <div class="plan-title">{{ $plan->title }}</div>
                                @if($plan->description)
                                <div class="plan-description">{{ Str::limit($plan->description, 60) }}</div>
                                @endif
                            </div>
                        </td>

                        <td data-label="Year" class="td-year">
                            <span class="year-badge enhanced-badge">
                                <i class="fas fa-calendar"></i>
                                {{ $plan->year }}
                            </span>
                        </td>

                        <td data-label="Duration" class="td-duration">
                            <div class="duration-info">
                                <div class="start-date">
                                    <i class="fas fa-play"></i>
                                    {{ $plan->start_date->format('M j') }}
                                </div>
                                <div class="end-date">
                                    <i class="fas fa-flag-checkered"></i>
                                    {{ $plan->end_date->format('M j, Y') }}
                                </div>
                            </div>
                        </td>

                        <td data-label="Status" class="td-status">
                            <span class="status-badge enhanced-badge status-{{ $plan->status }}">
                                <div class="status-dot"></div>
                                {{ ucfirst(str_replace('_', ' ', $plan->status)) }}
                            </span>
                        </td>

                        <td data-label="Estimated Budget" class="td-budget">
                            @if($plan->estimated_budget)
                            <div class="budget-display">
                                <div class="budget-icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div class="budget-text">
                                    <span class="budget-value">{{ number_format($plan->estimated_budget, 2) }}</span>
                                </div>
                            </div>
                            @else
                            <span class="no-budget">-</span>
                            @endif
                        </td>

                        @permission('view_plans')
                        <td data-label="Actions" class="td-actions">
                            <div class="action-buttons enhanced-actions">
                                @permission('view_plans')
                                <a href="{{ route('admin.plans.show', $plan) }}"
                                    class="btn btn-sm btn-secondary action-btn" title="View Plan">
                                    <i class="fas fa-eye"></i>
                                    <span class="btn-tooltip">View</span>
                                </a>
                                @endpermission

                                @permission('edit_plans')
                                <a href="{{ route('admin.plans.edit', $plan) }}"
                                    class="btn btn-sm btn-primary action-btn" title="Edit Plan">
                                    <i class="fas fa-edit"></i>
                                    <span class="btn-tooltip">Edit</span>
                                </a>
                                @endpermission

                                @permission('delete_plans')
                                <form method="POST" action="{{ route('admin.plans.destroy', $plan) }}"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger action-btn delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this plan?')"
                                        title="Delete Plan">
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
            :paginator="$plans"
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
            <h3>No Year Plans Found</h3>
            <p>Get started by creating your first year plan to organize annual objectives.</p>
            <div class="empty-actions">
                @permission('create_plans')
                <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Create Your First Plan
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