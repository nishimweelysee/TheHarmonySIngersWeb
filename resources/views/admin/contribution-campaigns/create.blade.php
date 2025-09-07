@extends('layouts.admin')

@section('title', 'Create Campaign')
@section('page-title', 'Create Campaign')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header campaign-create-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-plus-circle"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Create New Campaign</h2>
                <p class="header-subtitle">Launch a new contribution campaign for The Harmony Singers</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-bullhorn"></i>
                        </span>
                        <span class="stat-label">New Campaign</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-hand-holding-usd"></i>
                        </span>
                        <span class="stat-label">Fundraising</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-calendar-plus"></i>
                        </span>
                        <span class="stat-label">Start Today</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.contribution-campaigns.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Campaigns</span>
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
                Campaign Creation Form
            </h3>
            <div class="header-badge">
                <span class="badge-dot"></span>
                Required Fields
            </div>
        </div>
    </div>

    <div class="card-content">
        <form method="POST" action="{{ route('admin.contribution-campaigns.store') }}" class="campaign-form enhanced-form">
            @csrf

            @if($errors->any())
            <div class="alert alert-danger enhanced-alert">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <div class="form-grid enhanced-form-grid">
                <!-- Basic Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Basic Information
                        </h4>
                        <p class="section-subtitle">Essential details about the campaign</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="name" class="form-label enhanced-label">
                                <i class="fas fa-tag"></i>
                                Campaign Name *
                            </label>
                            <input type="text" id="name" name="name"
                                class="form-input enhanced-input"
                                value="{{ old('name') }}"
                                placeholder="Enter campaign name" required>
                            <div class="input-glow"></div>
                            @error('name')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="type" class="form-label enhanced-label">
                                <i class="fas fa-list"></i>
                                Campaign Type *
                            </label>
                            <select id="type" name="type" class="form-select enhanced-select" required>
                                <option value="">Select Type</option>
                                <option value="monthly" {{ old('type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="project" {{ old('type') == 'project' ? 'selected' : '' }}>Project</option>
                                <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event</option>
                                <option value="special" {{ old('type') == 'special' ? 'selected' : '' }}>Special</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('type')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="start_date" class="form-label enhanced-label">
                                <i class="fas fa-calendar-plus"></i>
                                Start Date *
                            </label>
                            <input type="date" id="start_date" name="start_date"
                                class="form-input enhanced-input"
                                value="{{ old('start_date') }}" required>
                            <div class="input-glow"></div>
                            @error('start_date')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="end_date" class="form-label enhanced-label">
                                <i class="fas fa-calendar-check"></i>
                                End Date *
                            </label>
                            <input type="date" id="end_date" name="end_date"
                                class="form-input enhanced-input"
                                value="{{ old('end_date') }}" required>
                            <div class="input-glow"></div>
                            @error('end_date')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Financial Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-dollar-sign"></i>
                            Financial Information
                        </h4>
                        <p class="section-subtitle">Financial targets and currency settings</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="target_amount" class="form-label enhanced-label">
                                <i class="fas fa-bullseye"></i>
                                Target Amount
                            </label>
                            <div class="input-group enhanced-input-group">
                                <span class="input-prefix">₣</span>
                                <input type="number" id="target_amount" name="target_amount"
                                    class="form-input enhanced-input"
                                    value="{{ old('target_amount') }}"
                                    step="0.01" min="0"
                                    placeholder="Enter target amount">
                                <div class="input-glow"></div>
                            </div>
                            @error('target_amount')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="min_amount_per_person" class="form-label enhanced-label">
                                <i class="fas fa-user-plus"></i>
                                Minimum Amount Per Person
                            </label>
                            <div class="input-group enhanced-input-group">
                                <span class="input-prefix">₣</span>
                                <input type="number" id="min_amount_per_person" name="min_amount_per_person"
                                    class="form-input enhanced-input"
                                    value="{{ old('min_amount_per_person') }}"
                                    step="0.01" min="0"
                                    placeholder="Enter minimum amount">
                                <div class="input-glow"></div>
                            </div>
                            @error('min_amount_per_person')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="currency" class="form-label enhanced-label">
                                <i class="fas fa-money-bill-wave"></i>
                                Currency
                            </label>
                            <select id="currency" name="currency" class="form-select enhanced-select">
                                <option value="RWF" {{ old('currency') == 'RWF' ? 'selected' : '' }}>RWF (₣)</option>
                                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                <option value="CAD" {{ old('currency') == 'CAD' ? 'selected' : '' }}>CAD (C$)</option>
                                <option value="AUD" {{ old('currency') == 'AUD' ? 'selected' : '' }}>AUD (A$)</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('currency')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="status" class="form-label enhanced-label">
                                <i class="fas fa-toggle-on"></i>
                                Status *
                            </label>
                            <select id="status" name="status" class="form-select enhanced-select" required>
                                <option value="">Select Status</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('status')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="year_plan_id" class="form-label enhanced-label">
                            <i class="fas fa-calendar-alt"></i>
                            Associated Year Plan
                        </label>
                        <select id="year_plan_id" name="year_plan_id" class="form-select enhanced-select">
                            <option value="">No Year Plan</option>
                            @foreach($yearPlans as $plan)
                            <option value="{{ $plan->id }}" {{ old('year_plan_id') == $plan->id ? 'selected' : '' }}>
                                {{ $plan->title }} ({{ $plan->year }})
                            </option>
                            @endforeach
                        </select>
                        <div class="select-glow"></div>
                        @error('year_plan_id')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Description Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-align-left"></i>
                            Description & Notes
                        </h4>
                        <p class="section-subtitle">Additional information about the campaign</p>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="description" class="form-label enhanced-label">
                            <i class="fas fa-file-alt"></i>
                            Description
                        </label>
                        <textarea id="description" name="description"
                            class="form-textarea enhanced-textarea"
                            rows="4"
                            placeholder="Describe the purpose and goals of this campaign...">{{ old('description') }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('description')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="campaign_notes" class="form-label enhanced-label">
                            <i class="fas fa-sticky-note"></i>
                            Campaign Notes
                        </label>
                        <textarea id="campaign_notes" name="campaign_notes"
                            class="form-textarea enhanced-textarea"
                            rows="4"
                            placeholder="Any additional notes or internal comments about this campaign...">{{ old('campaign_notes') }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('campaign_notes')
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
                        <span>Create Campaign</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.contribution-campaigns.index') }}" class="btn btn-outline action-btn">
                        <i class="fas fa-times"></i>
                        <span>Cancel</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
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

        if (!isValid) {
            e.preventDefault();
            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'form-error enhanced-error';
            errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Please fill in all required fields.';
            document.querySelector('.enhanced-form').insertBefore(errorDiv, document.querySelector('.form-actions'));

            setTimeout(() => {
                errorDiv.remove();
            }, 5000);
        }
    });
</script>
@endpush

@endsection