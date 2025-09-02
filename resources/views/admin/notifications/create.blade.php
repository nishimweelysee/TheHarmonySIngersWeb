@extends('layouts.admin')

@section('title', 'Send Notification')
@section('page-title', 'Send New Notification')

@section('content')

<!-- Enhanced Page Header -->
<div class="page-header">
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon-wrapper">
                <i class="fas fa-paper-plane"></i>
            </div>
            <div>
                <h1 class="header-title">Send New Notification</h1>
                <p class="header-subtitle">Communicate with choir members, users, or custom recipients</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Notifications
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Content Card -->
<div class="content-card">
    <div class="card-header">
        <div class="header-content">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Notification Details
            </h3>
            <div class="header-meta">
                <span class="info-text">Fill in the details below to send your notification</span>
            </div>
        </div>
    </div>

    <div class="card-content">
        <form action="{{ route('admin.notifications.store') }}" method="POST" class="notification-form" id="notificationForm">
            @csrf

            <!-- Enhanced Template Selection -->
            <div class="form-section">
                <div class="section-header">
                    <h4 class="section-title">
                        <i class="fas fa-file-alt"></i>
                        Choose Template
                    </h4>
                    <p class="section-description">Select a pre-defined template or create a custom message</p>
                </div>

                <div class="template-grid">
                    @foreach($notificationTemplates as $key => $template)
                    <div class="template-card {{ request('template') === $key ? 'selected' : '' }}"
                        data-template="{{ $key }}" data-title="{{ $template['title'] }}"
                        data-message="{{ $template['message'] }}">
                        <div class="template-icon template-icon-{{ $key }}">
                            @switch($key)
                            @case('rehearsal_reminder')
                            <i class="fas fa-music"></i>
                            @break
                            @case('concert_announcement')
                            <i class="fas fa-calendar-alt"></i>
                            @break
                            @case('general_announcement')
                            <i class="fas fa-bullhorn"></i>
                            @break
                            @case('birthday_wishes')
                            <i class="fas fa-birthday-cake"></i>
                            @break
                            @case('event_announcement')
                            <i class="fas fa-star"></i>
                            @break
                            @default
                            <i class="fas fa-file-alt"></i>
                            @endswitch
                        </div>
                        <div class="template-content">
                            <h5 class="template-name">{{ $template['name'] }}</h5>
                            <p class="template-description">{{ Str::limit($template['message'], 80) }}</p>
                        </div>
                        <div class="template-radio">
                            <input type="radio" name="template" value="{{ $key }}" id="template_{{ $key }}"
                                {{ request('template') === $key ? 'checked' : '' }}>
                            <label for="template_{{ $key }}" class="radio-label"></label>
                        </div>
                        <div class="template-overlay">
                            <div class="overlay-content">
                                <i class="fas fa-check-circle"></i>
                                <span>Selected</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Enhanced Title and Message -->
            <div class="form-section">
                <div class="section-header">
                    <h4 class="section-title">
                        <i class="fas fa-edit"></i>
                        Notification Content
                    </h4>
                    <p class="section-description">Customize the title and message for your notification</p>
                </div>

                <!-- Template Preview -->
                <div id="template-preview" class="template-preview hidden">
                    <div class="preview-header">
                        <h5><i class="fas fa-eye"></i> Template Preview</h5>
                        <button type="button" class="btn btn-sm btn-outline" onclick="hidePreview()">
                            <i class="fas fa-times"></i> Hide
                        </button>
                    </div>
                    <div class="preview-content">
                        <div class="preview-title"></div>
                        <div class="preview-message"></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="title" class="form-label">
                            Notification Title <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <input type="text" id="title" name="title" required class="form-input"
                                placeholder="Enter notification title" value="{{ old('title') }}">
                            <div class="input-focus-border"></div>
                        </div>
                        @error('title')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="message" class="form-label">
                            Message <span class="required">*</span>
                        </label>
                        <div class="textarea-wrapper">
                            <textarea id="message" name="message" rows="6" required class="form-textarea"
                                placeholder="Enter your message here...">{{ old('message') }}</textarea>
                            <div class="textarea-focus-border"></div>
                        </div>
                        <div class="form-help">
                            <span class="char-count">0</span> / 2000 characters
                            <span class="char-remaining"></span>
                        </div>
                        @error('message')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Enhanced Recipient Selection -->
            <div class="form-section">
                <div class="section-header">
                    <h4 class="section-title">
                        <i class="fas fa-users"></i>
                        Recipients
                    </h4>
                    <p class="section-description">Choose who should receive this notification</p>
                </div>

                <div class="recipient-options">
                    <div class="recipient-option">
                        <input type="radio" name="recipient_type" value="all_members" id="recipient_all_members"
                            class="recipient-radio"
                            {{ old('recipient_type') === 'all_members' ? 'checked' : '' }}>
                        <label for="recipient_all_members" class="recipient-label">
                            <div class="recipient-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="recipient-content">
                                <h5>All Choir Members</h5>
                                <p>{{ $members->count() }} members will receive this notification</p>
                            </div>
                            <div class="recipient-check">
                                <i class="fas fa-check"></i>
                            </div>
                        </label>
                    </div>

                    <div class="recipient-option">
                        <input type="radio" name="recipient_type" value="all_users" id="recipient_all_users"
                            class="recipient-radio"
                            {{ old('recipient_type') === 'all_users' ? 'checked' : '' }}>
                        <label for="recipient_all_users" class="recipient-label">
                            <div class="recipient-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="recipient-content">
                                <h5>All Portal Users</h5>
                                <p>{{ $users->count() }} users will receive this notification</p>
                            </div>
                            <div class="recipient-check">
                                <i class="fas fa-check"></i>
                            </div>
                        </label>
                    </div>

                    <div class="recipient-option">
                        <input type="radio" name="recipient_type" value="selected_members"
                            id="recipient_selected_members" class="recipient-radio"
                            {{ old('recipient_type') === 'selected_members' ? 'checked' : '' }}>
                        <label for="recipient_selected_members" class="recipient-label">
                            <div class="recipient-icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="recipient-content">
                                <h5>Selected Members</h5>
                                <p>Choose specific choir members</p>
                            </div>
                            <div class="recipient-check">
                                <i class="fas fa-check"></i>
                            </div>
                        </label>
                    </div>

                    <div class="recipient-option">
                        <input type="radio" name="recipient_type" value="selected_users" id="recipient_selected_users"
                            class="recipient-radio"
                            {{ old('recipient_type') === 'selected_users' ? 'checked' : '' }}>
                        <label for="recipient_selected_users" class="recipient-label">
                            <div class="recipient-icon">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <div class="recipient-content">
                                <h5>Selected Users</h5>
                                <p>Choose specific portal users</p>
                            </div>
                            <div class="recipient-check">
                                <i class="fas fa-check"></i>
                            </div>
                        </label>
                    </div>

                    <div class="recipient-option">
                        <input type="radio" name="recipient_type" value="custom" id="recipient_custom"
                            class="recipient-radio"
                            {{ old('recipient_type') === 'custom' ? 'checked' : '' }}>
                        <label for="recipient_custom" class="recipient-label">
                            <div class="recipient-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="recipient-content">
                                <h5>Custom Email Addresses</h5>
                                <p>Send to specific email addresses</p>
                            </div>
                            <div class="recipient-check">
                                <i class="fas fa-check"></i>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Dynamic Recipient Sections -->
                <div id="selected-members-section" class="recipient-section hidden">
                    <div class="section-subheader">
                        <h5>Select Members</h5>
                        <p>Choose which choir members should receive this notification</p>
                    </div>
                    <div class="recipient-list">
                        @foreach($members as $member)
                        <label class="recipient-item">
                            <input type="checkbox" name="selected_recipients[]" value="member_{{ $member->id }}"
                                class="recipient-checkbox">
                            <div class="recipient-info">
                                <div class="recipient-name">{{ $member->first_name }} {{ $member->last_name }}</div>
                                <div class="recipient-details">
                                    <span class="recipient-email">{{ $member->email }}</span>
                                    @if($member->voice_part)
                                    <span class="recipient-voice">{{ ucfirst($member->voice_part) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="checkbox-custom">
                                <i class="fas fa-check"></i>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div id="selected-users-section" class="recipient-section hidden">
                    <div class="section-subheader">
                        <h5>Select Users</h5>
                        <p>Choose which portal users should receive this notification</p>
                    </div>
                    <div class="recipient-list">
                        @foreach($users as $user)
                        <label class="recipient-item">
                            <input type="checkbox" name="selected_recipients[]" value="user_{{ $user->id }}"
                                class="recipient-checkbox">
                            <div class="recipient-info">
                                <div class="recipient-name">{{ $user->name }}</div>
                                <div class="recipient-details">
                                    <span class="recipient-email">{{ $user->email }}</span>
                                    @if($user->role)
                                    <span class="recipient-role">{{ ucfirst($user->role->name) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="checkbox-custom">
                                <i class="fas fa-check"></i>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div id="custom-emails-section" class="recipient-section hidden">
                    <div class="section-subheader">
                        <h5>Custom Email Addresses</h5>
                        <p>Enter specific email addresses to receive this notification</p>
                    </div>
                    <div class="form-group">
                        <div class="textarea-wrapper">
                            <textarea id="custom_emails" name="custom_emails" rows="3"
                                class="form-textarea"
                                placeholder="Enter email addresses separated by commas (e.g., email1@example.com, email2@example.com)">{{ old('custom_emails') }}</textarea>
                            <div class="textarea-focus-border"></div>
                        </div>
                        <div class="form-help">Separate multiple email addresses with commas</div>
                        @error('custom_emails')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Enhanced Delivery Methods -->
            <div class="form-section">
                <div class="section-header">
                    <h4 class="section-title">
                        <i class="fas fa-paper-plane"></i>
                        Delivery Methods
                    </h4>
                    <p class="section-description">Choose how to deliver this notification</p>
                </div>

                <div class="delivery-options">
                    <label class="delivery-option">
                        <input type="checkbox" name="send_inbox" value="1" checked
                            class="delivery-checkbox">
                        <div class="delivery-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <div class="delivery-content">
                            <h5>Inbox Notification</h5>
                            <p>Send to portal inbox</p>
                        </div>
                        <div class="checkbox-custom">
                            <i class="fas fa-check"></i>
                        </div>
                    </label>

                    <label class="delivery-option">
                        <input type="checkbox" name="send_email" value="1" class="delivery-checkbox">
                        <div class="delivery-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="delivery-content">
                            <h5>Email</h5>
                            <p>Send via email</p>
                        </div>
                        <div class="checkbox-custom">
                            <i class="fas fa-check"></i>
                        </div>
                    </label>

                    <label class="delivery-option">
                        <input type="checkbox" name="send_sms" value="1" class="delivery-checkbox">
                        <div class="delivery-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="delivery-content">
                            <h5>SMS</h5>
                            <p>Send text message (if phone available)</p>
                        </div>
                        <div class="checkbox-custom">
                            <i class="fas fa-check"></i>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Enhanced Form Actions -->
            <div class="form-actions">
                <button type="button" class="btn btn-info" onclick="testFormSubmission()">
                    <i class="fas fa-bug"></i>
                    Test Form
                </button>
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-paper-plane"></i>
                    <span class="btn-text">Send Notification</span>
                    <span class="btn-loading hidden">
                        <i class="fas fa-spinner fa-spin"></i>
                        Sending...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Enhanced Page Header */
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: var(--white);
        margin-bottom: var(--space-8);
    }

    .header-icon-wrapper {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: var(--space-4);
    }

    .header-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: var(--space-2);
    }

    .header-subtitle {
        opacity: 0.9;
        font-size: 1rem;
    }

    /* Enhanced Template Cards */
    .template-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: var(--space-4);
        margin-top: var(--space-4);
    }

    .template-card {
        position: relative;
        background: var(--white);
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-xl);
        padding: var(--space-6);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .template-card:hover {
        transform: translateY(-4px);
        border-color: var(--accent);
        box-shadow: var(--shadow-xl);
    }

    .template-card.selected {
        border-color: var(--accent);
        background: linear-gradient(135deg, var(--accent-light) 0%, var(--primary-50) 100%);
        box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.15);
    }

    .template-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--gray-600);
        margin-bottom: var(--space-4);
        transition: all 0.3s ease;
    }

    .template-card:hover .template-icon {
        background: linear-gradient(135deg, var(--accent-light) 0%, var(--primary-100) 100%);
        color: var(--accent);
        transform: scale(1.1);
    }

    .template-card.selected .template-icon {
        background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
        color: var(--white);
    }

    .template-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: var(--space-2);
    }

    .template-description {
        color: var(--gray-600);
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .template-radio {
        position: absolute;
        top: var(--space-4);
        right: var(--space-4);
        opacity: 0;
        pointer-events: none;
    }

    .radio-label {
        display: none;
    }

    /* Template Preview */
    .template-preview {
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        padding: var(--space-4);
        margin-bottom: var(--space-6);
    }

    .preview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-4);
        padding-bottom: var(--space-3);
        border-bottom: 1px solid var(--gray-200);
    }

    .preview-header h5 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }

    .preview-header h5 i {
        color: var(--accent);
    }

    .preview-content {
        background: var(--white);
        border-radius: var(--radius);
        padding: var(--space-4);
        border: 1px solid var(--gray-200);
    }

    .preview-title {
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: var(--space-3);
        font-size: 1.1rem;
    }

    .preview-message {
        color: var(--gray-700);
        line-height: 1.6;
        white-space: pre-wrap;
    }

    .template-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.9) 0%, rgba(37, 99, 235, 0.9) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: var(--radius-xl);
    }

    .template-card.selected .template-overlay {
        opacity: 1;
    }

    .overlay-content {
        color: var(--white);
        text-align: center;
    }

    .overlay-content i {
        font-size: 2rem;
        margin-bottom: var(--space-2);
        display: block;
    }

    .overlay-content span {
        font-weight: 600;
        font-size: 1.1rem;
    }

    /* Enhanced Form Inputs */
    .input-wrapper,
    .textarea-wrapper {
        position: relative;
    }

    .form-input,
    .form-textarea {
        width: 100%;
        padding: var(--space-4) var(--space-5);
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-lg);
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--white);
        font-family: inherit;
        line-height: 1.5;
    }

    .form-textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        background: var(--gray-50);
    }

    .form-input:hover,
    .form-textarea:hover {
        border-color: var(--gray-300);
    }

    .input-focus-border,
    .textarea-focus-border {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--accent);
        transition: width 0.3s ease;
    }

    .form-input:focus~.input-focus-border,
    .form-textarea:focus~.textarea-focus-border {
        width: 100%;
    }

    /* Enhanced Recipient Options */
    .recipient-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: var(--space-4);
        margin-top: var(--space-4);
    }

    .recipient-option {
        position: relative;
    }

    .recipient-label {
        display: flex;
        align-items: center;
        padding: var(--space-6);
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-xl);
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--white);
    }

    .recipient-label:hover {
        border-color: var(--accent);
        background: var(--gray-50);
        transform: translateY(-2px);
    }

    .recipient-radio:checked+.recipient-label {
        border-color: var(--accent);
        background: linear-gradient(135deg, var(--accent-light) 0%, var(--primary-50) 100%);
        box-shadow: var(--shadow-lg);
    }

    .recipient-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--gray-600);
        margin-right: var(--space-4);
        transition: all 0.3s ease;
    }

    .recipient-label:hover .recipient-icon {
        background: linear-gradient(135deg, var(--accent-light) 0%, var(--primary-100) 100%);
        color: var(--accent);
        transform: scale(1.05);
    }

    .recipient-radio:checked+.recipient-label .recipient-icon {
        background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
        color: var(--white);
    }

    .recipient-content h5 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: var(--space-1);
    }

    .recipient-content p {
        color: var(--gray-600);
        font-size: 0.9rem;
        margin: 0;
    }

    .recipient-check {
        position: absolute;
        right: var(--space-6);
        top: 50%;
        transform: translateY(-50%);
        width: 24px;
        height: 24px;
        border: 2px solid var(--gray-200);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .recipient-radio:checked+.recipient-label .recipient-check {
        border-color: var(--accent);
        background: var(--accent);
        color: var(--white);
    }

    /* Enhanced Delivery Options */
    .delivery-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: var(--space-4);
        margin-top: var(--space-4);
    }

    .delivery-option {
        position: relative;
        cursor: pointer;
    }

    .delivery-option label {
        display: flex;
        align-items: center;
        padding: var(--space-6);
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-xl);
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--white);
    }

    .delivery-option:hover label {
        border-color: var(--accent);
        background: var(--gray-50);
        transform: translateY(-2px);
    }

    .delivery-checkbox:checked+label {
        border-color: var(--accent);
        background: linear-gradient(135deg, var(--accent-light) 0%, var(--primary-50) 100%);
        box-shadow: var(--shadow-lg);
    }

    .delivery-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--gray-600);
        margin-right: var(--space-4);
        transition: all 0.3s ease;
    }

    .delivery-option:hover label .delivery-icon {
        background: linear-gradient(135deg, var(--accent-light) 0%, var(--primary-100) 100%);
        color: var(--accent);
        transform: scale(1.05);
    }

    .delivery-checkbox:checked+label .delivery-icon {
        background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
        color: var(--white);
    }

    .delivery-content h5 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: var(--space-1);
    }

    .delivery-content p {
        color: var(--gray-600);
        font-size: 0.9rem;
        margin: 0;
    }

    .checkbox-custom {
        position: absolute;
        right: var(--space-6);
        top: 50%;
        transform: translateY(-50%);
        width: 24px;
        height: 24px;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .delivery-checkbox:checked+label .checkbox-custom {
        border-color: var(--accent);
        background: var(--accent);
        color: var(--white);
    }

    /* Enhanced Recipient List */
    .recipient-list {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        margin-top: var(--space-4);
    }

    .recipient-item {
        display: flex;
        align-items: center;
        padding: var(--space-4) var(--space-6);
        border-bottom: 1px solid var(--gray-100);
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .recipient-item:hover {
        background-color: var(--gray-50);
    }

    .recipient-item:last-child {
        border-bottom: none;
    }

    .recipient-checkbox {
        margin-right: var(--space-4);
    }

    .recipient-info {
        flex: 1;
    }

    .recipient-name {
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: var(--space-1);
    }

    .recipient-details {
        display: flex;
        gap: var(--space-4);
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    .recipient-email,
    .recipient-voice,
    .recipient-role {
        background: var(--gray-100);
        padding: var(--space-1) var(--space-2);
        border-radius: var(--radius);
        font-size: 0.75rem;
    }

    /* Enhanced Form Actions */
    .form-actions {
        display: flex;
        gap: var(--space-4);
        justify-content: flex-end;
        margin-top: var(--space-8);
        padding-top: var(--space-8);
        border-top: 1px solid var(--gray-200);
    }

    /* Enhanced Section Styling */
    .form-section {
        margin-bottom: var(--space-8);
        padding: var(--space-8);
        background: var(--white);
        border-radius: var(--radius-xl);
        border: 1px solid var(--gray-100);
        box-shadow: var(--shadow);
    }

    .section-header {
        margin-bottom: var(--space-6);
        padding-bottom: var(--space-4);
        border-bottom: 2px solid var(--gray-100);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: var(--space-2);
    }

    .section-title i {
        color: var(--accent);
        font-size: 1.1rem;
    }

    .section-description {
        color: var(--gray-600);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .section-subheader {
        margin-bottom: var(--space-4);
    }

    .section-subheader h5 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: var(--space-1);
    }

    .section-subheader p {
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    /* Enhanced Form Groups */
    .form-group {
        margin-bottom: var(--space-6);
    }

    .form-row {
        margin-bottom: var(--space-6);
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: var(--space-2);
        font-size: 0.95rem;
    }

    .required {
        color: var(--error);
        font-weight: 700;
    }

    /* Enhanced Help Text */
    .form-help {
        margin-top: var(--space-2);
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    .char-count {
        font-weight: 600;
        color: var(--accent);
    }

    .char-remaining {
        margin-left: var(--space-2);
        font-weight: 500;
    }

    /* Enhanced Error Messages */
    .error-message {
        display: block;
        margin-top: var(--space-2);
        color: var(--error);
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Hidden class for dynamic sections */
    .hidden {
        display: none;
    }

    /* Button loading state */
    .btn-loading {
        display: none;
    }

    .btn.loading .btn-text {
        display: none;
    }

    .btn.loading .btn-loading {
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .template-grid {
            grid-template-columns: 1fr;
        }

        .recipient-options {
            grid-template-columns: 1fr;
        }

        .delivery-options {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .header-content {
            flex-direction: column;
            gap: var(--space-4);
            text-align: center;
        }

        .header-icon-wrapper {
            margin-right: 0;
            margin-bottom: var(--space-4);
        }
    }

    @media (max-width: 480px) {
        .form-section {
            padding: var(--space-4);
        }

        .template-card,
        .recipient-label,
        .delivery-option label {
            padding: var(--space-4);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const templateCards = document.querySelectorAll('.template-card');
        const titleInput = document.getElementById('title');
        const messageInput = document.getElementById('message');
        const charCount = document.querySelector('.char-count');
        const recipientTypeRadios = document.querySelectorAll('input[name="recipient_type"]');

        // Template selection
        templateCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from all cards
                templateCards.forEach(c => c.classList.remove('selected'));

                // Add selected class to clicked card
                this.classList.add('selected');

                // Check the radio button
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;

                // Fill in the form fields
                const template = radio.value;
                if (template && template !== 'custom') {
                    const title = this.dataset.title;
                    const message = this.dataset.message;
                    titleInput.value = title;
                    messageInput.value = message;
                    updateCharCount();

                    // Show template preview
                    showTemplatePreview(title, message);

                    // Auto-select "All Choir Members" as default recipient type
                    const allMembersRadio = document.getElementById('recipient_all_members');
                    if (allMembersRadio) {
                        allMembersRadio.checked = true;
                        allMembersRadio.dispatchEvent(new Event('change'));
                    }

                    // Auto-select "Send to Inbox" as default delivery method
                    const inboxCheckbox = document.querySelector('input[name="send_inbox"]');
                    if (inboxCheckbox) {
                        inboxCheckbox.checked = true;
                    }
                } else {
                    // Hide preview for custom template
                    hidePreview();
                }
            });
        });

        // Character count
        messageInput.addEventListener('input', updateCharCount);

        function updateCharCount() {
            const count = messageInput.value.length;
            const remaining = 2000 - count;
            const charRemaining = document.querySelector('.char-remaining');

            charCount.textContent = count;
            charRemaining.textContent = `(${remaining} remaining)`;

            if (count > 1800) {
                charCount.style.color = 'var(--error)';
                charRemaining.style.color = 'var(--error)';
            } else if (count > 1500) {
                charCount.style.color = 'var(--warning)';
                charRemaining.style.color = 'var(--warning)';
            } else {
                charCount.style.color = 'var(--accent)';
                charRemaining.style.color = 'var(--gray-600)';
            }
        }

        // Initialize character count
        updateCharCount();

        // Recipient type change handler
        recipientTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                // Hide all sections first
                document.querySelectorAll('.recipient-section').forEach(section => {
                    section.classList.add('hidden');
                });

                // Show relevant section
                if (this.value === 'selected_members') {
                    document.getElementById('selected-members-section').classList.remove('hidden');
                } else if (this.value === 'selected_users') {
                    document.getElementById('selected-users-section').classList.remove('hidden');
                } else if (this.value === 'custom') {
                    document.getElementById('custom-emails-section').classList.remove('hidden');
                }
            });
        });

        // Form validation
        document.getElementById('notificationForm').addEventListener('submit', function(e) {
            const recipientType = document.querySelector('input[name="recipient_type"]:checked');

            if (!recipientType) {
                e.preventDefault();
                alert('Please select a recipient type');
                return;
            }

            if (recipientType.value === 'selected_members' || recipientType.value === 'selected_users') {
                const selectedRecipients = document.querySelectorAll('input[name="selected_recipients[]"]:checked');
                if (selectedRecipients.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one recipient');
                    return;
                }
            }

            if (recipientType.value === 'custom') {
                const customEmails = document.getElementById('custom_emails').value.trim();
                if (!customEmails) {
                    e.preventDefault();
                    alert('Please enter at least one email address');
                    return;
                }
            }

            // Check if at least one delivery method is selected
            const deliveryMethods = document.querySelectorAll('input[name="send_inbox"], input[name="send_email"], input[name="send_sms"]');
            const hasDeliveryMethod = Array.from(deliveryMethods).some(method => method.checked);

            if (!hasDeliveryMethod) {
                e.preventDefault();
                alert('Please select at least one delivery method');
                return;
            }

            // Show loading state
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });

        // Auto-select template if URL parameter exists
        const urlParams = new URLSearchParams(window.location.search);
        const templateParam = urlParams.get('template');
        if (templateParam) {
            const templateCard = document.querySelector(`[data-template="${templateParam}"]`);
            if (templateCard) {
                templateCard.click();
            }
        }

        // Set default recipient type if none is selected
        const hasRecipientType = document.querySelector('input[name="recipient_type"]:checked');
        if (!hasRecipientType) {
            const allMembersRadio = document.getElementById('recipient_all_members');
            if (allMembersRadio) {
                allMembersRadio.checked = true;
            }
        }

        // Set default delivery method if none is selected
        const hasDeliveryMethod = document.querySelectorAll('input[name="send_inbox"], input[name="send_email"], input[name="send_sms"]:checked');
        if (hasDeliveryMethod.length === 0) {
            const inboxCheckbox = document.querySelector('input[name="send_inbox"]');
            if (inboxCheckbox) {
                inboxCheckbox.checked = true;
            }
        }
    });

    // Test function to debug form submission
    function testFormSubmission() {
        console.log('=== FORM TEST ===');
        const form = document.getElementById('notificationForm');
        console.log('Form element:', form);
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);

        // Check all form fields
        console.log('Title:', document.getElementById('title').value);
        console.log('Message:', document.getElementById('message').value);
        console.log('Template:', document.querySelector('input[name="template"]:checked')?.value);
        console.log('Recipient type:', document.querySelector('input[name="recipient_type"]:checked')?.value);
        console.log('Send inbox:', document.querySelector('input[name="send_inbox"]')?.checked);
        console.log('Send email:', document.querySelector('input[name="send_email"]')?.checked);
        console.log('Send SMS:', document.querySelector('input[name="send_sms"]')?.checked);

        // Check CSRF token
        const csrfToken = document.querySelector('input[name="_token"]');
        console.log('CSRF token present:', csrfToken ? 'Yes' : 'No');

        // Test form validation
        const formData = new FormData(form);
        console.log('FormData entries:');
        for (let [key, value] of formData.entries()) {
            console.log(`  ${key}: ${value}`);
        }

        console.log('=== END FORM TEST ===');
    }

    // Template preview functions
    function showTemplatePreview(title, message) {
        const preview = document.getElementById('template-preview');
        const previewTitle = preview.querySelector('.preview-title');
        const previewMessage = preview.querySelector('.preview-message');

        previewTitle.textContent = title;
        previewMessage.textContent = message;
        preview.classList.remove('hidden');
    }

    function hidePreview() {
        const preview = document.getElementById('template-preview');
        preview.classList.add('hidden');
    }
</script>

@endsection