@extends('layouts.admin')

@section('title', 'Sponsor Details')
@section('page-title', 'Sponsor Details')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header sponsor-show-header">
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
                <h2 class="header-title">Sponsor Profile</h2>
                <p class="header-subtitle">Detailed information for {{ $sponsor->name }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">#{{ $sponsor->id }}</span>
                        <span class="stat-label">Sponsor ID</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $sponsor->partnership_start_date ? $sponsor->partnership_start_date->diffForHumans() : 'Not set' }}</span>
                        <span class="stat-label">Partnership Since</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ ucfirst($sponsor->status) }}</span>
                        <span class="stat-label">Status</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('edit_sponsors')
            <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-edit"></i>
                    <span>Edit Sponsor</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
            <a href="{{ route('admin.sponsors.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Sponsors</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Sponsor Details -->
<div class="sponsor-details enhanced-details">
    <div class="details-grid">
        <!-- Basic Information -->
        <div class="detail-card enhanced-card basic-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-building"></i>
                        Basic Information
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Organization Details
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Organization Name</span>
                            <span class="info-value">{{ $sponsor->name }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Sponsor Type</span>
                            <span class="info-value">
                                <span class="type-badge enhanced-badge type-{{ $sponsor->type }}">
                                    <i class="fas fa-{{ $sponsor->type === 'corporate' ? 'building' : ($sponsor->type === 'individual' ? 'user' : ($sponsor->type === 'foundation' ? 'university' : 'landmark')) }}"></i>
                                    {{ ucfirst($sponsor->type) }}
                                </span>
                            </span>
                        </div>
                    </div>

                    @if($sponsor->category)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Category</span>
                            <span class="info-value">{{ $sponsor->category }}</span>
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
                                <span class="status-badge enhanced-badge {{ $sponsor->status }}">
                                    <div class="status-dot"></div>
                                    {{ ucfirst($sponsor->status) }}
                                </span>
                            </span>
                        </div>
                    </div>

                    @if($sponsor->address)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Address</span>
                            <span class="info-value">{{ $sponsor->address }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="detail-card enhanced-card contact-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-address-book"></i>
                        Contact Information
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Communication Details
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    @if($sponsor->contact_person)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Contact Person</span>
                            <span class="info-value">{{ $sponsor->contact_person }}</span>
                        </div>
                    </div>
                    @endif

                    @if($sponsor->contact_email)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Email</span>
                            <span class="info-value">
                                <a href="mailto:{{ $sponsor->contact_email }}" class="link-highlight">{{ $sponsor->contact_email }}</a>
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($sponsor->contact_phone)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Phone</span>
                            <span class="info-value">
                                <a href="tel:{{ $sponsor->contact_phone }}" class="link-highlight">{{ $sponsor->contact_phone }}</a>
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($sponsor->website)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Website</span>
                            <span class="info-value">
                                <a href="{{ $sponsor->website }}" target="_blank" class="link-highlight">{{ $sponsor->website }}</a>
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sponsorship Details -->
        <div class="detail-card enhanced-card sponsorship-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-star"></i>
                        Sponsorship Details
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Partnership Information
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    @if($sponsor->sponsorship_level)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-crown"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Sponsorship Level</span>
                            <span class="info-value">
                                <span class="level-badge enhanced-badge level-{{ $sponsor->sponsorship_level }}">
                                    <i class="fas fa-star"></i>
                                    {{ ucfirst($sponsor->sponsorship_level) }}
                                </span>
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($sponsor->annual_contribution)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Annual Contribution</span>
                            <span class="info-value amount-highlight">${{ number_format($sponsor->annual_contribution, 2) }}</span>
                        </div>
                    </div>
                    @endif

                    @if($sponsor->partnership_start_date)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Partnership Start Date</span>
                            <span class="info-value">
                                <div class="date-display">
                                    <span class="date-main">{{ $sponsor->partnership_start_date->format('M j, Y') }}</span>
                                    <span class="date-ago">{{ $sponsor->partnership_start_date->diffForHumans() }}</span>
                                </div>
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($sponsor->partnership_end_date)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar-minus"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Partnership End Date</span>
                            <span class="info-value">
                                <div class="date-display">
                                    <span class="date-main">{{ $sponsor->partnership_end_date->format('M j, Y') }}</span>
                                    <span class="date-ago">{{ $sponsor->partnership_end_date->diffForHumans() }}</span>
                                </div>
                            </span>
                        </div>
                    </div>
                    @endif
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
                            <span class="info-label">Partnership Since</span>
                            <span class="info-value">{{ $sponsor->partnership_start_date ? $sponsor->partnership_start_date->diffForHumans() : 'Not set' }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Created</span>
                            <span class="info-value">{{ $sponsor->created_at->format('M j, Y \a\t g:i A') }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Last Updated</span>
                            <span class="info-value">{{ $sponsor->updated_at->format('M j, Y \a\t g:i A') }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Sponsor ID</span>
                            <span class="info-value">#{{ $sponsor->id }}</span>
                        </div>
                    </div>
                </div>

                @if($sponsor->notes)
                <div class="notes-section">
                    <div class="section-title enhanced-label">
                        <i class="fas fa-sticky-note"></i>
                        Notes
                    </div>
                    <div class="notes-text">{{ $sponsor->notes }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Enhanced Action Buttons -->
    <div class="action-section enhanced-actions">
        <div class="action-buttons">
            @permission('edit_sponsors')
            <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="btn btn-primary action-btn">
                <i class="fas fa-edit"></i>
                <span>Edit Sponsor</span>
            </a>
            @endpermission

            @permission('delete_sponsors')
            <form method="POST" action="{{ route('admin.sponsors.destroy', $sponsor) }}" class="inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger action-btn delete-btn"
                    onclick="return confirm('Are you sure you want to delete this sponsor? This action cannot be undone.')">
                    <i class="fas fa-trash"></i>
                    <span>Delete Sponsor</span>
                </button>
            </form>
            @endpermission

            <a href="{{ route('admin.sponsors.index') }}" class="btn btn-outline action-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Sponsors</span>
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Add hover effects to sponsor cards
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