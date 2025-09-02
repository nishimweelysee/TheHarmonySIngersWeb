<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'category',
        'contact_person',
        'contact_email',
        'contact_phone',
        'website',
        'address',
        'sponsorship_level',
        'sponsorship_amount',
        'partnership_start_date',
        'partnership_end_date',
        'annual_contribution',
        'status',
        'description',
        'notes'
    ];

    protected $casts = [
        'sponsorship_amount' => 'decimal:2',
        'annual_contribution' => 'decimal:2',
        'partnership_start_date' => 'date',
        'partnership_end_date' => 'date',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeIndividuals($query)
    {
        return $query->where('type', 'individual');
    }

    public function scopeOrganizations($query)
    {
        return $query->whereIn('type', ['corporate', 'foundation', 'government']);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('sponsorship_level', $level);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
