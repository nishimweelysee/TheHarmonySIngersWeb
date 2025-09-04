@extends('layouts.admin')

@section('title', 'Add Contribution')
@section('page-title', 'Add Contribution')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header contribution-add-header">
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
                <h2 class="header-title">Add Contribution</h2>
                <p class="header-subtitle">Add a new contribution to campaign: {{ $contributionCampaign->name }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-hand-holding-usd"></i>
                        </span>
                        <span class="stat-label">New Contribution</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-user-plus"></i>
                        </span>
                        <span class="stat-label">Add Donor</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="stat-label">Record Payment</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.contribution-campaigns.show', $contributionCampaign) }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Campaign</span>
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
                <i class="fas fa-plus-circle"></i>
                Contribution Details
            </h3>
            <div class="header-badge">
                <span class="badge-dot"></span>
                Required Fields
            </div>
        </div>
    </div>

    <div class="card-content">
        <form method="POST" action="{{ route('admin.contribution-campaigns.store-contribution', $contributionCampaign) }}" class="contribution-form enhanced-form">
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
                <!-- Contributor Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-user"></i>
                            Contributor Information
                        </h4>
                        <p class="section-subtitle">Details about the person making the contribution</p>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="member_id" class="form-label enhanced-label">
                            <i class="fas fa-users"></i>
                            Select Member
                        </label>
                        <select id="member_id" name="member_id" class="form-select enhanced-select">
                            <option value="">Select a member or leave empty for new contributor</option>
                            @foreach($members as $member)
                            <option value="{{ $member->id }}" data-name="{{ $member->first_name }} {{ $member->last_name }}" data-email="{{ $member->email }}" data-phone="{{ $member->phone }}">
                                {{ $member->first_name }} {{ $member->last_name }}
                                @if($member->email) - {{ $member->email }}@endif
                                @if($member->phone) ({{ $member->phone }})@endif
                            </option>
                            @endforeach
                        </select>
                        <div class="select-glow"></div>
                        <small class="form-help enhanced-help">Choose an existing member to auto-fill details, or leave empty to enter new contributor information</small>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="contributor_name" class="form-label enhanced-label">
                                <i class="fas fa-user"></i>
                                Contributor Name *
                            </label>
                            <input type="text" id="contributor_name" name="contributor_name"
                                class="form-input enhanced-input"
                                value="{{ old('contributor_name') }}"
                                placeholder="Enter contributor name" required>
                            <div class="input-glow"></div>
                            @error('contributor_name')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="contributor_email" class="form-label enhanced-label">
                                <i class="fas fa-envelope"></i>
                                Contributor Email
                            </label>
                            <input type="email" id="contributor_email" name="contributor_email"
                                class="form-input enhanced-input"
                                value="{{ old('contributor_email') }}"
                                placeholder="Enter email address">
                            <div class="input-glow"></div>
                            @error('contributor_email')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="contributor_phone" class="form-label enhanced-label">
                            <i class="fas fa-phone"></i>
                            Contributor Phone
                        </label>
                        <input type="text" id="contributor_phone" name="contributor_phone"
                            class="form-input enhanced-input"
                            value="{{ old('contributor_phone') }}"
                            placeholder="Enter phone number">
                        <div class="input-glow"></div>
                        @error('contributor_phone')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Payment Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-credit-card"></i>
                            Payment Information
                        </h4>
                        <p class="section-subtitle">Contribution amount and payment details</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="amount" class="form-label enhanced-label">
                                <i class="fas fa-dollar-sign"></i>
                                Amount *
                            </label>
                            <div class="input-group enhanced-input-group">
                                <span class="input-prefix">₣</span>
                                <input type="number" id="amount" name="amount"
                                    class="form-input enhanced-input"
                                    value="{{ old('amount') }}"
                                    step="0.01" min="0.01"
                                    placeholder="Enter amount" required>
                                <div class="input-glow"></div>
                            </div>
                            @error('amount')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="currency" class="form-label enhanced-label">
                                <i class="fas fa-money-bill-wave"></i>
                                Currency
                            </label>
                            <select id="currency" name="currency" class="form-select enhanced-select">
                                <option value="RWF" {{ old('currency', 'RWF') == 'RWF' ? 'selected' : '' }}>RWF (₣)</option>
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
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="contribution_date" class="form-label enhanced-label">
                                <i class="fas fa-calendar-alt"></i>
                                Contribution Date *
                            </label>
                            <input type="date" id="contribution_date" name="contribution_date"
                                class="form-input enhanced-input"
                                value="{{ old('contribution_date', now()->format('Y-m-d')) }}" required>
                            <div class="input-glow"></div>
                            @error('contribution_date')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="payment_method" class="form-label enhanced-label">
                                <i class="fas fa-credit-card"></i>
                                Payment Method *
                            </label>
                            <select id="payment_method" name="payment_method" class="form-select enhanced-select" required>
                                <option value="">Select Payment Method</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Check</option>
                                <option value="mobile_money" {{ old('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('payment_method')
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
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('status')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="reference_number" class="form-label enhanced-label">
                                <i class="fas fa-hashtag"></i>
                                Reference Number
                            </label>
                            <input type="text" id="reference_number" name="reference_number"
                                class="form-input enhanced-input"
                                value="{{ old('reference_number') }}"
                                placeholder="Transaction ID, check number, etc.">
                            <div class="input-glow"></div>
                            @error('reference_number')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-sticky-note"></i>
                            Additional Information
                        </h4>
                        <p class="section-subtitle">Any additional notes or comments</p>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="notes" class="form-label enhanced-label">
                            <i class="fas fa-align-left"></i>
                            Notes
                        </label>
                        <textarea id="notes" name="notes"
                            class="form-textarea enhanced-textarea"
                            rows="4"
                            placeholder="Any additional notes about this contribution...">{{ old('notes') }}</textarea>
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
                        <i class="fas fa-plus"></i>
                        <span>Add Contribution</span>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.contribution-campaigns.show', $contributionCampaign) }}" class="btn btn-outline action-btn">
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
    // Member auto-fill functionality
    document.addEventListener('DOMContentLoaded', function() {
        const memberSelect = document.getElementById('member_id');
        const contributorName = document.getElementById('contributor_name');
        const contributorEmail = document.getElementById('contributor_email');
        const contributorPhone = document.getElementById('contributor_phone');

        memberSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];

            if (this.value) {
                // Member selected - auto-fill the form
                contributorName.value = selectedOption.dataset.name;
                contributorName.readOnly = true;
                contributorEmail.value = selectedOption.dataset.email || '';
                contributorEmail.readOnly = true;
                contributorPhone.value = selectedOption.dataset.phone || '';
                contributorPhone.readOnly = true;
            } else {
                // No member selected - allow manual input
                contributorName.value = '';
                contributorName.readOnly = false;
                contributorEmail.value = '';
                contributorEmail.readOnly = false;
                contributorPhone.value = '';
                contributorPhone.readOnly = false;
            }
        });
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