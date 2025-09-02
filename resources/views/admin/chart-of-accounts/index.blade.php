@extends('layouts.admin')

@section('title', 'Chart of Accounts')
@section('page-title', 'Chart of Accounts')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-text">
            <h2 class="header-title">Chart of Accounts</h2>
            <p class="header-subtitle">Manage financial accounts and their classifications</p>
        </div>
        <div class="header-actions">
            @permission('manage_chart_of_accounts')
            <a href="{{ route('admin.chart-of-accounts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add New Account
            </a>
            @endpermission
        </div>
    </div>
</div>

<div class="content-card">
    <div class="card-header">
        <h3>All Accounts</h3>
        <div class="filters">
            <div class="search-box">
                <input type="text" id="search" placeholder="Search accounts..." class="search-input">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($accounts->count() > 0)
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Account Code</th>
                        <th>Account Name</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Current Balance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accounts as $account)
                    <tr>
                        <td data-label="Account Code">
                            <span class="font-mono font-medium">{{ $account->account_code }}</span>
                        </td>
                        <td data-label="Account Name">
                            <div class="account-info">
                                <div class="account-name">{{ $account->account_name }}</div>
                                @if($account->description)
                                <div class="account-description">{{ Str::limit($account->description, 50) }}</div>
                                @endif
                            </div>
                        </td>
                        <td data-label="Type">
                            <span class="type-badge type-{{ $account->account_type }}">
                                {{ ucfirst($account->account_type) }}
                            </span>
                        </td>
                        <td data-label="Category">
                            <span class="category-badge">
                                {{ str_replace('_', ' ', ucfirst($account->account_category)) }}
                            </span>
                        </td>
                        <td data-label="Current Balance">
                            <span class="balance-amount {{ $account->current_balance >= 0 ? 'positive' : 'negative' }}">
                                {{ $account->formatted_balance }}
                            </span>
                        </td>
                        <td data-label="Status">
                            <span class="status-badge {{ $account->is_active ? 'active' : 'inactive' }}">
                                {{ $account->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td data-label="Actions">
                            <div class="action-buttons">
                                <a href="{{ route('admin.chart-of-accounts.edit', $account) }}"
                                    class="btn btn-sm btn-outline" title="Edit Account">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if(!$account->is_system_account)
                                <form action="{{ route('admin.chart-of-accounts.toggle-status', $account) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="btn btn-sm {{ $account->is_active ? 'btn-warning' : 'btn-success' }}"
                                        title="{{ $account->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-{{ $account->is_active ? 'pause' : 'play' }}"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.chart-of-accounts.destroy', $account) }}"
                                    method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this account? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete Account">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                <span class="system-account-badge" title="System accounts cannot be modified">
                                    <i class="fas fa-shield-alt"></i>
                                    System
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($accounts->hasPages())
        <div class="pagination-wrapper">
            {{ $accounts->links() }}
        </div>
        @endif
        @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <h3>No accounts found</h3>
            <p>Get started by creating your first chart of account.</p>
            @permission('manage_chart_of_accounts')
            <a href="{{ route('admin.chart-of-accounts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Create First Account
            </a>
            @endpermission
        </div>
        @endif
    </div>
</div>



<script>
    // Simple search functionality
    document.getElementById('search').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>
@endsection