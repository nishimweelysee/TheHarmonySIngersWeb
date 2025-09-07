@extends('layouts.admin')

@section('title', 'User Details')
@section('page-title', 'User Details')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header user-show-header">
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
                <h2 class="header-title">User Profile</h2>
                <p class="header-subtitle">Detailed information for {{ $user->name }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">#{{ $user->id }}</span>
                        <span class="stat-label">User ID</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $user->created_at->diffForHumans() }}</span>
                        <span class="stat-label">Member Since</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $user->role ? $user->role->permissions->count() : 0 }}</span>
                        <span class="stat-label">Permissions</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('edit_users')
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-edit"></i>
                    <span>Edit User</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Users</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced User Details -->
<div class="user-details enhanced-details">
    <div class="details-grid">
        <!-- Basic Information -->
        <div class="detail-card enhanced-card basic-card">
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
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Full Name</span>
                            <span class="info-value">{{ $user->name }}</span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Email Address</span>
                            <span class="info-value">{{ $user->email }}</span>
                        </div>
                    </div>

                    @if($user->phone)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Phone Number</span>
                            <span class="info-value">{{ $user->phone }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope-check"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Email Verification</span>
                            <span class="info-value">
                                @if($user->email_verified_at)
                                <span class="verification-badge enhanced-badge verified">
                                    <div class="status-dot"></div>
                                    <i class="fas fa-check-circle"></i>
                                    Verified
                                </span>
                                @else
                                <span class="verification-badge enhanced-badge unverified">
                                    <div class="status-dot"></div>
                                    <i class="fas fa-times-circle"></i>
                                    Not Verified
                                </span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-toggle-on"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Account Status</span>
                            <span class="info-value">
                                <span class="status-badge enhanced-badge active">
                                    <div class="status-dot"></div>
                                    Active
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">User ID</span>
                            <span class="info-value">#{{ $user->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Role Information with All Permissions -->
        <div class="detail-card enhanced-card role-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-user-tag"></i>
                        Role & Permissions
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Access Rights
                    </div>
                </div>
            </div>
            <div class="card-content">
                @if($user->role)
                <div class="role-details enhanced-role-details">
                    <div class="role-main">
                        <div class="role-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="role-info">
                            <h4 class="role-name">{{ $user->role->display_name }}</h4>
                            <span class="role-slug">{{ $user->role->name }}</span>
                        </div>
                    </div>

                    <div class="role-stats enhanced-role-stats">
                        <div class="stat-item enhanced-stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-key"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">{{ $user->role->permissions->count() }}</span>
                                <span class="stat-label">Total Permissions</span>
                            </div>
                        </div>
                        <div class="stat-item enhanced-stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">{{ $user->role->users->count() }}</span>
                                <span class="stat-label">Users with Role</span>
                            </div>
                        </div>
                    </div>

                    @if($user->role->permissions->count() > 0)
                    <div class="permissions-section">
                        <div class="permissions-header">
                            <h5 class="permissions-title">
                                <i class="fas fa-shield-alt"></i>
                                All Assigned Permissions
                                <span class="permissions-count">({{ $user->role->permissions->count() }})</span>
                            </h5>
                            <div class="permissions-filter">
                                <button class="filter-btn active" data-filter="all">All</button>
                                <button class="filter-btn" data-filter="active">Active</button>
                                <button class="filter-btn" data-filter="inactive">Inactive</button>
                            </div>
                        </div>

                        <div class="permissions-grid enhanced-permissions-grid">
                            @foreach($user->role->permissions as $permission)
                            <div class="permission-item enhanced-permission-item"
                                data-status="{{ $permission->is_active ? 'active' : 'inactive' }}">
                                <div class="permission-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="permission-status">
                                    @if($permission->is_active)
                                    <span class="status-badge enhanced-badge active">
                                        <div class="status-dot"></div>
                                        Active
                                    </span>
                                    @else
                                    <span class="status-badge enhanced-badge inactive">
                                        <div class="status-dot"></div>
                                        Inactive
                                    </span>
                                    @endif
                                </div>
                                <div class="permission-content">
                                    <h6 class="permission-name">{{ $permission->display_name }}</h6>
                                    <span class="permission-key">{{ $permission->name }}</span>
                                </div>
                                <div class="permission-meta">
                                    <span class="module-badge enhanced-badge">
                                        <i class="fas fa-cube"></i>
                                        {{ ucfirst($permission->module ?? 'N/A') }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Permission Summary -->
                        <div class="permissions-summary">
                            <div class="summary-stats">
                                <div class="summary-item">
                                    <span class="summary-label">Active Permissions:</span>
                                    <span
                                        class="summary-value">{{ $user->role->permissions->where('is_active', true)->count() }}</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Inactive Permissions:</span>
                                    <span
                                        class="summary-value">{{ $user->role->permissions->where('is_active', false)->count() }}</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Total Modules:</span>
                                    <span
                                        class="summary-value">{{ $user->role->permissions->pluck('module')->unique()->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="no-permissions enhanced-empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>No Permissions Assigned</h4>
                        <p>This role has no permissions assigned to it.</p>
                    </div>
                    @endif
                </div>
                @else
                <div class="no-role enhanced-empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <h4>No Role Assigned</h4>
                    <p>This user has no role and therefore no permissions in the system.</p>
                    @permission('edit_users')
                    <div class="empty-actions">
                        <a href="{{ route('admin.users.edit-role', $user) }}" class="btn btn-primary">
                            <i class="fas fa-user-tag"></i>
                            <span>Assign Role</span>
                        </a>
                    </div>
                    @endpermission
                </div>
                @endif
            </div>
        </div>

        <!-- Account Timestamps -->
        <div class="detail-card enhanced-card timestamps-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-clock"></i>
                        Account Timeline
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        History
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Account Created</span>
                            <span class="info-value">
                                <div class="date-display">
                                    <span class="date-main">{{ $user->created_at->format('M j, Y \a\t g:i A') }}</span>
                                    <span class="date-ago">{{ $user->created_at->diffForHumans() }}</span>
                                </div>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Last Updated</span>
                            <span class="info-value">
                                <div class="date-display">
                                    <span class="date-main">{{ $user->updated_at->format('M j, Y \a\t g:i A') }}</span>
                                    <span class="date-ago">{{ $user->updated_at->diffForHumans() }}</span>
                                </div>
                            </span>
                        </div>
                    </div>

                    @if($user->email_verified_at)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope-check"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Email Verified</span>
                            <span class="info-value">
                                <div class="date-display">
                                    <span
                                        class="date-main">{{ $user->email_verified_at->format('M j, Y \a\t g:i A') }}</span>
                                    <span class="date-ago">{{ $user->email_verified_at->diffForHumans() }}</span>
                                </div>
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Action Buttons -->
    <div class="action-section enhanced-actions">
        <div class="action-buttons">
            @permission('edit_users')
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary action-btn">
                <i class="fas fa-edit"></i>
                <span>Edit User</span>
            </a>
            @endpermission

            @permission('edit_users')
            <a href="{{ route('admin.users.edit-role', $user) }}" class="btn btn-info action-btn">
                <i class="fas fa-user-tag"></i>
                <span>Edit Role</span>
            </a>
            @endpermission

            @permission('delete_users')
            @if($user->id !== auth()->id())
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger action-btn delete-btn"
                    onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                    <i class="fas fa-trash"></i>
                    <span>Delete User</span>
                </button>
            </form>
            @endif
            @endpermission

            <a href="{{ route('admin.users.index') }}" class="btn btn-outline action-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Users</span>
            </a>
        </div>
    </div>
</div>

@endsection



@push('scripts')
<script>
    // Permission filtering functionality
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const permissionItems = document.querySelectorAll('.permission-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                filterBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                permissionItems.forEach(item => {
                    if (filter === 'all') {
                        item.style.display = 'block';
                        item.style.opacity = '1';
                    } else {
                        const status = item.getAttribute('data-status');
                        if (status === filter) {
                            item.style.display = 'block';
                            item.style.opacity = '1';
                        } else {
                            item.style.display = 'none';
                            item.style.opacity = '0';
                        }
                    }
                });
            });
        });

        // Add hover effects to user cards
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

        // Add hover effects to permission items
        permissionItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.1)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });

        // Add hover effects to filter buttons
        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'scale(1.05)';
                }
            });

            btn.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'scale(1)';
                }
            });
        });
    });
</script>
@endpush