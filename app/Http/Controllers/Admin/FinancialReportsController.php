<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AccountingService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FinancialReportsController extends Controller
{
    protected $accountingService;

    public function __construct(AccountingService $accountingService)
    {
        $this->accountingService = $accountingService;
    }

    public function index()
    {
        $currentYear = now()->year;
        $years = range($currentYear - 5, $currentYear + 1);

        return view('admin.financial-reports.index', compact('years', 'currentYear'));
    }

    public function trialBalance(Request $request)
    {
        $date = $request->get('date') ? Carbon::parse($request->get('date')) : now();

        $trialBalance = $this->accountingService->generateTrialBalance($date);

        $totalDebits = collect($trialBalance)->sum('debits');
        $totalCredits = collect($trialBalance)->sum('credits');

        return view('admin.financial-reports.trial-balance', compact('trialBalance', 'date', 'totalDebits', 'totalCredits'));
    }

    public function balanceSheet(Request $request)
    {
        $date = $request->get('date') ? Carbon::parse($request->get('date')) : now();

        $balanceSheet = $this->accountingService->generateBalanceSheet($date);

        return view('admin.financial-reports.balance-sheet', compact('balanceSheet', 'date'));
    }

    public function incomeStatement(Request $request)
    {
        $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : now()->startOfYear();
        $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : now()->endOfYear();

        $incomeStatement = $this->accountingService->generateIncomeStatement($startDate, $endDate);

        return view('admin.financial-reports.income-statement', compact('incomeStatement', 'startDate', 'endDate'));
    }

    public function cashFlow(Request $request)
    {
        $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : now()->startOfYear();
        $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : now()->endOfYear();

        // Get cash account transactions
        $cashAccount = \App\Models\ChartOfAccount::where('account_code', '1000')->first();

        $cashTransactions = \App\Models\JournalEntryLine::where('account_id', $cashAccount->id)
            ->whereHas('journalEntry', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('entry_date', [$startDate, $endDate])
                    ->where('status', 'posted');
            })
            ->with(['journalEntry', 'account'])
            ->orderBy('created_at')
            ->get();

        $openingBalance = $cashAccount->opening_balance;
        $closingBalance = $openingBalance;

        $cashFlow = [];
        foreach ($cashTransactions as $transaction) {
            if ($transaction->entry_type === 'debit') {
                $closingBalance += $transaction->amount;
                $cashFlow[] = [
                    'date' => $transaction->journalEntry->entry_date,
                    'description' => $transaction->journalEntry->description,
                    'type' => 'inflow',
                    'amount' => $transaction->amount,
                    'balance' => $closingBalance
                ];
            } else {
                $closingBalance -= $transaction->amount;
                $cashFlow[] = [
                    'date' => $transaction->journalEntry->entry_date,
                    'description' => $transaction->journalEntry->description,
                    'type' => 'outflow',
                    'amount' => $transaction->amount,
                    'balance' => $closingBalance
                ];
            }
        }

        $totalInflow = collect($cashFlow)->where('type', 'inflow')->sum('amount');
        $totalOutflow = collect($cashFlow)->where('type', 'outflow')->sum('amount');
        $netCashFlow = $totalInflow - $totalOutflow;

        return view('admin.financial-reports.cash-flow', compact(
            'cashFlow',
            'startDate',
            'endDate',
            'openingBalance',
            'closingBalance',
            'totalInflow',
            'totalOutflow',
            'netCashFlow'
        ));
    }

    public function generalLedger(Request $request)
    {
        $accountId = $request->get('account_id');
        $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : now()->startOfYear();
        $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : now()->endOfYear();

        $accounts = \App\Models\ChartOfAccount::active()->orderBy('account_code')->get();

        if ($accountId) {
            $account = \App\Models\ChartOfAccount::findOrFail($accountId);

            $transactions = \App\Models\JournalEntryLine::where('account_id', $accountId)
                ->whereHas('journalEntry', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('entry_date', [$startDate, $endDate])
                        ->where('status', 'posted');
                })
                ->with(['journalEntry'])
                ->orderBy('created_at')
                ->get();

            $openingBalance = $account->opening_balance;
            $runningBalance = $openingBalance;

            $ledgerEntries = [];
            foreach ($transactions as $transaction) {
                if (in_array($account->account_type, ['asset', 'expense'])) {
                    if ($transaction->entry_type === 'debit') {
                        $runningBalance += $transaction->amount;
                    } else {
                        $runningBalance -= $transaction->amount;
                    }
                } else {
                    if ($transaction->entry_type === 'credit') {
                        $runningBalance += $transaction->amount;
                    } else {
                        $runningBalance -= $transaction->amount;
                    }
                }

                $ledgerEntries[] = [
                    'date' => $transaction->journalEntry->entry_date,
                    'entry_number' => $transaction->journalEntry->entry_number,
                    'description' => $transaction->journalEntry->description,
                    'debit' => $transaction->entry_type === 'debit' ? $transaction->amount : 0,
                    'credit' => $transaction->entry_type === 'credit' ? $transaction->amount : 0,
                    'balance' => $runningBalance
                ];
            }

            return view('admin.financial-reports.general-ledger', compact(
                'accounts',
                'account',
                'ledgerEntries',
                'startDate',
                'endDate',
                'openingBalance',
                'runningBalance'
            ));
        }

        return view('admin.financial-reports.general-ledger', compact('accounts', 'startDate', 'endDate'));
    }

    public function export(Request $request, $reportType)
    {
        switch ($reportType) {
            case 'trial-balance':
                return $this->exportTrialBalance($request);
            case 'balance-sheet':
                return $this->exportBalanceSheet($request);
            case 'income-statement':
                return $this->exportIncomeStatement($request);
            case 'cash-flow':
                return $this->exportCashFlow($request);
            case 'general-ledger':
                return $this->exportGeneralLedger($request);
            default:
                abort(404, 'Report type not found');
        }
    }

    public function exportTrialBalance(Request $request)
    {
        $date = $request->get('date') ? Carbon::parse($request->get('date')) : now();
        $trialBalance = $this->accountingService->generateTrialBalance($date);

        $filename = "trial_balance_{$date->format('Y-m-d')}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($trialBalance) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, ['Account Code', 'Account Name', 'Account Type', 'Debits', 'Credits', 'Balance']);

            // Data rows
            foreach ($trialBalance as $row) {
                fputcsv($file, [
                    $row['account_code'],
                    $row['account_name'],
                    $row['account_type'],
                    $row['debits'],
                    $row['credits'],
                    $row['balance']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportBalanceSheet(Request $request)
    {
        $date = $request->get('date') ? Carbon::parse($request->get('date')) : now();
        $balanceSheet = $this->accountingService->generateBalanceSheet($date);

        $filename = "balance_sheet_{$date->format('Y-m-d')}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($balanceSheet) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, ['Section', 'Account Name', 'Balance']);

            // Assets
            fputcsv($file, ['ASSETS', '', '']);
            foreach ($balanceSheet['assets'] as $asset) {
                fputcsv($file, ['', $asset['account_name'], $asset['balance']]);
            }
            fputcsv($file, ['', 'Total Assets', $balanceSheet['totals']['total_assets']]);
            fputcsv($file, ['', '', '']);

            // Liabilities
            fputcsv($file, ['LIABILITIES', '', '']);
            foreach ($balanceSheet['liabilities'] as $liability) {
                fputcsv($file, ['', $liability['account_name'], $liability['balance']]);
            }
            fputcsv($file, ['', 'Total Liabilities', $balanceSheet['totals']['total_liabilities']]);
            fputcsv($file, ['', '', '']);

            // Equity
            fputcsv($file, ['EQUITY', '', '']);
            foreach ($balanceSheet['equity'] as $equity) {
                fputcsv($file, ['', $equity['account_name'], $equity['balance']]);
            }
            fputcsv($file, ['', 'Total Equity', $balanceSheet['totals']['total_equity']]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportIncomeStatement(Request $request)
    {
        $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : now()->startOfYear();
        $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : now()->endOfYear();
        $incomeStatement = $this->accountingService->generateIncomeStatement($startDate, $endDate);

        $filename = "income_statement_{$startDate->format('Y-m-d')}_{$endDate->format('Y-m-d')}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($incomeStatement) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, ['Section', 'Account Name', 'Amount']);

            // Revenue
            fputcsv($file, ['REVENUE', '', '']);
            foreach ($incomeStatement['revenue'] as $revenue) {
                fputcsv($file, ['', $revenue['account_name'], $revenue['amount']]);
            }
            fputcsv($file, ['', 'Total Revenue', $incomeStatement['totals']['total_revenue']]);
            fputcsv($file, ['', '', '']);

            // Expenses
            fputcsv($file, ['EXPENSES', '', '']);
            foreach ($incomeStatement['expenses'] as $expense) {
                fputcsv($file, ['', $expense['account_name'], $expense['amount']]);
            }
            fputcsv($file, ['', 'Total Expenses', $incomeStatement['totals']['total_expenses']]);
            fputcsv($file, ['', '', '']);

            // Net Income
            fputcsv($file, ['NET INCOME', '', $incomeStatement['totals']['net_income']]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportCashFlow(Request $request)
    {
        $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : now()->startOfYear();
        $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : now()->endOfYear();

        $filename = "cash_flow_{$startDate->format('Y-m-d')}_{$endDate->format('Y-m-d')}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($startDate, $endDate) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, ['Date', 'Description', 'Type', 'Amount', 'Balance']);

            // Get cash account transactions
            $cashAccount = \App\Models\ChartOfAccount::where('account_code', '1000')->first();
            if ($cashAccount) {
                $cashTransactions = \App\Models\JournalEntryLine::where('account_id', $cashAccount->id)
                    ->whereHas('journalEntry', function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('entry_date', [$startDate, $endDate])
                            ->where('status', 'posted');
                    })
                    ->with(['journalEntry', 'account'])
                    ->orderBy('created_at')
                    ->get();

                $openingBalance = $cashAccount->opening_balance;
                $runningBalance = $openingBalance;

                foreach ($cashTransactions as $transaction) {
                    if ($transaction->entry_type === 'debit') {
                        $runningBalance += $transaction->amount;
                        fputcsv($file, [
                            $transaction->journalEntry->entry_date->format('Y-m-d'),
                            $transaction->journalEntry->description,
                            'Inflow',
                            $transaction->amount,
                            $runningBalance
                        ]);
                    } else {
                        $runningBalance -= $transaction->amount;
                        fputcsv($file, [
                            $transaction->journalEntry->entry_date->format('Y-m-d'),
                            $transaction->journalEntry->description,
                            'Outflow',
                            $transaction->amount,
                            $runningBalance
                        ]);
                    }
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportGeneralLedger(Request $request)
    {
        $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : now()->startOfYear();
        $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : now()->endOfYear();
        $accountId = $request->get('account_id');

        $filename = "general_ledger_{$startDate->format('Y-m-d')}_{$endDate->format('Y-m-d')}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($startDate, $endDate, $accountId) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, ['Date', 'Description', 'Reference', 'Debit', 'Credit', 'Balance']);

            if ($accountId) {
                $account = \App\Models\ChartOfAccount::find($accountId);
                if ($account) {
                    $ledgerEntries = \App\Models\JournalEntryLine::where('account_id', $accountId)
                        ->whereHas('journalEntry', function ($query) use ($startDate, $endDate) {
                            $query->whereBetween('entry_date', [$startDate, $endDate])
                                ->where('status', 'posted');
                        })
                        ->with(['journalEntry'])
                        ->orderBy('created_at')
                        ->get();

                    $openingBalance = $account->opening_balance;
                    $runningBalance = $openingBalance;

                    foreach ($ledgerEntries as $entry) {
                        if ($entry->entry_type === 'debit') {
                            $runningBalance += $entry->amount;
                            fputcsv($file, [
                                $entry->journalEntry->entry_date->format('Y-m-d'),
                                $entry->journalEntry->description,
                                $entry->journalEntry->reference_number ?? '',
                                $entry->amount,
                                '',
                                $runningBalance
                            ]);
                        } else {
                            $runningBalance -= $entry->amount;
                            fputcsv($file, [
                                $entry->journalEntry->entry_date->format('Y-m-d'),
                                $entry->journalEntry->description,
                                $entry->journalEntry->reference_number ?? '',
                                '',
                                $entry->amount,
                                $runningBalance
                            ]);
                        }
                    }
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
