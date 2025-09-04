@extends('layouts.admin')

@section('title', 'Permissions by Module')
@section('page-title', 'Permissions by Module')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header permissions-module-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-cube"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">{{ ucfirst($module) }} Module Permissions</h2>
                <p class="header-subtitle">Manage permissions for the {{ ucfirst($module) }} module</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $permissions->count() }}</span>
                        <span class="stat-label">Total Permissions</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $permissions->where('is_active', true)->count() }}</span>
                        <span class="stat-label">Active</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $permissions->where('is_active', false)->count() }}</span>
                        <span class="stat-label">Inactive</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('manage_roles')
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Create Permission</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to All Permissions</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Content Card -->
<div class="content-card enhanced-card">
    <!-- Module Navigation -->
    <div class="module-navigation enhanced-navigation">
        <div class="navigation-header">
            <h3 class="navigation-title">
                <i class="fas fa-sitemap"></i>
                Module Navigation
            </h3>
            <p class="navigation-subtitle">Switch between different modules to manage their permissions</p>
        </div>
        <div class="module-tabs">
            <a href="{{ route('admin.permissions.index') }}" class="module-tab {{ $module === 'all' ? 'active' : '' }}">
                <i class="fas fa-globe"></i>
                <span>All Modules</span>
            </a>
            @foreach($modules as $moduleName)
            <a href="{{ route('admin.permissions.by-module', $moduleName) }}"
                class="module-tab {{ $moduleName === $module ? 'active' : '' }}">
                <i class="fas fa-cube"></i>
                <span>{{ ucfirst($moduleName) }}</span>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Search and Filters Section -->
    <div class="search-filters-section enhanced-filters">
        <div class="filters-header">
            <h4 class="filters-title">
                <i class="fas fa-filter"></i>
                Search & Filters
            </h4>
            <button class="filters-toggle" onclick="toggleFilters()">
                <i class="fas fa-chevron-down"></i>
                <span>Toggle Filters</span>
            </button>
        </div>

        <div class="filters-content" id="filtersContent">
            <div class="filters-grid">
                <div class="filter-group">
                    <label for="search" class="filter-label">
                        <i class="fas fa-search"></i>
                        Search Permissions
                    </label>
                    <input type="text" id="search" class="filter-input enhanced-input"
                        placeholder="Search {{ $module }} permissions...">
                    <div class="input-glow"></div>
                </div>

                <div class="filter-group">
                    <label for="statusFilter" class="filter-label">
                        <i class="fas fa-toggle-on"></i>
                        Status Filter
                    </label>
                    <select id="statusFilter" class="filter-select enhanced-select">
                        <option value="">All Status</option>
                        <option value="active">Active Only</option>
                        <option value="inactive">Inactive Only</option>
                    </select>
                    <div class="select-glow"></div>
                </div>

                <div class="filter-group">
                    <label for="actionFilter" class="filter-label">
                        <i class="fas fa-bolt"></i>
                        Action Filter
                    </label>
                    <select id="actionFilter" class="filter-select enhanced-select">
                        <option value="">All Actions</option>
                        <option value="view">View</option>
                        <option value="create">Create</option>
                        <option value="edit">Edit</option>
                        <option value="delete">Delete</option>
                        <option value="manage">Manage</option>
                    </select>
                    <div class="select-glow"></div>
                </div>

                <div class="filter-group">
                    <label for="roleFilter" class="filter-label">
                        <i class="fas fa-users"></i>
                        Role Assignment
                    </label>
                    <select id="roleFilter" class="filter-select enhanced-select">
                        <option value="">All Permissions</option>
                        <option value="assigned">Assigned to Roles</option>
                        <option value="unassigned">Not Assigned</option>
                    </select>
                    <div class="select-glow"></div>
                </div>
            </div>

            <div class="filter-actions">
                <button type="button" class="btn btn-secondary filter-btn" onclick="clearFilters()">
                    <i class="fas fa-times"></i>
                    <span>Clear Filters</span>
                </button>
                <button type="button" class="btn btn-primary filter-btn" onclick="applyFilters()">
                    <i class="fas fa-check"></i>
                    <span>Apply Filters</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Enhanced Table -->
    <div class="table-container">
        @if($permissions->count() > 0)
        <table class="data-table enhanced-table">
            <thead>
                <tr>
                    <th class="th-permission">
                        <i class="fas fa-shield-alt"></i>
                        Permission
                    </th>
                    <th class="th-description">
                        <i class="fas fa-align-left"></i>
                        Description
                    </th>
                    <th class="th-action">
                        <i class="fas fa-bolt"></i>
                        Action
                    </th>
                    <th class="th-roles">
                        <i class="fas fa-users"></i>
                        Assigned Roles
                    </th>
                    <th class="th-status">
                        <i class="fas fa-toggle-on"></i>
                        Status
                    </th>
                    @permission('manage_roles')
                    <th class="th-actions">
                        <i class="fas fa-cogs"></i>
                        Actions
                    </th>
                    @endpermission
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                <tr class="table-row enhanced-row" data-permission="{{ $permission->id }}">
                    <td data-label="Permission">
                        <div class="permission-info">
                            <div class="permission-name">{{ $permission->display_name }}</div>
                            <div class="permission-slug">{{ $permission->name }}</div>
                        </div>
                    </td>
                    <td data-label="Description">
                        <div class="permission-description">
                            {{ Str::limit($permission->description ?? 'No description provided', 60) }}
                        </div>
                    </td>
                    <td data-label="Action">
                        <div class="action-badge enhanced-badge">
                            <i class="fas fa-arrow-right"></i>
                            {{ ucfirst($permission->action ?? 'N/A') }}
                        </div>
                    </td>
                    <td data-label="Assigned Roles">
                        <div class="roles-list">
                            @forelse($permission->roles->take(3) as $role)
                            <span class="role-badge enhanced-badge">
                                <i class="fas fa-user-tag"></i>
                                {{ $role->display_name }}
                            </span>
                            @empty
                            <span class="no-roles">No roles assigned</span>
                            @endforelse
                            @if($permission->roles->count() > 3)
                            <span class="more-roles-badge enhanced-badge">
                                <i class="fas fa-plus"></i>
                                +{{ $permission->roles->count() - 3 }} more
                            </span>
                            @endif
                        </div>
                    </td>
                    <td data-label="Status">
                        @if($permission->is_active)
                        <span class="status-badge enhanced-badge active">
                            <div class="status-dot"></div>
                            Active
                        </span>
                        @else
                        <span class="status-badge enhanced-badge inactive">
                            <div class="status-dot"></div>
                            Inactive
                        </span>
                        @endif
                    </td>
                    @permission('manage_roles')
                    <td data-label="Actions">
                        <div class="action-buttons enhanced-actions">
                            <a href="{{ route('admin.permissions.show', $permission) }}"
                                class="btn btn-sm btn-info action-btn" title="View Permission">
                                <i class="fas fa-eye"></i>
                                <span>View</span>
                            </a>
                            <a href="{{ route('admin.permissions.edit', $permission) }}"
                                class="btn btn-sm btn-primary action-btn" title="Edit Permission">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </a>
                        </div>
                    </td>
                    @endpermission
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Enhanced Pagination -->
        @if($permissions->hasPages())
        <div class="pagination-wrapper enhanced-pagination">
            {{ $permissions->links() }}
        </div>
        @endif

        <!-- Results Summary -->
        <div class="results-summary">
            <div class="summary-stats">
                <span class="stat-item">
                    <i class="fas fa-list"></i>
                    Showing {{ $permissions->firstItem() ?? 0 }} to {{ $permissions->lastItem() ?? 0 }} of
                    {{ $permissions->total() }} permissions
                </span>
                <span class="stat-item">
                    <i class="fas fa-clock"></i>
                    Page {{ $permissions->currentPage() }} of {{ $permissions->lastPage() }}
                </span>
            </div>
        </div>

        @else
        <!-- Enhanced Empty State -->
        <div class="empty-state enhanced-empty-state">
            <div class="empty-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h3>No Permissions Found</h3>
            <p>No permissions were found for the {{ ucfirst($module) }} module with the current filters.</p>
            <div class="empty-actions">
                @permission('manage_roles')
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    <span>Create First Permission</span>
                </a>
                @endpermission
                <button class="btn btn-secondary" onclick="clearFilters()">
                    <i class="fas fa-times"></i>
                    <span>Clear Filters</span>
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Toggle filters section
    function toggleFilters() {
        const filtersContent = document.getElementById('filtersContent');
        const toggleBtn = document.querySelector('.filters-toggle i');

        if (filtersContent.style.display === 'none' || filtersContent.style.display === '') {
            filtersContent.style.display = 'block';
            toggleBtn.className = 'fas fa-chevron-up';
        } else {
            filtersContent.style.display = 'none';
            toggleBtn.className = 'fas fa-chevron-down';
        }
    }

    // Apply filters
    function applyFilters() {
        const searchTerm = document.getElementById('search').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const actionFilter = document.getElementById('actionFilter').value;
        const roleFilter = document.getElementById('roleFilter').value;

        const rows = document.querySelectorAll('.table-row');

        rows.forEach(row => {
            let showRow = true;

            // Search filter
            if (searchTerm) {
                const permissionName = row.querySelector('.permission-name').textContent.toLowerCase();
                const permissionSlug = row.querySelector('.permission-slug').textContent.toLowerCase();
                const description = row.querySelector('.permission-description').textContent.toLowerCase();

                if (!permissionName.includes(searchTerm) &&
                    !permissionSlug.includes(searchTerm) &&
                    !description.includes(searchTerm)) {
                    showRow = false;
                }
            }

            // Status filter
            if (statusFilter) {
                const status = row.querySelector('.status-badge').textContent.trim().toLowerCase();
                if (status !== statusFilter) {
                    showRow = false;
                }
            }

            // Action filter
            if (actionFilter) {
                const action = row.querySelector('.action-badge').textContent.trim().toLowerCase();
                if (action !== actionFilter) {
                    showRow = false;
                }
            }

            // Role assignment filter
            if (roleFilter) {
                const hasRoles = row.querySelector('.no-roles') === null;
                if (roleFilter === 'assigned' && !hasRoles) {
                    showRow = false;
                } else if (roleFilter === 'unassigned' && hasRoles) {
                    showRow = false;
                }
            }

            row.style.display = showRow ? 'table-row' : 'none';
        });

        updateResultsCount();
    }

    // Clear all filters
    function clearFilters() {
        document.getElementById('search').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('actionFilter').value = '';
        document.getElementById('roleFilter').value = '';

        // Show all rows
        document.querySelectorAll('.table-row').forEach(row => {
            row.style.display = 'table-row';
        });

        updateResultsCount();
    }

    // Update results count
    function updateResultsCount() {
        const visibleRows = document.querySelectorAll('.table-row[style="table-row"], .table-row:not([style])').length;
        const totalRows = document.querySelectorAll('.table-row').length;

        // Update summary if it exists
        const summary = document.querySelector('.results-summary .stat-item:first-child');
        if (summary) {
            summary.innerHTML = `<i class="fas fa-list"></i> Showing ${visibleRows} of ${totalRows} permissions`;
        }
    }

    // Initialize filters on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Set filters to collapsed by default
        document.getElementById('filtersContent').style.display = 'none';

        // Add event listeners for real-time filtering
        document.getElementById('search').addEventListener('input', applyFilters);
        document.getElementById('statusFilter').addEventListener('change', applyFilters);
        document.getElementById('actionFilter').addEventListener('change', applyFilters);
        document.getElementById('roleFilter').addEventListener('change', applyFilters);

        // Add hover effects to table rows
        document.querySelectorAll('.table-row').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(59, 130, 246, 0.05)';
            });

            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    });
</script>
@endpush