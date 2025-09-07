<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndividualContribution extends Model
{
    protected $fillable = [
        'campaign_id',
        'contributor_name',
        'contributor_email',
        'contributor_phone',
        'amount',
        'currency',
        'contribution_date',
        'payment_method',
        'reference_number',
        'status',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'contribution_date' => 'date'
    ];

    // Relationships
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(ContributionCampaign::class, 'campaign_id');
    }

    // Scopes
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('contribution_date', now()->month)
            ->whereYear('contribution_date', now()->year);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('contribution_date', now()->year);
    }

    // Methods
    public function getFormattedAmountAttribute()
    {
        return $this->currency . ' ' . number_format($this->amount, 2);
    }

    public function getPaymentMethodLabelAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->payment_method));
    }

    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'confirmed' => 'info',
            'completed' => 'success',
            default => 'secondary'
        };
    }

    // Events
    protected static function booted()
    {
        static::created(function ($contribution) {
            // Update campaign current amount when contribution is added
            $contribution->campaign->updateCurrentAmount();
        });

        static::updated(function ($contribution) {
            // Update campaign current amount when contribution is updated
            if ($contribution->wasChanged('amount') || $contribution->wasChanged('status')) {
                $contribution->campaign->updateCurrentAmount();
            }
        });

        static::deleted(function ($contribution) {
            // Update campaign current amount when contribution is deleted
            $contribution->campaign->updateCurrentAmount();
        });
    }
}
