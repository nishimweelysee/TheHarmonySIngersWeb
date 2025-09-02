<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relationships
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function budgetItems(): HasMany
    {
        return $this->hasMany(BudgetItem::class);
    }

    // Accessors
    public function getTotalExpensesAttribute(): float
    {
        return $this->expenses()->sum('amount');
    }

    public function getFormattedTotalExpensesAttribute(): string
    {
        return number_format($this->total_expenses, 2);
    }

    public function getExpenseCountAttribute(): int
    {
        return $this->expenses()->count();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }
}
