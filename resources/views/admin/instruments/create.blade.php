@extends('layouts.admin')

@section('title', 'Add Instrument')
@section('page-title', 'Add New Instrument')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header instrument-create-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-guitar"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Add New Instrument</h2>
                <p class="header-subtitle">Add a new instrument to the choir's inventory</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="stat-label">New Addition</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-music"></i>
                        </span>
                        <span class="stat-label">Expand Sound</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-calendar-plus"></i>
                        </span>
                        <span class="stat-label">Add Today</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
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

<!-- Enhanced Content Card -->
<div class="content-card enhanced-card">
    <div class="card-header enhanced-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Instrument Registration Form
            </h3>
            <div class="header-badge">
                <span class="badge-dot"></span>
                Required Fields
            </div>
        </div>
    </div>

    <div class="card-content">
        <form method="POST" action="{{ route('admin.instruments.store') }}" class="instrument-form enhanced-form">
            @csrf

            <div class="form-grid enhanced-form-grid">
                <!-- Basic Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Basic Information
                        </h4>
                        <p class="section-subtitle">Instrument details and identification</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="name" class="form-label enhanced-label">
                                <i class="fas fa-guitar"></i>
                                Instrument Name *
                            </label>
                            <input type="text" id="name" name="name"
                                class="form-input enhanced-input"
                                value="{{ old('name') }}"
                                placeholder="Enter instrument name" required>
                            <div class="input-glow"></div>
                            @error('name')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="type" class="form-label enhanced-label">
                                <i class="fas fa-tag"></i>
                                Instrument Type *
                            </label>
                            <select id="type" name="type" class="form-select enhanced-select" required>
                                <option value="">Select Type</option>
                                <option value="string" {{ old('type') == 'string' ? 'selected' : '' }}>String</option>
                                <option value="wind" {{ old('type') == 'wind' ? 'selected' : '' }}>Wind</option>
                                <option value="percussion" {{ old('type') == 'percussion' ? 'selected' : '' }}>Percussion</option>
                                <option value="keyboard" {{ old('type') == 'keyboard' ? 'selected' : '' }}>Keyboard</option>
                                <option value="electronic" {{ old('type') == 'electronic' ? 'selected' : '' }}>Electronic</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('type')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="brand" class="form-label enhanced-label">
                                <i class="fas fa-building"></i>
                                Brand
                            </label>
                            <input type="text" id="brand" name="brand"
                                class="form-input enhanced-input"
                                value="{{ old('brand') }}"
                                placeholder="Enter brand name">
                            <div class="input-glow"></div>
                            @error('brand')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="model" class="form-label enhanced-label">
                                <i class="fas fa-cube"></i>
                                Model
                            </label>
                            <input type="text" id="model" name="model"
                                class="form-input enhanced-input"
                                value="{{ old('model') }}"
                                placeholder="Enter model name">
                            <div class="input-glow"></div>
                            @error('model')
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
                            placeholder="Enter instrument description">{{ old('description') }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('description')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Technical Details Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-cogs"></i>
                            Technical Details
                        </h4>
                        <p class="section-subtitle">Serial number, purchase information, and specifications</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="serial_number" class="form-label enhanced-label">
                                <i class="fas fa-barcode"></i>
                                Serial Number
                            </label>
                            <div class="enhanced-input-group">
                                <input type="text" id="serial_number" name="serial_number"
                                    class="form-input enhanced-input"
                                    value="{{ old('serial_number') }}"
                                    placeholder="e.g., SN123456789">
                                <button type="button" class="input-suffix" onclick="generateSerialNumber()">
                                    <i class="fas fa-magic"></i>
                                </button>
                                <div class="input-glow"></div>
                            </div>
                            <small class="enhanced-help">Click the magic wand to auto-generate a serial number</small>
                            @error('serial_number')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="purchase_date" class="form-label enhanced-label">
                                <i class="fas fa-calendar"></i>
                                Purchase Date
                            </label>
                            <input type="date" id="purchase_date" name="purchase_date"
                                class="form-input enhanced-input"
                                value="{{ old('purchase_date') }}">
                            <div class="input-glow"></div>
                            @error('purchase_date')
                            <span class="error-message enhanced-error">{{ $message }}</span>
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
                                <input type="number" id="purchase_price" name="purchase_price"
                                    class="form-input enhanced-input"
                                    value="{{ old('purchase_price') }}"
                                    placeholder="0.00"
                                    step="0.01"
                                    min="0">
                                <div class="input-glow"></div>
                            </div>
                            @error('purchase_price')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="condition" class="form-label enhanced-label">
                                <i class="fas fa-star"></i>
                                Condition
                            </label>
                            <select id="condition" name="condition" class="form-select enhanced-select">
                                <option value="">Select Condition</option>
                                <option value="excellent" {{ old('condition') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                                <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Good</option>
                                <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                                <option value="poor" {{ old('condition') == 'poor' ? 'selected' : '' }}>Poor</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('condition')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="location" class="form-label enhanced-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Location
                            </label>
                            <input type="text" id="location" name="location"
                                class="form-input enhanced-input"
                                value="{{ old('location') }}"
                                placeholder="e.g., Storage Room A, Stage Left">
                            <div class="input-glow"></div>
                            @error('location')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="is_available" class="form-label enhanced-label">
                                <i class="fas fa-toggle-on"></i>
                                Availability
                            </label>
                            <div class="checkbox-group enhanced-checkbox">
                                <input type="checkbox" id="is_available" name="is_available" value="1"
                                    {{ old('is_available', '1') ? 'checked' : '' }}
                                    class="enhanced-checkbox-input">
                                <label for="is_available" class="checkbox-label enhanced-label">
                                    <span class="checkbox-custom"></span>
                                    Available for Use
                                </label>
                            </div>
                            @error('is_available')
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
                            placeholder="Additional notes about the instrument">{{ old('notes') }}</textarea>
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
                        <span>Create Instrument</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.instruments.index') }}" class="btn btn-outline action-btn">
                        <i class="fas fa-times"></i>
                        <span>Cancel</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Generate serial number function
    function generateSerialNumber() {
        const timestamp = Date.now().toString(36);
        const random = Math.random().toString(36).substr(2, 5);
        const serialNumber = `SN${timestamp}${random}`.toUpperCase();
        document.getElementById('serial_number').value = serialNumber;
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

        // Validate purchase price if provided
        const purchasePriceField = document.getElementById('purchase_price');
        if (purchasePriceField.value && parseFloat(purchasePriceField.value) < 0) {
            purchasePriceField.classList.add('error');
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
</script>

@endsection