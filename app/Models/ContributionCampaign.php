<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContributionCampaign extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'year_plan_id',
        'start_date',
        'end_date',
        'target_amount',
        'min_amount_per_person',
        'current_amount',
        'status',
        'currency',
        'campaign_notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'target_amount' => 'decimal:2',
        'min_amount_per_person' => 'decimal:2',
        'current_amount' => 'decimal:2'
    ];

    // Relationships
    public function yearPlan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'year_plan_id');
    }

    public function individualContributions(): HasMany
    {
        return $this->hasMany(IndividualContribution::class, 'campaign_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeMonthly($query)
    {
        return $query->where('type', 'monthly');
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('start_date', date('Y'));
    }

    // Methods
    public function getProgressPercentageAttribute()
    {
        if (!$this->target_amount || $this->target_amount == 0) {
            return 0;
        }

        return min(100, round(($this->current_amount / $this->target_amount) * 100, 1));
    }

    public function getRemainingAmountAttribute()
    {
        if (!$this->target_amount) {
            return 0;
        }

        return max(0, $this->target_amount - $this->current_amount);
    }

    public function isOverdue()
    {
        return $this->end_date->isPast() && $this->status === 'active';
    }

    public function updateCurrentAmount()
    {
        $total = $this->individualContributions()
            ->whereIn('status', ['completed', 'confirmed'])
            ->sum('amount');

        $this->update(['current_amount' => $total]);

        // Auto-complete if target reached
        if ($this->target_amount && $total >= $this->target_amount && $this->status === 'active') {
            $this->update(['status' => 'completed']);
        }
    }

    public function getContributorCountAttribute()
    {
        return $this->individualContributions()
            ->whereIn('status', ['completed', 'confirmed'])
            ->count();
    }

    public function getAverageContributionAttribute()
    {
        $count = $this->contributor_count;
        if ($count === 0) return 0;

        return round($this->current_amount / $count, 2);
    }

    public function meetsMinimumAmount($amount)
    {
        if (!$this->min_amount_per_person) {
            return true; // No minimum set
        }

        return $amount >= $this->min_amount_per_person;
    }

    public function getMinimumAmountFormattedAttribute()
    {
        if (!$this->min_amount_per_person) {
            return 'No minimum';
        }

        return $this->currency . ' ' . number_format($this->min_amount_per_person, 2);
    }
}