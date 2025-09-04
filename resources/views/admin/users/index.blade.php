@extends('layouts.admin')

@section('title', 'Users')
@section('page-title', 'Manage Users')
@section('page-icon', 'user-cog')

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

            <!-- Export Actions -->
            <div class="export-actions">
                <a href="{{ route('admin.users.export.excel', request()->query()) }}"
                    class="btn btn-success enhanced-btn"
                    title="Export to Excel">
                    <div class="btn-content">
                        <i class="fas fa-file-excel"></i>
                        <span>Excel</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>

                <a href="{{ route('admin.users.export.pdf', request()->query()) }}"
                    class="btn btn-danger enhanced-btn"
                    title="Export to PDF">
                    <div class="btn-content">
                        <i class="fas fa-file-pdf"></i>
                        <span>PDF</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
            </div>
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
                            placeholder="Search by name, email, or phone..." class="search-input enhanced-input">
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
                        <label class="filter-label">User Type</label>
                        <select name="user_type" class="filter-select enhanced-select">
                            <option value="">All Types</option>
                            <option value="admin" {{ request('user_type') === 'admin' ? 'selected' : '' }}>
                                Administrators</option>
                            <option value="user" {{ request('user_type') === 'user' ? 'selected' : '' }}>Regular Users
                            </option>
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
        <div class="table-container">
            <table class="data-table enhanced-table">
                <thead>
                    <tr>
                        <th class="th-name">Name & Contact</th>
                        <th class="th-role">Role</th>
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
                        <td data-label="Name & Contact" class="td-info">
                            <div class="member-info enhanced-info">
                                <div class="member-name">{{ $user->name }}</div>
                                <div class="member-email">{{ $user->email }}</div>
                                @if($user->phone)
                                <div class="member-phone">
                                    <i class="fas fa-phone"></i>
                                    {{ $user->phone }}
                                </div>
                                @endif
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

                        <td data-label="Joined" class="td-joined">
                            <div class="join-date">
                                <div class="date-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="date-text">
                                    <span class="date-day">{{ $user->created_at->format('M j') }}</span>
                                    <span class="date-year">{{ $user->created_at->format('Y') }}</span>
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

        <x-enhanced-pagination
            :paginator="$users"
            :show-per-page-selector="true"
            :per-page-options="[5, 10, 20, 50, 100]"
            :show-page-info="true"
            :show-jump-to-page="true"
            :max-visible-pages="7" />
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

<style>
    /* User Role Badge Styling */
    .role-admin {
        background: linear-gradient(135deg, #dc2626, #991b1b);
        color: white;
        border: 1px solid #991b1b;
    }

    .role-user {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        color: white;
        border: 1px solid #1e40af;
    }

    .role-admin:hover {
        background: linear-gradient(135deg, #991b1b, #7f1d1d);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    .role-user:hover {
        background: linear-gradient(135deg, #1e40af, #1e3a8a);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    /* Enhanced action buttons for users */
    .action-btn.user-specific {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        border-color: #1e40af;
    }

    .action-btn.user-specific:hover {
        background: linear-gradient(135deg, #1e40af, #1e3a8a);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }
</style>

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