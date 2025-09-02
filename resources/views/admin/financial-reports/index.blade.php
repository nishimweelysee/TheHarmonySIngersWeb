@extends('layouts.admin')

@section('title', 'Financial Reports')
@section('page-title', 'Financial Reports')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-text">
            <h2 class="header-title">Financial Reports</h2>
            <p class="header-subtitle">Generate and view comprehensive financial reports for The Harmony Singers</p>
        </div>
        <div class="header-actions">
            <div class="date-range-picker">
                <label for="report_period" class="picker-label">Report Period:</label>
                <select id="report_period" class="picker-select">
                    <option value="current_month">Current Month</option>
                    <option value="last_month">Last Month</option>
                    <option value="current_quarter">Current Quarter</option>
                    <option value="last_quarter">Last Quarter</option>
                    <option value="current_year">Current Year</option>
                    <option value="last_year">Last Year</option>
                    <option value="custom">Custom Range</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="reports-grid">
    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="card-icon income">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="card-content">
                <h3 class="card-title">Total Income</h3>
                <div class="card-value">${{ number_format($summary['total_income'] ?? 0, 2) }}</div>
                <div class="card-change positive">+{{ $summary['income_change'] ?? 0 }}% from last period</div>
            </div>
        </div>

        <div class="summary-card">
            <div class="card-icon expenses">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="card-content">
                <h3 class="card-title">Total Expenses</h3>
                <div class="card-value">${{ number_format($summary['total_expenses'] ?? 0, 2) }}</div>
                <div class="card-change negative">+{{ $summary['expense_change'] ?? 0 }}% from last period</div>
            </div>
        </div>

        <div class="summary-card">
            <div class="card-icon profit">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="card-content">
                <h3 class="card-title">Net Profit/Loss</h3>
                <div class="card-value {{ ($summary['net_profit'] ?? 0) >= 0 ? 'positive' : 'negative' }}">
                    ${{ number_format($summary['net_profit'] ?? 0, 2) }}
                </div>
                <div class="card-change {{ ($summary['profit_change'] ?? 0) >= 0 ? 'positive' : 'negative' }}">
                    {{ ($summary['profit_change'] ?? 0) >= 0 ? '+' : '' }}{{ $summary['profit_change'] ?? 0 }}% from last period
                </div>
            </div>
        </div>

        <div class="summary-card">
            <div class="card-icon balance">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="card-content">
                <h3 class="card-title">Cash Balance</h3>
                <div class="card-value">${{ number_format($summary['cash_balance'] ?? 0, 2) }}</div>
                <div class="card-change neutral">Current balance</div>
            </div>
        </div>
    </div>

    <!-- Report Types -->
    <div class="content-card">
        <div class="card-header">
            <h3>Available Reports</h3>
            <p>Select a report type to generate detailed financial information</p>
        </div>

        <div class="card-content">
            <div class="reports-list">
                <div class="report-item">
                    <div class="report-info">
                        <div class="report-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <div class="report-details">
                            <h4 class="report-title">Trial Balance</h4>
                            <p class="report-description">View all account balances to ensure debits equal credits</p>
                        </div>
                    </div>
                    <div class="report-actions">
                        <a href="{{ route('admin.financial-reports.trial-balance') }}" class="btn btn-outline">
                            <i class="fas fa-eye"></i>
                            View Report
                        </a>
                        @permission('export_financial_reports')
                        <a href="{{ route('admin.financial-reports.export', 'trial-balance') }}" class="btn btn-secondary">
                            <i class="fas fa-download"></i>
                            Export PDF
                        </a>
                        @endpermission
                    </div>
                </div>

                <div class="report-item">
                    <div class="report-info">
                        <div class="report-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="report-details">
                            <h4 class="report-title">Balance Sheet</h4>
                            <p class="report-description">Snapshot of assets, liabilities, and equity at a specific date</p>
                        </div>
                    </div>
                    <div class="report-actions">
                        <a href="{{ route('admin.financial-reports.balance-sheet') }}" class="btn btn-outline">
                            <i class="fas fa-eye"></i>
                            View Report
                        </a>
                        @permission('export_financial_reports')
                        <a href="{{ route('admin.financial-reports.export', 'balance-sheet') }}" class="btn btn-secondary">
                            <i class="fas fa-download"></i>
                            Export PDF
                        </a>
                        @endpermission
                    </div>
                </div>

                <div class="report-item">
                    <div class="report-info">
                        <div class="report-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="report-details">
                            <h4 class="report-title">Income Statement</h4>
                            <p class="report-description">Revenue, expenses, and resulting profit or loss for a period</p>
                        </div>
                    </div>
                    <div class="report-actions">
                        <a href="{{ route('admin.financial-reports.income-statement') }}" class="btn btn-outline">
                            <i class="fas fa-eye"></i>
                            View Report
                        </a>
                        @permission('export_financial_reports')
                        <a href="{{ route('admin.financial-reports.export', 'income-statement') }}" class="btn btn-secondary">
                            <i class="fas fa-download"></i>
                            Export PDF
                        </a>
                        @endpermission
                    </div>
                </div>

                <div class="report-item">
                    <div class="report-info">
                        <div class="report-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="report-details">
                            <h4 class="report-title">Cash Flow Statement</h4>
                            <p class="report-description">Track cash inflows and outflows from operating, investing, and financing activities</p>
                        </div>
                    </div>
                    <div class="report-actions">
                        <a href="{{ route('admin.financial-reports.cash-flow') }}" class="btn btn-outline">
                            <i class="fas fa-eye"></i>
                            View Report
                        </a>
                        @permission('export_financial_reports')
                        <a href="{{ route('admin.financial-reports.export', 'cash-flow') }}" class="btn btn-secondary">
                            <i class="fas fa-download"></i>
                            Export PDF
                        </a>
                        @endpermission
                    </div>
                </div>

                <div class="report-item">
                    <div class="report-info">
                        <div class="report-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="report-details">
                            <h4 class="report-title">General Ledger</h4>
                            <p class="report-description">Detailed view of all transactions for each account</p>
                        </div>
                    </div>
                    <div class="report-actions">
                        <a href="{{ route('admin.financial-reports.general-ledger') }}" class="btn btn-outline">
                            <i class="fas fa-eye"></i>
                            View Report
                        </a>
                        @permission('export_financial_reports')
                        <a href="{{ route('admin.financial-reports.export', 'general-ledger') }}" class="btn btn-secondary">
                            <i class="fas fa-download"></i>
                            Export PDF
                        </a>
                        @endpermission
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="content-card">
        <div class="card-header">
            <h3>Quick Actions</h3>
            <p>Common financial management tasks</p>
        </div>

        <div class="card-content">
            <div class="quick-actions">
                <a href="{{ route('admin.chart-of-accounts.index') }}" class="quick-action-card">
                    <div class="action-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4>Manage Accounts</h4>
                    <p>View and modify chart of accounts</p>
                </a>

                <a href="{{ route('admin.expenses.index') }}" class="quick-action-card">
                    <div class="action-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <h4>Manage Expenses</h4>
                    <p>Review and approve expense requests</p>
                </a>

                <a href="{{ route('admin.contributions.index') }}" class="quick-action-card">
                    <div class="action-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h4>View Contributions</h4>
                    <p>Track donations and contributions</p>
                </a>

                <a href="{{ route('admin.donations.index') }}" class="quick-action-card">
                    <div class="action-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <h4>View Donations</h4>
                    <p>Monitor individual donations</p>
                </a>
            </div>
        </div>
    </div>
</div>



<script>
    // Report period change handler
    document.getElementById('report_period').addEventListener('change', function(e) {
        const period = e.target.value;
        if (period === 'custom') {
            // TODO: Implement custom date range picker
            alert('Custom date range picker coming soon!');
        } else {
            // TODO: Update reports based on selected period
            console.log('Selected period:', period);
        }
    });
</script>
@endsection