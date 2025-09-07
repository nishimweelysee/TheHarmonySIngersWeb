@extends('layouts.admin')

@section('title', 'Members')
@section('page-title', 'Manage Members')
@section('page-icon', 'users')

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
                <h2 class="header-title">Members Management</h2>
                <p class="header-subtitle">Manage choir members and singers with ease</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $members->total() }}</span>
                        <span class="stat-label">Total Members</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $members->where('is_active', true)->count() }}</span>
                        <span class="stat-label">Active</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $members->where('type', 'singer')->count() }}</span>
                        <span class="stat-label">Singers</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('create_members')
            <a href="{{ route('admin.members.create') }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-plus"></i>
                    <span>Add New Member</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission

            <!-- Export Actions -->
            <div class="export-actions">
                <a href="{{ route('admin.members.export.excel', request()->query()) }}"
                    class="btn btn-success enhanced-btn" title="Export to Excel">
                    <div class="btn-content">
                        <i class="fas fa-file-excel"></i>
                        <span>Excel</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>

                <a href="{{ route('admin.members.export.pdf', request()->query()) }}"
                    class="btn btn-danger enhanced-btn" title="Export to PDF">
                    <div class="btn-content">
                        <i class="fas fa-file-pdf"></i>
                        <span>PDF</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>

                <!-- Certificate Printing Actions -->
                <button onclick="printSelectedCertificates()" class="btn btn-info enhanced-btn"
                    title="Print Certificates for Selected Members" id="printSelectedBtn" disabled>
                    <div class="btn-content">
                        <i class="fas fa-certificate"></i>
                        <span>Print Selected</span>
                    </div>
                    <div class="btn-glow"></div>
                </button>

                <button onclick="printFilteredCertificates()" class="btn btn-warning enhanced-btn"
                    title="Print Certificates for All Filtered Members">
                    <div class="btn-content">
                        <i class="fas fa-print"></i>
                        <span>Print All</span>
                    </div>
                    <div class="btn-glow"></div>
                </button>
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

        <form method="GET" action="{{ route('admin.members.index') }}" class="filters-form" id="filtersForm">
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
                        <label class="filter-label">Member Type</label>
                        <select name="type" class="filter-select enhanced-select">
                            <option value="">All Types</option>
                            <option value="singer" {{ request('type') === 'singer' ? 'selected' : '' }}>Singers</option>
                            <option value="general" {{ request('type') === 'general' ? 'selected' : '' }}>General
                                Members</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Voice Part</label>
                        <select name="voice" class="filter-select enhanced-select">
                            <option value="">All Voice Parts</option>
                            <option value="soprano" {{ request('voice') === 'soprano' ? 'selected' : '' }}>Soprano
                            </option>
                            <option value="alto" {{ request('voice') === 'alto' ? 'selected' : '' }}>Alto</option>
                            <option value="tenor" {{ request('voice') === 'tenor' ? 'selected' : '' }}>Tenor</option>
                            <option value="bass" {{ request('voice') === 'bass' ? 'selected' : '' }}>Bass</option>
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
                    <a href="{{ route('admin.members.index') }}" class="btn btn-outline clear-btn">
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
                Members Directory
            </h3>
            <div class="header-meta">
                <span class="results-count">{{ $members->count() }} of {{ $members->total() }} members</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        @if($members->count() > 0)
        <div class="table-container">
            <table class="data-table enhanced-table">
                <thead>
                    <tr>
                        <th class="th-select">
                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                        </th>
                        <th class="th-photo">Photo</th>
                        <th class="th-name">Name & Contact</th>
                        <th class="th-type">Type</th>
                        <th class="th-voice">Voice Part</th>
                        <th class="th-join">Join Date</th>
                        <th class="th-status">Status</th>
                        @permission('view_members')
                        <th class="th-actions">Actions</th>
                        @endpermission
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                    <tr class="member-row">
                        <td data-label="Select" class="td-select">
                            <input type="checkbox" class="member-checkbox" value="{{ $member->id }}"
                                onchange="updatePrintButton()">
                        </td>
                        <td data-label="Photo" class="td-photo">
                            @if($member->profile_photo)
                            <div class="member-photo enhanced-photo">
                                <img src="{{ Storage::url($member->profile_photo) }}" alt="Profile Photo">
                                <div class="photo-overlay"></div>
                            </div>
                            @else
                            <div class="member-photo-placeholder enhanced-placeholder">
                                <i class="fas fa-user"></i>
                                <div class="placeholder-glow"></div>
                            </div>
                            @endif
                        </td>

                        <td data-label="Name & Contact" class="td-info">
                            <div class="member-info enhanced-info">
                                <div class="member-name">{{ $member->full_name }}</div>
                                <div class="member-email">{{ $member->email }}</div>
                                @if($member->phone)
                                <div class="member-phone">
                                    <i class="fas fa-phone"></i>
                                    {{ $member->phone }}
                                </div>
                                @endif
                            </div>
                        </td>

                        <td data-label="Type" class="td-type">
                            @if($member->type === 'singer')
                            <span class="type-badge enhanced-badge singer-badge">
                                <i class="fas fa-music"></i>
                                Singer
                            </span>
                            @else
                            <span class="type-badge enhanced-badge general-badge">
                                <i class="fas fa-user-friends"></i>
                                General Member
                            </span>
                            @endif
                        </td>

                        <td data-label="Voice Part" class="td-voice">
                            @if($member->voice_part)
                            <span class="voice-badge enhanced-badge voice-{{ $member->voice_part }}">
                                <i class="fas fa-music"></i>
                                {{ ucfirst($member->voice_part) }}
                            </span>
                            @else
                            <span class="no-voice">-</span>
                            @endif
                        </td>

                        <td data-label="Join Date" class="td-join">
                            <div class="join-date">
                                <div class="date-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="date-text">
                                    <span class="date-day">{{ $member->join_date->format('M j') }}</span>
                                    <span class="date-year">{{ $member->join_date->format('Y') }}</span>
                                </div>
                            </div>
                        </td>

                        <td data-label="Status" class="td-status">
                            <span class="status-badge enhanced-badge {{ $member->is_active ? 'active' : 'inactive' }}">
                                <div class="status-dot"></div>
                                {{ $member->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        @permission('view_members')
                        <td data-label="Actions" class="td-actions">
                            <div class="action-buttons enhanced-actions">
                                @permission('view_members')
                                <a href="{{ route('admin.members.show', $member) }}"
                                    class="btn btn-sm btn-secondary action-btn" title="View Member">
                                    <i class="fas fa-eye"></i>
                                    <span class="btn-tooltip">View</span>
                                </a>
                                @endpermission

                                @permission('edit_members')
                                <a href="{{ route('admin.members.edit', $member) }}"
                                    class="btn btn-sm btn-primary action-btn" title="Edit Member">
                                    <i class="fas fa-edit"></i>
                                    <span class="btn-tooltip">Edit</span>
                                </a>
                                @endpermission

                                @permission('view_members')
                                <a href="{{ route('admin.members.certificate.download', $member) }}"
                                    class="btn btn-sm btn-success action-btn" title="Download Certificate">
                                    <i class="fas fa-download"></i>
                                    <span class="btn-tooltip">Download</span>
                                </a>
                                @endpermission

                                @if($member->type === 'singer')
                                @permission('view_practice_sessions')
                                <a href="{{ route('admin.practice-sessions.index', ['member' => $member->id]) }}"
                                    class="btn btn-sm btn-success action-btn" title="Practice Attendance">
                                    <i class="fas fa-calendar-check"></i>
                                    <span class="btn-tooltip">Attendance</span>
                                </a>
                                @endpermission
                                @endif

                                @permission('delete_members')
                                <form method="POST" action="{{ route('admin.members.destroy', $member) }}"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger action-btn delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this member?')"
                                        title="Delete Member">
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

        <x-enhanced-pagination :paginator="$members" :show-per-page-selector="true"
            :per-page-options="[5, 10, 20, 50, 100]" :show-page-info="true" :show-jump-to-page="true"
            :max-visible-pages="7" />
        @else
        <div class="empty-state enhanced-empty-state">
            <div class="empty-icon">
                <i class="fas fa-users"></i>
                <div class="icon-pulse"></div>
            </div>
            <h3>No Members Found</h3>
            <p>Get started by adding your first choir member to build your ensemble.</p>
            <div class="empty-actions">
                @permission('create_members')
                <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Your First Member
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
    /* Member Type Badge Styling */
    .singer-badge {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        color: white;
        border: 1px solid #1e40af;
    }

    .general-badge {
        background: linear-gradient(135deg, #10b981, #065f46);
        color: white;
        border: 1px solid #065f46;
    }

    .singer-badge:hover {
        background: linear-gradient(135deg, #1e40af, #1e3a8a);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .general-badge:hover {
        background: linear-gradient(135deg, #065f46, #064e3b);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    /* Enhanced action buttons for singers */
    .action-btn.singer-specific {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        border-color: #1e40af;
    }

    .action-btn.singer-specific:hover {
        background: linear-gradient(135deg, #1e40af, #1e3a8a);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    /* Certificate printing styles */
    .th-select,
    .td-select {
        width: 50px;
        text-align: center;
    }

    .th-select input[type="checkbox"],
    .td-select input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .export-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .export-actions .btn {
        min-width: 120px;
    }

    .export-actions .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
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

    // Certificate printing functions
    function toggleSelectAll() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const memberCheckboxes = document.querySelectorAll('.member-checkbox');

        memberCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });

        updatePrintButton();
    }

    function updatePrintButton() {
        const selectedCheckboxes = document.querySelectorAll('.member-checkbox:checked');
        const printSelectedBtn = document.getElementById('printSelectedBtn');

        if (selectedCheckboxes.length > 0) {
            printSelectedBtn.disabled = false;
            printSelectedBtn.innerHTML = `
                <div class="btn-content">
                    <i class="fas fa-certificate"></i>
                    <span>Print Selected (${selectedCheckboxes.length})</span>
                </div>
                <div class="btn-glow"></div>
            `;
        } else {
            printSelectedBtn.disabled = true;
            printSelectedBtn.innerHTML = `
                <div class="btn-content">
                    <i class="fas fa-certificate"></i>
                    <span>Print Selected</span>
                </div>
                <div class="btn-glow"></div>
            `;
        }
    }

    function printSelectedCertificates() {
        const selectedCheckboxes = document.querySelectorAll('.member-checkbox:checked');

        if (selectedCheckboxes.length === 0) {
            alert('Please select at least one member to print certificates.');
            return;
        }

        const memberIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);

        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.members.print-certificates") }}';

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        // Add member IDs
        memberIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'member_ids[]';
            input.value = id;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    function printFilteredCertificates() {
        if (confirm('This will print certificates for all members matching the current filters. Continue?')) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.members.print-filtered-certificates") }}';

            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            // Add current filter parameters
            const currentParams = new URLSearchParams(window.location.search);
            currentParams.forEach((value, key) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    }
</script>

.th-select,
.td-select {
width: 50px;
text-align: center;
}

.th-select input[type="checkbox"],
.td-select input[type="checkbox"] {
width: 18px;
height: 18px;
cursor: pointer;
}

.export-actions {
display: flex;
gap: 0.5rem;
flex-wrap: wrap;
}

.export-actions .btn {
min-width: 120px;
}

.export-actions .btn:disabled {
opacity: 0.5;
cursor: not-allowed;
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

    // Certificate printing functions
    function toggleSelectAll() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const memberCheckboxes = document.querySelectorAll('.member-checkbox');

        memberCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });

        updatePrintButton();
    }

    function updatePrintButton() {
        const selectedCheckboxes = document.querySelectorAll('.member-checkbox:checked');
        const printSelectedBtn = document.getElementById('printSelectedBtn');

        if (selectedCheckboxes.length > 0) {
            printSelectedBtn.disabled = false;
            printSelectedBtn.innerHTML = `
                <div class="btn-content">
                    <i class="fas fa-certificate"></i>
                    <span>Print Selected (${selectedCheckboxes.length})</span>
                </div>
                <div class="btn-glow"></div>
            `;
        } else {
            printSelectedBtn.disabled = true;
            printSelectedBtn.innerHTML = `
                <div class="btn-content">
                    <i class="fas fa-certificate"></i>
                    <span>Print Selected</span>
                </div>
                <div class="btn-glow"></div>
            `;
        }
    }

    function printSelectedCertificates() {
        const selectedCheckboxes = document.querySelectorAll('.member-checkbox:checked');

        if (selectedCheckboxes.length === 0) {
            alert('Please select at least one member to print certificates.');
            return;
        }

        const memberIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);

        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.members.print-certificates") }}';

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        // Add member IDs
        memberIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'member_ids[]';
            input.value = id;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    function printFilteredCertificates() {
        if (confirm('This will print certificates for all members matching the current filters. Continue?')) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.members.print-filtered-certificates") }}';

            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            // Add current filter parameters
            const currentParams = new URLSearchParams(window.location.search);
            currentParams.forEach((value, key) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    }
</script>

@endsection