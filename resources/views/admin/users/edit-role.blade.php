@extends('layouts.admin')

@section('title', 'Edit User Role')
@section('page-title', 'Edit User Role')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header user-role-edit-header">
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
                <h2 class="header-title">Edit User Role</h2>
                <p class="header-subtitle">Manage role and permissions for {{ $user->name }}</p>
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
                        <span class="stat-number">{{ $user->role ? $user->role->display_name : 'No Role' }}</span>
                        <span class="stat-label">Current Role</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-eye"></i>
                    <span>View User</span>
                </div>
                <div class="btn-glow"></div>
            </a>
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

<!-- Enhanced Content Grid -->
<div class="content-grid">
    <!-- Role Assignment Card -->
    <div class="content-card enhanced-card role-assignment-card">
        <div class="card-header enhanced-header">
            <div class="header-content">
                <h3 class="card-title">
                    <i class="fas fa-user-tag"></i>
                    Role Assignment
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Select New Role
                </div>
            </div>
        </div>
        <div class="card-content">
            <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="role-form enhanced-form">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-shield-alt"></i>
                            Role Selection
                        </h4>
                        <p class="section-subtitle">Choose the appropriate role for this user</p>
                    </div>

                    <div class="form-group enhanced-group">
                        <label for="role_id" class="form-label enhanced-label">
                            <i class="fas fa-user-tag"></i>
                            Select Role *
                        </label>
                        <select name="role_id" id="role_id" required class="form-select enhanced-select">
                            <option value="">Choose a role</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="select-glow"></div>
                        @error('role_id')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions enhanced-actions">
                        <button type="submit" class="btn btn-primary action-btn submit-btn">
                            <i class="fas fa-save"></i>
                            <span>Update Role</span>
                            <div class="btn-glow"></div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Current Role Information Card -->
    <div class="content-card enhanced-card current-role-card">
        <div class="card-header enhanced-header">
            <div class="header-content">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Current Role Information
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Role Details
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
                        @if($user->role->description)
                        <p class="role-description">{{ $user->role->description }}</p>
                        @endif
                    </div>
                </div>

                <div class="role-stats">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number">{{ $user->role->permissions->count() }}</span>
                            <span class="stat-label">Permissions</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number">{{ $user->role->users->count() }}</span>
                            <span class="stat-label">Users</span>
                        </div>
                    </div>
                </div>

                @if($user->role->permissions->count() > 0)
                <div class="permissions-list">
                    <h5 class="permissions-title">
                        <i class="fas fa-shield-alt"></i>
                        Assigned Permissions
                    </h5>
                    <div class="permissions-grid">
                        @foreach($user->role->permissions->take(8) as $permission)
                        <div class="permission-item">
                            <i class="fas fa-check"></i>
                            <span>{{ $permission->display_name }}</span>
                        </div>
                        @endforeach
                        @if($user->role->permissions->count() > 8)
                        <div class="permission-item more">
                            <i class="fas fa-plus"></i>
                            <span>{{ $user->role->permissions->count() - 8 }} more...</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            @else
            <div class="no-role enhanced-empty-state">
                <div class="empty-icon">
                    <i class="fas fa-user-slash"></i>
                </div>
                <h4>No Role Assigned</h4>
                <p>This user currently has no role and therefore no permissions in the system.</p>
                <div class="empty-actions">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                        <i class="fas fa-user-tag"></i>
                        Assign Role
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Role Comparison Card -->
    <div class="content-card enhanced-card role-comparison-card">
        <div class="card-header enhanced-header">
            <div class="header-content">
                <h3 class="card-title">
                    <i class="fas fa-balance-scale"></i>
                    Role Comparison
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Available Roles
                </div>
            </div>
        </div>
        <div class="card-content">
            <div class="roles-comparison">
                @foreach($roles->take(4) as $role)
                <div class="role-comparison-item">
                    <div class="role-header">
                        <h5 class="role-name">{{ $role->display_name }}</h5>
                        <span class="role-slug">{{ $role->name }}</span>
                    </div>
                    <div class="role-stats">
                        <span class="stat">
                            <i class="fas fa-key"></i>
                            {{ $role->permissions->count() }} permissions
                        </span>
                        <span class="stat">
                            <i class="fas fa-users"></i>
                            {{ $role->users->count() }} users
                        </span>
                    </div>
                    @if($role->description)
                    <p class="role-description">{{ Str::limit($role->description, 80) }}</p>
                    @endif
                </div>
                @endforeach
                @if($roles->count() > 4)
                <div class="more-roles">
                    <i class="fas fa-ellipsis-h"></i>
                    <span>{{ $roles->count() - 4 }} more roles available</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Action Buttons -->
<div class="action-section enhanced-actions">
    <div class="action-buttons">
        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary action-btn">
            <i class="fas fa-eye"></i>
            <span>View User</span>
        </a>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary action-btn">
            <i class="fas fa-edit"></i>
            <span>Edit User</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline action-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Users</span>
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Enhanced form validation
    document.querySelector('.enhanced-form').addEventListener('submit', function(e) {
        const roleSelect = document.getElementById('role_id');
        let isValid = true;

        if (!roleSelect.value) {
            roleSelect.classList.add('error');
            isValid = false;
        } else {
            roleSelect.classList.remove('error');
        }

        if (!isValid) {
            e.preventDefault();
            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'form-error enhanced-error';
            errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Please select a role before submitting.';
            document.querySelector('.enhanced-form').insertBefore(errorDiv, document.querySelector('.form-actions'));

            setTimeout(() => {
                errorDiv.remove();
            }, 5000);
        }
    });

    // Real-time validation feedback
    document.getElementById('role_id').addEventListener('change', function() {
        if (this.classList.contains('error') && this.value) {
            this.classList.remove('error');
        }
    });

    // Add hover effects to role comparison items
    document.addEventListener('DOMContentLoaded', function() {
        const comparisonItems = document.querySelectorAll('.role-comparison-item');

        comparisonItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.1)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });
    });
</script>
@endpush