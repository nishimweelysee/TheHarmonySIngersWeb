<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_number',
        'title',
        'description',
        'expense_category_id',
        'account_id',
        'amount',
        'expense_date',
        'payment_method',
        'reference_number',
        'status',
        'requested_by',
        'approved_by',
        'approved_at',
        'paid_at',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime'
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
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
            'draft' => 'bg-gray-100 text-gray-800',
            'pending_approval' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-blue-100 text-blue-800',
            'paid' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getCanApproveAttribute(): bool
    {
        return $this->status === 'pending_approval';
    }

    public function getCanPayAttribute(): bool
    {
        return $this->status === 'approved';
    }

    public function getCanCancelAttribute(): bool
    {
        return in_array($this->status, ['draft', 'pending_approval', 'approved']);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('expense_category_id', $categoryId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('expense_date', [$startDate, $endDate]);
    }

    public function scopePendingApproval($query)
    {
        return $query->where('status', 'pending_approval');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    // Methods
    public function submitForApproval(): bool
    {
        if ($this->status !== 'draft') {
            return false;
        }

        $this->update(['status' => 'pending_approval']);
        return true;
    }

    public function approve($approvedBy): bool
    {
        if ($this->status !== 'pending_approval') {
            return false;
        }

        $this->update([
            'status' => 'approved',
            'approved_by' => $approvedBy,
            'approved_at' => now()
        ]);

        return true;
    }

    public function markAsPaid(): bool
    {
        if ($this->status !== 'approved') {
            return false;
        }

        $this->update([
            'status' => 'paid',
            'paid_at' => now()
        ]);

        return true;
    }

    public function cancel(): bool
    {
        if (!$this->can_cancel) {
            return false;
        }

        $this->update(['status' => 'cancelled']);
        return true;
    }
}
