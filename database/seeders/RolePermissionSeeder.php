<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions using updateOrCreate to avoid duplicates
        $permissions = [
            // Dashboard permissions
            ['name' => 'view_dashboard', 'display_name' => 'View Dashboard', 'module' => 'dashboard'],

            // Member permissions
            ['name' => 'view_members', 'display_name' => 'View Members', 'module' => 'members'],
            ['name' => 'create_members', 'display_name' => 'Create Members', 'module' => 'members'],
            ['name' => 'edit_members', 'display_name' => 'Edit Members', 'module' => 'members'],
            ['name' => 'delete_members', 'display_name' => 'Delete Members', 'module' => 'members'],
            ['name' => 'export_members', 'display_name' => 'Export Members', 'module' => 'members'],

            // Concert permissions
            ['name' => 'view_concerts', 'display_name' => 'View Concerts', 'module' => 'concerts'],
            ['name' => 'create_concerts', 'display_name' => 'Create Concerts', 'module' => 'concerts'],
            ['name' => 'edit_concerts', 'display_name' => 'Edit Concerts', 'module' => 'concerts'],
            ['name' => 'delete_concerts', 'display_name' => 'Delete Concerts', 'module' => 'concerts'],

            // Song permissions
            ['name' => 'view_songs', 'display_name' => 'View Songs', 'module' => 'songs'],
            ['name' => 'create_songs', 'display_name' => 'Create Songs', 'module' => 'songs'],
            ['name' => 'edit_songs', 'display_name' => 'Edit Songs', 'module' => 'songs'],
            ['name' => 'delete_songs', 'display_name' => 'Delete Songs', 'module' => 'songs'],

            // Album permissions
            ['name' => 'view_albums', 'display_name' => 'View Albums', 'module' => 'albums'],
            ['name' => 'create_albums', 'display_name' => 'Create Albums', 'module' => 'albums'],
            ['name' => 'edit_albums', 'display_name' => 'Edit Albums', 'module' => 'albums'],
            ['name' => 'delete_albums', 'display_name' => 'Delete Albums', 'module' => 'albums'],

            // Media permissions
            ['name' => 'view_media', 'display_name' => 'View Media', 'module' => 'media'],
            ['name' => 'upload_media', 'display_name' => 'Upload Media', 'module' => 'media'],
            ['name' => 'edit_media', 'display_name' => 'Edit Media', 'module' => 'media'],
            ['name' => 'delete_media', 'display_name' => 'Delete Media', 'module' => 'media'],

            // Contribution permissions
            ['name' => 'view_contributions', 'display_name' => 'View Contributions', 'module' => 'contributions'],
            ['name' => 'create_contributions', 'display_name' => 'Create Contributions', 'module' => 'contributions'],
            ['name' => 'edit_contributions', 'display_name' => 'Edit Contributions', 'module' => 'contributions'],
            ['name' => 'delete_contributions', 'display_name' => 'Delete Contributions', 'module' => 'contributions'],

            // Contribution Campaign permissions
            ['name' => 'view_contribution_campaigns', 'display_name' => 'View Contribution Campaigns', 'module' => 'contribution_campaigns'],
            ['name' => 'create_contribution_campaigns', 'display_name' => 'Create Contribution Campaigns', 'module' => 'contribution_campaigns'],
            ['name' => 'edit_contribution_campaigns', 'display_name' => 'Edit Contribution Campaigns', 'module' => 'contribution_campaigns'],
            ['name' => 'delete_contribution_campaigns', 'display_name' => 'Delete Contribution Campaigns', 'module' => 'contribution_campaigns'],
            ['name' => 'manage_campaign_contributions', 'display_name' => 'Manage Campaign Contributions', 'module' => 'contribution_campaigns'],

            // Sponsor permissions
            ['name' => 'view_sponsors', 'display_name' => 'View Sponsors', 'module' => 'sponsors'],
            ['name' => 'create_sponsors', 'display_name' => 'Create Sponsors', 'module' => 'sponsors'],
            ['name' => 'edit_sponsors', 'display_name' => 'Edit Sponsors', 'module' => 'sponsors'],
            ['name' => 'delete_sponsors', 'display_name' => 'Delete Sponsors', 'module' => 'sponsors'],

            // Instrument permissions
            ['name' => 'view_instruments', 'display_name' => 'View Instruments', 'module' => 'instruments'],
            ['name' => 'create_instruments', 'display_name' => 'Create Instruments', 'module' => 'instruments'],
            ['name' => 'edit_instruments', 'display_name' => 'Edit Instruments', 'module' => 'instruments'],
            ['name' => 'delete_instruments', 'display_name' => 'Delete Instruments', 'module' => 'instruments'],

            // Plan permissions
            ['name' => 'view_plans', 'display_name' => 'View Plans', 'module' => 'plans'],
            ['name' => 'create_plans', 'display_name' => 'Create Plans', 'module' => 'plans'],
            ['name' => 'edit_plans', 'display_name' => 'Edit Plans', 'module' => 'plans'],
            ['name' => 'delete_plans', 'display_name' => 'Delete Plans', 'module' => 'plans'],

            // Practice Session permissions
            ['name' => 'view_practice_sessions', 'display_name' => 'View Practice Sessions', 'module' => 'practice_sessions'],
            ['name' => 'create_practice_sessions', 'display_name' => 'Create Practice Sessions', 'module' => 'practice_sessions'],
            ['name' => 'edit_practice_sessions', 'display_name' => 'Edit Practice Sessions', 'module' => 'practice_sessions'],
            ['name' => 'delete_practice_sessions', 'display_name' => 'Delete Practice Sessions', 'module' => 'practice_sessions'],
            ['name' => 'manage_practice_attendance', 'display_name' => 'Manage Practice Attendance', 'module' => 'practice_sessions'],

            // User management permissions
            ['name' => 'view_users', 'display_name' => 'View Users', 'module' => 'users'],
            ['name' => 'create_users', 'display_name' => 'Create Users', 'module' => 'users'],
            ['name' => 'edit_users', 'display_name' => 'Edit Users', 'module' => 'users'],
            ['name' => 'delete_users', 'display_name' => 'Delete Users', 'module' => 'users'],
            ['name' => 'manage_roles', 'display_name' => 'Manage Roles', 'module' => 'users'],

            // Permission management permissions
            ['name' => 'view_permissions', 'display_name' => 'View Permissions', 'module' => 'permissions'],
            ['name' => 'create_permissions', 'display_name' => 'Create Permissions', 'module' => 'permissions'],
            ['name' => 'edit_permissions', 'display_name' => 'Edit Permissions', 'module' => 'permissions'],
            ['name' => 'delete_permissions', 'display_name' => 'Delete Permissions', 'module' => 'permissions'],

            // Notification permissions
            ['name' => 'send_notifications', 'display_name' => 'Send Notifications', 'module' => 'notifications'],

            // Accounting permissions
            ['name' => 'view_accounting', 'display_name' => 'View Accounting', 'module' => 'accounting'],
            ['name' => 'manage_chart_of_accounts', 'display_name' => 'Manage Chart of Accounts', 'module' => 'accounting'],
            ['name' => 'manage_expenses', 'display_name' => 'Manage Expenses', 'module' => 'accounting'],
            ['name' => 'view_financial_reports', 'display_name' => 'View Financial Reports', 'module' => 'accounting'],
            ['name' => 'export_financial_reports', 'display_name' => 'Export Financial Reports', 'module' => 'accounting'],
        ];

        foreach ($permissions as $permissionData) {
            Permission::updateOrCreate(
                ['name' => $permissionData['name']],
                $permissionData
            );
        }

        // Create roles using updateOrCreate to avoid duplicates
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Full access to all features and settings',
            ],
            [
                'name' => 'moderator',
                'display_name' => 'Moderator',
                'description' => 'Can manage content and moderate activities',
            ],
            [
                'name' => 'user',
                'display_name' => 'Regular User',
                'description' => 'Basic access to view content',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['name' => $roleData['name']],
                $roleData
            );
        }

        // Assign permissions to roles
        $adminRole = Role::where('name', 'admin')->first();
        $moderatorRole = Role::where('name', 'moderator')->first();
        $userRole = Role::where('name', 'user')->first();

        // Admin gets all permissions
        $adminRole->permissions()->sync(Permission::pluck('id'));

        // Moderator gets most permissions except user management
        $moderatorPermissions = Permission::whereNotIn('name', [
            'manage_roles',
            'create_users',
            'edit_users',
            'delete_users'
        ])->pluck('id');
        $moderatorRole->permissions()->sync($moderatorPermissions);

        // User gets only view permissions
        $userPermissions = Permission::whereIn('name', [
            'view_dashboard',
            'view_members',
            'view_concerts',
            'view_songs',
            'view_albums',
            'view_media',
            'view_contributions',
            'view_contribution_campaigns',
            'view_sponsors',
            'view_instruments',
            'view_plans',
            'view_practice_sessions',
            'view_accounting',
            'manage_chart_of_accounts',
            'manage_expenses',
            'view_financial_reports'
        ])->pluck('id');
        $userRole->permissions()->sync($userPermissions);

        // Assign admin role to existing users (if any)
        $existingUsers = User::whereNull('role_id')->get();
        foreach ($existingUsers as $user) {
            $user->update(['role_id' => $adminRole->id]);
        }
    }
}
