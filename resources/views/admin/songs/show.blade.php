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
                <div class="header-content">
                    <h3 class="card-title">
                        <i class="fas fa-align-left"></i>
                        Lyrics
                    </h3>
                    <div class="header-badge">
                        <span class="badge-dot"></span>
                        Song Text
                    </div>
                </div>
                <div class="header-actions">
                    <button onclick="printLyrics()" class="btn btn-outline enhanced-btn">
                        <div class="btn-content">
                            <i class="fas fa-print"></i>
                            <span>Print Lyrics</span>
                        </div>
                        <div class="btn-glow"></div>
                    </button>
                </div>
            </div>
            <div class="card-content">
                <div class="lyrics-content enhanced-content" id="lyricsContent">
                    {!! $song->lyrics !!}
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

@push('scripts')
<script>
    function printLyrics() {
        const lyricsContent = document.getElementById('lyricsContent');
        const songTitle = '{{ $song->title }}';
        const composer = '{{ $song->composer ?? "Unknown" }}';

        // Create a new window for printing
        const printWindow = window.open('', '_blank');

        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>${songTitle} - Lyrics</title>
                <style>
                    body {
                        font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
                        font-size: 14px;
                        line-height: 1.6;
                        color: #000;
                        max-width: 800px;
                        margin: 0 auto;
                        padding: 2rem;
                    }
                    .print-header {
                        text-align: center;
                        margin-bottom: 2rem;
                        border-bottom: 2px solid #000;
                        padding-bottom: 1rem;
                    }
                    .print-title {
                        font-size: 24px;
                        font-weight: bold;
                        margin-bottom: 0.5rem;
                    }
                    .print-composer {
                        font-size: 16px;
                        color: #666;
                        font-style: italic;
                    }
                    .print-content {
                        margin-top: 2rem;
                    }
                    .print-content h1,
                    .print-content h2,
                    .print-content h3,
                    .print-content h4,
                    .print-content h5,
                    .print-content h6 {
                        color: #000;
                        margin: 1.5rem 0 1rem 0;
                        font-weight: 600;
                    }
                    .print-content p {
                        margin: 1rem 0;
                        line-height: 1.8;
                    }
                    .print-content strong {
                        color: #000;
                        font-weight: 600;
                    }
                    .print-content em {
                        font-style: italic;
                    }
                    .print-content ul,
                    .print-content ol {
                        margin: 1rem 0;
                        padding-left: 2rem;
                    }
                    .print-content li {
                        margin: 0.5rem 0;
                        line-height: 1.6;
                    }
                    .print-content blockquote {
                        border-left: 4px solid #000;
                        padding-left: 1rem;
                        margin: 1.5rem 0;
                        font-style: italic;
                        background: #f5f5f5;
                        padding: 1rem;
                    }
                    .print-content table {
                        width: 100%;
                        border-collapse: collapse;
                        margin: 1rem 0;
                    }
                    .print-content th,
                    .print-content td {
                        border: 1px solid #000;
                        padding: 0.75rem;
                        text-align: left;
                    }
                    .print-content th {
                        background: #f0f0f0;
                        font-weight: 600;
                    }
                    @media print {
                        body { margin: 0; padding: 1rem; }
                        .print-header { page-break-after: avoid; }
                    }
                </style>
            </head>
            <body>
                <div class="print-header">
                    <div class="print-title">${songTitle}</div>
                    <div class="print-composer">by ${composer}</div>
                </div>
                <div class="print-content">
                    ${lyricsContent.innerHTML}
                </div>
            </body>
            </html>
        `);

        printWindow.document.close();

        // Wait for content to load, then print
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 500);
    }
</script>
@endpush