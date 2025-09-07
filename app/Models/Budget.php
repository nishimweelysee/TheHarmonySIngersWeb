<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'fiscal_year',
        'period',
        'start_date',
        'end_date',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
        'notes'
    ];

    protected $casts = [
        'fiscal_year' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime'
    ];

    // Relationships
    public function items(): HasMany
    {
        return $this->hasMany(BudgetItem::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Accessors
    public function getTotalPlannedAttribute(): float
    {
        return $this->items()->sum('planned_amount');
    }

    public function getTotalActualAttribute(): float
    {
        return $this->items()->sum('actual_amount');
    }

    public function getTotalVarianceAttribute(): float
    {
        return $this->total_actual - $this->total_planned;
    }

    public function getVariancePercentageAttribute(): float
    {
        if ($this->total_planned == 0) {
            return 0;
        }
        return ($this->total_variance / $this->total_planned) * 100;
    }

    public function getFormattedTotalPlannedAttribute(): string
    {
        return number_format($this->total_planned, 2);
    }

    public function getFormattedTotalActualAttribute(): string
    {
        return number_format($this->total_actual, 2);
    }

    public function getFormattedTotalVarianceAttribute(): string
    {
        return number_format($this->total_variance, 2);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'bg-gray-100 text-gray-800',
            'active' => 'bg-green-100 text-green-800',
            'closed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByFiscalYear($query, $year)
    {
        return $query->where('fiscal_year', $year);
    }

    public function scopeByPeriod($query, $period)
    {
        return $query->where('period', $period);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('start_date', [$startDate, $endDate])
            ->orWhereBetween('end_date', [$startDate, $endDate]);
    }

    // Methods
    public function activate(): bool
    {
        if ($this->status !== 'draft') {
            return false;
        }

        $this->update(['status' => 'active']);
        return true;
    }

    public function close(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        $this->update(['status' => 'closed']);
        return true;
    }

    public function approve($approvedBy): bool
    {
        if ($this->status !== 'draft') {
            return false;
        }

        $this->update([
            'approved_by' => $approvedBy,
            'approved_at' => now()
        ]);

        return true;
    }
}
