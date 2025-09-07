@extends('layouts.admin')

@section('title', 'Create Practice Session')

@section('content')
<div class="container-fluid">
    <!-- Enhanced Page Header -->
    <div class="page-header enhanced-header">
        <div class="header-background">
            <div class="header-pattern"></div>
            <div class="header-glow"></div>
        </div>
        <div class="header-content">
            <div class="header-text">
                <div class="header-icon">
                    <i class="fas fa-calendar-plus"></i>
                    <div class="icon-glow"></div>
                </div>
                <div class="header-details">
                    <h2 class="header-title">Create Practice Session</h2>
                    <p class="header-subtitle">Schedule a new practice session for the choir</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.practice-sessions.index') }}" class="btn btn-secondary enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Sessions</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card enhanced-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Session Details
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.practice-sessions.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="form-group enhanced-group">
                                    <label for="title" class="form-label enhanced-label">
                                        <i class="fas fa-heading me-2"></i>
                                        Session Title *
                                    </label>
                                    <input type="text" id="title" name="title"
                                        class="form-input enhanced-input"
                                        value="{{ old('title') }}"
                                        placeholder="Enter session title" required>
                                    <div class="input-glow"></div>
                                    @error('title')
                                    <span class="error-message enhanced-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group enhanced-group">
                                    <label for="description" class="form-label enhanced-label">
                                        <i class="fas fa-align-left me-2"></i>
                                        Description
                                    </label>
                                    <textarea id="description" name="description"
                                        class="form-textarea enhanced-textarea"
                                        rows="4"
                                        placeholder="Enter session description">{{ old('description') }}</textarea>
                                    <div class="input-glow"></div>
                                    @error('description')
                                    <span class="error-message enhanced-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group enhanced-group">
                                    <label for="practice_date" class="form-label enhanced-label">
                                        <i class="fas fa-calendar me-2"></i>
                                        Practice Date *
                                    </label>
                                    <input type="date" id="practice_date" name="practice_date"
                                        class="form-input enhanced-input"
                                        value="{{ old('practice_date') }}" required>
                                    <div class="input-glow"></div>
                                    @error('practice_date')
                                    <span class="error-message enhanced-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group enhanced-group">
                                    <label for="start_time" class="form-label enhanced-label">
                                        <i class="fas fa-clock me-2"></i>
                                        Start Time *
                                    </label>
                                    <input type="time" id="start_time" name="start_time"
                                        class="form-input enhanced-input"
                                        value="{{ old('start_time') }}" required>
                                    <div class="input-glow"></div>
                                    @error('start_time')
                                    <span class="error-message enhanced-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="form-group enhanced-group">
                                    <label for="end_time" class="form-label enhanced-label">
                                        <i class="fas fa-clock me-2"></i>
                                        End Time *
                                    </label>
                                    <input type="time" id="end_time" name="end_time"
                                        class="form-input enhanced-input"
                                        value="{{ old('end_time') }}" required>
                                    <div class="input-glow"></div>
                                    @error('end_time')
                                    <span class="error-message enhanced-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group enhanced-group">
                                    <label for="venue" class="form-label enhanced-label">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        Venue
                                    </label>
                                    <input type="text" id="venue" name="venue"
                                        class="form-input enhanced-input"
                                        value="{{ old('venue') }}"
                                        placeholder="e.g., Main Hall, Community Center">
                                    <div class="input-glow"></div>
                                    @error('venue')
                                    <span class="error-message enhanced-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group enhanced-group">
                                    <label for="venue_address" class="form-label enhanced-label">
                                        <i class="fas fa-map me-2"></i>
                                        Venue Address
                                    </label>
                                    <input type="text" id="venue_address" name="venue_address"
                                        class="form-input enhanced-input"
                                        value="{{ old('venue_address') }}"
                                        placeholder="Full address of the venue">
                                    <div class="input-glow"></div>
                                    @error('venue_address')
                                    <span class="error-message enhanced-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group enhanced-group">
                                    <label for="status" class="form-label enhanced-label">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Status *
                                    </label>
                                    <select id="status" name="status" class="form-select enhanced-select" required>
                                        <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <div class="input-glow"></div>
                                    @error('status')
                                    <span class="error-message enhanced-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group enhanced-group">
                                    <label for="notes" class="form-label enhanced-label">
                                        <i class="fas fa-sticky-note me-2"></i>
                                        Notes
                                    </label>
                                    <textarea id="notes" name="notes"
                                        class="form-textarea enhanced-textarea"
                                        rows="3"
                                        placeholder="Additional notes for organizers">{{ old('notes') }}</textarea>
                                    <div class="input-glow"></div>
                                    @error('notes')
                                    <span class="error-message enhanced-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.practice-sessions.index') }}" class="btn btn-secondary enhanced-btn">
                                        <div class="btn-content">
                                            <i class="fas fa-times"></i>
                                            <span>Cancel</span>
                                        </div>
                                        <div class="btn-glow"></div>
                                    </a>
                                    <button type="submit" class="btn btn-primary enhanced-btn">
                                        <div class="btn-content">
                                            <i class="fas fa-save"></i>
                                            <span>Create Session</span>
                                        </div>
                                        <div class="btn-glow"></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const dateInput = document.getElementById('practice_date');

        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        dateInput.min = today;

        // Validate end time is after start time
        function validateTime() {
            if (startTimeInput.value && endTimeInput.value) {
                if (startTimeInput.value >= endTimeInput.value) {
                    endTimeInput.setCustomValidity('End time must be after start time');
                } else {
                    endTimeInput.setCustomValidity('');
                }
            }
        }

        startTimeInput.addEventListener('change', validateTime);
        endTimeInput.addEventListener('change', validateTime);
    });
</script>
@endsection