@extends('layouts.admin')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header user-edit-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-user-edit"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Edit User Profile</h2>
                <p class="header-subtitle">Update information for {{ $user->name }}</p>
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
                    <div class="stat-item">
                        <span class="stat-number">{{ $user->email_verified_at ? 'Verified' : 'Pending' }}</span>
                        <span class="stat-label">Email Status</span>
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

<!-- User Quick Info Card -->
<div class="user-quick-info enhanced-card">
    <div class="quick-info-header">
        <div class="user-avatar">
            <i class="fas fa-user-circle"></i>
        </div>
        <div class="user-summary">
            <h3 class="user-name">{{ $user->name }}</h3>
            <p class="user-email">{{ $user->email }}</p>
            <div class="user-meta">
                <span class="meta-item">
                    <i class="fas fa-calendar"></i>
                    {{ $user->created_at->format('M j, Y') }}
                </span>
                <span class="meta-item">
                    <i class="fas fa-clock"></i>
                    {{ $user->created_at->diffForHumans() }}
                </span>
                @if($user->last_login_at)
                <span class="meta-item">
                    <i class="fas fa-sign-in-alt"></i>
                    Last login: {{ $user->last_login_at->diffForHumans() }}
                </span>
                @endif
            </div>
        </div>
        <div class="user-status">
            @if($user->is_active)
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

<!-- Enhanced Content Card -->
<div class="content-card enhanced-card">
    <div class="card-header enhanced-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                User Update Form
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

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="user-form enhanced-form">
            @csrf
            @method('PUT')

            <div class="enhanced-form-grid">
                <!-- Personal Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-user"></i>
                            Personal Information
                        </h4>
                        <p class="section-subtitle">Basic details about the user</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="name" class="form-label enhanced-label">
                                <i class="fas fa-user"></i>
                                Full Name *
                            </label>
                            <input type="text" id="name" name="name"
                                class="form-input enhanced-input"
                                value="{{ old('name', $user->name) }}"
                                placeholder="Enter full name" required>
                            <div class="input-glow"></div>
                            @error('name')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="email" class="form-label enhanced-label">
                                <i class="fas fa-envelope"></i>
                                Email Address *
                            </label>
                            <input type="email" id="email" name="email"
                                class="form-input enhanced-input"
                                value="{{ old('email', $user->email) }}"
                                placeholder="Enter email address" required>
                            <div class="input-glow"></div>
                            @error('email')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="phone" class="form-label enhanced-label">
                                <i class="fas fa-phone"></i>
                                Phone Number
                            </label>
                            <input type="tel" id="phone" name="phone"
                                class="form-input enhanced-input"
                                value="{{ old('phone', $user->phone) }}"
                                placeholder="Enter phone number">
                            <div class="input-glow"></div>
                            @error('phone')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="role_id" class="form-label enhanced-label">
                                <i class="fas fa-user-tag"></i>
                                User Role *
                            </label>
                            <select id="role_id" name="role_id" class="form-select enhanced-select" required>
                                <option value="">Select User Role</option>
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
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="username" class="form-label enhanced-label">
                                <i class="fas fa-at"></i>
                                Username
                            </label>
                            <input type="text" id="username" name="username"
                                class="form-input enhanced-input"
                                value="{{ old('username', $user->username) }}"
                                placeholder="Enter username (optional)">
                            <div class="input-glow"></div>
                            @error('username')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="timezone" class="form-label enhanced-label">
                                <i class="fas fa-globe"></i>
                                Timezone
                            </label>
                            <select id="timezone" name="timezone" class="form-select enhanced-select">
                                <option value="">Select Timezone</option>
                                <option value="UTC" {{ old('timezone', $user->timezone) == 'UTC' ? 'selected' : '' }}>UTC</option>
                                <option value="America/New_York" {{ old('timezone', $user->timezone) == 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                <option value="America/Chicago" {{ old('timezone', $user->timezone) == 'America/Chicago' ? 'selected' : '' }}>Central Time</option>
                                <option value="America/Denver" {{ old('timezone', $user->timezone) == 'America/Denver' ? 'selected' : '' }}>Mountain Time</option>
                                <option value="America/Los_Angeles" {{ old('timezone', $user->timezone) == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time</option>
                                <option value="Europe/London" {{ old('timezone', $user->timezone) == 'Europe/London' ? 'selected' : '' }}>London</option>
                                <option value="Europe/Paris" {{ old('timezone', $user->timezone) == 'Europe/Paris' ? 'selected' : '' }}>Paris</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('timezone')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account Security Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-lock"></i>
                            Account Security
                        </h4>
                        <p class="section-subtitle">Update password (leave blank to keep current)</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="password" class="form-label enhanced-label">
                                <i class="fas fa-key"></i>
                                New Password
                            </label>
                            <div class="enhanced-input-group">
                                <input type="password" id="password" name="password"
                                    class="form-input enhanced-input"
                                    placeholder="Enter new password (leave blank to keep current)"
                                    oninput="checkPasswordStrength(this.value)">
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <div class="input-glow"></div>
                            </div>
                            <div class="password-strength" id="passwordStrength"></div>
                            <div class="password-requirements">
                                <small class="requirement-item" data-requirement="length">
                                    <i class="fas fa-circle"></i> At least 8 characters
                                </small>
                                <small class="requirement-item" data-requirement="uppercase">
                                    <i class="fas fa-circle"></i> One uppercase letter
                                </small>
                                <small class="requirement-item" data-requirement="lowercase">
                                    <i class="fas fa-circle"></i> One lowercase letter
                                </small>
                                <small class="requirement-item" data-requirement="number">
                                    <i class="fas fa-circle"></i> One number
                                </small>
                                <small class="requirement-item" data-requirement="special">
                                    <i class="fas fa-circle"></i> One special character
                                </small>
                            </div>
                            @error('password')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="password_confirmation" class="form-label enhanced-label">
                                <i class="fas fa-check-circle"></i>
                                Confirm New Password
                            </label>
                            <div class="enhanced-input-group">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-input enhanced-input"
                                    placeholder="Confirm new password"
                                    oninput="checkPasswordMatch()">
                                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <div class="input-glow"></div>
                            </div>
                            <div class="password-match" id="passwordMatch"></div>
                        </div>
                    </div>
                </div>

                <!-- Account Status Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-toggle-on"></i>
                            Account Status
                        </h4>
                        <p class="section-subtitle">Manage account accessibility and settings</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="is_active" class="form-label enhanced-label">
                                <i class="fas fa-power-off"></i>
                                Account Status
                            </label>
                            <div class="toggle-switch">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                    {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }} class="enhanced-toggle">
                                <label for="is_active" class="toggle-label">
                                    <span class="toggle-text">Active Account</span>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            @error('is_active')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="email_verified" class="form-label enhanced-label">
                                <i class="fas fa-envelope-check"></i>
                                Email Verification
                            </label>
                            <div class="toggle-switch">
                                <input type="checkbox" id="email_verified" name="email_verified" value="1"
                                    {{ old('email_verified', $user->email_verified_at ? true : false) ? 'checked' : '' }} class="enhanced-toggle">
                                <label for="email_verified" class="toggle-label">
                                    <span class="toggle-text">Email Verified</span>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            @error('email_verified')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Additional Information
                        </h4>
                        <p class="section-subtitle">Optional details and notes</p>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="notes" class="form-label enhanced-label">
                            <i class="fas fa-sticky-note"></i>
                            Notes
                        </label>
                        <textarea id="notes" name="notes"
                            class="form-textarea enhanced-textarea"
                            rows="4"
                            placeholder="Any additional notes about this user">{{ old('notes', $user->notes) }}</textarea>
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
                        <span>Update User</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary action-btn">
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
    // Password toggle functionality
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const button = input.nextElementSibling;
        const icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye';
        }
    }

    // Password strength checking
    function checkPasswordStrength(password) {
        const strengthBar = document.getElementById('passwordStrength');
        const requirements = document.querySelectorAll('.requirement-item');

        if (!password) {
            strengthBar.className = 'password-strength';
            requirements.forEach(req => req.classList.remove('met'));
            return;
        }

        // Check requirements
        const checks = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /\d/.test(password),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };

        // Update requirement indicators
        requirements.forEach(req => {
            const requirement = req.getAttribute('data-requirement');
            if (checks[requirement]) {
                req.classList.add('met');
            } else {
                req.classList.remove('met');
            }
        });

        // Calculate strength
        const metCount = Object.values(checks).filter(Boolean).length;
        let strength = 'weak';
        let strengthClass = 'weak';

        if (metCount >= 4) {
            strength = 'strong';
            strengthClass = 'strong';
        } else if (metCount >= 3) {
            strength = 'good';
            strengthClass = 'good';
        } else if (metCount >= 2) {
            strength = 'fair';
            strengthClass = 'fair';
        }

        strengthBar.className = `password-strength ${strengthClass}`;
    }

    // Password match checking
    function checkPasswordMatch() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const matchIndicator = document.getElementById('passwordMatch');

        if (!password || !confirmPassword) {
            matchIndicator.innerHTML = '';
            matchIndicator.className = 'password-match';
            return;
        }

        if (password === confirmPassword) {
            matchIndicator.innerHTML = '<i class="fas fa-check-circle"></i> Passwords match';
            matchIndicator.className = 'password-match match';
        } else {
            matchIndicator.innerHTML = '<i class="fas fa-times-circle"></i> Passwords do not match';
            matchIndicator.className = 'password-match no-match';
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

        // Validate password confirmation if password is provided
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');

        if (password.value && password.value !== confirmPassword.value) {
            confirmPassword.classList.add('error');
            isValid = false;
        } else {
            confirmPassword.classList.remove('error');
        }

        // Validate email format
        const email = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email.value && !emailRegex.test(email.value)) {
            email.classList.add('error');
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
</script>
@endpush