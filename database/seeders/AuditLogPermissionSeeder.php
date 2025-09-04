<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class AuditLogPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create audit log permissions
        $permissions = [
            [
                'name' => 'view_audit_logs',
                'display_name' => 'View Audit Logs',
                'description' => 'Can view audit logs and system activity',
                'module' => 'audit',
            ],
        ];

        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate(
                ['name' => $permissionData['name']],
                $permissionData
            );
        }

        // Assign audit log permission to admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $auditPermission = Permission::where('name', 'view_audit_logs')->first();
            if ($auditPermission && !$adminRole->permissions()->where('permission_id', $auditPermission->id)->exists()) {
                $adminRole->permissions()->attach($auditPermission->id);
            }
        }

        // Assign audit log permission to super admin role
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $auditPermission = Permission::where('name', 'view_audit_logs')->first();
            if ($auditPermission && !$superAdminRole->permissions()->where('permission_id', $auditPermission->id)->exists()) {
                $superAdminRole->permissions()->attach($auditPermission->id);
            }
        }
    }
}
