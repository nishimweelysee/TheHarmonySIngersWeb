@extends('layouts.admin')

@section('title', 'Edit Instrument')
@section('page-title', 'Edit Instrument')

@section('content')
<!-- Enhanced Page Header -->
<div class="page-header enhanced-header instrument-edit-header">
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
                <h2 class="header-title">Edit Instrument Profile</h2>
                <p class="header-subtitle">Update information for {{ $instrument->name }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">#{{ $instrument->id }}</span>
                        <span class="stat-label">Instrument ID</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ ucfirst($instrument->type) }}</span>
                        <span class="stat-label">Type</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $instrument->is_available ? 'Available' : 'Not Available' }}</span>
                        <span class="stat-label">Status</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.instruments.show', $instrument) }}" class="btn btn-info enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-eye"></i>
                    <span>View Instrument</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            <a href="{{ route('admin.instruments.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Instruments</span>
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

        <form method="POST" action="{{ route('admin.instruments.update', $instrument) }}" class="instrument-form enhanced-form">
            @csrf
            @method('PUT')

            <div class="enhanced-form-grid">
                <!-- Basic Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Basic Information
                        </h3>
                        <p class="section-subtitle">Update instrument details and identification</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="name" class="form-label enhanced-label">
                                <i class="fas fa-guitar"></i>
                                Instrument Name *
                            </label>
                            <input type="text" id="name" name="name" class="form-input enhanced-input"
                                value="{{ old('name', $instrument->name) }}" required>
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
                                Instrument Type *
                            </label>
                            <select id="type" name="type" class="form-select enhanced-select" required>
                                <option value="">Select Type</option>
                                <option value="string" {{ old('type', $instrument->type) == 'string' ? 'selected' : '' }}>String</option>
                                <option value="wind" {{ old('type', $instrument->type) == 'wind' ? 'selected' : '' }}>Wind</option>
                                <option value="percussion" {{ old('type', $instrument->type) == 'percussion' ? 'selected' : '' }}>Percussion</option>
                                <option value="keyboard" {{ old('type', $instrument->type) == 'keyboard' ? 'selected' : '' }}>Keyboard</option>
                                <option value="electronic" {{ old('type', $instrument->type) == 'electronic' ? 'selected' : '' }}>Electronic</option>
                                <option value="other" {{ old('type', $instrument->type) == 'other' ? 'selected' : '' }}>Other</option>
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
                            <label for="brand" class="form-label enhanced-label">
                                <i class="fas fa-building"></i>
                                Brand
                            </label>
                            <input type="text" id="brand" name="brand" class="form-input enhanced-input"
                                value="{{ old('brand', $instrument->brand) }}">
                            <div class="input-glow"></div>
                            @error('brand')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="model" class="form-label enhanced-label">
                                <i class="fas fa-cube"></i>
                                Model
                            </label>
                            <input type="text" id="model" name="model" class="form-input enhanced-input"
                                value="{{ old('model', $instrument->model) }}">
                            <div class="input-glow"></div>
                            @error('model')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="description" class="form-label enhanced-label">
                            <i class="fas fa-align-left"></i>
                            Description
                        </label>
                        <textarea id="description" name="description" class="form-textarea enhanced-textarea"
                            rows="3">{{ old('description', $instrument->description) }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('description')
                        <div class="error-message enhanced-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Technical Details Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-cogs"></i>
                            Technical Details
                        </h3>
                        <p class="section-subtitle">Update serial number, purchase information, and specifications</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="serial_number" class="form-label enhanced-label">
                                <i class="fas fa-barcode"></i>
                                Serial Number
                            </label>
                            <div class="enhanced-input-group">
                                <input type="text" id="serial_number" name="serial_number" class="form-input enhanced-input"
                                    value="{{ old('serial_number', $instrument->serial_number) }}">
                                <button type="button" class="input-suffix" onclick="generateSerialNumber()">
                                    <i class="fas fa-magic"></i>
                                </button>
                                <div class="input-glow"></div>
                            </div>
                            <small class="enhanced-help">Click the magic wand to auto-generate a serial number</small>
                            @error('serial_number')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="purchase_date" class="form-label enhanced-label">
                                <i class="fas fa-calendar"></i>
                                Purchase Date
                            </label>
                            <input type="date" id="purchase_date" name="purchase_date" class="form-input enhanced-input"
                                value="{{ old('purchase_date', $instrument->purchase_date?->format('Y-m-d')) }}">
                            <div class="input-glow"></div>
                            @error('purchase_date')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="purchase_price" class="form-label enhanced-label">
                                <i class="fas fa-dollar-sign"></i>
                                Purchase Price
                            </label>
                            <div class="enhanced-input-group">
                                <span class="input-prefix">$</span>
                                <input type="number" id="purchase_price" name="purchase_price" class="form-input enhanced-input"
                                    value="{{ old('purchase_price', $instrument->purchase_price) }}"
                                    step="0.01" min="0">
                                <div class="input-glow"></div>
                            </div>
                            @error('purchase_price')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="condition" class="form-label enhanced-label">
                                <i class="fas fa-star"></i>
                                Condition
                            </label>
                            <select id="condition" name="condition" class="form-select enhanced-select">
                                <option value="">Select Condition</option>
                                <option value="excellent" {{ old('condition', $instrument->condition) == 'excellent' ? 'selected' : '' }}>Excellent</option>
                                <option value="good" {{ old('condition', $instrument->condition) == 'good' ? 'selected' : '' }}>Good</option>
                                <option value="fair" {{ old('condition', $instrument->condition) == 'fair' ? 'selected' : '' }}>Fair</option>
                                <option value="poor" {{ old('condition', $instrument->condition) == 'poor' ? 'selected' : '' }}>Poor</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('condition')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="location" class="form-label enhanced-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Location
                            </label>
                            <input type="text" id="location" name="location" class="form-input enhanced-input"
                                value="{{ old('location', $instrument->location) }}">
                            <div class="input-glow"></div>
                            @error('location')
                            <div class="error-message enhanced-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="is_available" class="form-label enhanced-label">
                                <i class="fas fa-toggle-on"></i>
                                Availability
                            </label>
                            <div class="checkbox-group enhanced-checkbox">
                                <input type="checkbox" id="is_available" name="is_available" value="1" class="enhanced-checkbox-input"
                                    {{ old('is_available', $instrument->is_available) ? 'checked' : '' }}>
                                <label for="is_available" class="checkbox-label enhanced-label">
                                    <div class="checkbox-custom"></div>
                                    Available for Use
                                </label>
                            </div>
                            @error('is_available')
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
                            rows="4">{{ old('notes', $instrument->notes) }}</textarea>
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
                        <span>Update Instrument</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.instruments.show', $instrument) }}" class="btn btn-secondary enhanced-btn">
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
    // Generate serial number function
    function generateSerialNumber() {
        const timestamp = Date.now().toString(36);
        const random = Math.random().toString(36).substr(2, 5);
        const serialNumber = `SN${timestamp}${random}`.toUpperCase();
        document.getElementById('serial_number').value = serialNumber;
    }

    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.instrument-form');

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

            // Validate purchase price if provided
            const purchasePriceField = form.querySelector('#purchase_price');
            if (purchasePriceField.value && parseFloat(purchasePriceField.value) < 0) {
                purchasePriceField.classList.add('error');
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
    });
</script>
@endpush