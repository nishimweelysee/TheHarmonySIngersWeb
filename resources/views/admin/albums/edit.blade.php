@extends('layouts.admin')

@section('title', 'Edit Album')
@section('page-title', 'Edit Album')

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
                <h2 class="header-title">Edit Album</h2>
                <p class="header-subtitle">Update information for {{ $album->name }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-images"></i>
                        </span>
                        <span class="stat-label">{{ ucfirst($album->type) }} Album</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-image"></i>
                        </span>
                        <span class="stat-label">{{ $album->media->count() }} items</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-calendar"></i>
                        </span>
                        <span class="stat-label">{{ $album->created_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.albums.show', $album) }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-eye"></i>
                    <span>View Album</span>
                </div>
                <div class="btn-glow"></div>
            </a>
            <a href="{{ route('admin.albums.index') }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Albums</span>
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
                Album Update Form
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

        <form action="{{ route('admin.albums.update', $album) }}" method="POST" class="form enhanced-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid enhanced-form-grid">
                <!-- Basic Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Album Information
                        </h4>
                        <p class="section-subtitle">Essential details about your album</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="name" class="form-label enhanced-label">
                                <i class="fas fa-heading"></i>
                                Album Name *
                            </label>
                            <input type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $album->name) }}"
                                class="form-input enhanced-input @error('name') error @enderror"
                                placeholder="Enter album name"
                                required>
                            <div class="input-glow"></div>
                            @error('name')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="type" class="form-label enhanced-label">
                                <i class="fas fa-tag"></i>
                                Album Type *
                            </label>
                            <select id="type" name="type" class="form-select enhanced-select @error('type') error @enderror" required>
                                <option value="">Select album type</option>
                                <option value="photo" {{ old('type', $album->type) == 'photo' ? 'selected' : '' }}>Photo Collection</option>
                                <option value="video" {{ old('type', $album->type) == 'video' ? 'selected' : '' }}>Video Collection</option>
                                <option value="audio" {{ old('type', $album->type) == 'audio' ? 'selected' : '' }}>Audio Collection</option>
                                <option value="mixed" {{ old('type', $album->type) == 'mixed' ? 'selected' : '' }}>Mixed Media</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('type')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="description" class="form-label enhanced-label">
                            <i class="fas fa-align-left"></i>
                            Description
                        </label>
                        <textarea id="description"
                            name="description"
                            class="form-textarea enhanced-textarea @error('description') error @enderror"
                            placeholder="Describe your album (optional)"
                            rows="4">{{ old('description', $album->description) }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('description')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Cover Image Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-image"></i>
                            Cover Image
                        </h4>
                        <p class="section-subtitle">Upload a cover image for your album</p>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="cover_image" class="form-label enhanced-label">
                            <i class="fas fa-upload"></i>
                            Album Cover
                        </label>
                        <div class="file-upload-container enhanced-upload">
                            <input type="file" id="cover_image" name="cover_image"
                                class="file-input enhanced-file-input"
                                accept="image/*"
                                onchange="previewCoverImage(this)">
                            <div class="upload-placeholder">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choose a photo or drag here</span>
                                <small>JPG, PNG, GIF up to 5MB</small>
                            </div>
                            @if($album->cover_image_url)
                            <div class="current-file-info">
                                <i class="fas fa-image"></i>
                                <span>Current: {{ basename($album->cover_image) }}</span>
                                <img src="{{ $album->cover_image_url }}" alt="Current Cover" class="current-cover-preview" style="max-width: 150px; max-height: 150px; width: auto; height: auto; object-fit: cover;">
                            </div>
                            @endif
                            <div class="file-preview" id="coverImagePreview" style="display: none;">
                                <img src="" alt="Cover Preview" class="cover-preview-image" style="max-width: 200px; max-height: 200px; width: auto; height: auto; object-fit: cover;">
                                <button type="button" class="remove-file-btn" onclick="removeCoverImage()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        @error('cover_image')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Association Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-link"></i>
                            Associations
                        </h4>
                        <p class="section-subtitle">Link your album to events or concerts</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="concert_id" class="form-label enhanced-label">
                                <i class="fas fa-calendar"></i>
                                Related Concert
                            </label>
                            <select id="concert_id" name="concert_id" class="form-select enhanced-select @error('concert_id') error @enderror">
                                <option value="">No concert association</option>
                                @foreach($concerts as $concert)
                                <option value="{{ $concert->id }}" {{ old('concert_id', $album->concert_id) == $concert->id ? 'selected' : '' }}>
                                    {{ $concert->title }} - {{ $concert->date ? $concert->date->format('M j, Y') : 'Date TBA' }}
                                </option>
                                @endforeach
                            </select>
                            <div class="select-glow"></div>
                            @error('concert_id')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="event_date" class="form-label enhanced-label">
                                <i class="fas fa-clock"></i>
                                Event Date
                            </label>
                            <input type="date"
                                id="event_date"
                                name="event_date"
                                value="{{ old('event_date', $album->event_date ? $album->event_date->format('Y-m-d') : '') }}"
                                class="form-input enhanced-input @error('event_date') error @enderror">
                            <div class="input-glow"></div>
                            @error('event_date')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Settings Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-cog"></i>
                            Album Settings
                        </h4>
                        <p class="section-subtitle">Configure album visibility and features</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="is_featured" class="form-label enhanced-label">
                                <i class="fas fa-star"></i>
                                Featured Album
                            </label>
                            <div class="checkbox-group enhanced-checkbox">
                                <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                    class="enhanced-checkbox-input"
                                    {{ old('is_featured', $album->is_featured) ? 'checked' : '' }}>
                                <label for="is_featured" class="checkbox-label enhanced-label">
                                    <span class="checkbox-custom"></span>
                                    Mark as featured album
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
                                    {{ old('is_public', $album->is_public) ? 'checked' : '' }}>
                                <label for="is_public" class="checkbox-label enhanced-label">
                                    <span class="checkbox-custom"></span>
                                    Make album publicly visible
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
                        <input type="number"
                            id="sort_order"
                            name="sort_order"
                            value="{{ old('sort_order', $album->sort_order) }}"
                            class="form-input enhanced-input @error('sort_order') error @enderror"
                            min="0"
                            placeholder="0">
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
                        <span>Update Album</span>
                    </div>
                    <div class="btn-glow"></div>
                </button>
                <a href="{{ route('admin.albums.show', $album) }}" class="btn btn-outline enhanced-btn">
                    <div class="btn-content">
                        <i class="fas fa-eye"></i>
                        <span>View Album</span>
                    </div>
                    <div class="btn-glow"></div>
                </a>
                <a href="{{ route('admin.albums.index') }}" class="btn btn-outline enhanced-btn">
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
    function previewCoverImage(input) {
        const file = input.files[0];
        const preview = document.getElementById('coverImagePreview');
        const img = preview.querySelector('.cover-preview-image');
        const placeholder = input.parentNode.querySelector('.upload-placeholder');

        if (file) {
            const url = URL.createObjectURL(file);
            img.src = url;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        }
    }

    function removeCoverImage() {
        const input = document.getElementById('cover_image');
        const preview = document.getElementById('coverImagePreview');
        const placeholder = input.parentNode.querySelector('.upload-placeholder');

        input.value = '';
        preview.style.display = 'none';
        placeholder.style.display = 'block';
    }
</script>
@endpush