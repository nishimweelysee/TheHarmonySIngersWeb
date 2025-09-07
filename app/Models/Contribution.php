<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contribution extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'goal_amount',
        'current_amount',
        'start_date',
        'end_date',
        'status',
        'is_recurring',
        'notes'
    ];

    protected $casts = [
        'goal_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_recurring' => 'boolean'
    ];

    // Relationships
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    // Accessors
    public function getProgressPercentageAttribute(): float
    {
        if (!$this->goal_amount || $this->goal_amount == 0) {
            return 0;
        }
        return min(100, ($this->current_amount / $this->goal_amount) * 100);
    }

    public function getRemainingAmountAttribute(): float
    {
        return max(0, $this->goal_amount - $this->current_amount);
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

    public function scopeProject($query)
    {
        return $query->where('type', 'project');
    }
}
