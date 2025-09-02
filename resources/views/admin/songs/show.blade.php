@extends('layouts.admin')

@section('title', 'Song Details')
@section('page-title', 'Song Details')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header song-show-header">
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
                <h2 class="header-title">{{ $song->title }}</h2>
                <p class="header-subtitle">Song Details & Information</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-tag"></i>
                        </span>
                        <span class="stat-label">
                            {{ $song->genre ? ucfirst($song->genre) : 'No Genre' }}
                        </span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-user"></i>
                        </span>
                        <span class="stat-label">
                            {{ $song->composer ?: 'No Composer' }}
                        </span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-star"></i>
                        </span>
                        <span class="stat-label">
                            {{ $song->difficulty ? ucfirst($song->difficulty) : 'No Difficulty' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            @permission('update_songs')
            <a href="{{ route('admin.songs.edit', $song) }}" class="btn btn-primary enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-edit"></i>
                    <span>Edit Song</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            @endpermission
            <a href="{{ route('admin.songs.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Songs</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Song Details -->
<div class="song-details enhanced-details">
    <div class="details-grid enhanced-grid">
        <!-- Basic Information -->
        <div class="detail-card enhanced-card">
            <div class="card-header enhanced-header">
                <h3 class="card-title">
                    <i class="fas fa-music"></i>
                    Song Information
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Basic Details
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-heading"></i>
                            Title
                        </span>
                        <span class="info-value enhanced-value">{{ $song->title }}</span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-tag"></i>
                            Genre
                        </span>
                        <span class="info-value enhanced-value">
                            @if($song->genre)
                            <span class="badge badge-{{ $song->genre === 'classical' ? 'primary' : 'secondary' }} enhanced-badge">
                                {{ ucfirst($song->genre) }}
                            </span>
                            @else
                            <span class="text-muted">Not specified</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-user"></i>
                            Composer
                        </span>
                        <span class="info-value enhanced-value">{{ $song->composer ?? 'Not specified' }}</span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-user-edit"></i>
                            Arranger
                        </span>
                        <span class="info-value enhanced-value">{{ $song->arranger ?? 'Not specified' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Technical Details -->
        <div class="detail-card enhanced-card">
            <div class="card-header enhanced-header">
                <h3 class="card-title">
                    <i class="fas fa-cog"></i>
                    Technical Details
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Musical Info
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-language"></i>
                            Language
                        </span>
                        <span class="info-value enhanced-value">{{ $song->language ?? 'Not specified' }}</span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-calendar"></i>
                            Year Composed
                        </span>
                        <span class="info-value enhanced-value">{{ $song->year_composed ?? 'Not specified' }}</span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-star"></i>
                            Difficulty
                        </span>
                        <span class="info-value enhanced-value">
                            @if($song->difficulty)
                            <span class="badge badge-{{ $song->difficulty === 'beginner' ? 'success' : ($song->difficulty === 'intermediate' ? 'warning' : ($song->difficulty === 'advanced' ? 'info' : 'danger')) }} enhanced-badge">
                                {{ ucfirst($song->difficulty) }}
                            </span>
                            @else
                            <span class="text-muted">Not specified</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-clock"></i>
                            Duration
                        </span>
                        <span class="info-value enhanced-value">
                            @if($song->duration)
                            {{ $song->formatted_duration ?? $song->duration }} minutes
                            @else
                            <span class="text-muted">Not specified</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-music"></i>
                            Key Signature
                        </span>
                        <span class="info-value enhanced-value">{{ $song->key_signature ?? 'Not specified' }}</span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-clock"></i>
                            Time Signature
                        </span>
                        <span class="info-value enhanced-value">{{ $song->time_signature ?? 'Not specified' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Media Files -->
        @if($song->audio_file || $song->sheet_music_file)
        <div class="detail-card enhanced-card full-width">
            <div class="card-header enhanced-header">
                <h3 class="card-title">
                    <i class="fas fa-upload"></i>
                    Media Files
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Audio & Sheet Music
                </div>
            </div>
            <div class="card-content">
                <div class="media-grid enhanced-media-grid">
                    @if($song->audio_file)
                    <div class="media-item enhanced-media-item">
                        <div class="media-header">
                            <i class="fas fa-music"></i>
                            <h4>Audio Recording</h4>
                        </div>
                        <div class="media-content">
                            <audio controls class="audio-player enhanced-audio">
                                <source src="{{ $song->audio_url }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <div class="media-actions">
                                <a href="{{ $song->audio_url }}" download class="btn btn-sm btn-outline enhanced-btn">
                                    <i class="fas fa-download"></i>
                                    <span>Download</span>
                                </a>
                                <span class="file-info">{{ basename($song->audio_file) }}</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($song->sheet_music_file)
                    <div class="media-item enhanced-media-item">
                        <div class="media-header">
                            <i class="fas fa-file-pdf"></i>
                            <h4>Sheet Music</h4>
                        </div>
                        <div class="media-content">
                            <div class="sheet-music-preview">
                                <i class="fas fa-file-pdf fa-3x"></i>
                                <p class="file-name">{{ basename($song->sheet_music_file) }}</p>
                            </div>
                            <div class="media-actions">
                                <a href="{{ $song->sheet_music_url }}" target="_blank" class="btn btn-sm btn-primary enhanced-btn">
                                    <i class="fas fa-eye"></i>
                                    <span>View</span>
                                </a>
                                <a href="{{ $song->sheet_music_url }}" download class="btn btn-sm btn-outline enhanced-btn">
                                    <i class="fas fa-download"></i>
                                    <span>Download</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Lyrics Section -->
        @if($song->lyrics)
        <div class="detail-card enhanced-card full-width">
            <div class="card-header enhanced-header">
                <h3 class="card-title">
                    <i class="fas fa-align-left"></i>
                    Lyrics
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Song Text
                </div>
            </div>
            <div class="card-content">
                <div class="lyrics-content enhanced-content">
                    {!! nl2br(e($song->lyrics)) !!}
                </div>
            </div>
        </div>
        @endif

        <!-- Additional Information -->
        @if($song->description || $song->notes)
        <div class="detail-card enhanced-card full-width">
            <div class="card-header enhanced-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Additional Information
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Details & Notes
                </div>
            </div>
            <div class="card-content">
                @if($song->description)
                <div class="info-section">
                    <h4 class="info-section-title">
                        <i class="fas fa-align-left"></i>
                        Description
                    </h4>
                    <div class="info-content enhanced-content">
                        <p>{{ $song->description }}</p>
                    </div>
                </div>
                @endif

                @if($song->notes)
                <div class="info-section">
                    <h4 class="info-section-title">
                        <i class="fas fa-sticky-note"></i>
                        Performance Notes
                    </h4>
                    <div class="info-content enhanced-content">
                        <p>{{ $song->notes }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Song Status -->
        <div class="detail-card enhanced-card">
            <div class="card-header enhanced-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Song Status
                </h3>
                <div class="header-badge">
                    <span class="badge-dot"></span>
                    Status Info
                </div>
            </div>
            <div class="card-content">
                <div class="info-grid enhanced-info-grid">
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-star"></i>
                            Featured Song
                        </span>
                        <span class="info-value enhanced-value">
                            <span class="badge badge-{{ $song->is_featured ? 'success' : 'secondary' }} enhanced-badge">
                                {{ $song->is_featured ? 'Yes' : 'No' }}
                            </span>
                        </span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-calendar-plus"></i>
                            Created
                        </span>
                        <span class="info-value enhanced-value">{{ $song->created_at->format('M j, Y \a\t g:i A') }}</span>
                    </div>
                    <div class="info-item enhanced-item">
                        <span class="info-label enhanced-label">
                            <i class="fas fa-calendar-check"></i>
                            Last Updated
                        </span>
                        <span class="info-value enhanced-value">{{ $song->updated_at->format('M j, Y \a\t g:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection