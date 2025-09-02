<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Concert extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'venue',
        'type',
        'status',
        'ticket_price',
        'max_attendees',
        'is_featured'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'string',
        'ticket_price' => 'decimal:2',
        'max_attendees' => 'integer',
        'is_featured' => 'boolean'
    ];

    // Relationships
    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming')->where('date', '>', now());
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('date', date('Y'));
    }
}