<?php

namespace App\Services;

use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Models\Expense;
use App\Models\Donation;
use App\Models\Contribution;
use App\Models\BankTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AccountingService
{
    /**
     * Create a journal entry for a donation
     */
    public function recordDonation(Donation $donation): JournalEntry
    {
        return DB::transaction(function () use ($donation) {
            $entry = JournalEntry::create([
                'entry_number' => $this->generateEntryNumber('DON'),
                'entry_date' => $donation->donation_date,
                'description' => "Donation from {$donation->donor_display_name}",
                'entry_type' => 'donation',
                'status' => 'posted',
                'created_by' => Auth::id(),
                'posted_at' => now(),
                'notes' => "Donation ID: {$donation->id}"
            ]);

            // Debit Cash/Accounts Receivable
            $cashAccount = ChartOfAccount::where('account_code', '1000')->first();
            JournalEntryLine::create([
                'journal_entry_id' => $entry->id,
                'account_id' => $cashAccount->id,
                'entry_type' => 'debit',
                'amount' => $donation->amount,
                'description' => "Donation from {$donation->donor_display_name}",
                'reference_type' => Donation::class,
                'reference_id' => $donation->id
            ]);

            // Credit Donation Revenue
            $donationAccount = ChartOfAccount::where('account_code', '4300')->first();
            JournalEntryLine::create([
                'journal_entry_id' => $entry->id,
                'account_id' => $donationAccount->id,
                'entry_type' => 'credit',
                'amount' => $donation->amount,
                'description' => "Donation from {$donation->donor_display_name}",
                'reference_type' => Donation::class,
                'reference_id' => $donation->id
            ]);

            return $entry;
        });
    }

    /**
     * Create a journal entry for an expense
     */
    public function recordExpense(Expense $expense): JournalEntry
    {
        return DB::transaction(function () use ($expense) {
            $entry = JournalEntry::create([
                'entry_number' => $this->generateEntryNumber('EXP'),
                'entry_date' => $expense->expense_date,
                'description' => "Expense: {$expense->title}",
                'entry_type' => 'expense',
                'status' => 'posted',
                'created_by' => Auth::id(),
                'posted_at' => now(),
                'notes' => "Expense ID: {$expense->id}"
            ]);

            // Debit Expense Account
            JournalEntryLine::create([
                'journal_entry_id' => $entry->id,
                'account_id' => $expense->account_id,
                'entry_type' => 'debit',
                'amount' => $expense->amount,
                'description' => $expense->title,
                'reference_type' => Expense::class,
                'reference_id' => $expense->id
            ]);

            // Credit Cash/Accounts Payable
            $cashAccount = ChartOfAccount::where('account_code', '1000')->first();
            JournalEntryLine::create([
                'journal_entry_id' => $entry->id,
                'account_id' => $cashAccount->id,
                'entry_type' => 'credit',
                'amount' => $expense->amount,
                'description' => "Payment for {$expense->title}",
                'reference_type' => Expense::class,
                'reference_id' => $expense->id
            ]);

            // Update expense with journal entry reference
            $expense->update(['journal_entry_id' => $entry->id]);

            return $entry;
        });
    }

    /**
     * Create a journal entry for a bank transaction
     */
    public function recordBankTransaction(BankTransaction $transaction): JournalEntry
    {
        return DB::transaction(function () use ($transaction) {
            $entry = JournalEntry::create([
                'entry_number' => $this->generateEntryNumber('BANK'),
                'entry_date' => $transaction->transaction_date,
                'description' => "Bank transaction: {$transaction->description}",
                'entry_type' => 'manual',
                'status' => 'posted',
                'created_by' => Auth::id(),
                'posted_at' => now(),
                'notes' => "Bank transaction ID: {$transaction->id}"
            ]);

            $cashAccount = ChartOfAccount::where('account_code', '1000')->first();

            if (in_array($transaction->type, ['deposit', 'interest'])) {
                // Debit Cash
                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id' => $cashAccount->id,
                    'entry_type' => 'debit',
                    'amount' => $transaction->amount,
                    'description' => $transaction->description,
                    'reference_type' => BankTransaction::class,
                    'reference_id' => $transaction->id
                ]);

                // Credit appropriate account based on type
                $creditAccount = match ($transaction->type) {
                    'deposit' => $cashAccount, // Transfer from another account
                    'interest' => ChartOfAccount::where('account_code', '4500')->first(), // Interest Income
                    default => $cashAccount
                };

                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id' => $creditAccount->id,
                    'entry_type' => 'credit',
                    'amount' => $transaction->amount,
                    'description' => $transaction->description,
                    'reference_type' => BankTransaction::class,
                    'reference_id' => $transaction->id
                ]);
            } else {
                // Credit Cash
                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id' => $cashAccount->id,
                    'entry_type' => 'credit',
                    'amount' => $transaction->amount,
                    'description' => $transaction->description,
                    'reference_type' => BankTransaction::class,
                    'reference_id' => $transaction->id
                ]);

                // Debit appropriate account based on type
                $debitAccount = match ($transaction->type) {
                    'withdrawal' => $cashAccount, // Transfer to another account
                    'fee' => ChartOfAccount::where('account_code', '6200')->first(), // Bank Charges
                    default => $cashAccount
                };

                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id' => $debitAccount->id,
                    'entry_type' => 'debit',
                    'amount' => $transaction->amount,
                    'description' => $transaction->description,
                    'reference_type' => BankTransaction::class,
                    'reference_id' => $transaction->id
                ]);
            }

            // Update transaction with journal entry reference
            $transaction->update(['journal_entry_id' => $entry->id]);

            return $entry;
        });
    }

    /**
     * Generate trial balance for a specific date
     */
    public function generateTrialBalance(Carbon $date = null): array
    {
        $date = $date ?? now();

        $accounts = ChartOfAccount::active()->get();
        $trialBalance = [];

        foreach ($accounts as $account) {
            $debits = $account->journalEntryLines()
                ->whereHas('journalEntry', function ($query) use ($date) {
                    $query->where('entry_date', '<=', $date)
                        ->where('status', 'posted');
                })
                ->where('entry_type', 'debit')
                ->sum('amount');

            $credits = $account->journalEntryLines()
                ->whereHas('journalEntry', function ($query) use ($date) {
                    $query->where('entry_date', '<=', $date)
                        ->where('status', 'posted');
                })
                ->where('entry_type', 'credit')
                ->sum('amount');

            $balance = $account->opening_balance;

            if (in_array($account->account_type, ['asset', 'expense'])) {
                $balance += $debits - $credits;
            } else {
                $balance += $credits - $debits;
            }

            $trialBalance[] = [
                'account_code' => $account->account_code,
                'account_name' => $account->account_name,
                'account_type' => $account->account_type,
                'debits' => $debits,
                'credits' => $credits,
                'balance' => $balance,
                'formatted_balance' => number_format($balance, 2)
            ];
        }

        return $trialBalance;
    }

    /**
     * Generate income statement for a date range
     */
    public function generateIncomeStatement(Carbon $startDate, Carbon $endDate): array
    {
        $revenueAccounts = ChartOfAccount::where('account_type', 'revenue')->get();
        $expenseAccounts = ChartOfAccount::where('account_type', 'expense')->get();

        $revenues = [];
        $expenses = [];
        $totalRevenue = 0;
        $totalExpenses = 0;

        // Calculate revenues
        foreach ($revenueAccounts as $account) {
            $credits = $account->journalEntryLines()
                ->whereHas('journalEntry', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('entry_date', [$startDate, $endDate])
                        ->where('status', 'posted');
                })
                ->where('entry_type', 'credit')
                ->sum('amount');

            if ($credits > 0) {
                $revenues[] = [
                    'account_name' => $account->account_name,
                    'amount' => $credits,
                    'formatted_amount' => number_format($credits, 2)
                ];
                $totalRevenue += $credits;
            }
        }

        // Calculate expenses
        foreach ($expenseAccounts as $account) {
            $debits = $account->journalEntryLines()
                ->whereHas('journalEntry', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('entry_date', [$startDate, $endDate])
                        ->where('status', 'posted');
                })
                ->where('entry_type', 'debit')
                ->sum('amount');

            if ($debits > 0) {
                $expenses[] = [
                    'account_name' => $account->account_name,
                    'amount' => $debits,
                    'formatted_amount' => number_format($debits, 2)
                ];
                $totalExpenses += $debits;
            }
        }

        $netIncome = $totalRevenue - $totalExpenses;

        return [
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d')
            ],
            'revenues' => $revenues,
            'expenses' => $expenses,
            'total_revenue' => $totalRevenue,
            'total_expenses' => $totalExpenses,
            'net_income' => $netIncome,
            'formatted_totals' => [
                'total_revenue' => number_format($totalRevenue, 2),
                'total_expenses' => number_format($totalExpenses, 2),
                'net_income' => number_format($netIncome, 2)
            ]
        ];
    }

    /**
     * Generate balance sheet as of a specific date
     */
    public function generateBalanceSheet(Carbon $date = null): array
    {
        $date = $date ?? now();

        $assets = ChartOfAccount::where('account_type', 'asset')->get();
        $liabilities = ChartOfAccount::where('account_type', 'liability')->get();
        $equity = ChartOfAccount::where('account_type', 'equity')->get();

        $totalAssets = 0;
        $totalLiabilities = 0;
        $totalEquity = 0;

        // Calculate assets
        $assetItems = [];
        foreach ($assets as $account) {
            $debits = $account->journalEntryLines()
                ->whereHas('journalEntry', function ($query) use ($date) {
                    $query->where('entry_date', '<=', $date)
                        ->where('status', 'posted');
                })
                ->where('entry_type', 'debit')
                ->sum('amount');

            $credits = $account->journalEntryLines()
                ->whereHas('journalEntry', function ($query) use ($date) {
                    $query->where('entry_date', '<=', $date)
                        ->where('status', 'posted');
                })
                ->where('entry_type', 'credit')
                ->sum('amount');

            $balance = $account->opening_balance + $debits - $credits;
            $totalAssets += $balance;

            $assetItems[] = [
                'account_name' => $account->account_name,
                'balance' => $balance,
                'formatted_balance' => number_format($balance, 2)
            ];
        }

        // Calculate liabilities
        $liabilityItems = [];
        foreach ($liabilities as $account) {
            $debits = $account->journalEntryLines()
                ->whereHas('journalEntry', function ($query) use ($date) {
                    $query->where('entry_date', '<=', $date)
                        ->where('status', 'posted');
                })
                ->where('entry_type', 'debit')
                ->sum('amount');

            $credits = $account->journalEntryLines()
                ->whereHas('journalEntry', function ($query) use ($date) {
                    $query->where('entry_date', '<=', $date)
                        ->where('status', 'posted');
                })
                ->where('entry_type', 'credit')
                ->sum('amount');

            $balance = $account->opening_balance + $credits - $debits;
            $totalLiabilities += $balance;

            $liabilityItems[] = [
                'account_name' => $account->account_name,
                'balance' => $balance,
                'formatted_balance' => number_format($balance, 2)
            ];
        }

        // Calculate equity
        $equityItems = [];
        foreach ($equity as $account) {
            $debits = $account->journalEntryLines()
                ->whereHas('journalEntry', function ($query) use ($date) {
                    $query->where('entry_date', '<=', $date)
                        ->where('status', 'posted');
                })
                ->where('entry_type', 'debit')
                ->sum('amount');

            $credits = $account->journalEntryLines()
                ->whereHas('journalEntry', function ($query) use ($date) {
                    $query->where('entry_date', '<=', $date)
                        ->where('status', 'posted');
                })
                ->where('entry_type', 'credit')
                ->sum('amount');

            $balance = $account->opening_balance + $credits - $debits;
            $totalEquity += $balance;

            $equityItems[] = [
                'account_name' => $account->account_name,
                'balance' => $balance,
                'formatted_balance' => number_format($balance, 2)
            ];
        }

        return [
            'as_of_date' => $date->format('Y-m-d'),
            'assets' => $assetItems,
            'liabilities' => $liabilityItems,
            'equity' => $equityItems,
            'totals' => [
                'total_assets' => $totalAssets,
                'total_liabilities' => $totalLiabilities,
                'total_equity' => $totalEquity,
                'formatted_totals' => [
                    'total_assets' => number_format($totalAssets, 2),
                    'total_liabilities' => number_format($totalLiabilities, 2),
                    'total_equity' => number_format($totalEquity, 2)
                ]
            ]
        ];
    }

    /**
     * Generate entry number
     */
    private function generateEntryNumber(string $prefix): string
    {
        $lastEntry = JournalEntry::where('entry_number', 'like', $prefix . '%')
            ->orderBy('entry_number', 'desc')
            ->first();

        if ($lastEntry) {
            $lastNumber = (int) substr($lastEntry->entry_number, strlen($prefix));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }
}
