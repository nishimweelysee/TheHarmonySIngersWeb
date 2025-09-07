@extends('layouts.public')

@section('title', 'File Upload Too Large')
@section('description', 'The uploaded file exceeds the maximum allowed size')

@section('content')
<div class="error-container">
    <div class="error-content">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>

        <h1 class="error-title">File Upload Too Large</h1>
        <p class="error-message">
            The file you're trying to upload exceeds the maximum allowed size for this server.
        </p>

        <div class="current-limits">
            <h3>Current Server Limits:</h3>
            <div class="limits-grid">
                <div class="limit-item">
                    <span class="limit-label">Upload Max Size:</span>
                    <span class="limit-value">{{ $current_limits['upload_max_filesize'] }}</span>
                </div>
                <div class="limit-item">
                    <span class="limit-label">Post Max Size:</span>
                    <span class="limit-value">{{ $current_limits['post_max_size'] }}</span>
                </div>
                <div class="limit-item">
                    <span class="limit-label">Memory Limit:</span>
                    <span class="limit-value">{{ $current_limits['memory_limit'] }}</span>
                </div>
            </div>
        </div>

        <div class="solutions">
            <h3>Solutions:</h3>
            <ul>
                <li><strong>Reduce file size:</strong> Try uploading a smaller file or compress the file</li>
                <li><strong>Check file format:</strong> Ensure the file is in an appropriate format</li>
                <li><strong>Contact administrator:</strong> If you need to upload larger files regularly</li>
            </ul>
        </div>

        <div class="actions">
            <a href="{{ url()->previous() }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i>
                Go Back
            </a>
            <a href="{{ route('home') }}" class="btn btn-secondary">
                <i class="fas fa-home"></i>
                Home
            </a>
        </div>
    </div>
</div>

<style>
    .error-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: var(--space-6);
        background: var(--gray-50);
    }

    .error-content {
        max-width: 600px;
        text-align: center;
        background: white;
        padding: var(--space-8);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--gray-200);
    }

    .error-icon {
        font-size: 4rem;
        color: var(--warning);
        margin-bottom: var(--space-6);
    }

    .error-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: var(--space-4);
    }

    .error-message {
        font-size: 1.125rem;
        color: var(--gray-600);
        margin-bottom: var(--space-8);
        line-height: 1.6;
    }

    .current-limits {
        background: var(--gray-50);
        padding: var(--space-6);
        border-radius: var(--radius-lg);
        margin-bottom: var(--space-6);
        text-align: left;
    }

    .current-limits h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: var(--space-4);
        text-align: center;
    }

    .limits-grid {
        display: grid;
        gap: var(--space-3);
    }

    .limit-item {
        display: flex;
        justify-content: space-between;
        padding: var(--space-2) 0;
        border-bottom: 1px solid var(--gray-200);
    }

    .limit-item:last-child {
        border-bottom: none;
    }

    .limit-label {
        font-weight: 500;
        color: var(--gray-600);
    }

    .limit-value {
        font-weight: 600;
        color: var(--gray-900);
        font-family: monospace;
    }

    .solutions {
        text-align: left;
        margin-bottom: var(--space-8);
    }

    .solutions h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: var(--space-4);
        text-align: center;
    }

    .solutions ul {
        list-style: none;
        padding: 0;
    }

    .solutions li {
        padding: var(--space-2) 0;
        color: var(--gray-600);
        line-height: 1.5;
    }

    .solutions li:before {
        content: "✓";
        color: var(--success);
        font-weight: bold;
        margin-right: var(--space-2);
    }

    .actions {
        display: flex;
        gap: var(--space-4);
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-3) var(--space-6);
        border-radius: var(--radius);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: var(--gray-100);
        color: var(--gray-700);
        border: 1px solid var(--gray-300);
    }

    .btn-secondary:hover {
        background: var(--gray-200);
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .error-content {
            padding: var(--space-6);
        }

        .actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection