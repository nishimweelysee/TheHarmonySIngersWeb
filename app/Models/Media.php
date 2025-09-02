<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'album_id',
        'concert_id',
        'event_date',
        'is_featured',
        'is_public',
        'sort_order'
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_featured' => 'boolean',
        'is_public' => 'boolean'
    ];

    // Relationships
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function concert(): BelongsTo
    {
        return $this->belongsTo(Concert::class);
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePhotos($query)
    {
        return $query->where('type', 'photo');
    }

    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    public function scopeAudios($query)
    {
        return $query->where('type', 'audio');
    }
}
