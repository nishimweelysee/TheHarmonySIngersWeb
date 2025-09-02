<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_dashboard_with_permission()
    {
        // Create a role with dashboard permission
        $role = Role::create([
            'name' => 'test_role',
            'display_name' => 'Test Role',
            'description' => 'Test role for testing',
        ]);

        $permission = Permission::create([
            'name' => 'view_dashboard',
            'display_name' => 'View Dashboard',
            'module' => 'dashboard',
        ]);

        $role->permissions()->attach($permission);

        // Create a user with that role
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_user_cannot_access_dashboard_without_permission()
    {
        // Create a role without dashboard permission
        $role = Role::create([
            'name' => 'test_role',
            'display_name' => 'Test Role',
            'description' => 'Test role for testing',
        ]);

        // Create a user with that role
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_user_can_access_members_with_permission()
    {
        // Create a role with members permission
        $role = Role::create([
            'name' => 'test_role',
            'display_name' => 'Test Role',
            'description' => 'Test role for testing',
        ]);

        $permission = Permission::create([
            'name' => 'view_members',
            'display_name' => 'View Members',
            'module' => 'members',
        ]);

        $role->permissions()->attach($permission);

        // Create a user with that role
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);

        $response = $this->actingAs($user)->get('/admin/members');

        $response->assertStatus(200);
    }

    public function test_user_cannot_access_members_without_permission()
    {
        // Create a role without members permission
        $role = Role::create([
            'name' => 'test_role',
            'display_name' => 'Test Role',
            'description' => 'Test role for testing',
        ]);

        // Create a user with that role
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);

        $response = $this->actingAs($user)->get('/admin/members');

        $response->assertStatus(403);
    }
}
