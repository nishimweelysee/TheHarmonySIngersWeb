@extends('layouts.admin')

@section('title', 'Contribution Campaigns')
@section('page-title', 'Contribution Campaigns')

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
                <i class="fas fa-hand-holding-heart"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Contribution Campaigns</h2>
                <p class="header-subtitle">Manage monthly contribution campaigns and track progress</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $contributionCampaigns->total() }}</span>
                        <span class="stat-label">Total Campaigns</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $contributionCampaigns->where('status', 'active')->count() }}</span>
                        <span class="stat-label">Active</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $contributionCampaigns->where('status', 'completed')->count() }}</span>
                        <span class="stat-label">Completed</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $contributionCampaigns->sum('current_amount') > 0 ? 'RWF ' . number_format($contributionCampaigns->sum('current_amount'), 2) : 'RWF 0.00' }}</span>
                        <span class="stat-label">Total Raised</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <div class="export-buttons">
                <a href="{{ route('admin.contribution-campaigns.export.excel', request()->query()) }}" class="btn btn-success enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-file-excel"></i>
                        <span>Export Excel</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
                <a href="{{ route('admin.contribution-campaigns.export.pdf', request()->query()) }}" class="btn btn-danger enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-file-pdf"></i>
                        <span>Export PDF</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
            </div>
            @permission('create_contribution_campaigns')
            <a href="{{ route('admin.contribution-campaigns.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Create Campaign</span>
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

        <form method="GET" action="{{ route('admin.contribution-campaigns.index') }}" class="filters-form" id="filtersForm">
            <div class="filters-grid">
                <div class="search-group">
                    <div class="search-box enhanced-search">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search campaigns..."
                            class="search-input enhanced-input">
                        <div class="search-glow"></div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-item">
                        <label class="filter-label">Campaign Type</label>
                        <select name="type" class="filter-select enhanced-select">
                            <option value="">All Types</option>
                            <option value="monthly" {{ request('type') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="project" {{ request('type') === 'project' ? 'selected' : '' }}>Project</option>
                            <option value="event" {{ request('type') === 'event' ? 'selected' : '' }}>Event</option>
                            <option value="special" {{ request('type') === 'special' ? 'selected' : '' }}>Special</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Status</label>
                        <select name="status" class="filter-select enhanced-select">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Year</label>
                        <select name="year" class="filter-select enhanced-select">
                            <option value="">All Years</option>
                            @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary enhanced-btn">
                        <div class="btn-content">
                            <i class="fas fa-filter"></i>
                            <span>Apply Filters</span>
                        </div>
                    </button>
                    <a href="{{ route('admin.contribution-campaigns.index') }}" class="btn btn-secondary enhanced-btn">
                        <div class="btn-content">
                            <i class="fas fa-times"></i>
                            <span>Clear Filters</span>
                        </div>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Campaign Summary Cards -->
<div class="summary-cards">
    <div class="summary-card total-campaigns">
        <div class="summary-icon">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="summary-content">
            <span class="summary-number">{{ $contributionCampaigns->total() }}</span>
            <span class="summary-label">Total Campaigns</span>
        </div>
    </div>

    <div class="summary-card total-raised">
        <div class="summary-icon">
            <i class="fas fa-hand-holding-heart"></i>
        </div>
        <div class="summary-content">
            <span class="summary-number">{{ $contributionCampaigns->sum('current_amount') > 0 ? 'RWF ' . number_format($contributionCampaigns->sum('current_amount'), 2) : 'RWF 0.00' }}</span>
            <span class="summary-label">Total Raised</span>
        </div>
    </div>

    <div class="summary-card active-campaigns">
        <div class="summary-icon">
            <i class="fas fa-play-circle"></i>
        </div>
        <div class="summary-content">
            <span class="summary-number">{{ $contributionCampaigns->where('status', 'active')->count() }}</span>
            <span class="summary-label">Active Campaigns</span>
        </div>
    </div>

    <div class="summary-card completed-campaigns">
        <div class="summary-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="summary-content">
            <span class="summary-number">{{ $contributionCampaigns->where('status', 'completed')->count() }}</span>
            <span class="summary-label">Completed</span>
        </div>
    </div>
</div>

<!-- Enhanced Campaigns Grid -->
<div class="content-card enhanced-card">
    <div class="card-header enhanced-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-list"></i>
                Campaigns
            </h3>
            <div class="header-meta">
                <span class="campaigns-count">{{ $contributionCampaigns->total() }} campaigns found</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($contributionCampaigns && $contributionCampaigns->count() > 0)
        <div class="campaigns-grid enhanced-grid">
            @foreach($contributionCampaigns as $campaign)
            <div class="campaign-card enhanced-card">
                <div class="campaign-header">
                    <div class="campaign-type">
                        <span class="type-badge enhanced-badge type-{{ $campaign->type }}">
                            <i class="fas fa-{{ $campaign->type === 'monthly' ? 'calendar-alt' : ($campaign->type === 'project' ? 'project-diagram' : ($campaign->type === 'event' ? 'calendar-day' : 'star')) }}"></i>
                            {{ ucfirst($campaign->type) }}
                        </span>
                    </div>
                    <div class="campaign-status">
                        <span class="status-badge enhanced-badge status-{{ $campaign->status }}">
                            <i class="fas fa-{{ $campaign->status === 'active' ? 'play-circle' : ($campaign->status === 'completed' ? 'check-circle' : 'times-circle') }}"></i>
                            {{ ucfirst($campaign->status) }}
                        </span>
                    </div>
                </div>

                <div class="campaign-body">
                    <h3 class="campaign-title">{{ $campaign->name }}</h3>
                    @if($campaign->description)
                    <p class="campaign-description">{{ $campaign->description }}</p>
                    @endif

                    @if($campaign->yearPlan)
                    <div class="year-plan-link">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ $campaign->yearPlan->title }}</span>
                    </div>
                    @endif

                    <div class="campaign-dates">
                        <div class="date-item">
                            <span class="date-label">Start:</span>
                            <span class="date-value">{{ $campaign->start_date->format('M j, Y') }}</span>
                        </div>
                        <div class="date-item">
                            <span class="date-label">End:</span>
                            <span class="date-value">{{ $campaign->end_date->format('M j, Y') }}</span>
                        </div>
                    </div>

                    @if($campaign->target_amount)
                    <div class="progress-section">
                        <div class="progress-header">
                            <span class="progress-label">Progress</span>
                            <span class="progress-percentage">{{ $campaign->progress_percentage }}%</span>
                        </div>
                        <div class="progress-bar enhanced-progress">
                            <div class="progress-fill" data-width="{{ $campaign->progress_percentage }}"></div>
                        </div>
                        <div class="progress-amounts">
                            <span class="raised-amount">{{ $campaign->currency }} {{ number_format($campaign->current_amount, 2) }} raised</span>
                            <span class="target-amount">of {{ $campaign->currency }} {{ number_format($campaign->target_amount, 2) }}</span>
                        </div>
                        <div class="remaining-amount">
                            <span class="remaining-label">Remaining:</span>
                            <span class="remaining-value">{{ $campaign->currency }} {{ number_format($campaign->remaining_amount, 2) }}</span>
                        </div>
                    </div>
                    @else
                    <div class="amount-section">
                        <div class="amount-display">
                            <span class="amount-label">Total Raised:</span>
                            <span class="amount-value">{{ $campaign->currency }} {{ number_format($campaign->current_amount, 2) }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="campaign-stats">
                        <div class="stat-item">
                            <span class="stat-label">Contributors</span>
                            <span class="stat-value">{{ $campaign->contributor_count }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Time Left</span>
                            <span class="stat-value time-display" data-end-date="{{ $campaign->end_date->toISOString() }}">
                                <span class="time-text">Calculating...</span>
                            </span>
                        </div>
                        @if($campaign->min_amount_per_person)
                        <div class="stat-item">
                            <span class="stat-label">Min Amount</span>
                            <span class="stat-value">{{ $campaign->currency }} {{ number_format($campaign->min_amount_per_person, 2) }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="campaign-actions">
                    <a href="{{ route('admin.contribution-campaigns.show', $campaign) }}" class="btn btn-primary enhanced-btn btn-sm">
                        <div class="btn-content">
                            <i class="fas fa-eye"></i>
                            <span>View</span>
                        </div>
                    </a>
                    @permission('update_contribution_campaigns')
                    <a href="{{ route('admin.contribution-campaigns.edit', $campaign) }}" class="btn btn-secondary enhanced-btn btn-sm">
                        <div class="btn-content">
                            <i class="fas fa-edit"></i>
                            <span>Edit</span>
                        </div>
                    </a>
                    @endpermission
                    @permission('create_contributions')
                    <a href="{{ route('admin.contribution-campaigns.add-contribution', $campaign) }}" class="btn btn-success enhanced-btn btn-sm">
                        <div class="btn-content">
                            <i class="fas fa-plus"></i>
                            <span>Add Contribution</span>
                        </div>
                    </a>
                    @endpermission
                </div>
            </div>
            @endforeach
        </div>

        <!-- Enhanced Pagination -->
        @if($contributionCampaigns->hasPages())
        <x-enhanced-pagination
            :paginator="$contributionCampaigns"
            :show-per-page-selector="true"
            :per-page-options="[5, 10, 20, 50, 100]"
            :show-page-info="true"
            :show-jump-to-page="true"
            :max-visible-pages="7" />
        @endif

        @else
        <div class="empty-state enhanced-empty">
            <div class="empty-icon">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
            <h3 class="empty-title">No Campaigns Found</h3>
            <p class="empty-description">No contribution campaigns match your current filters.</p>
            <div class="empty-actions">
                <a href="{{ route('admin.contribution-campaigns.create') }}" class="btn btn-primary enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-plus"></i>
                        <span>Create Your First Campaign</span>
                    </div>
                </a>
                <a href="{{ route('admin.contribution-campaigns.index') }}" class="btn btn-secondary enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-times"></i>
                        <span>Clear Filters</span>
                    </div>
                </a>
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

        if (form.classList.contains('expanded')) {
            form.classList.remove('expanded');
            icon.className = 'fas fa-chevron-down';
            text.textContent = 'Show Filters';
        } else {
            form.classList.add('expanded');
            icon.className = 'fas fa-chevron-up';
            text.textContent = 'Hide Filters';
        }
    }

    // Initialize progress bars and time displays
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize progress bars
        const progressBars = document.querySelectorAll('.progress-fill');
        progressBars.forEach(function(bar) {
            const width = bar.getAttribute('data-width');
            if (width) {
                // Set CSS custom property for the width
                bar.style.setProperty('--progress-width', width + '%');
                // Add animated class to trigger the animation
                setTimeout(function() {
                    bar.classList.add('animated');
                }, 200);
            }
        });

        // Add hover effects to summary cards
        const summaryCards = document.querySelectorAll('.summary-card');
        summaryCards.forEach(function(card) {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Initialize time displays
        updateTimeRemaining();
        setInterval(updateTimeRemaining, 1000);
    });

    // Calculate and display time remaining for campaigns
    function updateTimeRemaining() {
        const timeElements = document.querySelectorAll('.time-display[data-end-date]');

        timeElements.forEach(function(element) {
            const endDate = new Date(element.getAttribute('data-end-date'));
            const now = new Date();
            const timeLeft = endDate - now;

            if (timeLeft <= 0) {
                element.querySelector('.time-text').textContent = 'Ended';
                element.style.color = '#ef4444';
                element.style.fontWeight = '700';
                return;
            }

            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            let timeString = '';
            if (days > 0) {
                timeString += `${days}d `;
            }
            if (hours > 0 || days > 0) {
                timeString += `${hours}h `;
            }
            if (minutes > 0 || hours > 0 || days > 0) {
                timeString += `${minutes}m `;
            }
            timeString += `${seconds}s`;

            element.querySelector('.time-text').textContent = timeString;

            // Color coding based on time remaining
            if (days <= 1) {
                element.style.color = '#ef4444'; // Red for urgent
                element.style.fontWeight = '700';
            } else if (days <= 3) {
                element.style.color = '#f59e0b'; // Orange for warning
                element.style.fontWeight = '600';
            } else {
                element.style.color = '#10b981'; // Green for good
                element.style.fontWeight = '600';
            }
        });
    }
</script>
@endpush