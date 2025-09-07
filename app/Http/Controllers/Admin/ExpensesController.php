<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpensesController extends Controller
{
    public function index()
    {
        $expenses = Expense::with(['category', 'account', 'requester'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $categories = ExpenseCategory::active()->get();
        $statuses = ['draft', 'pending_approval', 'approved', 'paid', 'cancelled'];

        return view('admin.expenses.index', compact('expenses', 'categories', 'statuses'));
    }

    public function create()
    {
        $categories = ExpenseCategory::active()->get();
        $accounts = ChartOfAccount::where('account_type', 'expense')->active()->get();
        $paymentMethods = ['cash', 'check', 'bank_transfer', 'credit_card', 'online'];

        return view('admin.expenses.create', compact('categories', 'accounts', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'account_id' => 'required|exists:chart_of_accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'payment_method' => 'required|in:cash,check,bank_transfer,credit_card,online',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $validated['expense_number'] = $this->generateExpenseNumber();
        $validated['requested_by'] = Auth::id();
        $validated['status'] = 'draft';

        Expense::create($validated);

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Expense created successfully.');
    }

    public function show(Expense $expense)
    {
        $expense->load(['category', 'account', 'requester', 'approver']);

        return view('admin.expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::active()->get();
        $accounts = ChartOfAccount::where('account_type', 'expense')->active()->get();
        $paymentMethods = ['cash', 'check', 'bank_transfer', 'credit_card', 'online'];

        return view('admin.expenses.edit', compact('expense', 'categories', 'accounts', 'paymentMethods'));
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->status !== 'draft') {
            return back()->with('error', 'Only draft expenses can be edited.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'account_id' => 'required|exists:chart_of_accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'payment_method' => 'required|in:cash,check,bank_transfer,credit_card,online',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $expense->update($validated);

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->status !== 'draft') {
            return back()->with('error', 'Only draft expenses can be deleted.');
        }

        $expense->delete();

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }

    public function submitForApproval(Expense $expense)
    {
        if ($expense->status !== 'draft') {
            return back()->with('error', 'Only draft expenses can be submitted for approval.');
        }

        $expense->submitForApproval();

        return back()->with('success', 'Expense submitted for approval.');
    }

    public function approve(Expense $expense)
    {
        if ($expense->status !== 'pending_approval') {
            return back()->with('error', 'Only pending expenses can be approved.');
        }

        $expense->approve(Auth::id());

        return back()->with('success', 'Expense approved successfully.');
    }

    public function markAsPaid(Expense $expense)
    {
        if ($expense->status !== 'approved') {
            return back()->with('error', 'Only approved expenses can be marked as paid.');
        }

        $expense->markAsPaid();

        return back()->with('success', 'Expense marked as paid.');
    }

    public function cancel(Expense $expense)
    {
        if (!$expense->can_cancel) {
            return back()->with('error', 'This expense cannot be cancelled.');
        }

        $expense->cancel();

        return back()->with('success', 'Expense cancelled successfully.');
    }

    private function generateExpenseNumber(): string
    {
        $lastExpense = Expense::orderBy('id', 'desc')->first();

        if ($lastExpense) {
            $lastNumber = (int) substr($lastExpense->expense_number, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'EXP' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }
}
