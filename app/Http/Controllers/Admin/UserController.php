<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Services\UserExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::with('role');

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role_id', $request->role);
        }

        // Filter by status (active/inactive based on role)
        if ($request->filled('status')) {
            if ($request->status === 'Active') {
                $query->whereHas('role', function ($q) {
                    $q->where('is_active', true);
                });
            } elseif ($request->status === 'Inactive') {
                $query->whereHas('role', function ($q) {
                    $q->where('is_active', false);
                });
            }
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 10);
        $users = $query->orderBy('name', 'asc')->paginate($perPage)->withQueryString();
        $roles = Role::active()->orderBy('display_name', 'asc')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::active()->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::active()->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->getKey() === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Show the form for editing user roles and permissions.
     */
    public function editRole(User $user)
    {
        $roles = Role::active()->get();
        $permissions = Permission::active()->get();

        return view('admin.users.edit-role', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update user role and permissions.
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user->update([
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User role updated successfully.');
    }

    /**
     * Export users to Excel
     */
    public function exportExcel(Request $request)
    {
        $exportService = new UserExportService();
        return $exportService->exportToExcel($request);
    }

    /**
     * Export users to PDF
     */
    public function exportPdf(Request $request)
    {
        $exportService = new UserExportService();
        return $exportService->exportToPdf($request);
    }
}
