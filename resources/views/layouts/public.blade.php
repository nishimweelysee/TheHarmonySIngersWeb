<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - The Harmony Singers</title>
    <meta name="description"
        content="@yield('description', 'The Harmony Singers - A premier choir bringing beautiful music to our community')">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('ths-favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('ths-favicon.svg') }}">

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
    /* Professional Design System */
    :root {
        /* Brand Colors */
        --primary: #173478;
        --primary-light: #1e40af;
        --primary-dark: #0f1729;
        --secondary: #f8fafc;
        --accent: #3b82f6;

        /* Neutral Colors */
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

        /* Semantic Colors */
        --success: #10b981;
        --warning: #f59e0b;
        --error: #ef4444;
        --info: #3b82f6;

        /* Typography */
        --font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;

        /* Spacing Scale */
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
        --space-20: 5rem;
        --space-24: 6rem;

        /* Border Radius */
        --radius-sm: 0.375rem;
        --radius: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
        --radius-2xl: 1.5rem;

        /* Shadows */
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);

        /* Transitions */
        --transition: 0.15s ease-in-out;
        --transition-slow: 0.3s ease-in-out;
    }

    /* Reset and Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: var(--font-family);
        line-height: 1.6;
        color: var(--gray-700);
        background-color: var(--white);
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Professional Navigation */
    .navbar {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--gray-200);
        position: sticky;
        top: 0;
        z-index: 50;
        transition: var(--transition);
    }

    .navbar-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 var(--space-4);
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 5rem;
        min-height: 5rem;
    }

    .navbar-brand {
        font-weight: 800;
        font-size: 1.5rem;
        color: var(--primary);
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: var(--transition);
    }

    .navbar-brand:hover {
        color: var(--primary-light);
        text-decoration: none;
        transform: translateY(-1px);
    }

    .navbar-logo {
        height: 50px;
        width: auto;
        max-width: 300px;
        transition: var(--transition);
        flex-shrink: 0;
    }

    .navbar-brand:hover .navbar-logo {
        transform: scale(1.02);
    }

    .brand-text {
        display: none;
    }

    /* Responsive logo sizing */
    @media (max-width: 768px) {
        .navbar-logo {
            height: 40px;
            max-width: 250px;
        }
    }

    @media (max-width: 480px) {
        .navbar-container {
            height: 4rem;
            min-height: 4rem;
        }

        .navbar-logo {
            height: 35px;
            max-width: 200px;
        }
    }

    .navbar-nav {
        display: flex;
        align-items: center;
        gap: var(--space-8);
    }

    .nav-link {
        font-weight: 500;
        color: var(--gray-600);
        text-decoration: none;
        padding: var(--space-2) var(--space-2);
        border-radius: var(--radius);
        transition: var(--transition);
        position: relative;
    }

    .nav-link:hover {
        color: var(--primary);
        background-color: var(--gray-50);
        text-decoration: none;
    }

    .nav-link.active {
        color: var(--primary);
        font-weight: 600;
    }

    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: var(--space-4);
        right: var(--space-4);
        height: 2px;
        background: var(--primary);
        border-radius: 1px;
    }

    /* Mobile Navigation */
    .mobile-menu-button {
        display: none;
        background: none;
        border: none;
        color: var(--gray-500);
        font-size: 1.5rem;
        cursor: pointer;
    }

    .mobile-nav {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-top: 1px solid var(--gray-200);
        box-shadow: var(--shadow-lg);
    }

    .mobile-nav-link {
        display: block;
        padding: var(--space-4);
        color: var(--gray-600);
        text-decoration: none;
        border-bottom: 1px solid var(--gray-100);
        transition: var(--transition);
    }

    .mobile-nav-link:hover {
        background-color: var(--gray-100);
        color: var(--primary);
    }

    .mobile-nav-link.active {
        color: var(--primary);
        background-color: var(--secondary);
        font-weight: 600;
    }

    /* Social Media Navigation */
    .social-media-nav {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        margin-left: var(--space-4);
        padding-left: var(--space-4);
        border-left: 1px solid var(--gray-200);
    }

    .social-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--gray-100);
        color: var(--gray-600);
        text-decoration: none;
        transition: all var(--transition);
        font-size: 1rem;
    }

    .social-link:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Mobile Social Media */
    .mobile-social-media {
        margin-top: var(--space-4);
        padding-top: var(--space-4);
        border-top: 1px solid var(--gray-200);
    }

    .mobile-social-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: var(--space-3);
        padding-left: var(--space-3);
    }

    .mobile-social-links {
        display: flex;
        flex-direction: column;
        gap: var(--space-2);
    }

    .mobile-social-link {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        padding: var(--space-2) var(--space-3);
        border-radius: var(--radius);
        text-decoration: none;
        color: var(--gray-700);
        transition: all var(--transition);
    }

    .mobile-social-link:hover {
        background: var(--gray-100);
        color: var(--primary);
    }

    .mobile-social-link i {
        width: 20px;
        text-align: center;
        font-size: 1.1rem;
    }

    /* Button Styles */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-2);
        padding: var(--space-3) var(--space-6);
        font-weight: 600;
        text-decoration: none;
        border-radius: var(--radius-lg);
        transition: var(--transition);
        cursor: pointer;
        border: none;
        font-size: 0.875rem;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-light);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: white;
        color: var(--gray-700);
        border: 1px solid var(--gray-300);
    }

    .btn-secondary:hover {
        background: var(--gray-50);
        border-color: var(--gray-400);
        transform: translateY(-1px);
        color: var(--gray-700);
        text-decoration: none;
    }

    .btn-lg {
        padding: var(--space-4) var(--space-8);
        font-size: 1rem;
    }

    /* Card Styles */
    .card {
        background: white;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow);
        overflow: hidden;
        transition: var(--transition-slow);
        border: 1px solid var(--gray-200);
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .card-header {
        padding: var(--space-6);
        border-bottom: 1px solid var(--gray-200);
    }

    .card-body {
        padding: var(--space-6);
    }

    .card-footer {
        padding: var(--space-6);
        border-top: 1px solid var(--gray-200);
        background: var(--gray-50);
    }

    /* Hero Section */
    .hero {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        padding: var(--space-20) 0;
        position: relative;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 var(--space-4);
        text-align: center;
    }

    .hero h1 {
        font-size: 3.5rem;
        font-weight: 900;
        margin-bottom: var(--space-6);
        line-height: 1.1;
    }

    .hero p {
        font-size: 1.25rem;
        margin-bottom: var(--space-8);
        opacity: 0.9;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Statistics */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--space-6);
        margin: var(--space-16) 0;
    }

    .stat-card {
        text-align: center;
        padding: var(--space-8);
        background: white;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow);
        transition: var(--transition-slow);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 900;
        color: var(--primary);
        margin-bottom: var(--space-2);
        line-height: 1;
    }

    .stat-label {
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: var(--space-1);
    }

    .stat-description {
        font-size: 0.875rem;
        color: var(--gray-500);
    }

    /* Section Styles */
    .section {
        padding: var(--space-20) 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: var(--space-16);
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: var(--space-4);
    }

    .section-subtitle {
        font-size: 1.125rem;
        color: var(--gray-600);
        max-width: 600px;
        margin: 0 auto;
    }

    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 var(--space-4);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .navbar-container {
            height: 4.5rem;
            min-height: 4.5rem;
        }

        .navbar-nav {
            display: none;
        }

        .mobile-menu-button {
            display: block;
        }

        .mobile-nav.show {
            display: block;
        }

        .hero h1 {
            font-size: 2.5rem;
        }

        .hero p {
            font-size: 1.125rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: var(--space-4);
        }

        .stat-number {
            font-size: 2.5rem;
        }

        /* Hide social media nav on mobile */
        .social-media-nav {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .hero {
            padding: var(--space-16) 0;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        /* Mobile social media adjustments */
        .mobile-social-links {
            gap: var(--space-1);
        }

        .mobile-social-link {
            padding: var(--space-1) var(--space-2);
        }

        .footer-social-links {
            gap: var(--space-2);
        }

        .footer-social-link {
            padding: var(--space-1) 0;
        }
    }

    /* Footer Social Links */
    .footer-social-links {
        display: flex;
        flex-direction: column;
        gap: var(--space-3);
    }

    .footer-social-link {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        color: var(--gray-300);
        text-decoration: none;
        transition: all var(--transition);
        padding: var(--space-2) 0;
    }

    .footer-social-link:hover {
        color: white;
        transform: translateX(4px);
    }

    .footer-social-link i {
        width: 20px;
        text-align: center;
        color: var(--accent);
        font-size: 1.1rem;
    }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('ths-logo-horizontal.svg') }}" alt="The Harmony Singers" class="navbar-logo">
            </a>

            <!-- Desktop Navigation -->
            <div class="navbar-nav">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Home
                </a>
                <a href="{{ route('concerts.index') }}"
                    class="nav-link {{ request()->routeIs('concerts.*') ? 'active' : '' }}">
                    Concerts
                </a>
                <a href="{{ route('media.index') }}"
                    class="nav-link {{ request()->routeIs('media.*') ? 'active' : '' }}">
                    Media
                </a>
                <a href="{{ route('contact.index') }}"
                    class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}">
                    Contact
                </a>
                <a href="{{ route('public.member-register') }}"
                    class="nav-link {{ request()->routeIs('public.member-register*') ? 'active' : '' }}">
                    Join Us
                </a>
                @auth
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="nav-link">Logout</button>
                </form>
                @else
                <a href="{{ route('register') }}" class="nav-link">Register</a>
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                @endauth

                <!-- Social Media Links -->
                <div class="social-media-nav">
                    <a href="https://tr.ee/jwyyD_5ueg" target="_blank" rel="noopener noreferrer" class="social-link"
                        title="Linktree">
                        <i class="fas fa-link"></i>
                    </a>
                    <a href="https://www.tiktok.com/@thehamonysingerschoir" target="_blank" rel="noopener noreferrer"
                        class="social-link" title="TikTok">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    <a href="https://www.instagram.com/harmonyfamily_/" target="_blank" rel="noopener noreferrer"
                        class="social-link" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="http://www.youtube.com/@theharmonysingerschoir" target="_blank" rel="noopener noreferrer"
                        class="social-link" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="mobile-menu-button">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div class="mobile-nav" id="mobile-nav">
            <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                Home
            </a>
            <a href="{{ route('concerts.index') }}"
                class="mobile-nav-link {{ request()->routeIs('concerts.*') ? 'active' : '' }}">
                Concerts
            </a>
            <a href="{{ route('media.index') }}"
                class="mobile-nav-link {{ request()->routeIs('media.*') ? 'active' : '' }}">
                Media
            </a>
            <a href="{{ route('contact.index') }}"
                class="mobile-nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}">
                Contact
            </a>
            <a href="{{ route('public.member-register') }}"
                class="mobile-nav-link {{ request()->routeIs('public.member-register*') ? 'active' : '' }}">
                Join Us
            </a>
            @auth
            <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link">
                Dashboard
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="mobile-nav-link">Logout</button>
            </form>
            @else
            <a href="{{ route('register') }}" class="mobile-nav-link">Register</a>
            <a href="{{ route('login') }}" class="mobile-nav-link">Login</a>
            @endauth

            <!-- Mobile Social Media Links -->
            <div class="mobile-social-media">
                <div class="mobile-social-title">Follow Us</div>
                <div class="mobile-social-links">
                    <a href="https://tr.ee/jwyyD_5ueg" target="_blank" rel="noopener noreferrer"
                        class="mobile-social-link" title="Linktree">
                        <i class="fas fa-link"></i>
                        <span>Linktree</span>
                    </a>
                    <a href="https://www.tiktok.com/@thehamonysingerschoir" target="_blank" rel="noopener noreferrer"
                        class="mobile-social-link" title="TikTok">
                        <i class="fab fa-tiktok"></i>
                        <span>TikTok</span>
                    </a>
                    <a href="https://www.instagram.com/harmonyfamily_/" target="_blank" rel="noopener noreferrer"
                        class="mobile-social-link" title="Instagram">
                        <i class="fab fa-instagram"></i>
                        <span>Instagram</span>
                    </a>
                    <a href="http://www.youtube.com/@theharmonysingerschoir" target="_blank" rel="noopener noreferrer"
                        class="mobile-social-link" title="YouTube">
                        <i class="fab fa-youtube"></i>
                        <span>YouTube</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background: var(--gray-900); color: white; padding: var(--space-16) 0;">
        <div class="container">
            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--space-8); margin-bottom: var(--space-8);">
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: var(--space-4); color: white;">
                        The Harmony Singers
                    </h3>
                    <p style="color: var(--gray-300); line-height: 1.6;">
                        Bringing beautiful music to our community through passionate performances and dedication to
                        excellence.
                    </p>
                </div>
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: var(--space-4); color: white;">
                        Quick Links
                    </h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: var(--space-2);">
                            <a href="{{ route('home') }}"
                                style="color: var(--gray-300); text-decoration: none; transition: var(--transition);"
                                onmouseover="this.style.color='white'" onmouseout="this.style.color='var(--gray-300)'">
                                Home
                            </a>
                        </li>
                        <li style="margin-bottom: var(--space-2);">
                            <a href="{{ route('concerts.index') }}"
                                style="color: var(--gray-300); text-decoration: none; transition: var(--transition);"
                                onmouseover="this.style.color='white'" onmouseout="this.style.color='var(--gray-300)'">
                                Concerts
                            </a>
                        </li>
                        <li style="margin-bottom: var(--space-2);">
                            <a href="{{ route('media.index') }}"
                                style="color: var(--gray-300); text-decoration: none; transition: var(--transition);"
                                onmouseover="this.style.color='white'" onmouseout="this.style.color='var(--gray-300)'">
                                Media
                            </a>
                        </li>
                        <li style="margin-bottom: var(--space-2);">
                            <a href="{{ route('contact.index') }}"
                                style="color: var(--gray-300); text-decoration: none; transition: var(--transition);"
                                onmouseover="this.style.color='white'" onmouseout="this.style.color='var(--gray-300)'">
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: var(--space-4); color: white;">
                        Contact Info
                    </h3>
                    <div style="color: var(--gray-300); line-height: 1.8;">
                        <p style="margin-bottom: var(--space-2);">
                            <i class="fas fa-envelope" style="margin-right: var(--space-2); color: var(--accent);"></i>
                            info@harmonysingers.com
                        </p>
                        <p style="margin-bottom: var(--space-2);">
                            <i class="fas fa-phone" style="margin-right: var(--space-2); color: var(--accent);"></i>
                            (250) 791334414
                        </p>
                        <p>
                            <i class="fas fa-users" style="margin-right: var(--space-2); color: var(--accent);"></i>
                            Follow us for updates!
                        </p>
                    </div>
                </div>
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: var(--space-4); color: white;">
                        Follow Us
                    </h3>
                    <div class="footer-social-links">
                        <a href="https://tr.ee/jwyyD_5ueg" target="_blank" rel="noopener noreferrer"
                            class="footer-social-link" title="Linktree">
                            <i class="fas fa-link"></i>
                            <span>Linktree</span>
                        </a>
                        <a href="https://www.tiktok.com/@thehamonysingerschoir" target="_blank"
                            rel="noopener noreferrer" class="footer-social-link" title="TikTok">
                            <i class="fab fa-tiktok"></i>
                            <span>TikTok</span>
                        </a>
                        <a href="https://www.instagram.com/harmonyfamily_/" target="_blank" rel="noopener noreferrer"
                            class="footer-social-link" title="Instagram">
                            <i class="fab fa-instagram"></i>
                            <span>Instagram</span>
                        </a>
                        <a href="http://www.youtube.com/@theharmonysingerschoir" target="_blank"
                            rel="noopener noreferrer" class="footer-social-link" title="YouTube">
                            <i class="fab fa-youtube"></i>
                            <span>YouTube</span>
                        </a>
                    </div>
                </div>
            </div>
            <div style="border-top: 1px solid var(--gray-700); padding-top: var(--space-8); text-align: center;">
                <p style="color: var(--gray-400);">
                    &copy; {{ date('Y') }} The Harmony Singers. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileNav = document.getElementById('mobile-nav');

        if (mobileMenuButton && mobileNav) {
            mobileMenuButton.addEventListener('click', function() {
                mobileNav.classList.toggle('show');
            });
        }
    });
    </script>
</body>

</html>