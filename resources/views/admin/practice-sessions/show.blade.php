@extends('layouts.admin')

@section('title', 'Practice Session Details')
@section('page-title', 'Session Information')

@push('styles')
<style>
body {
    overflow-x: hidden !important;
    max-width: 100vw !important;
}
</style>
@endpush

@section('content')
<div class="practice-session-page">

    <!-- Enhanced Page Header -->
    <div class="page-header enhanced-header">
        <div class="header-background">
            <div class="header-pattern"></div>
            <div class="header-glow"></div>
        </div>
        <div class="header-content">
            <div class="header-text">
                <div class="header-icon">
                    <i class="fas fa-calendar-check"></i>
                    <div class="icon-glow"></div>
                </div>
                <div class="header-details">
                    <h2 class="header-title">Practice Session Details</h2>
                    <p class="header-subtitle">{{ $practiceSession->title }}</p>
                    <div class="header-stats">
                        <div class="stat-item">
                            <span class="stat-number">{{ $practiceSession->status }}</span>
                            <span class="stat-label">Status</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $practiceSession->practice_date->format('M j') }}</span>
                            <span class="stat-label">Date</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $practiceSession->duration }}</span>
                            <span class="stat-label">Duration</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                @permission('manage_practice_attendance')
                <a href="{{ route('admin.practice-sessions.attendance', $practiceSession) }}"
                    class="btn btn-success enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Manage Attendance</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
                @endpermission
                @permission('manage_practice_attendance')
                <div class="export-actions">
                    <a href="{{ route('admin.practice-sessions.export-attendance.excel', $practiceSession) }}"
                        class="btn btn-success enhanced-btn">
                        <div class="btn-content">
                            <i class="fas fa-file-excel"></i>
                            <span>Excel</span>
                        </div>
                        <div class="btn-glow"></div>
                    </a>
                    <a href="{{ route('admin.practice-sessions.export-attendance.pdf', $practiceSession) }}"
                        class="btn btn-danger enhanced-btn">
                        <div class="btn-content">
                            <i class="fas fa-file-pdf"></i>
                            <span>PDF</span>
                        </div>
                        <div class="btn-glow"></div>
                    </a>
                    <a href="{{ route('admin.practice-sessions.export-attendance', $practiceSession) }}"
                        class="btn btn-secondary enhanced-btn">
                        <div class="btn-content">
                            <i class="fas fa-file-csv"></i>
                            <span>CSV</span>
                        </div>
                        <div class="btn-glow"></div>
                    </a>
                </div>
                @endpermission
                @permission('edit_practice_sessions')
                <a href="{{ route('admin.practice-sessions.edit', $practiceSession) }}"
                    class="btn btn-warning enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-edit"></i>
                        <span>Edit Session</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
                @endpermission
                <a href="{{ route('admin.practice-sessions.index') }}" class="btn btn-outline enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Sessions</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Enhanced Session Status Banner -->
    <div class="status-banner status-banner-{{ $practiceSession->status }}">
        <div class="banner-content">
            <i class="fas fa-calendar-check"></i>
            <span class="banner-text">
                @if($practiceSession->isToday() && $practiceSession->isInProgress())
                Session in progress
                @elseif($practiceSession->isToday())
                Session today
                @endif
            </span>
        </div>
    </div>

    <!-- Enhanced Session Information Card -->
    <div class="content-card enhanced-card">
        <div class="card-header enhanced-header">
            <div class="header-content">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Session Information
                </h3>
                <div class="header-meta">
                    <span class="session-id">ID: {{ $practiceSession->id }}</span>
                </div>
            </div>
        </div>
        <div class="card-content">
            <div class="info-grid">
                <div class="info-item">
                    <h4><i class="fas fa-calendar"></i>Basic Details</h4>
                    <div class="info-content">
                        <p><strong>Title:</strong> {{ $practiceSession->title }}</p>
                        <p><strong>Date:</strong>
                            <span class="date-display">{{ $practiceSession->practice_date->format('l, F j, Y') }}</span>
                        </p>
                        <p><strong>Time:</strong>
                            <span class="time-display">
                                {{ \Carbon\Carbon::parse($practiceSession->start_time)->format('g:i A') }} -
                                {{ \Carbon\Carbon::parse($practiceSession->end_time)->format('g:i A') }}
                            </span>
                        </p>
                        <p><strong>Duration:</strong>
                            <span class="duration-badge">{{ $practiceSession->duration }}</span>
                        </p>
                        <p><strong>Status:</strong>
                            @php
                            $statusClasses = [
                            'scheduled' => 'status-badge enhanced-badge status-scheduled',
                            'in_progress' => 'status-badge enhanced-badge status-in_progress',
                            'completed' => 'status-badge enhanced-badge status-completed',
                            'cancelled' => 'status-badge enhanced-badge status-cancelled'
                            ];
                            $statusLabels = [
                            'scheduled' => 'Scheduled',
                            'in_progress' => 'In Progress',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled'
                            ];
                            @endphp
                            <span class="{{ $statusClasses[$practiceSession->status] }}">
                                <div class="status-dot"></div>
                                {{ $statusLabels[$practiceSession->status] }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="info-item">
                    <h4><i class="fas fa-map-marker-alt"></i>Venue & Location</h4>
                    <div class="info-content">
                        @if($practiceSession->venue)
                        <p><strong>Location:</strong> {{ $practiceSession->venue }}</p>
                        @if($practiceSession->venue_address)
                        <p><strong>Address:</strong> {{ $practiceSession->venue_address }}</p>
                        @endif
                        @else
                        <p class="text-muted">Not specified</p>
                        @endif
                    </div>
                </div>

                <div class="info-item">
                    <h4><i class="fas fa-clock"></i>Timing Details</h4>
                    <div class="info-content">
                        @if($practiceSession->isToday())
                        @if($practiceSession->isInProgress())
                        <p class="text-success"><i class="fas fa-play-circle"></i>Currently in progress</p>
                        @elseif(now()->lt(\Carbon\Carbon::parse($practiceSession->start_time)))
                        <p class="text-primary">
                            <i class="fas fa-clock"></i>
                            Starts in
                            {{ now()->diffForHumans(\Carbon\Carbon::parse($practiceSession->start_time), ['parts' => 2]) }}
                        </p>
                        @else
                        <p class="text-muted"><i class="fas fa-check-circle"></i>Session ended</p>
                        @endif
                        @endif
                    </div>
                </div>
            </div>

            @if($practiceSession->description)
            <div class="info-section">
                <h4><i class="fas fa-align-left"></i>Description</h4>
                <div class="description-content">
                    {{ $practiceSession->description }}
                </div>
            </div>
            @endif

            @if($practiceSession->notes)
            <div class="info-section">
                <h4><i class="fas fa-sticky-note"></i>Notes</h4>
                <div class="notes-content">
                    {{ $practiceSession->notes }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Attendance Summary Card -->
    <div class="content-card enhanced-card">
        <div class="card-header enhanced-header">
            <div class="header-content">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i>
                    Attendance Summary
                </h3>
                <div class="header-actions">
                    @permission('manage_practice_attendance')
                    <a href="{{ route('admin.practice-sessions.attendance', $practiceSession) }}"
                        class="btn btn-primary">
                        <i class="fas fa-edit"></i>
                        Edit Attendance
                    </a>
                    @endpermission
                </div>
            </div>
        </div>
        <div class="card-content">
            @php
            $stats = $practiceSession->attendance_count;
            $percentage = $practiceSession->attendance_percentage;
            @endphp

            <!-- Enhanced Attendance Statistics Cards -->
            <div class="stats-grid stats-grid-small">
                <div class="stat-card stat-card-small stat-card-present">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['present'] }}</div>
                        <div class="stat-label">Present</div>
                    </div>
                </div>

                <div class="stat-card stat-card-small stat-card-late">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['late'] }}</div>
                        <div class="stat-label">Late</div>
                    </div>
                </div>

                <div class="stat-card stat-card-small stat-card-absent">
                    <div class="stat-icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['absent'] }}</div>
                        <div class="stat-label">Absent</div>
                    </div>
                </div>

                <div class="stat-card stat-card-small stat-card-excused">
                    <div class="stat-icon">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['excused'] }}</div>
                        <div class="stat-label">Excused</div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Overall Attendance Progress -->
            <div class="attendance-progress">
                <div class="progress-header">
                    <h4>Overall Attendance Rate</h4>
                    <span class="progress-percentage">{{ $percentage }}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $percentage }}%"></div>
                </div>
                <div class="progress-stats">
                    <span class="total-members">Total Members: {{ array_sum($stats) }}</span>
                    <span class="attending-members">Attending: {{ $stats['present'] + $stats['late'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Attendance Records Table Card -->
    <div class="content-card enhanced-card">
        <div class="card-header enhanced-header">
            <div class="header-content">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Attendance Records
                </h3>
                <div class="header-actions">
                    @permission('manage_practice_attendance')
                    <a href="{{ route('admin.practice-sessions.attendance', $practiceSession) }}"
                        class="btn btn-primary">
                        <i class="fas fa-edit"></i>
                        Edit Attendance
                    </a>
                    @endpermission
                </div>
            </div>
        </div>
        <div class="card-content">
            @if($practiceSession->attendances->count() > 0)
            <div class="table-container">
                <table class="data-table enhanced-table">
                    <thead>
                        <tr>
                            <th class="th-member">Member</th>
                            <th class="th-voice">Voice Part</th>
                            <th class="th-status">Status</th>
                            <th class="th-reason">Reason</th>
                            <th class="th-notes">Notes</th>
                            <th class="th-arrival">Arrival Time</th>
                            <th class="th-updated">Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($practiceSession->attendances->sortBy('member.first_name') as $attendance)
                        <tr class="attendance-row attendance-{{ $attendance->status }}">
                            <td data-label="Member" class="td-member">
                                <div class="member-info enhanced-info">
                                    <div class="member-details">
                                        <div class="member-name">{{ $attendance->member->full_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Voice Part" class="td-voice">
                                @if($attendance->member->voice_part)
                                <span
                                    class="voice-badge enhanced-badge voice-{{ strtolower($attendance->member->voice_part) }}">
                                    <i class="fas fa-music"></i>
                                    {{ $attendance->member->voice_part }}
                                </span>
                                @else
                                <span class="no-voice">-</span>
                                @endif
                            </td>
                            <td data-label="Status" class="td-status">
                                @php
                                $statusClasses = [
                                'present' => 'status-badge enhanced-badge status-present',
                                'absent' => 'status-badge enhanced-badge status-absent',
                                'late' => 'status-badge enhanced-badge status-late',
                                'excused' => 'status-badge enhanced-badge status-excused'
                                ];
                                $statusLabels = [
                                'present' => 'Present',
                                'absent' => 'Absent',
                                'late' => 'Late',
                                'excused' => 'Excused'
                                ];
                                @endphp
                                <span class="{{ $statusClasses[$attendance->status] }}">
                                    <div class="status-dot"></div>
                                    {{ $statusLabels[$attendance->status] }}
                                </span>
                            </td>
                            <td data-label="Reason" class="td-reason">
                                @if($attendance->reason)
                                <span class="reason-text">{{ $attendance->reason }}</span>
                                @else
                                <span class="no-reason">-</span>
                                @endif
                            </td>
                            <td data-label="Notes" class="td-notes">
                                @if($attendance->notes)
                                <span class="notes-text">{{ $attendance->notes }}</span>
                                @else
                                <span class="no-notes">-</span>
                                @endif
                            </td>
                            <td data-label="Arrival Time" class="td-arrival">
                                @if($attendance->arrival_time)
                                <span class="arrival-time">
                                    <i class="fas fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($attendance->arrival_time)->format('g:i A') }}
                                </span>
                                @else
                                <span class="no-arrival">-</span>
                                @endif
                            </td>
                            <td data-label="Updated" class="td-updated">
                                <span class="update-time">
                                    <i class="fas fa-history"></i>
                                    {{ $attendance->updated_at->diffForHumans() }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state enhanced-empty-state">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                    <div class="icon-pulse"></div>
                </div>
                <h3>No Attendance Records</h3>
                <p>Attendance has not been marked for this session yet.</p>
                @permission('manage_practice_attendance')
                <a href="{{ route('admin.practice-sessions.attendance', $practiceSession) }}" class="btn btn-primary">
                    <i class="fas fa-clipboard-check"></i>
                    Mark Attendance
                </a>
                @endpermission
            </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Session Actions Card -->
    @if($practiceSession->status === 'scheduled' && $practiceSession->isToday())
    <div class="content-card enhanced-card">
        <div class="card-header enhanced-header">
            <div class="header-content">
                <h3 class="card-title">
                    <i class="fas fa-cogs"></i>
                    Session Actions
                </h3>
                <div class="header-meta">
                    <span class="action-status">Ready for actions</span>
                </div>
            </div>
        </div>
        <div class="card-content">
            <div class="action-buttons enhanced-actions">
                @permission('edit_practice_sessions')
                <button type="button" class="btn btn-warning enhanced-btn" onclick="updateSessionStatus('in_progress')">
                    <div class="btn-content">
                        <i class="fas fa-play"></i>
                        <span>Start Session</span>
                    </div>
                    <div class="btn-glow"></div>
                </button>
                @endpermission
                @permission('manage_practice_attendance')
                <a href="{{ route('admin.practice-sessions.attendance', $practiceSession) }}"
                    class="btn btn-success enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Take Attendance</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
                @endpermission
            </div>
        </div>
    </div>
    @endif

</div> <!-- End practice-session-page -->

@endsection

@push('scripts')
<script>
function updateSessionStatus(status) {
    if (confirm('Are you sure you want to update the session status?')) {
        // This would need a route and controller method to handle status updates
        console.log('Updating session status to:', status);
    }
}

// Prevent page horizontal scroll when table is being scrolled
document.addEventListener('DOMContentLoaded', function() {
    const tableContainer = document.querySelector('.practice-session-page .table-container');
    const body = document.body;
    const html = document.documentElement;

    // Prevent body and html horizontal scroll
    body.style.overflowX = 'hidden';
    body.style.maxWidth = '100vw';
    html.style.overflowX = 'hidden';
    html.style.maxWidth = '100vw';

    // Ensure all page elements fit within viewport
    const pageElements = document.querySelectorAll('.practice-session-page *');
    pageElements.forEach(element => {
        if (element !== tableContainer) {
            element.style.maxWidth = '100%';
            element.style.boxSizing = 'border-box';
        }
    });

    if (tableContainer) {
        // Handle table scroll to prevent page scroll
        tableContainer.addEventListener('wheel', function(e) {
            if (e.deltaX !== 0) {
                e.preventDefault();
                this.scrollLeft += e.deltaX;
            }
        }, {
            passive: false
        });

        // Prevent page scroll when table is at scroll boundaries
        tableContainer.addEventListener('scroll', function() {
            if (this.scrollLeft <= 0) {
                this.scrollLeft = 0;
            }
            const maxScroll = this.scrollWidth - this.clientWidth;
            if (this.scrollLeft >= maxScroll) {
                this.scrollLeft = maxScroll;
            }
        });
    }

    // Handle window resize to ensure content fits
    window.addEventListener('resize', function() {
        const viewportWidth = window.innerWidth;
        const pageElement = document.querySelector('.practice-session-page');
        if (pageElement) {
            const pageWidth = pageElement.scrollWidth;
            if (pageWidth > viewportWidth) {
                pageElement.style.maxWidth = viewportWidth + 'px';
            }
        }
    });
});
</script>
@endpush