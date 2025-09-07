<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'title',
        'description',
        'period_type',
        'year',
        'quarter',
        'month',
        'start_date',
        'end_date',
        'category',
        'status',
        'estimated_budget',
        'budget',
        'objectives',
        'activities',
        'notes'
    ];

    protected $casts = [
        'year' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'estimated_budget' => 'decimal:2'
    ];

    // Scopes
    public function scopeForYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function scopeForQuarter($query, $quarter)
    {
        return $query->where('quarter', $quarter);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeCurrentYear($query)
    {
        return $query->where('year', date('Y'));
    }

    // Relationships
    public function contributionCampaigns(): HasMany
    {
        return $this->hasMany(ContributionCampaign::class, 'year_plan_id');
    }
}
