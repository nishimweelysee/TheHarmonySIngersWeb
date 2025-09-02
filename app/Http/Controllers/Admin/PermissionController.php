<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * Display a listing of the permissions.
     */
    public function index(Request $request)
    {
        $query = Permission::with('roles');

        // Filter by module
        if ($request->filled('module')) {
            $query->where('module', strtolower($request->module));
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'Active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'Inactive') {
                $query->where('is_active', false);
            }
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

        $permissions = $query->orderBy('module')->orderBy('display_name')->paginate(20)->withQueryString();
        $modules = Permission::distinct()->pluck('module')->sort();

        return view('admin.permissions.index', compact('permissions', 'modules'));
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create()
    {
        $modules = Permission::distinct()->pluck('module')->sort();
        $roles = Role::active()->get();

        return view('admin.permissions.create', compact('modules', 'roles'));
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions'],
            'display_name' => ['required', 'string', 'max:255'],
            'module' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'roles' => ['array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        $permission = Permission::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'module' => $request->module,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);

        if ($request->has('roles')) {
            $permission->roles()->sync($request->roles);
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified permission.
     */
    public function show(Permission $permission)
    {
        $permission->load('roles');
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit(Permission $permission)
    {
        $modules = Permission::distinct()->pluck('module')->sort();
        $roles = Role::active()->get();

        return view('admin.permissions.edit', compact('permission', 'modules', 'roles'));
    }

    /**
     * Update the specified permission in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission->id)],
            'display_name' => ['required', 'string', 'max:255'],
            'module' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'roles' => ['array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        $permission->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'module' => $request->module,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);

        if ($request->has('roles')) {
            $permission->roles()->sync($request->roles);
        } else {
            $permission->roles()->detach();
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy(Permission $permission)
    {
        // Check if permission is assigned to any roles
        if ($permission->roles()->count() > 0) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'Cannot delete permission. It is assigned to one or more roles.');
        }

        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }

    /**
     * Toggle the active status of a permission.
     */
    public function toggleStatus(Permission $permission)
    {
        $permission->update(['is_active' => !$permission->is_active]);

        $status = $permission->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.permissions.index')
            ->with('success', "Permission {$status} successfully.");
    }

    /**
     * Show permissions by module.
     */
    public function byModule($module)
    {
        $permissions = Permission::where('module', $module)
            ->with('roles')
            ->orderBy('display_name')
            ->paginate(20);

        $modules = Permission::distinct()->pluck('module')->sort();

        return view('admin.permissions.by-module', compact('permissions', 'modules', 'module'));
    }
}
