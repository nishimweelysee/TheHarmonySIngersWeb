@extends('layouts.admin')

@section('title', 'Edit Account')
@section('page-title', 'Edit Account')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-text">
            <h2 class="header-title">Edit Account</h2>
            <p class="header-subtitle">Modify account information for {{ $account->account_name }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.chart-of-accounts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Accounts
            </a>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="card-header">
        <h3>Account Information</h3>
        <div class="account-meta">
            <span class="account-code">Code: {{ $account->account_code }}</span>
            <span class="account-type">Type: {{ ucfirst($account->account_type) }}</span>
        </div>
    </div>

    <div class="card-content">
        <form action="{{ route('admin.chart-of-accounts.update', $account) }}" method="POST" class="form">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label for="account_code" class="form-label">Account Code <span class="required">*</span></label>
                    <input type="text"
                        id="account_code"
                        name="account_code"
                        value="{{ old('account_code', $account->account_code) }}"
                        class="form-input @error('account_code') error @enderror"
                        placeholder="e.g., 1000, 2000, 3000"
                        {{ $account->is_system_account ? 'readonly' : '' }}
                        required>
                    @error('account_code')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Unique identifier for the account (e.g., 1000 for assets, 2000 for liabilities)</div>
                    @if($account->is_system_account)
                    <div class="form-help warning">System accounts cannot have their codes modified</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="account_name" class="form-label">Account Name <span class="required">*</span></label>
                    <input type="text"
                        id="account_name"
                        name="account_name"
                        value="{{ old('account_name', $account->account_name) }}"
                        class="form-input @error('account_name') error @enderror"
                        placeholder="e.g., Cash, Accounts Payable, Sales Revenue"
                        required>
                    @error('account_name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="account_type" class="form-label">Account Type <span class="required">*</span></label>
                    <select id="account_type"
                        name="account_type"
                        class="form-select @error('account_type') error @enderror"
                        {{ $account->is_system_account ? 'disabled' : '' }}
                        required>
                        <option value="">Select Account Type</option>
                        <option value="asset" {{ old('account_type', $account->account_type) === 'asset' ? 'selected' : '' }}>Asset</option>
                        <option value="liability" {{ old('account_type', $account->account_type) === 'liability' ? 'selected' : '' }}>Liability</option>
                        <option value="equity" {{ old('account_type', $account->account_type) === 'equity' ? 'selected' : '' }}>Equity</option>
                        <option value="revenue" {{ old('account_type', $account->account_type) === 'revenue' ? 'selected' : '' }}>Revenue</option>
                        <option value="expense" {{ old('account_type', $account->account_type) === 'expense' ? 'selected' : '' }}>Expense</option>
                    </select>
                    @error('account_type')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                    @if($account->is_system_account)
                    <div class="form-help warning">System accounts cannot have their types modified</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="account_category" class="form-label">Account Category <span class="required">*</span></label>
                    <select id="account_category"
                        name="account_category"
                        class="form-select @error('account_category') error @enderror"
                        {{ $account->is_system_account ? 'disabled' : '' }}
                        required>
                        <option value="">Select Category</option>
                        <option value="current_assets" {{ old('account_category', $account->account_category) === 'current_assets' ? 'selected' : '' }}>Current Assets</option>
                        <option value="fixed_assets" {{ old('account_category', $account->account_category) === 'fixed_assets' ? 'selected' : '' }}>Fixed Assets</option>
                        <option value="current_liabilities" {{ old('account_category', $account->account_category) === 'current_liabilities' ? 'selected' : '' }}>Current Liabilities</option>
                        <option value="long_term_liabilities" {{ old('account_category', $account->account_category) === 'long_term_liabilities' ? 'selected' : '' }}>Long-term Liabilities</option>
                        <option value="equity" {{ old('account_category', $account->account_category) === 'equity' ? 'selected' : '' }}>Equity</option>
                        <option value="operating_revenue" {{ old('account_category', $account->account_category) === 'operating_revenue' ? 'selected' : '' }}>Operating Revenue</option>
                        <option value="non_operating_revenue" {{ old('account_category', $account->account_category) === 'non_operating_revenue' ? 'selected' : '' }}>Non-operating Revenue</option>
                        <option value="operating_expenses" {{ old('account_category', $account->account_category) === 'operating_expenses' ? 'selected' : '' }}>Operating Expenses</option>
                        <option value="non_operating_expenses" {{ old('account_category', $account->account_category) === 'non_operating_expenses' ? 'selected' : '' }}>Non-operating Expenses</option>
                    </select>
                    @error('account_category')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                    @if($account->is_system_account)
                    <div class="form-help warning">System accounts cannot have their categories modified</div>
                    @endif
                </div>

                <div class="form-group form-group-full">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description"
                        name="description"
                        class="form-textarea @error('description') error @enderror"
                        placeholder="Optional description of the account's purpose"
                        rows="3">{{ old('description', $account->description) }}</textarea>
                    @error('description')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="is_active" class="form-label">Status</label>
                    <div class="checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox"
                                id="is_active"
                                name="is_active"
                                value="1"
                                {{ old('is_active', $account->is_active) ? 'checked' : '' }}
                                {{ $account->is_system_account ? 'disabled' : '' }}
                                class="checkbox-input">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-text">Active</span>
                        </label>
                    </div>
                    <div class="form-help">Active accounts can be used in transactions</div>
                    @if($account->is_system_account)
                    <div class="form-help warning">System accounts must remain active</div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label">Current Balance</label>
                    <div class="current-balance-display">
                        <span class="balance-amount {{ $account->current_balance >= 0 ? 'positive' : 'negative' }}">
                            {{ $account->formatted_balance }}
                        </span>
                        <div class="form-help">Current balance cannot be modified directly. Use journal entries to adjust balances.</div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" {{ $account->is_system_account ? 'disabled' : '' }}>
                    <i class="fas fa-save"></i>
                    Update Account
                </button>
                <a href="{{ route('admin.chart-of-accounts.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                @if(!$account->is_system_account)
                <form action="{{ route('admin.chart-of-accounts.destroy', $account) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this account? This action cannot be undone.')">
                        <i class="fas fa-trash"></i>
                        Delete Account
                    </button>
                </form>
                @endif
            </div>
        </form>
    </div>
</div>


@endsection