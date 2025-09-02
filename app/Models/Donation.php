<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    protected $fillable = [
        'contribution_id',
        'member_id',
        'sponsor_id',
        'donor_name',
        'donor_email',
        'amount',
        'donation_date',
        'payment_method',
        'reference_number',
        'notes',
        'is_anonymous'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'donation_date' => 'date',
        'is_anonymous' => 'boolean'
    ];

    // Relationships
    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    // Accessors
    public function getDonorDisplayNameAttribute(): string
    {
        if ($this->is_anonymous) {
            return 'Anonymous';
        }

        if ($this->member) {
            return $this->member->full_name;
        }

        if ($this->sponsor) {
            return $this->sponsor->name;
        }

        return $this->donor_name;
    }
}
