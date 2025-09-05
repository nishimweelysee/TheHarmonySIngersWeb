@extends('layouts.admin')

@section('title', 'Edit Permission')
@section('page-title', 'Edit Permission')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header permission-edit-header">
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
                <h2 class="header-title">Edit Permission Profile</h2>
                <p class="header-subtitle">Update information for {{ $permission->display_name }}</p>
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
            <a href="{{ route('admin.permissions.show', $permission) }}" class="btn btn-info enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-eye"></i>
                    <span>View Permission</span>
                </div>
                <div class="btn-glow"></div>
            </a>
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
            <strong>This permission is currently inactive.</strong>
            <span>Inactive permissions won't be available for assignment to roles.</span>
        </div>
    </div>
</div>
@endif

<!-- Enhanced Content Card -->
<div class="content-card enhanced-card">
    <div class="card-header enhanced-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Permission Update Form
            </h3>
            <div class="header-badge">
                <span class="badge-dot"></span>
                Required Fields
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

        <form method="POST" action="{{ route('admin.permissions.update', $permission) }}" class="permission-form enhanced-form">
            @csrf
            @method('PUT')

            <div class="enhanced-form-grid">
                <!-- Basic Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Basic Information
                        </h4>
                        <p class="section-subtitle">Permission name and display information</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="name" class="form-label enhanced-label">
                                <i class="fas fa-shield-alt"></i>
                                Permission Name *
                            </label>
                            <input type="text" id="name" name="name"
                                class="form-input enhanced-input"
                                value="{{ old('name', $permission->name) }}"
                                placeholder="Enter permission name (e.g., create_users)" required>
                            <div class="input-glow"></div>
                            @error('name')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="display_name" class="form-label enhanced-label">
                                <i class="fas fa-tag"></i>
                                Display Name *
                            </label>
                            <input type="text" id="display_name" name="display_name"
                                class="form-input enhanced-input"
                                value="{{ old('display_name', $permission->display_name) }}"
                                placeholder="Enter display name (e.g., Create Users)" required>
                            <div class="input-glow"></div>
                            @error('display_name')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="description" class="form-label enhanced-label">
                            <i class="fas fa-align-left"></i>
                            Description
                        </label>
                        <textarea id="description" name="description"
                            class="form-textarea enhanced-textarea"
                            rows="3"
                            placeholder="Describe what this permission allows users to do">{{ old('description', $permission->description) }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('description')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Module and Action Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-cube"></i>
                            Module and Action
                        </h4>
                        <p class="section-subtitle">Define the module and action type</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="module" class="form-label enhanced-label">
                                <i class="fas fa-folder"></i>
                                Module *
                            </label>
                            <select id="module" name="module" class="form-select enhanced-select" required>
                                <option value="">Select Module</option>
                                <option value="users" {{ old('module', $permission->module) == 'users' ? 'selected' : '' }}>Users</option>
                                <option value="roles" {{ old('module', $permission->module) == 'roles' ? 'selected' : '' }}>Roles</option>
                                <option value="permissions" {{ old('module', $permission->module) == 'permissions' ? 'selected' : '' }}>Permissions</option>
                                <option value="members" {{ old('module', $permission->module) == 'members' ? 'selected' : '' }}>Members</option>
                                <option value="concerts" {{ old('module', $permission->module) == 'concerts' ? 'selected' : '' }}>Concerts</option>
                                <option value="songs" {{ old('module', $permission->module) == 'songs' ? 'selected' : '' }}>Songs</option>
                                <option value="media" {{ old('module', $permission->module) == 'media' ? 'selected' : '' }}>Media</option>
                                <option value="financial" {{ old('module', $permission->module) == 'financial' ? 'selected' : '' }}>Financial</option>
                                <option value="practice" {{ old('module', $permission->module) == 'practice' ? 'selected' : '' }}>Practice Sessions</option>
                                <option value="plans" {{ old('module', $permission->module) == 'plans' ? 'selected' : '' }}>Year Plans</option>
                                <option value="sponsors" {{ old('module', $permission->module) == 'sponsors' ? 'selected' : '' }}>Sponsors</option>
                                <option value="albums" {{ old('module', $permission->module) == 'albums' ? 'selected' : '' }}>Albums</option>
                                <option value="notifications" {{ old('module', $permission->module) == 'notifications' ? 'selected' : '' }}>Notifications</option>
                                <option value="admin" {{ old('module', $permission->module) == 'admin' ? 'selected' : '' }}>Administration</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('module')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="action" class="form-label enhanced-label">
                                <i class="fas fa-bolt"></i>
                                Action Type *
                            </label>
                            <select id="action" name="action" class="form-select enhanced-select" required>
                                <option value="">Select Action</option>
                                <option value="view" {{ old('action', $permission->action) == 'view' ? 'selected' : '' }}>View</option>
                                <option value="create" {{ old('action', $permission->action) == 'create' ? 'selected' : '' }}>Create</option>
                                <option value="edit" {{ old('action', $permission->action) == 'edit' ? 'selected' : '' }}>Edit</option>
                                <option value="delete" {{ old('action', $permission->action) == 'delete' ? 'selected' : '' }}>Delete</option>
                                <option value="manage" {{ old('action', $permission->action) == 'manage' ? 'selected' : '' }}>Manage</option>
                                <option value="approve" {{ old('action', $permission->action) == 'approve' ? 'selected' : '' }}>Approve</option>
                                <option value="export" {{ old('action', $permission->action) == 'export' ? 'selected' : '' }}>Export</option>
                                <option value="import" {{ old('action', $permission->action) == 'import' ? 'selected' : '' }}>Import</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('action')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <div class="form-help">
                            <i class="fas fa-info-circle"></i>
                            Permission name should follow the format: {action}_{module} (e.g., create_users, edit_members)
                        </div>
                    </div>
                </div>

                <!-- Additional Settings Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-cogs"></i>
                            Additional Settings
                        </h4>
                        <p class="section-subtitle">Permission configuration options</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="is_active" class="form-label enhanced-label">
                                <i class="fas fa-toggle-on"></i>
                                Status
                            </label>
                            <div class="toggle-switch">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                    {{ old('is_active', $permission->is_active) ? 'checked' : '' }} class="enhanced-toggle">
                                <label for="is_active" class="toggle-label">
                                    <span class="toggle-text">Active Permission</span>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            @error('is_active')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <!-- Enhanced Form Actions -->
            <div class="form-actions enhanced-actions">
                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary action-btn submit-btn">
                        <i class="fas fa-save"></i>
                        <span>Update Permission</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.permissions.show', $permission) }}" class="btn btn-secondary action-btn">
                        <i class="fas fa-times"></i>
                        <span>Cancel</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Auto-generate display name from module and action
    function updateDisplayName() {
        const module = document.getElementById('module').value;
        const action = document.getElementById('action').value;
        const displayNameField = document.getElementById('display_name');

        if (module && action && !displayNameField.value) {
            const actionText = action.charAt(0).toUpperCase() + action.slice(1);
            const moduleText = module.charAt(0).toUpperCase() + module.slice(1);
            displayNameField.value = `${actionText} ${moduleText}`;
        }
    }

    // Auto-generate permission name from module and action
    function updatePermissionName() {
        const module = document.getElementById('module').value;
        const action = document.getElementById('action').value;
        const nameField = document.getElementById('name');

        if (module && action && !nameField.value) {
            nameField.value = `${action}_${module}`;
        }
    }

    // Enhanced form validation
    document.querySelector('.enhanced-form').addEventListener('submit', function(e) {
        const requiredFields = document.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('error');
                isValid = false;
            } else {
                field.classList.remove('error');
            }
        });

        // Validate permission name format (lowercase, no spaces)
        const permissionName = document.getElementById('name');
        const nameRegex = /^[a-z_]+$/;
        if (permissionName.value && !nameRegex.test(permissionName.value)) {
            permissionName.classList.add('error');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'form-error enhanced-error';
            errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Please fill in all required fields correctly.';
            document.querySelector('.enhanced-form').insertBefore(errorDiv, document.querySelector('.form-actions'));

            setTimeout(() => {
                errorDiv.remove();
            }, 5000);
        }
    });

    // Real-time validation feedback
    document.querySelectorAll('.enhanced-input, .enhanced-select').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('error') && this.value.trim()) {
                this.classList.remove('error');
            }
        });
    });

    // Auto-update fields when module or action changes
    document.getElementById('module').addEventListener('change', function() {
        updatePermissionName();
        updateDisplayName();
    });

    document.getElementById('action').addEventListener('change', function() {
        updatePermissionName();
        updateDisplayName();
    });

    // Initialize fields on page load
    document.addEventListener('DOMContentLoaded', function() {
        updatePermissionName();
        updateDisplayName();
    });
</script>
@endpush