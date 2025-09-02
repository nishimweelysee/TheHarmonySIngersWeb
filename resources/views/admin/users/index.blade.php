@extends('layouts.admin')

@section('title', 'Users')
@section('page-title', 'Manage Users')

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
                <i class="fas fa-users"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Users Management</h2>
                <p class="header-subtitle">Manage system users and their roles with ease</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $users->total() }}</span>
                        <span class="stat-label">Total Users</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $users->where('role.name', 'admin')->count() }}</span>
                        <span class="stat-label">Admins</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $users->where('role.name', 'user')->count() }}</span>
                        <span class="stat-label">Regular Users</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('create_users')
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Add New User</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
        </div>
    </div>
</div>

<!-- Enhanced Role Statistics Overview -->
<div class="role-stats-overview enhanced-role-stats">
    <div class="stat-item enhanced-stat-item">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <span class="stat-number">{{ $users->total() }}</span>
            <span class="stat-label">Total Users</span>
        </div>
    </div>
    <div class="stat-item enhanced-stat-item">
        <div class="stat-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="stat-content">
            <span class="stat-number">{{ $users->where('role.name', 'admin')->count() }}</span>
            <span class="stat-label">Administrators</span>
        </div>
    </div>
    <div class="stat-item enhanced-stat-item">
        <div class="stat-icon">
            <i class="fas fa-user"></i>
        </div>
        <div class="stat-content">
            <span class="stat-number">{{ $users->where('role.name', 'user')->count() }}</span>
            <span class="stat-label">Regular Users</span>
        </div>
    </div>
    <div class="stat-item enhanced-stat-item">
        <div class="stat-icon">
            <i class="fas fa-user-tag"></i>
        </div>
        <div class="stat-content">
            <span class="stat-number">{{ $users->whereNotNull('role_id')->count() }}</span>
            <span class="stat-label">Users with Roles</span>
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

        <form method="GET" action="{{ route('admin.users.index') }}" class="filters-form" id="filtersForm">
            <div class="filters-grid">
                <div class="search-group">
                    <div class="search-box enhanced-search">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search users by name, email, or phone..." class="search-input enhanced-input">
                        <div class="search-glow"></div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-item">
                        <label class="filter-label">Role</label>
                        <select name="role" class="filter-select enhanced-select">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Status</label>
                        <select name="status" class="filter-select enhanced-select">
                            <option value="">All Status</option>
                            <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary filter-btn">
                        <i class="fas fa-search"></i>
                        <span>Apply Filters</span>
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline clear-btn">
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
                Users Directory
            </h3>
            <div class="header-meta">
                <span class="results-count">{{ $users->count() }} of {{ $users->total() }} users</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($users->count() > 0)
        <div class="table-container enhanced-table">
            <table class="data-table enhanced-table">
                <thead>
                    <tr>
                        <th class="th-user">User</th>
                        <th class="th-email">Email</th>
                        <th class="th-role">Role</th>
                        <th class="th-phone">Phone</th>
                        <th class="th-joined">Joined</th>
                        <th class="th-status">Status</th>
                        @permission('view_users')
                        <th class="th-actions">Actions</th>
                        @endpermission
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="user-row">
                        <td data-label="User" class="td-info">
                            <div class="user-info enhanced-info">
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-id">ID: {{ $user->id }}</div>
                            </div>
                        </td>

                        <td data-label="Email" class="td-email">
                            <div class="email-display">
                                <i class="fas fa-envelope"></i>
                                {{ $user->email }}
                            </div>
                        </td>

                        <td data-label="Role" class="td-role">
                            @if($user->role)
                            <span class="role-badge enhanced-badge role-{{ $user->role->name }}">
                                <i class="fas fa-user-tag"></i>
                                {{ $user->role->display_name }}
                            </span>
                            @else
                            <span class="no-role">No Role</span>
                            @endif
                        </td>

                        <td data-label="Phone" class="td-phone">
                            @if($user->phone)
                            <div class="phone-display">
                                <i class="fas fa-phone"></i>
                                {{ $user->phone }}
                            </div>
                            @else
                            <span class="no-phone">-</span>
                            @endif
                        </td>

                        <td data-label="Joined" class="td-joined">
                            <div class="date-display">
                                <div class="date-icon">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div class="date-text">
                                    <span class="date-main">{{ $user->created_at->format('M j, Y') }}</span>
                                    <span class="date-ago">{{ $user->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </td>

                        <td data-label="Status" class="td-status">
                            <span class="status-badge enhanced-badge active">
                                <div class="status-dot"></div>
                                Active
                            </span>
                        </td>

                        @permission('view_users')
                        <td data-label="Actions" class="td-actions">
                            <div class="action-buttons enhanced-actions">
                                @permission('view_users')
                                <a href="{{ route('admin.users.show', $user) }}"
                                    class="btn btn-sm btn-secondary action-btn" title="View User">
                                    <i class="fas fa-eye"></i>
                                    <span class="btn-tooltip">View</span>
                                </a>
                                @endpermission

                                @permission('edit_users')
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="btn btn-sm btn-primary action-btn" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                    <span class="btn-tooltip">Edit</span>
                                </a>
                                @endpermission

                                @permission('edit_users')
                                <a href="{{ route('admin.users.edit-role', $user) }}"
                                    class="btn btn-sm btn-info action-btn" title="Edit Role">
                                    <i class="fas fa-user-tag"></i>
                                    <span class="btn-tooltip">Role</span>
                                </a>
                                @endpermission

                                @permission('delete_users')
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger action-btn delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this user?')"
                                        title="Delete User">
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

        <!-- Enhanced Role Summary Statistics -->
        <div class="role-summary-section">
            <div class="summary-header">
                <h4 class="summary-title">
                    <i class="fas fa-chart-pie"></i>
                    Role Distribution Summary
                </h4>
            </div>
            <div class="summary-grid">
                @foreach($roles as $role)
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-user-tag"></i>
                    </div>
                    <div class="summary-content">
                        <span class="summary-role-name">{{ $role->display_name }}</span>
                        <span class="summary-role-count">{{ $users->where('role_id', $role->id)->count() }} users</span>
                        <span class="summary-role-percentage">
                            {{ $users->total() > 0 ? round(($users->where('role_id', $role->id)->count() / $users->total()) * 100, 1) : 0 }}%
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="pagination-wrapper enhanced-pagination">
            {{ $users->links() }}
        </div>
        @else
        <div class="empty-state enhanced-empty-state">
            <div class="empty-icon">
                <i class="fas fa-users"></i>
                <div class="icon-pulse"></div>
            </div>
            <h3>No Users Found</h3>
            <p>Get started by adding your first user to the system.</p>
            <div class="empty-actions">
                @permission('create_users')
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Your First User
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