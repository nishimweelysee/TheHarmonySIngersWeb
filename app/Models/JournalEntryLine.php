<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JournalEntryLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_entry_id',
        'account_id',
        'entry_type',
        'amount',
        'description',
        'reference_type',
        'reference_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    // Relationships
    public function journalEntry(): BelongsTo
    {
        return $this->belongsTo(JournalEntry::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }

    public function reference()
    {
        if ($this->reference_type && $this->reference_id) {
            return $this->reference_type::find($this->reference_id);
        }
        return null;
    }

    // Accessors
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2);
    }

    public function getIsDebitAttribute(): bool
    {
        return $this->entry_type === 'debit';
    }

    public function getIsCreditAttribute(): bool
    {
        return $this->entry_type === 'credit';
    }

    // Scopes
    public function scopeDebits($query)
    {
        return $query->where('entry_type', 'debit');
    }

    public function scopeCredits($query)
    {
        return $query->where('entry_type', 'credit');
    }

    public function scopeByAccount($query, $accountId)
    {
        return $query->where('account_id', $accountId);
    }
}
