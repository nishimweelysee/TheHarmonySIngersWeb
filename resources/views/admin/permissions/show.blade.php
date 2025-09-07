@extends('layouts.admin')

@section('title', 'Permission Details')
@section('page-title', 'Permission Details')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header permission-show-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-shield-alt"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Permission Profile</h2>
                <p class="header-subtitle">Detailed information for {{ $permission->display_name }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">#{{ $permission->id }}</span>
                        <span class="stat-label">Permission ID</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $permission->roles->count() }}</span>
                        <span class="stat-label">Assigned Roles</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ ucfirst($permission->module) }}</span>
                        <span class="stat-label">Module</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('edit_permissions')
            <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-edit"></i>
                    <span>Edit Permission</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Permissions</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Permission Status Banner -->
@if(!$permission->is_active)
<div class="status-banner inactive enhanced-banner">
    <div class="banner-content">
        <i class="fas fa-exclamation-triangle"></i>
        <div>
            <strong>Permission Inactive</strong>
            <span>This permission is currently inactive and won't be available for assignment to roles</span>
        </div>
    </div>
</div>
@endif

<!-- Enhanced Permission Details -->
<div class="permission-details enhanced-details">
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
                        Permission Details
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Permission Name</span>
                            <span class="info-value">
                                <code class="permission-name-code">{{ $permission->name }}</code>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Display Name</span>
                            <span class="info-value">{{ $permission->display_name }}</span>
                        </div>
                    </div>

                    @if($permission->description)
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-align-left"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Description</span>
                            <span class="info-value">{{ $permission->description }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-cube"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Module</span>
                            <span class="info-value">
                                <span class="module-badge enhanced-badge">
                                    <i class="fas fa-folder"></i>
                                    {{ ucfirst($permission->module) }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Action Type</span>
                            <span class="info-value">
                                <span class="action-badge enhanced-badge">
                                    <i class="fas fa-arrow-right"></i>
                                    {{ ucfirst($permission->action ?? 'N/A') }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-toggle-on"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Status</span>
                            <span class="info-value">
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
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Permission ID</span>
                            <span class="info-value">#{{ $permission->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Assignments -->
        <div class="detail-card enhanced-card roles-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i>
                        Assigned Roles
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Role List
                    </div>
                </div>
            </div>
            <div class="card-content">
                @if($permission->roles->count() > 0)
                <div class="roles-overview">
                    <div class="roles-summary">
                        <div class="summary-stats">
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-number">{{ $permission->roles->count() }}</span>
                                    <span class="stat-label">Total Roles</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="roles-list">
                        @foreach($permission->roles->take(8) as $role)
                        <div class="role-item">
                            <div class="role-avatar">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <div class="role-details">
                                <span class="role-name">{{ $role->display_name }}</span>
                                <span class="role-slug">{{ $role->name }}</span>
                            </div>
                            <div class="role-actions">
                                <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-sm btn-outline">
                                    <i class="fas fa-eye"></i>
                                    <span>View</span>
                                </a>
                            </div>
                        </div>
                        @endforeach
                        @if($permission->roles->count() > 8)
                        <div class="more-roles">
                            <i class="fas fa-ellipsis-h"></i>
                            <span>{{ $permission->roles->count() - 8 }} more roles...</span>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <div class="no-roles enhanced-empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <h4>No Roles Assigned</h4>
                    <p>This permission is not currently assigned to any roles.</p>
                    @permission('manage_roles')
                    <div class="empty-actions">
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Create Role
                        </a>
                    </div>
                    @endpermission
                </div>
                @endif
            </div>
        </div>

        <!-- Usage Information -->
        <div class="detail-card enhanced-card usage-card">
            <div class="card-background">
                <div class="card-pattern"></div>
            </div>
            <div class="card-header enhanced-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i>
                        Usage Information
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Statistics
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Total Users Affected</span>
                            <span class="info-value">
                                @php
                                $totalUsers = $permission->roles->sum(function($role) {
                                return $role->users->count();
                                });
                                @endphp
                                <span class="user-count-badge enhanced-badge">
                                    <i class="fas fa-users"></i>
                                    {{ $totalUsers }} users
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="info-item enhanced-item">
                        <div class="info-icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">System Coverage</span>
                            <span class="info-value">
                                @php
                                $totalRoles = \App\Models\Role::count();
                                $coverage = $totalRoles > 0 ? round(($permission->roles->count() / $totalRoles) * 100, 1) : 0;
                                @endphp
                                <span class="coverage-badge enhanced-badge">
                                    <i class="fas fa-chart-pie"></i>
                                    {{ $coverage }}%
                                </span>
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
                                <span class="priority-badge enhanced-badge priority-{{ $permission->priority ?? 2 }}">
                                    <i class="fas fa-flag"></i>
                                    Level {{ $permission->priority ?? 2 }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
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
                                    <span class="date-main">{{ $permission->created_at->format('M j, Y \a\t g:i A') }}</span>
                                    <span class="date-ago">{{ $permission->created_at->diffForHumans() }}</span>
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
                                    <span class="date-main">{{ $permission->updated_at->format('M j, Y \a\t g:i A') }}</span>
                                    <span class="date-ago">{{ $permission->updated_at->diffForHumans() }}</span>
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
            @permission('edit_permissions')
            <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-primary action-btn">
                <i class="fas fa-edit"></i>
                <span>Edit Permission</span>
            </a>
            @endpermission

            @permission('create_permissions')
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-success action-btn">
                <i class="fas fa-plus"></i>
                <span>Create New Permission</span>
            </a>
            @endpermission

            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline action-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Permissions</span>
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Add hover effects to permission cards
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

        // Add hover effects to role items
        const roleItems = document.querySelectorAll('.role-item');
        roleItems.forEach(item => {
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