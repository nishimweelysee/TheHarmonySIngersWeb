@extends('layouts.admin')

@section('title', 'Add Member')
@section('page-title', 'Add New Member')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header member-create-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-user-plus"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Add New Member</h2>
                <p class="header-subtitle">Register a new choir member or singer to join The Harmony Singers</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="stat-label">Expand Choir</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-music"></i>
                        </span>
                        <span class="stat-label">New Voice</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-calendar-plus"></i>
                        </span>
                        <span class="stat-label">Join Today</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
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

<!-- Enhanced Content Card -->
<div class="content-card enhanced-card">
    <div class="card-header enhanced-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Member Registration Form
            </h3>
            <div class="header-badge">
                <span class="badge-dot"></span>
                Required Fields
            </div>
        </div>
    </div>

    <div class="card-content">
        <form method="POST" action="{{ route('admin.members.store') }}" class="member-form enhanced-form"
            enctype="multipart/form-data">
            @csrf

            <div class="form-grid enhanced-form-grid">
                <!-- Personal Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-user"></i>
                            Personal Information
                        </h4>
                        <p class="section-subtitle">Basic details about the new member</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="first_name" class="form-label enhanced-label">
                                <i class="fas fa-user"></i>
                                First Name *
                            </label>
                            <input type="text" id="first_name" name="first_name" class="form-input enhanced-input"
                                value="{{ old('first_name') }}" placeholder="Enter first name" required>
                            <div class="input-glow"></div>
                            @error('first_name')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="last_name" class="form-label enhanced-label">
                                <i class="fas fa-user"></i>
                                Last Name *
                            </label>
                            <input type="text" id="last_name" name="last_name" class="form-input enhanced-input"
                                value="{{ old('last_name') }}" placeholder="Enter last name" required>
                            <div class="input-glow"></div>
                            @error('last_name')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="email" class="form-label enhanced-label">
                                <i class="fas fa-envelope"></i>
                                Email Address *
                            </label>
                            <input type="email" id="email" name="email" class="form-input enhanced-input"
                                value="{{ old('email') }}" placeholder="Enter email address" required>
                            <div class="input-glow"></div>
                            @error('email')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="phone" class="form-label enhanced-label">
                                <i class="fas fa-phone"></i>
                                Phone Number
                            </label>
                            <input type="tel" id="phone" name="phone" class="form-input enhanced-input"
                                value="{{ old('phone') }}" placeholder="Enter phone number">
                            <div class="input-glow"></div>
                            @error('phone')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="date_of_birth" class="form-label enhanced-label">
                                <i class="fas fa-birthday-cake"></i>
                                Date of Birth
                            </label>
                            <input type="date" id="date_of_birth" name="date_of_birth" class="form-input enhanced-input"
                                value="{{ old('date_of_birth') }}">
                            <div class="input-glow"></div>
                            @error('date_of_birth')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="profile_photo" class="form-label enhanced-label">
                                <i class="fas fa-camera"></i>
                                Profile Photo
                            </label>
                            <div class="file-upload-container enhanced-upload">
                                <input type="file" id="profile_photo" name="profile_photo"
                                    class="file-input enhanced-file-input" accept="image/*">
                                <div class="upload-placeholder">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choose a photo or drag here</span>
                                    <small>JPG, PNG, GIF up to 5MB</small>
                                </div>
                                <div class="upload-preview" id="uploadPreview" style="display: none;">
                                    <img src="" alt="Preview" id="previewImage">
                                    <button type="button" class="remove-file" onclick="removeFile()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @error('profile_photo')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="address" class="form-label enhanced-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Address
                        </label>
                        <textarea id="address" name="address" class="form-textarea enhanced-textarea" rows="3"
                            placeholder="Enter full address">{{ old('address') }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('address')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Choir Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-music"></i>
                            Choir Information
                        </h4>
                        <p class="section-subtitle">Musical and membership details</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="type" class="form-label enhanced-label">
                                <i class="fas fa-microphone"></i>
                                Member Type *
                            </label>
                            <select id="type" name="type" class="form-select enhanced-select" required>
                                <option value="">Select Member Type</option>
                                <option value="singer" {{ old('type') == 'singer' ? 'selected' : '' }}>Singer</option>
                                <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General Member
                                </option>
                            </select>
                            <div class="select-glow"></div>
                            @error('type')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="voice_part" class="form-label enhanced-label">
                                <i class="fas fa-music"></i>
                                Voice Part
                            </label>
                            <select id="voice_part" name="voice_part" class="form-select enhanced-select">
                                <option value="">Select Voice Part</option>
                                <option value="soprano" {{ old('voice_part') == 'soprano' ? 'selected' : '' }}>Soprano
                                </option>
                                <option value="alto" {{ old('voice_part') == 'alto' ? 'selected' : '' }}>Alto</option>
                                <option value="tenor" {{ old('voice_part') == 'tenor' ? 'selected' : '' }}>Tenor
                                </option>
                                <option value="bass" {{ old('voice_part') == 'bass' ? 'selected' : '' }}>Bass</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('voice_part')
                            <span class="error-message enhanced-error">{{ $message }}</span>
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
                                value="{{ old('join_date', date('Y-m-d')) }}" required>
                            <div class="input-glow"></div>
                            @error('join_date')
                            <span class="error-message enhanced-error">{{ $message }}</span>
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
                                    {{ old('is_active', '1') ? 'checked' : '' }} class="enhanced-checkbox-input">
                                <label for="is_active" class="checkbox-label enhanced-label">
                                    <div class="checkbox-custom"></div>
                                    Active Member
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
                        <span>Create Member</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.members.index') }}" class="btn btn-outline action-btn">
                        <i class="fas fa-times"></i>
                        <span>Cancel</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// File upload preview functionality
document.getElementById('profile_photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('uploadPreview').style.display = 'block';
            document.querySelector('.upload-placeholder').style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
});

function removeFile() {
    document.getElementById('profile_photo').value = '';
    document.getElementById('uploadPreview').style.display = 'none';
    document.querySelector('.upload-placeholder').style.display = 'flex';
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

    if (!isValid) {
        e.preventDefault();
        // Show error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'form-error enhanced-error';
        errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Please fill in all required fields.';
        document.querySelector('.enhanced-form').insertBefore(errorDiv, document.querySelector(
            '.form-actions'));

        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }
});
</script>

@endsection