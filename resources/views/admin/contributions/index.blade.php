@extends('layouts.admin')

@section('title', 'Contributions')
@section('page-title', 'Contributions')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="header-text">
            <h2 class="header-title">Contributions</h2>
            <p class="header-subtitle">Manage financial contributions and donations</p>
        </div>
        <div class="header-actions">
            @permission('create_contributions')
            <a href="{{ route('admin.contributions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add Contribution
            </a>
            @endpermission
        </div>
    </div>
</div>

<div class="content-card">
    <div class="card-header">
        <form method="GET" action="{{ route('admin.contributions.index') }}" class="header-filters">
            <div class="search-box">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search contributions..." class="search-input">
                <i class="fas fa-search search-icon"></i>
            </div>
            <div class="filter-group">
                <select name="type" class="filter-select">
                    <option value="">All Types</option>
                    <option value="monthly" {{ request('type') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="project" {{ request('type') === 'project' ? 'selected' : '' }}>Project</option>
                    <option value="recording" {{ request('type') === 'recording' ? 'selected' : '' }}>Recording</option>
                    <option value="event" {{ request('type') === 'event' ? 'selected' : '' }}>Event</option>
                </select>
                <select name="status" class="filter-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('admin.contributions.index') }}" class="btn btn-secondary">Clear Filters</a>
            </div>
        </form>
    </div>

    <div class="card-content">
        @if($contributions && $contributions->count() > 0)
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Contributor</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Project/Event</th>
                        @permission('view_contributions')
                        <th>Actions</th>
                        @endpermission
                    </tr>
                </thead>
                <tbody>
                    @foreach($contributions as $contribution)
                    <tr>
                        <td>
                            <div class="contributor-info">
                                <div class="contributor-name">{{ $contribution->contributor_name }}</div>
                                <div class="contributor-email">{{ $contribution->contributor_email }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="type-badge type-{{ $contribution->type }}">
                                {{ ucfirst($contribution->type) }}
                            </span>
                        </td>
                        <td>
                            <div class="amount-info">
                                <div class="amount">${{ number_format($contribution->amount, 2) }}</div>
                                <div class="currency">{{ $contribution->currency ?? 'RWF' }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="date-info">
                                <div class="date">{{ $contribution->contribution_date ? $contribution->contribution_date->format('M j, Y') : 'N/A' }}</div>
                                <div class="time">{{ $contribution->contribution_date ? $contribution->contribution_date->format('g:i A') : '' }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $contribution->status }}">
                                {{ ucfirst($contribution->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="project-info">
                                @if($contribution->project_name)
                                <div class="project-name">{{ $contribution->project_name }}</div>
                                <div class="project-type">{{ $contribution->project_type ?? 'N/A' }}</div>
                                @else
                                <span class="text-muted">General</span>
                                @endif
                            </div>
                        </td>
                        @permission('view_contributions')
                        <td>
                            <div class="action-buttons">
                                @permission('view_contributions')
                                <a href="{{ route('admin.contributions.show', $contribution) }}" class="btn btn-sm btn-secondary" title="View Contribution">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endpermission

                                @permission('edit_contributions')
                                <a href="{{ route('admin.contributions.edit', $contribution) }}" class="btn btn-sm btn-primary" title="Edit Contribution">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endpermission

                                @permission('delete_contributions')
                                <form method="POST" action="{{ route('admin.contributions.destroy', $contribution) }}" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this contribution?')" title="Delete Contribution">
                                        <i class="fas fa-trash"></i>
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

        <div class="pagination-wrapper">
            {{ $contributions->links() }}
        </div>
        @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <h3>No Contributions Found</h3>
            <p>Get started by recording your first contribution.</p>
            @permission('create_contributions')
            <a href="{{ route('admin.contributions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add Contribution
            </a>
            @endpermission
        </div>
        @endif
    </div>
</div>




@endsection