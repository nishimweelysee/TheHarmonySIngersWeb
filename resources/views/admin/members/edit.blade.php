@extends('layouts.admin')

@section('title', 'Edit Member')
@section('page-title', 'Edit Member')

@section('content')
<!-- Enhanced Page Header -->
<div class="page-header enhanced-header member-edit-header">
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
                <h2 class="header-title">Edit Member Profile</h2>
                <p class="header-subtitle">Update information for {{ $member->full_name }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">#{{ $member->id }}</span>
                        <span class="stat-label">Member ID</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $member->join_date->diffForHumans() }}</span>
                        <span class="stat-label">Member Since</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $member->is_active ? 'Active' : 'Inactive' }}</span>
                        <span class="stat-label">Current Status</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.members.show', $member) }}" class="btn btn-info enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-eye"></i>
                    <span>View Member</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            <a href="{{ route('admin.members.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Members</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<div class="content-card enhanced-card">
    <div class="card-content">
        @if ($errors->any())
        <div class="form-error enhanced-error">
            <i class="fas fa-exclamation-triangle"></i>
            <span>Please fix the following errors:</span>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.members.update', $member) }}" class="member-form enhanced-form"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="enhanced-form-grid">
                <!-- Personal Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-user"></i>
                            Personal Information
                        </h3>
                        <p class="section-subtitle">Update member's personal details and contact information</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="first_name" class="form-label enhanced-label">
                                <i class="fas fa-user"></i>
                                First Name *
                            </label>
                            <input type="text" id="first_name" name="first_name" class="form-input enhanced-input"
                                value="{{ old('first_name', $member->first_name) }}" required>
                            <div class="input-glow"></div>
                            @error('first_name')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="last_name" class="form-label enhanced-label">
                                <i class="fas fa-user"></i>
                                Last Name *
                            </label>
                            <input type="text" id="last_name" name="last_name" class="form-input enhanced-input"
                                value="{{ old('last_name', $member->last_name) }}" required>
                            <div class="input-glow"></div>
                            @error('last_name')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="email" class="form-label enhanced-label">
                                <i class="fas fa-envelope"></i>
                                Email *
                            </label>
                            <input type="email" id="email" name="email" class="form-input enhanced-input"
                                value="{{ old('email', $member->email) }}" required>
                            <div class="input-glow"></div>
                            @error('email')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="phone" class="form-label enhanced-label">
                                <i class="fas fa-phone"></i>
                                Phone
                            </label>
                            <input type="tel" id="phone" name="phone" class="form-input enhanced-input"
                                value="{{ old('phone', $member->phone) }}">
                            <div class="input-glow"></div>
                            @error('phone')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="date_of_birth" class="form-label enhanced-label">
                                <i class="fas fa-calendar"></i>
                                Date of Birth
                            </label>
                            <input type="date" id="date_of_birth" name="date_of_birth" class="form-input enhanced-input"
                                value="{{ old('date_of_birth', $member->date_of_birth?->format('Y-m-d')) }}">
                            <div class="input-glow"></div>
                            @error('date_of_birth')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="profile_photo" class="form-label enhanced-label">
                                <i class="fas fa-camera"></i>
                                Profile Photo
                            </label>
                            <div class="file-upload-container enhanced-upload" id="photoUploadContainer">
                                @if($member->profile_photo)
                                <div class="upload-preview">
                                    <img src="{{ Storage::url($member->profile_photo) }}" alt="Current Profile Photo"
                                        id="currentPhoto">
                                    <button type="button" class="remove-file" onclick="removeCurrentPhoto()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @else
                                <div class="upload-placeholder">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Click to upload new photo</span>
                                    <small>or drag and drop</small>
                                </div>
                                @endif
                                <input type="file" id="profile_photo" name="profile_photo"
                                    class="file-input enhanced-file-input" accept="image/*"
                                    onchange="previewPhoto(this)">
                            </div>
                            @error('profile_photo')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="address" class="form-label enhanced-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Address
                        </label>
                        <textarea id="address" name="address" class="form-textarea enhanced-textarea"
                            rows="3">{{ old('address', $member->address) }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('address')
                        <div class="error-message enhanced-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Choir Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-music"></i>
                            Choir Information
                        </h3>
                        <p class="section-subtitle">Update member's choir role and participation details</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="type" class="form-label enhanced-label">
                                <i class="fas fa-users"></i>
                                Member Type *
                            </label>
                            <select id="type" name="type" class="form-select enhanced-select" required>
                                <option value="">Select Type</option>
                                <option value="singer" {{ old('type', $member->type) == 'singer' ? 'selected' : '' }}>
                                    Singer</option>
                                <option value="general" {{ old('type', $member->type) == 'general' ? 'selected' : '' }}>
                                    General Member</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('type')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="voice_part" class="form-label enhanced-label">
                                <i class="fas fa-microphone"></i>
                                Voice Part
                            </label>
                            <select id="voice_part" name="voice_part" class="form-select enhanced-select">
                                <option value="">Select Voice Part</option>
                                <option value="soprano"
                                    {{ old('voice_part', $member->voice_part) == 'soprano' ? 'selected' : '' }}>Soprano
                                </option>
                                <option value="alto"
                                    {{ old('voice_part', $member->voice_part) == 'alto' ? 'selected' : '' }}>Alto
                                </option>
                                <option value="tenor"
                                    {{ old('voice_part', $member->voice_part) == 'tenor' ? 'selected' : '' }}>Tenor
                                </option>
                                <option value="bass"
                                    {{ old('voice_part', $member->voice_part) == 'bass' ? 'selected' : '' }}>Bass
                                </option>
                            </select>
                            <div class="select-glow"></div>
                            @error('voice_part')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="join_date" class="form-label enhanced-label">
                                <i class="fas fa-calendar-plus"></i>
                                Join Date *
                            </label>
                            <input type="date" id="join_date" name="join_date" class="form-input enhanced-input"
                                value="{{ old('join_date', $member->join_date->format('Y-m-d')) }}" required>
                            <div class="input-glow"></div>
                            @error('join_date')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label class="form-label enhanced-label">
                                <i class="fas fa-toggle-on"></i>
                                Member Status
                            </label>
                            <div class="checkbox-group enhanced-checkbox">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                    class="enhanced-checkbox-input"
                                    {{ old('is_active', $member->is_active) ? 'checked' : '' }}>
                                <label for="is_active" class="checkbox-label enhanced-label">
                                    <div class="checkbox-custom"></div>
                                    Active Member
                                </label>
                            </div>
                            @error('is_active')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions enhanced-actions">
                <div class="action-buttons">
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-save"></i>
                        <span>Update Member</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.members.show', $member) }}" class="btn btn-secondary enhanced-btn">
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

@endsection

@push('scripts')
<script>
// File upload preview functionality
function previewPhoto(input) {
    const container = document.getElementById('photoUploadContainer');
    const currentPhoto = document.getElementById('currentPhoto');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            // Remove current photo if exists
            if (currentPhoto) {
                currentPhoto.remove();
            }

            // Create new preview
            const preview = document.createElement('div');
            preview.className = 'upload-preview';
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Photo Preview">
                <button type="button" class="remove-file" onclick="removePhoto()">
                    <i class="fas fa-times"></i>
                </button>
            `;

            // Clear container and add preview
            container.innerHTML = '';
            container.appendChild(preview);
            container.appendChild(input);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

// Remove current photo
function removeCurrentPhoto() {
    const container = document.getElementById('photoUploadContainer');
    const input = container.querySelector('input[type="file"]');

    // Clear the file input
    input.value = '';

    // Show upload placeholder
    container.innerHTML = `
        <div class="upload-placeholder">
            <i class="fas fa-cloud-upload-alt"></i>
            <span>Click to upload new photo</span>
            <small>or drag and drop</small>
        </div>
        <input type="file" id="profile_photo" name="profile_photo" class="file-input enhanced-file-input" 
            accept="image/*" onchange="previewPhoto(this)">
    `;
}

// Remove uploaded photo
function removePhoto() {
    const container = document.getElementById('photoUploadContainer');
    const input = container.querySelector('input[type="file"]');

    // Clear the file input
    input.value = '';

    // Show upload placeholder
    container.innerHTML = `
        <div class="upload-placeholder">
            <i class="fas fa-cloud-upload-alt"></i>
            <span>Click to upload new photo</span>
            <small>or drag and drop</small>
        </div>
        <input type="file" id="profile_photo" name="profile_photo" class="file-input enhanced-file-input" 
            accept="image/*" onchange="previewPhoto(this)">
    `;
}

// Drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('photoUploadContainer');

    container.addEventListener('dragover', function(e) {
        e.preventDefault();
        container.classList.add('dragover');
    });

    container.addEventListener('dragleave', function(e) {
        e.preventDefault();
        container.classList.remove('dragover');
    });

    container.addEventListener('drop', function(e) {
        e.preventDefault();
        container.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const input = container.querySelector('input[type="file"]');
            input.files = files;
            previewPhoto(input);
        }
    });
});

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.member-form');

    form.addEventListener('submit', function(e) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');

        // Clear previous error states
        form.querySelectorAll('.enhanced-input, .enhanced-select, .enhanced-textarea').forEach(
            field => {
                field.classList.remove('error');
            });

        // Validate required fields
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('error');
                isValid = false;
            }
        });

        // Validate email format
        const emailField = form.querySelector('#email');
        if (emailField.value && !isValidEmail(emailField.value)) {
            emailField.classList.add('error');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'form-error enhanced-error';
            errorDiv.innerHTML =
                '<i class="fas fa-exclamation-triangle"></i><span>Please fill in all required fields correctly.</span>';

            const existingError = form.querySelector('.form-error');
            if (existingError) {
                existingError.remove();
            }

            form.insertBefore(errorDiv, form.firstChild);

            // Scroll to first error
            const firstError = form.querySelector('.error');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }
    });

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});
</script>
@endpush