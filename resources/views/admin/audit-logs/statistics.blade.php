@extends('layouts.admin')

@section('title', 'Audit Logs Statistics')
@section('page-title', 'Audit Logs Analytics')

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
                <i class="fas fa-chart-line"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Audit Logs Analytics</h2>
                <p class="header-subtitle">Comprehensive insights into system activity and user behavior</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($stats['total_logs']) }}</span>
                        <span class="stat-label">Total Logs</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($stats['today_logs']) }}</span>
                        <span class="stat-label">Today's Activity</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($stats['user_actions']) }}</span>
                        <span class="stat-label">User Actions</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-secondary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Logs</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Statistics Overview Cards -->
<div class="stats-grid enhanced-stats">
    <div class="stat-card enhanced-card">
        <div class="stat-icon stat-icon-blue">
            <i class="fas fa-database"></i>
            <div class="icon-glow"></div>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ number_format($stats['total_logs']) }}</div>
            <div class="stat-label">Total Audit Logs</div>
            <div class="stat-description">All system activities recorded</div>
        </div>
        <div class="stat-trend">
            <i class="fas fa-chart-line"></i>
            <span>All Time</span>
        </div>
    </div>

    <div class="stat-card enhanced-card">
        <div class="stat-icon stat-icon-green">
            <i class="fas fa-calendar-day"></i>
            <div class="icon-glow"></div>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ number_format($stats['today_logs']) }}</div>
            <div class="stat-label">Today's Activity</div>
            <div class="stat-description">Actions performed today</div>
        </div>
        <div class="stat-trend">
            <i class="fas fa-arrow-up"></i>
            <span>Live</span>
        </div>
    </div>

    <div class="stat-card enhanced-card">
        <div class="stat-icon stat-icon-purple">
            <i class="fas fa-users"></i>
            <div class="icon-glow"></div>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ number_format($stats['user_actions']) }}</div>
            <div class="stat-label">User Actions</div>
            <div class="stat-description">Actions by authenticated users</div>
        </div>
        <div class="stat-trend">
            <i class="fas fa-user-check"></i>
            <span>{{ round(($stats['user_actions'] / max($stats['total_logs'], 1)) * 100, 1) }}%</span>
        </div>
    </div>

    <div class="stat-card enhanced-card">
        <div class="stat-icon stat-icon-orange">
            <i class="fas fa-robot"></i>
            <div class="icon-glow"></div>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ number_format($stats['system_actions']) }}</div>
            <div class="stat-label">System Actions</div>
            <div class="stat-description">Automated system activities</div>
        </div>
        <div class="stat-trend">
            <i class="fas fa-cog"></i>
            <span>{{ round(($stats['system_actions'] / max($stats['total_logs'], 1)) * 100, 1) }}%</span>
        </div>
    </div>
</div>

<!-- Charts and Analytics Section -->
<div class="analytics-section">
    <div class="analytics-grid">
        <!-- Event Distribution Chart -->
        <div class="analytics-card enhanced-card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-chart-pie"></i>
                    <h3>Event Distribution</h3>
                </div>
                <div class="card-actions">
                    <button class="btn-icon" title="Refresh Data">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="card-content">
                <div class="chart-container">
                    <canvas id="eventDistributionChart" width="400" height="200"></canvas>
                </div>
                <div class="chart-legend">
                    @foreach($stats['events'] as $event)
                    <div class="legend-item">
                        <div class="legend-color"
                            style="background-color: {{ $loop->index % 2 == 0 ? '#3B82F6' : '#10B981' }}"></div>
                        <span class="legend-label">{{ ucfirst($event->event) }}</span>
                        <span class="legend-value">{{ number_format($event->count) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Top Users Activity -->
        <div class="analytics-card enhanced-card user-activity-card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title-icon">
                        <i class="fas fa-trophy"></i>
                        <div class="icon-glow"></div>
                    </div>
                    <div class="title-content">
                        <h3>Most Active Users</h3>
                        <p class="title-subtitle">Top performers this period</p>
                    </div>
                </div>
                <div class="card-actions">
                    <button class="btn-icon enhanced-btn-icon" title="View All Users">
                        <i class="fas fa-external-link-alt"></i>
                    </button>
                </div>
            </div>
            <div class="card-content">
                <div class="user-activity-list enhanced-user-list">
                    @forelse($stats['top_users'] as $index => $userActivity)
                    <div class="user-activity-item enhanced-user-item" data-rank="{{ $index + 1 }}">
                        <div class="user-rank">
                            <div class="rank-badge rank-{{ $index + 1 }}">
                                @if($index + 1 <= 3) <i class="fas fa-medal"></i>
                                    @else
                                    <span>{{ $index + 1 }}</span>
                                    @endif
                            </div>
                        </div>
                        <div class="user-info">
                            <div class="user-avatar enhanced-avatar">
                                <div class="avatar-inner">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="avatar-ring"></div>
                            </div>
                            <div class="user-details">
                                <div class="user-name">{{ $userActivity->user->name ?? 'Unknown User' }}</div>
                                <div class="user-email">{{ $userActivity->user->email ?? 'N/A' }}</div>
                                <div class="user-role">{{ $userActivity->user->role->name ?? 'No Role' }}</div>
                            </div>
                        </div>
                        <div class="activity-stats">
                            <div class="activity-count">{{ number_format($userActivity->count) }}</div>
                            <div class="activity-label">actions</div>
                            <div class="activity-percentage">
                                {{ round(($userActivity->count / max($stats['top_users']->first()->count, 1)) * 100, 1) }}%
                            </div>
                        </div>
                        <div class="activity-visual">
                            <div class="activity-bar">
                                <div class="activity-progress"
                                    style="width: {{ ($userActivity->count / max($stats['top_users']->first()->count, 1)) * 100 }}%">
                                </div>
                            </div>
                            <div class="activity-sparkline">
                                <div class="sparkline-dot"></div>
                                <div class="sparkline-dot"></div>
                                <div class="sparkline-dot"></div>
                                <div class="sparkline-dot"></div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state enhanced-empty">
                        <div class="empty-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>No Activity Data</h4>
                        <p>No user activity data available for this period</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activity Timeline -->
<div class="timeline-section">
    <div class="timeline-card enhanced-card timeline-enhanced">
        <div class="card-header">
            <div class="card-title">
                <div class="title-icon">
                    <i class="fas fa-history"></i>
                    <div class="icon-glow"></div>
                </div>
                <div class="title-content">
                    <h3>Recent Activity Timeline</h3>
                    <p class="title-subtitle">Live system activity feed</p>
                </div>
            </div>
            <div class="card-actions">
                <div class="timeline-controls">
                    <div class="live-indicator">
                        <div class="live-dot"></div>
                        <span>Live</span>
                    </div>
                    <select class="time-filter enhanced-filter">
                        <option value="1h">Last Hour</option>
                        <option value="24h" selected>Last 24 Hours</option>
                        <option value="7d">Last 7 Days</option>
                        <option value="30d">Last 30 Days</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-content">
            <div class="timeline-container enhanced-timeline">
                <div class="timeline-item enhanced-timeline-item" data-type="success">
                    <div class="timeline-marker timeline-marker-success">
                        <i class="fas fa-check"></i>
                        <div class="marker-pulse"></div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <div class="timeline-title">System Health Check</div>
                            <div class="timeline-badge success-badge">Success</div>
                        </div>
                        <div class="timeline-description">Automated system maintenance completed successfully</div>
                        <div class="timeline-meta">
                            <div class="timeline-time">
                                <i class="fas fa-clock"></i>
                                <span>2 minutes ago</span>
                            </div>
                            <div class="timeline-source">
                                <i class="fas fa-server"></i>
                                <span>System</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeline-item enhanced-timeline-item" data-type="info">
                    <div class="timeline-marker timeline-marker-info">
                        <i class="fas fa-user"></i>
                        <div class="marker-pulse"></div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <div class="timeline-title">User Login</div>
                            <div class="timeline-badge info-badge">Login</div>
                        </div>
                        <div class="timeline-description">Admin user logged in from 192.168.1.100</div>
                        <div class="timeline-meta">
                            <div class="timeline-time">
                                <i class="fas fa-clock"></i>
                                <span>15 minutes ago</span>
                            </div>
                            <div class="timeline-source">
                                <i class="fas fa-user-circle"></i>
                                <span>Admin User</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeline-item enhanced-timeline-item" data-type="warning">
                    <div class="timeline-marker timeline-marker-warning">
                        <i class="fas fa-edit"></i>
                        <div class="marker-pulse"></div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <div class="timeline-title">Data Update</div>
                            <div class="timeline-badge warning-badge">Update</div>
                        </div>
                        <div class="timeline-description">Member profile updated by admin</div>
                        <div class="timeline-meta">
                            <div class="timeline-time">
                                <i class="fas fa-clock"></i>
                                <span>1 hour ago</span>
                            </div>
                            <div class="timeline-source">
                                <i class="fas fa-user-edit"></i>
                                <span>Admin User</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeline-item enhanced-timeline-item" data-type="error">
                    <div class="timeline-marker timeline-marker-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div class="marker-pulse"></div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <div class="timeline-title">Failed Login Attempt</div>
                            <div class="timeline-badge error-badge">Failed</div>
                        </div>
                        <div class="timeline-description">Invalid credentials from 192.168.1.50</div>
                        <div class="timeline-meta">
                            <div class="timeline-time">
                                <i class="fas fa-clock"></i>
                                <span>2 hours ago</span>
                            </div>
                            <div class="timeline-source">
                                <i class="fas fa-shield-alt"></i>
                                <span>Security</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Event Distribution Chart
    const eventCtx = document.getElementById('eventDistributionChart').getContext('2d');
    const eventData = @json($stats['events']);

    new Chart(eventCtx, {
        type: 'doughnut',
        data: {
            labels: eventData.map(event => event.event.charAt(0).toUpperCase() + event.event.slice(1)),
            datasets: [{
                data: eventData.map(event => event.count),
                backgroundColor: [
                    '#3B82F6',
                    '#10B981',
                    '#F59E0B',
                    '#EF4444',
                    '#8B5CF6',
                    '#06B6D4',
                    '#84CC16',
                    '#F97316'
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '60%'
        }
    });

    // Add hover effects to stat cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Time filter functionality
    const timeFilter = document.querySelector('.time-filter');
    if (timeFilter) {
        timeFilter.addEventListener('change', function() {
            // Here you would typically make an AJAX request to update the timeline
            console.log('Time filter changed to:', this.value);
        });
    }
});
</script>
@endpush