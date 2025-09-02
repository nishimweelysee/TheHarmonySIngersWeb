@extends('layouts.admin')

@section('title', 'Expense Details')
@section('page-title', 'Expense Details')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-text">
            <h2 class="header-title">Expense Details</h2>
            <p class="header-subtitle">View and manage expense information</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.expenses.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Expenses
            </a>
            @if($expense->status === 'pending' && $expense->requester_id === auth()->id())
            <a href="{{ route('admin.expenses.edit', $expense) }}" class="btn btn-outline">
                <i class="fas fa-edit"></i>
                Edit Expense
            </a>
            @endif
        </div>
    </div>
</div>

<div class="content-card">
    <div class="card-header">
        <h3>Expense #{{ $expense->expense_number }}</h3>
        <div class="expense-status">
            <span class="status-badge status-{{ $expense->status }}">
                {{ ucfirst(str_replace('_', ' ', $expense->status)) }}
            </span>
        </div>
    </div>

    <div class="card-content">
        <div class="expense-details">
            <div class="detail-section">
                <h4 class="section-title">Basic Information</h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label class="detail-label">Title</label>
                        <div class="detail-value">{{ $expense->title }}</div>
                    </div>
                    <div class="detail-item">
                        <label class="detail-label">Category</label>
                        <div class="detail-value">
                            <span class="category-badge">{{ $expense->category->name }}</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <label class="detail-label">Amount</label>
                        <div class="detail-value amount-display">
                            ${{ number_format($expense->amount, 2) }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <label class="detail-label">Expense Date</label>
                        <div class="detail-value">{{ $expense->expense_date->format('M j, Y') }}</div>
                    </div>
                    <div class="detail-item">
                        <label class="detail-label">Priority</label>
                        <div class="detail-value">
                            <span class="priority-badge priority-{{ $expense->priority ?? 'medium' }}">
                                {{ ucfirst($expense->priority ?? 'medium') }}
                            </span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <label class="detail-label">Payment Method</label>
                        <div class="detail-value">
                            {{ $expense->payment_method ? ucfirst(str_replace('_', ' ', $expense->payment_method)) : 'Not specified' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <h4 class="section-title">Description</h4>
                <div class="description-content">
                    {{ $expense->description }}
                </div>
            </div>

            <div class="detail-section">
                <h4 class="section-title">Additional Details</h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label class="detail-label">Vendor/Supplier</label>
                        <div class="detail-value">
                            {{ $expense->vendor ?: 'Not specified' }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <label class="detail-label">Expected Payment Date</label>
                        <div class="detail-value">
                            {{ $expense->expected_payment_date ? $expense->expected_payment_date->format('M j, Y') : 'Not specified' }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <label class="detail-label">Created By</label>
                        <div class="detail-value">{{ $expense->requester->name }}</div>
                    </div>
                    <div class="detail-item">
                        <label class="detail-label">Created Date</label>
                        <div class="detail-value">{{ $expense->created_at->format('M j, Y \a\t g:i A') }}</div>
                    </div>
                    @if($expense->updated_at != $expense->created_at)
                    <div class="detail-item">
                        <label class="detail-label">Last Updated</label>
                        <div class="detail-value">{{ $expense->updated_at->format('M j, Y \a\t g:i A') }}</div>
                    </div>
                    @endif
                </div>
            </div>

            @if($expense->receipt_path)
            <div class="detail-section">
                <h4 class="section-title">Receipt/Invoice</h4>
                <div class="receipt-display">
                    @if(in_array(pathinfo($expense->receipt_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                    <img src="{{ asset('storage/' . $expense->receipt_path) }}"
                        alt="Receipt"
                        class="receipt-image">
                    @else
                    <div class="receipt-file">
                        <i class="fas fa-file-alt"></i>
                        <span>{{ basename($expense->receipt_path) }}</span>
                        <a href="{{ asset('storage/' . $expense->receipt_path) }}"
                            target="_blank"
                            class="btn btn-sm btn-outline">
                            <i class="fas fa-download"></i>
                            Download
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @if($expense->notes)
            <div class="detail-section">
                <h4 class="section-title">Notes</h4>
                <div class="notes-content">
                    {{ $expense->notes }}
                </div>
            </div>
            @endif
        </div>

        @if($expense->status === 'pending')
        <div class="expense-actions">
            <h4 class="section-title">Actions</h4>
            <div class="action-buttons">
                @permission('manage_expenses')
                <form action="{{ route('admin.expenses.approve', $expense) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i>
                        Approve Expense
                    </button>
                </form>

                <form action="{{ route('admin.expenses.reject', $expense) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i>
                        Reject Expense
                    </button>
                </form>
                @endpermission
            </div>
        </div>
        @endif

        @if($expense->status === 'approved')
        <div class="expense-actions">
            <h4 class="section-title">Payment Actions</h4>
            <div class="action-buttons">
                @permission('manage_expenses')
                <form action="{{ route('admin.expenses.pay', $expense) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-dollar-sign"></i>
                        Mark as Paid
                    </button>
                </form>
                @endpermission
            </div>
        </div>
        @endif
    </div>
</div>


@endsection