@extends('layouts.admin')

@section('title', 'Add Sponsor')
@section('page-title', 'Add New Sponsor')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header sponsor-create-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-handshake"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Add New Sponsor</h2>
                <p class="header-subtitle">Register a new sponsor or partner organization</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-handshake"></i>
                        </span>
                        <span class="stat-label">New Partnership</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-star"></i>
                        </span>
                        <span class="stat-label">Support Growth</span>
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
            <a href="{{ route('admin.sponsors.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Sponsors</span>
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
                Sponsor Registration Form
            </h3>
            <div class="header-badge">
                <span class="badge-dot"></span>
                Required Fields
            </div>
        </div>
    </div>

    <div class="card-content">
        <form method="POST" action="{{ route('admin.sponsors.store') }}" class="sponsor-form enhanced-form">
            @csrf

            <div class="form-grid enhanced-form-grid">
                <!-- Basic Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-building"></i>
                            Basic Information
                        </h4>
                        <p class="section-subtitle">Organization details and contact information</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="name" class="form-label enhanced-label">
                                <i class="fas fa-building"></i>
                                Organization Name *
                            </label>
                            <input type="text" id="name" name="name"
                                class="form-input enhanced-input"
                                value="{{ old('name') }}"
                                placeholder="Enter organization name" required>
                            <div class="input-glow"></div>
                            @error('name')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="type" class="form-label enhanced-label">
                                <i class="fas fa-tag"></i>
                                Sponsor Type *
                            </label>
                            <select id="type" name="type" class="form-select enhanced-select" required>
                                <option value="">Select Sponsor Type</option>
                                <option value="corporate" {{ old('type') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                <option value="individual" {{ old('type') == 'individual' ? 'selected' : '' }}>Individual</option>
                                <option value="foundation" {{ old('type') == 'foundation' ? 'selected' : '' }}>Foundation</option>
                                <option value="government" {{ old('type') == 'government' ? 'selected' : '' }}>Government</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('type')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="category" class="form-label enhanced-label">
                                <i class="fas fa-layer-group"></i>
                                Category
                            </label>
                            <input type="text" id="category" name="category"
                                class="form-input enhanced-input"
                                value="{{ old('category') }}"
                                placeholder="Enter category (e.g., Technology, Healthcare)">
                            <div class="input-glow"></div>
                            @error('category')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="contact_person" class="form-label enhanced-label">
                                <i class="fas fa-user"></i>
                                Contact Person
                            </label>
                            <input type="text" id="contact_person" name="contact_person"
                                class="form-input enhanced-input"
                                value="{{ old('contact_person') }}"
                                placeholder="Enter contact person name">
                            <div class="input-glow"></div>
                            @error('contact_person')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="contact_email" class="form-label enhanced-label">
                                <i class="fas fa-envelope"></i>
                                Contact Email
                            </label>
                            <input type="email" id="contact_email" name="contact_email"
                                class="form-input enhanced-input"
                                value="{{ old('contact_email') }}"
                                placeholder="Enter contact email">
                            <div class="input-glow"></div>
                            @error('contact_email')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="contact_phone" class="form-label enhanced-label">
                                <i class="fas fa-phone"></i>
                                Contact Phone
                            </label>
                            <input type="tel" id="contact_phone" name="contact_phone"
                                class="form-input enhanced-input"
                                value="{{ old('contact_phone') }}"
                                placeholder="Enter contact phone">
                            <div class="input-glow"></div>
                            @error('contact_phone')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="website" class="form-label enhanced-label">
                            <i class="fas fa-globe"></i>
                            Website
                        </label>
                        <input type="url" id="website" name="website"
                            class="form-input enhanced-input"
                            value="{{ old('website') }}"
                            placeholder="Enter website URL">
                        <div class="input-glow"></div>
                        @error('website')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="address" class="form-label enhanced-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Address
                        </label>
                        <textarea id="address" name="address"
                            class="form-textarea enhanced-textarea"
                            rows="3"
                            placeholder="Enter organization address">{{ old('address') }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('address')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Sponsorship Details Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-star"></i>
                            Sponsorship Details
                        </h4>
                        <p class="section-subtitle">Partnership and financial information</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="sponsorship_level" class="form-label enhanced-label">
                                <i class="fas fa-crown"></i>
                                Sponsorship Level
                            </label>
                            <select id="sponsorship_level" name="sponsorship_level" class="form-select enhanced-select">
                                <option value="">Select Level</option>
                                <option value="platinum" {{ old('sponsorship_level') == 'platinum' ? 'selected' : '' }}>Platinum</option>
                                <option value="gold" {{ old('sponsorship_level') == 'gold' ? 'selected' : '' }}>Gold</option>
                                <option value="silver" {{ old('sponsorship_level') == 'silver' ? 'selected' : '' }}>Silver</option>
                                <option value="bronze" {{ old('sponsorship_level') == 'bronze' ? 'selected' : '' }}>Bronze</option>
                                <option value="patron" {{ old('sponsorship_level') == 'patron' ? 'selected' : '' }}>Patron</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('sponsorship_level')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="annual_contribution" class="form-label enhanced-label">
                                <i class="fas fa-dollar-sign"></i>
                                Annual Contribution
                            </label>
                            <div class="enhanced-input-group">
                                <span class="input-prefix">$</span>
                                <input type="number" id="annual_contribution" name="annual_contribution"
                                    class="form-input enhanced-input"
                                    value="{{ old('annual_contribution') }}"
                                    placeholder="0.00"
                                    step="0.01"
                                    min="0">
                                <div class="input-glow"></div>
                            </div>
                            @error('annual_contribution')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="partnership_start_date" class="form-label enhanced-label">
                                <i class="fas fa-calendar-plus"></i>
                                Partnership Start Date
                            </label>
                            <input type="date" id="partnership_start_date" name="partnership_start_date"
                                class="form-input enhanced-input"
                                value="{{ old('partnership_start_date') }}">
                            <div class="input-glow"></div>
                            @error('partnership_start_date')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="partnership_end_date" class="form-label enhanced-label">
                                <i class="fas fa-calendar-minus"></i>
                                Partnership End Date
                            </label>
                            <input type="date" id="partnership_end_date" name="partnership_end_date"
                                class="form-input enhanced-input"
                                value="{{ old('partnership_end_date') }}">
                            <div class="input-glow"></div>
                            @error('partnership_end_date')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="status" class="form-label enhanced-label">
                                <i class="fas fa-toggle-on"></i>
                                Status *
                            </label>
                            <select id="status" name="status" class="form-select enhanced-select" required>
                                <option value="">Select Status</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('status')
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
                            rows="4"
                            placeholder="Additional notes about the sponsor or partnership">{{ old('notes') }}</textarea>
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
                        <span>Create Sponsor</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.sponsors.index') }}" class="btn btn-outline action-btn">
                        <i class="fas fa-times"></i>
                        <span>Cancel</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
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

        // Validate email format if provided
        const emailField = document.getElementById('contact_email');
        if (emailField.value && !isValidEmail(emailField.value)) {
            emailField.classList.add('error');
            isValid = false;
        }

        // Validate website URL if provided
        const websiteField = document.getElementById('website');
        if (websiteField.value && !isValidUrl(websiteField.value)) {
            websiteField.classList.add('error');
            isValid = false;
        }

        // Validate partnership dates
        const startDate = document.getElementById('partnership_start_date');
        const endDate = document.getElementById('partnership_end_date');
        if (startDate.value && endDate.value && startDate.value > endDate.value) {
            endDate.classList.add('error');
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

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
</script>

@endsection