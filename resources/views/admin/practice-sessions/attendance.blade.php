@extends('layouts.admin')

@section('title', 'Manage Attendance')
@section('page-title', 'Session Attendance')

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
                <i class="fas fa-clipboard-check"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Manage Attendance</h2>
                <p class="header-subtitle">{{ $practiceSession->title }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $activeSingers->count() }}</span>
                        <span class="stat-label">Total Members</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $practiceSession->practice_date->format('M j') }}</span>
                        <span class="stat-label">Session Date</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">Attendance</span>
                        <span class="stat-label">Mode</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
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
            <a href="{{ route('admin.practice-sessions.show', $practiceSession) }}" class="btn btn-secondary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-eye"></i>
                    <span>View Session</span>
                </div>
            </a>
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
            Session in progress - Taking attendance
            @elseif($practiceSession->isToday())
            Session today - Mark attendance
            @endif
        </span>
    </div>
</div>

<!-- Enhanced Member Count Summary Card -->
<div class="content-card enhanced-card">
    <div class="card-header enhanced-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-users"></i>
                Member Summary
            </h3>
            <div class="header-meta">
                <span class="session-date">{{ $practiceSession->practice_date->format('M j, Y') }}</span>
            </div>
        </div>
    </div>
    <div class="card-content">
        <div class="member-summary">
            <div class="summary-item">
                <span class="summary-number">{{ $activeSingers->count() }}</span>
                <span class="summary-label">Total Members</span>
            </div>
            <div class="summary-item">
                <span class="summary-number">{{ $voicePartStats['soprano'] }}</span>
                <span class="summary-label">Sopranos</span>
            </div>
            <div class="summary-item">
                <span class="summary-number">{{ $voicePartStats['alto'] }}</span>
                <span class="summary-label">Altos</span>
            </div>
            <div class="summary-item">
                <span class="summary-number">{{ $voicePartStats['tenor'] }}</span>
                <span class="summary-label">Tenors</span>
            </div>
            <div class="summary-item">
                <span class="summary-number">{{ $voicePartStats['bass'] }}</span>
                <span class="summary-label">Basses</span>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Attendance Management Card -->
<div class="content-card enhanced-card">
    <div class="card-header enhanced-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-clipboard-check"></i>
                Mark Attendance
            </h3>
            <div class="quick-actions">
                <button type="button" onclick="markAllPresent()" class="btn btn-sm btn-success enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-check-double"></i>
                        <span>Mark All Present</span>
                    </div>
                </button>
                <button type="button" onclick="markAllExcused()" class="btn btn-sm btn-primary enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-user-clock"></i>
                        <span>Mark All Excused</span>
                    </div>
                </button>
                <button type="button" onclick="clearAllReasons()" class="btn btn-sm btn-secondary enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-eraser"></i>
                        <span>Clear All Reasons</span>
                    </div>
                </button>
                <button type="button" onclick="toggleBulkEdit()" class="btn btn-sm btn-warning enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-edit"></i>
                        <span>Bulk Edit</span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
        @endif

        <!-- Enhanced Bulk Edit Panel -->
        <div id="bulkEditPanel" class="bulk-edit-panel hidden">
            <div class="bulk-edit-header">
                <h4><i class="fas fa-edit"></i>Bulk Edit Selected Members</h4>
                <button type="button" onclick="toggleBulkEdit()" class="btn btn-sm btn-outline">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="bulk-edit-form">
                <div class="form-group">
                    <label for="bulkStatus" class="form-label">Status</label>
                    <select id="bulkStatus" class="form-select enhanced-select">
                        <option value="">Keep Current</option>
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                        <option value="late">Late</option>
                        <option value="excused">Excused</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bulkReason" class="form-label">Reason</label>
                    <input type="text" id="bulkReason" placeholder="Common reason..." class="form-input enhanced-input">
                </div>
                <div class="form-group">
                    <label for="bulkNotes" class="form-label">Notes</label>
                    <input type="text" id="bulkNotes" placeholder="Common notes..." class="form-input enhanced-input">
                </div>
            </div>
            <div class="bulk-edit-actions">
                <button type="button" onclick="applyBulkEdit()" class="btn btn-primary enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-check"></i>
                        <span>Apply to Selected</span>
                    </div>
                </button>
                <button type="button" onclick="selectAllMembers()" class="btn btn-secondary enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-check-square"></i>
                        <span>Select All</span>
                    </div>
                </button>
                <button type="button" onclick="deselectAllMembers()" class="btn btn-outline enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-square"></i>
                        <span>Deselect All</span>
                    </div>
                </button>
            </div>
        </div>

        <form action="{{ route('admin.practice-sessions.update-attendance', $practiceSession) }}" method="POST"
            id="attendance-form">
            @csrf

            <div class="table-container">
                <table class="data-table enhanced-table">
                    <thead>
                        <tr>
                            <th class="checkbox-cell">
                                <input type="checkbox" id="selectAll" onchange="toggleAllMembers(this)">
                            </th>
                            <th class="th-member">Member</th>
                            <th class="th-voice">Voice Part</th>
                            <th class="th-status">Status</th>
                            <th class="th-reason">Reason</th>
                            <th class="th-notes">Notes</th>
                            <th class="th-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activeSingers as $member)
                        @php
                        $attendance = $member->practiceAttendance($practiceSession->id);
                        $status = $attendance ? $attendance->status : 'present';
                        $reason = $attendance ? $attendance->reason : '';
                        $notes = $attendance ? $attendance->notes : '';
                        @endphp
                        <tr class="member-row member-{{ $status }}">
                            <td class="checkbox-cell">
                                <input type="checkbox" name="selected_members[]" value="{{ $member->id }}"
                                    class="member-checkbox">
                            </td>
                            <td data-label="Member" class="td-member">
                                <div class="member-info enhanced-info">
                                    <div class="member-details">
                                        <div class="member-name">{{ $member->full_name }}</div>
                                        @if($member->phone)
                                        <div class="member-phone">
                                            <i class="fas fa-phone"></i>
                                            {{ $member->phone }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td data-label="Voice Part" class="td-voice">
                                @if($member->voice_part)
                                <span class="voice-badge enhanced-badge voice-{{ strtolower($member->voice_part) }}">
                                    <i class="fas fa-music"></i>
                                    {{ $member->voice_part }}
                                </span>
                                @else
                                <span class="no-voice">-</span>
                                @endif
                            </td>
                            <td data-label="Status" class="td-status">
                                <select name="attendance[{{ $member->id }}][status]"
                                    class="form-select enhanced-select attendance-status" onchange="updateRowClass(this)">
                                    <option value="present" {{ $status === 'present' ? 'selected' : '' }}>
                                        Present
                                    </option>
                                    <option value="absent" {{ $status === 'absent' ? 'selected' : '' }}>
                                        Absent
                                    </option>
                                    <option value="late" {{ $status === 'late' ? 'selected' : '' }}>
                                        Late
                                    </option>
                                    <option value="excused" {{ $status === 'excused' ? 'selected' : '' }}>
                                        Excused
                                    </option>
                                </select>
                            </td>
                            <td data-label="Reason" class="td-reason">
                                <input type="text" name="attendance[{{ $member->id }}][reason]" value="{{ $reason }}"
                                    class="form-input enhanced-input" placeholder="Reason for absence/late">
                            </td>
                            <td data-label="Notes" class="td-notes">
                                <input type="text" name="attendance[{{ $member->id }}][notes]" value="{{ $notes }}"
                                    class="form-input enhanced-input" placeholder="Additional notes">
                            </td>
                            <td data-label="Actions" class="td-actions">
                                <div class="action-buttons enhanced-actions">
                                    <button type="button" onclick="markPresent(this)"
                                        class="btn btn-sm btn-success action-btn" title="Mark Present">
                                        <i class="fas fa-check"></i>
                                        <span class="btn-tooltip">Present</span>
                                    </button>
                                    <button type="button" onclick="markAbsent(this)"
                                        class="btn btn-sm btn-danger action-btn" title="Mark Absent">
                                        <i class="fas fa-times"></i>
                                        <span class="btn-tooltip">Absent</span>
                                    </button>
                                    <button type="button" onclick="markExcused(this)"
                                        class="btn btn-sm btn-primary action-btn" title="Mark Excused">
                                        <i class="fas fa-user-clock"></i>
                                        <span class="btn-tooltip">Excused</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary enhanced-btn btn-lg">
                    <div class="btn-content">
                        <i class="fas fa-save"></i>
                        <span>Save Attendance</span>
                    </div>
                    <div class="btn-glow"></div>
                </button>
                <a href="{{ route('admin.practice-sessions.show', $practiceSession) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Enhanced Attendance Summary Preview Card -->
<div class="content-card enhanced-card">
    <div class="card-header enhanced-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-chart-bar"></i>
                Attendance Preview
            </h3>
            <div class="header-meta">
                <span class="preview-status">Live updates</span>
            </div>
        </div>
    </div>
    <div class="card-content">
        <div class="preview-stats">
            <div class="preview-item preview-present">
                <span class="preview-count" id="previewPresent">{{ $attendanceStats['present'] }}</span>
                <span class="preview-label">Present</span>
            </div>
            <div class="preview-item preview-late">
                <span class="preview-count" id="previewLate">{{ $attendanceStats['late'] }}</span>
                <span class="preview-label">Late</span>
            </div>
            <div class="preview-item preview-absent">
                <span class="preview-count" id="previewAbsent">{{ $attendanceStats['absent'] }}</span>
                <span class="preview-label">Absent</span>
            </div>
            <div class="preview-item preview-excused">
                <span class="preview-count" id="previewExcused">{{ $attendanceStats['excused'] }}</span>
                <span class="preview-label">Excused</span>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Global functions that need to be accessible via onclick attributes
    function toggleBulkEdit() {
        try {
            const panel = document.getElementById('bulkEditPanel');
            if (panel) {
                panel.classList.toggle('hidden');
            }
        } catch (error) {
            console.error('Error toggling bulk edit:', error);
        }
    }

    function markAllPresent() {
        try {
            const checkboxes = document.querySelectorAll('.member-checkbox:checked');
            const statusSelects = document.querySelectorAll('.attendance-status');

            checkboxes.forEach(function(checkbox) {
                const row = checkbox.closest('tr');
                const statusSelect = row.querySelector('.attendance-status');
                if (statusSelect) {
                    statusSelect.value = 'present';
                    updateRowClass(statusSelect);
                }
            });

            // Update all status selects if no checkboxes are selected
            if (checkboxes.length === 0) {
                statusSelects.forEach(function(select) {
                    select.value = 'present';
                    updateRowClass(select);
                });
            }

            updateAttendancePreview();
            showToast('All selected members marked as present', 'success');
        } catch (error) {
            console.error('Error marking all present:', error);
            showToast('Error marking all present', 'error');
        }
    }

    function markAllExcused() {
        try {
            const checkboxes = document.querySelectorAll('.member-checkbox:checked');
            const statusSelects = document.querySelectorAll('.attendance-status');

            checkboxes.forEach(function(checkbox) {
                const row = checkbox.closest('tr');
                const statusSelect = row.querySelector('.attendance-status');
                if (statusSelect) {
                    statusSelect.value = 'excused';
                    updateRowClass(statusSelect);
                }
            });

            // Update all status selects if no checkboxes are selected
            if (checkboxes.length === 0) {
                statusSelects.forEach(function(select) {
                    select.value = 'excused';
                    updateRowClass(select);
                });
            }

            updateAttendancePreview();
            showToast('All selected members marked as excused', 'success');
        } catch (error) {
            console.error('Error marking all excused:', error);
            showToast('Error marking all excused', 'error');
        }
    }

    function clearAllReasons() {
        try {
            const checkboxes = document.querySelectorAll('.member-checkbox:checked');
            const reasonInputs = document.querySelectorAll('input[name*="[reason]"]');
            const notesInputs = document.querySelectorAll('input[name*="[notes]"]');

            if (checkboxes.length > 0) {
                // Clear only selected members
                checkboxes.forEach(function(checkbox) {
                    const row = checkbox.closest('tr');
                    const reasonInput = row.querySelector('input[name*="[reason]"]');
                    const notesInput = row.querySelector('input[name*="[notes]"]');
                    if (reasonInput) reasonInput.value = '';
                    if (notesInput) notesInput.value = '';
                });
            } else {
                // Clear all if no checkboxes selected
                reasonInputs.forEach(function(input) {
                    input.value = '';
                });
                notesInputs.forEach(function(input) {
                    input.value = '';
                });
            }

            showToast('Reasons and notes cleared', 'success');
        } catch (error) {
            console.error('Error clearing reasons:', error);
            showToast('Error clearing reasons', 'error');
        }
    }

    function selectAllMembers() {
        try {
            const checkboxes = document.querySelectorAll('.member-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true;
            });
            showToast('All members selected', 'info');
        } catch (error) {
            console.error('Error selecting all members:', error);
            showToast('Error selecting all members', 'error');
        }
    }

    function deselectAllMembers() {
        try {
            const checkboxes = document.querySelectorAll('.member-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
            showToast('All members deselected', 'info');
        } catch (error) {
            console.error('Error deselecting all members:', error);
            showToast('Error deselecting all members', 'error');
        }
    }

    function toggleAllMembers(selectAllCheckbox) {
        try {
            const checkboxes = document.querySelectorAll('.member-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        } catch (error) {
            console.error('Error toggling all members:', error);
        }
    }

    function applyBulkEdit() {
        try {
            const statusSelect = document.getElementById('bulkStatus');
            const reasonInput = document.getElementById('bulkReason');
            const notesInput = document.getElementById('bulkNotes');

            if (!statusSelect.value && !reasonInput.value && !notesInput.value) {
                showToast('Please select at least one field to update', 'warning');
                return;
            }

            const checkboxes = document.querySelectorAll('.member-checkbox:checked');
            if (checkboxes.length === 0) {
                showToast('Please select at least one member', 'warning');
                return;
            }

            checkboxes.forEach(function(checkbox) {
                const row = checkbox.closest('tr');

                if (statusSelect.value) {
                    const statusField = row.querySelector('.attendance-status');
                    if (statusField) {
                        statusField.value = statusSelect.value;
                        updateRowClass(statusField);
                    }
                }

                if (reasonInput.value) {
                    const reasonField = row.querySelector('input[name*="[reason]"]');
                    if (reasonField) reasonField.value = reasonInput.value;
                }

                if (notesInput.value) {
                    const notesField = row.querySelector('input[name*="[notes]"]');
                    if (notesField) notesField.value = notesInput.value;
                }
            });

            updateAttendancePreview();
            showToast('Bulk edit applied successfully', 'success');

            // Close bulk edit panel
            toggleBulkEdit();
        } catch (error) {
            console.error('Error applying bulk edit:', error);
            showToast('Error applying bulk edit', 'error');
        }
    }

    function markPresent(select) {
        try {
            updateRowClass(select);
            updateAttendancePreview();
        } catch (error) {
            console.error('Error marking present:', error);
        }
    }

    function markAbsent(select) {
        try {
            updateRowClass(select);
            updateAttendancePreview();
        } catch (error) {
            console.error('Error marking absent:', error);
        }
    }

    function markExcused(select) {
        try {
            updateRowClass(select);
            updateAttendancePreview();
        } catch (error) {
            console.error('Error marking excused:', error);
        }
    }

    function updateRowClass(select) {
        try {
            const row = select.closest('tr');
            if (row) {
                // Remove existing status classes
                row.classList.remove('member-present', 'member-absent', 'member-late', 'member-excused');

                // Add new status class
                const status = select.value;
                if (status) {
                    row.classList.add('member-' + status);
                }
            }
        } catch (error) {
            console.error('Error updating row class:', error);
        }
    }

    function updateAttendancePreview() {
        try {
            const statusSelects = document.querySelectorAll('.attendance-status');
            let present = 0,
                absent = 0,
                late = 0,
                excused = 0;

            statusSelects.forEach(function(select) {
                switch (select.value) {
                    case 'present':
                        present++;
                        break;
                    case 'absent':
                        absent++;
                        break;
                    case 'late':
                        late++;
                        break;
                    case 'excused':
                        excused++;
                        break;
                }
            });

            const preview = document.getElementById('previewPresent');
            if (preview) preview.textContent = present;
            const previewLate = document.getElementById('previewLate');
            if (previewLate) previewLate.textContent = late;
            const previewAbsent = document.getElementById('previewAbsent');
            if (previewAbsent) previewAbsent.textContent = absent;
            const previewExcused = document.getElementById('previewExcused');
            if (previewExcused) previewExcused.textContent = excused;
        } catch (error) {
            console.error('Error updating attendance preview:', error);
        }
    }

    // Use the global showToast function from admin layout
    function showToast(message, type = 'info') {
        if (window.showToast) {
            window.showToast(message, type);
        } else {
            console.log(`${type.toUpperCase()}: ${message}`);
        }
    }

    function initializeBulkEdit() {
        try {
            // Initialize select all checkbox
            const selectAllCheckbox = document.getElementById('selectAll');
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    toggleAllMembers(this);
                });
            }
        } catch (error) {
            console.error('Error initializing bulk edit:', error);
        }
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize bulk edit functionality
        initializeBulkEdit();

        // Initialize attendance preview
        updateAttendancePreview();

        // Add event listeners for status changes
        document.querySelectorAll('.attendance-status').forEach(function(select) {
            select.addEventListener('change', function() {
                updateRowClass(this);
                updateAttendancePreview();
            });
        });

        // Add event listeners for reason and notes inputs
        document.querySelectorAll('input[name*="[reason]"], input[name*="[notes]"]').forEach(function(input) {
            input.addEventListener('input', function() {
                // Input change event handled silently
            });
        });
    });
</script>
@endpush