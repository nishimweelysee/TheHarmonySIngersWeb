@extends('layouts.admin')

@section('title', 'Create Permission')
@section('page-title', 'Create New Permission')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header permission-create-header">
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
                <h2 class="header-title">Add New Permission</h2>
                <p class="header-subtitle">Create a new system permission for access control</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-lock"></i>
                        </span>
                        <span class="stat-label">Access Control</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-cube"></i>
                        </span>
                        <span class="stat-label">Module Security</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-shield"></i>
                        </span>
                        <span class="stat-label">User Rights</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
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

<!-- Enhanced Content Card -->
<div class="content-card enhanced-card">
    <div class="card-header enhanced-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Permission Creation Form
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

        <form method="POST" action="{{ route('admin.permissions.store') }}" class="permission-form enhanced-form">
            @csrf

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
                                <i class="fas fa-tag"></i>
                                Permission Name *
                            </label>
                            <input type="text" id="name" name="name"
                                class="form-input enhanced-input"
                                value="{{ old('name') }}"
                                placeholder="Enter permission name (e.g., view_users)" required>
                            <div class="input-glow"></div>
                            @error('name')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="display_name" class="form-label enhanced-label">
                                <i class="fas fa-eye"></i>
                                Display Name *
                            </label>
                            <input type="text" id="display_name" name="display_name"
                                class="form-input enhanced-input"
                                value="{{ old('display_name') }}"
                                placeholder="Enter display name (e.g., View Users)" required>
                            <div class="input-glow"></div>
                            @error('display_name')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="description" class="form-label enhanced-label">
                            <i class="fas fa-align-left"></i>
                            Description *
                        </label>
                        <textarea id="description" name="description"
                            class="form-textarea enhanced-textarea"
                            rows="3"
                            placeholder="Describe what this permission allows users to do" required>{{ old('description') }}</textarea>
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
                            Module & Action
                        </h4>
                        <p class="section-subtitle">Define the module and action type</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="module" class="form-label enhanced-label">
                                <i class="fas fa-cube"></i>
                                Module *
                            </label>
                            <select id="module" name="module" class="form-select enhanced-select" required>
                                <option value="">Select Module</option>
                                <option value="users" {{ old('module') == 'users' ? 'selected' : '' }}>Users</option>
                                <option value="roles" {{ old('module') == 'roles' ? 'selected' : '' }}>Roles</option>
                                <option value="permissions" {{ old('module') == 'permissions' ? 'selected' : '' }}>Permissions</option>
                                <option value="members" {{ old('module') == 'members' ? 'selected' : '' }}>Members</option>
                                <option value="concerts" {{ old('module') == 'concerts' ? 'selected' : '' }}>Concerts</option>
                                <option value="songs" {{ old('module') == 'songs' ? 'selected' : '' }}>Songs</option>
                                <option value="media" {{ old('module') == 'media' ? 'selected' : '' }}>Media</option>
                                <option value="financial" {{ old('module') == 'financial' ? 'selected' : '' }}>Financial</option>
                                <option value="practice" {{ old('module') == 'practice' ? 'selected' : '' }}>Practice Sessions</option>
                                <option value="contributions" {{ old('module') == 'contributions' ? 'selected' : '' }}>Contributions</option>
                                <option value="instruments" {{ old('module') == 'instruments' ? 'selected' : '' }}>Instruments</option>
                                <option value="plans" {{ old('module') == 'plans' ? 'selected' : '' }}>Year Plans</option>
                                <option value="sponsors" {{ old('module') == 'sponsors' ? 'selected' : '' }}>Sponsors</option>
                                <option value="albums" {{ old('module') == 'albums' ? 'selected' : '' }}>Albums</option>
                                <option value="notifications" {{ old('module') == 'notifications' ? 'selected' : '' }}>Notifications</option>
                                <option value="admin" {{ old('module') == 'admin' ? 'selected' : '' }}>Administration</option>
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
                                <option value="view" {{ old('action') == 'view' ? 'selected' : '' }}>View</option>
                                <option value="create" {{ old('action') == 'create' ? 'selected' : '' }}>Create</option>
                                <option value="edit" {{ old('action') == 'edit' ? 'selected' : '' }}>Edit</option>
                                <option value="delete" {{ old('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                                <option value="manage" {{ old('action') == 'manage' ? 'selected' : '' }}>Manage</option>
                                <option value="approve" {{ old('action') == 'approve' ? 'selected' : '' }}>Approve</option>
                                <option value="reject" {{ old('action') == 'reject' ? 'selected' : '' }}>Reject</option>
                                <option value="export" {{ old('action') == 'export' ? 'selected' : '' }}>Export</option>
                                <option value="import" {{ old('action') == 'import' ? 'selected' : '' }}>Import</option>
                                <option value="print" {{ old('action') == 'print' ? 'selected' : '' }}>Print</option>
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
                                    {{ old('is_active', true) ? 'checked' : '' }} class="enhanced-toggle">
                                <label for="is_active" class="toggle-label">
                                    <span class="toggle-text">Active</span>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            @error('is_active')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="notes" class="form-label enhanced-label">
                            <i class="fas fa-sticky-note"></i>
                            Notes
                        </label>
                        <textarea id="notes" name="notes"
                            class="form-textarea enhanced-textarea"
                            rows="3"
                            placeholder="Any additional notes about this permission">{{ old('notes') }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('notes')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Enhanced Form Actions -->
            <div class="form-actions enhanced-actions">
                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary action-btn submit-btn">
                        <i class="fas fa-save"></i>
                        <span>Create Permission</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline action-btn">
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
    // Auto-generate permission name from module and action
    function generatePermissionName() {
        const module = document.getElementById('module').value;
        const action = document.getElementById('action').value;
        const nameField = document.getElementById('name');

        if (module && action && !nameField.value) {
            nameField.value = `${action}_${module}`;
        }
    }

    // Auto-generate display name from module and action
    function generateDisplayName() {
        const module = document.getElementById('module').value;
        const action = document.getElementById('action').value;
        const displayNameField = document.getElementById('display_name');

        if (module && action && !displayNameField.value) {
            const actionText = action.charAt(0).toUpperCase() + action.slice(1);
            const moduleText = module.charAt(0).toUpperCase() + module.slice(1);
            displayNameField.value = `${actionText} ${moduleText}`;
        }
    }

    // Event listeners for auto-generation
    document.getElementById('module').addEventListener('change', function() {
        generatePermissionName();
        generateDisplayName();
    });

    document.getElementById('action').addEventListener('change', function() {
        generatePermissionName();
        generateDisplayName();
    });

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

        // Validate permission name format (lowercase, underscores)
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

    // Initialize permission key generation on page load
    document.addEventListener('DOMContentLoaded', function() {
        generatePermissionKey();
        generateDisplayName();
    });
</script>
@endpush