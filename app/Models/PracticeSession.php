<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Carbon\Carbon;

class PracticeSession extends Model
{
    protected $fillable = [
        'title',
        'description',
        'practice_date',
        'start_time',
        'end_time',
        'venue',
        'venue_address',
        'status',
        'notes',
        'reminders_sent',
        'reminder_sent_at'
    ];

    protected $casts = [
        'practice_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'reminders_sent' => 'boolean',
        'reminder_sent_at' => 'datetime'
    ];

    // Relationships
    public function attendances(): HasMany
    {
        return $this->hasMany(PracticeAttendance::class);
    }

    public function members(): HasManyThrough
    {
        return $this->hasManyThrough(Member::class, PracticeAttendance::class, 'practice_session_id', 'id', 'id', 'member_id');
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('practice_date', '>=', now()->toDateString())
            ->where('status', 'scheduled');
    }

    public function scopeToday($query)
    {
        return $query->where('practice_date', now()->toDateString());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('practice_date', [
            now()->startOfWeek()->toDateString(),
            now()->endOfWeek()->toDateString()
        ]);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Accessors
    public function getFullDateTimeAttribute(): string
    {
        return $this->practice_date->format('F j, Y') . ' at ' . $this->start_time->format('g:i A');
    }

    public function getDurationAttribute(): string
    {
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        $duration = $start->diffInMinutes($end);

        if ($duration < 60) {
            return $duration . ' minutes';
        }

        $hours = floor($duration / 60);
        $minutes = $duration % 60;

        if ($minutes == 0) {
            return $hours . ' hour' . ($hours > 1 ? 's' : '');
        }

        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ' . $minutes . ' minutes';
    }

    public function getAttendanceCountAttribute(): array
    {
        $attendances = $this->attendances;

        return [
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'excused' => $attendances->where('status', 'excused')->count(),
            'total' => $attendances->count()
        ];
    }

    public function getAttendancePercentageAttribute(): float
    {
        $counts = $this->attendance_count;
        if ($counts['total'] == 0) return 0;

        $present = $counts['present'] + $counts['late'];
        return round(($present / $counts['total']) * 100, 1);
    }

    // Methods
    public function isUpcoming(): bool
    {
        return $this->practice_date->isFuture() && $this->status === 'scheduled';
    }

    public function isToday(): bool
    {
        return $this->practice_date->isToday();
    }

    public function isInProgress(): bool
    {
        if (!$this->isToday()) return false;

        $now = now();
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);

        return $now->between($start, $end);
    }

    public function shouldSendReminders(): bool
    {
        if ($this->reminders_sent) return false;

        $practiceDateTime = Carbon::parse($this->practice_date . ' ' . $this->start_time);
        $now = now();

        // Send reminders 1 day before, morning of, and 30 minutes before
        return $now->diffInHours($practiceDateTime, false) <= 24;
    }

    public function markRemindersSent(): void
    {
        $this->update([
            'reminders_sent' => true,
            'reminder_sent_at' => now()
        ]);
    }
}
