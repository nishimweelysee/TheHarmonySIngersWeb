<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Auditable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'profile_photo',
        'phone',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role assigned to this user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user's inbox notifications.
     */
    public function inboxNotifications(): HasMany
    {
        return $this->hasMany(\App\Models\Notification::class, 'notifiable_id')
            ->where('notifiable_type', self::class);
    }

    /**
     * Check if the user has a specific permission.
     */
    public function hasPermission(string $permissionName): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->hasPermission($permissionName);
    }

    /**
     * Get audit logs for this user.
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(\App\Models\AuditLog::class, 'user_id');
    }

    /**
     * Check if the user has any permission from a list.
     */
    public function hasAnyPermission(array $permissionNames): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->hasAnyPermission($permissionNames);
    }

    /**
     * Check if the user has all permissions from a list.
     */
    public function hasAllPermissions(array $permissionNames): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->hasAllPermissions($permissionNames);
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\CustomVerifyEmailNotification());
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }



    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Check if the user has any role from a list.
     */
    public function hasAnyRole(array $roleNames): bool
    {
        return $this->role && in_array($this->role->name, $roleNames);
    }

    /**
     * Check if the user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if the user is a moderator.
     */
    public function isModerator(): bool
    {
        return $this->hasRole('moderator');
    }

    /**
     * Check if the user is a regular user.
     */
    public function isUser(): bool
    {
        return $this->hasRole('user');
    }
}
