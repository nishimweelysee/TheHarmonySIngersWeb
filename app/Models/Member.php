<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use App\Traits\Auditable;

class Member extends Model
{
    use Notifiable, Auditable;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'profile_photo',
        'date_of_birth',
        'address',
        'type',
        'voice_part',
        'join_date',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'join_date' => 'date',
        'date_of_birth' => 'date',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function instruments(): HasMany
    {
        return $this->hasMany(Instrument::class, 'owner_member_id');
    }

    public function inboxNotifications(): HasMany
    {
        return $this->hasMany(\App\Models\Notification::class, 'notifiable_id')
            ->where('notifiable_type', self::class);
    }

    public function practiceAttendances(): HasMany
    {
        return $this->hasMany(PracticeAttendance::class);
    }

    public function practiceAttendance($practiceSessionId)
    {
        return $this->practiceAttendances()
            ->where('practice_session_id', $practiceSessionId)
            ->first();
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSingers($query)
    {
        return $query->where('type', 'singer');
    }

    public function scopeGeneral($query)
    {
        return $query->where('type', 'general');
    }
}
