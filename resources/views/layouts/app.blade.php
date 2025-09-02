<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - The Harmony Singers</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #173478;
            --primary-light: #2563eb;
            --primary-dark: #1e40af;
            --secondary-color: #edeff2;
            --accent-color: #8b5cf6;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        /* Modern Card Styles */
        .modern-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            border: 1px solid rgb(229 231 235);
        }

        .modern-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            border: 1px solid rgb(243 244 246);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-1);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: rgb(107 114 128);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Quick Actions */
        .quick-action {
            border-radius: 12px;
            padding: 1rem 1.5rem;
            font-weight: 600;
            text-align: center;
            transition: all 0.2s ease;
            text-decoration: none;
            display: block;
            box-shadow: var(--shadow-sm);
        }

        .quick-action:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            text-decoration: none;
        }

        .quick-action-primary {
            background: var(--primary-color);
            color: white;
        }

        .quick-action-success {
            background: var(--success-color);
            color: white;
        }

        .quick-action-purple {
            background: var(--accent-color);
            color: white;
        }

        .quick-action-warning {
            background: var(--warning-color);
            color: white;
        }

        .quick-action-gray {
            background: rgb(107 114 128);
            color: white;
        }

        /* Progress Bars */
        .modern-progress {
            height: 8px;
            background: rgb(243 244 246);
            border-radius: 4px;
            overflow: hidden;
        }

        .modern-progress-bar {
            height: 100%;
            background: var(--gradient-1);
            border-radius: 4px;
            transition: width 0.8s ease;
        }

        /* Section Headers */
        .section-header {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            position: relative;
            padding-left: 1rem;
        }

        .section-header::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--gradient-1);
            border-radius: 2px;
        }

        /* Activity Cards */
        .activity-card {
            padding: 1.5rem;
            border-left: 4px solid var(--primary-color);
            background: white;
            border-radius: 0 12px 12px 0;
            margin-bottom: 1rem;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
        }

        .activity-card:hover {
            transform: translateX(4px);
            box-shadow: var(--shadow-md);
        }

        .activity-card.success {
            border-left-color: var(--success-color);
        }

        .activity-card.warning {
            border-left-color: var(--warning-color);
        }

        .activity-card.purple {
            border-left-color: var(--accent-color);
        }

        /* Financial Cards */
        .financial-card {
            text-align: center;
            padding: 1.5rem;
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }

        .financial-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .financial-amount {
            font-size: 1.875rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .financial-amount.success {
            color: var(--success-color);
        }

        .financial-amount.primary {
            color: var(--primary-color);
        }

        .financial-amount.purple {
            color: var(--accent-color);
        }

        .financial-amount.warning {
            color: var(--warning-color);
        }

        /* Legacy support */
        .bg-primary {
            background-color: var(--primary-color);
        }

        .text-primary {
            color: var(--primary-color);
        }

        .border-primary {
            border-color: var(--primary-color);
        }

        .bg-secondary {
            background-color: var(--secondary-color);
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
</body>

</html>