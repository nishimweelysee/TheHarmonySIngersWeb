@extends('layouts.admin')

@section('title', 'Profile Management')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header profile-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon-wrapper">
                <i class="fas fa-user-circle"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <div class="welcome-section">
                    <h1 class="header-title">Profile Management</h1>
                    <p class="header-subtitle">Manage your account information, security settings, and preferences</p>
                    <div class="current-time">
                        <i class="fas fa-clock"></i>
                        <span>Last updated {{ Auth::user()->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="header-stats">
                    <div class="stat-item">
                        <div class="stat-icon-small">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number">{{ Auth::user()->created_at->diffForHumans() }}</span>
                            <span class="stat-label">Member Since</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon-small">
                            <i class="fas fa-key"></i>
                        </div>
                        <div class="stat-content">
                            <span
                                class="stat-number">{{ Auth::user()->role ? Auth::user()->role->permissions->count() : 0 }}</span>
                            <span class="stat-label">Permissions</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon-small">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="stat-content">
                            <span
                                class="stat-number">{{ Auth::user()->email_verified_at ? 'Verified' : 'Pending' }}</span>
                            <span class="stat-label">Email Status</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon-small">
                            <i class="fas fa-user-tag"></i>
                        </div>
                        <div class="stat-content">
                            <span
                                class="stat-number">{{ Auth::user()->role ? Auth::user()->role->display_name : 'No Role' }}</span>
                            <span class="stat-label">Current Role</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <div class="action-group">
                <div class="status-indicator">
                    <div class="status-dot"></div>
                    <span>Account Active</span>
                    <div class="status-pulse"></div>
                </div>
                <div class="quick-stats">
                    <div class="quick-stat">
                        <i class="fas fa-database"></i>
                        <span>Profile: Active</span>
                    </div>
                    <div class="quick-stat">
                        <i class="fas fa-envelope"></i>
                        <span>Email: {{ Auth::user()->email_verified_at ? 'OK' : 'Pending' }}</span>
                    </div>
                </div>
            </div>
            <div class="action-buttons">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline action-btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Success Messages -->
@if (session('status'))
<div class="alert-container enhanced-alerts">
    @if (session('status') === 'profile-updated')
    <div class="alert alert-success enhanced-alert">
        <i class="fas fa-check-circle"></i>
        <span>Profile information updated successfully!</span>
    </div>
    @elseif (session('status') === 'password-updated')
    <div class="alert alert-success enhanced-alert">
        <i class="fas fa-check-circle"></i>
        <span>Password updated successfully!</span>
    </div>
    @endif
</div>
@endif

<!-- Enhanced Profile Content -->
<div class="profile-content">
    <!-- Profile Overview Card -->
    <div class="profile-card overview-card">
        <div class="card-header">
            <div class="header-content">
                <h3 class="card-title">
                    <i class="fas fa-user"></i>
                    Account Overview
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Personal Information
                </div>
            </div>
        </div>
        <div class="card-content">
            <div class="profile-overview">
                <div class="profile-avatar">
                    <div class="avatar-initial">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div class="avatar-status">
                        <i class="fas fa-circle"></i>
                        <span>Active</span>
                    </div>
                </div>
                <div class="profile-details">
                    <div class="profile-name">{{ Auth::user()->name }}</div>
                    <div class="profile-email">{{ Auth::user()->email }}</div>
                    @if(Auth::user()->phone)
                    <div class="profile-phone">{{ Auth::user()->phone }}</div>
                    @endif

                    <!-- Role Information -->
                    <div class="profile-role">
                        @if(Auth::user()->role)
                        <span class="role-badge">
                            <i class="fas fa-user-tag"></i>
                            {{ Auth::user()->role->display_name }}
                        </span>
                        @if(Auth::user()->role->description)
                        <div class="role-description">{{ Auth::user()->role->description }}</div>
                        @endif
                        @else
                        <span class="role-badge no-role">
                            <i class="fas fa-user-slash"></i>
                            No Role Assigned
                        </span>
                        @endif
                    </div>

                    <div class="profile-meta">
                        <span class="meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            Joined {{ Auth::user()->created_at->format('F j, Y') }}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-clock"></i>
                            Last updated {{ Auth::user()->updated_at->diffForHumans() }}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-shield-alt"></i>
                            {{ Auth::user()->email_verified_at ? 'Email Verified' : 'Email Pending' }}
                        </span>
                        @if(Auth::user()->role)
                        <span class="meta-item">
                            <i class="fas fa-key"></i>
                            {{ Auth::user()->role->permissions->count() }} Permissions
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Management Forms -->
    <div class="profile-forms">
        <!-- Profile Information Form -->
        <div class="profile-form-card">
            <div class="card-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Update Profile Information
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Personal Details
                    </div>
                </div>
            </div>
            <div class="card-content">
                <form method="POST" action="{{ route('profile.update') }}" class="profile-form" id="profileForm">
                    @csrf
                    @method('patch')

                    <div class="form-section">
                        <div class="section-header">
                            <h4 class="section-title">
                                <i class="fas fa-info-circle"></i>
                                Basic Information
                            </h4>
                            <p class="section-subtitle">Update your personal details and contact information</p>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user"></i>
                                    Full Name *
                                </label>
                                <input type="text" id="name" name="name" class="form-input"
                                    value="{{ old('name', Auth::user()->name) }}" placeholder="Enter your full name"
                                    required>
                                <div class="input-focus-border"></div>
                                @error('name')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i>
                                    Email Address *
                                </label>
                                <input type="email" id="email" name="email" class="form-input"
                                    value="{{ old('email', Auth::user()->email) }}"
                                    placeholder="Enter your email address" required>
                                <div class="input-focus-border"></div>
                                @error('email')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">
                                <i class="fas fa-phone"></i>
                                Phone Number
                            </label>
                            <input type="tel" id="phone" name="phone" class="form-input"
                                value="{{ old('phone', Auth::user()->phone) }}" placeholder="Enter your phone number">
                            <div class="input-focus-border"></div>
                            @error('phone')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary action-btn submit-btn" id="profileSubmitBtn">
                                <i class="fas fa-save"></i>
                                <span class="btn-text">Update Profile</span>
                                <span class="btn-loading hidden">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    Updating...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Password Update Form -->
        <div class="profile-form-card">
            <div class="card-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-lock"></i>
                        Update Password
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Security Settings
                    </div>
                </div>
            </div>
            <div class="card-content">
                <form method="POST" action="{{ route('password.update') }}" class="password-form" id="passwordForm">
                    @csrf
                    @method('put')

                    <div class="form-section">
                        <div class="section-header">
                            <h4 class="section-title">
                                <i class="fas fa-shield-alt"></i>
                                Password Security
                            </h4>
                            <p class="section-subtitle">Change your password to keep your account secure</p>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="current_password" class="form-label">
                                    <i class="fas fa-key"></i>
                                    Current Password *
                                </label>
                                <div class="input-group">
                                    <input type="password" id="current_password" name="current_password"
                                        class="form-input" placeholder="Enter your current password" required>
                                    <button type="button" class="password-toggle"
                                        onclick="togglePassword('current_password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <div class="input-focus-border"></div>
                                </div>
                                @error('current_password')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i>
                                    New Password *
                                </label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-input"
                                        placeholder="Enter your new password" required>
                                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <div class="input-focus-border"></div>
                                </div>
                                @error('password')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-check-circle"></i>
                                Confirm New Password *
                            </label>
                            <div class="input-group">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-input" placeholder="Confirm your new password" required>
                                <button type="button" class="password-toggle"
                                    onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <div class="input-focus-border"></div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary action-btn submit-btn" id="passwordSubmitBtn">
                                <i class="fas fa-save"></i>
                                <span class="btn-text">Update Password</span>
                                <span class="btn-loading hidden">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    Updating...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Account Security Form -->
        <div class="profile-form-card">
            <div class="card-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-shield-alt"></i>
                        Account Security
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Security Options
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="security-options">
                    <div class="security-item">
                        <div class="security-info">
                            <div class="security-icon">
                                <i class="fas fa-envelope-check"></i>
                            </div>
                            <div class="security-content">
                                <h4 class="security-title">Email Verification</h4>
                                <p class="security-description">Verify your email address to enhance account security
                                </p>
                            </div>
                        </div>
                        <div class="security-status">
                            @if(Auth::user()->email_verified_at)
                            <span class="status-badge verified">
                                <div class="status-dot"></div>
                                Verified
                            </span>
                            @else
                            <span class="status-badge unverified">
                                <div class="status-dot"></div>
                                Pending
                            </span>
                            <form method="POST" action="{{ route('verification.send') }}" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-paper-plane"></i>
                                    <span>Resend</span>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <div class="security-item">
                        <div class="security-info">
                            <div class="security-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="security-content">
                                <h4 class="security-title">Two-Factor Authentication</h4>
                                <p class="security-description">Add an extra layer of security to your account</p>
                            </div>
                        </div>
                        <div class="security-status">
                            <span class="status-badge disabled">
                                <div class="status-dot"></div>
                                Not Enabled
                            </span>
                            <button class="btn btn-sm btn-outline" disabled>
                                <i class="btn-text">
                                    <i class="fas fa-plus"></i>
                                    <span>Enable</span>
                                </i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Action Buttons -->
    <div class="action-section">
        <div class="action-buttons">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline action-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Dashboard</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-info action-btn">
                <i class="fas fa-users"></i>
                <span>Manage Users</span>
            </a>
        </div>
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

// Enhanced form validation
document.querySelectorAll('.profile-form, .password-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
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
        if (this.classList.contains('password-form')) {
            const password = this.querySelector('#password');
            const confirmPassword = this.querySelector('#password_confirmation');

            if (password && confirmPassword && password.value !== confirmPassword.value) {
                confirmPassword.classList.add('error');
                isValid = false;
            } else if (confirmPassword) {
                confirmPassword.classList.remove('error');
            }
        }

        if (!isValid) {
            e.preventDefault();
            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'form-error';
            errorDiv.innerHTML =
                '<i class="fas fa-exclamation-triangle"></i> Please fill in all required fields correctly.';
            this.insertBefore(errorDiv, this.querySelector('.form-actions'));

            setTimeout(() => {
                errorDiv.remove();
            }, 5000);
        } else {
            // Show loading state
            const submitBtn = this.querySelector('.submit-btn');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            }
        }
    });
});

// Real-time validation feedback
document.querySelectorAll('.form-input').forEach(input => {
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

// Add hover effects to profile cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.profile-card, .profile-form-card');

    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
            this.style.boxShadow = 'var(--shadow-xl)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });

    // Add hover effects to security items
    const securityItems = document.querySelectorAll('.security-item');
    securityItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
            this.style.backgroundColor = 'var(--gray-50)';
        });

        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
            this.style.backgroundColor = '';
        });
    });

    // Add hover effects to stat items
    const statItems = document.querySelectorAll('.stat-item');
    statItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.2)';
        });

        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });
});
</script>
@endpush