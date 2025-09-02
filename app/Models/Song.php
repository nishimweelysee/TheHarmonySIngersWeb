<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Song extends Model
{
    protected $fillable = [
        'title',
        'composer',
        'arranger',
        'genre',
        'language',
        'year_composed',
        'difficulty',
        'duration',
        'duration_minutes',
        'key_signature',
        'time_signature',
        'lyrics',
        'notes',
        'audio_file',
        'sheet_music_file',
        'is_active',
        'is_featured'
    ];

    protected $casts = [
        'year_composed' => 'integer',
        'duration' => 'decimal:2',
        'duration_minutes' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean'
    ];

    // Relationships
    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    // Scopes
    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    public function scopeByGenre($query, $genre)
    {
        return $query->where('genre', $genre);
    }

    public function scopeWithAudio($query)
    {
        return $query->whereNotNull('audio_file');
    }

    public function scopeWithSheetMusic($query)
    {
        return $query->whereNotNull('sheet_music_file');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Accessors
    public function getAudioUrlAttribute()
    {
        return $this->audio_file ? asset('storage/' . $this->audio_file) : null;
    }

    public function getSheetMusicUrlAttribute()
    {
        return $this->sheet_music_file ? asset('storage/' . $this->sheet_music_file) : null;
    }

    public function getFormattedDurationAttribute()
    {
        if ($this->duration) {
            $minutes = floor($this->duration);
            $seconds = round(($this->duration - $minutes) * 60);
            return $minutes . ':' . str_pad($seconds, 2, '0', STR_PAD_LEFT);
        }
        return null;
    }

    public function getFormattedDifficultyAttribute()
    {
        return ucfirst($this->difficulty ?? 'Not specified');
    }
}
