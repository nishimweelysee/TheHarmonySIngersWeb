@extends('layouts.admin')

@section('title', 'Add New Media')
@section('page-title', 'Add New Media')

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
                <i class="fas fa-plus"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Add New Media</h2>
                <p class="header-subtitle">
                    @if($selectedAlbumId)
                    Adding media to album
                    @else
                    Upload new photos, videos, or audio files
                    @endif
                </p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="stat-label">New Media</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-photo-video"></i>
                        </span>
                        <span class="stat-label">File Upload</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-calendar-plus"></i>
                        </span>
                        <span class="stat-label">Create Today</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
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
                Media Upload Form
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

        <!-- Album Information Display (when album is pre-selected) -->
        @if($selectedAlbumId)
        @php
        $selectedAlbum = $albums->firstWhere('id', $selectedAlbumId);
        @endphp
        @if($selectedAlbum)
        <div class="album-info-display enhanced-info-display">
            <div class="info-header enhanced-header">
                <h3>Adding Media to: <strong>{{ $selectedAlbum->name }}</strong></h3>
            </div>
            <div class="info-grid enhanced-info-grid">
                <div class="info-item enhanced-item">
                    <div class="info-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Album Type</span>
                        <span class="info-value">{{ ucfirst($selectedAlbum->type) }}</span>
                    </div>
                </div>
                @if($selectedAlbum->description)
                <div class="info-item enhanced-item">
                    <div class="info-icon">
                        <i class="fas fa-align-left"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Description</span>
                        <span class="info-value">{{ $selectedAlbum->description }}</span>
                    </div>
                </div>
                @endif
                @if($selectedAlbum->concert)
                <div class="info-item enhanced-item">
                    <div class="info-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Concert</span>
                        <span class="info-value">{{ $selectedAlbum->concert->title }}</span>
                    </div>
                </div>
                @endif
                @if($selectedAlbum->event_date)
                <div class="info-item enhanced-item">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Event Date</span>
                        <span class="info-value">{{ $selectedAlbum->event_date->format('M j, Y') }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
        @endif

        <form method="POST" action="{{ route('admin.media.upload-large') }}" enctype="multipart/form-data"
            class="media-form enhanced-form" id="mediaForm">
            @csrf

            <!-- Hidden fields for album context -->
            @if($selectedAlbumId)
            <input type="hidden" name="album_id" value="{{ $selectedAlbumId }}">
            <input type="hidden" name="type" value="{{ $selectedAlbum->type ?? '' }}">
            @if($selectedAlbum && $selectedAlbum->concert_id)
            <input type="hidden" name="concert_id" value="{{ $selectedAlbum->concert_id }}">
            @endif
            @else
            <!-- Full form when no album is pre-selected -->
            <div class="form-section">
                <div class="section-header">
                    <h4 class="section-title">
                        <i class="fas fa-images"></i>
                        Album Information
                    </h4>
                    <p class="section-subtitle">Select the album for this media item</p>
                </div>
                <div class="form-grid enhanced-form-grid">
                    <div class="form-group enhanced-group">
                        <label for="album_id" class="form-label enhanced-label">
                            <i class="fas fa-images"></i>
                            Album *
                        </label>
                        <select id="album_id" name="album_id" class="form-select enhanced-select" required>
                            <option value="">Select an album</option>
                            @foreach($albums as $album)
                            <option value="{{ $album->id }}" {{ old('album_id') == $album->id ? 'selected' : '' }}>
                                {{ $album->name }} ({{ ucfirst($album->type) }})
                            </option>
                            @endforeach
                        </select>
                        <div class="select-glow"></div>
                        @error('album_id')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group enhanced-group">
                        <label for="type" class="form-label enhanced-label">
                            <i class="fas fa-tag"></i>
                            Media Type *
                        </label>
                        <select id="type" name="type" class="form-select enhanced-select" required>
                            <option value="">Select media type</option>
                            <option value="photo" {{ old('type') == 'photo' ? 'selected' : '' }}>Photo</option>
                            <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video</option>
                            <option value="audio" {{ old('type') == 'audio' ? 'selected' : '' }}>Audio</option>
                        </select>
                        <div class="select-glow"></div>
                        @error('type')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            @endif

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
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
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
                            placeholder="Describe your media item (optional)">{{ old('description') }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('description')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- File Upload Section -->
            <div class="form-section">
                <div class="section-header">
                    <h4 class="section-title">
                        <i class="fas fa-upload"></i>
                        File Upload
                    </h4>
                    <p class="section-subtitle">Select the media file to upload</p>
                </div>

                <div class="form-group enhanced-group full-width">
                    <label for="media_file" class="form-label enhanced-label">
                        <i class="fas fa-file"></i>
                        Media File *
                    </label>
                    <div class="file-upload-container enhanced-upload">
                        <input type="file" id="media_file" name="media_file"
                            class="file-input enhanced-file-input"
                            accept="image/*,video/*,audio/*"
                            onchange="previewMediaFile(this)" required>
                        <div class="upload-placeholder">
                            <div class="upload-icon-container">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <span>Choose a file or drag here</span>
                            <small>Images: JPG, PNG, GIF | Videos: MP4, AVI, MOV | Audio: MP3, WAV, OGG</small>
                        </div>
                        <div class="file-preview" id="mediaFilePreview" style="display: none;">
                            <div class="preview-content">
                                <div class="file-preview-image">
                                    <img id="previewImage" src="" alt="File Preview" class="preview-img">
                                    <div class="preview-placeholder" id="previewPlaceholder">
                                        <i class="fas fa-file"></i>
                                    </div>
                                </div>
                                <div class="preview-info">
                                    <span class="file-name" id="fileName"></span>
                                    <span class="file-size" id="fileSize"></span>
                                </div>
                                <button type="button" class="remove-file-btn" onclick="removeMediaFile()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('media_file')
                    <span class="error-message enhanced-error">{{ $message }}</span>
                    @enderror
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
                                {{ old('is_featured') ? 'checked' : '' }}>
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
                                {{ old('is_public', '1') ? 'checked' : '' }}>
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
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}"
                        class="form-input enhanced-input @error('sort_order') error @enderror"
                        min="0" placeholder="0">
                    <div class="input-glow"></div>
                    @error('sort_order')
                    <span class="error-message enhanced-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions enhanced-actions">
                <button type="submit" class="btn btn-primary enhanced-btn submit-btn">
                    <div class="btn-content">
                        <i class="fas fa-upload"></i>
                        <span>Upload Media</span>
                    </div>
                    <div class="btn-glow"></div>
                </button>
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

@push('scripts')
<script>
    function previewMediaFile(input) {
        const file = input.files[0];
        const preview = document.getElementById('mediaFilePreview');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const placeholder = input.parentNode.querySelector('.upload-placeholder');
        const previewImage = document.getElementById('previewImage');
        const previewPlaceholder = document.getElementById('previewPlaceholder');

        if (file) {
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            preview.style.display = 'block';
            placeholder.style.display = 'none';
            previewPlaceholder.style.display = 'none'; // Hide placeholder

            if (file.type.startsWith('image/')) {
                previewImage.src = URL.createObjectURL(file);
                previewImage.style.display = 'block';
            } else {
                previewImage.src = ''; // Clear previous image
                previewImage.style.display = 'none';
                previewPlaceholder.style.display = 'block'; // Show placeholder
            }
        }
    }

    function removeMediaFile() {
        const input = document.getElementById('media_file');
        const preview = document.getElementById('mediaFilePreview');
        const placeholder = input.parentNode.querySelector('.upload-placeholder');
        const previewImage = document.getElementById('previewImage');
        const previewPlaceholder = document.getElementById('previewPlaceholder');

        input.value = '';
        preview.style.display = 'none';
        placeholder.style.display = 'block';
        previewPlaceholder.style.display = 'none'; // Hide placeholder
        previewImage.src = ''; // Clear preview image
        previewImage.style.display = 'none';
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
</script>
@endpush