@extends('layouts.admin')

@section('title', 'Year Plan Details')
@section('page-title', 'Year Plan Details')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header plan-show-header">
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
                <h2 class="header-title">Year Plan Profile</h2>
                <p class="header-subtitle">Detailed information for {{ $plan->title }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">#{{ $plan->id }}</span>
                        <span class="stat-label">Plan ID</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $plan->year }}</span>
                        <span class="stat-label">Year</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ ucfirst(str_replace('_', ' ', $plan->status)) }}</span>
                        <span class="stat-label">Status</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('edit_plans')
            <a href="{{ route('admin.plans.edit', $plan) }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-edit"></i>
                    <span>Edit Plan</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
            <a href="{{ route('admin.plans.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Plans</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Plan Details -->
<div class="plan-details enhanced-details">
    <div class="details-grid">
        <!-- Basic Information -->
        <div class="detail-card enhanced-card basic-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Basic Information
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Plan Details
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Plan Title</span>
                            <span class="info-value">{{ $plan->title }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Year</span>
                            <span class="info-value">
                                <span class="year-badge enhanced-badge">
                                    <i class="fas fa-calendar"></i>
                                    {{ $plan->year }}
                                </span>
                            </span>
                        </div>
                    </div>

                    @if($plan->period_type)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Period Type</span>
                            <span class="info-value">
                                <span class="period-badge enhanced-badge">
                                    <i class="fas fa-calendar-week"></i>
                                    {{ ucfirst($plan->period_type) }}
                                </span>
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($plan->quarter)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Quarter</span>
                            <span class="info-value">{{ $plan->quarter }}</span>
                        </div>
                    </div>
                    @endif

                    @if($plan->month)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Month</span>
                            <span class="info-value">{{ date('F', mktime(0, 0, 0, $plan->month, 1)) }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-toggle-on"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Status</span>
                            <span class="info-value">
                                <span class="status-badge enhanced-badge status-{{ $plan->status }}">
                                    <div class="status-dot"></div>
                                    {{ ucfirst(str_replace('_', ' ', $plan->status)) }}
                                </span>
                            </span>
                        </div>
                    </div>

                    @if($plan->category)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Category</span>
                            <span class="info-value">{{ ucfirst($plan->category) }}</span>
                        </div>
                    </div>
                    @endif
                </div>

                @if($plan->description)
                <div class="description-section">
                    <div class="section-title enhanced-label">
                        <i class="fas fa-align-left"></i>
                        Description
                    </div>
                    <div class="description-text">{{ $plan->description }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Timeline Information -->
        <div class="detail-card enhanced-card timeline-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-clock"></i>
                        Timeline Information
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Schedule
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Start Date</span>
                            <span class="info-value">
                                <div class="date-display">
                                    <span class="date-main">{{ $plan->start_date->format('M j, Y') }}</span>
                                    <span class="date-ago">{{ $plan->start_date->diffForHumans() }}</span>
                                </div>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-flag-checkered"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">End Date</span>
                            <span class="info-value">
                                <div class="date-display">
                                    <span class="date-main">{{ $plan->end_date->format('M j, Y') }}</span>
                                    <span class="date-ago">{{ $plan->end_date->diffForHumans() }}</span>
                                </div>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Duration</span>
                            <span class="info-value">{{ $plan->start_date->diffInDays($plan->end_date) + 1 }} days</span>
                        </div>
                    </div>

                    @if($plan->estimated_budget)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Estimated Budget</span>
                            <span class="info-value amount-highlight">${{ number_format($plan->estimated_budget, 2) }}</span>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Timeline Visual -->
                <div class="timeline-visual">
                    <div class="timeline-item">
                        <div class="timeline-marker start">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="timeline-content">
                            <label class="timeline-label">Start Date</label>
                            <div class="timeline-date">{{ $plan->start_date->format('M j, Y') }}</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker end">
                            <i class="fas fa-flag-checkered"></i>
                        </div>
                        <div class="timeline-content">
                            <label class="timeline-label">End Date</label>
                            <div class="timeline-date">{{ $plan->end_date->format('M j, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="detail-card enhanced-card additional-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Additional Information
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        System Details
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Created</span>
                            <span class="info-value">{{ $plan->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Created Date</span>
                            <span class="info-value">{{ $plan->created_at->format('M j, Y \a\t g:i A') }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Last Updated</span>
                            <span class="info-value">{{ $plan->updated_at->format('M j, Y \a\t g:i A') }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Plan ID</span>
                            <span class="info-value">#{{ $plan->id }}</span>
                        </div>
                    </div>
                </div>

                @if($plan->notes)
                <div class="notes-section">
                    <div class="section-title enhanced-label">
                        <i class="fas fa-sticky-note"></i>
                        Notes
                    </div>
                    <div class="notes-text">{{ $plan->notes }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Enhanced Action Buttons -->
    <div class="action-section enhanced-actions">
        <div class="action-buttons">
            @permission('edit_plans')
            <a href="{{ route('admin.plans.edit', $plan) }}" class="btn btn-primary action-btn">
                <i class="fas fa-edit"></i>
                <span>Edit Plan</span>
            </a>
            @endpermission

            @permission('delete_plans')
            <form method="POST" action="{{ route('admin.plans.destroy', $plan) }}" class="inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger action-btn delete-btn"
                    onclick="return confirm('Are you sure you want to delete this plan? This action cannot be undone.')">
                    <i class="fas fa-trash"></i>
                    <span>Delete Plan</span>
                </button>
            </form>
            @endpermission

            <a href="{{ route('admin.plans.index') }}" class="btn btn-outline action-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Plans</span>
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Add hover effects to plan cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.detail-card');

        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.15)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });
    });
</script>
@endpush