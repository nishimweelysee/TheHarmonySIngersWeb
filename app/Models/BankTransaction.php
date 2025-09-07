<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_account_id',
        'transaction_date',
        'description',
        'amount',
        'type',
        'reference_number',
        'check_number',
        'status',
        'journal_entry_id',
        'notes'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2'
    ];

    // Relationships
    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function journalEntry(): BelongsTo
    {
        return $this->belongsTo(JournalEntry::class);
    }

    // Accessors
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'cleared' => 'bg-blue-100 text-blue-800',
            'reconciled' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getTypeBadgeAttribute(): string
    {
        return match ($this->type) {
            'deposit' => 'bg-green-100 text-green-800',
            'withdrawal' => 'bg-red-100 text-red-800',
            'transfer' => 'bg-blue-100 text-blue-800',
            'fee' => 'bg-orange-100 text-orange-800',
            'interest' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getIsReconciledAttribute(): bool
    {
        return $this->status === 'reconciled';
    }

    public function getCanReconcileAttribute(): bool
    {
        return $this->status === 'cleared';
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCleared($query)
    {
        return $query->where('status', 'cleared');
    }

    public function scopeReconciled($query)
    {
        return $query->where('status', 'reconciled');
    }

    public function scopeUnreconciled($query)
    {
        return $query->whereIn('status', ['pending', 'cleared']);
    }

    // Methods
    public function markAsCleared(): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        $this->update(['status' => 'cleared']);
        return true;
    }

    public function reconcile(): bool
    {
        if ($this->status !== 'cleared') {
            return false;
        }

        $this->update(['status' => 'reconciled']);
        return true;
    }

    public function unreconcile(): bool
    {
        if ($this->status !== 'reconciled') {
            return false;
        }

        $this->update(['status' => 'cleared']);
        return true;
    }
}
