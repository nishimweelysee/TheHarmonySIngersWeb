<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the permissions associated with this role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    /**
     * Get the users that have this role.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if the role has a specific permission.
     */
    public function hasPermission(string $permissionName): bool
    {
        return $this->permissions()->where('name', $permissionName)->exists();
    }

    /**
     * Check if the role has any permission from a list.
     */
    public function hasAnyPermission(array $permissionNames): bool
    {
        return $this->permissions()->whereIn('name', $permissionNames)->exists();
    }

    /**
     * Check if the role has all permissions from a list.
     */
    public function hasAllPermissions(array $permissionNames): bool
    {
        $permissionCount = $this->permissions()->whereIn('name', $permissionNames)->count();
        return $permissionCount === count($permissionNames);
    }

    /**
     * Scope to get only active roles.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
