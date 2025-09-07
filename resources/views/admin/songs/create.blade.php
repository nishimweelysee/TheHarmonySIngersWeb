@extends('layouts.admin')

@section('title', 'Add Song')
@section('page-title', 'Add New Song')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header enhanced-header song-create-header">
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
                <h2 class="header-title">Add New Song</h2>
                <p class="header-subtitle">Add a new song to The Harmony Singers choir repertoire</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="stat-label">New Song</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-music"></i>
                        </span>
                        <span class="stat-label">Expand Repertoire</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-calendar-plus"></i>
                        </span>
                        <span class="stat-label">Add Today</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
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

<!-- Enhanced Content Card -->
<div class="content-card enhanced-card">
    <div class="card-header enhanced-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Song Registration Form
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

        <form method="POST" action="{{ route('admin.songs.store') }}" class="song-form enhanced-form" enctype="multipart/form-data">
            @csrf

            <div class="form-grid enhanced-form-grid">
                <!-- Basic Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-music"></i>
                            Song Information
                        </h4>
                        <p class="section-subtitle">Essential details about the new song</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="title" class="form-label enhanced-label">
                                <i class="fas fa-heading"></i>
                                Song Title *
                            </label>
                            <input type="text" id="title" name="title"
                                class="form-input enhanced-input"
                                value="{{ old('title') }}"
                                placeholder="Enter song title" required>
                            <div class="input-glow"></div>
                            @error('title')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="genre" class="form-label enhanced-label">
                                <i class="fas fa-tag"></i>
                                Genre
                            </label>
                            <select id="genre" name="genre" class="form-select enhanced-select">
                                <option value="">Select Genre</option>
                                <option value="classical" {{ old('genre') == 'classical' ? 'selected' : '' }}>Classical</option>
                                <option value="gospel" {{ old('genre') == 'gospel' ? 'selected' : '' }}>Gospel</option>
                                <option value="folk" {{ old('genre') == 'folk' ? 'selected' : '' }}>Folk</option>
                                <option value="pop" {{ old('genre') == 'pop' ? 'selected' : '' }}>Pop</option>
                                <option value="jazz" {{ old('genre') == 'jazz' ? 'selected' : '' }}>Jazz</option>
                                <option value="traditional" {{ old('genre') == 'traditional' ? 'selected' : '' }}>Traditional</option>
                                <option value="contemporary" {{ old('genre') == 'contemporary' ? 'selected' : '' }}>Contemporary</option>
                                <option value="other" {{ old('genre') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('genre')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="composer" class="form-label enhanced-label">
                                <i class="fas fa-user"></i>
                                Composer
                            </label>
                            <input type="text" id="composer" name="composer"
                                class="form-input enhanced-input"
                                value="{{ old('composer') }}"
                                placeholder="Enter composer name">
                            <div class="input-glow"></div>
                            @error('composer')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="arranger" class="form-label enhanced-label">
                                <i class="fas fa-user-edit"></i>
                                Arranger
                            </label>
                            <input type="text" id="arranger" name="arranger"
                                class="form-input enhanced-input"
                                value="{{ old('arranger') }}"
                                placeholder="Enter arranger name">
                            <div class="input-glow"></div>
                            @error('arranger')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Technical Details Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-cog"></i>
                            Technical Details
                        </h4>
                        <p class="section-subtitle">Musical and performance information</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="language" class="form-label enhanced-label">
                                <i class="fas fa-language"></i>
                                Language
                            </label>
                            <input type="text" id="language" name="language"
                                class="form-input enhanced-input"
                                value="{{ old('language') }}"
                                placeholder="e.g., English, Latin, French">
                            <div class="input-glow"></div>
                            @error('language')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="year_composed" class="form-label enhanced-label">
                                <i class="fas fa-calendar"></i>
                                Year Composed
                            </label>
                            <input type="number" id="year_composed" name="year_composed"
                                class="form-input enhanced-input"
                                value="{{ old('year_composed') }}"
                                min="1000" max="{{ date('Y') + 10 }}"
                                placeholder="e.g., 1800">
                            <div class="input-glow"></div>
                            @error('year_composed')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="difficulty" class="form-label enhanced-label">
                                <i class="fas fa-star"></i>
                                Difficulty Level
                            </label>
                            <select id="difficulty" name="difficulty" class="form-select enhanced-select">
                                <option value="">Select Difficulty</option>
                                <option value="beginner" {{ old('difficulty') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('difficulty') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                <option value="expert" {{ old('difficulty') == 'expert' ? 'selected' : '' }}>Expert</option>
                            </select>
                            <div class="select-glow"></div>
                            @error('difficulty')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="duration" class="form-label enhanced-label">
                                <i class="fas fa-clock"></i>
                                Duration (minutes)
                            </label>
                            <input type="number" id="duration" name="duration"
                                class="form-input enhanced-input"
                                value="{{ old('duration') }}"
                                min="0.5" max="60" step="0.5"
                                placeholder="e.g., 3.5">
                            <div class="input-glow"></div>
                            @error('duration')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="key_signature" class="form-label enhanced-label">
                                <i class="fas fa-music"></i>
                                Key Signature
                            </label>
                            <input type="text" id="key_signature" name="key_signature"
                                class="form-input enhanced-input"
                                value="{{ old('key_signature') }}"
                                placeholder="e.g., C major, F# minor">
                            <div class="input-glow"></div>
                            @error('key_signature')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="time_signature" class="form-label enhanced-label">
                                <i class="fas fa-clock"></i>
                                Time Signature
                            </label>
                            <input type="text" id="time_signature" name="time_signature"
                                class="form-input enhanced-input"
                                value="{{ old('time_signature') }}"
                                placeholder="e.g., 4/4, 3/4, 6/8">
                            <div class="input-glow"></div>
                            @error('time_signature')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- File Uploads Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fas fa-upload"></i>
                            Media Files
                        </h4>
                        <p class="section-subtitle">Upload audio recordings and sheet music</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="audio_file" class="form-label enhanced-label">
                                <i class="fas fa-music"></i>
                                Audio File
                            </label>
                            <div class="file-upload-group enhanced-file-upload">
                                <input type="file" id="audio_file" name="audio_file"
                                    class="file-input enhanced-file-input"
                                    accept=".mp3,.wav,.ogg,.m4a"
                                    onchange="previewAudioFile(this)">
                                <div class="file-upload-placeholder">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Click to upload audio file</span>
                                    <small>MP3, WAV, OGG, M4A (max 10MB)</small>
                                </div>
                                <div class="file-preview" id="audioPreview" style="display: none;">
                                    <audio controls class="audio-preview">
                                        <source src="" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                    <button type="button" class="remove-file-btn" onclick="removeAudioFile()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @error('audio_file')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="sheet_music_file" class="form-label enhanced-label">
                                <i class="fas fa-file-pdf"></i>
                                Sheet Music
                            </label>
                            <div class="file-upload-group enhanced-file-upload">
                                <input type="file" id="sheet_music_file" name="sheet_music_file"
                                    class="file-input enhanced-file-input"
                                    accept=".pdf,.doc,.docx"
                                    onchange="previewSheetMusicFile(this)">
                                <div class="file-upload-placeholder">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Click to upload sheet music</span>
                                    <small>PDF, DOC, DOCX (max 20MB)</small>
                                </div>
                                <div class="file-preview" id="sheetMusicPreview" style="display: none;">
                                    <div class="file-info">
                                        <i class="fas fa-file-pdf"></i>
                                        <span class="file-name"></span>
                                        <span class="file-size"></span>
                                    </div>
                                    <button type="button" class="remove-file-btn" onclick="removeSheetMusicFile()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @error('sheet_music_file')
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
                        <p class="section-subtitle">Optional information and notes</p>
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="lyrics" class="form-label enhanced-label">
                            <i class="fas fa-align-left"></i>
                            Lyrics
                        </label>
                        <textarea id="lyrics" name="lyrics"
                            class="form-textarea enhanced-textarea wysiwyg-editor"
                            rows="6"
                            placeholder="Enter the song lyrics here...">{{ old('lyrics') }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('lyrics')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="description" class="form-label enhanced-label">
                            <i class="fas fa-align-left"></i>
                            Description
                        </label>
                        <textarea id="description" name="description"
                            class="form-textarea enhanced-textarea"
                            rows="4"
                            placeholder="Enter song description or notes...">{{ old('description') }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('description')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group enhanced-group full-width">
                        <label for="notes" class="form-label enhanced-label">
                            <i class="fas fa-sticky-note"></i>
                            Performance Notes
                        </label>
                        <textarea id="notes" name="notes"
                            class="form-textarea enhanced-textarea"
                            rows="3"
                            placeholder="Enter performance notes, special instructions, or rehearsal tips...">{{ old('notes') }}</textarea>
                        <div class="textarea-glow"></div>
                        @error('notes')
                        <span class="error-message enhanced-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group enhanced-group">
                            <label for="is_active" class="form-label enhanced-label">
                                <i class="fas fa-toggle-on"></i>
                                Active Status
                            </label>
                            <div class="checkbox-group enhanced-checkbox">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                    class="enhanced-checkbox-input"
                                    {{ old('is_active', '1') ? 'checked' : '' }}>
                                <label for="is_active" class="checkbox-label enhanced-label">
                                    <span class="checkbox-custom"></span>
                                    Active in repertoire
                                </label>
                            </div>
                            @error('is_active')
                            <span class="error-message enhanced-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group enhanced-group">
                            <label for="is_featured" class="form-label enhanced-label">
                                <i class="fas fa-star"></i>
                                Featured Song
                            </label>
                            <div class="checkbox-group enhanced-checkbox">
                                <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                    class="enhanced-checkbox-input"
                                    {{ old('is_featured') ? 'checked' : '' }}>
                                <label for="is_featured" class="checkbox-label enhanced-label">
                                    <span class="checkbox-custom"></span>
                                    Mark as featured song
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
                        <span>Create Song</span>
                    </div>
                    <div class="btn-glow"></div>
                </button>
                <a href="{{ route('admin.songs.index') }}" class="btn btn-outline enhanced-btn">
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
    function previewAudioFile(input) {
        const file = input.files[0];
        const preview = document.getElementById('audioPreview');
        const audio = preview.querySelector('audio source');
        const placeholder = input.parentNode.querySelector('.file-upload-placeholder');

        if (file) {
            const url = URL.createObjectURL(file);
            audio.src = url;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        }
    }

    function removeAudioFile() {
        const input = document.getElementById('audio_file');
        const preview = document.getElementById('audioPreview');
        const placeholder = input.parentNode.querySelector('.file-upload-placeholder');

        input.value = '';
        preview.style.display = 'none';
        placeholder.style.display = 'block';
    }

    function previewSheetMusicFile(input) {
        const file = input.files[0];
        const preview = document.getElementById('sheetMusicPreview');
        const fileName = preview.querySelector('.file-name');
        const fileSize = preview.querySelector('.file-size');
        const placeholder = input.parentNode.querySelector('.file-upload-placeholder');

        if (file) {
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        }
    }

    function removeSheetMusicFile() {
        const input = document.getElementById('sheet_music_file');
        const preview = document.getElementById('sheetMusicPreview');
        const placeholder = input.parentNode.querySelector('.file-upload-placeholder');

        input.value = '';
        preview.style.display = 'none';
        placeholder.style.display = 'block';
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Initialize TinyMCE WYSIWYG Editor
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '.wysiwyg-editor',
                height: 350,
                menubar: false,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons',
                    'textcolor', 'colorpicker', 'textpattern', 'nonbreaking', 'pagebreak',
                    'directionality', 'template', 'paste', 'autosave'
                ],
                toolbar: 'undo redo | blocks fontsize | ' +
                    'bold italic underline strikethrough | forecolor backcolor | ' +
                    'alignleft aligncenter alignright alignjustify | ' +
                    'bullist numlist outdent indent | ' +
                    'link image media table | ' +
                    'emoticons charmap | ' +
                    'removeformat | fullscreen preview code | help',
                fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 20pt 24pt 28pt 32pt 36pt 48pt',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; line-height: 1.6; }',
                paste_data_images: false,
                paste_as_text: false,
                paste_auto_cleanup_on_paste: true,
                paste_remove_styles_if_webkit: false,
                paste_merge_formats: true,
                setup: function(editor) {
                    editor.on('change', function() {
                        editor.save();
                    });

                    // Add custom button for song structure
                    editor.ui.registry.addButton('songstructure', {
                        text: 'Song Structure',
                        tooltip: 'Insert song structure template',
                        onAction: function() {
                            editor.insertContent('<p><strong>Verse 1:</strong><br><br><strong>Chorus:</strong><br><br><strong>Verse 2:</strong><br><br><strong>Chorus:</strong><br><br><strong>Bridge:</strong><br><br><strong>Chorus:</strong></p>');
                        }
                    });
                },
                init_instance_callback: function(editor) {
                    // Auto-save functionality
                    editor.on('keyup', function() {
                        clearTimeout(window.tinymceAutoSave);
                        window.tinymceAutoSave = setTimeout(function() {
                            editor.save();
                        }, 2000);
                    });
                }
            });
        }
    });
</script>
@endpush