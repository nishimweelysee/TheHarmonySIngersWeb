@extends('layouts.admin')

@section('title', 'Add Contribution')
@section('page-title', 'Add New Contribution')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-text">
            <h2 class="header-title">Add New Contribution</h2>
            <p class="header-subtitle">Record a new financial contribution or donation</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.contributions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Contributions
            </a>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="card-content">
        <form method="POST" action="{{ route('admin.contributions.store') }}" class="contribution-form">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="contributor_name" class="form-label">Contributor Name *</label>
                    <input type="text" id="contributor_name" name="contributor_name" class="form-input" value="{{ old('contributor_name') }}" required>
                    @error('contributor_name')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="amount" class="form-label">Amount *</label>
                    <div class="input-group">
                        <span class="input-prefix">₣</span>
                        <input type="number" id="amount" name="amount" class="form-input" value="{{ old('amount') }}" step="0.01" min="0" required>
                    </div>
                    @error('amount')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="currency" class="form-label">Currency</label>
                    <select id="currency" name="currency" class="form-select">
                        <option value="RWF" {{ old('currency', 'RWF') == 'RWF' ? 'selected' : '' }}>RWF (₣)</option>
                        <option value="USD" {{ old('currency', 'RWF') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                        <option value="EUR" {{ old('currency', 'RWF') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                        <option value="GBP" {{ old('currency', 'RWF') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                        <option value="CAD" {{ old('currency', 'RWF') == 'CAD' ? 'selected' : '' }}>CAD (C$)</option>
                        <option value="AUD" {{ old('currency', 'RWF') == 'AUD' ? 'selected' : '' }}>AUD (A$)</option>
                    </select>
                    @error('currency')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contribution_date" class="form-label">Contribution Date *</label>
                    <input type="date" id="contribution_date" name="contribution_date" class="form-input" value="{{ old('contribution_date', date('Y-m-d')) }}" required>
                    @error('contribution_date')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type" class="form-label">Type *</label>
                    <select id="type" name="type" class="form-select" required>
                        <option value="">Select Type</option>
                        <option value="monthly" {{ old('type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="project-based" {{ old('type') == 'project-based' ? 'selected' : '' }}>Project-Based</option>
                        <option value="donation" {{ old('type') == 'donation' ? 'selected' : '' }}>Donation</option>
                        <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event</option>
                        <option value="recording" {{ old('type') == 'recording' ? 'selected' : '' }}>Recording</option>
                    </select>
                    @error('type')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select id="payment_method" name="payment_method" class="form-select">
                        <option value="">Select Method</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Check</option>
                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online Payment</option>
                        <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('payment_method')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="">Select Status</option>
                        <option value="received" {{ old('status') == 'received' ? 'selected' : '' }}>Received</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="is_anonymous" class="form-label">Anonymous</label>
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }}>
                        <label for="is_anonymous" class="checkbox-label">Keep contributor anonymous</label>
                    </div>
                    @error('is_anonymous')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea id="notes" name="notes" class="form-textarea" rows="4" placeholder="Any additional notes about this contribution...">{{ old('notes') }}</textarea>
                    @error('notes')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Save Contribution
                </button>
                <a href="{{ route('admin.contributions.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>


@endsection