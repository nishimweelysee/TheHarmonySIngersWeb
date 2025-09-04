@extends('layouts.admin')

@section('title', 'Edit Contribution')
@section('page-title', 'Edit Contribution')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header contribution-edit-header">
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
                <h2 class="header-title">Edit Contribution</h2>
                <p class="header-subtitle">Update contribution details for campaign: {{ $contributionCampaign->name }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-hand-holding-usd"></i>
                        </span>
                        <span class="stat-label">Edit Contribution</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-user-edit"></i>
                        </span>
                        <span class="stat-label">Update Donor</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-edit"></i>
                        </span>
                        <span class="stat-label">Modify Payment</span>
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

<!-- Enhanced Form Container -->
<div class="form-container enhanced-container">
    <div class="form-card enhanced-card">
        <div class="card-header enhanced-header">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Edit Contribution Details
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.contribution-campaigns.update-contribution', ['contributionCampaign' => $contributionCampaign, 'contribution' => $contribution]) }}" class="contribution-form enhanced-form">
                @csrf
                @method('PUT')

                @if($errors->any())
                <div class="error-alert">
                    <div class="error-header">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Please fix the following errors:</strong>
                    </div>
                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="form-grid enhanced-form-grid">
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
                        <small class="form-help">Choose an existing member to auto-fill details, or leave empty to enter new contributor information</small>
                    </div>

                    <div class="form-group enhanced-group">
                        <label for="contributor_name" class="form-label enhanced-label">
                            <i class="fas fa-user"></i>
                            Contributor Name *
                        </label>
                        <input type="text" id="contributor_name" name="contributor_name" class="form-input enhanced-input" value="{{ old('contributor_name', $contribution->contributor_name) }}" required>
                        @error('contributor_name')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group enhanced-group">
                        <label for="contributor_email" class="form-label enhanced-label">
                            <i class="fas fa-envelope"></i>
                            Contributor Email
                        </label>
                        <input type="email" id="contributor_email" name="contributor_email" class="form-input enhanced-input" value="{{ old('contributor_email', $contribution->contributor_email) }}">
                        @error('contributor_email')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group enhanced-group">
                        <label for="contributor_phone" class="form-label enhanced-label">
                            <i class="fas fa-phone"></i>
                            Contributor Phone
                        </label>
                        <input type="text" id="contributor_phone" name="contributor_phone" class="form-input enhanced-input" value="{{ old('contributor_phone', $contribution->contributor_phone) }}">
                        @error('contributor_phone')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group enhanced-group">
                        <label for="amount" class="form-label enhanced-label">
                            <i class="fas fa-dollar-sign"></i>
                            Amount *
                        </label>
                        <div class="input-group enhanced-input-group">
                            <span class="input-prefix enhanced-prefix">₣</span>
                            <input type="number" id="amount" name="amount" class="form-input enhanced-input" value="{{ old('amount', $contribution->amount) }}" step="0.01" min="0.01" required>
                        </div>
                        @error('amount')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group enhanced-group">
                        <label for="currency" class="form-label enhanced-label">
                            <i class="fas fa-coins"></i>
                            Currency
                        </label>
                        <select id="currency" name="currency" class="form-select enhanced-select">
                            <option value="RWF" {{ old('currency', $contribution->currency) == 'RWF' ? 'selected' : '' }}>RWF (₣)</option>
                            <option value="USD" {{ old('currency', $contribution->currency) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                            <option value="EUR" {{ old('currency', $contribution->currency) == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                            <option value="GBP" {{ old('currency', $contribution->currency) == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                            <option value="CAD" {{ old('currency', $contribution->currency) == 'CAD' ? 'selected' : '' }}>CAD (C$)</option>
                            <option value="AUD" {{ old('currency', $contribution->currency) == 'AUD' ? 'selected' : '' }}>AUD (A$)</option>
                        </select>
                        @error('currency')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group enhanced-group">
                        <label for="contribution_date" class="form-label enhanced-label">
                            <i class="fas fa-calendar-alt"></i>
                            Contribution Date *
                        </label>
                        <input type="date" id="contribution_date" name="contribution_date" class="form-input enhanced-input" value="{{ old('contribution_date', $contribution->contribution_date->format('Y-m-d')) }}" required>
                        @error('contribution_date')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group enhanced-group">
                        <label for="payment_method" class="form-label enhanced-label">
                            <i class="fas fa-credit-card"></i>
                            Payment Method *
                        </label>
                        <select id="payment_method" name="payment_method" class="form-select enhanced-select" required>
                            <option value="">Select Payment Method</option>
                            <option value="cash" {{ old('payment_method', $contribution->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank_transfer" {{ old('payment_method', $contribution->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="check" {{ old('payment_method', $contribution->payment_method) == 'check' ? 'selected' : '' }}>Check</option>
                            <option value="mobile_money" {{ old('payment_method', $contribution->payment_method) == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                            <option value="other" {{ old('payment_method', $contribution->payment_method) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('payment_method')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group enhanced-group">
                        <label for="status" class="form-label enhanced-label">
                            <i class="fas fa-info-circle"></i>
                            Status *
                        </label>
                        <select id="status" name="status" class="form-select enhanced-select" required>
                            <option value="">Select Status</option>
                            <option value="pending" {{ old('status', $contribution->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ old('status', $contribution->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ old('status', $contribution->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group enhanced-group">
                        <label for="reference_number" class="form-label enhanced-label">
                            <i class="fas fa-hashtag"></i>
                            Reference Number
                        </label>
                        <input type="text" id="reference_number" name="reference_number" class="form-input enhanced-input" value="{{ old('reference_number', $contribution->reference_number) }}" placeholder="Transaction ID, check number, etc.">
                        @error('reference_number')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group enhanced-group full-width">
                    <label for="notes" class="form-label enhanced-label">
                        <i class="fas fa-sticky-note"></i>
                        Notes
                    </label>
                    <textarea id="notes" name="notes" class="form-textarea enhanced-textarea" rows="4" placeholder="Any additional notes about this contribution...">{{ old('notes', $contribution->notes) }}</textarea>
                    @error('notes')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions enhanced-actions">
                    <button type="submit" class="btn btn-primary enhanced-btn">
                        <div class="btn-content">
                            <i class="fas fa-save"></i>
                            <span>Update Contribution</span>
                        </div>
                        <div class="btn-glow"></div>
                    </button>
                    <a href="{{ route('admin.contribution-campaigns.show', $contributionCampaign) }}" class="btn btn-secondary enhanced-btn">
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
</script>
@endsection