@extends('layouts.admin')

@section('title', 'Edit Role')
@section('page-title', 'Edit Role')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header role-edit-header">
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
                <h2 class="header-title">Edit Role Profile</h2>
                <p class="header-subtitle">Update information for {{ $role->display_name }}</p>
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
            <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-info enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-eye"></i>
                    <span>View Role</span>
                </div>
                <div class="btn-glow"></div>
            </a>
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

<!-- Role Quick Info Card -->
<div class="role-quick-info enhanced-card">
    <div class="quick-info-header">
        <div class="role-avatar">
            <i class="fas fa-user-tag"></i>
        </div>
        <div class="role-summary">
            <h3 class="role-name">{{ $role->display_name }}</h3>
            <p class="role-slug">{{ $role->name }}</p>
            <div class="role-meta">
                <span class="meta-item">
                    <i class="fas fa-shield-alt"></i>
                    {{ $role->permissions->count() }} Permissions
                </span>
                <span class="meta-item">
                    <i class="fas fa-users"></i>
                    {{ $role->users->count() }} Users
                </span>
                <span class="meta-item">
                    <i class="fas fa-calendar"></i>
                    {{ $role->created_at->format('M j, Y') }}
                </span>
                @if($role->priority)
                <span
                    class="meta-item priority-{{ $role->priority <= 2 ? 'low' : ($role->priority == 3 ? 'medium' : 'high') }}">
                    <i class="fas fa-sort-numeric-up"></i>
                    Priority {{ $role->priority }}
                </span>
                @endif
            </div>
        </div>
        <div class="role-status">
            @if($role->is_active)
            <span class="status-badge active">
                <i class="fas fa-check-circle"></i>
                Active
            </span>
            @else
            <span class="status-badge inactive">
                <i class="fas fa-times-circle"></i>
                Inactive
            </span>
            @endif
        </div>
    </div>
</div>

<!-- Role Status Banner -->
@if(!$role->is_active)
<div class="status-banner inactive enhanced-banner">
    <div class="banner-content">
        <i class="fas fa-exclamation-triangle"></i>
        <div>
            <strong>This role is currently inactive.</strong>
            <span>Inactive roles won't be available for assignment to new users.</span>
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
                Role Update Form
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

        <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="role-form enhanced-form">
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
                        <p class="section-subtitle">Role name and display information</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="name" class="form-label enhanced-label">
                                <i class="fas fa-tag"></i>
                                Role Name *
                            </label>
                            <input type="text" id="name" name="name" class="form-input enhanced-input"
                                value="{{ old('name', $role->name) }}" placeholder="Enter role name (e.g., moderator)"
                                required>
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
                            <input type="text" id="display_name" name="display_name" class="form-input enhanced-input"
                                value="{{ old('display_name', $role->display_name) }}"
                                placeholder="Enter display name (e.g., Moderator)" required>
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
                        <textarea id="description" name="description" class="form-textarea enhanced-textarea" rows="3"
                            placeholder="Describe the role's purpose and responsibilities">{{ old('description', $role->description) }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('description')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Permissions Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-shield-alt"></i>
                            Permissions
                        </h4>
                        <p class="section-subtitle">Select the permissions this role will have</p>
                        <div class="permissions-summary">
                            <span class="summary-item">
                                <i class="fas fa-check-circle"></i>
                                <span
                                    id="selectedCount">{{ count(old('permissions', $role->permissions->pluck('id')->toArray())) }}</span>
                                Selected
                            </span>
                            <span class="summary-item">
                                <i class="fas fa-layer-group"></i>
                                <span>{{ $permissions->count() }}</span> Total Available
                            </span>
                        </div>
                    </div>

                    <div class="permissions-controls">
                        <button type="button" class="btn btn-outline btn-sm" onclick="selectAllPermissions()">
                            <i class="fas fa-check-double"></i>
                            Select All
                        </button>
                        <button type="button" class="btn btn-outline btn-sm" onclick="clearAllPermissions()">
                            <i class="fas fa-times"></i>
                            Clear All
                        </button>
                        <button type="button" class="btn btn-outline btn-sm" onclick="expandAllModules()">
                            <i class="fas fa-expand-arrows-alt"></i>
                            Expand All
                        </button>
                        <button type="button" class="btn btn-outline btn-sm" onclick="collapseAllModules()">
                            <i class="fas fa-compress-arrows-alt"></i>
                            Collapse All
                        </button>
                    </div>

                    <div class="permissions-grid">
                        @foreach($permissions->groupBy('module') as $module => $modulePermissions)
                        <div class="permission-module">
                            <div class="module-header">
                                <h5 class="module-title">
                                    <i class="fas fa-cube"></i>
                                    {{ ucfirst($module) }}
                                    <span class="module-count">({{ $modulePermissions->count() }})</span>
                                </h5>
                                <div class="module-toggle">
                                    <button type="button" class="toggle-module" onclick="toggleModule('{{ $module }}')">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="permissions-list" id="module-{{ $module }}">
                                @foreach($modulePermissions as $permission)
                                <div class="permission-item">
                                    <label class="permission-checkbox">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                            {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}
                                            class="enhanced-checkbox" onchange="updatePermissionsCount()">
                                        <div class="permission-info">
                                            <span class="permission-name"
                                                data-tooltip="{{ $permission->description ?: '' }}"
                                                class="{{ $permission->description ? 'has-tooltip' : 'no-tooltip' }}">
                                                {{ $permission->display_name }}
                                            </span>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @error('permissions')
                    <span class="error-message enhanced-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Additional Settings Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-cogs"></i>
                            Additional Settings
                        </h4>
                        <p class="section-subtitle">Role configuration options</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="is_active" class="form-label enhanced-label">
                                <i class="fas fa-toggle-on"></i>
                                Status
                            </label>
                            <div class="toggle-switch">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                    {{ old('is_active', $role->is_active) ? 'checked' : '' }} class="enhanced-toggle">
                                <label for="is_active" class="toggle-label">
                                    <span class="toggle-text">Active Role</span>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            @error('is_active')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="priority" class="form-label enhanced-label">
                                <i class="fas fa-sort-numeric-up"></i>
                                Priority Level
                            </label>
                            <select id="priority" name="priority" class="form-select enhanced-select"
                                onchange="updatePriorityIndicator()">
                                <option value="1" {{ old('priority', $role->priority ?? 1) == 1 ? 'selected' : '' }}>Low
                                    (1)</option>
                                <option value="2" {{ old('priority', $role->priority ?? 2) == 2 ? 'selected' : '' }}>
                                    Medium (2)</option>
                                <option value="3" {{ old('priority', $role->priority ?? 3) == 3 ? 'selected' : '' }}>
                                    High (3)</option>
                                <option value="4" {{ old('priority', $role->priority ?? 4) == 4 ? 'selected' : '' }}>
                                    Critical (4)</option>
                            </select>
                            <div class="select-glow"></div>
                            <div class="priority-preview" id="priorityPreview">
                                <span
                                    class="priority-indicator priority-{{ old('priority', $role->priority ?? 1) <= 2 ? 'low' : (old('priority', $role->priority ?? 1) == 3 ? 'medium' : 'high') }}">
                                    <i class="fas fa-sort-numeric-up"></i>
                                    Priority {{ old('priority', $role->priority ?? 1) }}
                                </span>
                            </div>
                            @error('priority')
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
                        <span>Update Role</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-secondary action-btn">
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
    // Module toggle functionality
    function toggleModule(moduleName) {
        const moduleDiv = document.getElementById(`module-${moduleName}`);
        const toggleBtn = moduleDiv.previousElementSibling.querySelector('.toggle-module i');

        if (moduleDiv.style.display === 'none' || moduleDiv.style.display === '') {
            moduleDiv.style.display = 'block';
            toggleBtn.className = 'fas fa-chevron-up';
        } else {
            moduleDiv.style.display = 'none';
            toggleBtn.className = 'fas fa-chevron-down';
        }
    }

    // Initialize all modules as expanded
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.permissions-list').forEach(list => {
            list.style.display = 'block';
        });
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

        // Validate role name format (lowercase, no spaces)
        const roleName = document.getElementById('name');
        const nameRegex = /^[a-z_]+$/;
        if (roleName.value && !nameRegex.test(roleName.value)) {
            roleName.classList.add('error');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'form-error enhanced-error';
            errorDiv.innerHTML =
                '<i class="fas fa-exclamation-triangle"></i> Please fill in all required fields correctly.';
            document.querySelector('.enhanced-form').insertBefore(errorDiv, document.querySelector(
                '.form-actions'));

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

    // Auto-generate display name from role name
    document.getElementById('name').addEventListener('input', function() {
        const displayName = document.getElementById('display_name');
        if (!displayName.value) {
            const name = this.value.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            displayName.value = name;
        }
    });

    // Update priority indicator
    function updatePriorityIndicator() {
        const prioritySelect = document.getElementById('priority');
        const priorityPreview = document.getElementById('priorityPreview');
        const priority = parseInt(prioritySelect.value);

        let priorityClass = 'priority-low';
        if (priority >= 4) {
            priorityClass = 'priority-critical';
        } else if (priority >= 3) {
            priorityClass = 'priority-high';
        } else if (priority >= 2) {
            priorityClass = 'priority-medium';
        }

        priorityPreview.innerHTML = `
            <span class="priority-indicator ${priorityClass}">
                <i class="fas fa-sort-numeric-up"></i>
                Priority ${priority}
            </span>
        `;
    }

    // Update permissions count
    function updatePermissionsCount() {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]:checked');
        const selectedCount = document.getElementById('selectedCount');
        selectedCount.textContent = checkboxes.length;
    }

    // Select all permissions
    function selectAllPermissions() {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updatePermissionsCount();
    }

    // Clear all permissions
    function clearAllPermissions() {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updatePermissionsCount();
    }

    // Expand all modules
    function expandAllModules() {
        document.querySelectorAll('.permissions-list').forEach(list => {
            list.style.display = 'block';
        });
        document.querySelectorAll('.toggle-module i').forEach(icon => {
            icon.className = 'fas fa-chevron-up';
        });
    }

    // Collapse all modules
    function collapseAllModules() {
        document.querySelectorAll('.permissions-list').forEach(list => {
            list.style.display = 'none';
        });
        document.querySelectorAll('.toggle-module i').forEach(icon => {
            icon.className = 'fas fa-chevron-down';
        });
    }
</script>
@endpush