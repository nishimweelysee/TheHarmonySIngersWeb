@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header dashboard-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon-wrapper">
                <i class="fas fa-tachometer-alt"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <div class="welcome-section">
                    <h1 class="header-title">Admin Dashboard</h1>
                    <p class="header-subtitle">Welcome back, {{ Auth::user()->name }}! Here's what's happening today</p>
                    <div class="current-time">
                        <i class="fas fa-clock"></i>
                        <span id="current-time">{{ now()->format('l, F j, Y \a\t g:i A') }}</span>
                    </div>
                </div>
                <div class="header-stats">
                    <div class="stat-item">
                        <div class="stat-icon-small">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number">{{ $stats['total_members'] ?? 0 }}</span>
                            <span class="stat-label">Total Members</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon-small">
                            <i class="fas fa-music"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number">{{ $stats['upcoming_concerts'] ?? 0 }}</span>
                            <span class="stat-label">Upcoming Concerts</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon-small">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number">{{ $stats['active_contributions'] ?? 0 }}</span>
                            <span class="stat-label">Active Campaigns</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon-small">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number">{{ $upcomingPracticeSessions->count() ?? 0 }}</span>
                            <span class="stat-label">Practice Sessions</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <div class="action-group">
                <div class="status-indicator">
                    <div class="status-dot"></div>
                    <span>System Live</span>
                    <div class="status-pulse"></div>
                </div>
                <div class="quick-stats">
                    <div class="quick-stat">
                        <i class="fas fa-database"></i>
                        <span>DB: Active</span>
                    </div>
                    <div class="quick-stat">
                        <i class="fas fa-envelope"></i>
                        <span>Email: OK</span>
                    </div>
                </div>
            </div>
            <div class="action-buttons">
                <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Member
                </a>
                <a href="{{ route('admin.notifications.create') }}" class="btn btn-outline">
                    <i class="fas fa-bell"></i>
                    Send Alert
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Content -->
<div class="dashboard-content">
    <!-- Statistics Cards Grid -->
    <div class="stats-grid">
        <div class="stat-card stat-members">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $stats['total_members'] ?? 0 }}</h3>
                <p class="stat-label">Total Members</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ $stats['active_singers'] ?? 0 }} active singers</span>
                </div>
            </div>
        </div>

        <div class="stat-card stat-concerts">
            <div class="stat-icon">
                <i class="fas fa-music"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $stats['upcoming_concerts'] ?? 0 }}</h3>
                <p class="stat-label">Upcoming Concerts</p>
                <div class="stat-change positive">
                    <i class="fas fa-calendar"></i>
                    <span>Next: {{ $recentConcerts->first()->date ?? 'No upcoming' }}</span>
                </div>
            </div>
        </div>

        <div class="stat-card stat-contributions">
            <div class="stat-icon">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">${{ number_format($financialSummary['total_contributions'] ?? 0) }}</h3>
                <p class="stat-label">Total Contributions</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>${{ number_format($financialSummary['monthly_contributions'] ?? 0) }} this month</span>
                </div>
            </div>
        </div>

        <div class="stat-card stat-practice">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $upcomingPracticeSessions->count() ?? 0 }}</h3>
                <p class="stat-label">Practice Sessions</p>
                <div class="stat-change positive">
                    <i class="fas fa-clock"></i>
                    <span>{{ $todayPracticeSessions->count() ?? 0 }} today</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Grid -->
    <div class="dashboard-grid">
        <!-- Recent Activity & Quick Actions -->
        <div class="dashboard-card activity-card">
            <div class="card-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-clock"></i>
                        Recent Activity
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Latest Updates
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="activity-list">
                    @if($recentConcerts->count() > 0)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-music"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Upcoming Concert:
                                {{ $recentConcerts->first()->title ?? 'Concert' }}
                            </div>
                            <div class="activity-time">
                                {{ $recentConcerts->first()->date ? \Carbon\Carbon::parse($recentConcerts->first()->date)->format('M d, Y') : 'TBD' }}
                            </div>
                        </div>
                        <div class="activity-status">
                            <span class="status-badge info">
                                <div class="status-dot"></div>
                                Scheduled
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($recentMembers->count() > 0)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">New Member:
                                {{ $recentMembers->first()->first_name ?? 'Member' }}
                                {{ $recentMembers->first()->last_name ?? '' }}
                            </div>
                            <div class="activity-time">
                                {{ $recentMembers->first()->created_at ? $recentMembers->first()->created_at->diffForHumans() : 'Recently' }}
                            </div>
                        </div>
                        <div class="activity-status">
                            <span class="status-badge success">
                                <div class="status-dot"></div>
                                New
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($upcomingPracticeSessions->count() > 0)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Practice Session Scheduled</div>
                            <div class="activity-time">
                                {{ $upcomingPracticeSessions->first()->practice_date ? \Carbon\Carbon::parse($upcomingPracticeSessions->first()->practice_date)->format('M d, Y') : 'TBD' }}
                            </div>
                        </div>
                        <div class="activity-status">
                            <span class="status-badge warning">
                                <div class="status-dot"></div>
                                Upcoming
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($activeContributions->count() > 0)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Active Contribution Campaign</div>
                            <div class="activity-time">
                                {{ $activeContributions->first()->created_at ? $activeContributions->first()->created_at->diffForHumans() : 'Recently' }}
                            </div>
                        </div>
                        <div class="activity-status">
                            <span class="status-badge success">
                                <div class="status-dot"></div>
                                Active
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($recentMedia->count() > 0)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-photo-video"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">New Media Uploaded</div>
                            <div class="activity-time">
                                {{ $recentMedia->first()->created_at ? $recentMedia->first()->created_at->diffForHumans() : 'Recently' }}
                            </div>
                        </div>
                        <div class="activity-status">
                            <span class="status-badge info">
                                <div class="status-dot"></div>
                                Media
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($recentConcerts->count() == 0 && $recentMembers->count() == 0 &&
                    $upcomingPracticeSessions->count() == 0 && $activeContributions->count() == 0 &&
                    $recentMedia->count() == 0)
                    <div class="no-activity">
                        <div class="empty-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4>No Recent Activity</h4>
                        <p>No recent activities to display at the moment.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-card actions-card">
            <div class="card-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-bolt"></i>
                        Quick Actions
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Common Tasks
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="quick-actions-grid">
                    <a href="{{ route('admin.members.create') }}" class="quick-action">
                        <div class="action-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Add Member</span>
                            <span class="action-description">Register new choir member</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.concerts.create') }}" class="quick-action">
                        <div class="action-icon">
                            <i class="fas fa-music"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Schedule Concert</span>
                            <span class="action-description">Create new concert event</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.practice-sessions.create') }}" class="quick-action">
                        <div class="action-icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Plan Practice</span>
                            <span class="action-description">Schedule practice session</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.contributions.create') }}" class="quick-action">
                        <div class="action-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Record Contribution</span>
                            <span class="action-description">Log donation or contribution</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.users.create') }}" class="quick-action">
                        <div class="action-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Add User</span>
                            <span class="action-description">Create system user account</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.notifications.create') }}" class="quick-action">
                        <div class="action-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Send Notification</span>
                            <span class="action-description">Notify members and users</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="dashboard-card status-card">
            <div class="card-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-server"></i>
                        System Status
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Health Check
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="status-grid">
                    <div class="status-item">
                        <div class="status-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="status-content">
                            <span class="status-title">Database</span>
                            <span class="status-value">Connected</span>
                        </div>
                        <div class="status-indicator online"></div>
                    </div>

                    <div class="status-item">
                        <div class="status-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="status-content">
                            <span class="status-title">Email Service</span>
                            <span class="status-value">Active</span>
                        </div>
                        <div class="status-indicator online"></div>
                    </div>

                    <div class="status-item">
                        <div class="status-icon">
                            <i class="fas fa-file-upload"></i>
                        </div>
                        <div class="status-content">
                            <span class="status-title">File Storage</span>
                            <span class="status-value">Available</span>
                        </div>
                        <div class="status-indicator online"></div>
                    </div>

                    <div class="status-item">
                        <div class="status-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="status-content">
                            <span class="status-title">Security</span>
                            <span class="status-value">Protected</span>
                        </div>
                        <div class="status-indicator online"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Members -->
        <div class="dashboard-card members-card">
            <div class="card-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i>
                        Recent Members
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Latest Additions
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="members-list">
                    @forelse($recentMembers as $member)
                    <div class="member-item">
                        <div class="member-avatar">
                            @if($member->profile_photo)
                            <img src="{{ asset('storage/' . $member->profile_photo) }}" alt="{{ $member->first_name }}"
                                class="avatar-img">
                            @else
                            <i class="fas fa-user"></i>
                            @endif
                        </div>
                        <div class="member-content">
                            <span class="member-name">{{ $member->first_name }} {{ $member->last_name }}</span>
                            <span
                                class="member-joined">{{ $member->created_at ? $member->created_at->diffForHumans() : 'Recently' }}</span>
                        </div>
                        <div class="member-actions">
                            <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-sm btn-outline">
                                <i class="fas fa-eye"></i>
                                <span>View</span>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="no-members">
                        <div class="empty-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>No Recent Members</h4>
                        <p>No new members have been added recently.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="dashboard-card events-card">
            <div class="card-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt"></i>
                        Upcoming Events
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Next 7 Days
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="events-list">
                    @forelse($recentConcerts->take(3) as $concert)
                    <div class="event-item">
                        <div class="event-date">
                            <div class="date-day">{{ \Carbon\Carbon::parse($concert->date)->format('d') }}</div>
                            <div class="date-month">{{ \Carbon\Carbon::parse($concert->date)->format('M') }}</div>
                        </div>
                        <div class="event-content">
                            <div class="event-title">{{ $concert->title }}</div>
                            <div class="event-location">{{ $concert->venue ?? 'TBD' }}</div>
                        </div>
                        <div class="event-status">
                            <span class="status-badge info">Concert</span>
                        </div>
                    </div>
                    @empty
                    <div class="no-events">
                        <div class="empty-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h4>No Upcoming Events</h4>
                        <p>No events scheduled for the next few days.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Financial Summary -->
        <div class="dashboard-card financial-card">
            <div class="card-header">
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line"></i>
                        Financial Summary
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        This Month
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="financial-grid">
                    <div class="financial-item">
                        <div class="financial-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <div class="financial-content">
                            <span class="financial-label">Monthly Contributions</span>
                            <span
                                class="financial-amount">${{ number_format($financialSummary['monthly_contributions'] ?? 0) }}</span>
                        </div>
                    </div>
                    <div class="financial-item">
                        <div class="financial-icon">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <div class="financial-content">
                            <span class="financial-label">Project Contributions</span>
                            <span
                                class="financial-amount">${{ number_format($financialSummary['project_contributions'] ?? 0) }}</span>
                        </div>
                    </div>
                    <div class="financial-item">
                        <div class="financial-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="financial-content">
                            <span class="financial-label">Sponsor Support</span>
                            <span
                                class="financial-amount">${{ number_format($financialSummary['total_sponsor_contributions'] ?? 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Action Buttons -->
    <div class="action-section">
        <div class="action-buttons">
            <a href="{{ route('admin.members.index') }}" class="btn btn-primary action-btn">
                <i class="fas fa-users"></i>
                <span>Manage Members</span>
            </a>
            <a href="{{ route('admin.concerts.index') }}" class="btn btn-info action-btn">
                <i class="fas fa-music"></i>
                <span>View Concerts</span>
            </a>
            <a href="{{ route('admin.practice-sessions.index') }}" class="btn btn-warning action-btn">
                <i class="fas fa-calendar-check"></i>
                <span>Practice Sessions</span>
            </a>
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary action-btn">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
            </a>
            <a href="{{ route('admin.financial-reports.index') }}" class="btn btn-success action-btn">
                <i class="fas fa-chart-bar"></i>
                <span>Financial Reports</span>
            </a>
        </div>
    </div>
</div>

@endsection

<style>
    /* Dashboard Specific Styles */
    .dashboard-content {
        margin-top: var(--space-8);
    }

    /* Enhanced Dashboard Header */
    .page-header.dashboard-header,
    .dashboard-header {
        /* Fallback background */
        background: #1e3a8a;
        /* CSS Variables with fallbacks */
        background: linear-gradient(135deg,
                var(--primary, #1e3a8a) 0%,
                var(--primary-light, #3b82f6) 50%,
                var(--accent, #1d4ed8) 100%) !important;
        color: var(--white, #ffffff);
        margin-bottom: var(--space-8);
        position: relative;
        overflow: hidden;
        border-radius: var(--radius-xl);
        box-shadow: 0 10px 25px -5px rgba(30, 58, 138, 0.3);
        /* Ensure the background is visible */
        background-attachment: local;
        background-size: cover;
        background-position: center;
        /* Debug: ensure no other styles override */
        background-color: transparent !important;
        background-image: linear-gradient(135deg,
                var(--primary, #1e3a8a) 0%,
                var(--primary-light, #3b82f6) 50%,
                var(--accent, #1d4ed8) 100%) !important;
        /* Additional styling to ensure visibility */
        border: 2px solid #1e3a8a;
        position: relative;
        z-index: 10;
    }

    /* Override any conflicting styles from admin layout */
    .page-header.dashboard-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1d4ed8 100%) !important;
        background-image: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1d4ed8 100%) !important;
        color: #ffffff !important;
    }

    .header-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
    }

    .header-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image:
            radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        opacity: 0.6;
    }

    .header-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        right: -50%;
        bottom: -50%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: headerGlow 8s ease-in-out infinite;
    }

    @keyframes headerGlow {

        0%,
        100% {
            transform: scale(1) rotate(0deg);
            opacity: 0.3;
        }

        50% {
            transform: scale(1.2) rotate(180deg);
            opacity: 0.6;
        }
    }

    .header-text {
        display: flex;
        align-items: flex-start;
        gap: var(--space-6);
        margin-bottom: var(--space-6);
    }

    .header-icon-wrapper {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        position: relative;
        flex-shrink: 0;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .icon-glow {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.4) 0%, transparent 70%);
        border-radius: 50%;
        animation: iconPulse 3s ease-in-out infinite;
    }

    @keyframes iconPulse {

        0%,
        100% {
            opacity: 0.4;
            transform: scale(1);
        }

        50% {
            opacity: 0.8;
            transform: scale(1.1);
        }
    }

    .header-details {
        flex: 1;
    }

    .welcome-section {
        margin-bottom: var(--space-6);
    }

    .header-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: var(--space-2);
        background: linear-gradient(135deg, var(--white) 0%, rgba(255, 255, 255, 0.9) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: var(--space-4);
        line-height: 1.5;
    }

    .current-time {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        font-size: 0.95rem;
        opacity: 0.8;
        background: rgba(255, 255, 255, 0.1);
        padding: var(--space-2) var(--space-3);
        border-radius: var(--radius-lg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        width: fit-content;
    }

    .current-time i {
        color: var(--warning);
    }

    .header-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--space-4);
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        background: rgba(255, 255, 255, 0.1);
        padding: var(--space-4);
        border-radius: var(--radius-xl);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .stat-icon-small {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: var(--white);
        flex-shrink: 0;
    }

    .stat-content {
        flex: 1;
    }

    .stat-number {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: var(--space-1);
        color: var(--white);
    }

    .stat-label {
        display: block;
        font-size: 0.875rem;
        opacity: 0.8;
        font-weight: 500;
    }

    .dashboard-header .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: var(--space-6);
    }

    .action-group {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
    }

    .status-indicator {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        background: rgba(255, 255, 255, 0.1);
        padding: var(--space-3) var(--space-4);
        border-radius: var(--radius-lg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }

    .status-dot {
        width: 12px;
        height: 12px;
        background: var(--success);
        border-radius: 50%;
        position: relative;
    }

    .status-pulse {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 20px;
        height: 20px;
        background: var(--success);
        border-radius: 50%;
        opacity: 0.6;
        animation: statusPulse 2s ease-in-out infinite;
    }

    @keyframes statusPulse {
        0% {
            transform: translate(-50%, -50%) scale(0.8);
            opacity: 0.6;
        }

        50% {
            transform: translate(-50%, -50%) scale(1.2);
            opacity: 0.3;
        }

        100% {
            transform: translate(-50%, -50%) scale(0.8);
            opacity: 0.6;
        }
    }

    .quick-stats {
        display: flex;
        gap: var(--space-3);
    }

    .quick-stat {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        background: rgba(255, 255, 255, 0.1);
        padding: var(--space-2) var(--space-3);
        border-radius: var(--radius);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        font-size: 0.875rem;
        opacity: 0.9;
    }

    .quick-stat i {
        color: var(--success);
        font-size: 0.75rem;
    }

    .action-buttons {
        display: flex;
        gap: var(--space-3);
        flex-shrink: 0;
    }

    .action-buttons .btn {
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .btn-outline {
        background: rgba(255, 255, 255, 0.1);
        color: var(--white);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-outline:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
    }

    /* Statistics Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: var(--space-6);
        margin-bottom: var(--space-8);
    }

    .stat-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        padding: var(--space-6);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--gray-200);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 100%);
    }

    .stat-card.stat-members::before {
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 100%);
    }

    .stat-card.stat-concerts::before {
        background: linear-gradient(90deg, var(--info) 0%, var(--info-light) 100%);
    }

    .stat-card.stat-contributions::before {
        background: linear-gradient(90deg, var(--success) 0%, var(--success-light) 100%);
    }

    .stat-card.stat-practice::before {
        background: linear-gradient(90deg, var(--warning) 0%, var(--warning-light) 100%);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        background: var(--gray-100);
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--gray-600);
        margin-bottom: var(--space-4);
        transition: all 0.3s ease;
    }

    /* Dashboard Stat Card Icons - Colored Backgrounds */
    .stat-card.stat-members .stat-icon {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: var(--white);
        box-shadow: 0 4px 15px rgba(23, 52, 120, 0.3);
    }

    .stat-card.stat-concerts .stat-icon {
        background: linear-gradient(135deg, var(--info) 0%, var(--info-dark) 100%);
        color: var(--white);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .stat-card.stat-contributions .stat-icon {
        background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
        color: var(--white);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .stat-card.stat-practice .stat-icon {
        background: linear-gradient(135deg, var(--warning) 0%, var(--warning-dark) 100%);
        color: var(--white);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1);
    }

    /* Maintain colored backgrounds on hover */
    .stat-card.stat-members:hover .stat-icon {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        box-shadow: 0 6px 20px rgba(23, 52, 120, 0.4);
    }

    .stat-card.stat-concerts:hover .stat-icon {
        background: linear-gradient(135deg, var(--info-dark) 0%, var(--info) 100%);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .stat-card.stat-contributions:hover .stat-icon {
        background: linear-gradient(135deg, var(--success-dark) 0%, var(--success) 100%);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .stat-card.stat-practice:hover .stat-icon {
        background: linear-gradient(135deg, var(--warning-dark) 0%, var(--warning) 100%);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: var(--space-2);
        display: block;
    }

    .stat-label {
        color: var(--gray-600);
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: var(--space-3);
        display: block;
    }

    .stat-change {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        font-size: 0.875rem;
        font-weight: 500;
    }

    .stat-change.positive {
        color: var(--success);
    }

    .stat-change.negative {
        color: var(--error);
    }

    .stat-change i {
        font-size: 0.75rem;
    }

    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: var(--space-6);
        margin-bottom: var(--space-8);
    }

    .dashboard-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--gray-200);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card-header {
        background: linear-gradient(135deg, var(--white) 0%, var(--gray-50) 100%);
        padding: var(--space-6);
        border-bottom: 1px solid var(--gray-200);
    }

    .dashboard-card .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-900);
        margin: 0;
    }

    .card-title i {
        color: var(--accent);
        font-size: 1.1rem;
    }

    .header-badge {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        font-size: 0.875rem;
        color: var(--gray-600);
        font-weight: 500;
    }

    .badge-dot {
        width: 8px;
        height: 8px;
        background: var(--accent);
        border-radius: 50%;
    }

    .card-content {
        padding: var(--space-6);
    }

    /* Activity List */
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        padding: var(--space-4);
        border-radius: var(--radius-lg);
        transition: all 0.3s ease;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        background: var(--gray-100);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: var(--gray-600);
        flex-shrink: 0;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: var(--space-1);
        font-size: 0.95rem;
    }

    .activity-time {
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    .status-badge {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-2) var(--space-3);
        border-radius: var(--radius);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-badge.info {
        background: var(--info-light);
        color: var(--info-dark);
    }

    .status-badge.success {
        background: var(--success-light);
        color: var(--success-dark);
    }

    .status-badge.warning {
        background: var(--warning-light);
        color: var(--warning-dark);
    }

    .status-badge.error {
        background: var(--error-light);
        color: var(--error-dark);
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* Quick Actions */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--space-4);
    }

    .quick-action {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        padding: var(--space-4);
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-lg);
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        background: var(--white);
    }

    .quick-action:hover {
        border-color: var(--accent);
        background: var(--gray-50);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .action-icon {
        width: 50px;
        height: 50px;
        background: var(--gray-100);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--gray-600);
        transition: all 0.3s ease;
    }

    .quick-action:hover .action-icon {
        background: var(--accent-light);
        color: var(--accent);
        transform: scale(1.1);
    }

    .action-content {
        flex: 1;
    }

    .action-title {
        display: block;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: var(--space-1);
        font-size: 0.95rem;
    }

    .action-description {
        display: block;
        color: var(--gray-600);
        font-size: 0.875rem;
        line-height: 1.4;
    }

    /* System Status */
    .status-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--space-4);
    }

    .status-item {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        padding: var(--space-4);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        background: var(--white);
        transition: all 0.3s ease;
    }

    .status-item:hover {
        border-color: var(--accent);
        background: var(--gray-50);
    }

    .status-icon {
        width: 40px;
        height: 40px;
        background: var(--gray-100);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: var(--gray-600);
    }

    .status-content {
        flex: 1;
    }

    .status-title {
        display: block;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: var(--space-1);
        font-size: 0.9rem;
    }

    .status-value {
        display: block;
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .status-indicator.online {
        background: var(--success);
        box-shadow: 0 0 0 3px var(--success-light);
    }

    .status-indicator.offline {
        background: var(--error);
        box-shadow: 0 0 0 3px var(--error-light);
    }

    /* Members List */
    .members-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-3);
    }

    .member-item {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        padding: var(--space-4);
        border-radius: var(--radius-lg);
        transition: all 0.3s ease;
    }

    .member-avatar {
        width: 50px;
        height: 50px;
        background: var(--gray-100);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--gray-600);
        flex-shrink: 0;
        overflow: hidden;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .member-content {
        flex: 1;
    }

    .member-name {
        display: block;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: var(--space-1);
        font-size: 0.95rem;
    }

    .member-joined {
        display: block;
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    .member-actions {
        flex-shrink: 0;
    }

    /* Events List */
    .events-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
    }

    .event-item {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        padding: var(--space-4);
        border-radius: var(--radius-lg);
        transition: all 0.3s ease;
    }

    .event-date {
        width: 60px;
        height: 60px;
        background: var(--primary-light);
        border-radius: var(--radius-lg);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--white);
        flex-shrink: 0;
    }

    .date-day {
        font-size: 1.25rem;
        font-weight: 700;
        line-height: 1;
    }

    .date-month {
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .event-content {
        flex: 1;
    }

    .event-title {
        display: block;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: var(--space-1);
        font-size: 0.95rem;
    }

    .event-location {
        display: block;
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    .event-status {
        flex-shrink: 0;
    }

    /* Financial Grid */
    .financial-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--space-4);
    }

    .financial-item {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        padding: var(--space-4);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        background: var(--white);
        transition: all 0.3s ease;
    }

    .financial-item:hover {
        border-color: var(--accent);
        background: var(--gray-50);
    }

    .financial-icon {
        width: 50px;
        height: 50px;
        background: var(--success-light);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--success);
    }

    .financial-content {
        flex: 1;
    }

    .financial-label {
        display: block;
        font-weight: 500;
        color: var(--gray-700);
        margin-bottom: var(--space-1);
        font-size: 0.875rem;
    }

    .financial-amount {
        display: block;
        font-weight: 700;
        color: var(--gray-900);
        font-size: 1.1rem;
    }

    /* Action Section */
    .action-section {
        margin-top: var(--space-8);
        padding-top: var(--space-8);
        border-top: 1px solid var(--gray-200);
    }

    .action-buttons {
        display: flex;
        gap: var(--space-4);
        justify-content: center;
        flex-wrap: wrap;
    }

    .action-btn {
        min-width: 200px;
        justify-content: center;
    }

    /* Empty States */
    .no-activity,
    .no-members,
    .no-events {
        text-align: center;
        padding: var(--space-8);
        color: var(--gray-600);
    }

    .empty-icon {
        width: 60px;
        height: 60px;
        background: var(--gray-100);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--gray-400);
        margin: 0 auto var(--space-4);
    }

    .no-activity h4,
    .no-members h4,
    .no-events h4 {
        color: var(--gray-700);
        margin-bottom: var(--space-2);
        font-size: 1.1rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .quick-actions-grid {
            grid-template-columns: 1fr;
        }

        .status-grid {
            grid-template-columns: 1fr;
        }

        .financial-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-btn {
            width: 100%;
        }

        /* Header responsive adjustments */
        .header-content {
            padding: var(--space-6) var(--space-4);
        }

        .header-text {
            flex-direction: column;
            text-align: center;
            gap: var(--space-4);
        }

        .header-icon-wrapper {
            margin: 0 auto var(--space-4);
        }

        .header-title {
            font-size: 2rem;
            text-align: center;
        }

        .header-subtitle {
            text-align: center;
        }

        .current-time {
            margin: 0 auto;
        }

        .header-stats {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: var(--space-3);
        }

        .stat-item {
            padding: var(--space-3);
        }

        .stat-number {
            font-size: 1.25rem;
        }

        .dashboard-header .header-actions {
            flex-direction: column;
            gap: var(--space-4);
            align-items: center;
        }

        .action-group {
            align-items: center;
        }

        .quick-stats {
            justify-content: center;
        }

        .action-buttons {
            width: 100%;
            justify-content: center;
        }

        .action-buttons .btn {
            flex: 1;
            max-width: 200px;
        }
    }

    @media (max-width: 480px) {

        .stat-card,
        .dashboard-card {
            padding: var(--space-4);
        }

        .card-header,
        .card-content {
            padding: var(--space-4);
        }

        .quick-action,
        .status-item,
        .member-item,
        .event-item,
        .financial-item {
            padding: var(--space-3);
        }
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update current time
        function updateCurrentTime() {
            const now = new Date();
            const timeString = now.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }) + ' at ' + now.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });

            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }

        // Update time immediately and then every minute
        updateCurrentTime();
        setInterval(updateCurrentTime, 60000);

        // Add hover effects to dashboard cards
        const cards = document.querySelectorAll('.dashboard-card, .stat-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
                this.style.boxShadow = 'var(--shadow-xl)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });

        // Add hover effects to quick actions
        const quickActions = document.querySelectorAll('.quick-action');
        quickActions.forEach(action => {
            action.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
                this.style.boxShadow = 'var(--shadow-lg)';
            });

            action.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = '';
            });
        });

        // Add hover effects to activity items
        const activityItems = document.querySelectorAll('.activity-item');
        activityItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
                this.style.backgroundColor = 'var(--gray-50)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
                this.style.backgroundColor = '';
            });
        });

        // Add hover effects to member items
        const memberItems = document.querySelectorAll('.member-item');
        memberItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
                this.style.backgroundColor = 'var(--gray-50)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
                this.style.backgroundColor = '';
            });
        });

        // Add hover effects to event items
        const eventItems = document.querySelectorAll('.event-item');
        eventItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
                this.style.backgroundColor = 'var(--gray-50)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
                this.style.backgroundColor = '';
            });
        });

        // Add hover effects to financial items
        const financialItems = document.querySelectorAll('.financial-item');
        financialItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.backgroundColor = 'var(--gray-50)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.backgroundColor = '';
            });
        });
    });
</script>
@endpush