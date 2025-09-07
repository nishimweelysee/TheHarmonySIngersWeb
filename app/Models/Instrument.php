<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Instrument extends Model
{
    protected $fillable = [
        'name',
        'type',
        'brand',
        'model',
        'description',
        'condition',
        'purchase_price',
        'purchase_date',
        'owner_member_id',
        'is_available',
        'notes'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'purchase_date' => 'date',
        'is_available' => 'boolean'
    ];

    // Relationships
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'owner_member_id');
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCondition($query, $condition)
    {
        return $query->where('condition', $condition);
    }
}
