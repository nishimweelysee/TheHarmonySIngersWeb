@extends('layouts.admin')

@section('title', 'Edit Media')
@section('page-title', 'Edit Media')

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
                <i class="fas fa-edit"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
            <h2 class="header-title">Edit Media</h2>
                <p class="header-subtitle">Update information for {{ $media->title ?: 'Untitled' }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-{{ $media->type === 'photo' ? 'image' : ($media->type === 'video' ? 'video' : 'music') }}"></i>
                        </span>
                        <span class="stat-label">{{ ucfirst($media->type) }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-images"></i>
                        </span>
                        <span class="stat-label">{{ $media->album ? $media->album->name : 'No Album' }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-calendar"></i>
                        </span>
                        <span class="stat-label">{{ $media->created_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.media.show', $media) }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                <i class="fas fa-eye"></i>
                    <span>View Media</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            <a href="{{ route('admin.media.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                <i class="fas fa-arrow-left"></i>
                    <span>Back to Media</span>
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
                Media Update Form
            </h3>
            <div class="header-badge">
                <span class="badge-dot"></span>
                Required Fields
            </div>
        </div>
    </div>

    <div class="card-content">
        @if(session('success'))
        <div class="alert alert-success enhanced-alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger enhanced-alert">
            <i class="fas fa-exclamation-triangle"></i>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.media.update', $media) }}" method="POST" class="form enhanced-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid enhanced-form-grid">
                <!-- Media Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Media Information
                        </h4>
                        <p class="section-subtitle">Basic details about your media item</p>
                    </div>

                    <div class="form-grid enhanced-form-grid">
                        <div class="form-group enhanced-group">
                            <label for="title" class="form-label enhanced-label">
                                <i class="fas fa-heading"></i>
                                Title *
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title', $media->title) }}"
                                class="form-input enhanced-input @error('title') error @enderror"
                                placeholder="Enter media title" required>
                            <div class="input-glow"></div>
                    @error('title')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                    @enderror
                </div>

                        <div class="form-group enhanced-group">
                            <label for="description" class="form-label enhanced-label">
                                <i class="fas fa-align-left"></i>
                                Description
                            </label>
                            <textarea id="description" name="description" rows="3"
                                class="form-textarea enhanced-textarea @error('description') error @enderror"
                                placeholder="Describe your media item (optional)">{{ old('description', $media->description) }}</textarea>
                            <div class="textarea-glow"></div>
                            @error('description')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                    @enderror
                        </div>
                    </div>
                </div>

                <!-- Album Association Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-images"></i>
                            Album Association
                        </h4>
                        <p class="section-subtitle">Link this media to an album</p>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="album_id" class="form-label enhanced-label">
                            <i class="fas fa-images"></i>
                            Album
                        </label>
                        <select id="album_id" name="album_id" class="form-select enhanced-select @error('album_id') error @enderror">
                            <option value="">No album association</option>
                        @foreach($albums as $album)
                        <option value="{{ $album->id }}" {{ old('album_id', $media->album_id) == $album->id ? 'selected' : '' }}>
                            {{ $album->name }} ({{ ucfirst($album->type) }})
                        </option>
                        @endforeach
                    </select>
                        <div class="select-glow"></div>
                    @error('album_id')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                    @enderror
                </div>
                </div>

                <!-- Current Media Display Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-eye"></i>
                            Current Media
                        </h4>
                        <p class="section-subtitle">Preview of the current media file</p>
                </div>

                    <div class="current-media-display">
                        @if($media->type === 'photo' && $media->file_path)
                        <div class="media-preview enhanced-photo">
                            <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->title }}" class="media-image">
                            <div class="media-overlay"></div>
                        </div>
                        @elseif($media->type === 'photo')
                        <div class="media-preview enhanced-photo">
                            <i class="fas fa-image fa-3x"></i>
                            <span class="media-type-label">Photo File</span>
                            <div class="media-overlay"></div>
                        </div>
                        @elseif($media->type === 'video' && $media->file_path)
                        <div class="media-preview enhanced-video">
                            <video class="media-video" controls preload="metadata">
                                <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                                <source src="{{ asset('storage/' . $media->file_path) }}" type="video/webm">
                                <source src="{{ asset('storage/' . $media->file_path) }}" type="video/ogg">
                                Your browser does not support video playback.
                            </video>
                            <div class="media-overlay"></div>
                        </div>
                        @elseif($media->type === 'video')
                        <div class="media-preview enhanced-video">
                            <i class="fas fa-video fa-3x"></i>
                            <span class="media-type-label">Video File</span>
                            <div class="media-overlay"></div>
                        </div>
                        @elseif($media->type === 'audio' && $media->file_path)
                        <div class="media-preview enhanced-audio">
                            <audio class="media-audio" controls preload="metadata">
                                <source src="{{ asset('storage/' . $media->file_path) }}" type="audio/mpeg">
                                <source src="{{ asset('storage/' . $media->file_path) }}" type="audio/ogg">
                                <source src="{{ asset('storage/' . $media->file_path) }}" type="audio/wav">
                                Your browser does not support audio playback.
                            </audio>
                            <div class="media-overlay"></div>
                        </div>
                        @elseif($media->type === 'audio')
                        <div class="media-preview enhanced-audio">
                            <i class="fas fa-music fa-3x"></i>
                            <span class="media-type-label">Audio File</span>
                            <div class="media-overlay"></div>
                </div>
                        @endif

                        <div class="media-file-info">
                            <div class="file-details">
                                <span class="file-name">{{ basename($media->file_path) }}</span>
                                <span class="file-type">{{ strtoupper(pathinfo($media->file_path, PATHINFO_EXTENSION)) }}</span>
                                <span class="file-size">{{ $media->file_size_formatted ?? 'N/A' }}</span>
                            </div>
                            <div class="file-actions">
                                <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" class="btn btn-sm btn-outline enhanced-btn">
                                    <i class="fas fa-eye"></i>
                                    <span>View</span>
                                </a>
                                <a href="{{ asset('storage/' . $media->file_path) }}" download class="btn btn-sm btn-outline enhanced-btn">
                                    <i class="fas fa-download"></i>
                                    <span>Download</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Settings Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-cog"></i>
                            Additional Settings
                        </h4>
                        <p class="section-subtitle">Configure media visibility and features</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="is_featured" class="form-label enhanced-label">
                                <i class="fas fa-star"></i>
                                Featured Media
                            </label>
                            <div class="checkbox-group enhanced-checkbox">
                                <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                    class="enhanced-checkbox-input"
                                    {{ old('is_featured', $media->is_featured) ? 'checked' : '' }}>
                                <label for="is_featured" class="checkbox-label enhanced-label">
                                    <span class="checkbox-custom"></span>
                                    Mark as featured media
                                </label>
                    </div>
                    @error('is_featured')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                    @enderror
                </div>

                        <div class="form-group enhanced-group">
                            <label for="is_public" class="form-label enhanced-label">
                                <i class="fas fa-eye"></i>
                                Public Visibility
                            </label>
                            <div class="checkbox-group enhanced-checkbox">
                                <input type="checkbox" id="is_public" name="is_public" value="1"
                                    class="enhanced-checkbox-input"
                                    {{ old('is_public', $media->is_public) ? 'checked' : '' }}>
                                <label for="is_public" class="checkbox-label enhanced-label">
                                    <span class="checkbox-custom"></span>
                                    Make media publicly visible
                                </label>
                    </div>
                    @error('is_public')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

                    <div class="form-group enhanced-group">
                        <label for="sort_order" class="form-label enhanced-label">
                            <i class="fas fa-sort"></i>
                            Sort Order
                        </label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $media->sort_order ?? 0) }}"
                            class="form-input enhanced-input @error('sort_order') error @enderror"
                            min="0" placeholder="0">
                        <div class="input-glow"></div>
                        @error('sort_order')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions enhanced-actions">
                <button type="submit" class="btn btn-primary enhanced-btn submit-btn">
                    <div class="btn-content">
                    <i class="fas fa-save"></i>
                        <span>Update Media</span>
                    </div>
                    <div class="btn-glow"></div>
                </button>
                <a href="{{ route('admin.media.show', $media) }}" class="btn btn-outline enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-eye"></i>
                        <span>View Media</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
                <a href="{{ route('admin.media.index') }}" class="btn btn-outline enhanced-btn">
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