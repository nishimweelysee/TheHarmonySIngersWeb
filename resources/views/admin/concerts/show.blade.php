@extends('layouts.admin')

@section('title', 'Concert Details')
@section('page-title', 'Concert Details')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header concert-show-header">
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
                <h2 class="header-title">{{ $concert->title }}</h2>
                <p class="header-subtitle">Concert Details & Information</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-calendar"></i>
                        </span>
                        <span class="stat-label">
                            @if($concert->date)
                            {{ $concert->date->format('M j, Y') }}
                            @else
                            TBD
                            @endif
                        </span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-clock"></i>
                        </span>
                        <span class="stat-label">{{ $concert->time }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        <span class="stat-label">{{ $concert->venue }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('update_concerts')
            <a href="{{ route('admin.concerts.edit', $concert) }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-edit"></i>
                    <span>Edit Concert</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
            <a href="{{ route('admin.concerts.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Concerts</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Concert Details -->
<div class="concert-details enhanced-details">
    <div class="details-grid enhanced-grid">
        <!-- Basic Information -->
        <div class="detail-card enhanced-card">
            <div class="card-header enhanced-header">
                <h3 class="card-title">
                    <i class="fas fa-music"></i>
                    Concert Information
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Event Details
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-heading"></i>
                            Title
                        </span>
                        <span class="info-value enhanced-value">{{ $concert->title }}</span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-tag"></i>
                            Type
                        </span>
                        <span class="info-value enhanced-value">
                            <span class="badge badge-{{ $concert->type === 'special' ? 'primary' : 'secondary' }} enhanced-badge">
                                {{ ucfirst($concert->type) }}
                            </span>
                        </span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-info-circle"></i>
                            Status
                        </span>
                        <span class="info-value enhanced-value">
                            <span class="badge badge-{{ $concert->status === 'upcoming' ? 'success' : ($concert->status === 'ongoing' ? 'warning' : ($concert->status === 'completed' ? 'info' : 'danger')) }} enhanced-badge">
                                {{ ucfirst($concert->status) }}
                            </span>
                        </span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-star"></i>
                            Featured Event
                        </span>
                        <span class="info-value enhanced-value">
                            <span class="badge badge-{{ $concert->is_featured ? 'success' : 'secondary' }} enhanced-badge">
                                {{ $concert->is_featured ? 'Yes' : 'No' }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Date and Time -->
        <div class="detail-card enhanced-card">
            <div class="card-header enhanced-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-alt"></i>
                    Date & Time
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Schedule
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-calendar"></i>
                            Date
                        </span>
                        <span class="info-value enhanced-value">
                            @if($concert->date)
                            {{ $concert->date->format('l, F j, Y') }}
                            @else
                            <span class="text-muted">Not specified</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-clock"></i>
                            Time
                        </span>
                        <span class="info-value enhanced-value">{{ $concert->time }}</span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-calendar-day"></i>
                            Day of Week
                        </span>
                        <span class="info-value enhanced-value">
                            @if($concert->date)
                            {{ $concert->date->format('l') }}
                            @else
                            <span class="text-muted">Not specified</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-hourglass-half"></i>
                            Days Until
                        </span>
                        <span class="info-value enhanced-value">
                            @if($concert->date && $concert->date->isFuture())
                            {{ $concert->date->diffForHumans() }}
                            @elseif($concert->date && $concert->date->isPast())
                            <span class="text-muted">Event has passed</span>
                            @else
                            <span class="text-muted">Date not set</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Venue and Location -->
        <div class="detail-card enhanced-card">
            <div class="card-header enhanced-header">
                <h3 class="card-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Venue & Location
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Location
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-building"></i>
                            Venue
                        </span>
                        <span class="info-value enhanced-value">{{ $concert->venue }}</span>
                    </div>
                    @if($concert->max_attendees)
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-users"></i>
                            Capacity
                        </span>
                        <span class="info-value enhanced-value">{{ number_format($concert->max_attendees) }} people</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Financial Information -->
        @if($concert->ticket_price)
        <div class="detail-card enhanced-card">
            <div class="card-header enhanced-header">
                <h3 class="card-title">
                    <i class="fas fa-dollar-sign"></i>
                    Financial Details
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Pricing
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-ticket-alt"></i>
                            Ticket Price
                        </span>
                        <span class="info-value enhanced-value price-value">
                            ${{ number_format($concert->ticket_price, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Description -->
        @if($concert->description)
        <div class="detail-card enhanced-card full-width">
            <div class="card-header enhanced-header">
                <h3 class="card-title">
                    <i class="fas fa-align-left"></i>
                    Description
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Event Details
                </div>
            </div>
            <div class="card-content">
                <div class="description-content enhanced-description">
                    <p>{{ $concert->description }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Additional Information -->
        <div class="detail-card enhanced-card full-width">
            <div class="card-header enhanced-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Additional Information
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Metadata
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-calendar-plus"></i>
                            Created
                        </span>
                        <span class="info-value enhanced-value">{{ $concert->created_at->format('M j, Y \a\t g:i A') }}</span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-calendar-check"></i>
                            Last Updated
                        </span>
                        <span class="info-value enhanced-value">{{ $concert->updated_at->format('M j, Y \a\t g:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection