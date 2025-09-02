@extends('layouts.admin')

@section('title', 'Edit Sponsor')
@section('page-title', 'Edit Sponsor')

@section('content')
<!-- Enhanced Page Header -->
<div class="page-header enhanced-header sponsor-edit-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-edit"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Edit Sponsor Profile</h2>
                <p class="header-subtitle">Update information for {{ $sponsor->name }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">#{{ $sponsor->id }}</span>
                        <span class="stat-label">Sponsor ID</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $sponsor->partnership_start_date ? $sponsor->partnership_start_date->diffForHumans() : 'Not set' }}</span>
                        <span class="stat-label">Partnership Since</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ ucfirst($sponsor->status) }}</span>
                        <span class="stat-label">Current Status</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.sponsors.show', $sponsor) }}" class="btn btn-info enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-eye"></i>
                    <span>View Sponsor</span>
                </div>
                <div class="btn-glow"></div>
            </a>
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

<div class="content-card enhanced-card">
    <div class="card-content">
        @if ($errors->any())
        <div class="form-error enhanced-error">
            <i class="fas fa-exclamation-triangle"></i>
            <span>Please fix the following errors:</span>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.sponsors.update', $sponsor) }}" class="sponsor-form enhanced-form">
            @csrf
            @method('PUT')

            <div class="enhanced-form-grid">
                <!-- Basic Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-building"></i>
                            Basic Information
                        </h3>
                        <p class="section-subtitle">Update sponsor's organization details and contact information</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="name" class="form-label enhanced-label">
                                <i class="fas fa-building"></i>
                                Organization Name *
                            </label>
                            <input type="text" id="name" name="name" class="form-input enhanced-input"
                                value="{{ old('name', $sponsor->name) }}" required>
                            <div class="input-glow"></div>
                            @error('name')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                        <div class="form-group enhanced-group">
                            <label for="type" class="form-label enhanced-label">
                                <i class="fas fa-tag"></i>
                                Sponsor Type *
                            </label>
                            <select id="type" name="type" class="form-select enhanced-select" required>
                            <option value="">Select Type</option>
                            <option value="corporate" {{ old('type', $sponsor->type) == 'corporate' ? 'selected' : '' }}>Corporate</option>
                            <option value="individual" {{ old('type', $sponsor->type) == 'individual' ? 'selected' : '' }}>Individual</option>
                            <option value="foundation" {{ old('type', $sponsor->type) == 'foundation' ? 'selected' : '' }}>Foundation</option>
                            <option value="government" {{ old('type', $sponsor->type) == 'government' ? 'selected' : '' }}>Government</option>
                        </select>
                            <div class="select-glow"></div>
                        @error('type')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="category" class="form-label enhanced-label">
                                <i class="fas fa-layer-group"></i>
                                Category
                            </label>
                            <input type="text" id="category" name="category" class="form-input enhanced-input"
                                value="{{ old('category', $sponsor->category) }}">
                            <div class="input-glow"></div>
                            @error('category')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="contact_person" class="form-label enhanced-label">
                                <i class="fas fa-user"></i>
                                Contact Person
                            </label>
                            <input type="text" id="contact_person" name="contact_person" class="form-input enhanced-input"
                                value="{{ old('contact_person', $sponsor->contact_person) }}">
                            <div class="input-glow"></div>
                            @error('contact_person')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="contact_email" class="form-label enhanced-label">
                                <i class="fas fa-envelope"></i>
                                Contact Email
                            </label>
                            <input type="email" id="contact_email" name="contact_email" class="form-input enhanced-input"
                                value="{{ old('contact_email', $sponsor->contact_email) }}">
                            <div class="input-glow"></div>
                            @error('contact_email')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                        <div class="form-group enhanced-group">
                            <label for="contact_phone" class="form-label enhanced-label">
                                <i class="fas fa-phone"></i>
                                Contact Phone
                            </label>
                            <input type="tel" id="contact_phone" name="contact_phone" class="form-input enhanced-input"
                                value="{{ old('contact_phone', $sponsor->contact_phone) }}">
                            <div class="input-glow"></div>
                            @error('contact_phone')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                        </div>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="website" class="form-label enhanced-label">
                            <i class="fas fa-globe"></i>
                            Website
                        </label>
                        <input type="url" id="website" name="website" class="form-input enhanced-input"
                            value="{{ old('website', $sponsor->website) }}">
                        <div class="input-glow"></div>
                        @error('website')
                        <div class="error-message enhanced-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="address" class="form-label enhanced-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Address
                        </label>
                        <textarea id="address" name="address" class="form-textarea enhanced-textarea"
                            rows="3">{{ old('address', $sponsor->address) }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('address')
                        <div class="error-message enhanced-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Sponsorship Details Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-star"></i>
                            Sponsorship Details
                        </h3>
                        <p class="section-subtitle">Update sponsor's partnership and financial information</p>
            </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="sponsorship_level" class="form-label enhanced-label">
                                <i class="fas fa-crown"></i>
                                Sponsorship Level
                            </label>
                            <select id="sponsorship_level" name="sponsorship_level" class="form-select enhanced-select">
                            <option value="">Select Level</option>
                            <option value="platinum" {{ old('sponsorship_level', $sponsor->sponsorship_level) == 'platinum' ? 'selected' : '' }}>Platinum</option>
                            <option value="gold" {{ old('sponsorship_level', $sponsor->sponsorship_level) == 'gold' ? 'selected' : '' }}>Gold</option>
                            <option value="silver" {{ old('sponsorship_level', $sponsor->sponsorship_level) == 'silver' ? 'selected' : '' }}>Silver</option>
                            <option value="bronze" {{ old('sponsorship_level', $sponsor->sponsorship_level) == 'bronze' ? 'selected' : '' }}>Bronze</option>
                                <option value="patron" {{ old('sponsorship_level', $sponsor->sponsorship_level) == 'patron' ? 'selected' : '' }}>Patron</option>
                        </select>
                            <div class="select-glow"></div>
                        @error('sponsorship_level')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                        <div class="form-group enhanced-group">
                            <label for="annual_contribution" class="form-label enhanced-label">
                                <i class="fas fa-dollar-sign"></i>
                                Annual Contribution
                            </label>
                            <div class="enhanced-input-group">
                                <span class="input-prefix">$</span>
                                <input type="number" id="annual_contribution" name="annual_contribution" class="form-input enhanced-input"
                                    value="{{ old('annual_contribution', $sponsor->annual_contribution) }}"
                                    step="0.01" min="0">
                                <div class="input-glow"></div>
                            </div>
                            @error('annual_contribution')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="partnership_start_date" class="form-label enhanced-label">
                                <i class="fas fa-calendar-plus"></i>
                                Partnership Start Date
                            </label>
                            <input type="date" id="partnership_start_date" name="partnership_start_date" class="form-input enhanced-input"
                                value="{{ old('partnership_start_date', $sponsor->partnership_start_date?->format('Y-m-d')) }}">
                            <div class="input-glow"></div>
                        @error('partnership_start_date')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="partnership_end_date" class="form-label enhanced-label">
                                <i class="fas fa-calendar-minus"></i>
                                Partnership End Date
                            </label>
                            <input type="date" id="partnership_end_date" name="partnership_end_date" class="form-input enhanced-input"
                                value="{{ old('partnership_end_date', $sponsor->partnership_end_date?->format('Y-m-d')) }}">
                            <div class="input-glow"></div>
                            @error('partnership_end_date')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
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
                                <option value="active" {{ old('status', $sponsor->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $sponsor->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="pending" {{ old('status', $sponsor->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('status')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
            </div>
                        @enderror
                        </div>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="notes" class="form-label enhanced-label">
                            <i class="fas fa-sticky-note"></i>
                            Notes
                        </label>
                        <textarea id="notes" name="notes" class="form-textarea enhanced-textarea"
                            rows="4">{{ old('notes', $sponsor->notes) }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('notes')
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
                        <span>Update Sponsor</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.sponsors.show', $sponsor) }}" class="btn btn-secondary enhanced-btn">
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
    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.sponsor-form');

        form.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');

            // Clear previous error states
            form.querySelectorAll('.enhanced-input, .enhanced-select, .enhanced-textarea').forEach(field => {
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
            const emailField = form.querySelector('#contact_email');
            if (emailField.value && !isValidEmail(emailField.value)) {
                emailField.classList.add('error');
                isValid = false;
            }

            // Validate website URL
            const websiteField = form.querySelector('#website');
            if (websiteField.value && !isValidUrl(websiteField.value)) {
                websiteField.classList.add('error');
                isValid = false;
            }

            // Validate partnership dates
            const startDate = form.querySelector('#partnership_start_date');
            const endDate = form.querySelector('#partnership_end_date');
            if (startDate.value && endDate.value && startDate.value > endDate.value) {
                endDate.classList.add('error');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'form-error enhanced-error';
                errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i><span>Please fill in all required fields correctly.</span>';

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

        function isValidUrl(string) {
            try {
                new URL(string);
                return true;
            } catch (_) {
                return false;
            }
        }
    });
</script>
@endpush