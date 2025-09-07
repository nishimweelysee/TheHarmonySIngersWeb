@extends('layouts.admin')

@section('title', 'Audit Logs')
@section('page-title', 'Audit Logs')

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
                <i class="fas fa-clipboard-list"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Audit Logs</h2>
                <p class="header-subtitle">Track all user activities and system changes</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $auditLogs->total() }}</span>
                        <span class="stat-label">Total Logs</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $auditLogs->where('created_at', '>=', today())->count() }}</span>
                        <span class="stat-label">Today</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $auditLogs->where('user_id', '!=', null)->count() }}</span>
                        <span class="stat-label">User Actions</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <div class="export-buttons">
                <a href="{{ route('admin.audit-logs.export.excel', request()->query()) }}" class="btn btn-success enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-file-excel"></i>
                        <span>Export Excel</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
                <a href="{{ route('admin.audit-logs.export.pdf', request()->query()) }}" class="btn btn-danger enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-file-pdf"></i>
                        <span>Export PDF</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
            </div>
            <a href="{{ route('admin.audit-logs.statistics') }}" class="btn btn-info enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-chart-bar"></i>
                    <span>Statistics</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Search and Filters -->
<div class="search-filters-section">
    <div class="filters-card enhanced-card">
        <div class="filters-header">
            <h3 class="filters-title">
                <i class="fas fa-filter"></i>
                Search & Filters
            </h3>
            <div class="filters-toggle">
                <button class="toggle-btn enhanced-btn" onclick="toggleFilters()">
                    <i class="fas fa-chevron-down"></i>
                    <span>Show Filters</span>
                </button>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="filters-form" id="filtersForm">
            <div class="filters-grid">
                <div class="search-group">
                    <div class="search-box enhanced-search">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search logs..."
                            class="search-input enhanced-input">
                        <div class="search-glow"></div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-item">
                        <label class="filter-label">Event Type</label>
                        <select name="event" class="filter-select enhanced-select">
                            <option value="">All Events</option>
                            @foreach($events as $event)
                            <option value="{{ $event }}" {{ request('event') === $event ? 'selected' : '' }}>
                                {{ ucfirst($event) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">User</label>
                        <select name="user_id" class="filter-select enhanced-select">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Model Type</label>
                        <select name="auditable_type" class="filter-select enhanced-select">
                            <option value="">All Models</option>
                            @foreach($auditableTypes as $type)
                            <option value="{{ $type }}" {{ request('auditable_type') === $type ? 'selected' : '' }}>
                                {{ class_basename($type) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Date From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="filter-input enhanced-input">
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Date To</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="filter-input enhanced-input">
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary filter-btn enhanced-btn">
                        <i class="fas fa-search"></i>
                        <span>Apply Filters</span>
                    </button>
                    <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline clear-btn enhanced-btn">
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
                Audit Logs Directory
            </h3>
            <div class="header-meta">
                <span class="results-count">{{ $auditLogs->count() }} of {{ $auditLogs->total() }} logs</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($auditLogs->count() > 0)
        <div class="table-container">
            <table class="data-table enhanced-table audit-logs-table">
                <thead>
                    <tr>
                        <th class="th-event">Event</th>
                        <th class="th-user-name">User Name</th>
                        <th class="th-user-email">User Email</th>
                        <th class="th-model">Model</th>
                        <th class="th-ip">IP Address</th>
                        <th class="th-datetime">Date & Time</th>
                        <th class="th-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($auditLogs as $log)
                    <tr class="audit-row">
                        <td data-label="Event" class="td-event">
                            <span class="event-badge enhanced-badge event-{{ $log->event }}">
                                {{ ucfirst($log->event) }}
                            </span>
                        </td>

                        <td data-label="User Name" class="td-user-name">
                            @if($log->user)
                            <div class="user-name">{{ $log->user->name }}</div>
                            @else
                            <div class="user-name">System</div>
                            @endif
                        </td>

                        <td data-label="User Email" class="td-user-email">
                            @if($log->user)
                            <div class="user-email">{{ $log->user->email }}</div>
                            @else
                            <div class="user-email">Automated Action</div>
                            @endif
                        </td>

                        <td data-label="Model" class="td-model">
                            @if($log->auditable_type)
                            <span class="model-badge enhanced-badge">
                                {{ class_basename($log->auditable_type) }}
                                @if($log->auditable_id)
                                <span class="model-id">#{{ $log->auditable_id }}</span>
                                @endif
                            </span>
                            @else
                            <span class="no-model">-</span>
                            @endif
                        </td>

                        <td data-label="IP Address" class="td-ip">
                            @if($log->ip_address)
                            <div class="ip-info">
                                <div class="ip-address">{{ $log->ip_address }}</div>
                            </div>
                            @else
                            <span class="no-ip">-</span>
                            @endif
                        </td>

                        <td data-label="Date & Time" class="td-datetime">
                            <div class="datetime-info">
                                <span class="datetime-full">{{ $log->created_at->format('M j, Y H:i:s') }}</span>
                            </div>
                        </td>

                        <td data-label="Actions" class="td-actions">
                            <div class="action-buttons enhanced-actions">
                                <a href="{{ route('admin.audit-logs.show', $log) }}"
                                    class="btn btn-sm btn-secondary action-btn" title="View Details">
                                    <i class="fas fa-eye"></i>
                                    <span class="btn-tooltip">View</span>
                                </a>
                                @if($log->auditable_type && $log->auditable_id)
                                <a href="{{ route('admin.audit-logs.model', [class_basename($log->auditable_type), $log->auditable_id]) }}"
                                    class="btn btn-sm btn-info action-btn" title="View Model Logs">
                                    <i class="fas fa-history"></i>
                                    <span class="btn-tooltip">History</span>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-enhanced-pagination :paginator="$auditLogs" :show-per-page-selector="true"
            :per-page-options="[5, 10, 20, 50, 100]" :show-page-info="true" :show-jump-to-page="true"
            :max-visible-pages="7" />
        @else
        <div class="empty-state enhanced-empty-state">
            <div class="empty-icon">
                <i class="fas fa-list-alt"></i>
                <div class="icon-pulse"></div>
            </div>
            <h3>No Audit Logs Found</h3>
            <p>No audit logs match your current filters. Try adjusting your search criteria.</p>
            <div class="empty-actions">
                <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-primary">
                    <i class="fas fa-refresh"></i>
                    Clear Filters
                </a>
                <button class="btn btn-outline refresh-btn" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i>
                    Refresh
                </button>
            </div>
        </div>
        @endif
    </div>
</div>


@push('styles')
<style>
    /* Enhanced Table Styling */
    .table-container {
        overflow-x: auto;
        border-radius: var(--radius-lg);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .enhanced-table {
        width: 100%;
        border-collapse: collapse;
        background: var(--white);
        font-size: 0.75rem;
        overflow: scroll;
    }

    .enhanced-table thead {
        background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
        border-bottom: 2px solid var(--gray-200);
    }

    .enhanced-table th {
        padding: var(--space-4);
        text-align: left;
        font-weight: 600;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-200);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .enhanced-table th.sortable {
        cursor: pointer;
        user-select: none;
        transition: all 0.3s ease;
    }

    .enhanced-table th.sortable:hover {
        background: var(--gray-100);
        color: var(--primary);
    }

    .th-content {
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }

    .sort-icon {
        margin-left: auto;
        opacity: 0.5;
        transition: all 0.3s ease;
    }

    .enhanced-table th.sortable:hover .sort-icon {
        opacity: 1;
        color: var(--primary);
    }

    .enhanced-table td {
        padding: var(--space-4);
        border-bottom: 1px solid var(--gray-100);
        vertical-align: middle;
    }

    .enhanced-table tbody tr {
        transition: all 0.3s ease;
    }

    .enhanced-table tbody tr:hover {
        background: var(--gray-50);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Event Badge Styling */
    .event-badge {
        padding: var(--space-1) var(--space-3);
        border-radius: var(--radius);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .event-created {
        background: linear-gradient(135deg, #10b981, #065f46);
        color: white;
    }

    .event-updated {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .event-deleted {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .event-viewed {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        color: white;
    }

    .event-login {
        background: linear-gradient(135deg, #10b981, #065f46);
        color: white;
    }

    .event-logout {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
    }

    /* User Info Styling - Override admin layout styles */
    .audit-logs-table .user-name,
    .audit-logs-table .user-email {
        font-size: 0.75rem !important;
        color: var(--gray-600) !important;
        word-wrap: break-word !important;
        white-space: normal !important;
        font-weight: normal !important;
        font-family: inherit !important;
        line-height: 1.4 !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: visible !important;
        text-overflow: initial !important;
    }

    /* Ensure table cells have consistent styling */
    .audit-logs-table .td-user-name,
    .audit-logs-table .td-user-email {
        font-size: 0.75rem !important;
        color: var(--gray-600) !important;
        font-weight: normal !important;
    }


    /* Model Badge Styling */
    .model-badge {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        padding: var(--space-1) var(--space-3);
        border-radius: var(--radius);
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: var(--space-1);
    }

    .model-id {
        background: rgba(255, 255, 255, 0.2);
        padding: var(--space-1) var(--space-2);
        border-radius: var(--radius);
        font-size: 0.65rem;
    }

    .no-model,
    .no-ip {
        color: var(--gray-400);
        font-style: italic;
    }

    /* IP Info Styling */
    .ip-address {
        font-family: 'Courier New', monospace;
        font-size: 0.75rem;
        color: var(--gray-700);
    }

    /* DateTime Styling */
    .datetime-info {
        display: flex;
        align-items: center;
        min-width: 0;
        /* Allow text to wrap */
    }

    .datetime-full {
        font-weight: 600;
        color: var(--gray-900);
        font-size: 0.75rem;
        line-height: 1.4;
        word-wrap: break-word;
        white-space: normal;
        display: block;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: var(--space-2);
    }

    .action-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius);
        transition: all 0.3s ease;
        position: relative;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-tooltip {
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--gray-900);
        color: var(--white);
        padding: var(--space-1) var(--space-2);
        border-radius: var(--radius);
        font-size: 0.75rem;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        z-index: 1000;
    }

    .action-btn:hover .btn-tooltip {
        opacity: 1;
    }


    /* Responsive Design */
    @media (max-width: 768px) {

        .audit-logs-table .user-name,
        .audit-logs-table .user-email {
            font-size: 0.7rem !important;
        }

        .datetime-full {
            font-size: 0.7rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: var(--space-1);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Filter toggle functionality
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

    // Table functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize filters as hidden by default
        const form = document.getElementById('filtersForm');
        form.style.display = 'none';

        // Select all functionality
        const selectAllCheckbox = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const bulkActionsBar = document.getElementById('bulkActionsBar');
        const selectedCount = document.getElementById('selectedCount');

        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });

        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectAllState();
                updateBulkActions();
            });
        });

        function updateSelectAllState() {
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            selectAllCheckbox.checked = checkedBoxes.length === rowCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < rowCheckboxes.length;
        }

        function updateBulkActions() {
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            const count = checkedBoxes.length;

            selectedCount.textContent = count;

            if (count > 0) {
                bulkActionsBar.style.display = 'block';
            } else {
                bulkActionsBar.style.display = 'none';
            }
        }

        // Table sorting functionality
        const sortableHeaders = document.querySelectorAll('.sortable');
        sortableHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const sortField = this.dataset.sort;
                const currentUrl = new URL(window.location);
                const currentSort = currentUrl.searchParams.get('sort');
                const currentDirection = currentUrl.searchParams.get('direction');

                let newDirection = 'asc';
                if (currentSort === sortField && currentDirection === 'asc') {
                    newDirection = 'desc';
                }

                currentUrl.searchParams.set('sort', sortField);
                currentUrl.searchParams.set('direction', newDirection);
                window.location.href = currentUrl.toString();
            });
        });

    });

    // Column visibility toggle
    function toggleColumnVisibility() {
        // This would open a modal or dropdown to toggle column visibility
        alert('Column visibility toggle - to be implemented');
    }

    // Export table functionality
    function exportTable() {
        const currentUrl = new URL(window.location);
        currentUrl.pathname = '{{ route("admin.audit-logs.export.excel") }}';
        window.open(currentUrl.toString(), '_blank');
    }

    // Export selected functionality
    function exportSelected() {
        const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked'))
            .map(checkbox => checkbox.value);

        if (selectedIds.length === 0) {
            alert('Please select items to export');
            return;
        }

        const currentUrl = new URL(window.location);
        currentUrl.pathname = '{{ route("admin.audit-logs.export.excel") }}';
        currentUrl.searchParams.set('ids', selectedIds.join(','));
        window.open(currentUrl.toString(), '_blank');
    }

    // Delete selected functionality
    function deleteSelected() {
        const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked'))
            .map(checkbox => checkbox.value);

        if (selectedIds.length === 0) {
            alert('Please select items to delete');
            return;
        }

        if (confirm(`Are you sure you want to delete ${selectedIds.length} audit log(s)? This action cannot be undone.`)) {
            // This would make an AJAX request to delete the selected logs
            alert('Delete functionality - to be implemented');
        }
    }
</script>
@endpush

@endsection