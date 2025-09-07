@extends('layouts.admin')

@section('title', 'Trial Balance')
@section('page-title', 'Trial Balance')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-text">
            <h2 class="header-title">Trial Balance</h2>
            <p class="header-subtitle">Account balances as of {{ $asOfDate->format('F j, Y') }}</p>
        </div>
        <div class="header-actions">
            <div class="date-selector">
                <label for="as_of_date" class="date-label">As of Date:</label>
                <input type="date"
                    id="as_of_date"
                    name="as_of_date"
                    value="{{ $asOfDate->format('Y-m-d') }}"
                    class="date-input"
                    onchange="updateTrialBalance(this.value)">
            </div>
            @permission('export_financial_reports')
            <a href="{{ route('admin.financial-reports.export', 'trial-balance') }}?date={{ $asOfDate->format('Y-m-d') }}"
                class="btn btn-secondary">
                <i class="fas fa-download"></i>
                Export PDF
            </a>
            @endpermission
            <a href="{{ route('admin.financial-reports.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                Back to Reports
            </a>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="card-header">
        <h3>Trial Balance Report</h3>
        <div class="report-summary">
            <div class="summary-item">
                <span class="summary-label">Total Debits:</span>
                <span class="summary-value total-debits">${{ number_format($totalDebits, 2) }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Total Credits:</span>
                <span class="summary-value total-credits">${{ number_format($totalCredits, 2) }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Difference:</span>
                <span class="summary-value {{ $difference == 0 ? 'balanced' : 'unbalanced' }}">
                    ${{ number_format($difference, 2) }}
                </span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($difference == 0)
        <div class="balance-status balanced">
            <i class="fas fa-check-circle"></i>
            <span>Trial Balance is balanced ✓</span>
        </div>
        @else
        <div class="balance-status unbalanced">
            <i class="fas fa-exclamation-triangle"></i>
            <span>Trial Balance is unbalanced! Please review your accounts.</span>
        </div>
        @endif

        <div class="trial-balance-table">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Account Code</th>
                        <th>Account Name</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Debit Balance</th>
                        <th>Credit Balance</th>
                        <th>Net Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accounts as $account)
                    <tr class="account-row account-type-{{ $account->account_type }}">
                        <td data-label="Account Code">
                            <span class="account-code">{{ $account->account_code }}</span>
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
                        <td data-label="Debit Balance" class="amount-cell">
                            @if($account->debit_balance > 0)
                            <span class="debit-amount">${{ number_format($account->debit_balance, 2) }}</span>
                            @else
                            <span class="no-amount">-</span>
                            @endif
                        </td>
                        <td data-label="Credit Balance" class="amount-cell">
                            @if($account->credit_balance > 0)
                            <span class="credit-amount">${{ number_format($account->credit_balance, 2) }}</span>
                            @else
                            <span class="no-amount">-</span>
                            @endif
                        </td>
                        <td data-label="Net Balance" class="amount-cell">
                            <span class="net-amount {{ $account->net_balance >= 0 ? 'positive' : 'negative' }}">
                                ${{ number_format(abs($account->net_balance), 2) }}
                            </span>
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
    </div>
</div>



<script>
    function updateTrialBalance(date) {
        // Redirect to the same page with the new date
        window.location.href = '{{ route("admin.financial-reports.trial-balance") }}?date=' + date;
    }
</script>
@endsection