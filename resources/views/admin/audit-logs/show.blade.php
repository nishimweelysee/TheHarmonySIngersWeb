@extends('layouts.admin')

@section('title', 'Audit Log Details')
@section('page-title', 'Audit Log Details')

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
                <h2 class="header-title">Audit Log Details</h2>
                <p class="header-subtitle">Detailed information about this audit log entry</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">#{{ $auditLog->id }}</span>
                        <span class="stat-label">Log ID</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ ucfirst($auditLog->event) }}</span>
                        <span class="stat-label">Event Type</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $auditLog->created_at->format('M d, Y') }}</span>
                        <span class="stat-label">Date</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Logs</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="dashboard-grid">
    <!-- Basic Information -->
    <div class="dashboard-card">
        <div class="card-header">
            <div class="header-content">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Basic Information
                </h3>
            </div>
        </div>
        <div class="card-content">
            <div class="info-grid">
                <div class="info-item">
                    <label class="info-label">Event Type</label>
                    <div class="info-value">
                        <span class="badge badge-{{ $auditLog->event === 'created' ? 'success' : ($auditLog->event === 'updated' ? 'warning' : ($auditLog->event === 'deleted' ? 'danger' : 'info')) }}">
                            {{ ucfirst($auditLog->event) }}
                        </span>
                    </div>
                </div>

                <div class="info-item">
                    <label class="info-label">Description</label>
                    <div class="info-value">{{ $auditLog->formatted_description }}</div>
                </div>

                <div class="info-item">
                    <label class="info-label">Date & Time</label>
                    <div class="info-value">
                        {{ $auditLog->created_at->format('F j, Y \a\t g:i A') }}
                        <small class="text-muted">({{ $auditLog->created_at->diffForHumans() }})</small>
                    </div>
                </div>

                <div class="info-item">
                    <label class="info-label">User</label>
                    <div class="info-value">
                        @if($auditLog->user)
                        <div class="user-info">
                            <i class="fas fa-user"></i>
                            {{ $auditLog->user->name }}
                            <small class="text-muted">({{ $auditLog->user->email }})</small>
                        </div>
                        @else
                        <span class="text-muted">System</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Technical Details -->
    <div class="dashboard-card">
        <div class="card-header">
            <div class="header-content">
                <h3 class="card-title">
                    <i class="fas fa-cogs"></i>
                    Technical Details
                </h3>
            </div>
        </div>
        <div class="card-content">
            <div class="info-grid">
                <div class="info-item">
                    <label class="info-label">IP Address</label>
                    <div class="info-value">{{ $auditLog->ip_address ?? 'N/A' }}</div>
                </div>

                <div class="info-item">
                    <label class="info-label">User Agent</label>
                    <div class="info-value">
                        @if($auditLog->user_agent)
                        <code class="text-sm">{{ Str::limit($auditLog->user_agent, 80) }}</code>
                        @else
                        <span class="text-muted">N/A</span>
                        @endif
                    </div>
                </div>

                <div class="info-item">
                    <label class="info-label">URL</label>
                    <div class="info-value">
                        @if($auditLog->url)
                        <a href="{{ $auditLog->url }}" target="_blank" class="text-primary">
                            {{ Str::limit($auditLog->url, 60) }}
                            <i class="fas fa-external-link-alt ml-1"></i>
                        </a>
                        @else
                        <span class="text-muted">N/A</span>
                        @endif
                    </div>
                </div>

                @if($auditLog->auditable_type)
                <div class="info-item">
                    <label class="info-label">Model</label>
                    <div class="info-value">
                        <span class="badge badge-light">{{ class_basename($auditLog->auditable_type) }}</span>
                        @if($auditLog->auditable_id)
                        <span class="text-muted">#{{ $auditLog->auditable_id }}</span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @if($auditLog->old_values || $auditLog->new_values)
    <!-- Changes Made -->
    <div class="dashboard-card full-width">
        <div class="card-header">
            <div class="header-content">
                <h3 class="card-title">
                    <i class="fas fa-exchange-alt"></i>
                    Changes Made
                </h3>
            </div>
        </div>
        <div class="card-content">
            @if($auditLog->changes)
            <div class="changes-list">
                @foreach($auditLog->changes as $field => $change)
                <div class="change-item">
                    <div class="change-field">
                        <strong>{{ ucfirst(str_replace('_', ' ', $field)) }}</strong>
                    </div>
                    <div class="change-values">
                        <div class="change-old">
                            <label>Before:</label>
                            <span class="old-value">{{ $change['old'] ?? 'N/A' }}</span>
                        </div>
                        <div class="change-new">
                            <label>After:</label>
                            <span class="new-value">{{ $change['new'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="no-changes">
                <i class="fas fa-info-circle"></i>
                <span>No field changes recorded for this event.</span>
            </div>
            @endif
        </div>
    </div>
    @endif

    @if($auditLog->metadata)
    <!-- Metadata -->
    <div class="dashboard-card">
        <div class="card-header">
            <div class="header-content">
                <h3 class="card-title">
                    <i class="fas fa-database"></i>
                    Additional Data
                </h3>
            </div>
        </div>
        <div class="card-content">
            <pre class="metadata-display">{{ json_encode($auditLog->metadata, JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>
    @endif
</div>

<style>
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: var(--space-4);
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: var(--space-2);
    }

    .info-label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        color: var(--gray-900);
        font-size: 0.95rem;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }

    .changes-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
    }

    .change-item {
        padding: var(--space-4);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        background: var(--gray-50);
    }

    .change-field {
        margin-bottom: var(--space-3);
        font-size: 1rem;
        color: var(--gray-900);
    }

    .change-values {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--space-4);
    }

    .change-old,
    .change-new {
        display: flex;
        flex-direction: column;
        gap: var(--space-1);
    }

    .change-old label,
    .change-new label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--gray-600);
    }

    .old-value {
        padding: var(--space-2);
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: var(--radius);
        color: #dc2626;
        font-family: monospace;
        font-size: 0.875rem;
    }

    .new-value {
        padding: var(--space-2);
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: var(--radius);
        color: #16a34a;
        font-family: monospace;
        font-size: 0.875rem;
    }

    .no-changes {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-6);
        text-align: center;
        color: var(--gray-600);
        justify-content: center;
    }

    .metadata-display {
        background: var(--gray-100);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        padding: var(--space-4);
        font-size: 0.875rem;
        color: var(--gray-700);
        overflow-x: auto;
        white-space: pre-wrap;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    @media (max-width: 768px) {
        .change-values {
            grid-template-columns: 1fr;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection