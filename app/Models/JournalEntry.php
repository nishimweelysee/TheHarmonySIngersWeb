<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JournalEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'entry_number',
        'entry_date',
        'description',
        'entry_type',
        'status',
        'created_by',
        'approved_by',
        'posted_at',
        'notes'
    ];

    protected $casts = [
        'entry_date' => 'date',
        'posted_at' => 'datetime'
    ];

    // Relationships
    public function lines(): HasMany
    {
        return $this->hasMany(JournalEntryLine::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function bankTransactions(): HasMany
    {
        return $this->hasMany(BankTransaction::class);
    }

    // Accessors
    public function getTotalDebitsAttribute(): float
    {
        return $this->lines()->where('entry_type', 'debit')->sum('amount');
    }

    public function getTotalCreditsAttribute(): float
    {
        return $this->lines()->where('entry_type', 'credit')->sum('amount');
    }

    public function getIsBalancedAttribute(): bool
    {
        return abs($this->total_debits - $this->total_credits) < 0.01;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'bg-gray-100 text-gray-800',
            'posted' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Scopes
    public function scopePosted($query)
    {
        return $query->where('status', 'posted');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('entry_type', $type);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('entry_date', [$startDate, $endDate]);
    }

    // Methods
    public function post(): bool
    {
        if (!$this->is_balanced) {
            return false;
        }

        $this->update([
            'status' => 'posted',
            'posted_at' => now()
        ]);

        return true;
    }

    public function cancel(): bool
    {
        if ($this->status === 'posted') {
            return false;
        }

        $this->update(['status' => 'cancelled']);
        return true;
    }
}
