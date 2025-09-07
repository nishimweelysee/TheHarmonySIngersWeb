@extends('layouts.admin')

@section('title', 'Roles')
@section('page-title', 'Manage Roles')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-user-tag"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Roles Management</h2>
                <p class="header-subtitle">Manage user roles and permissions with ease</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $roles->total() }}</span>
                        <span class="stat-label">Total Roles</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $roles->where('name', 'admin')->count() }}</span>
                        <span class="stat-label">Admin Roles</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $roles->where('name', 'user')->count() }}</span>
                        <span class="stat-label">User Roles</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('manage_roles')
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Add New Role</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
        </div>
    </div>
</div>

<!-- Enhanced Search and Filters -->
<div class="search-filters-section">
    <div class="filters-card">
        <div class="filters-header">
            <h3 class="filters-title">
                <i class="fas fa-filter"></i>
                Search & Filters
            </h3>
            <div class="filters-toggle">
                <button class="toggle-btn" onclick="toggleFilters()">
                    <i class="fas fa-chevron-down"></i>
                    <span>Show Filters</span>
                </button>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.roles.index') }}" class="filters-form" id="filtersForm">
            <div class="filters-grid">
                <div class="search-group">
                    <div class="search-box enhanced-search">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search roles by name or description..." class="search-input enhanced-input">
                        <div class="search-glow"></div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-item">
                        <label class="filter-label">Role Type</label>
                        <select name="type" class="filter-select enhanced-select">
                            <option value="">All Types</option>
                            <option value="admin" {{ request('type') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ request('type') === 'user' ? 'selected' : '' }}>User</option>
                            <option value="moderator" {{ request('type') === 'moderator' ? 'selected' : '' }}>Moderator
                            </option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Status</label>
                        <select name="status" class="filter-select enhanced-select">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary filter-btn">
                        <i class="fas fa-search"></i>
                        <span>Apply Filters</span>
                    </button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline clear-btn">
                        <i class="fas fa-times"></i>
                        <span>Clear All</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Enhanced Content Card -->
<div class="content-card enhanced-card">
    <div class="card-header enhanced-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-list"></i>
                Roles Directory
            </h3>
            <div class="header-meta">
                <span class="results-count">{{ $roles->count() }} of {{ $roles->total() }} roles</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($roles->count() > 0)
        <div class="table-container">
            <table class="data-table enhanced-table">
                <thead>
                    <tr>
                        <th class="th-role">Role</th>
                        <th class="th-description">Description</th>
                        <th class="th-permissions">Permissions</th>
                        <th class="th-users">Users</th>
                        <th class="th-created">Created</th>
                        @permission('view_roles')
                        <th class="th-actions">Actions</th>
                        @endpermission
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr class="role-row">
                        <td data-label="Role" class="td-info">
                            <div class="role-info enhanced-info">
                                <div class="role-name">{{ $role->display_name }}</div>
                                <div class="role-slug">{{ $role->name }}</div>
                            </div>
                        </td>

                        <td data-label="Description" class="td-description">
                            @if($role->description)
                            <div class="description-text">{{ Str::limit($role->description, 60) }}</div>
                            @else
                            <span class="no-description">No description</span>
                            @endif
                        </td>

                        <td data-label="Permissions" class="td-permissions">
                            <div class="permissions-count">
                                <span class="count-badge enhanced-badge">
                                    <i class="fas fa-shield-alt"></i>
                                    {{ $role->permissions->count() }} permissions
                                </span>
                            </div>
                        </td>

                        <td data-label="Users" class="td-users">
                            <div class="users-count">
                                <span class="count-badge enhanced-badge">
                                    <i class="fas fa-users"></i>
                                    {{ $role->users->count() }} users
                                </span>
                            </div>
                        </td>

                        <td data-label="Created" class="td-created">
                            <div class="date-display">
                                <div class="date-icon">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div class="date-text">
                                    <span class="date-main">{{ $role->created_at->format('M j, Y') }}</span>
                                    <span class="date-ago">{{ $role->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </td>

                        @permission('view_roles')
                        <td data-label="Actions" class="td-actions">
                            <div class="action-buttons enhanced-actions">
                                @permission('view_roles')
                                <a href="{{ route('admin.roles.show', $role) }}"
                                    class="btn btn-sm btn-secondary action-btn" title="View Role">
                                    <i class="fas fa-eye"></i>
                                    <span class="btn-tooltip">View</span>
                                </a>
                                @endpermission

                                @permission('edit_roles')
                                <a href="{{ route('admin.roles.edit', $role) }}"
                                    class="btn btn-sm btn-primary action-btn" title="Edit Role">
                                    <i class="fas fa-edit"></i>
                                    <span class="btn-tooltip">Edit</span>
                                </a>
                                @endpermission

                                @permission('delete_roles')
                                @if($role->name !== 'admin' && $role->name !== 'user')
                                <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger action-btn delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this role?')"
                                        title="Delete Role">
                                        <i class="fas fa-trash"></i>
                                        <span class="btn-tooltip">Delete</span>
                                    </button>
                                </form>
                                @endif
                                @endpermission
                            </div>
                        </td>
                        @endpermission
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-enhanced-pagination
            :paginator="$roles"
            :show-per-page-selector="true"
            :per-page-options="[5, 10, 20, 50, 100]"
            :show-page-info="true"
            :show-jump-to-page="true"
            :max-visible-pages="7" />
        @else
        <div class="empty-state enhanced-empty-state">
            <div class="empty-icon">
                <i class="fas fa-user-tag"></i>
                <div class="icon-pulse"></div>
            </div>
            <h3>No Roles Found</h3>
            <p>Get started by creating your first role to manage user permissions.</p>
            <div class="empty-actions">
                @permission('manage_roles')
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Create Your First Role
                </a>
                @endpermission
                <button class="btn btn-outline refresh-btn" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i>
                    Refresh
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    function toggleFilters() {
        const form = document.getElementById('filtersForm');
        const toggleBtn = document.querySelector('.toggle-btn');
        const icon = toggleBtn.querySelector('i');
        const text = toggleBtn.querySelector('span');

        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'block';
            icon.className = 'fas fa-chevron-up';
            text.textContent = 'Hide Filters';
            toggleBtn.classList.add('active');
        } else {
            form.style.display = 'none';
            icon.className = 'fas fa-chevron-down';
            text.textContent = 'Show Filters';
            toggleBtn.classList.remove('active');
        }
    }

    // Initialize filters as hidden by default
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filtersForm');
        form.style.display = 'none';
    });
</script>

@endsection