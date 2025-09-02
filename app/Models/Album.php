<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Album extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type', // photo, video, audio, mixed
        'cover_image',
        'concert_id',
        'event_date',
        'is_featured',
        'is_public',
        'sort_order'
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Relationships
    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
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

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
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

    public function scopeMixed($query)
    {
        return $query->where('type', 'mixed');
    }

    // Methods
    public function getMediaCountAttribute()
    {
        return $this->media()->count();
    }

    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }

        // Return first media item as cover if no cover image set
        $firstMedia = $this->media()->first();
        if ($firstMedia) {
            return asset('storage/' . $firstMedia->file_path);
        }

        return null;
    }

    public function getFormattedEventDateAttribute()
    {
        return $this->event_date ? $this->event_date->format('F j, Y') : 'No date set';
    }
}
