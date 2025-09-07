@extends('layouts.admin')

@section('title', 'Edit Year Plan')
@section('page-title', 'Edit Year Plan')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header plan-edit-header">
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
                <h2 class="header-title">Edit Year Plan Profile</h2>
                <p class="header-subtitle">Update information for {{ $plan->title }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">#{{ $plan->id }}</span>
                        <span class="stat-label">Plan ID</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $plan->year }}</span>
                        <span class="stat-label">Year</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ ucfirst(str_replace('_', ' ', $plan->status)) }}</span>
                        <span class="stat-label">Current Status</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.plans.show', $plan) }}" class="btn btn-info enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-eye"></i>
                    <span>View Plan</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            <a href="{{ route('admin.plans.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Plans</span>
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
                Plan Update Form
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

        <form method="POST" action="{{ route('admin.plans.update', $plan) }}" class="plan-form enhanced-form">
            @csrf
            @method('PUT')

            <div class="enhanced-form-grid">
                <!-- Basic Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Basic Information
                        </h4>
                        <p class="section-subtitle">Plan title, description, and category</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="title" class="form-label enhanced-label">
                                <i class="fas fa-calendar-alt"></i>
                                Plan Title *
                            </label>
                            <input type="text" id="title" name="title"
                                class="form-input enhanced-input"
                                value="{{ old('title', $plan->title) }}"
                                placeholder="Enter plan title" required>
                            <div class="input-glow"></div>
                            @error('title')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="category" class="form-label enhanced-label">
                                <i class="fas fa-tags"></i>
                                Category
                            </label>
                            <select id="category" name="category" class="form-select enhanced-select">
                                <option value="">Select Category</option>
                                <option value="performance" {{ old('category', $plan->category) == 'performance' ? 'selected' : '' }}>Performance</option>
                                <option value="training" {{ old('category', $plan->category) == 'training' ? 'selected' : '' }}>Training</option>
                                <option value="workshop" {{ old('category', $plan->category) == 'workshop' ? 'selected' : '' }}>Workshop</option>
                                <option value="fundraising" {{ old('category', $plan->category) == 'fundraising' ? 'selected' : '' }}>Fundraising</option>
                                <option value="community" {{ old('category', $plan->category) == 'community' ? 'selected' : '' }}>Community</option>
                                <option value="administration" {{ old('category', $plan->category) == 'administration' ? 'selected' : '' }}>Administration</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('category')
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
                            rows="4"
                            placeholder="Enter plan description">{{ old('description', $plan->description) }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('description')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Period Configuration Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-calendar-week"></i>
                            Period Configuration
                        </h4>
                        <p class="section-subtitle">Select the planning period and timeframe</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="period_type" class="form-label enhanced-label">
                                <i class="fas fa-calendar-alt"></i>
                                Period Type *
                            </label>
                            <select id="period_type" name="period_type" class="form-select enhanced-select" required>
                                <option value="">Select Period Type</option>
                                <option value="yearly" {{ old('period_type', $plan->period_type) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                <option value="quarterly" {{ old('period_type', $plan->period_type) == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                <option value="monthly" {{ old('period_type', $plan->period_type) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('period_type')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="year" class="form-label enhanced-label">
                                <i class="fas fa-calendar"></i>
                                Year *
                            </label>
                            <select id="year" name="year" class="form-select enhanced-select" required>
                                <option value="">Select Year</option>
                                @for($y = date('Y') - 5; $y <= date('Y') + 10; $y++)
                                    <option value="{{ $y }}" {{ old('year', $plan->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                            </select>
                            <div class="select-glow"></div>
                            @error('year')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group" id="quarterly_period" style="display: none;">
                            <label for="quarter" class="form-label enhanced-label">
                                <i class="fas fa-chart-pie"></i>
                                Quarter
                            </label>
                            <select id="quarter" name="quarter" class="form-select enhanced-select">
                                <option value="">Select Quarter</option>
                                <option value="Q1" {{ old('quarter', $plan->quarter) == 'Q1' ? 'selected' : '' }}>Q1 (Jan-Mar)</option>
                                <option value="Q2" {{ old('quarter', $plan->quarter) == 'Q2' ? 'selected' : '' }}>Q2 (Apr-Jun)</option>
                                <option value="Q3" {{ old('quarter', $plan->quarter) == 'Q3' ? 'selected' : '' }}>Q3 (Jul-Sep)</option>
                                <option value="Q4" {{ old('quarter', $plan->quarter) == 'Q4' ? 'selected' : '' }}>Q4 (Oct-Dec)</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('quarter')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group" id="monthly_period" style="display: none;">
                            <label for="month" class="form-label enhanced-label">
                                <i class="fas fa-calendar-day"></i>
                                Month
                            </label>
                            <select id="month" name="month" class="form-select enhanced-select">
                                <option value="">Select Month</option>
                                <option value="01" {{ old('month', $plan->month) == '01' ? 'selected' : '' }}>January</option>
                                <option value="02" {{ old('month', $plan->month) == '02' ? 'selected' : '' }}>February</option>
                                <option value="03" {{ old('month', $plan->month) == '03' ? 'selected' : '' }}>March</option>
                                <option value="04" {{ old('month', $plan->month) == '04' ? 'selected' : '' }}>April</option>
                                <option value="05" {{ old('month', $plan->month) == '05' ? 'selected' : '' }}>May</option>
                                <option value="06" {{ old('month', $plan->month) == '06' ? 'selected' : '' }}>June</option>
                                <option value="07" {{ old('month', $plan->month) == '07' ? 'selected' : '' }}>July</option>
                                <option value="08" {{ old('month', $plan->month) == '08' ? 'selected' : '' }}>August</option>
                                <option value="09" {{ old('month', $plan->month) == '09' ? 'selected' : '' }}>September</option>
                                <option value="10" {{ old('month', $plan->month) == '10' ? 'selected' : '' }}>October</option>
                                <option value="11" {{ old('month', $plan->month) == '11' ? 'selected' : '' }}>November</option>
                                <option value="12" {{ old('month', $plan->month) == '12' ? 'selected' : '' }}>December</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('month')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Timeline Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-clock"></i>
                            Timeline
                        </h4>
                        <p class="section-subtitle">Set start and end dates for the plan</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="start_date" class="form-label enhanced-label">
                                <i class="fas fa-play"></i>
                                Start Date *
                            </label>
                            <input type="date" id="start_date" name="start_date"
                                class="form-input enhanced-input"
                                value="{{ old('start_date', $plan->start_date->format('Y-m-d')) }}" required>
                            <div class="input-glow"></div>
                            @error('start_date')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="end_date" class="form-label enhanced-label">
                                <i class="fas fa-flag-checkered"></i>
                                End Date *
                            </label>
                            <input type="date" id="end_date" name="end_date"
                                class="form-input enhanced-input"
                                value="{{ old('end_date', $plan->end_date->format('Y-m-d')) }}" required>
                            <div class="input-glow"></div>
                            @error('end_date')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status and Budget Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-cogs"></i>
                            Status & Budget
                        </h4>
                        <p class="section-subtitle">Plan status and financial information</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="status" class="form-label enhanced-label">
                                <i class="fas fa-toggle-on"></i>
                                Status *
                            </label>
                            <select id="status" name="status" class="form-select enhanced-select" required>
                                <option value="">Select Status</option>
                                <option value="draft" {{ old('status', $plan->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ old('status', $plan->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ old('status', $plan->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $plan->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('status')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="estimated_budget" class="form-label enhanced-label">
                                <i class="fas fa-dollar-sign"></i>
                                Estimated Budget
                            </label>
                            <div class="enhanced-input-group">
                                <span class="input-prefix">$</span>
                                <input type="number" id="estimated_budget" name="estimated_budget"
                                    class="form-input enhanced-input"
                                    value="{{ old('estimated_budget', $plan->estimated_budget) }}"
                                    placeholder="0.00"
                                    step="0.01"
                                    min="0">
                                <div class="input-glow"></div>
                            </div>
                            @error('estimated_budget')
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
                            placeholder="Additional notes about the plan">{{ old('notes', $plan->notes) }}</textarea>
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
                        <span>Update Plan</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.plans.show', $plan) }}" class="btn btn-secondary action-btn">
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
    // Period type change handler
    document.getElementById('period_type').addEventListener('change', function() {
        const quarterlyPeriod = document.getElementById('quarterly_period');
        const monthlyPeriod = document.getElementById('monthly_period');

        // Hide all period-specific fields
        quarterlyPeriod.style.display = 'none';
        monthlyPeriod.style.display = 'none';

        // Show relevant field based on selection
        if (this.value === 'quarterly') {
            quarterlyPeriod.style.display = 'block';
        } else if (this.value === 'monthly') {
            monthlyPeriod.style.display = 'block';
        }
    });

    // Initialize period fields on page load
    document.addEventListener('DOMContentLoaded', function() {
        const periodType = document.getElementById('period_type');
        if (periodType.value) {
            periodType.dispatchEvent(new Event('change'));
        }
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

        // Validate dates
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        if (startDate.value && endDate.value && startDate.value > endDate.value) {
            endDate.classList.add('error');
            isValid = false;
        }

        // Validate budget if provided
        const budgetField = document.getElementById('estimated_budget');
        if (budgetField.value && parseFloat(budgetField.value) < 0) {
            budgetField.classList.add('error');
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
@endpush