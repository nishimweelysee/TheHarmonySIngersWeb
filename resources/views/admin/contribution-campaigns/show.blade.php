@extends('layouts.admin')

@section('title', 'Campaign Details')
@section('page-title', 'Campaign Details')

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
                <h2 class="header-title">{{ $contributionCampaign->name }}</h2>
                <p class="header-subtitle">Campaign Details & Contributions</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $contributionCampaign->currency }} {{ number_format($contributionCampaign->current_amount, 2) }}</span>
                        <span class="stat-label">Total Raised</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $contributionCampaign->individualContributions->count() }}</span>
                        <span class="stat-label">Contributions</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $contributionCampaign->status === 'active' ? 'Active' : ucfirst($contributionCampaign->status) }}</span>
                        <span class="stat-label">Status</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('edit_contribution_campaigns')
            <a href="{{ route('admin.contribution-campaigns.edit', $contributionCampaign) }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-edit"></i>
                    <span>Edit Campaign</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
            <a href="{{ route('admin.contribution-campaigns.index') }}" class="btn btn-secondary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Campaigns</span>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="campaigns-grid enhanced-grid">
    <!-- Campaign Information Card -->
    <div class="campaign-card enhanced-card">
        <div class="card-header enhanced-header">
            <h3 class="card-title">
                <i class="fas fa-info-circle"></i>
                Campaign Information
            </h3>
        </div>
        <div class="card-body">
            <div class="info-grid enhanced-form-grid">
                <div class="info-item enhanced-form-group">
                    <label class="info-label enhanced-label">Campaign Name</label>
                    <div class="info-value">{{ $contributionCampaign->name }}</div>
                </div>

                <div class="info-item enhanced-form-group">
                    <label class="info-label enhanced-label">Type</label>
                    <div class="info-value">
                        <span class="type-badge enhanced-badge type-{{ $contributionCampaign->type }}">
                            {{ ucfirst($contributionCampaign->type) }}
                        </span>
                    </div>
                </div>

                <div class="info-item enhanced-form-group">
                    <label class="info-label enhanced-label">Status</label>
                    <div class="info-value">
                        <span class="status-badge enhanced-badge status-{{ $contributionCampaign->status }}">
                            {{ ucfirst($contributionCampaign->status) }}
                        </span>
                    </div>
                </div>

                <div class="info-item enhanced-form-group">
                    <label class="info-label enhanced-label">Start Date</label>
                    <div class="info-value">{{ $contributionCampaign->start_date->format('M j, Y') }}</div>
                </div>

                <div class="info-item enhanced-form-group">
                    <label class="info-label enhanced-label">End Date</label>
                    <div class="info-value">{{ $contributionCampaign->end_date->format('M j, Y') }}</div>
                </div>

                <div class="info-item enhanced-form-group">
                    <label class="info-label enhanced-label">Currency</label>
                    <div class="info-value">{{ $contributionCampaign->currency }}</div>
                </div>

                <div class="info-item enhanced-form-group">
                    <label class="info-label enhanced-label">Target Amount</label>
                    <div class="info-value">
                        @if($contributionCampaign->target_amount)
                        <span class="amount-highlight">{{ $contributionCampaign->currency }} {{ number_format($contributionCampaign->target_amount, 2) }}</span>
                        @else
                        <span class="text-muted">Not set</span>
                        @endif
                    </div>
                </div>

                <div class="info-item enhanced-form-group">
                    <label class="info-label enhanced-label">Minimum Amount Per Person</label>
                    <div class="info-value">
                        @if($contributionCampaign->min_amount_per_person)
                        <span class="amount-highlight">{{ $contributionCampaign->currency }} {{ number_format($contributionCampaign->min_amount_per_person, 2) }}</span>
                        @else
                        <span class="text-muted">No minimum</span>
                        @endif
                    </div>
                </div>

                <div class="info-item enhanced-form-group">
                    <label class="info-label enhanced-label">Current Amount</label>
                    <div class="info-value">
                        <span class="amount-highlight {{ $contributionCampaign->current_amount > 0 ? 'text-success' : 'text-muted' }}">
                            {{ $contributionCampaign->currency }} {{ number_format($contributionCampaign->current_amount, 2) }}
                        </span>
                    </div>
                </div>

                @if($contributionCampaign->yearPlan)
                <div class="info-item enhanced-form-group">
                    <label class="info-label enhanced-label">Year Plan</label>
                    <div class="info-value">
                        <a href="#" class="year-plan-link">{{ $contributionCampaign->yearPlan->title ?? 'N/A' }}</a>
                    </div>
                </div>
                @endif
            </div>

            @if($contributionCampaign->description)
            <div class="description-section">
                <h4 class="section-title enhanced-label">Description</h4>
                <div class="description-text">{{ $contributionCampaign->description }}</div>
            </div>
            @endif

            @if($contributionCampaign->campaign_notes)
            <div class="notes-section">
                <h4 class="section-title enhanced-label">Campaign Notes</h4>
                <div class="notes-text">{{ $contributionCampaign->campaign_notes }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Progress Chart Card -->
    @if($contributionCampaign->target_amount)
    <div class="campaign-card enhanced-card">
        <div class="card-header enhanced-header">
            <h3 class="card-title">
                <i class="fas fa-chart-line"></i>
                Progress
            </h3>
        </div>
        <div class="card-body">
            <div class="progress-section">
                @php
                $percentage = $contributionCampaign->target_amount > 0 ? ($contributionCampaign->current_amount / $contributionCampaign->target_amount) * 100 : 0;
                @endphp

                <div class="progress-header">
                    <div class="progress-label">Campaign Progress</div>
                    <div class="progress-percentage">{{ number_format($percentage, 1) }}% Complete</div>
                </div>

                <div class="progress-bar enhanced-progress">
                    <div class="progress-fill" data-width="{{ min($percentage, 100) }}"></div>
                </div>

                <div class="progress-amounts">
                    <div class="raised-amount">
                        <span class="amount-label">Raised:</span>
                        <span class="amount-value">{{ $contributionCampaign->currency }} {{ number_format($contributionCampaign->current_amount, 2) }}</span>
                    </div>
                    <div class="target-amount">
                        <span class="amount-label">Target:</span>
                        <span class="amount-value">{{ $contributionCampaign->currency }} {{ number_format($contributionCampaign->target_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Contributions List Card -->
    <div class="campaign-card enhanced-card full-width-card">
        <div class="card-header enhanced-header">
            <h3 class="card-title">
                <i class="fas fa-hand-holding-usd"></i>
                Contributions
            </h3>
            <div class="header-actions">
                @permission('manage_campaign_contributions')
                <a href="{{ route('admin.contribution-campaigns.add-contribution', $contributionCampaign) }}" class="btn btn-primary enhanced-btn btn-sm">
                    <div class="btn-content">
                        <i class="fas fa-plus"></i>
                        <span>Add Contribution</span>
                    </div>
                </a>
                @endpermission
                @permission('view_contribution_campaigns')
                <a href="{{ route('admin.contribution-campaigns.export-contributors.excel', $contributionCampaign) }}" class="btn btn-success enhanced-btn btn-sm">
                    <div class="btn-content">
                        <i class="fas fa-file-excel"></i>
                        <span>Export Excel</span>
                    </div>
                </a>
                <a href="{{ route('admin.contribution-campaigns.export-contributors.pdf', $contributionCampaign) }}" class="btn btn-danger enhanced-btn btn-sm">
                    <div class="btn-content">
                        <i class="fas fa-file-pdf"></i>
                        <span>Export PDF</span>
                    </div>
                </a>
                @endpermission
            </div>
        </div>
        <div class="card-body">
            @if($contributionCampaign->individualContributions->count() > 0)
            <div class="contributions-table">
                <table class="data-table enhanced-table">
                    <thead>
                        <tr>
                            <th>Contributor</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contributionCampaign->individualContributions as $contribution)
                        <tr class="contribution-row">
                            <td>
                                <div class="contributor-info">
                                    <div class="contributor-name">{{ $contribution->contributor_name }}</div>
                                    @if($contribution->contributor_email)
                                    <div class="contributor-email">{{ $contribution->contributor_email }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="amount-info">
                                    <div class="amount amount-highlight">{{ $contribution->currency }} {{ number_format($contribution->amount, 2) }}</div>
                                </div>
                            </td>
                            <td>{{ $contribution->contribution_date->format('M j, Y') }}</td>
                            <td>
                                <span class="payment-method">{{ ucwords(str_replace('_', ' ', $contribution->payment_method)) }}</span>
                            </td>
                            <td>
                                <span class="status-badge enhanced-badge status-{{ $contribution->status }}">
                                    {{ ucfirst($contribution->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @permission('manage_campaign_contributions')
                                    <a href="{{ route('admin.contribution-campaigns.edit-contribution', ['contributionCampaign' => $contributionCampaign, 'contribution' => $contribution]) }}" class="btn btn-sm btn-secondary enhanced-btn">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.contribution-campaigns.remove-contribution', ['contributionCampaign' => $contributionCampaign, 'contribution' => $contribution]) }}" method="POST" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this contribution?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger enhanced-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endpermission
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state enhanced-empty">
                <div class="empty-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <h3 class="empty-title">No Contributions Yet</h3>
                <p class="empty-description">This campaign hasn't received any contributions yet.</p>
                <div class="empty-actions">
                    @permission('manage_campaign_contributions')
                    <a href="{{ route('admin.contribution-campaigns.add-contribution', $contributionCampaign) }}" class="btn btn-primary enhanced-btn">
                        <div class="btn-content">
                            <i class="fas fa-plus"></i>
                            <span>Add First Contribution</span>
                        </div>
                    </a>
                    @endpermission
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection



@push('scripts')
<script>
    // Initialize progress bars and enhance UI
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

        // Add hover effects to contribution rows
        const contributionRows = document.querySelectorAll('.contribution-row');
        contributionRows.forEach(function(row) {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
            });

            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    });
</script>
@endpush