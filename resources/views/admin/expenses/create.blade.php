@extends('layouts.admin')

@section('title', 'Create Expense')
@section('page-title', 'Create Expense')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-text">
            <h2 class="header-title">Create New Expense</h2>
            <p class="header-subtitle">Submit a new expense request for approval</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.expenses.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Expenses
            </a>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="card-header">
        <h3>Expense Information</h3>
    </div>

    <div class="card-content">
        <form action="{{ route('admin.expenses.store') }}" method="POST" class="form" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="title" class="form-label">Expense Title <span class="required">*</span></label>
                    <input type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        class="form-input @error('title') error @enderror"
                        placeholder="e.g., Concert Venue Rental, Sheet Music Purchase"
                        required>
                    @error('title')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id" class="form-label">Category <span class="required">*</span></label>
                    <select id="category_id"
                        name="category_id"
                        class="form-select @error('category_id') error @enderror"
                        required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="amount" class="form-label">Amount <span class="required">*</span></label>
                    <div class="input-group">
                        <span class="input-prefix">$</span>
                        <input type="number"
                            id="amount"
                            name="amount"
                            value="{{ old('amount') }}"
                            class="form-input @error('amount') error @enderror"
                            step="0.01"
                            min="0.01"
                            placeholder="0.00"
                            required>
                    </div>
                    @error('amount')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="expense_date" class="form-label">Expense Date <span class="required">*</span></label>
                    <input type="date"
                        id="expense_date"
                        name="expense_date"
                        value="{{ old('expense_date', date('Y-m-d')) }}"
                        class="form-input @error('expense_date') error @enderror"
                        required>
                    @error('expense_date')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group form-group-full">
                    <label for="description" class="form-label">Description <span class="required">*</span></label>
                    <textarea id="description"
                        name="description"
                        class="form-textarea @error('description') error @enderror"
                        placeholder="Provide detailed description of the expense, including purpose and justification"
                        rows="4"
                        required>{{ old('description') }}</textarea>
                    @error('description')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Explain why this expense is necessary for the choir's operations</div>
                </div>

                <div class="form-group">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select id="payment_method"
                        name="payment_method"
                        class="form-select @error('payment_method') error @enderror">
                        <option value="">Select Payment Method</option>
                        <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="check" {{ old('payment_method') === 'check' ? 'selected' : '' }}>Check</option>
                        <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="credit_card" {{ old('payment_method') === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                        <option value="other" {{ old('payment_method') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('payment_method')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="vendor" class="form-label">Vendor/Supplier</label>
                    <input type="text"
                        id="vendor"
                        name="vendor"
                        value="{{ old('vendor') }}"
                        class="form-input @error('vendor') error @enderror"
                        placeholder="e.g., Music Store, Venue Name, etc.">
                    @error('vendor')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="receipt" class="form-label">Receipt/Invoice</label>
                    <input type="file"
                        id="receipt"
                        name="receipt"
                        class="form-file @error('receipt') error @enderror"
                        accept="image/*,.pdf,.doc,.docx">
                    @error('receipt')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Upload receipt, invoice, or supporting documentation (images, PDF, Word docs)</div>
                </div>

                <div class="form-group">
                    <label for="priority" class="form-label">Priority</label>
                    <select id="priority"
                        name="priority"
                        class="form-select @error('priority') error @enderror">
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                    @error('priority')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="expected_payment_date" class="form-label">Expected Payment Date</label>
                    <input type="date"
                        id="expected_payment_date"
                        name="expected_payment_date"
                        value="{{ old('expected_payment_date') }}"
                        class="form-input @error('expected_payment_date') error @enderror"
                        min="{{ date('Y-m-d') }}">
                    @error('expected_payment_date')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-help">When do you expect this expense to be paid?</div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i>
                    Submit Expense Request
                </button>
                <a href="{{ route('admin.expenses.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>


@endsection