<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'event',
        'auditable_type',
        'auditable_id',
        'user_id',
        'user_type',
        'old_values',
        'new_values',
        'url',
        'ip_address',
        'user_agent',
        'description',
        'metadata',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'metadata' => 'array',
    ];

    /**
     * Get the auditable model.
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who performed the action.
     */
    public function user(): MorphTo
    {
        return $this->morphTo('user');
    }

    /**
     * Scope to filter by event type.
     */
    public function scopeEvent($query, $event)
    {
        return $query->where('event', $event);
    }

    /**
     * Scope to filter by user.
     */
    public function scopeForUser($query, $userId, $userType = null)
    {
        $query->where('user_id', $userId);

        if ($userType) {
            $query->where('user_type', $userType);
        }

        return $query;
    }

    /**
     * Scope to filter by auditable model.
     */
    public function scopeForModel($query, $modelType, $modelId = null)
    {
        $query->where('auditable_type', $modelType);

        if ($modelId) {
            $query->where('auditable_id', $modelId);
        }

        return $query;
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Get formatted description.
     */
    public function getFormattedDescriptionAttribute(): string
    {
        if ($this->description) {
            return $this->description;
        }

        $userName = $this->user ? $this->user->name : 'System';

        // Handle cases where auditable_type is null (like login/logout events)
        if (!$this->auditable_type) {
            return match ($this->event) {
                'login' => "{$userName} logged in",
                'logout' => "{$userName} logged out",
                'viewed' => "{$userName} viewed {$this->url}",
                default => "{$userName} performed {$this->event}",
            };
        }

        $modelName = class_basename($this->auditable_type);

        return match ($this->event) {
            'created' => "{$userName} created {$modelName} #{$this->auditable_id}",
            'updated' => "{$userName} updated {$modelName} #{$this->auditable_id}",
            'deleted' => "{$userName} deleted {$modelName} #{$this->auditable_id}",
            'viewed' => "{$userName} viewed {$modelName} #{$this->auditable_id}",
            default => "{$userName} performed {$this->event} on {$modelName} #{$this->auditable_id}",
        };
    }

    /**
     * Get the changes made.
     */
    public function getChangesAttribute(): array
    {
        if (!$this->old_values || !$this->new_values) {
            return [];
        }

        $changes = [];
        foreach ($this->new_values as $key => $newValue) {
            $oldValue = $this->old_values[$key] ?? null;
            if ($oldValue !== $newValue) {
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => $newValue,
                ];
            }
        }

        return $changes;
    }
}
