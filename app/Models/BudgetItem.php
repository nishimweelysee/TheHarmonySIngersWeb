<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BudgetItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'account_id',
        'expense_category_id',
        'planned_amount',
        'actual_amount',
        'notes'
    ];

    protected $casts = [
        'planned_amount' => 'decimal:2',
        'actual_amount' => 'decimal:2'
    ];

    // Relationships
    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }

    public function expenseCategory(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    // Accessors
    public function getVarianceAttribute(): float
    {
        return $this->actual_amount - $this->planned_amount;
    }

    public function getVariancePercentageAttribute(): float
    {
        if ($this->planned_amount == 0) {
            return 0;
        }
        return ($this->variance / $this->planned_amount) * 100;
    }

    public function getFormattedPlannedAmountAttribute(): string
    {
        return number_format($this->planned_amount, 2);
    }

    public function getFormattedActualAmountAttribute(): string
    {
        return number_format($this->actual_amount, 2);
    }

    public function getFormattedVarianceAttribute(): string
    {
        return number_format($this->variance, 2);
    }

    public function getVarianceBadgeAttribute(): string
    {
        if ($this->variance == 0) {
            return 'bg-gray-100 text-gray-800';
        }

        if ($this->variance > 0) {
            return 'bg-red-100 text-red-800';
        }

        return 'bg-green-100 text-green-800';
    }

    // Scopes
    public function scopeByAccount($query, $accountId)
    {
        return $query->where('account_id', $accountId);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('expense_category_id', $categoryId);
    }

    public function scopeWithVariance($query)
    {
        return $query->whereRaw('actual_amount != planned_amount');
    }

    public function scopeOverBudget($query)
    {
        return $query->whereRaw('actual_amount > planned_amount');
    }

    public function scopeUnderBudget($query)
    {
        return $query->whereRaw('actual_amount < planned_amount');
    }
}
