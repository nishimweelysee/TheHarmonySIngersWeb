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

<!-- Enhanced Content Card -->
<div class="content-card enhanced-card">
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
        @if ($errors->any())
        <div class="form-error enhanced-error">
            <i class="fas fa-exclamation-triangle"></i>
            <span>Please fix the following errors:</span>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="role-form enhanced-form">
            @csrf
            @method('PUT')

            <div class="enhanced-form-grid">
                <!-- Role Selection Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-shield-alt"></i>
                            Role Selection
                        </h4>
                        <p class="section-subtitle">Choose the appropriate role for this user</p>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="role_id" class="form-label enhanced-label">
                            <i class="fas fa-user-tag"></i>
                            Select Role *
                        </label>
                        <select name="role_id" id="role_id" required class="form-select enhanced-select">
                            <option value="">Choose a role</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="select-glow"></div>
                        @error('role_id')
                        <div class="error-message enhanced-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions enhanced-actions">
                <div class="action-buttons">
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-save"></i>
                        <span>Update Role</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary enhanced-btn">
                        <div class="btn-content">
                            <i class="fas fa-times"></i>
                            <span>Cancel</span>
                        </div>
                        <div class="btn-glow"></div>
                    </a>
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
                    <div class="stat-icon stat-icon-permissions">
                        <i class="fas fa-key"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number">{{ $user->role->permissions->count() }}</span>
                        <span class="stat-label">Permissions</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon stat-icon-users">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number">{{ $user->role->users->count() }}</span>
                        <span class="stat-label">Users</span>
                    </div>
                </div>
            </div>

            @if($user->role->permissions->count() > 0)
            <div class="permissions-by-module">
                @foreach($user->role->permissions->groupBy('module') as $module => $modulePermissions)
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
                Available Roles
            </h3>
            <div class="header-badge">
                <span class="badge-dot"></span>
                Role Comparison
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
                        <div class="stat-icon-small stat-icon-permissions-small">
                            <i class="fas fa-key"></i>
                        </div>
                        {{ $role->permissions->count() }} permissions
                    </span>
                    <span class="stat">
                        <div class="stat-icon-small stat-icon-users-small">
                            <i class="fas fa-users"></i>
                        </div>
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

@endsection

@push('scripts')
<script>
// Enhanced form validation - Matching Members Pages
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.enhanced-form');
    const roleSelect = document.getElementById('role_id');

    // Form submission validation
    form.addEventListener('submit', function(e) {
        let isValid = true;

        // Clear previous error states
        form.querySelectorAll('.enhanced-select').forEach(field => {
            field.classList.remove('error');
        });

        // Validate role selection
        if (!roleSelect.value) {
            roleSelect.classList.add('error');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();

            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'form-error enhanced-error';
            errorDiv.innerHTML =
                '<i class="fas fa-exclamation-triangle"></i><span>Please select a role before submitting.</span>';

            const existingError = form.querySelector('.form-error');
            if (existingError) {
                existingError.remove();
            }

            form.insertBefore(errorDiv, form.querySelector('.form-actions'));

            // Scroll to first error
            roleSelect.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            // Auto-remove error after 5 seconds
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.remove();
                }
            }, 5000);
        }
    });

    // Real-time validation feedback
    roleSelect.addEventListener('change', function() {
        if (this.classList.contains('error') && this.value) {
            this.classList.remove('error');

            // Remove any existing error messages
            const existingError = form.querySelector('.form-error');
            if (existingError) {
                existingError.remove();
            }
        }
    });

    // Modern hover effects for role comparison items
    const comparisonItems = document.querySelectorAll('.role-comparison-item');

    comparisonItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
            this.style.boxShadow =
                '0 20px 40px rgba(0, 0, 0, 0.12), 0 8px 16px rgba(0, 0, 0, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.9)';

            // Add staggered animation to stat icons
            const statIcons = this.querySelectorAll('.stat-icon-small');
            statIcons.forEach((icon, index) => {
                setTimeout(() => {
                    icon.style.transform = 'translateY(-4px) scale(1.1)';
                }, index * 150);
            });
        });

        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow =
                '0 10px 25px rgba(0, 0, 0, 0.08), 0 4px 10px rgba(0, 0, 0, 0.04), inset 0 1px 0 rgba(255, 255, 255, 0.8)';

            // Reset stat icons
            const statIcons = this.querySelectorAll('.stat-icon-small');
            statIcons.forEach(icon => {
                icon.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add modern click effect to role comparison items
        item.addEventListener('click', function() {
            this.style.transform = 'translateY(-4px) scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            }, 200);
        });
    });

    // Enhanced select styling on focus
    roleSelect.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
    });

    roleSelect.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
    });

    // Add loading state to submit button
    form.addEventListener('submit', function() {
        const submitBtn = form.querySelector('.submit-btn');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Updating Role...</span>';
        submitBtn.disabled = true;

        // Re-enable after 3 seconds (in case of network issues)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });
});
</script>
@endpush