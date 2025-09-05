@extends('layouts.admin')

@section('title', 'Member Details')
@section('page-title', 'Member Details')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header member-show-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-user-circle"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Member Profile</h2>
                <p class="header-subtitle">Detailed information for {{ $member->full_name }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">#{{ $member->id }}</span>
                        <span class="stat-label">Member ID</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $member->join_date->diffForHumans() }}</span>
                        <span class="stat-label">Member Since</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $member->is_active ? 'Active' : 'Inactive' }}</span>
                        <span class="stat-label">Status</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('view_members')
            <a href="{{ route('admin.members.certificate.download', $member) }}" class="btn btn-success enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-download"></i>
                    <span>Download Certificate</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission

            @permission('edit_members')
            <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-edit"></i>
                    <span>Edit Member</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
            <a href="{{ route('admin.members.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Members</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Member Details -->
<div class="member-details enhanced-details">
    <div class="details-grid">
        <!-- Profile Photo and Basic Information -->
        <div class="detail-card enhanced-card profile-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i>
                        Basic Information
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Personal Details
                    </div>
                </div>
            </div>
            <div class="card-content">
                @if($member->profile_photo)
                <div class="profile-photo-container enhanced-photo">
                    <img src="{{ Storage::url($member->profile_photo) }}" alt="Profile Photo" class="profile-photo">
                    <div class="photo-overlay"></div>
                    <div class="photo-badge">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
                @else
                <div class="profile-photo-placeholder enhanced-placeholder">
                    <i class="fas fa-user"></i>
                    <div class="placeholder-glow"></div>
                </div>
                @endif

                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Full Name</span>
                            <span class="info-value">{{ $member->full_name }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $member->email }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Phone</span>
                            <span class="info-value">{{ $member->phone ?? 'Not provided' }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-birthday-cake"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Date of Birth</span>
                            <span class="info-value">
                                @if($member->date_of_birth)
                                {{ $member->date_of_birth->format('M j, Y') }}
                                <span class="age-badge">{{ $member->date_of_birth->age }} years old</span>
                                @else
                                <span class="text-muted">Not provided</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Address</span>
                            <span class="info-value">{{ $member->address ?? 'Not provided' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Choir Information -->
        <div class="detail-card enhanced-card choir-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-music"></i>
                        Choir Information
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Musical Details
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-microphone"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Member Type</span>
                            <span class="info-value">
                                <span class="type-badge enhanced-badge type-{{ $member->type }}">
                                    <i class="fas fa-{{ $member->type === 'singer' ? 'microphone' : 'user' }}"></i>
                                    {{ ucfirst($member->type) }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-music"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Voice Part</span>
                            <span class="info-value">
                                @if($member->voice_part)
                                <span class="voice-badge enhanced-badge voice-{{ $member->voice_part }}">
                                    <i class="fas fa-music"></i>
                                    {{ ucfirst($member->voice_part) }}
                                </span>
                                @else
                                <span class="text-muted">Not specified</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Join Date</span>
                            <span class="info-value">
                                <div class="date-display">
                                    <span class="date-main">{{ $member->join_date->format('M j, Y') }}</span>
                                    <span class="date-ago">{{ $member->join_date->diffForHumans() }}</span>
                                </div>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Status</span>
                            <span class="info-value">
                                <span class="status-badge enhanced-badge {{ $member->is_active ? 'active' : 'inactive' }}">
                                    <div class="status-dot"></div>
                                    {{ $member->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </span>
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
                            <span class="info-label">Member Since</span>
                            <span class="info-value">{{ $member->join_date->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Created</span>
                            <span class="info-value">{{ $member->created_at->format('M j, Y \a\t g:i A') }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Last Updated</span>
                            <span class="info-value">{{ $member->updated_at->format('M j, Y \a\t g:i A') }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Member ID</span>
                            <span class="info-value">#{{ $member->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Action Buttons -->
    <div class="action-section enhanced-actions">
        <div class="action-buttons">
            @permission('edit_members')
            <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-primary action-btn">
                <i class="fas fa-edit"></i>
                <span>Edit Member</span>
            </a>
            @endpermission

            @permission('delete_members')
            <form method="POST" action="{{ route('admin.members.destroy', $member) }}" class="inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger action-btn delete-btn"
                    onclick="return confirm('Are you sure you want to delete this member? This action cannot be undone.')">
                    <i class="fas fa-trash"></i>
                    <span>Delete Member</span>
                </button>
            </form>
            @endpermission

            <a href="{{ route('admin.members.index') }}" class="btn btn-outline action-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Members</span>
            </a>
        </div>
    </div>
</div>

@endsection