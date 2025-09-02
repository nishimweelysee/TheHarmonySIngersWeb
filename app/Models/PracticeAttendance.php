<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PracticeAttendance extends Model
{
    protected $fillable = [
        'practice_session_id',
        'member_id',
        'status',
        'reason',
        'arrival_time',
        'departure_time',
        'notes'
    ];

    protected $casts = [
        'arrival_time' => 'datetime',
        'departure_time' => 'datetime'
    ];

    // Relationships
    public function practiceSession(): BelongsTo
    {
        return $this->belongsTo(PracticeSession::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    // Scopes
    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }

    public function scopeLate($query)
    {
        return $query->where('status', 'late');
    }

    public function scopeExcused($query)
    {
        return $query->where('status', 'excused');
    }

    public function scopeBySession($query, $sessionId)
    {
        return $query->where('practice_session_id', $sessionId);
    }

    public function scopeByMember($query, $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    // Accessors
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'present' => 'success',
            'absent' => 'danger',
            'late' => 'warning',
            'excused' => 'info',
            default => 'secondary'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'present' => 'Present',
            'absent' => 'Absent',
            'late' => 'Late',
            'excused' => 'Excused',
            default => 'Unknown'
        };
    }

    // Methods
    public function markPresent(): void
    {
        $this->update([
            'status' => 'present',
            'arrival_time' => now(),
            'reason' => null
        ]);
    }

    public function markAbsent(string $reason = null): void
    {
        $this->update([
            'status' => 'absent',
            'arrival_time' => null,
            'departure_time' => null,
            'reason' => $reason
        ]);
    }

    public function markLate(string $reason = null): void
    {
        $this->update([
            'status' => 'late',
            'arrival_time' => now(),
            'reason' => $reason
        ]);
    }

    public function markExcused(string $reason): void
    {
        $this->update([
            'status' => 'excused',
            'arrival_time' => null,
            'departure_time' => null,
            'reason' => $reason
        ]);
    }

    public function recordDeparture(): void
    {
        $this->update([
            'departure_time' => now()
        ]);
    }
}
