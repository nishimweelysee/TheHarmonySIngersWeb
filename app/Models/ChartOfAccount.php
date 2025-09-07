<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChartOfAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_code',
        'account_name',
        'account_type',
        'account_category',
        'description',
        'opening_balance',
        'is_active',
        'is_system_account'
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2',
        'is_active' => 'boolean',
        'is_system_account' => 'boolean'
    ];

    // Relationships
    public function journalEntryLines(): HasMany
    {
        return $this->hasMany(JournalEntryLine::class, 'account_id');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'account_id');
    }

    public function budgetItems(): HasMany
    {
        return $this->hasMany(BudgetItem::class, 'account_id');
    }

    // Accessors
    public function getCurrentBalanceAttribute(): float
    {
        $debits = $this->journalEntryLines()
            ->where('entry_type', 'debit')
            ->sum('amount');

        $credits = $this->journalEntryLines()
            ->where('entry_type', 'credit')
            ->sum('amount');

        if (in_array($this->account_type, ['asset', 'expense'])) {
            return $this->opening_balance + $debits - $credits;
        }

        return $this->opening_balance + $credits - $debits;
    }

    public function getFormattedBalanceAttribute(): string
    {
        return number_format($this->current_balance, 2);
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->is_active ? 'active' : 'inactive';
    }

    public function getIsSystemAccountAttribute(): bool
    {
        return $this->attributes['is_system_account'] ?? false;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('account_type', $type);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('account_category', $category);
    }

    public function scopeSystemAccounts($query)
    {
        return $query->where('is_system_account', true);
    }

    public function scopeNonSystemAccounts($query)
    {
        return $query->where('is_system_account', false);
    }
}
