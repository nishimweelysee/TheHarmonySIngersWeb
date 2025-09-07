@extends('layouts.admin')

@section('title', 'Add Year Plan')
@section('page-title', 'Add New Year Plan')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header plan-create-header">
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
                <h2 class="header-title">Create New Year Plan</h2>
                <p class="header-subtitle">Plan the future of The Harmony Singers with strategic goals and objectives</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        <span class="stat-label">Year Planning</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-bullseye"></i>
                        </span>
                        <span class="stat-label">Set Goals</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-tasks"></i>
                        </span>
                        <span class="stat-label">Plan Activities</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.plans.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Year Plans</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Form Container -->
<div class="form-container enhanced-container">
    <div class="form-card enhanced-card">
        <div class="card-header enhanced-header">
            <h3 class="card-title">
                <i class="fas fa-plus-circle"></i>
                Create New Year Plan
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.plans.store') }}" class="plan-form enhanced-form">
                @csrf

                <div class="form-sections enhanced-form-sections">
                    <!-- Period Selection Section -->
                    <div class="form-section enhanced-section">
                        <div class="section-header enhanced-section-header">
                            <div class="section-icon">
                                <i class="fas fa-calendar-week"></i>
                            </div>
                            <h3 class="section-title">Period Configuration</h3>
                            <p class="section-description">Select the planning period and timeframe for your plan</p>
                        </div>
                        <div class="form-grid enhanced-form-grid">
                            <div class="form-group enhanced-group">
                                <label for="period_type" class="form-label enhanced-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    Period Type *
                                </label>
                                <select id="period_type" name="period_type" class="form-select enhanced-select" required>
                                    <option value="">Select Period Type</option>
                                    <option value="yearly" {{ old('period_type') == 'yearly' ? 'selected' : '' }}>Yearly
                                    </option>
                                    <option value="quarterly" {{ old('period_type') == 'quarterly' ? 'selected' : '' }}>
                                        Quarterly</option>
                                    <option value="monthly" {{ old('period_type') == 'monthly' ? 'selected' : '' }}>Monthly
                                    </option>
                                </select>
                                @error('period_type')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" id="yearly_period" style="display: none;">
                                <label for="year" class="form-label">
                                    <i class="fas fa-calendar-year"></i>
                                    Year *
                                </label>
                                <select id="year" name="year" class="form-select" required>
                                    <option value="">Select Year</option>
                                    @for($y = date('Y') - 5; $y <= date('Y') + 10; $y++) <option value="{{ $y }}"
                                        {{ old('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                </select>
                                @error('year')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" id="quarterly_period" style="display: none;">
                                <label for="quarter" class="form-label">
                                    <i class="fas fa-calendar-quarter"></i>
                                    Quarter
                                </label>
                                <select id="quarter" name="quarter" class="form-select">
                                    <option value="">Select Quarter</option>
                                    <option value="Q1" {{ old('quarter') == 'Q1' ? 'selected' : '' }}>Q1 (Jan-Mar)</option>
                                    <option value="Q2" {{ old('quarter') == 'Q2' ? 'selected' : '' }}>Q2 (Apr-Jun)</option>
                                    <option value="Q3" {{ old('quarter') == 'Q3' ? 'selected' : '' }}>Q3 (Jul-Sep)</option>
                                    <option value="Q4" {{ old('quarter') == 'Q4' ? 'selected' : '' }}>Q4 (Oct-Dec)</option>
                                </select>
                                @error('quarter')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" id="monthly_period" style="display: none;">
                                <label for="month" class="form-label">
                                    <i class="fas fa-calendar-month"></i>
                                    Month
                                </label>
                                <select id="month" name="month" class="form-select">
                                    <option value="">Select Month</option>
                                    <option value="01" {{ old('month') == '01' ? 'selected' : '' }}>January</option>
                                    <option value="02" {{ old('month') == '02' ? 'selected' : '' }}>February</option>
                                    <option value="03" {{ old('month') == '03' ? 'selected' : '' }}>March</option>
                                    <option value="04" {{ old('month') == '04' ? 'selected' : '' }}>April</option>
                                    <option value="05" {{ old('month') == '05' ? 'selected' : '' }}>May</option>
                                    <option value="06" {{ old('month') == '06' ? 'selected' : '' }}>June</option>
                                    <option value="07" {{ old('month') == '07' ? 'selected' : '' }}>July</option>
                                    <option value="08" {{ old('month') == '08' ? 'selected' : '' }}>August</option>
                                    <option value="09" {{ old('month') == '09' ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ old('month') == '10' ? 'selected' : '' }}>October</option>
                                    <option value="11" {{ old('month') == '11' ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ old('month') == '12' ? 'selected' : '' }}>December</option>
                                </select>
                                @error('month')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h3 class="section-title">Basic Information</h3>
                            <p class="section-description">Essential details about your plan</p>
                        </div>
                        <div class="form-grid">
                            <div class="form-group enhanced-group">
                                <label for="title" class="form-label enhanced-label">
                                    <i class="fas fa-heading"></i>
                                    Plan Title *
                                </label>
                                <input type="text" id="title" name="title" class="form-input enhanced-input" value="{{ old('title') }}"
                                    placeholder="e.g., 2024 Annual Performance Plan" required>
                                @error('title')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group enhanced-group">
                                <label for="status" class="form-label enhanced-label">
                                    <i class="fas fa-flag"></i>
                                    Status *
                                </label>
                                <select id="status" name="status" class="form-select enhanced-select" required>
                                    <option value="">Select Status</option>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="category" class="form-label">
                                    <i class="fas fa-tags"></i>
                                    Category
                                </label>
                                <select id="category" name="category" class="form-select">
                                    <option value="">Select Category</option>
                                    <option value="performance" {{ old('category') == 'performance' ? 'selected' : '' }}>
                                        Performance</option>
                                    <option value="training" {{ old('category') == 'training' ? 'selected' : '' }}>Training
                                    </option>
                                    <option value="workshop" {{ old('category') == 'workshop' ? 'selected' : '' }}>Workshop
                                    </option>
                                    <option value="fundraising" {{ old('category') == 'fundraising' ? 'selected' : '' }}>
                                        Fundraising</option>
                                    <option value="community" {{ old('category') == 'community' ? 'selected' : '' }}>Community
                                    </option>
                                    <option value="administration" {{ old('category') == 'administration' ? 'selected' : '' }}>
                                        Administration</option>
                                </select>
                                @error('category')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="estimated_budget" class="form-label">
                                    <i class="fas fa-coins"></i>
                                    Estimated Budget (RWF)
                                </label>
                                <div class="input-group">
                                    <span class="input-prefix">₣</span>
                                    <input type="number" id="estimated_budget" name="estimated_budget" class="form-input"
                                        value="{{ old('estimated_budget') }}" placeholder="0.00" min="0" step="0.01">
                                </div>
                                @error('estimated_budget')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3 class="section-title">Timeline</h3>
                            <p class="section-description">Set the start and end dates for your plan</p>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="start_date" class="form-label">
                                    <i class="fas fa-play"></i>
                                    Start Date *
                                </label>
                                <input type="date" id="start_date" name="start_date" class="form-input"
                                    value="{{ old('start_date') }}" required>
                                @error('start_date')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="end_date" class="form-label">
                                    <i class="fas fa-flag-checkered"></i>
                                    End Date *
                                </label>
                                <input type="date" id="end_date" name="end_date" class="form-input"
                                    value="{{ old('end_date') }}" required>
                                @error('end_date')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Content Sections -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h3 class="section-title">Plan Content</h3>
                            <p class="section-description">Detailed information about your plan</p>
                        </div>
                        <div class="form-grid">
                            <div class="form-group full-width enhanced-group">
                                <label for="description" class="form-label enhanced-label">
                                    <i class="fas fa-align-left"></i>
                                    Plan Description *
                                </label>
                                <textarea id="description" name="description" class="form-textarea enhanced-textarea" rows="4"
                                    placeholder="Brief description of the year's goals and objectives..."
                                    required>{{ old('description') }}</textarea>
                                @error('description')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group full-width">
                                <label for="objectives" class="form-label">
                                    <i class="fas fa-bullseye"></i>
                                    Goals & Objectives
                                </label>
                                <textarea id="objectives" name="objectives" class="form-textarea" rows="6"
                                    placeholder="List the main goals and objectives for this year...">{{ old('objectives') }}</textarea>
                                @error('objectives')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group full-width">
                                <label for="activities" class="form-label">
                                    <i class="fas fa-tasks"></i>
                                    Planned Activities
                                </label>
                                <textarea id="activities" name="activities" class="form-textarea" rows="6"
                                    placeholder="List the planned activities, events, and programs for this year...">{{ old('activities') }}</textarea>
                                @error('activities')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group full-width">
                                <label for="budget" class="form-label">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                    Budget Information
                                </label>
                                <textarea id="budget" name="budget" class="form-textarea" rows="4"
                                    placeholder="Budget details, funding sources, and financial projections...">{{ old('budget') }}</textarea>
                                @error('budget')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group full-width">
                                <label for="notes" class="form-label">
                                    <i class="fas fa-sticky-note"></i>
                                    Additional Notes
                                </label>
                                <textarea id="notes" name="notes" class="form-textarea" rows="3"
                                    placeholder="Any additional notes, considerations, or special instructions...">{{ old('notes') }}</textarea>
                                @error('notes')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions enhanced-actions">
                    <button type="submit" class="btn btn-primary enhanced-btn">
                        <div class="btn-content">
                            <i class="fas fa-save"></i>
                            <span>Create Year Plan</span>
                        </div>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary enhanced-btn">
                        <div class="btn-content">
                            <i class="fas fa-times"></i>
                            <span>Cancel</span>
                        </div>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const periodTypeSelect = document.getElementById('period_type');
        const yearlyPeriod = document.getElementById('yearly_period');
        const quarterlyPeriod = document.getElementById('quarterly_period');
        const monthlyPeriod = document.getElementById('monthly_period');
        const yearSelect = document.getElementById('year');
        const quarterSelect = document.getElementById('quarter');
        const monthSelect = document.getElementById('month');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        // Function to show/hide period fields based on selection
        function togglePeriodFields() {
            const selectedPeriod = periodTypeSelect.value;

            // Hide all period fields first
            yearlyPeriod.style.display = 'none';
            quarterlyPeriod.style.display = 'none';
            monthlyPeriod.style.display = 'none';

            // Show the selected period field
            if (selectedPeriod === 'yearly') {
                yearlyPeriod.style.display = 'block';
            } else if (selectedPeriod === 'quarterly') {
                quarterlyPeriod.style.display = 'block';
            } else if (selectedPeriod === 'monthly') {
                monthlyPeriod.style.display = 'block';
            }

            // Clear and auto-fill dates
            autoFillDates();
        }

        // Function to auto-fill start and end dates based on period selection
        function autoFillDates() {
            const selectedPeriod = periodTypeSelect.value;
            const selectedYear = yearSelect.value;
            const selectedQuarter = quarterSelect.value;
            const selectedMonth = monthSelect.value;

            if (!selectedPeriod || !selectedYear) return;

            let startDate, endDate;

            if (selectedPeriod === 'yearly') {
                // Yearly: Jan 1 to Dec 31
                startDate = `${selectedYear}-01-01`;
                endDate = `${selectedYear}-12-31`;
            } else if (selectedPeriod === 'quarterly' && selectedQuarter) {
                // Quarterly: Based on quarter selection
                const quarterMonths = {
                    'Q1': {
                        start: '01',
                        end: '03'
                    },
                    'Q2': {
                        start: '04',
                        end: '06'
                    },
                    'Q3': {
                        start: '07',
                        end: '09'
                    },
                    'Q4': {
                        start: '10',
                        end: '12'
                    }
                };

                const quarter = quarterMonths[selectedQuarter];
                startDate = `${selectedYear}-${quarter.start}-01`;

                // Calculate last day of the quarter
                const endMonth = parseInt(quarter.end);
                const lastDay = new Date(selectedYear, endMonth, 0).getDate();
                endDate = `${selectedYear}-${quarter.end}-${lastDay}`;
            } else if (selectedPeriod === 'monthly' && selectedMonth) {
                // Monthly: First day to last day of selected month
                startDate = `${selectedYear}-${selectedMonth}-01`;

                // Calculate last day of the month
                const lastDay = new Date(selectedYear, parseInt(selectedMonth), 0).getDate();
                endDate = `${selectedYear}-${selectedMonth}-${lastDay.toString().padStart(2, '0')}`;
            }

            if (startDate && endDate) {
                startDateInput.value = startDate;
                endDateInput.value = endDate;
            }
        }

        // Event listeners
        periodTypeSelect.addEventListener('change', togglePeriodFields);
        yearSelect.addEventListener('change', autoFillDates);
        quarterSelect.addEventListener('change', autoFillDates);
        monthSelect.addEventListener('change', autoFillDates);

        // Initialize on page load
        if (periodTypeSelect.value) {
            togglePeriodFields();
        }
    });
</script>


@endsection