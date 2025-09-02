@extends('layouts.admin')

@section('title', 'Create Role')
@section('page-title', 'Create New Role')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header role-create-header">
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
                <h2 class="header-title">Add New Role</h2>
                <p class="header-subtitle">Create a new user role with specific permissions</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-shield-alt"></i>
                        </span>
                        <span class="stat-label">New Access</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="stat-label">Role Control</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-lock"></i>
                        </span>
                        <span class="stat-label">Security</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
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

<!-- Enhanced Content Card -->
<div class="content-card enhanced-card">
    <div class="card-header enhanced-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Role Creation Form
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

        <form method="POST" action="{{ route('admin.roles.store') }}" class="role-form enhanced-form">
            @csrf

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
                            <input type="text" id="name" name="name"
                                class="form-input enhanced-input"
                                value="{{ old('name') }}"
                                placeholder="Enter role name (e.g., moderator)" required>
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
                        <textarea id="description" name="description"
                            class="form-textarea enhanced-textarea"
                            rows="3"
                            placeholder="Describe the role's purpose and responsibilities">{{ old('description') }}</textarea>
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
                    </div>

                    <div class="permissions-grid">
                        @foreach($permissions->groupBy('module') as $module => $modulePermissions)
                        <div class="permission-module">
                            <div class="module-header">
                                <h5 class="module-title">
                                    <i class="fas fa-cube"></i>
                                    {{ ucfirst($module) }}
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
                                        <input type="checkbox" name="permissions[]" 
                                            value="{{ $permission->id }}"
                                            {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                            class="enhanced-checkbox">
                                        <span class="checkmark"></span>
                                        <div class="permission-info">
                                            <span class="permission-name">{{ $permission->display_name }}</span>
                                            <span class="permission-description">{{ $permission->description }}</span>
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

                        <div class="form-group enhanced-group">
                            <label for="priority" class="form-label enhanced-label">
                                <i class="fas fa-sort-numeric-up"></i>
                                Priority Level
                            </label>
                            <select id="priority" name="priority" class="form-select enhanced-select">
                                <option value="1" {{ old('priority', 1) == 1 ? 'selected' : '' }}>Low (1)</option>
                                <option value="2" {{ old('priority', 2) == 2 ? 'selected' : '' }}>Medium (2)</option>
                                <option value="3" {{ old('priority', 3) == 3 ? 'selected' : '' }}>High (3)</option>
                                <option value="4" {{ old('priority', 4) == 4 ? 'selected' : '' }}>Critical (4)</option>
                            </select>
                            <div class="select-glow"></div>
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
                        <span>Create Role</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline action-btn">
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

    // Auto-generate display name from role name
    document.getElementById('name').addEventListener('input', function() {
        const displayName = document.getElementById('display_name');
        if (!displayName.value) {
            const name = this.value.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            displayName.value = name;
        }
    });
</script>
@endpush