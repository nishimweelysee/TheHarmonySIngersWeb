# Authorization System Guide

## Overview

The Harmony Singers Choir application now includes a comprehensive Role-Based Access Control (RBAC) system that allows you to control what users can see and do based on their assigned roles and permissions.

## System Components

### 1. Roles

-   **Administrator**: Full access to all features and settings
-   **Moderator**: Can manage content and moderate activities (no user management)
-   **Regular User**: Basic access to view content only

### 2. Permissions

Permissions are granular actions that can be performed:

-   `view_*`: Ability to view/list items
-   `create_*`: Ability to create new items
-   `edit_*`: Ability to edit existing items
-   `delete_*`: Ability to delete items
-   `manage_roles`: Ability to manage user roles and permissions

### 3. Modules

The system is organized into logical modules:

-   **Dashboard**: Main admin dashboard
-   **Members**: Member management
-   **Concerts**: Concert management
-   **Songs**: Song management
-   **Albums**: Album management
-   **Media**: Media file management
-   **Contributions**: Financial contribution management
-   **Sponsors**: Sponsor management
-   **Instruments**: Instrument management
-   **Plans**: Year plan management
-   **Users**: User and role management

## Usage Examples

### In Controllers

```php
// Check if user has a specific permission
if (auth()->user()->hasPermission('create_members')) {
    // User can create members
}

// Check if user has any of multiple permissions
if (auth()->user()->hasAnyPermission(['edit_members', 'delete_members'])) {
    // User can edit or delete members
}

// Check if user has all required permissions
if (auth()->user()->hasAllPermissions(['view_members', 'create_members'])) {
    // User can view and create members
}
```

### In Routes

```php
// Protect route with permission middleware
Route::middleware('permission:view_members')->group(function () {
    Route::get('/admin/members', [MemberController::class, 'index']);
});

// Protect route with role middleware
Route::middleware('role:admin')->group(function () {
    Route::get('/admin/settings', [SettingController::class, 'index']);
});
```

### In Blade Views

```blade
{{-- Show content only if user has permission --}}
@permission('create_members')
    <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
        Add New Member
    </a>
@endpermission

{{-- Show content only if user has role --}}
@role('admin')
    <div class="admin-only-content">
        This content is only visible to administrators.
    </div>
@endrole

{{-- Check multiple permissions --}}
@anyPermission(['edit_members', 'delete_members'])
    <div class="action-buttons">
        <button class="btn btn-edit">Edit</button>
        <button class="btn btn-delete">Delete</button>
    </div>
@endanyPermission
```

### Using Permission Components

```blade
{{-- Permission-based button component --}}
<x-permission-button permission="create_members" href="{{ route('admin.members.create') }}">
    <i class="fas fa-plus"></i> Add Member
</x-permission-button>

{{-- Permission-based danger button component --}}
<x-permission-danger-button permission="delete_members" type="submit">
    <i class="fas fa-trash"></i> Delete
</x-permission-danger-button>
```

## Adding New Permissions

To add new permissions:

1. **Create a migration** (if needed):

```bash
php artisan make:migration add_new_permission_to_permissions_table
```

2. **Add permission to the seeder** in `database/seeders/RolePermissionSeeder.php`:

```php
['name' => 'new_permission', 'display_name' => 'New Permission', 'module' => 'module_name']
```

3. **Assign to roles** in the seeder:

```php
$adminRole->permissions()->attach($newPermission);
$moderatorRole->permissions()->attach($newPermission);
```

4. **Run the seeder**:

```bash
php artisan db:seed --class=RolePermissionSeeder
```

## Adding New Roles

To add new roles:

1. **Add role to the seeder** in `database/seeders/RolePermissionSeeder.php`:

```php
[
    'name' => 'new_role',
    'display_name' => 'New Role',
    'description' => 'Description of the new role',
]
```

2. **Assign permissions** to the new role:

```php
$newRole = Role::where('name', 'new_role')->first();
$newRole->permissions()->attach($permissions);
```

3. **Run the seeder**:

```bash
php artisan db:seed --class=RolePermissionSeeder
```

## Security Best Practices

1. **Always check permissions** before allowing actions
2. **Use middleware** to protect routes at the application level
3. **Validate permissions** in controllers as a secondary check
4. **Use Blade directives** to hide UI elements from unauthorized users
5. **Regularly audit** user roles and permissions
6. **Follow the principle of least privilege** - only grant necessary permissions

## Testing

The system includes comprehensive tests in `tests/Feature/AuthorizationTest.php`. Run them with:

```bash
php artisan test --filter=AuthorizationTest
```

## Troubleshooting

### Common Issues

1. **Permission denied errors**: Check if the user has the required permission
2. **Menu items not showing**: Verify the user has the `view_*` permission for that module
3. **Actions not working**: Ensure the user has the appropriate `create_*`, `edit_*`, or `delete_*` permission

### Debugging

1. **Check user role**: `auth()->user()->role`
2. **Check permissions**: `auth()->user()->role->permissions`
3. **Verify middleware**: Check if routes are properly protected
4. **Check database**: Ensure roles and permissions are properly assigned

## Database Schema

The authorization system uses these tables:

-   `users`: User accounts with `role_id` foreign key
-   `roles`: Available roles in the system
-   `permissions`: Available permissions in the system
-   `role_permission`: Many-to-many relationship between roles and permissions

## Migration Commands

```bash
# Run migrations
php artisan migrate

# Rollback specific migration
php artisan migrate:rollback --step=1

# Reset and re-run all migrations
php artisan migrate:fresh --seed
```

## Seeder Commands

```bash
# Run specific seeder
php artisan db:seed --class=RolePermissionSeeder

# Run all seeders
php artisan db:seed

# Reset database and seed
php artisan migrate:fresh --seed
```
