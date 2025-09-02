@extends('layouts.admin')

@section('title', 'Add Concert')
@section('page-title', 'Add New Concert')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header concert-create-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-music"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Add New Concert</h2>
                <p class="header-subtitle">Schedule a new choir performance for The Harmony Singers</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-calendar-plus"></i>
                        </span>
                        <span class="stat-label">New Event</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="stat-label">Choir Performance</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-star"></i>
                        </span>
                        <span class="stat-label">Create Today</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.concerts.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Concerts</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Content Card -->
<div class="content-card enhanced-card">
    <div class="card-header enhanced-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Concert Registration Form
            </h3>
            <div class="header-badge">
                <span class="badge-dot"></span>
                Required Fields
            </div>
        </div>
    </div>

    <div class="card-content">
        <form method="POST" action="{{ route('admin.concerts.store') }}" class="concert-form enhanced-form">
            @csrf

            <div class="form-grid enhanced-form-grid">
                <!-- Basic Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-music"></i>
                            Concert Information
                        </h4>
                        <p class="section-subtitle">Essential details about the new concert</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="title" class="form-label enhanced-label">
                                <i class="fas fa-heading"></i>
                                Concert Title *
                            </label>
                            <input type="text" id="title" name="title"
                                class="form-input enhanced-input"
                                value="{{ old('title') }}"
                                placeholder="Enter concert title" required>
                            <div class="input-glow"></div>
                            @error('title')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="type" class="form-label enhanced-label">
                                <i class="fas fa-tag"></i>
                                Concert Type *
                            </label>
                            <select id="type" name="type" class="form-select enhanced-select" required>
                                <option value="">Select Type</option>
                                <option value="regular" {{ old('type') == 'regular' ? 'selected' : '' }}>Regular Concert</option>
                                <option value="special" {{ old('type') == 'special' ? 'selected' : '' }}>Special Event</option>
                                <option value="festival" {{ old('type') == 'festival' ? 'selected' : '' }}>Festival</option>
                                <option value="competition" {{ old('type') == 'competition' ? 'selected' : '' }}>Competition</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('type')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="venue" class="form-label enhanced-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Venue *
                            </label>
                            <input type="text" id="venue" name="venue"
                                class="form-input enhanced-input"
                                value="{{ old('venue') }}"
                                placeholder="Enter venue name" required>
                            <div class="input-glow"></div>
                            @error('venue')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="status" class="form-label enhanced-label">
                                <i class="fas fa-info-circle"></i>
                                Status *
                            </label>
                            <select id="status" name="status" class="form-select enhanced-select" required>
                                <option value="">Select Status</option>
                                <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('status')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Date and Time Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-calendar-alt"></i>
                            Date & Time
                        </h4>
                        <p class="section-subtitle">Schedule details for the concert</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="date" class="form-label enhanced-label">
                                <i class="fas fa-calendar"></i>
                                Concert Date *
                            </label>
                            <input type="date" id="date" name="date"
                                class="form-input enhanced-input"
                                value="{{ old('date') }}" required>
                            <div class="input-glow"></div>
                            @error('date')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="time" class="form-label enhanced-label">
                                <i class="fas fa-clock"></i>
                                Start Time *
                            </label>
                            <input type="time" id="time" name="time"
                                class="form-input enhanced-input"
                                value="{{ old('time') }}" required>
                            <div class="input-glow"></div>
                            @error('time')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Details Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Additional Details
                        </h4>
                        <p class="section-subtitle">Optional information and pricing</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="ticket_price" class="form-label enhanced-label">
                                <i class="fas fa-dollar-sign"></i>
                                Ticket Price
                            </label>
                            <div class="input-group enhanced-input-group">
                                <span class="input-prefix">$</span>
                                <input type="number" id="ticket_price" name="ticket_price"
                                    class="form-input enhanced-input"
                                    value="{{ old('ticket_price') }}"
                                    step="0.01" min="0"
                                    placeholder="0.00">
                                <div class="input-glow"></div>
                            </div>
                            @error('ticket_price')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="max_attendees" class="form-label enhanced-label">
                                <i class="fas fa-users"></i>
                                Max Attendees
                            </label>
                            <input type="number" id="max_attendees" name="max_attendees"
                                class="form-input enhanced-input"
                                value="{{ old('max_attendees') }}"
                                min="1"
                                placeholder="Enter maximum capacity">
                            <div class="input-glow"></div>
                            @error('max_attendees')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="description" class="form-label enhanced-label">
                            <i class="fas fa-align-left"></i>
                            Description
                        </label>
                        <textarea id="description" name="description"
                            class="form-textarea enhanced-textarea"
                            rows="4"
                            placeholder="Enter concert description...">{{ old('description') }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('description')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="is_featured" class="form-label enhanced-label">
                                <i class="fas fa-star"></i>
                                Featured Event
                            </label>
                            <div class="checkbox-group enhanced-checkbox">
                                <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                    class="enhanced-checkbox-input"
                                    {{ old('is_featured') ? 'checked' : '' }}>
                                <label for="is_featured" class="checkbox-label enhanced-label">
                                    <span class="checkbox-custom"></span>
                                    Mark as featured event
                                </label>
                            </div>
                            @error('is_featured')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions enhanced-actions">
                <button type="submit" class="btn btn-primary enhanced-btn submit-btn">
                    <div class="btn-content">
                        <i class="fas fa-save"></i>
                        <span>Create Concert</span>
                    </div>
                    <div class="btn-glow"></div>
                </button>
                <a href="{{ route('admin.concerts.index') }}" class="btn btn-outline enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-times"></i>
                        <span>Cancel</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
            </div>
        </form>
    </div>
</div>

@endsection