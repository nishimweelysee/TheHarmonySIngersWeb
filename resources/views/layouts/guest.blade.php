<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    :root {
        --primary: #173478;
        --primary-light: #1e40af;
        --primary-dark: #0f1729;
        --secondary: #f8fafc;
        --accent: #3b82f6;
        --white: #ffffff;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --success: #10b981;
        --warning: #f59e0b;
        --error: #ef4444;
        --info: #3b82f6;
        --font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        --space-1: 0.25rem;
        --space-2: 0.5rem;
        --space-3: 0.75rem;
        --space-4: 1rem;
        --space-5: 1.25rem;
        --space-6: 1.5rem;
        --space-8: 2rem;
        --space-10: 2.5rem;
        --space-12: 3rem;
        --space-16: 4rem;
        --radius-sm: 0.375rem;
        --radius: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
        --radius-2xl: 1.5rem;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        --transition: 0.15s ease-in-out;
    }

    body {
        font-family: var(--font-family);
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        min-height: 100vh;
    }

    .auth-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: var(--space-6);
    }

    .auth-card {
        background: white;
        border-radius: var(--radius-2xl);
        box-shadow: var(--shadow-xl);
        width: 100%;
        max-width: 400px;
        overflow: hidden;
    }

    .auth-header {
        text-align: center;
        padding: var(--space-8) var(--space-6) var(--space-6);
        background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
    }

    .auth-body {
        padding: 0 var(--space-6) var(--space-8);
    }

    .logo-container {
        margin-bottom: var(--space-6);
    }

    .logo-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto var(--space-4);
        box-shadow: var(--shadow-lg);
    }

    .logo-text {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: var(--space-2);
    }

    .logo-subtitle {
        color: var(--gray-500);
        font-size: 0.875rem;
    }

    .form-input {
        width: 100%;
        padding: var(--space-3);
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-lg);
        font-size: 1rem;
        transition: var(--transition);
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(23, 52, 120, 0.1);
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: var(--space-2);
        font-size: 0.875rem;
    }

    .form-group {
        margin-bottom: var(--space-6);
    }

    .btn-primary {
        background: var(--primary);
        color: white;
        padding: var(--space-3) var(--space-6);
        border: none;
        border-radius: var(--radius-lg);
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        width: 100%;
    }

    .btn-primary:hover {
        background: var(--primary-light);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }

    .link:hover {
        color: var(--primary-light);
        text-decoration: underline;
    }

    .error-message {
        color: var(--error);
        font-size: 0.875rem;
        margin-top: var(--space-1);
    }

    .success-message {
        background: var(--success);
        color: white;
        padding: var(--space-3);
        border-radius: var(--radius-lg);
        margin-bottom: var(--space-4);
        font-size: 0.875rem;
    }

    .checkbox-container {
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }

    .checkbox {
        width: 16px;
        height: 16px;
        accent-color: var(--primary);
    }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="logo-container">
                    <a href="{{ route('home') }}" style="text-decoration: none;">
                        <div class="logo-icon">
                            <i class="fas fa-music" style="font-size: 2rem; color: white;"></i>
                        </div>
                        <div class="logo-text">The Harmony Singers</div>
                        <div class="logo-subtitle">Beautiful Music, Beautiful Community</div>
                    </a>
                </div>
            </div>

            <div class="auth-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>