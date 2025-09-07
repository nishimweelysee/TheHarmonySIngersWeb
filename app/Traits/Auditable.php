<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Auditable
{
    /**
     * Boot the auditable trait.
     */
    protected static function bootAuditable()
    {
        static::created(function (Model $model) {
            static::logModelAuditEvent('created', $model);
        });

        static::updated(function (Model $model) {
            static::logModelAuditEvent('updated', $model);
        });

        static::deleted(function (Model $model) {
            static::logModelAuditEvent('deleted', $model);
        });
    }

    /**
     * Log an audit event for model changes.
     */
    protected static function logModelAuditEvent(string $event, Model $model): void
    {
        $user = Auth::user();

        $auditData = [
            'event' => $event,
            'auditable_type' => get_class($model),
            'auditable_id' => $model->getKey(),
            'user_id' => $user?->getKey(),
            'user_type' => $user ? get_class($user) : null,
            'url' => Request::fullUrl(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'description' => static::generateDescription($event, $model, $user),
        ];

        // Add old and new values for update events
        if ($event === 'updated' && $model->wasChanged()) {
            $auditData['old_values'] = $model->getOriginal();
            $auditData['new_values'] = $model->getChanges();
        } elseif ($event === 'created') {
            $auditData['new_values'] = $model->getAttributes();
        } elseif ($event === 'deleted') {
            $auditData['old_values'] = $model->getAttributes();
        }

        // Add metadata if the model has audit metadata
        if (method_exists($model, 'getAuditMetadata')) {
            $auditData['metadata'] = $model->getAuditMetadata();
        }

        AuditLog::create($auditData);
    }

    /**
     * Generate a human-readable description for the audit event.
     */
    protected static function generateDescription(string $event, Model $model, $user): string
    {
        $modelName = class_basename($model);
        $userName = $user ? $user->name : 'System';

        // Try to get a meaningful identifier for the model
        $identifier = static::getModelIdentifier($model);

        return match ($event) {
            'created' => "{$userName} created {$modelName} {$identifier}",
            'updated' => "{$userName} updated {$modelName} {$identifier}",
            'deleted' => "{$userName} deleted {$modelName} {$identifier}",
            default => "{$userName} performed {$event} on {$modelName} {$identifier}",
        };
    }

    /**
     * Get a meaningful identifier for the model.
     */
    protected static function getModelIdentifier(Model $model): string
    {
        // Try common identifier fields
        $identifierFields = ['name', 'title', 'email', 'first_name', 'full_name'];

        foreach ($identifierFields as $field) {
            if (isset($model->$field) && !empty($model->$field)) {
                return "'{$model->$field}'";
            }
        }

        // Fallback to ID
        return "#{$model->getKey()}";
    }

    /**
     * Manually log a custom audit event.
     */
    public function logAuditEvent(string $event, ?string $description = null, ?array $metadata = null): void
    {
        $user = Auth::user();

        AuditLog::create([
            'event' => $event,
            'auditable_type' => get_class($this),
            'auditable_id' => $this->getKey(),
            'user_id' => $user?->getKey(),
            'user_type' => $user ? get_class($user) : null,
            'url' => Request::fullUrl(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'description' => $description ?? $this->generateInstanceDescription($event, $user),
            'metadata' => $metadata,
        ]);
    }

    /**
     * Generate a description for instance audit events.
     */
    protected function generateInstanceDescription(string $event, $user): string
    {
        $modelName = class_basename($this);
        $userName = $user ? $user->name : 'System';
        $identifier = static::getModelIdentifier($this);

        return match ($event) {
            'created' => "{$userName} created {$modelName} {$identifier}",
            'updated' => "{$userName} updated {$modelName} {$identifier}",
            'deleted' => "{$userName} deleted {$modelName} {$identifier}",
            default => "{$userName} performed {$event} on {$modelName} {$identifier}",
        };
    }

    /**
     * Get audit logs for this model.
     */
    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    /**
     * Get the latest audit log for this model.
     */
    public function latestAuditLog()
    {
        return $this->morphOne(AuditLog::class, 'auditable')->latest();
    }
}