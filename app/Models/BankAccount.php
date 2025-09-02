<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_name',
        'account_number',
        'bank_name',
        'branch',
        'swift_code',
        'iban',
        'opening_balance',
        'current_balance',
        'opening_date',
        'currency',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'opening_date' => 'date',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function transactions(): HasMany
    {
        return $this->hasMany(BankTransaction::class);
    }

    // Accessors
    public function getFormattedOpeningBalanceAttribute(): string
    {
        return number_format($this->opening_balance, 2);
    }

    public function getFormattedCurrentBalanceAttribute(): string
    {
        return number_format($this->current_balance, 2);
    }

    public function getBalanceDifferenceAttribute(): float
    {
        return $this->current_balance - $this->opening_balance;
    }

    public function getFormattedBalanceDifferenceAttribute(): string
    {
        return number_format($this->balance_difference, 2);
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->is_active
            ? 'bg-green-100 text-green-800'
            : 'bg-red-100 text-red-800';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByBank($query, $bankName)
    {
        return $query->where('bank_name', 'like', "%{$bankName}%");
    }

    public function scopeByCurrency($query, $currency)
    {
        return $query->where('currency', $currency);
    }

    // Methods
    public function updateBalance(): void
    {
        $totalDeposits = $this->transactions()
            ->where('type', 'deposit')
            ->sum('amount');

        $totalWithdrawals = $this->transactions()
            ->where('type', 'withdrawal')
            ->sum('amount');

        $totalFees = $this->transactions()
            ->where('type', 'fee')
            ->sum('amount');

        $totalInterest = $this->transactions()
            ->where('type', 'interest')
            ->sum('amount');

        $this->current_balance = $this->opening_balance + $totalDeposits - $totalWithdrawals - $totalFees + $totalInterest;
        $this->save();
    }

    public function getReconciledBalance(): float
    {
        return $this->transactions()
            ->where('status', 'reconciled')
            ->get()
            ->sum(function ($transaction) {
                return match ($transaction->type) {
                    'deposit', 'interest' => $transaction->amount,
                    'withdrawal', 'fee' => -$transaction->amount,
                    default => 0
                };
            }) + $this->opening_balance;
    }
}
