@extends('layouts.admin')

@section('title', 'Expenses')
@section('page-title', 'Expenses')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-text">
            <h2 class="header-title">Expense Management</h2>
            <p class="header-subtitle">Track and manage choir expenses and reimbursements</p>
        </div>
        <div class="header-actions">
            @permission('manage_expenses')
            <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Create New Expense
            </a>
            @endpermission
        </div>
    </div>
</div>

<div class="content-card">
    <div class="card-header">
        <h3>All Expenses</h3>
        <div class="filters">
            <form method="GET" class="filter-form">
                <div class="filter-row">
                    <div class="filter-group">
                        <label for="category_filter" class="filter-label">Category</label>
                        <select name="category_filter" id="category_filter" class="filter-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_filter') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="status_filter" class="filter-label">Status</label>
                        <select name="status_filter" id="status_filter" class="filter-select">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status_filter') == $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="search" class="filter-label">Search</label>
                        <input type="text" name="search" id="search"
                            value="{{ request('search') }}"
                            class="filter-input"
                            placeholder="Search expenses...">
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-filter"></i>
                            Filter
                        </button>
                        @if(request('category_filter') || request('status_filter') || request('search'))
                        <a href="{{ route('admin.expenses.index') }}" class="btn btn-secondary btn-sm">
                            Clear
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card-content">
        @if($expenses->count() > 0)
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Expense #</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Requested By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                    <tr>
                        <td data-label="Expense #">
                            <span class="expense-number">{{ $expense->expense_number }}</span>
                        </td>
                        <td data-label="Title">
                            <div class="expense-info">
                                <div class="expense-title">{{ $expense->title }}</div>
                                @if($expense->description)
                                <div class="expense-description">{{ Str::limit($expense->description, 50) }}</div>
                                @endif
                            </div>
                        </td>
                        <td data-label="Category">
                            <span class="category-badge">
                                {{ $expense->category->name }}
                            </span>
                        </td>
                        <td data-label="Amount">
                            <span class="amount-display">
                                ${{ number_format($expense->amount, 2) }}
                            </span>
                        </td>
                        <td data-label="Date">
                            <span class="date-display">
                                {{ $expense->expense_date->format('M j, Y') }}
                            </span>
                        </td>
                        <td data-label="Status">
                            <span class="status-badge status-{{ $expense->status }}">
                                {{ ucfirst(str_replace('_', ' ', $expense->status)) }}
                            </span>
                        </td>
                        <td data-label="Requested By">
                            <div class="requester-info">
                                <div class="requester-name">{{ $expense->requester->name }}</div>
                                <div class="requester-date">{{ $expense->created_at->format('M j, Y') }}</div>
                            </div>
                        </td>
                        <td data-label="Actions">
                            <div class="action-buttons">
                                <a href="{{ route('admin.expenses.show', $expense) }}"
                                    class="btn btn-sm btn-outline" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($expense->status === 'pending')
                                @permission('manage_expenses')
                                <form action="{{ route('admin.expenses.approve', $expense) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success" title="Approve Expense">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.expenses.reject', $expense) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Reject Expense">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                @endpermission
                                @endif

                                @if($expense->status === 'approved')
                                @permission('manage_expenses')
                                <form action="{{ route('admin.expenses.pay', $expense) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-info" title="Mark as Paid">
                                        <i class="fas fa-dollar-sign"></i>
                                    </button>
                                </form>
                                @endpermission
                                @endif

                                @if($expense->status === 'pending' && $expense->requester_id === auth()->id())
                                <a href="{{ route('admin.expenses.edit', $expense) }}"
                                    class="btn btn-sm btn-outline" title="Edit Expense">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif

                                @if($expense->status === 'pending' && $expense->requester_id === auth()->id())
                                <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this expense?')"
                                        title="Delete Expense">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-message">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <h3>No expenses found</h3>
                                <p>Get started by creating your first expense request.</p>
                                @permission('manage_expenses')
                                <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                    Create First Expense
                                </a>
                                @endpermission
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($expenses->hasPages())
        <div class="pagination-wrapper">
            {{ $expenses->links() }}
        </div>
        @endif
        @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-receipt"></i>
            </div>
            <h3>No expenses found</h3>
            <p>Get started by creating your first expense request.</p>
            @permission('manage_expenses')
            <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Create First Expense
            </a>
            @endpermission
        </div>
        @endif
    </div>
</div>


@endsection