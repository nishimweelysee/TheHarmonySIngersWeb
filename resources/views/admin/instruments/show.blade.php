@extends('layouts.admin')

@section('title', 'Instrument Details')
@section('page-title', 'Instrument Details')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header instrument-show-header">
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
                <h2 class="header-title">Instrument Profile</h2>
                <p class="header-subtitle">Detailed information for {{ $instrument->name }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">#{{ $instrument->id }}</span>
                        <span class="stat-label">Instrument ID</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ ucfirst($instrument->type) }}</span>
                        <span class="stat-label">Type</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $instrument->is_available ? 'Available' : 'Not Available' }}</span>
                        <span class="stat-label">Status</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('edit_instruments')
            <a href="{{ route('admin.instruments.edit', $instrument) }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-edit"></i>
                    <span>Edit Instrument</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
            <a href="{{ route('admin.instruments.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Instruments</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Instrument Details -->
<div class="instrument-details enhanced-details">
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
                        Instrument Details
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-guitar"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Instrument Name</span>
                            <span class="info-value">{{ $instrument->name }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Type</span>
                            <span class="info-value">
                                <span class="type-badge enhanced-badge type-{{ $instrument->type }}">
                                    <i class="fas fa-{{ $instrument->type === 'string' ? 'guitar' : ($instrument->type === 'wind' ? 'wind' : ($instrument->type === 'percussion' ? 'drum' : ($instrument->type === 'keyboard' ? 'piano' : 'microchip'))) }}"></i>
                                    {{ ucfirst($instrument->type) }}
                                </span>
                            </span>
                        </div>
                    </div>

                    @if($instrument->brand)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Brand</span>
                            <span class="info-value">{{ $instrument->brand }}</span>
                        </div>
                    </div>
                    @endif

                    @if($instrument->model)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-cube"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Model</span>
                            <span class="info-value">{{ $instrument->model }}</span>
                        </div>
                    </div>
                    @endif

                    @if($instrument->serial_number)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-barcode"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Serial Number</span>
                            <span class="info-value">{{ $instrument->serial_number }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-toggle-on"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Availability</span>
                            <span class="info-value">
                                <span class="availability-badge enhanced-badge {{ $instrument->is_available ? 'available' : 'unavailable' }}">
                                    <div class="status-dot"></div>
                                    {{ $instrument->is_available ? 'Available' : 'Not Available' }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                @if($instrument->description)
                <div class="description-section">
                    <div class="section-title enhanced-label">
                        <i class="fas fa-align-left"></i>
                        Description
                    </div>
                    <div class="description-text">{{ $instrument->description }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Technical Information -->
        <div class="detail-card enhanced-card technical-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-cogs"></i>
                        Technical Information
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Specifications
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    @if($instrument->condition)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Condition</span>
                            <span class="info-value">
                                <span class="condition-badge enhanced-badge condition-{{ $instrument->condition }}">
                                    <i class="fas fa-circle"></i>
                                    {{ ucfirst($instrument->condition) }}
                                </span>
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($instrument->purchase_date)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Purchase Date</span>
                            <span class="info-value">
                                <div class="date-display">
                                    <span class="date-main">{{ $instrument->purchase_date->format('M j, Y') }}</span>
                                    <span class="date-ago">{{ $instrument->purchase_date->diffForHumans() }}</span>
                                </div>
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($instrument->purchase_price)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Purchase Price</span>
                            <span class="info-value amount-highlight">${{ number_format($instrument->purchase_price, 2) }}</span>
                        </div>
                    </div>
                    @endif

                    @if($instrument->location)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Location</span>
                            <span class="info-value">{{ $instrument->location }}</span>
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
                            <span class="info-label">Added to Inventory</span>
                            <span class="info-value">{{ $instrument->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Created</span>
                            <span class="info-value">{{ $instrument->created_at->format('M j, Y \a\t g:i A') }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Last Updated</span>
                            <span class="info-value">{{ $instrument->updated_at->format('M j, Y \a\t g:i A') }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Instrument ID</span>
                            <span class="info-value">#{{ $instrument->id }}</span>
                        </div>
                    </div>
                </div>

                @if($instrument->notes)
                <div class="notes-section">
                    <div class="section-title enhanced-label">
                        <i class="fas fa-sticky-note"></i>
                        Notes
                    </div>
                    <div class="notes-text">{{ $instrument->notes }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Enhanced Action Buttons -->
    <div class="action-section enhanced-actions">
        <div class="action-buttons">
            @permission('edit_instruments')
            <a href="{{ route('admin.instruments.edit', $instrument) }}" class="btn btn-primary action-btn">
                <i class="fas fa-edit"></i>
                <span>Edit Instrument</span>
            </a>
            @endpermission

            @permission('delete_instruments')
            <form method="POST" action="{{ route('admin.instruments.destroy', $instrument) }}" class="inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger action-btn delete-btn"
                    onclick="return confirm('Are you sure you want to delete this instrument? This action cannot be undone.')">
                    <i class="fas fa-trash"></i>
                    <span>Delete Instrument</span>
                </button>
            </form>
            @endpermission

            <a href="{{ route('admin.instruments.index') }}" class="btn btn-outline action-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Instruments</span>
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Add hover effects to instrument cards
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