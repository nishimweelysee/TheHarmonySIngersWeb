@extends('layouts.admin')

@section('title', 'Create Account')
@section('page-title', 'Create Account')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-text">
            <h2 class="header-title">Create New Account</h2>
            <p class="header-subtitle">Add a new account to the chart of accounts</p>
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
    </div>

    <div class="card-content">
        <form action="{{ route('admin.chart-of-accounts.store') }}" method="POST" class="form">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="account_code" class="form-label">Account Code <span class="required">*</span></label>
                    <input type="text"
                        id="account_code"
                        name="account_code"
                        value="{{ old('account_code') }}"
                        class="form-input @error('account_code') error @enderror"
                        placeholder="e.g., 1000, 2000, 3000"
                        required>
                    @error('account_code')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Unique identifier for the account (e.g., 1000 for assets, 2000 for liabilities)</div>
                </div>

                <div class="form-group">
                    <label for="account_name" class="form-label">Account Name <span class="required">*</span></label>
                    <input type="text"
                        id="account_name"
                        name="account_name"
                        value="{{ old('account_name') }}"
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
                        required>
                        <option value="">Select Account Type</option>
                        <option value="asset" {{ old('account_type') === 'asset' ? 'selected' : '' }}>Asset</option>
                        <option value="liability" {{ old('account_type') === 'liability' ? 'selected' : '' }}>Liability</option>
                        <option value="equity" {{ old('account_type') === 'equity' ? 'selected' : '' }}>Equity</option>
                        <option value="revenue" {{ old('account_type') === 'revenue' ? 'selected' : '' }}>Revenue</option>
                        <option value="expense" {{ old('account_type') === 'expense' ? 'selected' : '' }}>Expense</option>
                    </select>
                    @error('account_type')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="account_category" class="form-label">Account Category <span class="required">*</span></label>
                    <select id="account_category"
                        name="account_category"
                        class="form-select @error('account_category') error @enderror"
                        required>
                        <option value="">Select Category</option>
                        <option value="current_assets" {{ old('account_category') === 'current_assets' ? 'selected' : '' }}>Current Assets</option>
                        <option value="fixed_assets" {{ old('account_category') === 'fixed_assets' ? 'selected' : '' }}>Fixed Assets</option>
                        <option value="current_liabilities" {{ old('account_category') === 'current_liabilities' ? 'selected' : '' }}>Current Liabilities</option>
                        <option value="long_term_liabilities" {{ old('account_category') === 'long_term_liabilities' ? 'selected' : '' }}>Long-term Liabilities</option>
                        <option value="equity" {{ old('account_category') === 'equity' ? 'selected' : '' }}>Equity</option>
                        <option value="operating_revenue" {{ old('account_category') === 'operating_revenue' ? 'selected' : '' }}>Operating Revenue</option>
                        <option value="non_operating_revenue" {{ old('account_category') === 'non_operating_revenue' ? 'selected' : '' }}>Non-operating Revenue</option>
                        <option value="operating_expenses" {{ old('account_category') === 'operating_expenses' ? 'selected' : '' }}>Operating Expenses</option>
                        <option value="non_operating_expenses" {{ old('account_category') === 'non_operating_expenses' ? 'selected' : '' }}>Non-operating Expenses</option>
                    </select>
                    @error('account_category')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group form-group-full">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description"
                        name="description"
                        class="form-textarea @error('description') error @enderror"
                        placeholder="Optional description of the account's purpose"
                        rows="3">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="opening_balance" class="form-label">Opening Balance</label>
                    <div class="input-group">
                        <span class="input-prefix">$</span>
                        <input type="number"
                            id="opening_balance"
                            name="opening_balance"
                            value="{{ old('opening_balance', 0) }}"
                            class="form-input @error('opening_balance') error @enderror"
                            step="0.01"
                            min="0"
                            placeholder="0.00">
                    </div>
                    @error('opening_balance')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Initial balance when the account is created</div>
                </div>

                <div class="form-group">
                    <label for="is_active" class="form-label">Status</label>
                    <div class="checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox"
                                id="is_active"
                                name="is_active"
                                value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="checkbox-input">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-text">Active</span>
                        </label>
                    </div>
                    <div class="form-help">Active accounts can be used in transactions</div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Create Account
                </button>
                <a href="{{ route('admin.chart-of-accounts.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>


@endsection