<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index(Request $request)
    {
        $query = Role::with('permissions');

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'Active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'Inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('name', 'like', "%" . strtolower($request->type) . "%");
        }

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('display_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $roles = $query->orderBy('name', 'asc')->paginate(20)->withQueryString();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::active()->orderBy('module')->orderBy('display_name')->get();
        $modules = Permission::active()->distinct()->pluck('module')->sort();

        return view('admin.roles.create', compact('permissions', 'modules'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
            'display_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role)
    {
        $role->load('permissions', 'users');
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::active()->orderBy('module')->orderBy('display_name')->get();
        $modules = Permission::active()->distinct()->pluck('module')->sort();

        return view('admin.roles.edit', compact('role', 'permissions', 'modules'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'display_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        } else {
            $role->permissions()->detach();
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        // Check if role is assigned to any users
        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete role. It is assigned to one or more users.');
        }

        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    /**
     * Toggle the active status of a role.
     */
    public function toggleStatus(Role $role)
    {
        $role->update(['is_active' => !$role->is_active]);

        $status = $role->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.roles.index')
            ->with('success', "Role {$status} successfully.");
    }
}