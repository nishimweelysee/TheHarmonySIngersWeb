@extends('layouts.admin')

@section('title', 'Role Details')
@section('page-title', 'Role Details')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header role-show-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-user-tag"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Role Profile</h2>
                <p class="header-subtitle">Detailed information for {{ $role->display_name }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">#{{ $role->id }}</span>
                        <span class="stat-label">Role ID</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $role->permissions->count() }}</span>
                        <span class="stat-label">Permissions</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $role->users->count() }}</span>
                        <span class="stat-label">Users</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('manage_roles')
            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-edit"></i>
                    <span>Edit Role</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Roles</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Role Details -->
<div class="role-details enhanced-details">
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
                        Role Details
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Role Name</span>
                            <span class="info-value">
                                <code class="role-name-code">{{ $role->name }}</code>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Display Name</span>
                            <span class="info-value">{{ $role->display_name }}</span>
                        </div>
                    </div>

                    @if($role->description)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-align-left"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Description</span>
                            <span class="info-value">{{ $role->description }}</span>
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
                                @if($role->is_active)
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
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-sort-numeric-up"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Priority Level</span>
                            <span class="info-value">
                                <span class="priority-badge enhanced-badge priority-{{ $role->priority ?? 2 }}">
                                    <i class="fas fa-flag"></i>
                                    Level {{ $role->priority ?? 2 }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Role ID</span>
                            <span class="info-value">#{{ $role->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions Information -->
        <div class="detail-card enhanced-card permissions-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-shield-alt"></i>
                        Permissions
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Access Rights
                    </div>
                </div>
            </div>
            <div class="card-content">
                @if($role->permissions->count() > 0)
                <div class="permissions-overview">
                    <div class="permissions-summary">
                        <div class="summary-stats">
                            <div class="stat-item">
                                <div class="stat-icon stat-icon-permissions">
                                    <i class="fas fa-key"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-number">{{ $role->permissions->count() }}</span>
                                    <span class="stat-label">Total Permissions</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon stat-icon-modules">
                                    <i class="fas fa-cube"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-number">{{ $role->permissions->groupBy('module')->count() }}</span>
                                    <span class="stat-label">Modules</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="permissions-by-module">
                        @foreach($role->permissions->groupBy('module') as $module => $modulePermissions)
                        <div class="module-section">
                            <div class="module-header">
                                <h5 class="module-title">
                                    <i class="fas fa-cube"></i>
                                    {{ ucfirst($module) }}
                                </h5>
                                <span class="permission-count">{{ $modulePermissions->count() }} permissions</span>
                            </div>
                            <div class="permissions-list">
                                @foreach($modulePermissions as $permission)
                                <div class="permission-item">
                                    <div class="permission-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="permission-details">
                                        <span class="permission-name">{{ $permission->display_name }}</span>
                                        @if($permission->description)
                                        <span class="permission-description">{{ $permission->description }}</span>
                                        @endif
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
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="no-permissions enhanced-empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>No Permissions Assigned</h4>
                    <p>This role currently has no permissions assigned.</p>
                    @permission('manage_roles')
                    <div class="empty-actions">
                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Assign Permissions
                        </a>
                    </div>
                    @endpermission
                </div>
                @endif
            </div>
        </div>

        <!-- Users Information -->
        <div class="detail-card enhanced-card users-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i>
                        Assigned Users
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        User List
                    </div>
                </div>
            </div>
            <div class="card-content">
                @if($role->users->count() > 0)
                <div class="users-overview">
                    <div class="users-summary">
                        <div class="summary-stats">
                            <div class="stat-item">
                                <div class="stat-icon stat-icon-users">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-number">{{ $role->users->count() }}</span>
                                    <span class="stat-label">Total Users</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="users-list">
                        @foreach($role->users->take(8) as $user)
                        <div class="user-item">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-details">
                                <span class="user-name">{{ $user->name }}</span>
                                <span class="user-email">{{ $user->email }}</span>
                            </div>
                            <div class="user-actions">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline">
                                    <i class="fas fa-eye"></i>
                                    <span>View</span>
                                </a>
                            </div>
                        </div>
                        @endforeach
                        @if($role->users->count() > 8)
                        <div class="more-users">
                            <i class="fas fa-ellipsis-h"></i>
                            <span>{{ $role->users->count() - 8 }} more users...</span>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <div class="no-users enhanced-empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <h4>No Users Assigned</h4>
                    <p>No users are currently assigned to this role.</p>
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
                        Timeline
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
                            <span class="info-label">Created</span>
                            <span class="info-value">
                                <div class="date-display">
                                    <span class="date-main">{{ $role->created_at->format('M j, Y \a\t g:i A') }}</span>
                                    <span class="date-ago">{{ $role->created_at->diffForHumans() }}</span>
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
                                    <span class="date-main">{{ $role->updated_at->format('M j, Y \a\t g:i A') }}</span>
                                    <span class="date-ago">{{ $role->updated_at->diffForHumans() }}</span>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Action Buttons -->
    <div class="action-section enhanced-actions">
        <div class="action-buttons">
            @permission('manage_roles')
            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary action-btn">
                <i class="fas fa-edit"></i>
                <span>Edit Role</span>
            </a>
            @endpermission

            @permission('manage_roles')
            <a href="{{ route('admin.roles.create') }}" class="btn btn-success action-btn">
                <i class="fas fa-plus"></i>
                <span>Create New Role</span>
            </a>
            @endpermission

            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline action-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Roles</span>
            </a>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Role Show Page - Colored Stat Icons */
    .permissions-summary .stat-icon,
    .users-summary .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--white);
        margin-bottom: var(--space-3);
        transition: all 0.3s ease;
    }

    /* Key icon for permissions */
    .stat-icon-permissions {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        box-shadow: 0 4px 15px rgba(23, 52, 120, 0.3);
    }

    /* Cube icon for modules */
    .stat-icon-modules {
        background: linear-gradient(135deg, var(--info) 0%, var(--info-dark) 100%);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    /* Users icon */
    .stat-icon-users {
        background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    /* Hover effects */
    .permissions-summary .stat-item:hover .stat-icon,
    .users-summary .stat-item:hover .stat-icon {
        transform: scale(1.1);
    }

    .permissions-summary .stat-item:hover .stat-icon-permissions {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        box-shadow: 0 6px 20px rgba(23, 52, 120, 0.4);
    }

    .permissions-summary .stat-item:hover .stat-icon-modules {
        background: linear-gradient(135deg, var(--info-dark) 0%, var(--info) 100%);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .users-summary .stat-item:hover .stat-icon-users {
        background: linear-gradient(135deg, var(--success-dark) 0%, var(--success) 100%);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
</style>
@endpush

@push('scripts')
<script>
    // Add hover effects to role cards
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

        // Add hover effects to user items
        const userItems = document.querySelectorAll('.user-item');
        userItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
                this.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
                this.style.boxShadow = '';
            });
        });
    });
</script>
@endpush