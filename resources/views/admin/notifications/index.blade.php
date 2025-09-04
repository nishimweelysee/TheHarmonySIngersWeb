@extends('layouts.admin')

@section('title', 'Notifications')
@section('page-title', 'Manage Notifications')

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
                <i class="fas fa-bell"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Notifications Management</h2>
                <p class="header-subtitle">Manage and send notifications to choir members and users</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($stats['total_notifications']) }}</span>
                        <span class="stat-label">Total Notifications</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($stats['unread_notifications']) }}</span>
                        <span class="stat-label">Unread</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($stats['total_members']) }}</span>
                        <span class="stat-label">Members</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <div class="export-buttons">
                <a href="{{ route('admin.notifications.export.excel', request()->query()) }}" class="btn btn-success enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-file-excel"></i>
                        <span>Export Excel</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
                <a href="{{ route('admin.notifications.export.pdf', request()->query()) }}" class="btn btn-danger enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-file-pdf"></i>
                        <span>Export PDF</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
            </div>
            @permission('send_notifications')
            <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Send New Notification</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
        </div>
    </div>
</div>

<!-- Enhanced Statistics Cards -->
<div class="stats-grid enhanced-stats">
    <div class="stat-card enhanced-card">
        <div class="stat-icon stat-icon-blue">
            <i class="fas fa-bell"></i>
            <div class="icon-glow"></div>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($stats['total_notifications']) }}</div>
            <div class="stat-label">Total Notifications</div>
        </div>
    </div>

    <div class="stat-card enhanced-card">
        <div class="stat-icon stat-icon-yellow">
            <i class="fas fa-clock"></i>
            <div class="icon-glow"></div>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($stats['unread_notifications']) }}</div>
            <div class="stat-label">Unread</div>
        </div>
    </div>

    <div class="stat-card enhanced-card">
        <div class="stat-icon stat-icon-green">
            <i class="fas fa-users"></i>
            <div class="icon-glow"></div>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($stats['total_members']) }}</div>
            <div class="stat-label">Total Members</div>
        </div>
    </div>

    <div class="stat-card enhanced-card">
        <div class="stat-icon stat-icon-purple">
            <i class="fas fa-user-shield"></i>
            <div class="icon-glow"></div>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>
</div>

<!-- Enhanced Quick Actions -->
<div class="quick-actions enhanced-actions-section">
    <div class="actions-header">
        <h3 class="actions-title">
            <i class="fas fa-bolt"></i>
            Quick Actions
        </h3>
        <p class="actions-subtitle">Common notification tasks</p>
    </div>
    <div class="actions-grid enhanced-grid">
        @permission('send_notifications')
        <a href="{{ route('admin.notifications.create') }}" class="action-card enhanced-card action-primary">
            <div class="action-icon">
                <i class="fas fa-plus"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="action-content">
                <h4>Send Notification</h4>
                <p>Send a new notification to members or users</p>
            </div>
        </a>
        @endpermission

        @permission('send_notifications')
        <a href="{{ route('admin.notifications.create') }}?template=rehearsal_reminder"
            class="action-card enhanced-card action-success">
            <div class="action-icon">
                <i class="fas fa-music"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="action-content">
                <h4>Rehearsal Reminder</h4>
                <p>Quick rehearsal reminder template</p>
            </div>
        </a>
        @endpermission

        @permission('send_notifications')
        <a href="{{ route('admin.notifications.create') }}?template=concert_announcement"
            class="action-card enhanced-card action-info">
            <div class="action-icon">
                <i class="fas fa-calendar-alt"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="action-content">
                <h4>Concert Announcement</h4>
                <p>Announce upcoming concerts</p>
            </div>
        </a>
        @endpermission

        @permission('send_notifications')
        <a href="{{ route('admin.notifications.create') }}?template=general_announcement"
            class="action-card enhanced-card action-warning">
            <div class="action-icon">
                <i class="fas fa-bullhorn"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="action-content">
                <h4>General Announcement</h4>
                <p>Send general choir announcements</p>
            </div>
        </a>
        @endpermission
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

        <form method="GET" action="{{ route('admin.notifications.index') }}" class="filters-form" id="filtersForm">
            <div class="filters-grid">
                <div class="search-group">
                    <div class="search-box enhanced-search">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search notifications..." class="search-input enhanced-input">
                        <div class="search-glow"></div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-item">
                        <label class="filter-label">Status</label>
                        <select name="status" class="filter-select enhanced-select">
                            <option value="">All Status</option>
                            <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread
                            </option>
                            <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Type</label>
                        <select name="type" class="filter-select enhanced-select">
                            <option value="">All Types</option>
                            <option value="admin_broadcast"
                                {{ request('type') === 'admin_broadcast' ? 'selected' : '' }}>Admin Broadcast</option>
                            <option value="system" {{ request('type') === 'system' ? 'selected' : '' }}>System</option>
                            <option value="user" {{ request('type') === 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary filter-btn enhanced-btn">
                        <i class="fas fa-search"></i>
                        <span>Apply Filters</span>
                    </button>
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline clear-btn enhanced-btn">
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
                Recent Notifications
            </h3>
            <div class="header-meta">
                <span class="results-count">
                    Showing {{ $recentNotifications->firstItem() ?? 0 }} -
                    {{ $recentNotifications->lastItem() ?? 0 }} of {{ $recentNotifications->total() }}
                </span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($recentNotifications->count() > 0)
        <div class="notifications-list enhanced-list">
            @foreach($recentNotifications as $notification)
            <div class="notification-item enhanced-item {{ $notification->status === 'unread' ? 'unread' : 'read' }}">
                <div class="notification-header">
                    <div class="notification-title">
                        <h4 class="title-text">{{ $notification->title }}</h4>
                        <div class="notification-badges">
                            @if($notification->type === 'admin_broadcast')
                            <span class="badge enhanced-badge badge-purple">
                                <i class="fas fa-broadcast-tower"></i>
                                Admin Broadcast
                            </span>
                            @endif
                            @if($notification->status === 'unread')
                            <span class="badge enhanced-badge badge-blue">
                                <i class="fas fa-circle"></i>
                                Unread
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="notification-actions enhanced-actions">
                        @if($notification->status === 'unread')
                        <button onclick="markAsRead({{ $notification->id }})"
                            class="btn btn-sm btn-secondary action-btn enhanced-btn" title="Mark as Read">
                            <i class="fas fa-check"></i>
                            <span class="btn-tooltip">Mark Read</span>
                        </button>
                        @endif
                        @permission('delete_notifications')
                        <button onclick="deleteNotification({{ $notification->id }})"
                            class="btn btn-sm btn-danger action-btn enhanced-btn" title="Delete Notification">
                            <i class="fas fa-trash"></i>
                            <span class="btn-tooltip">Delete</span>
                        </button>
                        @endpermission
                    </div>
                </div>

                <div class="notification-body">
                    <p class="notification-message">{{ $notification->message }}</p>
                </div>

                <div class="notification-footer">
                    <div class="notification-meta enhanced-meta">
                        <span class="meta-item">
                            <i class="fas fa-clock"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                        @if($notification->notifiable)
                        <span class="meta-item">
                            <i class="fas fa-user"></i>
                            To:
                            {{ $notification->notifiable->name ?? $notification->notifiable->full_name ?? 'Unknown' }}
                        </span>
                        @endif
                        @if($notification->data && isset($notification->data['template']))
                        <span class="meta-item">
                            <i class="fas fa-file-alt"></i>
                            Template: {{ ucfirst(str_replace('_', ' ', $notification->data['template'])) }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrapper enhanced-pagination">
            {{ $recentNotifications->links() }}
        </div>
        @else
        <div class="empty-state enhanced-empty-state">
            <div class="empty-icon">
                <i class="fas fa-bell"></i>
                <div class="icon-pulse"></div>
            </div>
            <h3>No notifications yet</h3>
            <p>Start by sending your first notification to choir members.</p>
            <div class="empty-actions">
                @permission('send_notifications')
                <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary enhanced-btn">
                    <i class="fas fa-plus"></i>
                    Send First Notification
                </a>
                @endpermission
                <button class="btn btn-outline refresh-btn enhanced-btn" onclick="location.reload()">
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

    function markAsRead(notificationId) {
        if (!confirm('Mark this notification as read?')) return;

        fetch(`/notifications/${notificationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to mark notification as read');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to mark notification as read');
            });
    }

    function deleteNotification(notificationId) {
        if (!confirm('Are you sure you want to delete this notification? This action cannot be undone.')) return;

        fetch(`/admin/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Failed to delete notification');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete notification');
            });
    }

    // Initialize filters as hidden by default
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filtersForm');
        form.style.display = 'none';
    });
</script>

@endsection