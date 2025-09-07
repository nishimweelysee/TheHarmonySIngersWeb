@extends('layouts.admin')

@section('title', 'Permissions')
@section('page-title', 'Manage Permissions')

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
                <i class="fas fa-shield-alt"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Permissions Management</h2>
                <p class="header-subtitle">Manage system permissions and access controls</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $permissions->total() }}</span>
                        <span class="stat-label">Total Permissions</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $permissions->where('module', 'users')->count() }}</span>
                        <span class="stat-label">User Permissions</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $permissions->where('module', 'admin')->count() }}</span>
                        <span class="stat-label">Admin Permissions</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('create_permissions')
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Add New Permission</span>
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

        <form method="GET" action="{{ route('admin.permissions.index') }}" class="filters-form" id="filtersForm">
            <div class="filters-grid">
                <div class="search-group">
                    <div class="search-box enhanced-search">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search permissions by name or description..."
                            class="search-input enhanced-input">
                        <div class="search-glow"></div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-item">
                        <label class="filter-label">Module</label>
                        <select name="module" class="filter-select enhanced-select">
                            <option value="">All Modules</option>
                            <option value="users" {{ request('module') === 'users' ? 'selected' : '' }}>Users</option>
                            <option value="roles" {{ request('module') === 'roles' ? 'selected' : '' }}>Roles</option>
                            <option value="permissions" {{ request('module') === 'permissions' ? 'selected' : '' }}>Permissions</option>
                            <option value="members" {{ request('module') === 'members' ? 'selected' : '' }}>Members</option>
                            <option value="concerts" {{ request('module') === 'concerts' ? 'selected' : '' }}>Concerts</option>
                            <option value="songs" {{ request('module') === 'songs' ? 'selected' : '' }}>Songs</option>
                            <option value="media" {{ request('module') === 'media' ? 'selected' : '' }}>Media</option>
                            <option value="financial" {{ request('module') === 'financial' ? 'selected' : '' }}>Financial</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Action Type</label>
                        <select name="action" class="filter-select enhanced-select">
                            <option value="">All Actions</option>
                            <option value="view" {{ request('action') === 'view' ? 'selected' : '' }}>View</option>
                            <option value="create" {{ request('action') === 'create' ? 'selected' : '' }}>Create</option>
                            <option value="edit" {{ request('action') === 'edit' ? 'selected' : '' }}>Edit</option>
                            <option value="delete" {{ request('action') === 'delete' ? 'selected' : '' }}>Delete</option>
                            <option value="manage" {{ request('action') === 'manage' ? 'selected' : '' }}>Manage</option>
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary filter-btn">
                        <i class="fas fa-search"></i>
                        <span>Apply Filters</span>
                    </button>
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline clear-btn">
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
                Permissions Directory
            </h3>
            <div class="header-meta">
                <span class="results-count">{{ $permissions->count() }} of {{ $permissions->total() }} permissions</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($permissions->count() > 0)
        <div class="table-container">
            <table class="data-table enhanced-table">
                <thead>
                    <tr>
                        <th class="th-permission">Permission</th>
                        <th class="th-module">Module</th>
                        <th class="th-description">Description</th>
                        <th class="th-roles">Assigned Roles</th>
                        <th class="th-created">Created</th>
                        @permission('view_permissions')
                        <th class="th-actions">Actions</th>
                        @endpermission
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                    <tr class="permission-row">
                        <td data-label="Permission" class="td-info">
                            <div class="permission-info enhanced-info">
                                <div class="permission-name">{{ $permission->display_name }}</div>
                                <div class="permission-slug">{{ $permission->name }}</div>
                            </div>
                        </td>

                        <td data-label="Module" class="td-module">
                            <span class="module-badge enhanced-badge module-{{ $permission->module }}">
                                <i class="fas fa-cube"></i>
                                {{ ucfirst($permission->module) }}
                            </span>
                        </td>

                        <td data-label="Description" class="td-description">
                            @if($permission->description)
                            <div class="description-text">{{ Str::limit($permission->description, 60) }}</div>
                            @else
                            <span class="no-description">No description</span>
                            @endif
                        </td>

                        <td data-label="Assigned Roles" class="td-roles">
                            <div class="roles-count">
                                <span class="count-badge enhanced-badge">
                                    <i class="fas fa-user-tag"></i>
                                    {{ $permission->roles->count() }} roles
                                </span>
                            </div>
                        </td>

                        <td data-label="Created" class="td-created">
                            <div class="date-display">
                                <div class="date-icon">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div class="date-text">
                                    <span class="date-main">{{ $permission->created_at->format('M j, Y') }}</span>
                                    <span class="date-ago">{{ $permission->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </td>

                        @permission('view_permissions')
                        <td data-label="Actions" class="td-actions">
                            <div class="action-buttons enhanced-actions">
                                @permission('view_permissions')
                                <a href="{{ route('admin.permissions.show', $permission) }}"
                                    class="btn btn-sm btn-secondary action-btn" title="View Permission">
                                    <i class="fas fa-eye"></i>
                                    <span class="btn-tooltip">View</span>
                                </a>
                                @endpermission

                                @permission('edit_permissions')
                                <a href="{{ route('admin.permissions.edit', $permission) }}"
                                    class="btn btn-sm btn-primary action-btn" title="Edit Permission">
                                    <i class="fas fa-edit"></i>
                                    <span class="btn-tooltip">Edit</span>
                                </a>
                                @endpermission

                                @permission('delete_permissions')
                                <form method="POST" action="{{ route('admin.permissions.destroy', $permission) }}"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger action-btn delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this permission?')"
                                        title="Delete Permission">
                                        <i class="fas fa-trash"></i>
                                        <span class="btn-tooltip">Delete</span>
                                    </button>
                                </form>
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
            :paginator="$permissions"
            :show-per-page-selector="true"
            :per-page-options="[5, 10, 20, 50, 100]"
            :show-page-info="true"
            :show-jump-to-page="true"
            :max-visible-pages="7" />
        @else
        <div class="empty-state enhanced-empty-state">
            <div class="empty-icon">
                <i class="fas fa-shield-alt"></i>
                <div class="icon-pulse"></div>
            </div>
            <h3>No Permissions Found</h3>
            <p>Get started by creating your first permission to manage access controls.</p>
            <div class="empty-actions">
                @permission('create_permissions')
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Create Your First Permission
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