@extends('layouts.admin')

@section('title', 'Edit Contribution')
@section('page-title', 'Edit Contribution')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-text">
            <h2 class="header-title">Edit Contribution</h2>
            <p class="header-subtitle">Update contribution details for campaign: {{ $contributionCampaign->name }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.contribution-campaigns.show', $contributionCampaign) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Campaign
            </a>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="card-content">
        <form method="POST" action="{{ route('admin.contribution-campaigns.update-contribution', ['contributionCampaign' => $contributionCampaign, 'contribution' => $contribution]) }}" class="contribution-form">
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

            <div class="form-grid">
                <div class="form-group">
                    <label for="member_id" class="form-label">Select Member</label>
                    <select id="member_id" name="member_id" class="form-select">
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

                <div class="form-group">
                    <label for="contributor_name" class="form-label">Contributor Name *</label>
                    <input type="text" id="contributor_name" name="contributor_name" class="form-input" value="{{ old('contributor_name', $contribution->contributor_name) }}" required>
                    @error('contributor_name')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contributor_email" class="form-label">Contributor Email</label>
                    <input type="email" id="contributor_email" name="contributor_email" class="form-input" value="{{ old('contributor_email', $contribution->contributor_email) }}">
                    @error('contributor_email')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contributor_phone" class="form-label">Contributor Phone</label>
                    <input type="text" id="contributor_phone" name="contributor_phone" class="form-input" value="{{ old('contributor_phone', $contribution->contributor_phone) }}">
                    @error('contributor_phone')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="amount" class="form-label">Amount *</label>
                    <div class="input-group">
                        <span class="input-prefix">₣</span>
                        <input type="number" id="amount" name="amount" class="form-input" value="{{ old('amount', $contribution->amount) }}" step="0.01" min="0.01" required>
                    </div>
                    @error('amount')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="currency" class="form-label">Currency</label>
                    <select id="currency" name="currency" class="form-select">
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

                <div class="form-group">
                    <label for="contribution_date" class="form-label">Contribution Date *</label>
                    <input type="date" id="contribution_date" name="contribution_date" class="form-input" value="{{ old('contribution_date', $contribution->contribution_date->format('Y-m-d')) }}" required>
                    @error('contribution_date')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="payment_method" class="form-label">Payment Method *</label>
                    <select id="payment_method" name="payment_method" class="form-select" required>
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

                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="">Select Status</option>
                        <option value="pending" {{ old('status', $contribution->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status', $contribution->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ old('status', $contribution->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="reference_number" class="form-label">Reference Number</label>
                    <input type="text" id="reference_number" name="reference_number" class="form-input" value="{{ old('reference_number', $contribution->reference_number) }}" placeholder="Transaction ID, check number, etc.">
                    @error('reference_number')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="notes" class="form-label">Notes</label>
                <textarea id="notes" name="notes" class="form-textarea" rows="4" placeholder="Any additional notes about this contribution...">{{ old('notes', $contribution->notes) }}</textarea>
                @error('notes')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Update Contribution
                </button>
                <a href="{{ route('admin.contribution-campaigns.show', $contributionCampaign) }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
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