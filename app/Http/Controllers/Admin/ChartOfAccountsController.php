<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChartOfAccountsController extends Controller
{
    public function index()
    {
        $accounts = ChartOfAccount::orderBy('account_code')->paginate(20);

        return view('admin.chart-of-accounts.index', compact('accounts'));
    }

    public function create()
    {
        $accountTypes = [
            'asset' => 'Asset',
            'liability' => 'Liability',
            'equity' => 'Equity',
            'revenue' => 'Revenue',
            'expense' => 'Expense'
        ];

        $accountCategories = [
            'current_assets' => 'Current Assets',
            'fixed_assets' => 'Fixed Assets',
            'current_liabilities' => 'Current Liabilities',
            'long_term_liabilities' => 'Long-term Liabilities',
            'equity' => 'Equity',
            'operating_revenue' => 'Operating Revenue',
            'other_revenue' => 'Other Revenue',
            'operating_expenses' => 'Operating Expenses',
            'other_expenses' => 'Other Expenses'
        ];

        return view('admin.chart-of-accounts.create', compact('accountTypes', 'accountCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_code' => 'required|string|max:20|unique:chart_of_accounts',
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|in:asset,liability,equity,revenue,expense',
            'account_category' => 'required|string',
            'description' => 'nullable|string',
            'opening_balance' => 'nullable|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        ChartOfAccount::create($validated);

        return redirect()->route('admin.chart-of-accounts.index')
            ->with('success', 'Account created successfully.');
    }

    public function edit(ChartOfAccount $chartOfAccount)
    {
        $accountTypes = [
            'asset' => 'Asset',
            'liability' => 'Liability',
            'equity' => 'Equity',
            'revenue' => 'Revenue',
            'expense' => 'Expense'
        ];

        $accountCategories = [
            'current_assets' => 'Current Assets',
            'fixed_assets' => 'Fixed Assets',
            'current_liabilities' => 'Current Liabilities',
            'long_term_liabilities' => 'Long-term Liabilities',
            'equity' => 'Equity',
            'operating_revenue' => 'Operating Revenue',
            'other_revenue' => 'Other Revenue',
            'operating_expenses' => 'Operating Expenses',
            'other_expenses' => 'Other Expenses'
        ];

        return view('admin.chart-of-accounts.edit', compact('chartOfAccount', 'accountTypes', 'accountCategories'));
    }

    public function update(Request $request, ChartOfAccount $chartOfAccount)
    {
        $validated = $request->validate([
            'account_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('chart_of_accounts')->ignore($chartOfAccount->id)
            ],
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|in:asset,liability,equity,revenue,expense',
            'account_category' => 'required|string',
            'description' => 'nullable|string',
            'opening_balance' => 'nullable|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        $chartOfAccount->update($validated);

        return redirect()->route('admin.chart-of-accounts.index')
            ->with('success', 'Account updated successfully.');
    }

    public function destroy(ChartOfAccount $chartOfAccount)
    {
        if ($chartOfAccount->is_system_account) {
            return back()->with('error', 'System accounts cannot be deleted.');
        }

        if ($chartOfAccount->journalEntryLines()->exists()) {
            return back()->with('error', 'Cannot delete account with existing transactions.');
        }

        $chartOfAccount->delete();

        return redirect()->route('admin.chart-of-accounts.index')
            ->with('success', 'Account deleted successfully.');
    }

    public function toggleStatus(ChartOfAccount $chartOfAccount)
    {
        if ($chartOfAccount->is_system_account) {
            return back()->with('error', 'System accounts status cannot be changed.');
        }

        $chartOfAccount->update(['is_active' => !$chartOfAccount->is_active]);

        $status = $chartOfAccount->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Account {$status} successfully.");
    }
}
