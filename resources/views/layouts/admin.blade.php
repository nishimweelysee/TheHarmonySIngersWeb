<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - The Harmony Singers</title>

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

    <!-- Custom Enhanced Styles -->
    <link rel="stylesheet" href="{{ asset('css/songs-enhanced.css') }}">

    <style>
        /* Admin Layout Design System */
        :root {
            /* Brand Colors */
            --primary: #173478;
            --primary-light: #1e40af;
            --primary-dark: #0f1729;
            --primary-50: #eff6ff;
            --primary-100: #dbeafe;
            --primary-200: #bfdbfe;
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
            --success-light: #d1fae5;
            --success-dark: #065f46;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --warning-dark: #92400e;
            --error: #ef4444;
            --error-light: #fee2e2;
            --error-dark: #991b1b;
            --info: #3b82f6;
            --info-light: #dbeafe;
            --info-dark: #1e40af;
            --accent: #3b82f6;
            --accent-light: #dbeafe;
            --accent-dark: #1e40af;

            /* Typography */
            --font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;

            /* Spacing Scale */
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-5: 1.25rem;
            --space-0: 1.5rem;
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

        /* ===== ENHANCED CARD ANIMATIONS ===== */
        .content-card,
        .overview-card,
        .action-card,
        .stat-card,
        .summary-card,
        .campaign-card,
        .practice-session-card,
        .user-card,
        .notification-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .content-card::before,
        .overview-card::before,
        .action-card::before,
        .stat-card::before,
        .summary-card::before,
        .campaign-card::before,
        .practice-session-card::before,
        .user-card::before,
        .notification-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .content-card:hover::before,
        .overview-card:hover::before,
        .action-card:hover::before,
        .stat-card:hover::before,
        .summary-card:hover::before,
        .campaign-card:hover::before,
        .practice-session-card:hover::before,
        .user-card:hover::before,
        .notification-card:hover::before {
            left: 100%;
        }

        /* ===== COMMON ADMIN PAGE STYLES ===== */
        /* These styles are shared across all admin pages to eliminate duplication */

        /* Page Header - Common across all admin pages */
        .page-header {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            margin-bottom: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-text {
            flex: 1;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-1);
        }

        .header-subtitle {
            color: var(--gray-600);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            flex-shrink: 0;
        }

        /* Content Card - Common across all admin pages */
        .content-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }

        .card-header {
            border-bottom: 1px solid var(--gray-200);
            background: linear-gradient(135deg, var(--white) 0%, var(--gray-50) 100%);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--space-4) var(--space-6);
        }

        .card-header h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .card-content {
            padding: var(--space-0);
        }

        /* Button System - Common across all admin pages */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-3) var(--space-4);
            border-radius: var(--radius);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all var(--transition);
            white-space: nowrap;
            font-family: inherit;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn:active {
            transform: translateY(0) scale(0.98);
        }

        .btn:disabled,
        .btn.disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn:disabled:hover,
        .btn.disabled:hover {
            transform: none !important;
        }

        /* Action Section - Common across all admin pages */
        .action-section {
            margin-top: var(--space-8);
            padding-top: var(--space-8);
            border-top: 1px solid var(--gray-200);
        }

        .action-buttons {
            display: flex;
            gap: var(--space-4);
            justify-content: center;
            flex-wrap: wrap;
        }

        .action-btn {
            min-width: 200px;
            justify-content: center;
        }

        /* Button Variants */
        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-light);
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .btn-secondary:hover {
            background: var(--gray-200);
        }

        .btn-success {
            background: var(--success);
            color: var(--white);
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-warning {
            background: var(--warning);
            color: var(--white);
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-danger {
            background: var(--error);
            color: var(--white);
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-info {
            background: var(--info);
            color: var(--white);
        }

        .btn-info:hover {
            background: #2563eb;
        }

        .btn-outline {
            background: transparent;
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
        }

        .btn-outline:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
        }

        /* Button Sizes */
        .btn-sm {
            padding: var(--space-2) var(--space-3);
            font-size: 0.75rem;
            min-width: 32px;
            height: 32px;
            justify-content: center;
        }

        .btn-lg {
            padding: var(--space-4) var(--space-8);
            font-size: 1rem;
            border-radius: var(--radius-lg);
        }

        .btn-xl {
            padding: var(--space-5) var(--space-10);
            font-size: 1.125rem;
            border-radius: var(--radius-lg);
        }

        .btn-full {
            width: 100%;
            justify-content: center;
            font-size: 0.875rem;
            padding: var(--space-3) var(--space-4);
        }

        .btn i {
            font-size: 0.875rem;
        }

        .btn-sm i {
            font-size: 0.75rem;
        }

        /* Status Banner */
        .status-banner {
            padding: var(--space-4);
            margin-bottom: var(--space-0);
            border-radius: var(--radius-lg);
            border-left: 4px solid;
        }

        .status-banner-scheduled {
            background: var(--primary);
            border-left-color: var(--primary-dark);
            color: var(--white);
        }

        .status-banner-in_progress {
            background: var(--warning-light);
            border-left-color: var(--warning);
            color: var(--warning-dark);
        }

        .status-banner-completed {
            background: var(--success-light);
            border-left-color: var(--success);
            color: var(--success-dark);
        }

        .status-banner-cancelled {
            background: var(--error-light);
            border-left-color: var(--error);
            color: var(--error-dark);
        }

        .banner-content {
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .banner-text {
            font-size: 1.1rem;
        }

        /* Enhanced Info Display */
        .date-display,
        .time-display,
        .duration-badge {
            font-weight: 500;
            color: var(--primary);
        }

        .info-section {
            margin-top: var(--space-0);
            padding-top: var(--space-0);
            border-top: 1px solid var(--gray-200);
        }

        .info-section h4 {
            color: var(--gray-800);
            margin-bottom: var(--space-3);
            font-size: 1.1rem;
        }

        .description-content,
        .notes-content {
            background: var(--gray-50);
            padding: var(--space-4);
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
            line-height: 1.6;
            color: var(--gray-700);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-0);
            margin-bottom: var(--space-4);
        }

        .info-item {
            background: var(--gray-50);
            padding: var(--space-4);
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
        }

        .info-item h4 {
            color: var(--gray-800);
            margin-bottom: var(--space-3);
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .info-item h4 i {
            color: var(--primary);
            font-size: 1rem;
        }

        .info-content p {
            margin-bottom: var(--space-2);
            display: flex;
            align-items: flex-start;
            gap: var(--space-2);
        }

        .info-content p:last-child {
            margin-bottom: 0;
        }

        .info-content strong {
            color: var(--gray-700);
            min-width: 80px;
            flex-shrink: 0;
        }

        .duration-badge {
            background: var(--primary-light);
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            font-size: 0.875rem;
        }

        /* Statistics Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-4);
            margin-bottom: var(--space-0);
        }

        .stat-card {
            display: flex;
            align-items: center;
            padding: var(--space-4);
            border-radius: var(--radius-lg);
            background: var(--white);
            border: 1px solid var(--gray-200);
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card-present {
            border-left: 4px solid var(--success);
        }

        .stat-card-late {
            border-left: 4px solid var(--warning);
        }

        .stat-card-absent {
            border-left: 4px solid var(--error);
        }

        .stat-card-excused {
            border-left: 4px solid var(--primary);
        }

        .stat-icon {
            font-size: 2rem;
            margin-right: var(--space-4);
            opacity: 0.7;
        }

        .stat-card-present .stat-icon {
            color: var(--success);
        }

        .stat-card-late .stat-icon {
            color: var(--warning);
        }

        .stat-card-absent .stat-icon {
            color: var(--error);
        }

        .stat-card-excused .stat-icon {
            color: var(--primary);
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: var(--space-1);
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Small Stat Cards */
        .stats-grid-small {
            grid-template-columns: repeat(4, 1fr);
            gap: var(--space-2);
        }

        .stat-card-small {
            padding: var(--space-2);
            min-height: 60px;
        }

        .stat-card-small .stat-icon {
            font-size: 1rem;
            margin-right: var(--space-2);
        }

        .stat-card-small .stat-number {
            font-size: 1rem;
            margin-bottom: var(--space-1);
        }

        .stat-card-small .stat-label {
            font-size: 0.625rem;
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: var(--space-2);
            flex-wrap: wrap;
            align-items: center;
        }

        .quick-actions .btn {
            margin: 0;
            white-space: nowrap;
        }

        .card-header .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        /* Responsive quick actions */
        @media (max-width: 768px) {
            .quick-actions {
                flex-direction: column;
                gap: var(--space-1);
            }

            .quick-actions .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Hidden utility class */
        .hidden {
            display: none !important;
        }

        /* Toast Notification System */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
            padding: var(--space-4);
            min-width: 300px;
            max-width: 400px;
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }

        .toast-content {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            flex: 1;
        }

        .toast-content i {
            font-size: 1.125rem;
        }

        .toast-close {
            background: none;
            border: none;
            color: var(--gray-400);
            cursor: pointer;
            padding: var(--space-1);
            border-radius: var(--radius);
            transition: all var(--transition);
        }

        .toast-close:hover {
            color: var(--gray-600);
            background: var(--gray-100);
        }

        .toast-success {
            border-left: 4px solid var(--success);
        }

        .toast-success i {
            color: var(--success);
        }

        .toast-error {
            border-left: 4px solid var(--error);
        }

        .toast-error i {
            color: var(--error);
        }

        .toast-warning {
            border-left: 4px solid var(--warning);
        }

        .toast-warning i {
            color: var(--warning);
        }

        .toast-info {
            border-left: 4px solid var(--info);
        }

        .toast-info i {
            color: var(--info);
        }

        /* Attendance Progress */
        .attendance-progress {
            background: var(--gray-50);
            padding: var(--space-0);
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-4);
        }

        .progress-header h4 {
            margin: 0;
            color: var(--gray-800);
        }

        .progress-percentage {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
        }

        .progress-bar {
            height: 12px;
            background: var(--gray-200);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin-bottom: var(--space-4);
        }



        .progress-stats {
            display: flex;
            justify-content: space-between;
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        /* Member Summary */
        .member-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: var(--space-4);
        }

        .summary-item {
            text-align: center;
            padding: var(--space-3);
            background: var(--gray-50);
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
        }

        .summary-number {
            display: block;
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: var(--space-1);
        }

        .summary-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Attendance Preview */
        .preview-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: var(--space-4);
        }

        .preview-item {
            text-align: center;
            padding: var(--space-3);
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
        }

        .preview-present {
            background: var(--success-light);
            border-color: var(--success);
        }

        /* Enhanced Contribution Campaign Styling */
        .campaigns-grid.enhanced-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: var(--space-4);
            margin-top: var(--space-4);
        }

        .campaign-card.enhanced-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow);
            transition: all var(--transition);
            overflow: hidden;
            position: relative;
        }

        .campaign-card.enhanced-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary-light);
        }

        .campaign-card.enhanced-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        .campaign-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: var(--space-4);
            border-bottom: 1px solid var(--gray-100);
        }

        .type-badge.enhanced-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .type-badge.type-monthly {
            background: var(--info-light);
            color: var(--info);
            border: 1px solid var(--info);
        }

        .type-badge.type-project {
            background: var(--warning-light);
            color: var(--warning);
            border: 1px solid var(--warning);
        }

        .type-badge.type-event {
            background: var(--success-light);
            color: var(--success);
            border: 1px solid var(--success);
        }

        .type-badge.type-special {
            background: var(--accent-light);
            color: var(--accent);
            border: 1px solid var(--accent);
        }

        .status-badge.enhanced-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-badge.status-active {
            background: var(--success-light);
            color: var(--success);
            border: 1px solid var(--success);
        }

        .status-badge.status-completed {
            background: var(--info-light);
            color: var(--info);
            border: 1px solid var(--info);
        }

        .status-badge.status-cancelled {
            background: var(--error-light);
            color: var(--error);
            border: 1px solid var(--error);
        }

        .campaign-body {
            padding: var(--space-4);
        }

        .campaign-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 var(--space-3) 0;
            line-height: 1.3;
        }

        .campaign-description {
            color: var(--gray-600);
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: var(--space-3);
        }



        .campaign-dates {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--space-3);
            margin-bottom: var(--space-4);
        }

        .date-item {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .date-label {
            font-size: 0.75rem;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .date-value {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
        }

        .progress-section {
            margin-bottom: var(--space-4);
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-3);
        }

        .progress-label {
            font-size: 0.875rem;
            color: var(--gray-600);
            font-weight: 500;
        }

        .progress-percentage {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--primary);
        }

        .progress-bar.enhanced-progress {
            height: 8px;
            background: var(--gray-200);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin-bottom: var(--space-3);
        }



        .progress-amounts {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: var(--gray-600);
        }

        .raised-amount {
            color: var(--success);
            font-weight: 600;
        }

        .target-amount {
            color: var(--gray-500);
        }

        .campaign-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--space-3);
            margin-bottom: var(--space-4);
        }

        .campaign-stats .stat-item {
            text-align: center;
            padding: var(--space-3);
            background: var(--gray-50);
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
        }

        .campaign-stats .stat-label {
            font-size: 0.75rem;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: var(--space-1);
        }

        .campaign-stats .stat-value {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
        }

        .campaign-actions {
            display: flex;
            gap: var(--space-2);
            padding: var(--space-4);
            border-top: 1px solid var(--gray-100);
            background: var(--gray-50);
        }

        .campaign-actions .enhanced-btn {
            flex: 1;
            justify-content: center;
        }

        /* Enhanced Form Styling for Contribution Campaigns */
        .enhanced-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-6);
            margin-bottom: var(--space-6);
        }

        .enhanced-form-group {
            margin-bottom: var(--space-4);
        }

        .enhanced-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: var(--space-2);
        }

        .enhanced-input,
        .enhanced-select,
        .enhanced-textarea {
            width: 100%;
            padding: var(--space-3);
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            font-size: 0.875rem;
            transition: all var(--transition);
            background: var(--white);
        }

        .enhanced-input:focus,
        .enhanced-select:focus,
        .enhanced-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .enhanced-input-group {
            display: flex;
            align-items: center;
            position: relative;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-xl);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .enhanced-input-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        .enhanced-input-group:hover {
            border-color: var(--gray-300);
        }

        .enhanced-input-group .enhanced-input {
            border: none;
            border-radius: 0;
            flex: 1;
            box-shadow: none;
            transform: none;
        }

        .enhanced-input-group .enhanced-input:focus {
            box-shadow: none;
            transform: none;
        }

        .enhanced-input-group .input-prefix {
            padding: var(--space-3) var(--space-4);
            background: var(--gray-50);
            color: var(--gray-600);
            font-weight: 600;
            border-right: 1px solid var(--gray-200);
            font-size: 1rem;
        }

        .enhanced-help {
            display: block;
            font-size: 0.75rem;
            color: var(--gray-500);
            margin-top: var(--space-1);
            line-height: 1.4;
        }

        .enhanced-error {
            display: block;
            font-size: 0.75rem;
            color: var(--error);
            margin-top: var(--space-1);
        }

        .enhanced-form-actions {
            display: flex;
            gap: var(--space-4);
            justify-content: flex-start;
            align-items: center;
            padding-top: var(--space-6);
            border-top: 1px solid var(--gray-200);
        }

        .enhanced-alert {
            display: flex;
            align-items: flex-start;
            gap: var(--space-3);
            padding: var(--space-4);
            border-radius: var(--radius);
            margin-bottom: var(--space-6);
            border: 1px solid transparent;
        }

        .enhanced-alert.alert-success {
            background: var(--success-light);
            color: var(--success-dark);
            border-color: var(--success);
        }

        .enhanced-alert.alert-danger {
            background: var(--error-light);
            color: var(--error-dark);
            border-color: var(--error);
        }

        .enhanced-alert i {
            font-size: 1.125rem;
            margin-top: 2px;
        }

        .preview-late {
            background: var(--warning-light);
            border-color: var(--warning);
        }

        .preview-absent {
            background: var(--error-light);
            border-color: var(--error);
        }

        .preview-excused {
            background: var(--primary-light);
            border-color: var(--primary);
        }

        .preview-count {
            display: block;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: var(--space-1);
        }

        .preview-present .preview-count {
            color: var(--success);
        }

        .preview-late .preview-count {
            color: var(--warning);
        }

        .preview-absent .preview-count {
            color: var(--error);
        }

        .preview-excused .preview-count {
            color: var(--primary);
        }

        .preview-label {
            font-size: 0.75rem;
            color: var(--gray-700);
            font-weight: 500;
        }

        /* Enhanced Table Rows */
        .attendance-row.member-present {
            background: var(--success-light);
        }

        .attendance-row.member-late {
            background: var(--warning-light);
        }

        .attendance-row.member-absent {
            background: var(--error-light);
        }

        .attendance-row.member-excused {
            background: var(--primary-light);
        }

        .member-row.member-present {
            background: var(--success-light);
        }

        .member-row.member-late {
            background: var(--warning-light);
        }

        .member-row.member-absent {
            background: var(--error-light);
        }

        .member-row.member-excused {
            background: var(--primary-light);
        }

        /* Enhanced member row status styling */
        .member-row.member-present {
            background: rgba(16, 185, 129, 0.05);
            border-left: 4px solid var(--success);
        }

        .member-row.member-absent {
            background: rgba(239, 68, 68, 0.05);
            border-left: 4px solid var(--error);
        }

        .member-row.member-late {
            background: rgba(245, 158, 11, 0.05);
            border-left: 4px solid var(--warning);
        }

        .member-row.member-excused {
            background: rgba(59, 130, 246, 0.05);
            border-left: 4px solid var(--primary);
        }

        /* Enhanced checkbox styling */
        .checkbox-cell {
            width: 40px;
            text-align: center;
        }

        .member-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        /* Enhanced quick actions */
        .quick-actions {
            display: flex;
            gap: var(--space-2);
            flex-wrap: wrap;
            align-items: center;
        }

        .quick-actions .btn {
            font-size: 0.875rem;
            padding: var(--space-2) var(--space-3);
        }

        /* Enhanced Bulk Edit Panel */
        .bulk-edit-panel {
            background: var(--white);
            border: 2px solid var(--primary);
            border-radius: var(--radius-xl);
            padding: var(--space-5);
            margin-bottom: var(--space-0);
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .bulk-edit-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        .bulk-edit-panel.hidden {
            display: none !important;
        }

        .bulk-edit-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-4);
        }

        .bulk-edit-header h4 {
            margin: 0;
            color: var(--gray-800);
        }

        .bulk-edit-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-4);
            margin-bottom: var(--space-4);
        }

        .bulk-edit-actions {
            display: flex;
            gap: var(--space-3);
            flex-wrap: wrap;
            align-items: center;
            justify-content: flex-start;
        }

        .bulk-edit-actions .btn {
            flex-shrink: 0;
        }

        /* Enhanced Member Info */
        .member-phone {
            font-size: 0.625rem;
        }

        .reason-text,
        .notes-text {
            color: var(--gray-700);
            font-weight: 500;
        }

        .arrival-time {
            font-weight: 500;
        }

        /* Enhanced Voice Badges */
        .voice-badge {
            display: inline-flex;
            align-items: center;
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .voice-badge i {
            margin-right: var(--space-1);
            font-size: 0.625rem;
        }

        /* Search and Filter System - Common across all admin pages */
        .filters {
            display: flex;
            gap: var(--space-4);
            align-items: center;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .search-input {
            width: 100%;
            padding: var(--space-3) var(--space-4);
            padding-left: 4.25rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-lg);
            font-size: 0.875rem;
            transition: all var(--transition);
            background: var(--white);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(23, 52, 120, 0.1);
        }

        .search-input::placeholder {
            color: var(--gray-400);
        }

        /* Enhanced Search Input Styles - Specific for filter sections */
        .search-input.enhanced-input {
            width: 100% !important;
            padding: var(--space-3) var(--space-3) var(--space-3) var(--space-10) !important;
            border: 2px solid var(--gray-300) !important;
            border-radius: var(--radius-lg) !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            color: var(--gray-700) !important;
            background: var(--white) !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;
        }

        .search-input.enhanced-input:focus {
            outline: none !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 4px rgba(23, 52, 120, 0.1), 0 4px 12px rgba(0, 0, 0, 0.1) !important;
            transform: translateY(-1px) !important;
        }

        .search-input.enhanced-input:hover {
            border-color: var(--gray-400) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        }

        .search-input.enhanced-input::placeholder {
            color: var(--gray-400) !important;
            font-weight: 400 !important;
        }

        .search-input.enhanced-input:focus::placeholder {
            color: var(--gray-500) !important;
        }

        /* Enhanced Search Box Container */
        .search-box.enhanced-search {
            position: relative !important;
            width: 100% !important;
            max-width: 500px !important;
        }

        .search-box.enhanced-search .search-icon {
            position: absolute !important;
            left: var(--space-3) !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: var(--gray-400) !important;
            z-index: 2 !important;
            transition: color 0.3s ease !important;
            font-size: 0.875rem !important;
        }

        .search-box.enhanced-search:focus-within .search-icon {
            color: var(--primary) !important;
        }

        .search-glow {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            border-radius: var(--radius-lg) !important;
            background: linear-gradient(135deg, var(--primary-light), var(--primary)) !important;
            opacity: 0 !important;
            transition: opacity 0.3s ease !important;
            z-index: -1 !important;
        }

        .search-input.enhanced-input:focus+.search-glow {
            opacity: 0.1 !important;
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: 0.875rem;
            pointer-events: none;
        }

        .filter-group {
            display: flex;
            gap: var(--space-3);
        }

        .filter-select {
            padding: var(--space-3) var(--space-4);
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-lg);
            font-size: 0.875rem;
            transition: all var(--transition);
            background: var(--white);
            min-width: 150px;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(23, 52, 120, 0.1);
        }

        /* Table System - Common across all admin pages */
        .table-container {
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: var(--gray-300) var(--gray-100);
        }

        /* General Responsive Layout - Prevent Horizontal Scroll on All Pages */
        .main-content {
            overflow-x: hidden;
            max-width: 100%;
            box-sizing: border-box;
        }

        /* Prevent body and html from horizontal scrolling */
        body,
        html {
            overflow-x: hidden;
            max-width: 100vw;
        }

        /* General page container */
        .page-container {
            overflow-x: hidden;
            max-width: 100vw;
            width: 100%;
            box-sizing: border-box;
        }

        /* Practice Session Page - Specific overrides */
        .practice-session-page {
            overflow-x: hidden;
            max-width: 100vw;
            width: 100%;
            box-sizing: border-box;
        }

        /* General Responsive Elements for All Pages */
        .page-header {
            max-width: 100%;
            overflow-x: hidden;
            box-sizing: border-box;
        }

        .header-actions {
            flex-wrap: wrap;
            gap: var(--space-2);
        }

        .header-actions .btn {
            flex-shrink: 1;
            min-width: auto;
        }

        .content-card {
            max-width: 100%;
            overflow-x: hidden;
            box-sizing: border-box;
        }

        .card-content {
            max-width: 100%;
            overflow-x: hidden;
            box-sizing: border-box;
        }

        /* Export actions responsive */
        .export-actions {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-2);
            max-width: 100%;
        }

        .export-actions .btn {
            flex-shrink: 1;
            min-width: auto;
        }

        /* Make page header responsive */
        .practice-session-page .page-header {
            max-width: 100%;
            overflow-x: hidden;
        }

        .practice-session-page .header-actions {
            flex-wrap: wrap;
            gap: var(--space-2);
        }

        .practice-session-page .header-actions .btn {
            flex-shrink: 1;
            min-width: auto;
        }

        /* Make content cards responsive */
        .practice-session-page .content-card {
            max-width: 100%;
            overflow-x: hidden;
        }

        .practice-session-page .card-content {
            max-width: 100%;
            overflow-x: hidden;
        }

        .practice-session-page .table-container {
            overflow-x: auto;
            overflow-y: visible;
            max-width: 100%;
            width: 100%;
            box-sizing: border-box;
        }

        .practice-session-page .data-table {
            min-width: 800px;
            width: 100%;
            table-layout: fixed;
        }

        /* Responsive table columns for practice sessions */
        .practice-session-page .th-member,
        .practice-session-page .td-member {
            min-width: 150px;
            max-width: 200px;
        }

        .practice-session-page .th-voice,
        .practice-session-page .td-voice {
            min-width: 100px;
            max-width: 120px;
        }

        .practice-session-page .th-status,
        .practice-session-page .td-status {
            min-width: 80px;
            max-width: 100px;
        }

        .practice-session-page .th-reason,
        .practice-session-page .td-reason {
            min-width: 120px;
            max-width: 150px;
        }

        .practice-session-page .th-notes,
        .practice-session-page .td-notes {
            min-width: 150px;
            max-width: 200px;
        }

        .practice-session-page .th-arrival,
        .practice-session-page .td-arrival {
            min-width: 120px;
            max-width: 140px;
        }

        .practice-session-page .th-updated,
        .practice-session-page .td-updated {
            min-width: 100px;
            max-width: 120px;
        }

        /* Additional overflow prevention */
        .practice-session-page .content-card,
        .practice-session-page .page-header,
        .practice-session-page .card-content {
            overflow-x: hidden;
            max-width: 100%;
            box-sizing: border-box;
        }

        /* General Responsive Grid Systems */
        .info-grid,
        .cards-grid,
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-4);
            max-width: 100%;
        }

        .info-card,
        .stat-card,
        .content-card {
            min-width: 0;
            overflow-x: hidden;
            box-sizing: border-box;
        }

        /* Make session info cards responsive */
        .practice-session-page .session-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-4);
            max-width: 100%;
        }

        .practice-session-page .info-card {
            min-width: 0;
            overflow-x: hidden;
        }

        /* General Responsive Breakpoints */
        @media (max-width: 1200px) {
            .header-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .header-actions .btn {
                width: 100%;
                justify-content: center;
                margin-bottom: var(--space-2);
            }

            .export-actions {
                flex-direction: row;
                justify-content: center;
                flex-wrap: wrap;
            }

            .export-actions .btn {
                flex: 1;
                min-width: 80px;
                margin: var(--space-1);
            }
        }

        @media (max-width: 1024px) {

            .info-grid,
            .cards-grid,
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .practice-session-page .session-info-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Make stats grid responsive */
        .practice-session-page .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-4);
            max-width: 100%;
        }

        .practice-session-page .stat-card {
            min-width: 0;
            overflow-x: hidden;
        }

        /* General Mobile Responsive Styles */
        @media (max-width: 768px) {
            .page-header {
                padding: var(--space-4);
                margin: 0;
            }

            .content-card {
                margin: 0;
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .table-container {
                margin: 0 -1rem;
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: var(--space-3);
            }

            .practice-session-page .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: var(--space-3);
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .practice-session-page .stats-grid {
                grid-template-columns: 1fr;
            }

            .header-actions .btn {
                font-size: 0.875rem;
                padding: var(--space-2) var(--space-3);
            }

            .export-actions .btn {
                font-size: 0.875rem;
                padding: var(--space-2) var(--space-3);
            }
        }

        /* Responsive header actions */
        @media (max-width: 1200px) {
            .practice-session-page .header-actions {
                flex-direction: column;
                align-items: stretch;
                width: 100%;
            }

            .practice-session-page .header-actions .btn {
                width: 100%;
                justify-content: center;
                margin-bottom: var(--space-2);
            }

            .practice-session-page .export-actions {
                flex-direction: row;
                justify-content: center;
                flex-wrap: wrap;
            }

            .practice-session-page .export-actions .btn {
                flex: 1;
                min-width: 80px;
                margin: var(--space-1);
            }
        }

        /* Mobile responsive for practice session page */
        @media (max-width: 768px) {
            .practice-session-page {
                padding: 0;
                margin: 0;
            }

            .practice-session-page .page-header {
                margin: 0;
                border-radius: 0;
            }

            .practice-session-page .content-card {
                margin: 0;
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .practice-session-page .table-container {
                margin: 0 -1rem;
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .practice-session-page .data-table {
                min-width: 700px;
            }

            /* Stack table columns on very small screens */
            .practice-session-page .th-reason,
            .practice-session-page .td-reason,
            .practice-session-page .th-notes,
            .practice-session-page .td-notes {
                min-width: 100px;
                max-width: 120px;
            }
        }

        @media (max-width: 480px) {
            .practice-session-page .data-table {
                min-width: 600px;
            }

            .practice-session-page .th-member,
            .practice-session-page .td-member {
                min-width: 120px;
                max-width: 150px;
            }

            .practice-session-page .th-voice,
            .practice-session-page .td-voice {
                min-width: 80px;
                max-width: 100px;
            }

            .practice-session-page .th-status,
            .practice-session-page .td-status {
                min-width: 60px;
                max-width: 80px;
            }
        }

        .table-container::-webkit-scrollbar {
            height: 8px;
        }

        .table-container::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }

        .data-table {
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: var(--space-4);
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .data-table th {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            font-weight: 700;
            color: var(--gray-700);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: var(--space-5) var(--space-4);
            border-bottom: 2px solid var(--gray-200);
            position: relative;
        }

        .data-table th::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            transform: scaleX(0);
            transition: transform var(--transition);
        }

        .data-table th:hover::after {
            transform: scaleX(1);
        }

        .data-table tbody tr {
            transition: all var(--transition);
            position: relative;
        }

        .data-table tr:hover {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            transform: scale(1.01);
            box-shadow: var(--shadow-xl);
            z-index: 1;
        }

        .data-table tbody tr:hover td {
            color: var(--white);
        }

        .data-table tbody tr:hover .status-badge,
        .data-table tbody tr:hover .type-badge,
        .data-table tbody tr:hover .voice-badge {
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
        }

        /* Status Badge System - Common across all admin pages */
        .status-badge,
        .type-badge,
        .voice-badge {
            position: relative;
            overflow: hidden;
            transition: all var(--transition);
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .status-badge::before,
        .type-badge::before,
        .voice-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .status-badge:hover::before,
        .type-badge:hover::before,
        .voice-badge:hover::before {
            left: 100%;
        }

        .status-badge {
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .type-badge {
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .voice-badge {
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .status-active,
        .status-upcoming,
        .status-scheduled {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .status-inactive,
        .status-completed,
        .status-past {
            background: rgba(107, 114, 128, 0.1);
            color: var(--gray-600);
        }

        .status-cancelled,
        .status-absent {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }

        .status-ongoing,
        .status-in_progress,
        .status-late {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .status-pending,
        .status-excused {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
        }

        /* Type Badge System - Common across all admin pages */
        .type-badge {
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .type-singer,
        .type-admin {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
        }

        .type-general,
        .type-moderator {
            background: rgba(107, 114, 128, 0.1);
            color: var(--gray-600);
        }

        .type-user {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        /* Voice Part Badge System */
        .voice-badge {
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .voice-soprano {
            background: rgba(236, 72, 153, 0.1);
            color: #ec4899;
        }

        .voice-alto {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .voice-tenor {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .voice-bass {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
        }

        /* Action Buttons - Common across all admin pages */
        .action-buttons {
            display: flex;
            gap: var(--space-2);
            flex-wrap: wrap;
            align-items: center;
        }

        /* Empty State - Common across all admin pages */
        .empty-state {
            text-align: center;
            padding: var(--space-16);
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
            border-radius: var(--radius-2xl);
            border: 2px dashed var(--gray-200);
            position: relative;
            overflow: hidden;
        }

        .empty-state::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(59, 130, 246, 0.05) 50%, transparent 70%);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: 50%;
            border: 3px solid var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto var(--space-0);
            font-size: 2rem;
            color: var(--white);
            box-shadow: var(--shadow-xl);
            position: relative;
            z-index: 1;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-3);
            position: relative;
            z-index: 1;
        }

        .empty-state p {
            color: var(--gray-600);
            margin-bottom: var(--space-0);
            font-size: 1rem;
            position: relative;
            z-index: 1;
        }

        /* Pagination - Common across all admin pages */
        .pagination-wrapper {
            margin-top: var(--space-8);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pagination-wrapper nav {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }

        .pagination-wrapper .pagination {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pagination-wrapper .page-item {
            border-right: 1px solid var(--gray-200);
        }

        .pagination-wrapper .page-item:last-child {
            border-right: none;
        }

        .pagination-wrapper .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            height: 44px;
            padding: var(--space-3) var(--space-4);
            color: var(--gray-700);
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition);
            background: var(--white);
        }

        .pagination-wrapper .page-link:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-1px);
        }

        .pagination-wrapper .page-item.active .page-link {
            background: var(--primary);
            color: var(--white);
            font-weight: 700;
        }

        .pagination-wrapper .page-item.disabled .page-link {
            color: var(--gray-400);
            cursor: not-allowed;
            background: var(--gray-50);
        }

        /* Form Elements - Common across all admin pages */
        .form-group {
            position: relative;
            margin-bottom: var(--space-0);
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: var(--space-2);
            transition: color var(--transition);
        }

        .form-group:focus-within .form-label {
            color: var(--primary);
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: var(--space-4) var(--space-4);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            font-size: 0.875rem;
            transition: all var(--transition);
            background: var(--white);
            position: relative;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(23, 52, 120, 0.1);
            transform: translateY(-1px);
        }

        .form-input:hover,
        .form-textarea:hover,
        .form-select:hover {
            border-color: var(--gray-300);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
            line-height: 1.6;
        }

        .form-error {
            color: var(--error);
            font-size: 0.875rem;
            margin-top: var(--space-2);
            display: flex;
            align-items: center;
            gap: var(--space-2);
            animation: slideInError 0.3s ease;
        }

        .form-error::before {
            content: '⚠';
            font-size: 1rem;
        }

        @keyframes slideInError {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Info and Alert Boxes - Common across all admin pages */
        .info-box,
        .warning-box,
        .alert {
            padding: var(--space-4) var(--space-0);
            border-radius: var(--radius-xl);
            margin-bottom: var(--space-0);
            border: 2px solid;
            display: flex;
            align-items: center;
            gap: var(--space-3);
            font-weight: 500;
            position: relative;
            overflow: hidden;
            animation: slideInAlert 0.5s ease;
        }

        @keyframes slideInAlert {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .info-box::before,
        .warning-box::before,
        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 2s infinite;
        }

        .info-box {
            background: rgba(59, 130, 246, 0.1);
            border-color: var(--info);
            color: var(--info);
        }

        .info-box h4 {
            color: var(--info);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: var(--space-2);
        }

        .info-box p {
            color: var(--gray-700);
            font-size: 0.875rem;
            margin: 0;
        }

        .warning-box {
            background: rgba(245, 158, 11, 0.1);
            border-color: var(--warning);
            color: var(--warning);
        }

        .warning-box h4 {
            color: var(--warning);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: var(--space-2);
        }

        .warning-box p {
            color: var(--gray-700);
            font-size: 0.875rem;
            margin: 0;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border-color: var(--success);
            color: var(--success);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border-color: var(--error);
            color: var(--error);
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            border-color: var(--warning);
            color: var(--warning);
        }

        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            border-color: var(--info);
            color: var(--info);
        }

        /* Responsive Design - Common across all admin pages */
        @media (max-width: 1024px) {
            .page-header {
                padding: var(--space-4);
            }

            .header-content {
                flex-direction: column;
                align-items: stretch;
                gap: var(--space-4);
            }

            .page-header .header-actions {
                justify-content: center;
            }

            .content-card {
                margin: 0 var(--space-2);
            }

            .card-header {
                flex-direction: column;
                gap: var(--space-4);
                align-items: stretch;
            }

            .filters {
                flex-direction: column;
                gap: var(--space-3);
            }

            .search-input,
            .filter-select {
                width: 100%;
            }

            .search-box {
                max-width: none;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                padding: var(--space-3);
                margin-bottom: var(--space-4);
            }

            .header-title {
                font-size: 1.25rem;
            }

            .header-subtitle {
                font-size: 0.875rem;
            }

            .content-card {
                margin: 0;
                border-radius: var(--radius-lg);
            }

            .card-header {
                padding: var(--space-2);
            }

            .card-header h3 {
                font-size: 1rem;
            }

            .card-content {
                padding: var(--space-4);
            }

            /* Mobile Table Styles */
            .table-container {
                overflow-x: auto;
                overflow-y: visible;
            }

            .data-table {
                display: block;
            }

            .data-table thead {
                display: none;
            }

            .data-table tbody {
                display: block;
            }

            .data-table tr {
                display: block;
                padding: var(--space-3);
                margin-bottom: var(--space-2);
                border: 1px solid var(--gray-200);
                border-radius: var(--radius);
                background: var(--white);
            }

            .data-table td {
                display: block;
                padding: var(--space-1) 0;
                border: none;
                text-align: left;
            }

            .data-table td::before {
                content: none;
            }

            .action-buttons {
                flex-direction: column;
                gap: var(--space-2);
            }

            .btn-sm {
                width: 100%;
                justify-content: center;
                padding: var(--space-3);
            }

            .filters {
                gap: var(--space-2);
            }

            .search-input,
            .filter-select {
                padding: var(--space-2);
                font-size: 0.875rem;
            }

            .empty-state {
                padding: var(--space-8);
            }

            .empty-state h3 {
                font-size: 1.125rem;
            }

            .empty-state p {
                font-size: 0.875rem;
            }

            /* Enhanced responsive improvements for all components */
            .summary-cards {
                grid-template-columns: 1fr;
            }

            .permission-grid {
                grid-template-columns: 1fr;
            }

            .session-details,
            .campaign-details {
                grid-template-columns: 1fr;
            }

            .campaign-header,
            .session-header,
            .user-header {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--space-3);
            }

            .card-icon {
                width: 48px;
                height: 48px;
                font-size: 1.25rem;
            }

            .card-value {
                font-size: 1.5rem;
            }

            .empty-icon {
                width: 64px;
                height: 64px;
                font-size: 1.5rem;
            }

            .empty-state h3 {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 480px) {

            .summary-card,
            .campaign-card,
            .practice-session-card,
            .user-card,
            .notification-card {
                padding: var(--space-4);
            }

            .card-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .card-value {
                font-size: 1.25rem;
            }

            .empty-state {
                padding: var(--space-8);
            }

            .empty-icon {
                width: 56px;
                height: 56px;
                font-size: 1.25rem;
            }

            /* Enhanced responsive improvements for new components */
            .permission-module {
                margin-bottom: var(--space-4);
            }

            .module-header {
                padding: var(--space-4);
            }

            .module-content {
                padding: var(--space-4);
            }

            .chart-container {
                padding: var(--space-4);
            }

            .chart-header {
                flex-direction: column;
                gap: var(--space-3);
                align-items: flex-start;
            }

            .chart-legend {
                justify-content: flex-start;
            }
        }

        @media (max-width: 480px) {
            .page-header {
                padding: var(--space-3);
            }

            .header-title {
                font-size: 1.125rem;
            }

            .content-card {
                border-radius: var(--radius);
            }

            .card-header {
                padding: var(--space-2);
            }

            .card-content {
                padding: var(--space-3);
            }
        }

        /* Print Styles - Common across all admin pages */
        @media print {

            .page-header,
            .filters,
            .action-buttons {
                display: none;
            }

            .data-table {
                display: table;
            }

            .data-table thead {
                display: table-header-group;
            }

            .data-table tbody {
                display: table-row-group;
            }

            .data-table tr {
                display: table-row;
            }

            .data-table td {
                display: table-cell;
            }

            /* Enhanced print styles for all components */
            .content-card,
            .overview-card,
            .action-card,
            .stat-card,
            .summary-card,
            .campaign-card,
            .practice-session-card,
            .user-card,
            .notification-card {
                break-inside: avoid;
                box-shadow: none;
                border: 1px solid var(--gray-300);
            }

            .btn,
            .action-buttons {
                display: none;
            }

            .data-table {
                border: 1px solid var(--gray-300);
            }

            .data-table th,
            .data-table td {
                border: 1px solid var(--gray-300);
            }
        }

        /* ===== EXISTING ADMIN LAYOUT STYLES ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--gray-50);
            color: var(--gray-700);
        }

        /* Admin Layout */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background: var(--white);
            border-right: 1px solid var(--gray-200);
            box-shadow: var(--shadow-lg);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 50;
            transition: transform var(--transition-slow);
        }

        .sidebar-header {
            padding: var(--space-2);
            border-bottom: 1px solid var(--gray-200);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%, rgba(255, 255, 255, 0.05) 100%);
            pointer-events: none;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 1.5rem;
            font-weight: 800;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .sidebar-logo-horizontal,
        .sidebar-logo-circular {
            height: 50px;
            flex-shrink: 0;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
            transition: all var(--transition);
        }

        .sidebar-logo-horizontal {
            width: auto;
            display: block;
        }

        .sidebar-logo-circular {
            width: 50px;
            display: none;
        }

        .sidebar-logo:hover .sidebar-logo-horizontal,
        .sidebar-logo:hover .sidebar-logo-circular {
            transform: scale(1.05);
        }

        .sidebar-logo-text {
            flex: 1;
            transition: all 0.3s ease;
        }

        .sidebar-logo-title {
            font-size: 1.25rem;
            font-weight: 800;
            line-height: 1.2;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .sidebar-subtitle {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.8);
            margin-top: var(--space-1);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .sidebar-toggle {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--white);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
            backdrop-filter: blur(10px);
        }

        .sidebar-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .sidebar-toggle:active {
            transform: scale(0.95);
        }

        .sidebar-toggle i {
            font-size: 12px;
            transition: transform 0.3s ease;
        }

        /* Collapsed sidebar state */
        .admin-sidebar.collapsed {
            width: 80px;
        }

        .admin-sidebar.collapsed .sidebar-logo-text,
        .admin-sidebar.collapsed .nav-text,
        .admin-sidebar.collapsed .nav-section-title {
            opacity: 0;
            visibility: hidden;
            width: 0;
            overflow: hidden;
        }

        .admin-sidebar.collapsed .sidebar-logo {
            justify-content: center;
            gap: 0;
        }

        .admin-sidebar.collapsed .sidebar-logo-horizontal {
            display: none;
        }

        .admin-sidebar.collapsed .sidebar-logo-circular {
            display: block;
            transform: scale(0.9);
        }

        .admin-sidebar.collapsed .sidebar-toggle i {
            transform: rotate(180deg);
        }

        .admin-sidebar.collapsed .nav-item {
            justify-content: center;
            padding: var(--space-3);
        }

        .admin-sidebar.collapsed .nav-icon {
            margin-right: 0;
            font-size: 1.25rem;
        }

        .admin-sidebar.collapsed .nav-section {
            margin-bottom: var(--space-2);
        }

        /* Adjust main content when sidebar is collapsed */
        .admin-layout.sidebar-collapsed .admin-main {
            margin-left: 80px !important;
        }

        /* Ensure smooth transitions for main content */
        .admin-main {
            transition: margin-left 0.3s ease;
        }

        /* Override responsive rules when sidebar is collapsed */
        @media (max-width: 1280px) {
            .admin-layout.sidebar-collapsed .admin-main {
                margin-left: 80px !important;
            }
        }

        @media (max-width: 1024px) {
            .admin-layout.sidebar-collapsed .admin-main {
                margin-left: 80px !important;
            }
        }

        /* Tooltip for collapsed sidebar items */
        .admin-sidebar.collapsed .nav-item {
            position: relative;
        }

        .admin-sidebar.collapsed .nav-item::after {
            content: attr(title);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: var(--gray-800);
            color: var(--white);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.875rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            z-index: 1000;
            margin-left: var(--space-3);
            box-shadow: var(--shadow-lg);
        }

        .admin-sidebar.collapsed .nav-item::before {
            content: '';
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: var(--gray-800);
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            z-index: 1000;
            margin-left: -5px;
        }

        .admin-sidebar.collapsed .nav-item:hover::after,
        .admin-sidebar.collapsed .nav-item:hover::before {
            opacity: 1;
            visibility: visible;
        }

        .sidebar-nav {
            padding: var(--space-4);
            overflow-y: auto;
            max-height: calc(100vh - 140px);
        }

        .nav-section {
            margin-bottom: var(--space-0);
        }

        .nav-section:last-child {
            margin-bottom: var(--space-8);
        }

        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: var(--space-3);
            padding-left: var(--space-3);
            position: relative;
        }

        .nav-section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 2px;
            height: 12px;
            background: var(--gray-300);
            border-radius: 1px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3);
            border-radius: var(--radius-lg);
            text-decoration: none;
            color: var(--gray-700);
            transition: all var(--transition);
            margin-bottom: var(--space-1);
            position: relative;
        }

        .nav-item:hover {
            background: var(--gray-100);
            color: var(--primary);
            transform: translateX(4px);
        }

        .nav-item.active {
            background: var(--primary);
            color: var(--white);
            box-shadow: var(--shadow-md);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 20px;
            background: var(--white);
            border-radius: 0 var(--radius) var(--radius) 0;
        }

        .nav-item.active .nav-icon {
            color: var(--white);
        }

        .nav-item:focus {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        .nav-icon {
            width: 20px;
            text-align: center;
            color: var(--gray-500);
            transition: color var(--transition);
        }

        .nav-text {
            font-weight: 500;
            transition: color var(--transition);
        }

        .nav-badge {
            margin-left: auto;
            background: var(--accent);
            color: var(--white);
            padding: 0.125rem 0.5rem;
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 280px;
            transition: margin-left var(--transition-slow);
        }

        .admin-header {
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: var(--space-3) var(--space-4);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 40;
            min-height: 3rem;
            width: 100%;
        }

        .admin-header .header-left {
            display: flex;
            align-items: center;
            gap: var(--space-4);
            flex: 1;
            min-width: 0;
        }

        .sidebar-toggle-btn {
            background: var(--primary);
            color: var(--white);
            border: none;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .sidebar-toggle-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .page-title-section {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            flex: 1;
            min-width: 0;
        }

        .page-title-icon {
            font-size: 1.25rem;
            color: var(--primary);
            background: var(--primary-light);
            padding: var(--space-2);
            border-radius: var(--radius-md);
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admin-header .header-actions {
            display: flex;
            align-items: center;
            gap: var(--space-4);
            flex-shrink: 0;
        }

        .admin-header .user-menu {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius-lg);
            background: var(--gray-50);
            cursor: pointer;
            transition: all var(--transition);
            position: relative;
            min-width: 0;
        }

        .admin-header .user-menu:hover {
            background: var(--gray-100);
        }

        .admin-header .user-menu.active {
            background: var(--gray-100);
            border: 1px solid var(--primary);
        }

        .user-menu.active .user-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }


        /* ===== USER INFO STYLES ===== */
        .user-info {
            display: block;
            min-width: 0;
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 0.75rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-email {
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-bottom: var(--space-2);
        }

        .user-role {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-1) var(--space-3);
            background: var(--gray-100);
            color: var(--gray-700);
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .user-role i {
            color: var(--primary);
        }

        .header-actions .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .dropdown-arrow {
            color: var(--gray-500);
            font-size: 0.75rem;
            transition: transform var(--transition);
        }

        .user-menu.active .dropdown-arrow {
            transform: rotate(180deg);
            color: var(--primary);
        }

        .user-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all var(--transition);
            z-index: 1000;
            margin-top: 0;
            pointer-events: none;
        }

        .user-menu.active .user-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3) var(--space-4);
            color: var(--gray-700);
            text-decoration: none;
            transition: all var(--transition);
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-size: 0.875rem;
            cursor: pointer;
        }

        .user-dropdown-item:hover {
            background: var(--gray-50);
            color: var(--primary);
        }

        .user-dropdown-item:first-child {
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }

        .user-dropdown-item:last-child {
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
            border-top: 1px solid var(--gray-200);
        }

        .user-dropdown-item.logout-btn {
            color: var(--gray-700);
        }

        .user-dropdown-item.logout-btn:hover {
            background: #fef2f2;
            color: var(--error);
        }

        .admin-content {
            padding: var(--space-0);
        }

        /* Responsive Design */
        @media (max-width: 1280px) {
            .admin-sidebar {
                width: 250px;
            }

            .admin-main {
                margin-left: 250px;
            }
        }

        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
                width: 280px;
                position: fixed;
                z-index: 1000;
                height: 100vh;
                transition: transform 0.3s ease;
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            /* Handle collapsed sidebar on mobile */
            .admin-sidebar.collapsed {
                width: 80px;
            }

            .admin-sidebar.collapsed.open {
                width: 80px;
            }

            .mobile-menu-toggle {
                display: block !important;
            }

            .user-info {
                display: none;
            }

            .admin-header .user-menu {
                padding: var(--space-2);
                gap: var(--space-2);
            }

            .header-actions .user-avatar {
                width: 24px;
                height: 24px;
                font-size: 0.625rem;
            }

            .user-dropdown {
                position: absolute;
                top: calc(100% + 8px);
                right: 0;
                background: white;
                border: 1px solid var(--gray-200);
                border-radius: var(--radius-lg);
                box-shadow: var(--shadow-lg);
                min-width: 200px;
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px);
                transition: all var(--transition);
                z-index: 1001;
                margin-top: 0;
                pointer-events: none;
            }

            .user-menu.active .user-dropdown {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
                pointer-events: auto;
            }

            .floating-sidebar-toggle {
                display: none !important;
            }
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                width: 100%;
                max-width: 320px;
            }

            .sidebar-header {
                padding: var(--space-2);
            }

            .sidebar-logo {
                gap: var(--space-2);
            }

            .sidebar-logo-horizontal,
            .sidebar-logo-circular {
                height: 40px;
            }

            .sidebar-logo-horizontal {
                width: auto;
            }

            .sidebar-logo-circular {
                width: 40px;
            }

            .sidebar-logo-title {
                font-size: 1.125rem;
            }

            .sidebar-subtitle {
                font-size: 0.75rem;
            }

            .admin-content {
                padding: var(--space-4);
            }

            .page-title {
                font-size: 1rem;
            }

            .admin-header {
                padding: var(--space-3) var(--space-4);
                gap: var(--space-3);
            }

            .admin-header .header-actions {
                gap: var(--space-3);
            }

            .admin-header .user-menu {
                padding: var(--space-2);
            }

            .header-actions .user-avatar {
                width: 26px;
                height: 26px;
                font-size: 0.75rem;
            }

            .mobile-menu-toggle {
                display: block !important;
            }

            .floating-sidebar-toggle {
                display: none !important;
            }
        }

        @media (max-width: 480px) {
            .admin-sidebar {
                width: 100%;
                max-width: 100vw;
            }

            .sidebar-header {
                padding: var(--space-3);
            }

            .sidebar-logo {
                flex-direction: column;
                gap: var(--space-2);
                text-align: center;
            }

            .admin-sidebar.collapsed .sidebar-logo {
                flex-direction: row;
                justify-content: center;
            }

            .sidebar-logo-svg {
                width: 45px;
                height: 45px;
            }

            .sidebar-nav {
                padding: var(--space-3);
            }

            .nav-item {
                padding: var(--space-2) var(--space-3);
            }

            .admin-content {
                padding: var(--space-3);
            }

            .page-title {
                font-size: 1rem;
            }

            .admin-header {
                flex-direction: row;
                justify-content: space-between;
                gap: var(--space-2);
                align-items: center;
                padding: var(--space-2) var(--space-3);
                min-height: 3rem;
            }

            .admin-header .header-left {
                justify-content: flex-start;
                gap: var(--space-2);
            }

            .admin-header .header-actions {
                justify-content: flex-end;
                gap: var(--space-2);
            }

            .sidebar-toggle-btn {
                width: 36px;
                height: 36px;
                font-size: 1rem;
            }

            .page-title-icon {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }

            .admin-header .user-menu {
                padding: var(--space-1);
                gap: var(--space-1);
            }

            .header-actions .user-avatar {
                width: 22px;
                height: 22px;
                font-size: 0.625rem;
            }

            .user-dropdown {
                right: -10px;
                min-width: 180px;
            }

            .floating-sidebar-toggle {
                display: none !important;
            }
        }

        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--gray-600);
            cursor: pointer;
            padding: var(--space-2);
            border-radius: var(--radius);
            transition: all var(--transition);
            z-index: 1001;
            position: relative;
        }

        .mobile-menu-toggle:hover {
            background: var(--gray-100);
            color: var(--gray-800);
        }

        .mobile-menu-toggle:focus {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        /* Floating Sidebar Toggle Button */
        .floating-sidebar-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            color: var(--white);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all var(--transition);
            margin-right: var(--space-3);
            box-shadow: var(--shadow-md);
            z-index: 1002;
        }

        .floating-sidebar-toggle:hover {
            background: var(--primary-light);
            transform: scale(1.05);
            box-shadow: var(--shadow-lg);
        }

        .floating-sidebar-toggle:active {
            transform: scale(0.95);
        }

        .floating-sidebar-toggle i {
            transition: transform 0.3s ease;
        }

        /* Rotate icon when sidebar is collapsed */
        .admin-layout.sidebar-collapsed .floating-sidebar-toggle i {
            transform: rotate(180deg);
        }

        .mobile-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .mobile-backdrop.active {
            opacity: 1;
            display: block;
            pointer-events: auto;
        }

        /* Toast Notification System */
        .toast-container {
            position: fixed;
            top: var(--space-0);
            right: var(--space-0);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: var(--space-3);
            max-width: 400px;
        }

        .toast {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
            padding: var(--space-4);
            display: flex;
            align-items: flex-start;
            gap: var(--space-3);
            position: relative;
            overflow: hidden;
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }

        .toast.hiding {
            transform: translateX(100%);
            opacity: 0;
        }

        .toast-icon {
            flex-shrink: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1rem;
        }

        .toast-success .toast-icon {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .toast-error .toast-icon {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }

        .toast-warning .toast-icon {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .toast-info .toast-icon {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info);
        }

        .toast-content {
            flex: 1;
            min-width: 0;
        }

        .toast-title {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--gray-900);
            margin-bottom: var(--space-1);
        }

        .toast-message {
            font-size: 0.875rem;
            color: var(--gray-600);
            line-height: 1.4;
            word-wrap: break-word;
        }

        .toast-close {
            flex-shrink: 0;
            width: 24px;
            height: 24px;
            border: none;
            background: transparent;
            color: var(--gray-400);
            cursor: pointer;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition);
            font-size: 0.75rem;
        }

        .toast-close:hover {
            background: var(--gray-100);
            color: var(--gray-600);
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: var(--gray-200);
            width: 100%;
            transform-origin: left;
            animation: toast-progress 5s linear forwards;
        }

        .toast-success .toast-progress {
            background: var(--success);
        }

        .toast-error .toast-progress {
            background: var(--error);
        }

        .toast-warning .toast-progress {
            background: var(--warning);
        }

        .toast-info .toast-progress {
            background: var(--info);
        }

        @keyframes toast-progress {
            from {
                transform: scaleX(1);
            }

            to {
                transform: scaleX(0);
            }
        }

        /* Enhanced Loading States */
        .loading-spinner {
            display: inline-block;
            width: 24px;
            height: 24px;
            border: 3px solid var(--gray-200);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: inherit;
            z-index: 10;
        }

        /* Enhanced Tooltip System */
        .tooltip {
            position: relative;
            cursor: help;
        }

        .tooltip::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--gray-900);
            color: var(--white);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition);
            z-index: 1000;
            pointer-events: none;
        }

        .tooltip:hover::after {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(-4px);
        }

        /* Enhanced Modal Improvements */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition);
            backdrop-filter: blur(8px);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: var(--white);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-2xl);
            max-width: 90vw;
            max-height: 90vh;
            overflow: hidden;
            transform: scale(0.9) translateY(20px);
            transition: all var(--transition);
        }

        .modal-overlay.active .modal-content {
            transform: scale(1) translateY(0);
        }

        /* Enhanced Chart and Graph Styles */
        .chart-container {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            position: relative;
            overflow: hidden;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-0);
            padding-bottom: var(--space-4);
            border-bottom: 2px solid var(--gray-100);
        }

        .chart-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .chart-legend {
            display: flex;
            gap: var(--space-4);
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 2px;
            background: var(--primary);
        }

        /* Responsive toast design */
        @media (max-width: 768px) {
            .toast-container {
                top: var(--space-4);
                right: var(--space-4);
                left: var(--space-4);
                max-width: none;
            }

            .toast {
                padding: var(--space-3);
            }

            .toast-content {
                font-size: 0.875rem;
            }
        }

        /* Enhanced Search and Filter Styles */
        .search-box {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .search-input {
            width: 100%;
            padding: var(--space-4) var(--space-12) var(--space-4) var(--space-4);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-xl);
            font-size: 0.875rem;
            transition: all var(--transition);
            background: var(--white);
            box-shadow: var(--shadow-sm);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(23, 52, 120, 0.1), var(--shadow-md);
            transform: translateY(-2px);
        }

        .search-input::placeholder {
            color: var(--gray-400);
            transition: color var(--transition);
        }

        .search-input:focus::placeholder {
            color: var(--gray-500);
        }

        .search-icon {
            position: absolute;
            right: var(--space-4);
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: 1rem;
            pointer-events: none;
            transition: color var(--transition);
        }

        .search-input:focus+.search-icon {
            color: var(--primary);
        }

        .filter-group {
            display: flex;
            gap: var(--space-3);
        }

        .filter-select {
            padding: var(--space-4) var(--space-4);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-xl);
            font-size: 0.875rem;
            transition: all var(--transition);
            background: var(--white);
            min-width: 150px;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(23, 52, 120, 0.1), var(--shadow-md);
            transform: translateY(-2px);
        }

        .filter-select:hover {
            border-color: var(--gray-300);
            box-shadow: var(--shadow-md);
        }

        .filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: var(--space-4);
        }

        @media (max-width: 768px) {
            .filters {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                justify-content: center;
            }

            .search-box {
                max-width: none;
            }
        }

        /* ===== COMPREHENSIVE TABLE SYSTEM ===== */
        /* Common table styles for all admin pages */

        /* Table Container */
        .table-container {
            overflow-x: auto;
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            background: var(--white);
            box-shadow: var(--shadow-sm);
        }

        /* Base Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--white);
        }

        /* Table Headers */
        .data-table thead {
            background: var(--gray-50);
            border-bottom: 2px solid var(--gray-200);
        }

        .data-table th {
            padding: var(--space-4);
            text-align: left;
            font-weight: 600;
            color: var(--gray-700);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--gray-200);
            position: relative;
        }

        .data-table th:first-child {
            border-top-left-radius: var(--radius-lg);
        }

        .data-table th:last-child {
            border-top-right-radius: var(--radius-lg);
        }

        /* Table Rows */
        .data-table tbody tr {
            border-bottom: 1px solid var(--gray-100);
            transition: all var(--transition);
        }

        .data-table tbody tr:last-child {
            border-bottom: none;
        }

        .data-table tbody tr:hover {
            background: var(--gray-50);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        /* Table Cells */
        .data-table td {
            padding: var(--space-4);
            text-align: left;
            border-bottom: 1px solid var(--gray-100);
            vertical-align: middle;
        }

        .data-table td:first-child {
            font-weight: 500;
            color: var(--gray-900);
        }

        /* Table Content Types */
        .data-table .text-center {
            text-align: center;
        }

        .data-table .text-right {
            text-align: right;
        }

        .data-table .text-muted {
            color: var(--gray-500);
        }

        .data-table .text-small {
            font-size: 0.875rem;
        }

        /* Table Actions Column */
        .data-table .actions-column {
            width: 120px;
            text-align: center;
            margin: 0;
            padding: 0;
            vertical-align: top;
        }

        .data-table .actions-column .action-buttons {
            display: flex;
            gap: var(--space-2);
            justify-content: center;
            flex-wrap: wrap;
            margin: 0;
            padding: 0;
        }

        /* Table Status Indicators */
        .data-table .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
        }

        .data-table .status-indicator::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--gray-400);
        }

        .data-table .status-indicator.active::before {
            background: var(--success);
        }

        .data-table .status-indicator.inactive::before {
            background: var(--error);
        }

        .data-table .status-indicator.pending::before {
            background: var(--warning);
        }

        /* Table Images and Avatars */
        .data-table .avatar-cell {
            width: 60px;
            text-align: center;
        }

        .data-table .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--gray-200);
        }

        .data-table .avatar-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gray-100);
            border: 2px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
            font-size: 1rem;
        }

        /* Table Checkboxes */
        .data-table .checkbox-cell {
            width: 40px;
            text-align: center;
        }

        .data-table .checkbox-cell input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border: 2px solid var(--gray-300);
            border-radius: var(--radius);
            cursor: pointer;
            transition: all var(--transition);
        }

        .data-table .checkbox-cell input[type="checkbox"]:checked {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* Table Empty State */
        .data-table .empty-row td {
            text-align: center;
            padding: var(--space-12);
            color: var(--gray-500);
        }

        .data-table .empty-row .empty-icon {
            font-size: 3rem;
            color: var(--gray-300);
            margin-bottom: var(--space-4);
        }

        /* Table Loading State */
        .data-table .loading-row td {
            text-align: center;
            padding: var(--space-8);
        }

        .data-table .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid var(--gray-200);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Table Responsive Design */
        @media (max-width: 1024px) {
            .table-container {
                border-radius: var(--radius);
            }

            .data-table th,
            .data-table td {
                padding: var(--space-3);
            }
        }

        @media (max-width: 768px) {
            .table-container {
                border: none;
                box-shadow: none;
                overflow-x: auto;
                overflow-y: visible;
            }

            .data-table {
                display: block;
            }

            .data-table thead {
                display: none;
            }

            .data-table tbody {
                display: block;
            }

            .data-table tr {
                display: block;
                padding: var(--space-3);
                margin-bottom: var(--space-2);
                border: 1px solid var(--gray-200);
                border-radius: var(--radius);
                background: var(--white);
                box-shadow: var(--shadow-sm);
            }

            .data-table td {
                display: block;
                padding: var(--space-2) 0;
                border: none;
                text-align: left;
            }

            .data-table td::before {
                content: none;
            }

            .data-table .actions-column {
                width: auto;
                text-align: left;
            }

            .data-table .actions-column .action-buttons {
                justify-content: flex-start;
                margin-top: 0;
            }

            .data-table .avatar-cell {
                width: auto;
                text-align: left;
            }

            .data-table .checkbox-cell {
                width: auto;
                text-align: left;
            }
        }

        @media (max-width: 480px) {
            .data-table tr {
                padding: var(--space-2);
            }

            .data-table td {
                padding: var(--space-1) 0;
            }

            .data-table td::before {
                width: 100px;
                font-size: 0.875rem;
            }

            .data-table .actions-column .action-buttons {
                flex-direction: column;
                gap: var(--space-1);
            }
        }

        /* Table Print Styles */
        @media print {
            .table-container {
                border: none;
                box-shadow: none;
                overflow: visible;
            }

            .data-table {
                display: table;
                border: 1px solid var(--gray-300);
            }

            .data-table thead {
                display: table-header-group;
                background: var(--gray-100) !important;
            }

            .data-table tbody {
                display: table-row-group;
            }

            .data-table tr {
                display: table-row;
                border: none;
                padding: 0;
                margin: 0;
                box-shadow: none;
            }

            .data-table td {
                display: table-cell;
                border: 1px solid var(--gray-300);
                padding: var(--space-2);
            }

            .data-table .actions-column {
                display: none;
            }

            .data-table .checkbox-cell {
                display: none;
            }
        }

        /* ===== ENHANCED PRACTICE SESSION STYLES ===== */
        .session-row {
            transition: all var(--transition);
        }

        .session-row:hover {
            background: var(--gray-50);
            transform: translateY(-1px);
        }

        .session-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
        }

        .session-title {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 1rem;
        }

        .session-description {
            color: var(--gray-600);
            font-size: 0.875rem;
            line-height: 1.4;
        }

        .datetime-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
        }

        .date-display,
        .time-display {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-weight: 500;
            color: var(--primary);
        }

        .duration-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            background: var(--primary-light);
            color: var(--white);
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 600;
        }

        .venue-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .venue-name {
            font-weight: 600;
            color: var(--gray-900);
        }

        .venue-address {
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .no-venue {
            color: var(--gray-400);
            font-style: italic;
        }

        .attendance-stats {
            display: flex;
            flex-direction: column;
            gap: var(--space-3);
        }

        .stats-row {
            display: flex;
            gap: var(--space-4);
            justify-content: center;
        }

        .stat-present,
        .stat-late,
        .stat-absent,
        .stat-excused {
            font-weight: 700;
            font-size: 1.125rem;
        }

        .stat-present {
            color: var(--success);
        }

        .stat-late {
            color: var(--warning);
        }

        .stat-absent {
            color: var(--error);
        }

        .stat-excused {
            color: var(--primary);
        }

        .attendance-percentage {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
            color: var(--gray-600);
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Enhanced Member Info Styles */
        .member-info.enhanced-info {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .member-photo.enhanced-photo {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            flex-shrink: 0;
        }

        .member-photo.enhanced-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), transparent);
            opacity: 0;
            transition: opacity var(--transition);
        }

        .member-photo.enhanced-photo:hover .photo-overlay {
            opacity: 1;
        }

        .member-photo-placeholder.enhanced-placeholder {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--gray-100);
            border: 2px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
            font-size: 1.25rem;
            position: relative;
            flex-shrink: 0;
        }

        .placeholder-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            filter: blur(8px);
            opacity: 0.3;
            animation: pulse 2s infinite;
        }

        .member-details {
            flex: 1;
            min-width: 0;
        }

        .member-name {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-1);
        }

        .member-email {
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .member-phone {
            color: var(--gray-500);
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: var(--space-1);
            margin-top: var(--space-1);
        }

        /* Enhanced Status Badge Styles */
        .status-badge.enhanced-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-lg);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            position: relative;
            overflow: hidden;
        }

        .status-badge.enhanced-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .status-badge.enhanced-badge:hover::before {
            left: 100%;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.8;
        }

        .status-scheduled {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
        }

        .status-in_progress {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .status-completed {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .status-cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }

        .status-present {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .status-absent {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }

        .status-late {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .status-excused {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
        }

        /* Enhanced Voice Badge Styles */
        .voice-badge.enhanced-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-lg);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .voice-soprano {
            background: rgba(236, 72, 153, 0.1);
            color: #ec4899;
        }

        .voice-alto {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .voice-tenor {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .voice-bass {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
        }

        .no-voice,
        .no-reason,
        .no-notes,
        .no-arrival {
            color: var(--gray-400);
            font-style: italic;
        }

        .reason-text,
        .notes-text {
            color: var(--gray-700);
            font-weight: 500;
        }

        .arrival-time {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--success);
            font-weight: 500;
        }

        .update-time {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--gray-500);
            font-size: 0.875rem;
        }

        /* Enhanced Search and Filters Section */
        .search-filters-section {
            margin-bottom: var(--space-0);
        }

        .filters-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }

        .filters-header {
            padding: var(--space-4) var(--space-0);
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filters-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .filters-toggle {
            display: flex;
            align-items: center;
        }

        .toggle-btn {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-4);
            background: var(--white);
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-lg);
            color: var(--gray-700);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition);
        }

        .toggle-btn:hover,
        .toggle-btn.active {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }

        .filters-form {
            padding: var(--space-0);
        }

        .filters-grid {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }

        .search-group {
            display: flex;
            justify-content: center;
        }

        .filter-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-4);
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
        }

        .filter-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
        }

        .filter-actions {
            display: flex;
            justify-content: center;
            gap: var(--space-3);
            margin-top: var(--space-4);
        }

        /* Enhanced Filter Select Styles */
        .filter-select.enhanced-select {
            padding: var(--space-3) var(--space-4) !important;
            border: 2px solid var(--gray-300) !important;
            border-radius: var(--radius-lg) !important;
            background: var(--white) !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            color: var(--gray-700) !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            appearance: none !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e") !important;
            background-position: right 0.75rem center !important;
            background-repeat: no-repeat !important;
            background-size: 1.5em 1.5em !important;
            padding-right: 2.5rem !important;
        }

        .filter-select.enhanced-select:focus {
            outline: none !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(23, 52, 120, 0.1) !important;
            transform: translateY(-1px) !important;
        }

        .filter-select.enhanced-select:hover {
            border-color: var(--gray-400) !important;
        }

        .filter-btn,
        .clear-btn {
            padding: var(--space-3) var(--space-0);
            border-radius: var(--radius-lg);
            font-weight: 500;
            transition: all var(--transition);
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Enhanced Enhanced Button Styles */
        .enhanced-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }



        .btn-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .btn-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            filter: blur(15px);
            opacity: 0.3;
            transition: opacity 0.3s ease;
        }

        .enhanced-btn:hover .btn-glow {
            opacity: 0.6;
        }

        /* Enhanced Enhanced Header Styles */
        .enhanced-header {
            position: relative;
            overflow: hidden;
        }

        .header-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        .header-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.03) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .enhanced-header:hover .header-pattern {
            opacity: 1;
        }

        .header-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            right: -50%;
            bottom: -50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.05) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .enhanced-header:hover .header-glow {
            opacity: 1;
        }

        .header-icon {
            position: relative;
            flex-shrink: 0;
        }

        .icon-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            filter: blur(20px);
            opacity: 0.3;
            transition: opacity 0.3s ease;
        }

        .enhanced-header:hover .icon-glow {
            opacity: 0.6;
        }

        .header-stats {
            display: flex;
            gap: var(--space-4);
            margin-top: var(--space-3);
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--space-1);
        }

        .stat-number {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Enhanced Enhanced Card Styles */
        .enhanced-card {
            position: relative;
            overflow: hidden;
        }

        .enhanced-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.02), transparent);
            transition: left 0.5s ease;
        }

        .enhanced-card:hover::before {
            left: 100%;
        }

        .enhanced-table {
            position: relative;
            overflow: hidden;
        }

        .enhanced-table::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.02), transparent);
            transition: left 0.5s ease;
        }

        .enhanced-table:hover::before {
            left: 100%;
        }

        .enhanced-pagination {
            position: relative;
            overflow: hidden;
        }

        .enhanced-pagination::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.02), transparent);
            transition: left 0.5s ease;
        }

        .enhanced-pagination:hover::before {
            left: 100%;
        }

        .enhanced-empty-state {
            position: relative;
            overflow: hidden;
        }

        .enhanced-empty-state::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.02), transparent);
            transition: left 0.5s ease;
        }

        .enhanced-empty-state:hover::before {
            left: 100%;
        }

        .icon-pulse {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            filter: blur(15px);
            opacity: 0.3;
            animation: pulse 2s infinite;
        }

        /* Enhanced Enhanced Input Styles */
        .enhanced-input,
        .enhanced-select,
        .enhanced-textarea {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .enhanced-input::before,
        .enhanced-select::before,
        .enhanced-textarea::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.05), transparent);
            transition: left 0.5s ease;
        }

        .enhanced-input:hover::before,
        .enhanced-select:hover::before,
        .enhanced-textarea:hover::before {
            left: 100%;
        }

        .enhanced-input:focus::before,
        .enhanced-select:focus::before,
        .enhanced-textarea:focus::before {
            left: 100%;
        }

        /* Enhanced Enhanced Actions Styles */
        .enhanced-actions {
            position: relative;
            overflow: hidden;
        }

        .enhanced-actions::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.02), transparent);
            transition: left 0.5s ease;
        }

        .enhanced-actions:hover::before {
            left: 100%;
        }

        .action-btn {
            position: relative;
            overflow: hidden;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .action-btn:hover::before {
            width: 200px;
            height: 200px;
        }

        .btn-tooltip {
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--gray-900);
            color: var(--white);
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition);
            pointer-events: none;
        }

        .action-btn:hover .btn-tooltip {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(-5px);
        }

        /* Enhanced Enhanced Search Styles */
        .enhanced-search {
            position: relative;
            overflow: hidden;
        }

        .enhanced-search::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.05), transparent);
            transition: left 0.5s ease;
        }

        .enhanced-search:hover::before {
            left: 100%;
        }

        .search-glow {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            filter: blur(15px);
            opacity: 0.3;
            transition: opacity 0.3s ease;
        }

        .enhanced-search:hover .search-glow {
            opacity: 0.6;
        }

        /* ===== ENHANCED FINANCIAL REPORT STYLES ===== */
        .reports-grid {
            display: grid;
            gap: var(--space-0);
            margin-bottom: var(--space-8);
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--space-0);
        }

        .summary-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: var(--space-4);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            transform: scaleX(0);
            transition: transform var(--transition);
        }

        .summary-card:hover::before {
            transform: scaleX(1);
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .card-icon {
            width: 64px;
            height: 64px;
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--white);
            flex-shrink: 0;
        }

        .card-icon.income {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
        }

        .card-icon.expenses {
            background: linear-gradient(135deg, var(--error) 0%, #dc2626 100%);
        }

        .card-icon.profit {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        }

        .card-icon.balance {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
        }

        .card-content {
            flex: 1;
        }

        .card-title {
            font-weight: 600;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: var(--space-2);
        }

        .card-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
            line-height: 1;
        }

        .card-change {
            font-size: 0.75rem;
            font-weight: 600;
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            display: inline-block;
        }

        .card-change.positive {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .card-change.negative {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }

        .card-change.neutral {
            background: rgba(107, 114, 128, 0.1);
            color: var(--gray-600);
        }

        /* ===== ENHANCED DASHBOARD SPECIFIC STYLES ===== */
        .dashboard-welcome {
            margin-bottom: var(--space-8);
        }

        .welcome-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: var(--radius-2xl);
            padding: var(--space-8);
            color: var(--white);
            box-shadow: var(--shadow-2xl);
            position: relative;
            overflow: hidden;
        }

        .welcome-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        .welcome-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            animation: patternFloat 20s ease-in-out infinite;
        }

        @keyframes patternFloat {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) rotate(1deg);
            }
        }

        .welcome-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            right: -50%;
            bottom: -50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: glowPulse 4s ease-in-out infinite;
        }

        @keyframes glowPulse {

            0%,
            100% {
                opacity: 0.3;
                transform: scale(1);
            }

            50% {
                opacity: 0.6;
                transform: scale(1.1);
            }
        }

        .welcome-content {
            position: relative;
            z-index: 2;
        }

        .welcome-header {
            display: flex;
            align-items: center;
            gap: var(--space-0);
            margin-bottom: var(--space-0);
        }

        .welcome-avatar {
            position: relative;
            flex-shrink: 0;
        }

        .avatar-initial {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 800;
            color: var(--white);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-xl);
        }

        .avatar-status {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--success);
            color: var(--white);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--white);
            font-size: 0.75rem;
            animation: statusPulse 2s ease-in-out infinite;
        }

        @keyframes statusPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .welcome-text {
            flex: 1;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: var(--space-2);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .welcome-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: var(--space-4);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .welcome-meta {
            display: flex;
            gap: var(--space-0);
            align-items: center;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
            opacity: 0.8;
            background: rgba(255, 255, 255, 0.1);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-lg);
            backdrop-filter: blur(10px);
        }

        .meta-item i {
            color: var(--white);
            font-size: 0.875rem;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.1);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-lg);
            backdrop-filter: blur(10px);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: var(--success);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        /* Enhanced Section Headers */
        .section-header {
            text-align: center;
            margin-bottom: var(--space-8);
            position: relative;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            border-radius: var(--radius);
        }

        .section-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: var(--space-3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-3);
        }

        .section-title i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .section-subtitle {
            color: var(--gray-600);
            font-size: 1.125rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Enhanced Dashboard Stats */
        .dashboard-stats {
            margin-bottom: var(--space-8);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(4, 1fr));
            gap: var(--space-0);
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: var(--space-4);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(59, 130, 246, 0.02) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-2xl);
        }

        .stat-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        .stat-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 10% 90%, rgba(59, 130, 246, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 90% 10%, rgba(59, 130, 246, 0.03) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover .stat-pattern {
            opacity: 1;
        }

        .stat-icon {
            width: 80px;
            height: 80px;
            border-radius: var(--radius-2xl);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--white);
            flex-shrink: 0;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .icon-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            filter: blur(20px);
            opacity: 0.3;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover .icon-glow {
            opacity: 0.6;
        }

        .stat-icon.members {
            background: linear-gradient(135deg, var(--accent) 0%, #4f46e5 100%);
        }

        .stat-icon.contributions {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
        }

        .stat-icon.concerts {
            background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
        }

        .stat-icon.media {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
        }

        .stat-content {
            flex: 1;
            position: relative;
            z-index: 2;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
            line-height: 1;
            background: linear-gradient(135deg, var(--gray-900) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-bottom: var(--space-3);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-change {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
            font-weight: 600;
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-lg);
            width: fit-content;
        }

        .stat-change.positive {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .stat-change.neutral {
            background: rgba(107, 114, 128, 0.1);
            color: var(--gray-600);
        }

        .stat-change i {
            font-size: 0.75rem;
        }

        .stat-decoration {
            position: absolute;
            top: var(--space-4);
            right: var(--space-4);
            z-index: 2;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover .stat-decoration {
            opacity: 1;
        }

        .decoration-dot {
            width: 8px;
            height: 8px;
            background: var(--primary);
            border-radius: 50%;
            margin-bottom: var(--space-2);
            animation: bounce 2s infinite;
        }

        .decoration-line {
            width: 2px;
            height: 20px;
            background: linear-gradient(to bottom, var(--primary), transparent);
            border-radius: var(--radius);
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .welcome-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: var(--radius-2xl);
            padding: var(--space-8);
            color: var(--white);
            box-shadow: var(--shadow-2xl);
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: var(--space-2);
        }

        .welcome-subtitle {
            font-size: 1.125rem;
            opacity: 0.9;
            margin-bottom: var(--space-0);
        }

        .welcome-meta {
            display: flex;
            gap: var(--space-0);
            align-items: center;
        }

        .last-updated {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
            opacity: 0.8;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .dashboard-stats {
            margin-bottom: var(--space-8);
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: var(--space-4);
            transition: all var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .stat-icon {
            width: 64px;
            height: 64px;
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--white);
        }

        .stat-icon.members {
            background: var(--accent);
        }

        .stat-icon.contributions {
            background: var(--success);
        }

        .stat-icon.concerts {
            background: var(--warning);
        }

        .stat-icon.media {
            background: #8b5cf6;
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: var(--space-1);
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-bottom: var(--space-2);
        }

        .stat-change {
            font-size: 0.75rem;
            font-weight: 600;
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
        }

        .stat-change.positive {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .stat-change.neutral {
            background: rgba(156, 163, 175, 0.1);
            color: var(--gray-500);
        }

        /* Enhanced Action Cards */
        .dashboard-actions {
            margin-bottom: var(--space-8);
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--space-0);
        }

        .action-card {
            background: var(--white);
            border-radius: var(--radius-2xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            text-decoration: none;
            color: inherit;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(59, 130, 246, 0.02) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .action-card:hover::before {
            opacity: 1;
        }

        .action-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-2xl);
            border-color: var(--primary);
        }

        .action-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        .action-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.03) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .action-card:hover .action-pattern {
            opacity: 1;
        }

        .action-icon {
            width: 64px;
            height: 64px;
            background: var(--primary);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto var(--space-4);
            font-size: 1.5rem;
            color: var(--white);
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .action-card:hover .action-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .icon-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            filter: blur(15px);
            opacity: 0.3;
            transition: opacity 0.3s ease;
        }

        .action-card:hover .icon-glow {
            opacity: 0.6;
        }

        .action-card-members .action-icon {
            background: linear-gradient(135deg, var(--accent) 0%, #4f46e5 100%);
        }

        .action-card-concerts .action-icon {
            background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
        }

        .action-card-campaigns .action-icon {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
        }

        .action-card-media .action-icon {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
        }

        .action-content {
            position: relative;
            z-index: 2;
        }

        .action-content h4 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
        }

        .action-content p {
            font-size: 0.875rem;
            color: var(--gray-600);
            line-height: 1.5;
        }

        .action-arrow {
            position: absolute;
            top: var(--space-4);
            right: var(--space-4);
            width: 32px;
            height: 32px;
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-500);
            font-size: 0.875rem;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateX(10px);
        }

        .action-card:hover .action-arrow {
            opacity: 1;
            transform: translateX(0);
            background: var(--primary);
            color: var(--white);
        }

        /* Enhanced Overview Cards */
        .dashboard-overview {
            margin-bottom: var(--space-8);
        }

        .overview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: var(--space-0);
        }

        .overview-card {
            background: var(--white);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .overview-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .card-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        .card-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 10% 90%, rgba(59, 130, 246, 0.02) 0%, transparent 50%),
                radial-gradient(circle at 90% 10%, rgba(59, 130, 246, 0.02) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .overview-card:hover .card-pattern {
            opacity: 1;
        }

        .overview-card .card-header {
            padding: var(--space-0);
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .header-content h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .header-content h3 i {
            color: var(--primary);
            font-size: 1rem;
        }

        .header-badge {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            background: var(--primary);
            color: var(--white);
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius-lg);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            background: var(--success);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .view-all {
            font-size: 0.875rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: var(--space-2);
            transition: all 0.3s ease;
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-lg);
            background: rgba(59, 130, 246, 0.1);
        }

        .view-all:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateX(4px);
        }

        .overview-card .card-content {
            padding: var(--space-0);
            position: relative;
            z-index: 2;
        }

        /* Enhanced Empty States */
        .enhanced-empty-state {
            text-align: center;
            padding: var(--space-8);
        }

        .enhanced-empty-state .empty-icon {
            position: relative;
            margin-bottom: var(--space-0);
        }

        .icon-pulse {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            animation: iconPulse 2s ease-in-out infinite;
        }

        @keyframes iconPulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.3;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.6;
            }
        }

        .enhanced-empty-state h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-3);
        }

        .enhanced-empty-state p {
            color: var(--gray-600);
            margin-bottom: var(--space-0);
            font-size: 1rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .empty-actions {
            display: flex;
            gap: var(--space-3);
            justify-content: center;
            flex-wrap: wrap;
        }

        .refresh-btn {
            background: transparent;
            color: var(--gray-600);
            border: 2px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .refresh-btn:hover {
            background: var(--gray-100);
            border-color: var(--gray-300);
            color: var(--gray-800);
        }

        /* Enhanced Quick Stats */
        .dashboard-quick-stats {
            margin-bottom: var(--space-8);
        }

        .quick-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-4);
        }

        .quick-stat-item {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-4);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: var(--space-3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .quick-stat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .quick-stat-item:hover::before {
            transform: scaleY(1);
        }

        .quick-stat-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .quick-stat-item .stat-icon {
            width: 48px;
            height: 48px;
            background: var(--primary);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .quick-stat-item .stat-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .quick-stat-item .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--gray-900);
            line-height: 1;
        }

        .quick-stat-item .stat-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        .quick-stat-item .stat-trend {
            display: flex;
            align-items: center;
            gap: var(--space-1);
            font-size: 0.75rem;
            font-weight: 600;
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-trend.positive {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .stat-trend.neutral {
            background: rgba(107, 114, 128, 0.1);
            color: var(--gray-600);
        }

        .stat-trend i {
            font-size: 0.625rem;
        }

        /* ===== ENHANCED MEMBERS PAGE STYLES ===== */

        /* Enhanced Page Header */
        .enhanced-header {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: var(--radius-2xl);
            margin-bottom: var(--space-8);
            box-shadow: var(--shadow-2xl);
        }

        .header-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        .header-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            animation: patternFloat 20s ease-in-out infinite;
        }

        .header-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            right: -50%;
            bottom: -50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: glowPulse 4s ease-in-out infinite;
        }

        .enhanced-header .header-content {
            position: relative;
            z-index: 2;
            color: var(--white);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: var(--space-0);
        }

        .enhanced-header .header-text {
            flex: 1;
            display: flex;
            gap: var(--space-0);
            align-items: flex-start;
        }

        .header-icon {
            position: relative;
            flex-shrink: 0;
        }

        .header-icon i {
            font-size: 3rem;
            color: var(--white);
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .icon-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            filter: blur(20px);
            opacity: 0.3;
            animation: iconGlow 3s ease-in-out infinite;
        }

        @keyframes iconGlow {

            0%,
            100% {
                opacity: 0.3;
                transform: scale(1);
            }

            50% {
                opacity: 0.6;
                transform: scale(1.1);
            }
        }

        .header-details {
            flex: 1;
        }

        .enhanced-header .header-title {
            font-size: 1rem;
            font-weight: 900;
            margin-bottom: var(--space-3);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .enhanced-header .header-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: var(--space-0);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .header-stats {
            display: flex;
            gap: var(--space-0);
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--space-1);
            background: rgba(255, 255, 255, 0.1);
            padding: var(--space-3) var(--space-4);
            border-radius: var(--radius-xl);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            min-width: 80px;
        }

        .stat-item .stat-number {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--white);
            line-height: 1;
        }

        .stat-item .stat-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        .enhanced-header .header-actions {
            flex-shrink: 0;
        }

        /* Enhanced Buttons */
        .enhanced-btn {
            position: relative;
            overflow: hidden;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .enhanced-btn:hover {
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .btn-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: inherit;
        }

        .btn-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            filter: blur(15px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .enhanced-btn:hover .btn-glow {
            opacity: 0.6;
        }

        /* Enhanced Search and Filters */
        .search-filters-section {
            margin-bottom: var(--space-0);
        }

        .filters-card {
            background: var(--white);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }

        .filters-header {
            padding: var(--space-0);
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filters-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .filters-title i {
            color: var(--primary);
        }

        .toggle-btn {
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: var(--space-2) var(--space-4);
            border-radius: var(--radius-lg);
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .toggle-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .toggle-btn.active {
            background: var(--success);
        }

        .filters-form {
            padding: var(--space-0);
            display: none;
        }

        .filters-grid {
            display: grid;
            gap: var(--space-0);
        }

        .search-group {
            grid-column: 1 / -1;
        }

        .filter-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-4);
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
        }

        .filter-label {
            font-size: 0.625rem;
            font-weight: 600;
            color: var(--gray-700);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .filter-actions {
            display: flex;
            gap: var(--space-3);
            justify-content: flex-end;
            padding-top: var(--space-4);
            border-top: 1px solid var(--gray-200);
        }

        .filter-btn {
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: var(--space-3) var(--space-0);
            border-radius: var(--radius-lg);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .filter-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .clear-btn {
            background: transparent;
            color: var(--gray-600);
            border: 2px solid var(--gray-300);
            padding: var(--space-3) var(--space-0);
            border-radius: var(--radius-lg);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: var(--space-2);
            text-decoration: none;
        }

        .clear-btn:hover {
            background: var(--gray-100);
            border-color: var(--gray-400);
            color: var(--gray-800);
        }

        /* Enhanced Search Box */
        .enhanced-search {
            position: relative;
            background: var(--white);
            border-radius: var(--radius-xl);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .enhanced-search:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .search-icon {
            position: absolute;
            left: var(--space-4);
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: 0.75rem;
            z-index: 2;
            transition: color 0.3s ease;
        }

        .enhanced-search:focus-within .search-icon {
            color: var(--primary);
        }

        .enhanced-input {
            width: 100%;
            padding: var(--space-4) var(--space-4) var(--space-4) var(--space-12);
            border: none;
            outline: none;
            font-size: 1rem;
            background: transparent;
            color: var(--gray-900);
        }

        .enhanced-input::placeholder {
            color: var(--gray-400);
        }

        .search-glow {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(59, 130, 246, 0.02) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .enhanced-search:focus-within .search-glow {
            opacity: 1;
        }

        /* Enhanced Select */
        .enhanced-select {
            width: 100%;
            padding: var(--space-3) var(--space-4);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            background: var(--white);
            color: var(--gray-900);
            font-size: 0.625rem;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        .enhanced-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .enhanced-select:hover {
            border-color: var(--gray-300);
        }

        /* Enhanced Content Card */
        .enhanced-card {
            background: var(--white);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .enhanced-card:hover {
            box-shadow: var(--shadow-2xl);
            transform: translateY(-2px);
        }

        .enhanced-card .card-header {
            padding: var(--space-0);
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .enhanced-card .card-title {
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .enhanced-card .card-title i {
            color: var(--primary);
            font-size: 1rem;
        }

        .header-meta {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .results-count {
            font-size: 0.75rem;
            color: var(--gray-600);
            font-weight: 500;
            background: var(--gray-100);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-lg);
        }

        /* Enhanced Table */
        .enhanced-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .enhanced-table thead th {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            padding: var(--space-4) var(--space-0);
            text-align: left;
            font-weight: 700;
            color: var(--gray-900);
            border-bottom: 2px solid var(--gray-200);
            position: sticky;
            top: 0;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .enhanced-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid var(--gray-100);
        }

        .enhanced-table tbody tr:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.02) 0%, rgba(59, 130, 246, 0.05) 100%);
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Enhanced Member Photos */
        .enhanced-photo {
            position: relative;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .enhanced-photo:hover {
            transform: scale(1.1);
            border-color: var(--primary);
        }

        .enhanced-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(0, 0, 0, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .enhanced-photo:hover .photo-overlay {
            opacity: 1;
        }

        .enhanced-placeholder {
            position: relative;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gray-200) 0%, var(--gray-300) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-500);
            font-size: 1.25rem;
            border: 2px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .enhanced-placeholder:hover {
            background: linear-gradient(135deg, var(--gray-300) 0%, var(--gray-400) 100%);
            color: var(--gray-600);
            transform: scale(1.1);
        }

        .placeholder-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            filter: blur(10px);
            opacity: 0;
            animation: placeholderGlow 2s ease-in-out infinite;
        }

        @keyframes placeholderGlow {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 0.3;
            }
        }

        /* Enhanced Member Info */
        .enhanced-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .member-name {
            font-weight: 700;
            color: var(--gray-900);
            font-size: 1rem;
        }

        .member-email {
            font-size: 0.75rem;
            color: var(--gray-600);
        }

        .member-phone {
            font-size: 0.625rem;
            color: var(--gray-500);
            display: flex;
            align-items: center;
            gap: var(--space-1);
        }

        .member-phone i {
            color: var(--primary);
            font-size: 0.625rem;
        }

        /* Enhanced Badges */
        .enhanced-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-lg);
            font-size: 0.625rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .enhanced-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(255, 255, 255, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .enhanced-badge:hover::before {
            opacity: 1;
        }

        .enhanced-badge i {
            font-size: 0.625rem;
        }

        .type-badge.type-singer {
            background: linear-gradient(135deg, var(--accent) 0%, #4f46e5 100%);
            color: var(--white);
        }

        .type-badge.type-general {
            background: linear-gradient(135deg, var(--gray-500) 0%, var(--gray-600) 100%);
            color: var(--white);
        }

        .voice-badge.voice-soprano {
            background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
            color: var(--white);
        }

        .voice-badge.voice-alto {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: var(--white);
        }

        .voice-badge.voice-tenor {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            color: var(--white);
        }

        .voice-badge.voice-bass {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: var(--white);
        }

        .status-badge.active {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: var(--white);
        }

        .status-badge.inactive {
            background: linear-gradient(135deg, var(--gray-500) 0%, var(--gray-600) 100%);
            color: var(--white);
        }

        .status-dot {
            width: 6px;
            height: 6px;
            background: currentColor;
            border-radius: 50%;
            animation: statusPulse 2s ease-in-out infinite;
        }

        @keyframes statusPulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.7;
                transform: scale(1.2);
            }
        }

        /* Enhanced Join Date */
        .join-date {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .date-icon {
            width: 32px;
            height: 32px;
            background: var(--primary);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 0.75rem;
        }

        .date-text {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .date-day {
            font-weight: 700;
            color: var(--gray-900);
            font-size: 0.75rem;
        }

        .date-year {
            font-size: 0.625rem;
            color: var(--gray-500);
        }

        /* Enhanced Action Buttons */
        .enhanced-actions {
            display: flex;
            gap: var(--space-2);
            flex-wrap: wrap;
        }

        .action-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            border-radius: var(--radius-lg);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-tooltip {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--gray-900);
            color: var(--white);
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            font-size: 0.625rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            margin-bottom: var(--space-2);
        }

        .action-btn:hover .btn-tooltip {
            opacity: 1;
        }

        .delete-btn:hover {
            background: var(--danger-dark);
            border-color: var(--danger-dark);
        }

        /* Enhanced Pagination */
        .enhanced-pagination {
            margin-top: var(--space-8);
            display: flex;
            justify-content: center;
        }

        .enhanced-pagination .pagination {
            display: flex;
            gap: var(--space-2);
            align-items: center;
            background: var(--white);
            padding: var(--space-3) var(--space-3);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
        }

        .enhanced-pagination .page-item .page-link {
            padding: var(--space-2) var(--space-2);
            border-radius: var(--radius-lg);
            color: var(--gray-700);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .enhanced-pagination .page-item .page-link:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        .enhanced-pagination .page-item.active .page-link {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }

        .enhanced-pagination .page-item.disabled .page-link {
            color: var(--gray-400);
            cursor: not-allowed;
        }

        /* Enhanced Empty State */
        .enhanced-empty-state {
            text-align: center;
            padding: var(--space-12);
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
            border-radius: var(--radius-2xl);
            border: 2px dashed var(--gray-200);
        }

        .enhanced-empty-state .empty-icon {
            position: relative;
            margin-bottom: var(--space-0);
            display: inline-block;
        }

        .enhanced-empty-state .empty-icon i {
            font-size: 4rem;
            color: var(--gray-400);
            position: relative;
            z-index: 2;
        }

        .icon-pulse {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            animation: iconPulse 2s ease-in-out infinite;
        }

        .enhanced-empty-state h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-3);
        }

        .enhanced-empty-state p {
            color: var(--gray-600);
            margin-bottom: var(--space-0);
            font-size: 1rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .empty-actions {
            display: flex;
            gap: var(--space-3);
            justify-content: center;
            flex-wrap: wrap;
        }

        .refresh-btn {
            background: transparent;
            color: var(--gray-600);
            border: 2px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .refresh-btn:hover {
            background: var(--gray-100);
            border-color: var(--gray-300);
            color: var(--gray-800);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .enhanced-header .header-content {
                flex-direction: column;
                gap: var(--space-4);
                text-align: center;
            }

            .header-stats {
                justify-content: center;
            }

            .filter-group {
                grid-template-columns: 1fr;
            }

            .filter-actions {
                flex-direction: column;
            }

            .enhanced-table {
                font-size: 0.875rem;
            }

            .enhanced-actions {
                flex-direction: column;
                gap: var(--space-1);
            }
        }

        @media (max-width: 480px) {
            .enhanced-header .header-title {
                font-size: 2rem;
            }

            .enhanced-header .header-subtitle {
                font-size: 1rem;
            }

            .header-stats {
                flex-direction: column;
                align-items: center;
            }

            .stat-item {
                min-width: 120px;
            }
        }

        .dashboard-actions {
            margin-bottom: var(--space-8);
        }

        /* ===== ENHANCED CONCERTS PAGE STYLES ===== */

        /* Concert-specific header styling */
        .concerts-header {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
        }

        /* Enhanced Concert Info */
        .concert-info.enhanced-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
        }

        .concert-title {
            font-weight: 700;
            color: var(--gray-900);
            font-size: 1.125rem;
            line-height: 1.3;
        }

        .concert-description {
            font-size: 0.875rem;
            color: var(--gray-600);
            line-height: 1.4;
            margin-bottom: var(--space-2);
        }

        .concert-meta {
            display: flex;
            gap: var(--space-3);
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: var(--space-1);
            font-size: 0.75rem;
            color: var(--gray-500);
            background: var(--gray-100);
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            font-weight: 500;
        }

        .meta-item i {
            color: var(--primary);
            font-size: 0.625rem;
        }

        /* Enhanced Date Display */
        .enhanced-date {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .date-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1rem;
            flex-shrink: 0;
        }

        .date-content {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .date-main {
            font-weight: 700;
            color: var(--gray-900);
            font-size: 1rem;
        }

        .date-year {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .time-display {
            display: flex;
            align-items: center;
            gap: var(--space-1);
            font-size: 0.75rem;
            color: var(--primary);
            font-weight: 600;
            background: rgba(59, 130, 246, 0.1);
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            margin-top: var(--space-1);
        }

        .time-display i {
            font-size: 0.625rem;
        }

        .no-date {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--gray-400);
            font-size: 0.875rem;
            font-style: italic;
        }

        .no-date i {
            font-size: 1rem;
        }

        /* Enhanced Venue Display */
        .venue-display {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .venue-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .venue-text {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .venue-name {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 0.875rem;
        }

        /* Enhanced Concert Status Badges */
        .status-badge.status-upcoming {
            background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
            color: var(--white);
        }

        .status-badge.status-completed {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: var(--white);
        }

        .status-badge.status-cancelled {
            background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
            color: var(--white);
        }

        /* Concert Row Hover Effects */
        .concert-row:hover {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.02) 0%, rgba(139, 92, 246, 0.05) 100%);
        }

        .concert-row:hover .date-icon {
            transform: scale(1.1);
            box-shadow: var(--shadow-lg);
        }

        .concert-row:hover .venue-icon {
            transform: scale(1.1);
            box-shadow: var(--shadow-lg);
        }

        /* Responsive Design for Concerts */
        @media (max-width: 768px) {
            .concert-meta {
                flex-direction: column;
                gap: var(--space-2);
            }

            .enhanced-date {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--space-2);
            }

            .venue-display {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--space-2);
            }
        }

        /* ===== ENHANCED SONGS PAGE STYLES ===== */

        /* Song-specific header styling */
        .songs-header {
            background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
        }

        /* Enhanced Song Info */
        .song-info.enhanced-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
        }

        .song-title {
            font-weight: 700;
            color: var(--gray-900);
            font-size: 1.125rem;
            line-height: 1.3;
        }

        .song-description {
            font-size: 0.875rem;
            color: var(--gray-600);
            line-height: 1.4;
            margin-bottom: var(--space-2);
        }

        .song-meta {
            display: flex;
            gap: var(--space-3);
            flex-wrap: wrap;
        }

        .song-meta .meta-item {
            display: flex;
            align-items: center;
            gap: var(--space-1);
            font-size: 0.75rem;
            color: var(--gray-500);
            background: var(--gray-100);
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            font-weight: 500;
        }

        .song-meta .meta-item i {
            color: var(--primary);
            font-size: 0.625rem;
        }

        /* Enhanced Composer Display */
        .composer-display {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .composer-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--accent) 0%, #4f46e5 100%);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .composer-text {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .composer-name {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 0.875rem;
        }

        .no-composer {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--gray-400);
            font-size: 0.875rem;
            font-style: italic;
        }

        .no-composer i {
            font-size: 1rem;
        }

        /* Enhanced Genre Badges */
        .genre-badge.genre-classical {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: var(--white);
        }

        .genre-badge.genre-gospel {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: var(--white);
        }

        .genre-badge.genre-folk {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: var(--white);
        }

        .genre-badge.genre-traditional {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: var(--white);
        }

        .genre-badge.genre-unknown {
            background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
            color: var(--white);
        }

        /* Enhanced Duration Display */
        .duration-display {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .duration-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .duration-text {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .duration-value {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 0.875rem;
        }

        .no-duration {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--gray-400);
            font-size: 0.875rem;
            font-style: italic;
        }

        .no-duration i {
            font-size: 1rem;
        }

        /* Song Row Hover Effects */
        .song-row:hover {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.02) 0%, rgba(236, 72, 153, 0.05) 100%);
        }

        .song-row:hover .composer-icon {
            transform: scale(1.1);
            box-shadow: var(--shadow-lg);
        }

        .song-row:hover .duration-icon {
            transform: scale(1.1);
            box-shadow: var(--shadow-lg);
        }

        /* Responsive Design for Songs */
        @media (max-width: 768px) {
            .song-meta {
                flex-direction: column;
                gap: var(--space-2);
            }

            .composer-display {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--space-2);
            }

            .duration-display {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--space-2);
            }
        }

        /* ===== ENHANCED MEMBERS SHOW PAGE STYLES ===== */

        /* Member show specific header styling */
        .member-show-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        /* Enhanced Member Details */
        .enhanced-details {
            margin-bottom: var(--space-8);
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: var(--space-0);
            margin-bottom: var(--space-8);
        }

        /* Enhanced Detail Cards */
        .detail-card.enhanced-card {
            background: var(--white);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .detail-card.enhanced-card:hover {
            box-shadow: var(--shadow-2xl);
            transform: translateY(-4px);
        }

        .detail-card.enhanced-card .card-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        .detail-card.enhanced-card .card-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 10% 90%, rgba(16, 185, 129, 0.02) 0%, transparent 50%),
                radial-gradient(circle at 90% 10%, rgba(16, 185, 129, 0.02) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .detail-card.enhanced-card:hover .card-pattern {
            opacity: 1;
        }

        .detail-card.enhanced-card .card-header {
            padding: var(--space-0);
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .detail-card.enhanced-card .card-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .detail-card.enhanced-card .card-title i {
            color: var(--primary);
            font-size: 1rem;
        }

        .header-badge {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            background: var(--primary);
            color: var(--white);
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius-lg);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            background: var(--success);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .detail-card.enhanced-card .card-content {
            padding: var(--space-0);
            position: relative;
            z-index: 2;
        }

        /* Enhanced Profile Photo */
        .profile-photo-container.enhanced-photo {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid var(--gray-200);
            margin: 0 auto var(--space-0);
            transition: all 0.3s ease;
        }

        .profile-photo-container.enhanced-photo:hover {
            transform: scale(1.05);
            border-color: var(--primary);
            box-shadow: var(--shadow-xl);
        }

        .profile-photo-container.enhanced-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(0, 0, 0, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .profile-photo-container.enhanced-photo:hover .photo-overlay {
            opacity: 1;
        }

        .photo-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--primary);
            color: var(--white);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            border: 3px solid var(--white);
            box-shadow: var(--shadow-md);
        }

        .profile-photo-placeholder.enhanced-placeholder {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gray-200) 0%, var(--gray-300) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-500);
            font-size: 3rem;
            border: 4px solid var(--gray-200);
            margin: 0 auto var(--space-0);
            transition: all 0.3s ease;
        }

        .profile-photo-placeholder.enhanced-placeholder:hover {
            background: linear-gradient(135deg, var(--gray-300) 0%, var(--gray-400) 100%);
            color: var(--gray-600);
            transform: scale(1.05);
        }

        .placeholder-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            filter: blur(15px);
            opacity: 0;
            animation: placeholderGlow 2s ease-in-out infinite;
        }

        /* Enhanced Info Grid */
        .enhanced-info-grid {
            display: grid;
            gap: var(--space-4);
        }

        .info-item.enhanced-item {
            display: flex;
            align-items: flex-start;
            gap: var(--space-4);
            padding: var(--space-4);
            background: var(--gray-50);
            border-radius: var(--radius-xl);
            border: 1px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .info-item.enhanced-item:hover {
            background: var(--white);
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
            transform: translateX(4px);
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1rem;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .info-item.enhanced-item:hover .info-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: var(--shadow-lg);
        }

        .info-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .info-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
            line-height: 1.4;
        }

        /* Enhanced Age Badge */
        .age-badge {
            display: inline-block;
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: var(--space-2);
        }

        /* Enhanced Date Display */
        .date-display {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .date-main {
            font-weight: 700;
            color: var(--gray-900);
            font-size: 1rem;
        }

        .date-ago {
            font-size: 0.75rem;
            color: var(--gray-500);
            font-style: italic;
        }

        /* Enhanced Action Section */
        .action-section.enhanced-actions {
            background: var(--white);
            border-radius: var(--radius-2xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            text-align: center;
        }

        .action-section.enhanced-actions .action-buttons {
            display: flex;
            gap: var(--space-4);
            justify-content: center;
            flex-wrap: wrap;
        }

        .action-section.enhanced-actions .action-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            border-radius: var(--radius-lg);
            padding: var(--space-3) var(--space-0);
            font-weight: 600;
        }

        .action-section.enhanced-actions .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .delete-btn:hover {
            background: var(--danger-dark);
            border-color: var(--danger-dark);
        }

        /* Responsive Design for Member Show */
        @media (max-width: 768px) {
            .details-grid {
                grid-template-columns: 1fr;
                gap: var(--space-4);
            }

            .enhanced-info-grid {
                gap: var(--space-3);
            }

            .info-item.enhanced-item {
                padding: var(--space-3);
                gap: var(--space-3);
            }

            .action-section.enhanced-actions .action-buttons {
                flex-direction: column;
                gap: var(--space-3);
            }
        }

        @media (max-width: 480px) {

            .profile-photo-container.enhanced-photo,
            .profile-photo-placeholder.enhanced-placeholder {
                width: 100px;
                height: 100px;
                font-size: 2.5rem;
            }

            .info-icon {
                width: 32px;
                height: 32px;
                font-size: 0.875rem;
            }
        }

        /* ===== ENHANCED MEMBERS CREATE PAGE STYLES ===== */

        /* Member create specific header styling */
        .member-create-header {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        /* ===== ENHANCED MEMBERS EDIT PAGE STYLES ===== */

        /* Member edit specific header styling */
        .member-edit-header {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }

        /* ===== ENHANCED MEMBERS CERTIFICATE PAGE STYLES ===== */

        /* Member certificate specific header styling */
        .member-certificate-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        /* ===== CONTRIBUTION CAMPAIGNS PAGE STYLES ===== */

        /* Unified Progress Bar Styles - Overrides all previous progress-fill definitions */
        .progress-fill {
            height: 100% !important;
            background: linear-gradient(90deg, var(--success) 0%, var(--success-light) 100%) !important;
            border-radius: var(--radius-full) !important;
            transition: width 0.8s ease-in-out !important;
            width: 0% !important;
            position: relative !important;
            overflow: hidden !important;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3) !important;
        }

        .progress-fill.animated {
            width: var(--progress-width, 0%) !important;
        }



        /* Year Plan Link Styles */
        .year-plan-link {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-3);
            background: var(--primary-light);
            color: var(--white);
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: var(--space-3);
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
        }

        .year-plan-link:hover {
            background: var(--primary);
            color: var(--white);
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .year-plan-link i {
            font-size: 0.75rem;
        }

        /* Amount Display Styles */
        .amount-section {
            background: linear-gradient(135deg, var(--success-light, #d1fae5) 0%, var(--success, #10b981) 100%);
            border-radius: var(--radius-lg);
            padding: var(--space-4);
            margin: var(--space-4) 0;
            text-align: center;
            color: var(--white);
            box-shadow: var(--shadow-md);
        }

        .amount-display {
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
        }

        .amount-label {
            font-size: 0.875rem;
            opacity: 0.9;
            font-weight: 500;
        }

        .amount-value {
            font-size: 1.5rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Progress Section Enhancements */
        .progress-section {
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            padding: var(--space-4);
            margin: var(--space-4) 0;
            border: 1px solid var(--gray-200);
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-3);
        }

        .progress-label {
            font-weight: 600;
            color: var(--gray-700);
        }

        .progress-percentage {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.125rem;
        }

        .progress-amounts {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: var(--space-3);
            font-size: 0.875rem;
        }

        .raised-amount {
            color: var(--success);
            font-weight: 600;
        }

        .target-amount {
            color: var(--gray-600);
        }

        .remaining-amount {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: var(--space-2);
            padding-top: var(--space-2);
            border-top: 1px solid var(--gray-200);
            font-size: 0.875rem;
        }

        .remaining-label {
            color: var(--gray-600);
            font-weight: 500;
        }

        .remaining-value {
            color: var(--warning);
            font-weight: 700;
        }

        /* Progress Bar Styling */
        .progress-bar.enhanced-progress {
            width: 100%;
            height: 12px;
            background: var(--gray-200);
            border-radius: 9999px;
            overflow: hidden;
            margin: var(--space-3) 0;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }





        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        /* Time Display Styling */
        .time-display {
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .time-text {
            font-family: 'Courier New', monospace;
            letter-spacing: 0.5px;
        }

        /* Campaign Stats Enhancements */
        .campaign-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: var(--space-3);
            margin: var(--space-4) 0;
        }

        .campaign-stats .stat-item {
            text-align: center;
            padding: var(--space-3);
            background: var(--gray-50);
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
        }

        .campaign-stats .stat-label {
            display: block;
            font-size: 0.75rem;
            color: var(--gray-600);
            margin-bottom: var(--space-1);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .campaign-stats .stat-value {
            display: block;
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        /* Campaign Card Enhancements */
        .campaign-card {
            transition: all 0.3s ease;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-xl);
            overflow: hidden;
        }

        .campaign-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary-light);
        }

        .campaign-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: var(--space-4);
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
            border-bottom: 1px solid var(--gray-200);
        }

        .campaign-body {
            padding: var(--space-4);
        }

        .campaign-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-3);
            line-height: 1.3;
        }

        .campaign-description {
            color: var(--gray-600);
            margin-bottom: var(--space-3);
            line-height: 1.5;
        }

        .campaign-dates {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--space-3);
            margin: var(--space-4) 0;
        }

        .date-item {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .date-label {
            font-size: 0.75rem;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .date-value {
            font-weight: 600;
            color: var(--gray-700);
        }



        /* Summary Cards for Contribution Campaigns */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-6);
            margin-bottom: var(--space-8);
        }

        .summary-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-6);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .summary-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--white);
            flex-shrink: 0;
        }

        .total-campaigns .summary-icon {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        }

        .total-raised .summary-icon {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%);
        }

        .active-campaigns .summary-icon {
            background: linear-gradient(135deg, var(--warning) 0%, var(--warning-light) 100%);
        }

        .completed-campaigns .summary-icon {
            background: linear-gradient(135deg, var(--info) 0%, var(--info-light) 100%);
        }

        .summary-content {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .summary-number {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1.2;
        }

        .summary-label {
            font-size: 0.875rem;
            color: var(--gray-600);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .total-raised .summary-number {
            color: var(--success);
        }

        /* Responsive Summary Cards */
        @media (max-width: 768px) {
            .summary-cards {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: var(--space-4);
            }

            .summary-card {
                padding: var(--space-4);
            }

            .summary-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }

            .summary-number {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .summary-cards {
                grid-template-columns: 1fr;
            }
        }

        /* Header Stats Enhancements for Contribution Campaigns */
        .enhanced-header .header-stats .stat-item:last-child .stat-number {
            color: var(--success);
            font-weight: 700;
            font-size: 1.25rem;
        }

        .enhanced-header .header-stats .stat-item:last-child .stat-label {
            color: var(--success-light);
            font-weight: 600;
        }

        /* Certificate Actions */
        .certificate-actions.enhanced-actions {
            background: var(--white);
            border-radius: var(--radius-2xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            text-align: center;
            margin: var(--space-0) 0;
        }

        .certificate-actions.enhanced-actions .action-buttons {
            display: flex;
            gap: var(--space-4);
            justify-content: center;
            flex-wrap: wrap;
        }

        .print-btn,
        .download-btn,
        .share-btn {
            position: relative;
            overflow: hidden;
            border: none;
            padding: var(--space-3) var(--space-0);
            border-radius: var(--radius-lg);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: var(--space-2);
            min-width: 160px;
            justify-content: center;
        }

        .print-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
        }

        .print-btn .btn-content,
        .print-btn .btn-content i,
        .print-btn .btn-content span {
            color: var(--white) !important;
        }

        .download-btn {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
            color: var(--white);
        }

        .download-btn .btn-content,
        .download-btn .btn-content i,
        .download-btn .btn-content span {
            color: var(--white) !important;
        }

        .share-btn {
            background: linear-gradient(135deg, var(--info) 0%, var(--info-dark) 100%);
            color: var(--white);
        }

        .share-btn .btn-content,
        .share-btn .btn-content i,
        .share-btn .btn-content span {
            color: var(--white) !important;
        }

        .print-btn:hover,
        .download-btn:hover,
        .share-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .print-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Enhanced Button Visibility and Styling */
        .certificate-actions .btn,
        .certificate-actions .print-btn,
        .certificate-actions .download-btn,
        .certificate-actions .share-btn {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            text-decoration: none;
            border: none;
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .certificate-actions .download-btn {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }

        .certificate-actions .share-btn {
            background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
            box-shadow: 0 8px 25px rgba(23, 162, 184, 0.3);
        }

        .certificate-actions .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }

        .certificate-actions .download-btn:hover {
            box-shadow: 0 12px 35px rgba(40, 167, 69, 0.4);
        }

        .certificate-actions .share-btn:hover {
            box-shadow: 0 12px 35px rgba(23, 162, 184, 0.4);
        }

        .certificate-actions .btn .btn-content,
        .certificate-actions .btn .btn-content i,
        .certificate-actions .btn .btn-content span {
            color: white;
            position: relative;
            z-index: 2;
        }

        .certificate-actions .btn .btn-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.2));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .certificate-actions .btn:hover .btn-glow {
            opacity: 1;
        }

        /* Zoom Controls */
        .zoom-controls {
            display: flex;
            gap: var(--space-2);
            align-items: center;
        }

        .zoom-btn {
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: var(--radius-md);
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .zoom-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .zoom-btn:disabled {
            background: var(--gray-400);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .zoom-btn.zoom-in {
            background: var(--success);
        }

        .zoom-btn.zoom-in:hover {
            background: var(--success-dark);
        }

        .zoom-btn.zoom-out {
            background: var(--warning);
        }

        .zoom-btn.zoom-out:hover {
            background: var(--warning-dark);
        }

        .zoom-btn.zoom-reset {
            background: var(--info);
        }

        .zoom-btn.zoom-reset:hover {
            background: var(--info-dark);
        }

        /* Enhanced Certificate Component Styling */
        .certificate-wrapper .certificate-container {
            position: relative;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border: 3px solid #d4af37;
            border-radius: 20px;
            padding: 40px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            font-family: 'Georgia', serif;
            color: #2c3e50;
            overflow: hidden;
        }

        /* Musical Staff Background */
        .certificate-wrapper .musical-staff-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.05;
            z-index: 1;
        }

        .certificate-wrapper .staff-lines {
            position: absolute;
            top: 20%;
            left: 0;
            right: 0;
            height: 60%;
            background-image: repeating-linear-gradient(transparent,
                    transparent 19px,
                    #000 19px,
                    #000 21px);
        }

        .certificate-wrapper .musical-notes {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .certificate-wrapper .note {
            position: absolute;
            font-size: 2rem;
            color: #d4af37;
            animation: float 6s ease-in-out infinite;
        }

        .certificate-wrapper .note-1 {
            top: 15%;
            left: 10%;
            animation-delay: 0s;
        }

        .certificate-wrapper .note-2 {
            top: 25%;
            right: 15%;
            animation-delay: 1.5s;
        }

        .certificate-wrapper .note-3 {
            bottom: 25%;
            left: 15%;
            animation-delay: 3s;
        }

        .certificate-wrapper .note-4 {
            bottom: 15%;
            right: 10%;
            animation-delay: 4.5s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) rotate(5deg);
            }
        }

        /* Certificate Content */
        .certificate-wrapper .certificate-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        /* Header Section */
        .certificate-wrapper .certificate-header-section {
            margin-bottom: 30px;
            border-bottom: 2px solid #d4af37;
            padding-bottom: 20px;
        }

        .certificate-wrapper .main-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2c3e50;
            margin: 0 0 10px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: 3px;
        }

        .certificate-wrapper .subtitle {
            font-size: 1.8rem;
            color: #d4af37;
            margin: 0 0 15px 0;
            font-weight: 600;
            letter-spacing: 2px;
        }

        .certificate-wrapper .presenter-line {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin: 0;
            font-style: italic;
            letter-spacing: 1px;
        }

        /* Member Name Section */
        .certificate-wrapper .member-name-section {
            margin: 40px 0;
            padding: 20px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(212, 175, 55, 0.05) 100%);
            border-radius: 15px;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        .certificate-wrapper .member-name {
            font-size: 2.2rem;
            color: #2c3e50;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Scripture Section */
        .certificate-wrapper .scripture-section {
            margin: 30px 0;
            padding: 25px;
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.05) 0%, rgba(52, 152, 219, 0.02) 100%);
            border-left: 4px solid #3498db;
            border-radius: 10px;
        }

        .certificate-wrapper .verse-text {
            font-size: 1.1rem;
            font-style: italic;
            color: #2c3e50;
            margin: 0 0 10px 0;
            line-height: 1.6;
            letter-spacing: 1px;
        }

        .certificate-wrapper .verse-reference {
            font-size: 0.9rem;
            color: #3498db;
            margin: 0;
            font-weight: 600;
            letter-spacing: 1px;
        }

        /* Appreciation Section */
        .certificate-wrapper .appreciation-section {
            margin: 30px 0;
            padding: 20px;
            background: linear-gradient(135deg, rgba(231, 76, 60, 0.05) 0%, rgba(231, 76, 60, 0.02) 100%);
            border-radius: 10px;
            border: 1px solid rgba(231, 76, 60, 0.2);
        }

        .certificate-wrapper .appreciation-text {
            font-size: 1rem;
            color: #2c3e50;
            margin: 0;
            line-height: 1.7;
            letter-spacing: 0.5px;
        }

        /* Member Details Section */
        .certificate-wrapper .member-details-section {
            margin: 30px 0;
            padding: 20px;
            background: linear-gradient(135deg, rgba(46, 204, 113, 0.05) 0%, rgba(46, 204, 113, 0.02) 100%);
            border-radius: 10px;
            border: 1px solid rgba(46, 204, 113, 0.3);
        }

        .certificate-wrapper .member-info {
            font-size: 1.1rem;
            color: #2c3e50;
            margin: 0;
            font-weight: 600;
            letter-spacing: 1px;
        }

        /* Signature Section */
        .certificate-wrapper .signature-section {
            display: flex;
            justify-content: space-around;
            margin: 40px 0 20px 0;
            gap: 40px;
        }

        .certificate-wrapper .signature-line {
            flex: 1;
            text-align: center;
        }

        .certificate-wrapper .signature-line .line {
            height: 2px;
            background: #2c3e50;
            margin-bottom: 10px;
            border-radius: 1px;
        }

        .certificate-wrapper .signature-line .label {
            font-size: 0.8rem;
            color: #7f8c8d;
            font-weight: 600;
            letter-spacing: 1px;
        }

        /* Certificate Number */
        .certificate-wrapper .certificate-number {
            position: absolute;
            bottom: 15px;
            right: 20px;
            font-size: 0.8rem;
            color: #7f8c8d;
            font-weight: 600;
            letter-spacing: 1px;
        }

        /* Print Styles for Certificate */
        @media print {
            .certificate-wrapper .certificate-container {
                border: 2px solid #000 !important;
                box-shadow: none !important;
                margin: 0 !important;
                page-break-inside: avoid;
                background: white !important;
            }

            .certificate-wrapper .musical-staff-bg {
                opacity: 0.1 !important;
            }

            .certificate-wrapper .note {
                animation: none !important;
            }

            .page-header,
            .certificate-actions,
            .print-instructions,
            .certificate-header,
            .certificate-footer {
                display: none !important;
            }
        }

        /* Responsive Certificate Design */
        @media (max-width: 768px) {
            .certificate-wrapper .certificate-container {
                padding: 20px;
                margin: 10px;
                max-width: 100%;
            }

            .certificate-wrapper .main-title {
                font-size: 1.8rem;
                letter-spacing: 2px;
            }

            .certificate-wrapper .subtitle {
                font-size: 1.3rem;
                letter-spacing: 1px;
            }

            .certificate-wrapper .member-name {
                font-size: 1.6rem;
                letter-spacing: 2px;
            }

            .certificate-wrapper .verse-text {
                font-size: 0.95rem;
            }

            .certificate-wrapper .signature-section {
                flex-direction: column;
                gap: 20px;
            }
        }

        /* Certificate Container */
        .certificate-container.enhanced-card {
            background: var(--white);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            margin: var(--space-0) 0;
            overflow: hidden;
        }

        .certificate-header {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
            padding: var(--space-0);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: var(--space-4);
        }

        .certificate-title {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .certificate-title i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .certificate-title h3 {
            margin: 0;
            color: var(--gray-900);
            font-size: 1.25rem;
            font-weight: 700;
        }

        .certificate-meta {
            display: flex;
            gap: var(--space-4);
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .meta-item i {
            color: var(--primary);
            font-size: 0.875rem;
        }

        /* Zoom Controls */
        .zoom-controls {
            display: flex;
            gap: var(--space-2);
        }

        .zoom-btn {
            width: 40px;
            height: 40px;
            border: 1px solid var(--gray-300);
            background: var(--white);
            color: var(--gray-700);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .zoom-btn:hover:not(:disabled) {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
            transform: scale(1.05);
        }

        .zoom-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Certificate Wrapper */
        .certificate-wrapper.enhanced-wrapper {
            padding: var(--space-8);
            background: var(--gray-50);
            min-height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 0.3s ease;
            transform-origin: center center;
        }

        .certificate-content {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            padding: var(--space-0);
            max-width: 100%;
            overflow: auto;
        }

        /* Certificate Footer */
        .certificate-footer {
            background: var(--gray-50);
            padding: var(--space-4) var(--space-0);
            border-top: 1px solid var(--gray-200);
        }

        .footer-info {
            text-align: center;
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .footer-info p {
            margin: var(--space-1) 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
        }

        .footer-info i {
            color: var(--primary);
            font-size: 0.875rem;
        }

        /* Print Instructions */
        .print-instructions.enhanced-card {
            background: var(--white);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            margin: var(--space-0) 0;
            overflow: hidden;
        }

        .instructions-header {
            background: linear-gradient(135deg, var(--warning) 0%, var(--warning-dark) 100%);
            color: var(--white);
            padding: var(--space-4) var(--space-0);
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .instructions-header i {
            font-size: 1.25rem;
        }

        .instructions-header h4 {
            margin: 0;
            font-size: 1.125rem;
            font-weight: 600;
        }

        .instructions-content {
            padding: var(--space-0);
        }

        .tips-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: var(--space-3);
        }

        .tips-list li {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3);
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            border-left: 4px solid var(--warning);
            transition: all 0.3s ease;
        }

        .tips-list li:hover {
            background: var(--white);
            box-shadow: var(--shadow-md);
            transform: translateX(4px);
        }

        .tips-list i {
            color: var(--success);
            font-size: 1rem;
            min-width: 20px;
        }

        /* Toast Notifications */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            padding: var(--space-4);
            border-left: 4px solid var(--primary);
            z-index: 9999;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 350px;
            border: 1px solid var(--gray-200);
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast.toast-success {
            border-left-color: var(--success);
        }

        .toast.toast-error {
            border-left-color: var(--danger);
        }

        .toast.toast-info {
            border-left-color: var(--info);
        }

        .toast-content {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            margin-bottom: var(--space-3);
        }

        .toast-content i {
            font-size: 1.25rem;
        }

        .toast.toast-success .toast-content i {
            color: var(--success);
        }

        .toast.toast-error .toast-content i {
            color: var(--danger);
        }

        .toast.toast-info .toast-content i {
            color: var(--info);
        }

        .toast-content span {
            color: var(--gray-900);
            font-weight: 500;
        }

        .toast-close {
            position: absolute;
            top: var(--space-2);
            right: var(--space-2);
            background: none;
            border: none;
            color: var(--gray-400);
            cursor: pointer;
            padding: var(--space-1);
            border-radius: var(--radius);
            transition: all 0.3s ease;
        }

        .toast-close:hover {
            color: var(--gray-600);
            background: var(--gray-100);
        }

        /* Responsive Design for Certificate Page */
        @media (max-width: 768px) {
            .certificate-header {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--space-3);
            }

            .certificate-meta {
                justify-content: flex-start;
            }

            .certificate-actions.enhanced-actions .action-buttons {
                flex-direction: column;
                gap: var(--space-3);
            }

            .print-btn,
            .download-btn,
            .share-btn {
                min-width: auto;
                width: 100%;
            }

            .zoom-controls {
                order: -1;
                width: 100%;
                justify-content: center;
            }

            .certificate-wrapper.enhanced-wrapper {
                padding: var(--space-4);
            }
        }

        @media (max-width: 480px) {
            .certificate-meta {
                flex-direction: column;
                gap: var(--space-2);
            }

            .meta-item {
                font-size: 0.75rem;
            }

            .tips-list li {
                font-size: 0.875rem;
                padding: var(--space-2);
            }
        }

        /* Enhanced Form Styles */
        .enhanced-form {
            position: relative;
        }

        .enhanced-form-grid {
            display: grid;
            gap: var(--space-8);
        }

        .form-section {
            background: var(--white);
            border-radius: var(--radius-2xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .form-section:hover {
            box-shadow: var(--shadow-xl);
            transform: translateY(-2px);
        }

        .section-header {
            text-align: center;
            margin-bottom: var(--space-0);
            position: relative;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            border-radius: var(--radius);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-3);
        }

        .section-title i {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .section-subtitle {
            color: var(--gray-600);
            font-size: 1rem;
            max-width: 400px;
            margin: 0 auto;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-4);
            margin-bottom: var(--space-4);
        }

        .form-group.enhanced-group {
            position: relative;
            margin-bottom: var(--space-4);
        }

        .form-group.enhanced-group .form-input.enhanced-input,
        .form-group.enhanced-group .form-select.enhanced-select,
        .form-group.enhanced-group .form-textarea.enhanced-textarea {
            position: relative;
            z-index: 2;
        }

        .form-group.enhanced-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label.enhanced-label {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: var(--space-2);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-label.enhanced-label i {
            color: var(--primary);
            font-size: 0.875rem;
        }

        /* Enhanced Input Styles */
        .form-input.enhanced-input {
            width: 100%;
            padding: var(--space-3) var(--space-4);
            border-radius: var(--radius-xl);
            background: var(--white);
            color: var(--gray-900);
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .form-input.enhanced-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        .form-input.enhanced-input:hover {
            border-color: var(--gray-300);
        }

        .form-input.enhanced-input::placeholder {
            color: var(--gray-400);
        }

        .input-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(59, 130, 246, 0.02) 100%);
            border-radius: inherit;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: 1;
        }

        .form-input.enhanced-input:focus+.input-glow {
            opacity: 1;
        }

        .enhanced-input-group .input-glow {
            border-radius: var(--radius-xl);
        }

        /* Enhanced Select Styles */
        .form-select.enhanced-select {
            width: 100%;
            padding: var(--space-3) var(--space-4);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-xl);
            background: var(--white);
            color: var(--gray-900);
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        .form-select.enhanced-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        .form-select.enhanced-select:hover {
            border-color: var(--gray-300);
        }

        .select-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(59, 130, 246, 0.02) 100%);
            border-radius: inherit;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .form-select.enhanced-select:focus+.select-glow {
            opacity: 1;
        }

        /* Enhanced Textarea Styles */
        .form-textarea.enhanced-textarea {
            width: 100%;
            padding: var(--space-3) var(--space-4);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-xl);
            background: var(--white);
            color: var(--gray-900);
            font-size: 1rem;
            resize: vertical;
            min-height: 100px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-textarea.enhanced-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        .form-textarea.enhanced-textarea:hover {
            border-color: var(--gray-300);
        }

        .form-textarea.enhanced-textarea::placeholder {
            color: var(--gray-400);
        }

        .textarea-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(59, 130, 246, 0.02) 100%);
            border-radius: inherit;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .form-textarea.enhanced-textarea:focus+.textarea-glow {
            opacity: 1;
        }

        /* Enhanced File Upload */
        .file-upload-container.enhanced-upload {
            position: relative;
            border: 2px dashed var(--gray-300);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            text-align: center;
            transition: all 0.3s ease;
            background: var(--gray-50);
            cursor: pointer;
        }

        .file-upload-container.enhanced-upload:hover {
            border-color: var(--primary);
            background: rgba(59, 130, 246, 0.05);
        }

        .file-upload-container.enhanced-upload.dragover {
            border-color: var(--primary);
            background: rgba(59, 130, 246, 0.1);
            transform: scale(1.02);
        }

        .file-input.enhanced-file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--space-2);
            color: var(--gray-600);
        }

        .upload-placeholder i {
            font-size: 1rem;
            color: var(--primary);
            margin-bottom: var(--space-2);
        }

        .upload-placeholder span {
            font-size: 0.75rem;
            font-weight: 600;
        }

        .upload-placeholder small {
            font-size: 0.625rem;
            color: var(--gray-500);
        }

        .upload-preview {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .upload-preview img {
            max-width: 200px;
            max-height: 200px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
        }

        .remove-file {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 32px;
            height: 32px;
            background: var(--danger);
            color: var(--white);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
        }

        .remove-file:hover {
            background: var(--danger-dark);
            transform: scale(1.1);
        }

        /* Enhanced Checkbox Styles - More Specific to Override Conflicts */
        .form-group .checkbox-group.enhanced-checkbox {
            display: flex !important;
            align-items: center !important;
            gap: var(--space-3) !important;
            padding: var(--space-3) !important;
            background: var(--gray-50) !important;
            border-radius: var(--radius-lg) !important;
            border: 1px solid var(--gray-200) !important;
            transition: all 0.3s ease !important;
        }

        .form-group .checkbox-group.enhanced-checkbox:hover {
            background: var(--white) !important;
            border-color: var(--primary) !important;
            box-shadow: var(--shadow-md) !important;
        }

        .form-group .enhanced-checkbox-input {
            display: none !important;
        }

        .form-group .checkbox-label.enhanced-label {
            display: flex !important;
            align-items: center !important;
            gap: var(--space-3) !important;
            cursor: pointer !important;
            font-weight: 600 !important;
            color: var(--gray-700) !important;
        }

        .form-group .checkbox-custom {
            width: 20px !important;
            height: 20px !important;
            border: 2px solid var(--gray-300) !important;
            border-radius: var(--radius) !important;
            background: var(--white) !important;
            transition: all 0.3s ease !important;
            position: relative !important;
        }

        .form-group .enhanced-checkbox-input:checked+.checkbox-label .checkbox-custom {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        .form-group .enhanced-checkbox-input:checked+.checkbox-label .checkbox-custom::after {
            content: '✓' !important;
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            color: var(--white) !important;
            font-size: 0.75rem !important;
            font-weight: bold !important;
        }

        /* Hover effects for checkbox */
        .form-group .checkbox-group.enhanced-checkbox:hover .checkbox-custom {
            border-color: var(--primary) !important;
            transform: scale(1.05) !important;
        }

        .form-group .enhanced-checkbox-input:focus+.checkbox-label .checkbox-custom {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(23, 52, 120, 0.1) !important;
        }

        /* Enhanced Error Messages */
        .error-message.enhanced-error {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--danger);
            font-size: 0.875rem;
            margin-top: var(--space-2);
            padding: var(--space-2) var(--space-3);
            background: rgba(239, 68, 68, 0.1);
            border-radius: var(--radius);
            border-left: 3px solid var(--danger);
        }

        .form-error.enhanced-error {
            background: var(--danger);
            color: var(--white);
            padding: var(--space-4);
            border-radius: var(--radius-lg);
            margin-bottom: var(--space-0);
            text-align: center;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
        }

        /* Enhanced Form Actions */
        .form-actions.enhanced-actions {
            background: var(--white);
            border-radius: var(--radius-2xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            text-align: center;
        }

        .form-actions.enhanced-actions .action-buttons {
            display: flex;
            gap: var(--space-4);
            justify-content: center;
            flex-wrap: wrap;
        }

        .submit-btn {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            color: var(--white);
            padding: var(--space-3) var(--space-0);
            border-radius: var(--radius-lg);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .submit-btn .btn-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            filter: blur(15px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .submit-btn:hover .btn-glow {
            opacity: 0.6;
        }

        /* Form Validation States */
        .form-input.enhanced-input.error,
        .form-select.enhanced-select.error,
        .form-textarea.enhanced-textarea.error {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        /* Responsive Design for Member Create */
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: var(--space-3);
            }

            .form-section {
                padding: var(--space-4);
            }

            .section-title {
                font-size: 1.25rem;
            }

            .form-actions.enhanced-actions .action-buttons {
                flex-direction: column;
                gap: var(--space-3);
            }
        }

        @media (max-width: 480px) {
            .upload-placeholder i {
                font-size: 1.5rem;
            }

            .upload-placeholder span {
                font-size: 0.75rem;
            }

            .upload-placeholder small {
                font-size: 0.625rem;
            }
        }

        .actions-header {
            text-align: center;
            margin-bottom: var(--space-0);
        }

        .actions-header h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
        }

        .actions-header p {
            color: var(--gray-600);
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-0);
        }

        .action-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            text-decoration: none;
            color: inherit;
            transition: all var(--transition);
            text-align: center;
        }

        .action-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary);
        }

        .action-icon {
            width: 48px;
            height: 48px;
            background: var(--primary);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto var(--space-4);
            font-size: 1.25rem;
            color: var(--white);
        }

        .action-card h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
        }

        .action-card p {
            font-size: 0.75rem;
            color: var(--gray-600);
        }

        .dashboard-overview {
            margin-bottom: var(--space-8);
        }

        .overview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: var(--space-0);
        }

        .overview-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }

        .overview-card .card-header {
            padding: var(--space-4) var(--space-0);
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .overview-card .card-header h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .view-all {
            font-size: 0.75rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .view-all:hover {
            text-decoration: underline;
        }

        .overview-card .card-content {
            padding: var(--space-0);
        }

        /* ===== ENHANCED PRACTICE SESSION STYLES ===== */
        .practice-session-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            margin-bottom: var(--space-4);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }

        .practice-session-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            transform: scaleY(0);
            transition: transform var(--transition);
        }

        .practice-session-card:hover::before {
            transform: scaleY(1);
        }

        .practice-session-card:hover {
            transform: translateX(8px);
            box-shadow: var(--shadow-xl);
        }

        .session-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: var(--space-4);
        }

        .session-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
        }

        .session-status {
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.625rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .session-status.scheduled {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
        }

        .session-status.in_progress {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .session-status.completed {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .session-status.cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }

        .session-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-4);
            margin-bottom: var(--space-4);
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--gray-600);
            font-size: 0.75rem;
        }

        .detail-item i {
            color: var(--primary);
            width: 16px;
            text-align: center;
        }

        /* ===== MEMBERS SPECIFIC STYLES ===== */
        .member-photo {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
        }

        .member-photo-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f3f4f6;
            border: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
        }

        .member-photo-placeholder i {
            font-size: 16px;
        }

        .member-info .member-name {
            font-weight: 600;
            color: var(--gray-900);
        }

        .member-info .member-phone {
            font-size: 0.75rem;
            color: var(--gray-600);
            margin-top: var(--space-1);
        }

        .type-badge,
        .voice-badge,
        .status-badge {
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.625rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .type-singer {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
        }

        .type-general {
            background: rgba(107, 114, 128, 0.1);
            color: var(--gray-600);
        }

        .voice-soprano {
            background: rgba(236, 72, 153, 0.1);
            color: #ec4899;
        }

        .voice-alto {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .voice-tenor {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .voice-bass {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
        }

        .status-badge.active {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .status-badge.inactive {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }

        .no-voice {
            color: var(--gray-500);
            font-style: italic;
        }

        /* ===== ENHANCED CONTRIBUTION CAMPAIGN STYLES ===== */
        .campaign-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            margin-bottom: var(--space-4);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }

        .campaign-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 40px 40px 0;
            border-color: transparent var(--primary) transparent transparent;
            opacity: 0;
            transition: opacity var(--transition);
        }

        .campaign-card:hover::after {
            opacity: 1;
        }

        .campaign-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .campaign-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: var(--space-4);
        }

        .campaign-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
        }

        .campaign-goal {
            background: var(--gray-50);
            padding: var(--space-3) var(--space-4);
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            text-align: center;
        }

        .goal-amount {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            display: block;
        }

        .goal-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .campaign-progress {
            margin: var(--space-4) 0;
        }

        .progress-bar {
            height: 8px;
            background: var(--gray-200);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin-bottom: var(--space-2);
        }





        .progress-stats {
            display: flex;
            justify-content: space-between;
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        /* ===== CONCERTS SPECIFIC STYLES ===== */
        .concert-info .concert-title {
            font-weight: 600;
            color: var(--gray-900);
        }

        .concert-info .concert-description {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-top: var(--space-1);
        }

        .date-info .date {
            font-weight: 600;
            color: var(--gray-900);
        }

        .date-info .time {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-top: var(--space-1);
        }

        /* ===== ENHANCED USER MANAGEMENT STYLES ===== */
        .user-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            margin-bottom: var(--space-4);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }

        .user-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(59, 130, 246, 0.02) 100%);
            opacity: 0;
            transition: opacity var(--transition);
        }

        .user-card:hover::before {
            opacity: 1;
        }

        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .user-header {
            display: flex;
            align-items: center;
            gap: var(--space-4);
            margin-bottom: var(--space-4);
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.5rem;
            border: 3px solid var(--white);
            box-shadow: var(--shadow-md);
        }


        /* ===== ENHANCED MEDIA SPECIFIC STYLES ===== */
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
            margin-bottom: var(--space-0);
        }

        .media-card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .media-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transform: translateY(-4px);
        }

        .media-card.modern-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(226, 232, 240, 0.8);
            backdrop-filter: blur(10px);
        }

        .media-card.modern-card:hover {
            background: linear-gradient(145deg, #ffffff 0%, #f1f5f9 100%);
            border-color: rgba(59, 130, 246, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(59, 130, 246, 0.1);
        }

        .media-preview {
            position: relative;
            height: 220px;
            overflow: hidden;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 12px 12px 0 0;
        }

        .media-preview.enhanced-preview {
            height: 240px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            position: relative;
        }

        .preview-container {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .media-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .media-image.enhanced-image {
            filter: brightness(1) contrast(1.05);
        }

        .media-image:hover {
            transform: scale(1.08);
            filter: brightness(1.1) contrast(1.1);
            cursor: pointer;
        }

        .media-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            background: #000;
        }

        .media-video.enhanced-video {
            border-radius: 8px;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .media-card:hover .video-overlay {
            opacity: 1;
        }

        .play-button {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #3b82f6;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .play-button:hover {
            background: white;
            transform: scale(1.1);
        }

        .audio-container {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }

        .audio-visualizer {
            display: flex;
            align-items: end;
            gap: 4px;
            margin-bottom: 20px;
            height: 40px;
        }

        .visualizer-bar {
            width: 6px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 3px;
            animation: audioWave 1.5s ease-in-out infinite;
        }

        .visualizer-bar:nth-child(1) {
            height: 20px;
            animation-delay: 0s;
        }

        .visualizer-bar:nth-child(2) {
            height: 35px;
            animation-delay: 0.2s;
        }

        .visualizer-bar:nth-child(3) {
            height: 25px;
            animation-delay: 0.4s;
        }

        .visualizer-bar:nth-child(4) {
            height: 40px;
            animation-delay: 0.6s;
        }

        .visualizer-bar:nth-child(5) {
            height: 30px;
            animation-delay: 0.8s;
        }

        @keyframes audioWave {

            0%,
            100% {
                transform: scaleY(0.5);
            }

            50% {
                transform: scaleY(1);
            }
        }

        .media-audio {
            width: 100%;
            max-width: 200px;
        }

        .media-audio.enhanced-audio {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 8px;
        }

        .media-card[data-type="photo"] {
            position: relative;
            cursor: pointer;
        }

        .media-card[data-type="photo"]::after {
            content: 'Click to view';
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            opacity: 0;
            transition: opacity var(--transition);
            pointer-events: none;
        }

        .media-card[data-type="photo"]:hover::after {
            opacity: 1;
        }

        .media-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity var(--transition);
        }

        .media-overlay.enhanced-overlay {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.7) 100%);
            backdrop-filter: blur(4px);
        }

        .media-card:hover .media-overlay {
            opacity: 1;
        }

        .overlay-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .quick-actions {
            display: flex;
            gap: 8px;
        }

        .quick-action-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: none;
            background: rgba(255, 255, 255, 0.9);
            color: #374151;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .quick-action-btn:hover {
            background: white;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .quick-action-btn.view-btn:hover {
            color: #3b82f6;
        }

        .quick-action-btn.fullscreen-btn:hover {
            color: #10b981;
        }

        .quick-action-btn.download-btn:hover {
            color: #f59e0b;
        }

        /* Media Type Badge */
        .media-type-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .media-type-badge.type-photo {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .media-type-badge.type-video {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        .media-type-badge.type-audio {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        /* Featured Badge */
        .featured-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
            animation: featuredPulse 2s ease-in-out infinite;
        }

        @keyframes featuredPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .overlay-actions {
            display: flex;
            gap: var(--space-2);
        }

        .click-hint {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 6px;
            opacity: 0;
            transition: opacity var(--transition);
        }

        .media-card:hover .click-hint {
            opacity: 1;
        }

        .video-preview,
        .audio-preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            background: var(--gray-100);
            color: var(--gray-600);
            gap: var(--space-2);
        }

        .video-preview i,
        .audio-preview i {
            font-size: 2rem;
        }

        .media-info {
            padding: var(--space-4);
        }

        .media-info.enhanced-info {
            padding: 20px;
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .info-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .media-title.enhanced-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
            line-height: 1.4;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            word-break: break-word;
        }

        .media-meta {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
        }

        .file-size {
            font-size: 0.75rem;
            color: #6b7280;
            background: #f3f4f6;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: 500;
        }

        .media-description.enhanced-description {
            color: #6b7280;
            font-size: 0.875rem;
            line-height: 1.5;
            margin: 0 0 12px 0;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
        }

        .media-details {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-shrink: 0;
        }

        .media-concert.enhanced-concert,
        .media-date.enhanced-date {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .media-concert.enhanced-concert i,
        .media-date.enhanced-date i {
            color: #3b82f6;
            width: 16px;
        }

        .media-concert.enhanced-concert {
            color: #059669;
        }

        .media-concert.enhanced-concert i {
            color: #059669;
        }

        .media-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
        }

        .media-description {
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-bottom: var(--space-3);
            line-height: 1.4;
        }

        .media-meta {
            display: flex;
            gap: var(--space-2);
            align-items: center;
            margin-bottom: var(--space-2);
        }

        .badge {
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-primary {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .media-concert {
            font-size: 0.75rem;
            color: var(--gray-500);
            background: var(--gray-100);
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
        }

        .media-date {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        /* ===== ENHANCED PERMISSION MANAGEMENT STYLES ===== */
        .permission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-0);
            margin-bottom: var(--space-8);
        }

        .permission-module {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: all var(--transition);
        }

        .permission-module:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .module-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: var(--space-0);
            text-align: center;
        }

        .module-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: var(--space-2);
        }

        .module-description {
            opacity: 0.9;
            font-size: 0.875rem;
        }

        .module-content {
            padding: var(--space-0);
        }

        .permission-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .permission-item {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3) 0;
            border-bottom: 1px solid var(--gray-100);
            transition: all var(--transition);
        }

        .permission-item:last-child {
            border-bottom: none;
        }

        .permission-item:hover {
            background: var(--gray-50);
            padding-left: var(--space-3);
            border-radius: var(--radius);
        }

        .permission-checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid var(--gray-300);
            border-radius: var(--radius);
            cursor: pointer;
            transition: all var(--transition);
            position: relative;
        }

        .permission-checkbox:checked {
            background: var(--primary);
            border-color: var(--primary);
        }

        .permission-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: var(--white);
            font-size: 0.75rem;
            font-weight: 700;
        }

        .permission-label {
            flex: 1;
            font-size: 0.875rem;
            color: var(--gray-700);
            cursor: pointer;
        }

        .permission-description {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin-top: var(--space-1);
        }

        /* ===== SLIDESHOW MODAL STYLES ===== */
        .slideshow-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        .slideshow-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .slideshow-content {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 90%;
            max-width: 800px;
            max-height: 90%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .slideshow-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .header-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .slideshow-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #6b7280;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .close-btn:hover {
            color: #374151;
        }

        .slideshow-main {
            position: relative;
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            min-height: 400px;
        }

        .slide-container {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slide-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .slide-loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
            color: #6b7280;
            font-size: 1rem;
        }

        .slide-loading i {
            font-size: 2rem;
            color: #3b82f6;
        }

        .slide-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            color: #ffffff;
            padding: 16px;
            text-align: left;
        }

        .slide-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .slide-description {
            font-size: 1rem;
            margin-bottom: 12px;
        }

        .slide-meta {
            display: flex;
            gap: 12px;
            font-size: 0.875rem;
            color: #d1d5db;
        }

        .slide-album {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .slide-album i {
            color: #3b82f6;
        }

        .slide-date {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .slide-date i {
            color: #10b981;
        }

        .slideshow-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            border-top: 1px solid #e5e7eb;
        }

        .slide-counter {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .slide-actions {
            display: flex;
            gap: 12px;
        }

        .nav-btn {
            background: #f3f4f6;
            color: #374151;
            border: none;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nav-btn:hover {
            background: #e5e7eb;
        }

        .nav-btn.prev-btn {
            margin-right: 12px;
        }

        .nav-btn.next-btn {
            margin-left: 12px;
        }

        /* Thumbnail Navigation */
        .thumbnail-navigation {
            padding: 16px;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .thumbnail-container {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding: 8px 0;
            scrollbar-width: thin;
            scrollbar-color: #d1d5db #f3f4f6;
        }

        .thumbnail-container::-webkit-scrollbar {
            height: 6px;
        }

        .thumbnail-container::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 3px;
        }

        .thumbnail-container::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        .thumbnail-item {
            flex-shrink: 0;
            width: 60px;
            height: 60px;
            border: 2px solid transparent;
            border-radius: 6px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s ease;
            opacity: 0.6;
        }

        .thumbnail-item:hover {
            opacity: 0.8;
            transform: scale(1.05);
        }

        .thumbnail-item.active {
            border-color: #3b82f6;
            opacity: 1;
        }

        .thumbnail-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Navigation Help */
        .navigation-help {
            padding: 12px 16px;
            background: #f3f4f6;
            border-top: 1px solid #e5e7eb;
        }

        .help-text {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            font-size: 0.75rem;
            color: #6b7280;
        }

        .help-text span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .help-text i {
            color: #3b82f6;
        }

        /* Fullscreen Mode Styles */
        .slideshow-modal.fullscreen-mode .slideshow-header,
        .slideshow-modal.fullscreen-mode .slideshow-footer,
        .slideshow-modal.fullscreen-mode .navigation-help,
        .slideshow-modal.fullscreen-mode .thumbnail-navigation {
            display: none !important;
        }

        .slideshow-modal.fullscreen-mode .slide-counter {
            display: block !important;
        }

        .slideshow-modal.fullscreen-mode .slideshow-main {
            padding: 0;
            background: #000;
            width: 100vw;
            height: 100vh;
        }

        .slideshow-modal.fullscreen-mode .slide-container {
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
        }

        .slideshow-modal.fullscreen-mode .slide-image {
            max-width: 100vw;
            max-height: 100vh;
            object-fit: contain;
            background: #000;
        }

        /* Fullscreen container styles */
        .slideshow-modal.fullscreen-mode {
            background: #000;
        }

        /* ===== ENHANCED FULLSCREEN MODAL STYLES ===== */
        .fullscreen-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 9999;
            display: none;
            backdrop-filter: blur(10px);
        }

        .fullscreen-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fullscreen-content {
            position: relative;
            width: 90%;
            height: 90%;
            max-width: 1200px;
            max-height: 800px;
            background: #1f2937;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
        }

        .fullscreen-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .fullscreen-header h3 {
            color: white;
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .fullscreen-actions {
            display: flex;
            gap: 8px;
        }

        .fullscreen-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: #111827;
        }

        .fullscreen-media {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .fullscreen-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .fullscreen-video {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .fullscreen-audio {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 16px;
        }

        .fullscreen-info {
            margin-top: 16px;
            text-align: center;
            color: white;
        }

        .fullscreen-info h4 {
            margin: 0 0 8px 0;
            font-size: 1.125rem;
            font-weight: 600;
        }

        .fullscreen-info p {
            margin: 0;
            color: #d1d5db;
            font-size: 0.875rem;
        }

        .fullscreen-footer {
            padding: 16px 24px;
            background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .fullscreen-controls {
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        .close-btn {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .close-btn:hover {
            background: rgba(0, 0, 0, 0.9);
            transform: scale(1.1);
        }

        .slideshow-modal.fullscreen-mode .slideshow-content {
            background: transparent;
            box-shadow: none;
            border: none;
            width: 100vw;
            height: 100vh;
            max-width: none;
            max-height: none;
        }

        /* Fullscreen image optimization */
        .slideshow-modal.fullscreen-mode .slide-image {
            width: auto;
            height: auto;
            max-width: 100vw;
            max-height: 100vh;
            object-fit: contain;
            background: #000;
            box-shadow: none;
            transition: transform 0.3s ease;
        }

        .slideshow-modal.fullscreen-mode .slide-image:hover {
            transform: scale(1.02);
        }

        /* Fullscreen loading indicator */
        .slideshow-modal.fullscreen-mode .slide-loading {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            border-radius: 12px;
            z-index: 1002;
        }

        /* Fullscreen navigation buttons */
        .slideshow-modal.fullscreen-mode .nav-btn {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            padding: 16px 12px;
            border-radius: 8px;
            z-index: 1001;
        }

        .slideshow-modal.fullscreen-mode .nav-btn:hover {
            background: rgba(0, 0, 0, 0.9);
        }

        .slideshow-modal.fullscreen-mode .nav-btn.prev-btn {
            left: 20px;
        }

        .slideshow-modal.fullscreen-mode .nav-btn.next-btn {
            right: 20px;
        }

        /* Fullscreen counter */
        .slideshow-modal.fullscreen-mode .slide-counter {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            z-index: 1001;
        }

        /* Fullscreen keyboard shortcuts hint */
        .slideshow-modal.fullscreen-mode .keyboard-hint {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.75rem;
            z-index: 1001;
            opacity: 0.8;
            transition: opacity 0.3s ease;
            display: flex !important;
            gap: 16px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .slideshow-modal.fullscreen-mode .keyboard-hint:hover {
            opacity: 1;
        }

        .slideshow-modal.fullscreen-mode .keyboard-hint span {
            display: flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        /* Fullscreen Exit Button */
        .fullscreen-exit-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            border: none;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            z-index: 1001;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
        }

        .fullscreen-exit-btn:hover {
            background: rgba(0, 0, 0, 0.9);
            transform: translateY(-1px);
        }

        .fullscreen-exit-btn i {
            font-size: 1rem;
        }

        .slideshow-modal.fullscreen-mode .fullscreen-exit-btn {
            display: flex !important;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .slideshow-modal.fullscreen-mode .fullscreen-exit-btn:hover {
            opacity: 1;
        }

        /* Show exit button on top-left hover area */
        .slideshow-modal.fullscreen-mode::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100px;
            height: 100px;
            z-index: 1000;
            cursor: pointer;
        }

        .slideshow-modal.fullscreen-mode:hover .fullscreen-exit-btn {
            opacity: 1;
        }

        /* Fullscreen exit area clickable */
        .slideshow-modal.fullscreen-mode .exit-area {
            position: fixed;
            top: 0;
            left: 0;
            width: 100px;
            height: 100px;
            z-index: 1000;
            cursor: pointer;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.1) 0%, transparent 50%);
            transition: background 0.3s ease;
        }

        .slideshow-modal.fullscreen-mode .exit-area:hover {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.2) 0%, transparent 50%);
        }

        /* Description Toggle Styles */
        .slide-info {
            transition: opacity 0.3s ease;
        }

        .slide-info.hidden {
            opacity: 0;
            pointer-events: none;
        }

        /* Fullscreen Button States */
        .header-actions .btn[onclick*="toggleFullscreen"] i.fa-compress {
            color: #ef4444;
        }

        .header-actions .btn[onclick*="toggleDescription"] i.fa-eye-slash {
            color: #6b7280;
        }

        /* Debug button styling */
        .header-actions .btn[onclick*="exitFullscreen"] {
            background: #dc2626;
            color: white;
        }

        .header-actions .btn[onclick*="exitFullscreen"]:hover {
            background: #b91c1c;
        }

        /* ===== ENHANCED NOTIFICATION STYLES ===== */
        .notification-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            margin-bottom: var(--space-4);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .notification-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            transform: scaleY(0);
            transition: transform var(--transition);
        }

        .notification-card:hover::before {
            transform: scaleY(1);
        }

        .notification-card:hover {
            transform: translateX(8px);
            box-shadow: var(--shadow-xl);
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: var(--space-3);
        }

        .notification-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-1);
        }

        .notification-time {
            font-size: 0.75rem;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .notification-content {
            color: var(--gray-600);
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: var(--space-3);
        }

        .notification-meta {
            display: flex;
            gap: var(--space-3);
            align-items: center;
        }

        .notification-type {
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .notification-type.info {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info);
        }

        .notification-type.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .notification-type.warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .notification-type.error {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }

        /* ===== RESPONSIVE DESIGN FOR ALL COMPONENTS ===== */
        @media (max-width: 768px) {

            /* Dashboard responsive */
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .overview-grid {
                grid-template-columns: 1fr;
            }

            .welcome-title {
                font-size: 1.5rem;
            }

            .welcome-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--space-3);
            }

            /* Members responsive */
            .member-photo,
            .member-photo-placeholder {
                width: 32px;
                height: 32px;
            }

            .member-photo-placeholder i {
                font-size: 14px;
            }

            /* Media responsive */
            .filters-row {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-select,
            .filter-input {
                min-width: auto;
            }

            .media-grid {
                grid-template-columns: 1fr;
            }

            .slideshow-content {
                width: 95%;
                max-height: 95%;
            }

            .slideshow-main {
                flex-direction: column;
            }

            .nav-btn.prev-btn,
            .nav-btn.next-btn {
                margin: 0;
            }
        }

        /* ===== ENHANCED ADMIN PAGE IMPROVEMENTS ===== */
        /* Additional CSS improvements for all admin pages */

        /* Enhanced Card Animations */
        .content-card,
        .overview-card,
        .action-card,
        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .content-card::before,
        .overview-card::before,
        .action-card::before,
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .content-card:hover::before,
        .overview-card:hover::before,
        .action-card:hover::before,
        .stat-card:hover::before {
            left: 100%;
        }

        /* Enhanced Form Improvements */
        .form-group {
            position: relative;
            margin-bottom: var(--space-0);
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: var(--space-2);
            transition: color var(--transition);
        }

        .form-group:focus-within .form-label {
            color: var(--primary);
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: var(--space-4) var(--space-4);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            font-size: 0.875rem;
            transition: all var(--transition);
            background: var(--white);
            position: relative;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(23, 52, 120, 0.1);
            transform: translateY(-1px);
        }

        .form-input:hover,
        .form-textarea:hover,
        .form-select:hover {
            border-color: var(--gray-300);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
            line-height: 1.6;
        }

        .form-error {
            color: var(--error);
            font-size: 0.875rem;
            margin-top: var(--space-2);
            display: flex;
            align-items: center;
            gap: var(--space-2);
            animation: slideInError 0.3s ease;
        }

        .form-error::before {
            content: '⚠';
            font-size: 1rem;
        }

        @keyframes slideInError {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced Button Improvements */
        .btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 600;
            letter-spacing: 0.025em;
        }

        .btn:active {
            transform: translateY(1px) scale(0.98);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn:disabled::before {
            display: none;
        }

        /* Enhanced Table Improvements */
        .data-table {
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .data-table thead {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
        }

        .data-table th {
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-size: 0.75rem;
            padding: var(--space-5) var(--space-4);
            border-bottom: 2px solid var(--gray-200);
            position: relative;
        }

        .data-table th::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            transform: scaleX(0);
            transition: transform var(--transition);
        }

        .data-table th:hover::after {
            transform: scaleX(1);
        }

        .data-table tbody tr {
            transition: all var(--transition);
            position: relative;
        }

        .data-table tbody tr:hover {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            transform: scale(1.01);
            box-shadow: var(--shadow-xl);
            z-index: 1;
        }

        .data-table tbody tr:hover td {
            color: var(--white);
        }

        .data-table tbody tr:hover .status-badge,
        .data-table tbody tr:hover .type-badge,
        .data-table tbody tr:hover .voice-badge {
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
        }

        /* Enhanced Status Badge Improvements */
        .status-badge,
        .type-badge,
        .voice-badge {
            position: relative;
            overflow: hidden;
            transition: all var(--transition);
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .status-badge::before,
        .type-badge::before,
        .voice-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .status-badge:hover::before,
        .type-badge:hover::before,
        .voice-badge:hover::before {
            left: 100%;
        }

        /* Enhanced Search and Filter Improvements */
        .search-box {
            position: relative;
            flex: 1;
        }

        .search-input {
            width: 100%;
            padding: var(--space-4) var(--space-12) var(--space-4) var(--space-4);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-xl);
            font-size: 0.875rem;
            transition: all var(--transition);
            background: var(--white);
            box-shadow: var(--shadow-sm);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(23, 52, 120, 0.1), var(--shadow-md);
            transform: translateY(-2px);
        }

        .search-input::placeholder {
            color: var(--gray-400);
            transition: color var(--transition);
        }

        .search-input:focus::placeholder {
            color: var(--gray-500);
        }

        .search-icon {
            position: absolute;
            right: var(--space-4);
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: 1rem;
            pointer-events: none;
            transition: color var(--transition);
        }

        .search-input:focus+.search-icon {
            color: var(--primary);
        }

        .filter-select {
            padding: var(--space-4) var(--space-4);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-xl);
            font-size: 0.875rem;
            transition: all var(--transition);
            background: var(--white);
            min-width: 150px;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(23, 52, 120, 0.1), var(--shadow-md);
            transform: translateY(-2px);
        }

        .filter-select:hover {
            border-color: var(--gray-300);
            box-shadow: var(--shadow-md);
        }

        /* Enhanced Empty State Improvements */
        .empty-state {
            text-align: center;
            padding: var(--space-16);
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
            border-radius: var(--radius-2xl);
            border: 2px dashed var(--gray-200);
            position: relative;
            overflow: hidden;
        }

        .empty-state::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(59, 130, 246, 0.05) 50%, transparent 70%);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: 50%;
            border: 3px solid var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto var(--space-0);
            font-size: 2rem;
            color: var(--white);
            box-shadow: var(--shadow-xl);
            position: relative;
            z-index: 1;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-3);
            position: relative;
            z-index: 1;
        }

        .empty-state p {
            color: var(--gray-600);
            margin-bottom: var(--space-0);
            font-size: 1rem;
            position: relative;
            z-index: 1;
        }

        /* Enhanced Pagination Improvements */
        .pagination-wrapper {
            margin-top: var(--space-8);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pagination-wrapper nav {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }

        .pagination-wrapper .pagination {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pagination-wrapper .page-item {
            border-right: 1px solid var(--gray-200);
        }

        .pagination-wrapper .page-item:last-child {
            border-right: none;
        }

        .pagination-wrapper .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            height: 44px;
            padding: var(--space-3) var(--space-4);
            color: var(--gray-700);
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition);
            background: var(--white);
        }

        .pagination-wrapper .page-link:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-1px);
        }

        .pagination-wrapper .page-item.active .page-link {
            background: var(--primary);
            color: var(--white);
            font-weight: 700;
        }

        .pagination-wrapper .page-item.disabled .page-link {
            color: var(--gray-400);
            cursor: not-allowed;
            background: var(--gray-50);
        }

        /* ===== ENHANCED PAGINATION COMPONENT ===== */
        .enhanced-pagination-wrapper {
            margin-top: var(--space-8);
            padding: var(--space-6);
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: var(--space-4);
        }

        .pagination-info {
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .page-info-text {
            color: var(--gray-600);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .per-page-selector {
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .per-page-label {
            color: var(--gray-600);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .per-page-select {
            padding: var(--space-1) var(--space-3);
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            background: var(--white);
            color: var(--gray-700);
            font-size: 0.875rem;
            cursor: pointer;
            transition: all var(--transition);
        }

        .per-page-select:hover {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .per-page-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .per-page-text {
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .pagination-controls {
            display: flex;
            align-items: center;
            gap: var(--space-1);
        }

        .pagination-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            background: var(--white);
            color: var(--gray-700);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all var(--transition);
            cursor: pointer;
        }

        .pagination-btn:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .pagination-btn-active {
            background: var(--primary) !important;
            color: var(--white) !important;
            border-color: var(--primary) !important;
            font-weight: 700;
        }

        .pagination-btn-disabled {
            color: var(--gray-400) !important;
            cursor: not-allowed !important;
            background: var(--gray-50) !important;
            border-color: var(--gray-200) !important;
        }

        .pagination-btn-disabled:hover {
            transform: none !important;
            box-shadow: none !important;
        }

        .pagination-ellipsis {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            color: var(--gray-500);
            font-weight: 500;
        }

        .jump-to-page {
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .jump-label {
            color: var(--gray-600);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .jump-input {
            width: 60px;
            padding: var(--space-1) var(--space-2);
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            background: var(--white);
            color: var(--gray-700);
            font-size: 0.875rem;
            text-align: center;
            transition: all var(--transition);
        }

        .jump-input:hover {
            border-color: var(--primary);
        }

        .jump-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .jump-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border: 1px solid var(--primary);
            border-radius: var(--radius);
            background: var(--primary);
            color: var(--white);
            cursor: pointer;
            transition: all var(--transition);
        }

        .jump-btn:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        /* Responsive Design for Enhanced Pagination */
        @media (max-width: 768px) {
            .enhanced-pagination-wrapper {
                flex-direction: column;
                gap: var(--space-4);
                text-align: center;
            }

            .pagination-controls {
                order: 1;
            }

            .pagination-info {
                order: 2;
            }

            .per-page-selector {
                order: 3;
            }

            .jump-to-page {
                order: 4;
            }

            .pagination-btn {
                width: 36px;
                height: 36px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .enhanced-pagination-wrapper {
                padding: var(--space-4);
            }

            .pagination-controls {
                flex-wrap: wrap;
                justify-content: center;
            }

            .pagination-btn {
                width: 32px;
                height: 32px;
                font-size: 0.75rem;
            }
        }

        /* ===== EXPORT ACTIONS STYLING ===== */
        .export-actions {
            display: flex;
            gap: var(--space-2);
            align-items: center;
        }

        .export-actions .btn {
            min-width: 80px;
            padding: var(--space-2) var(--space-3);
        }

        .export-actions .btn-success {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            border-color: #059669;
        }

        .export-actions .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            border-color: #047857;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }

        .export-actions .btn-danger {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            border-color: #DC2626;
        }

        .export-actions .btn-danger:hover {
            background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
            border-color: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        }

        .export-actions .btn i {
            margin-right: var(--space-1);
        }

        /* Responsive export actions */
        @media (max-width: 768px) {
            .export-actions {
                flex-direction: column;
                width: 100%;
                margin-top: var(--space-3);
            }

            .export-actions .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .header-actions {
                flex-direction: column;
                gap: var(--space-3);
            }

            .export-actions {
                flex-direction: row;
                justify-content: center;
            }

            .export-actions .btn {
                min-width: 70px;
                padding: var(--space-2);
            }

            .export-actions .btn span {
                display: none;
            }
        }

        /* Enhanced Alert Improvements */
        .alert {
            padding: var(--space-4) var(--space-0);
            border-radius: var(--radius-xl);
            margin-bottom: var(--space-0);
            border: 2px solid;
            display: flex;
            align-items: center;
            gap: var(--space-3);
            font-weight: 500;
            position: relative;
            overflow: hidden;
            animation: slideInAlert 0.5s ease;
        }

        @keyframes slideInAlert {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 2s infinite;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border-color: var(--success);
            color: var(--success);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border-color: var(--error);
            color: var(--error);
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            border-color: var(--warning);
            color: var(--warning);
        }

        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            border-color: var(--info);
            color: var(--info);
        }

        /* Enhanced Loading States */
        .loading-spinner {
            display: inline-block;
            width: 24px;
            height: 24px;
            border: 3px solid var(--gray-200);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: inherit;
            z-index: 10;
        }

        /* Enhanced Tooltip System */
        .tooltip {
            position: relative;
            cursor: help;
        }

        .tooltip::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--gray-900);
            color: var(--white);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition);
            z-index: 1000;
            pointer-events: none;
        }

        .tooltip:hover::after {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(-4px);
        }

        /* Enhanced Modal Improvements */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition);
            backdrop-filter: blur(8px);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: var(--white);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-2xl);
            max-width: 90vw;
            max-height: 90vh;
            overflow: hidden;
            transform: scale(0.9) translateY(20px);
            transition: all var(--transition);
        }

        .modal-overlay.active .modal-content {
            transform: scale(1) translateY(0);
        }

        /* Enhanced Chart and Graph Styles */
        .chart-container {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            position: relative;
            overflow: hidden;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-0);
            padding-bottom: var(--space-4);
            border-bottom: 2px solid var(--gray-100);
        }

        .chart-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .chart-legend {
            display: flex;
            gap: var(--space-4);
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 2px;
            background: var(--primary);
        }

        /* Enhanced Financial Report Styles */
        .reports-grid {
            display: grid;
            gap: var(--space-0);
            margin-bottom: var(--space-8);
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--space-0);
        }

        .summary-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: var(--space-4);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            transform: scaleX(0);
            transition: transform var(--transition);
        }

        .summary-card:hover::before {
            transform: scaleX(1);
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .card-icon {
            width: 64px;
            height: 64px;
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--white);
            flex-shrink: 0;
        }

        .card-icon.income {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
        }

        .card-icon.expenses {
            background: linear-gradient(135deg, var(--error) 0%, #dc2626 100%);
        }

        .card-icon.profit {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        }

        .card-icon.balance {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
        }

        .card-content {
            flex: 1;
        }

        .card-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: var(--space-2);
        }

        .card-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
            line-height: 1;
        }

        .card-change {
            font-size: 0.75rem;
            font-weight: 600;
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            display: inline-block;
        }

        .card-change.positive {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .card-change.negative {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }

        .card-change.neutral {
            background: rgba(107, 114, 128, 0.1);
            color: var(--gray-600);
        }

        /* Enhanced Practice Session Styles */
        .practice-session-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            margin-bottom: var(--space-4);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }

        .practice-session-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            transform: scaleY(0);
            transition: transform var(--transition);
        }

        .practice-session-card:hover::before {
            transform: scaleY(1);
        }

        .practice-session-card:hover {
            transform: translateX(8px);
            box-shadow: var(--shadow-xl);
        }

        .session-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: var(--space-4);
        }

        .session-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
        }

        .session-status {
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .session-status.scheduled {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
        }

        .session-status.in_progress {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .session-status.completed {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .session-status.cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }

        .session-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-4);
            margin-bottom: var(--space-4);
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .detail-item i {
            color: var(--primary);
            width: 16px;
            text-align: center;
        }

        /* Enhanced Contribution Campaign Styles */
        .campaign-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            margin-bottom: var(--space-4);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }

        .campaign-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 40px 40px 0;
            border-color: transparent var(--primary) transparent transparent;
            opacity: 0;
            transition: opacity var(--transition);
        }

        .campaign-card:hover::after {
            opacity: 1;
        }

        .campaign-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .campaign-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: var(--space-4);
        }

        .campaign-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
        }

        .campaign-goal {
            background: var(--gray-50);
            padding: var(--space-3) var(--space-4);
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            text-align: center;
        }

        .goal-amount {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            display: block;
        }

        .goal-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .campaign-progress {
            margin: var(--space-4) 0;
        }

        .progress-bar {
            height: 8px;
            background: var(--gray-200);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin-bottom: var(--space-2);
        }





        .progress-stats {
            display: flex;
            justify-content: space-between;
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        /* Enhanced User Management Styles */
        .user-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            margin-bottom: var(--space-4);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }

        .user-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(59, 130, 246, 0.02) 100%);
            opacity: 0;
            transition: opacity var(--transition);
        }

        .user-card:hover::before {
            opacity: 1;
        }

        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .user-header {
            display: flex;
            align-items: center;
            gap: var(--space-4);
            margin-bottom: var(--space-4);
        }

        /* Enhanced Permission Management Styles */
        .permission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-0);
            margin-bottom: var(--space-8);
        }

        .permission-module {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: all var(--transition);
        }

        .permission-module:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .module-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: var(--space-0);
            text-align: center;
        }

        .module-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: var(--space-2);
        }

        .module-description {
            opacity: 0.9;
            font-size: 0.875rem;
        }

        .module-content {
            padding: var(--space-0);
        }

        .permission-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .permission-item {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3) 0;
            border-bottom: 1px solid var(--gray-100);
            transition: all var(--transition);
        }

        .permission-item:last-child {
            border-bottom: none;
        }

        .permission-item:hover {
            background: var(--gray-50);
            padding-left: var(--space-3);
            border-radius: var(--radius);
        }

        .permission-checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid var(--gray-300);
            border-radius: var(--radius);
            cursor: pointer;
            transition: all var(--transition);
            position: relative;
        }

        .permission-checkbox:checked {
            background: var(--primary);
            border-color: var(--primary);
        }

        .permission-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: var(--white);
            font-size: 0.75rem;
            font-weight: 700;
        }

        .permission-label {
            flex: 1;
            font-size: 0.875rem;
            color: var(--gray-700);
            cursor: pointer;
        }

        .permission-description {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin-top: var(--space-1);
        }

        /* Enhanced Notification Styles */
        .notification-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-0);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            margin-bottom: var(--space-4);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .notification-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            transform: scaleY(0);
            transition: transform var(--transition);
        }

        .notification-card:hover::before {
            transform: scaleY(1);
        }

        .notification-card:hover {
            transform: translateX(8px);
            box-shadow: var(--shadow-xl);
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: var(--space-3);
        }

        .notification-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-1);
        }

        .notification-time {
            font-size: 0.75rem;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .notification-content {
            color: var(--gray-600);
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: var(--space-3);
        }

        .notification-meta {
            display: flex;
            gap: var(--space-3);
            align-items: center;
        }

        .notification-type {
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .notification-type.info {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info);
        }

        .notification-type.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .notification-type.warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .notification-type.error {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }

        /* Enhanced Responsive Improvements */
        @media (max-width: 1024px) {
            .summary-cards {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }

            .permission-grid {
                grid-template-columns: 1fr;
            }

            .session-details,
            .campaign-details {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .summary-cards {
                grid-template-columns: 1fr;
            }

            .campaign-header,
            .session-header,
            .user-header {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--space-3);
            }

            .card-icon {
                width: 48px;
                height: 48px;
                font-size: 1.25rem;
            }

            .card-value {
                font-size: 1.5rem;
            }

            .empty-icon {
                width: 64px;
                height: 64px;
                font-size: 1.5rem;
            }

            .empty-state h3 {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 480px) {

            .summary-card,
            .campaign-card,
            .practice-session-card,
            .user-card,
            .notification-card {
                padding: var(--space-4);
            }

            .card-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .card-value {
                font-size: 1.25rem;
            }

            .empty-state {
                padding: var(--space-8);
            }

            .empty-icon {
                width: 56px;
                height: 56px;
                font-size: 1.25rem;
            }
        }

        /* Enhanced Print Styles */
        @media print {

            .content-card,
            .overview-card,
            .action-card,
            .stat-card,
            .summary-card,
            .campaign-card,
            .practice-session-card,
            .user-card,
            .notification-card {
                break-inside: avoid;
                box-shadow: none;
                border: 1px solid var(--gray-300);
            }

            .btn,
            .action-buttons {
                display: none;
            }

            .data-table {
                border: 1px solid var(--gray-300);
            }

            .data-table th,
            .data-table td {
                border: 1px solid var(--gray-300);
            }
        }

        /* Enhanced Contribution Campaign Show Page Styles */
        .campaigns-grid.enhanced-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--space-4);
            margin-top: var(--space-4);
        }

        .campaign-card.enhanced-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: all var(--transition);
        }

        .campaign-card.enhanced-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .campaign-card .card-header.enhanced-header {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            padding: var(--space-6);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .campaign-card .card-header .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-800);
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .campaign-card .card-header .card-title i {
            color: var(--primary);
            font-size: 1.125rem;
        }

        .campaign-card .card-body {
            padding: var(--space-6);
        }

        .info-grid.enhanced-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-4);
        }

        .info-item.enhanced-form-group {
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
        }

        .info-label.enhanced-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .info-value {
            font-size: 1rem;
            color: var(--gray-800);
            padding: var(--space-3);
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
        }

        .amount-highlight {
            font-weight: 700;
            color: var(--success);
        }

        .amount-highlight.text-success {
            color: var(--success);
        }

        .amount-highlight.text-muted {
            color: var(--gray-500);
        }



        .description-section,
        .notes-section {
            margin-top: var(--space-6);
            padding-top: var(--space-6);
            border-top: 1px solid var(--gray-200);
        }

        .section-title.enhanced-label {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: var(--space-3);
        }

        .description-text,
        .notes-text {
            color: var(--gray-700);
            line-height: 1.6;
            padding: var(--space-4);
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
        }

        /* Progress Section Styles */
        .progress-section {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .progress-label {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-700);
        }

        .progress-percentage {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--primary);
        }

        .progress-bar.enhanced-progress {
            height: 12px;
            background: var(--gray-200);
            border-radius: var(--radius-full);
            overflow: hidden;
            position: relative;
        }



        .progress-amounts {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: var(--space-3);
        }

        .raised-amount,
        .target-amount {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--space-1);
        }

        .amount-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .amount-value {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-800);
        }

        .raised-amount .amount-value {
            color: var(--success);
        }

        .target-amount .amount-value {
            color: var(--primary);
        }

        /* Enhanced Table Styles */
        .data-table.enhanced-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: var(--space-4);
        }

        .data-table.enhanced-table th {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            padding: var(--space-4);
            text-align: left;
            font-weight: 700;
            color: var(--gray-700);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--gray-200);
        }

        .contribution-row {
            transition: all var(--transition);
        }

        .contribution-row:hover {
            background: var(--gray-50);
        }

        .contributor-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .contributor-name {
            font-weight: 600;
            color: var(--gray-800);
        }

        .contributor-email {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .amount-info .amount {
            font-weight: 700;
            color: var(--success);
        }

        .payment-method {
            font-size: 0.875rem;
            color: var(--gray-600);
            padding: var(--space-1) var(--space-3);
            background: var(--gray-100);
            border-radius: var(--radius);
        }

        .action-buttons {
            display: flex;
            gap: var(--space-2);
        }

        .action-buttons .enhanced-btn {
            padding: var(--space-2) var(--space-3);
            font-size: 0.875rem;
        }

        /* Empty State Styles */
        .empty-state.enhanced-empty {
            text-align: center;
            padding: var(--space-12);
            color: var(--gray-500);
        }

        .empty-state .empty-icon {
            font-size: 3rem;
            margin-bottom: var(--space-4);
            color: var(--gray-400);
        }

        .empty-state .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: var(--space-2);
        }

        .empty-state .empty-description {
            font-size: 1rem;
            color: var(--gray-600);
            margin-bottom: var(--space-6);
        }

        .empty-state .empty-actions {
            display: flex;
            justify-content: center;
            gap: var(--space-3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .campaigns-grid.enhanced-grid {
                grid-template-columns: 1fr;
                gap: var(--space-3);
            }

            .info-grid.enhanced-form-grid {
                grid-template-columns: 1fr;
            }

            .progress-amounts {
                flex-direction: column;
                gap: var(--space-3);
            }

            .campaign-card .card-header.enhanced-header {
                flex-direction: column;
                gap: var(--space-4);
                align-items: flex-start;
            }

            .header-actions {
                display: flex;
                gap: var(--space-2);
            }

            .header-actions .enhanced-btn {
                flex: 1;
            }
        }

        /* Enhanced Sponsors Pages */
        .sponsors-grid.enhanced-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: var(--space-6);
            margin-top: var(--space-6);
        }

        .sponsor-card.enhanced-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid var(--gray-200);
        }

        .sponsor-card.enhanced-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .sponsor-card .card-header.enhanced-header {
            background: linear-gradient(135deg, var(--primary-50), var(--primary-100));
            padding: var(--space-6);
            border-bottom: 1px solid var(--gray-200);
            position: relative;
        }

        .sponsor-card .card-header.enhanced-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 197, 253, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sponsor-card:hover .card-header.enhanced-header::before {
            opacity: 1;
        }

        .sponsor-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
            margin-bottom: var(--space-6);
        }

        .sponsorship-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--space-4);
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            margin-bottom: var(--space-6);
        }

        .level-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
        }

        .level-badge.enhanced-badge {
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius-full);
            font-size: var(--text-xs);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .level-badge.level-platinum {
            background: var(--purple-100);
            color: var(--purple-800);
        }

        .level-badge.level-gold {
            background: var(--yellow-100);
            color: var(--yellow-800);
        }

        .level-badge.level-silver {
            background: var(--gray-100);
            color: var(--gray-800);
        }

        .level-badge.level-bronze {
            background: var(--orange-100);
            color: var(--orange-800);
        }

        .level-badge.level-partner {
            background: var(--blue-100);
            color: var(--blue-800);
        }

        .partnership-date {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: var(--space-1);
        }

        .date-label {
            font-size: var(--text-xs);
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .date-value {
            font-size: var(--text-sm);
            font-weight: 600;
            color: var(--gray-700);
        }

        .card-actions {
            display: flex;
            gap: var(--space-3);
            justify-content: flex-end;
            padding-top: var(--space-4);
            border-top: 1px solid var(--gray-200);
        }

        .link-highlight {
            color: var(--primary-600);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .link-highlight:hover {
            color: var(--primary-700);
            text-decoration: underline;
        }

        .text-muted {
            color: var(--gray-500);
        }

        .danger-zone .card-header.enhanced-header {
            background: linear-gradient(135deg, var(--error-50), var(--error-100));
        }

        .danger-zone .card-header.enhanced-header::before {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(252, 165, 165, 0.1));
        }

        /* Enhanced Contribution Campaign Show Page */
        .campaigns-grid.enhanced-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: var(--space-4);
            margin-top: var(--space-4);
        }

        .full-width-card {
            grid-column: 1 / -1;
        }

        .campaign-card.enhanced-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid var(--gray-200);
        }

        .campaign-card .card-header.enhanced-header {
            background: linear-gradient(135deg, var(--primary-50), var(--primary-100));
            padding: var(--space-6);
            border-bottom: 1px solid var(--gray-200);
            position: relative;
        }

        .campaign-card .card-header.enhanced-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 197, 253, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .campaign-card:hover .card-header.enhanced-header::before {
            opacity: 1;
        }

        .info-grid.enhanced-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-4);
        }

        .info-item.enhanced-form-group {
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
        }

        .info-label.enhanced-label {
            font-size: var(--text-sm);
            font-weight: 600;
            color: var(--gray-600);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .info-value {
            font-size: var(--text-base);
            color: var(--gray-900);
            font-weight: 500;
            padding: var(--space-2) 0;
        }

        .amount-highlight {
            font-size: var(--text-lg);
            font-weight: 700;
            color: var(--success-600);
            background: var(--success-50);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-lg);
            display: inline-block;
        }



        .description-section,
        .notes-section {
            margin-bottom: var(--space-6);
        }

        .section-title.enhanced-label {
            font-size: var(--text-sm);
            font-weight: 600;
            color: var(--gray-600);
            margin-bottom: var(--space-2);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .description-text,
        .notes-text {
            font-size: var(--text-base);
            color: var(--gray-700);
            line-height: 1.6;
            background: var(--gray-50);
            padding: var(--space-4);
            border-radius: var(--radius-lg);
            border-left: 4px solid var(--primary-500);
        }

        .progress-section {
            margin-top: var(--space-6);
            padding-top: var(--space-6);
            border-top: 1px solid var(--gray-200);
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-4);
        }

        .progress-label {
            font-size: var(--text-sm);
            font-weight: 600;
            color: var(--gray-600);
        }

        .progress-percentage {
            font-size: var(--text-lg);
            font-weight: 700;
            color: var(--primary-600);
        }

        .progress-bar.enhanced-progress {
            width: 100%;
            height: 12px;
            background: var(--gray-200);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin-bottom: var(--space-3);
        }



        .progress-amounts {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .raised-amount,
        .target-amount {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .amount-label {
            font-size: var(--text-xs);
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .amount-value {
            font-size: var(--text-lg);
            font-weight: 700;
            color: var(--gray-900);
        }

        .raised-amount .amount-value {
            color: var(--success-600);
        }

        .data-table.enhanced-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: var(--space-4);
        }

        .data-table.enhanced-table th {
            background: var(--gray-50);
            padding: var(--space-3) var(--space-4);
            text-align: left;
            font-weight: 600;
            color: var(--gray-700);
            border-bottom: 2px solid var(--gray-200);
        }

        .data-table.enhanced-table td {
            border-bottom: 1px solid var(--gray-200);
        }

        .contribution-row {
            transition: background-color 0.2s ease;
        }

        .contribution-row:hover {
            background: var(--gray-50);
        }

        .contributor-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .contributor-name {
            font-weight: 600;
            color: var(--gray-900);
        }

        .contributor-email {
            font-size: var(--text-sm);
            color: var(--gray-500);
        }

        .amount-info .amount {
            font-weight: 600;
            color: var(--success-600);
        }

        .payment-method {
            font-size: var(--text-sm);
            color: var(--gray-600);
        }

        .action-buttons {
            display: flex;
            gap: var(--space-2);
        }

        .action-buttons .enhanced-btn {
            padding: var(--space-1) var(--space-2);
            font-size: var(--text-xs);
        }

        .empty-state.enhanced-empty {
            text-align: center;
            padding: var(--space-12);
            background: var(--gray-50);
            border-radius: var(--radius-xl);
            border: 2px dashed var(--gray-300);
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--gray-400);
            margin-bottom: var(--space-4);
        }

        .empty-title {
            font-size: var(--text-xl);
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: var(--space-2);
        }

        .empty-description {
            font-size: var(--text-base);
            color: var(--gray-600);
            margin-bottom: var(--space-6);
        }

        .empty-actions {
            display: flex;
            justify-content: center;
            gap: var(--space-4);
        }

        /* Responsive Design */
        @media (max-width: 768px) {

            .campaigns-grid.enhanced-grid,
            .sponsors-grid.enhanced-grid {
                grid-template-columns: 1fr;
            }

            .info-grid.enhanced-form-grid {
                grid-template-columns: 1fr;
            }

            .progress-amounts {
                flex-direction: column;
                gap: var(--space-2);
            }

            .action-buttons {
                flex-direction: column;
            }

            .sponsorship-details {
                flex-direction: column;
                gap: var(--space-3);
                align-items: flex-start;
            }

            .partnership-date {
                align-items: flex-start;
            }

            .card-actions {
                flex-direction: column;
            }
        }

        /* Enhanced Role Statistics - Global Styles */
        .enhanced-role-stats {
            display: flex !important;
            flex-direction: row !important;
            gap: 30px !important;
            background: #f8fafc !important;
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            justify-content: center !important;
            align-items: center !important;
            flex-wrap: wrap !important;
        }

        .enhanced-stat-item {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            background: #ffffff !important;
            padding: 20px !important;
            border-radius: 10px !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
            min-width: 180px !important;
            transition: all 0.3s ease !important;
        }

        .enhanced-stat-item:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
            border-color: #3b82f6 !important;
        }

        .enhanced-stat-item .stat-icon {
            margin-right: 15px !important;
            width: 50px !important;
            height: 50px !important;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important;
            border-radius: 12px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #ffffff !important;
            font-size: 20px !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3) !important;
        }

        .enhanced-stat-item .stat-content {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
        }

        .enhanced-stat-item .stat-number {
            font-size: 32px !important;
            font-weight: 800 !important;
            color: #1e293b !important;
            line-height: 1 !important;
            margin-bottom: 5px !important;
        }

        .enhanced-stat-item .stat-label {
            font-size: 14px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        /* Enhanced Role Main Section */
        .role-main {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            background: #ffffff !important;
            padding: 25px !important;
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
            margin-bottom: 20px !important;
        }

        .role-icon {
            width: 60px !important;
            height: 60px !important;
            background: linear-gradient(135deg, #10b981, #059669) !important;
            border-radius: 15px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #ffffff !important;
            font-size: 24px !important;
            margin-right: 20px !important;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3) !important;
        }

        .role-info {
            flex: 1 !important;
        }

        .role-name {
            font-size: 24px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin: 0 0 8px 0 !important;
        }

        .role-slug {
            font-size: 16px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            font-family: 'Courier New', monospace !important;
            background: #f1f5f9 !important;
            padding: 4px 12px !important;
            border-radius: 6px !important;
            display: inline-block !important;
        }

        /* Enhanced Permissions Grid */
        .enhanced-permissions-grid {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            gap: 15px !important;
            margin-top: 20px !important;
        }

        .enhanced-permission-item {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            padding: 15px !important;
            min-width: 300px !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
            transition: all 0.3s ease !important;
        }

        .enhanced-permission-item:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .permission-icon {
            margin-right: 15px !important;
            color: #6b7280 !important;
            font-size: 18px !important;
        }

        .permission-status {
            margin-right: 15px !important;
        }

        .permission-content {
            flex: 1 !important;
            margin-right: 15px !important;
        }

        .permission-name {
            font-size: 14px !important;
            font-weight: 500 !important;
            color: #374151 !important;
            margin: 0 0 5px 0 !important;
        }

        .permission-key {
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #111827 !important;
            font-family: 'Courier New', monospace !important;
        }

        .permission-meta {
            display: flex !important;
            align-items: center !important;
        }

        .module-badge {
            background: #f3f4f6 !important;
            color: #374151 !important;
            padding: 4px 8px !important;
            border-radius: 4px !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        .module-badge i {
            margin-right: 4px !important;
            font-size: 10px !important;
        }

        .status-badge.active {
            background: #dcfce7 !important;
            color: #166534 !important;
            border: 1px solid #bbf7d0 !important;
        }

        .status-badge.inactive {
            background: #fef2f2 !important;
            color: #dc2626 !important;
            border: 1px solid #fecaca !important;
        }

        .status-dot {
            width: 6px !important;
            height: 6px !important;
            border-radius: 50% !important;
            display: inline-block !important;
            margin-right: 6px !important;
        }

        .status-badge.active .status-dot {
            background: #16a34a !important;
        }

        .status-badge.inactive .status-dot {
            background: #dc2626 !important;
        }

        .permissions-header {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            margin-bottom: 20px !important;
            padding-bottom: 15px !important;
            border-bottom: 1px solid #e5e7eb !important;
        }

        .permissions-title {
            display: flex !important;
            align-items: center !important;
            margin: 0 !important;
            font-size: 18px !important;
            font-weight: 600 !important;
            color: #111827 !important;
        }

        .permissions-title i {
            margin-right: 10px !important;
            color: #6b7280 !important;
        }

        .permissions-count {
            margin-left: 8px !important;
            color: #6b7280 !important;
            font-weight: 400 !important;
        }

        .permissions-filter {
            display: flex !important;
            gap: 10px !important;
        }

        .filter-btn {
            padding: 8px 16px !important;
            border: 1px solid #d1d5db !important;
            background: #ffffff !important;
            color: #374151 !important;
            border-radius: 6px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }

        .filter-btn:hover {
            background: #f9fafb !important;
            border-color: #9ca3af !important;
        }

        .filter-btn.active {
            background: #3b82f6 !important;
            color: #ffffff !important;
            border-color: #3b82f6 !important;
        }

        .permissions-summary {
            margin-top: 25px !important;
            padding: 20px !important;
            background: #f9fafb !important;
            border-radius: 8px !important;
            border: 1px solid #e5e7eb !important;
        }

        .summary-stats {
            display: flex !important;
            gap: 30px !important;
            justify-content: center !important;
        }

        .summary-item {
            text-align: center !important;
        }

        .summary-label {
            display: block !important;
            font-size: 14px !important;
            color: #6b7280 !important;
            margin-bottom: 5px !important;
        }

        .summary-value {
            display: block !important;
            font-size: 24px !important;
            font-weight: 700 !important;
            color: #111827 !important;
        }

        /* Enhanced Role Summary Section */
        .role-summary-section {
            margin: 30px 0 !important;
            padding: 25px !important;
            background: #f8fafc !important;
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
        }

        .summary-header {
            margin-bottom: 20px !important;
            text-align: center !important;
        }

        .summary-title {
            font-size: 20px !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            margin: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .summary-title i {
            margin-right: 10px !important;
            color: #3b82f6 !important;
        }

        .summary-grid {
            display: grid !important;
            grid-template-columns: repeat(auto-fit, minmax(4, 1fr)) !important;
            gap: 20px !important;
        }

        .summary-card {
            display: flex !important;
            align-items: center !important;
            background: #ffffff !important;
            padding: 20px !important;
            border-radius: 10px !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
            transition: all 0.3s ease !important;
        }

        .summary-card:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
            border-color: #3b82f6 !important;
        }

        .summary-icon {
            width: 50px !important;
            height: 50px !important;
            background: linear-gradient(135deg, #10b981, #059669) !important;
            border-radius: 12px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #ffffff !important;
            font-size: 20px !important;
            margin-right: 15px !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3) !important;
        }

        .summary-content {
            flex: 1 !important;
            display: flex !important;
            flex-direction: column !important;
        }

        .summary-role-name {
            font-size: 16px !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            margin-bottom: 5px !important;
        }

        .summary-role-count {
            font-size: 14px !important;
            color: #64748b !important;
            margin-bottom: 3px !important;
        }

        .summary-role-percentage {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #3b82f6 !important;
        }

        /* Media Player Modal Styles */
        .media-player-modal {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: rgba(0, 0, 0, 0.9) !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            z-index: 1000 !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out !important;
        }

        .media-player-modal.active {
            opacity: 1 !important;
            visibility: visible !important;
        }

        /* Media Card Styles */
        .media-card {
            transition: all 0.3s ease !important;
            border: 2px solid transparent !important;
        }

        .media-card:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
            border-color: var(--primary) !important;
        }

        .media-card:active {
            transform: translateY(-2px) !important;
        }

        .media-player-content {
            background: #ffffff !important;
            border-radius: 12px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            width: 90% !important;
            max-width: 800px !important;
            max-height: 90% !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
        }

        .media-player-header {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 16px !important;
            border-bottom: 1px solid #e5e7eb !important;
        }

        .header-actions {
            display: flex !important;
            gap: 12px !important;
            align-items: center !important;
        }

        .btn-sm {
            padding: 6px 12px !important;
            font-size: 0.875rem !important;
        }

        .modal-title {
            margin: 0 !important;
            font-size: 1.25rem !important;
            font-weight: 600 !important;
            color: #111827 !important;
        }

        .close-btn {
            background: none !important;
            border: none !important;
            font-size: 1.5rem !important;
            color: #6b7280 !important;
            cursor: pointer !important;
            transition: color 0.2s ease !important;
        }

        .close-btn:hover {
            color: #374151 !important;
        }

        /* Fullscreen Exit Button */
        .fullscreen-exit-btn {
            position: fixed !important;
            top: 20px !important;
            right: 20px !important;
            background: rgba(0, 0, 0, 0.8) !important;
            color: white !important;
            border: none !important;
            padding: 12px 16px !important;
            border-radius: 8px !important;
            cursor: pointer !important;
            z-index: 1001 !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
        }

        .fullscreen-exit-btn:hover {
            background: rgba(0, 0, 0, 0.9) !important;
            transform: scale(1.05) !important;
        }

        .fullscreen-exit-btn i {
            font-size: 1rem !important;
        }

        /* Fullscreen Exit Area */
        .exit-area {
            position: fixed !important;
            top: 20px !important;
            left: 20px !important;
            width: 60px !important;
            height: 60px !important;
            background: rgba(0, 0, 0, 0.8) !important;
            color: white !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            z-index: 1001 !important;
            transition: all 0.2s ease !important;
        }

        .exit-area:hover {
            background: rgba(0, 0, 0, 0.9) !important;
            transform: scale(1.1) !important;
        }

        .exit-area i {
            font-size: 1.5rem !important;
        }

        .media-player-body {
            flex-grow: 1 !important;
            padding: 16px !important;
            min-height: 400px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Photo display in modal */
        .media-player-body img {
            max-width: 100% !important;
            max-height: 100% !important;
            object-fit: contain !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
        }

        /* Fullscreen photo optimization */
        .media-player-modal.fullscreen-mode .media-player-body img {
            max-width: 100vw !important;
            max-height: 100vh !important;
            object-fit: contain !important;
        }

        /* Loading and Error States */
        .loading-state,
        .error-state {
            text-align: center !important;
            color: #6b7280 !important;
        }

        .loading-spinner {
            width: 40px !important;
            height: 40px !important;
            border: 4px solid #e5e7eb !important;
            border-top: 4px solid #3b82f6 !important;
            border-radius: 50% !important;
            animation: spin 1s linear infinite !important;
            margin: 0 auto 16px !important;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg) !important;
            }

            100% {
                transform: rotate(360deg) !important;
            }
        }

        .error-state h4 {
            color: #111827 !important;
            margin-bottom: 8px !important;
        }

        .error-state p {
            margin-bottom: 16px !important;
        }

        .video-player {
            width: 100% !important;
            height: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .audio-player {
            width: 100% !important;
            text-align: center !important;
        }

        .audio-info {
            margin-bottom: 24px !important;
        }

        .audio-cover {
            width: 120px !important;
            height: 120px !important;
            background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%) !important;
            border-radius: 12px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 auto 16px !important;
            color: white !important;
            font-size: 3rem !important;
        }

        .audio-title {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            color: #111827 !important;
            margin-bottom: 8px !important;
        }

        .audio-description {
            color: #6b7280 !important;
            font-size: 1rem !important;
            margin-bottom: 0 !important;
        }

        .media-player-footer {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 16px !important;
            border-top: 1px solid #e5e7eb !important;
            background: #f9fafb !important;
        }

        .media-meta {
            display: flex !important;
            gap: 12px !important;
            align-items: center !important;
        }

        .media-type-badge {
            background: #3b82f6 !important;
            color: white !important;
            padding: 4px 8px !important;
            border-radius: 6px !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
        }

        .media-date {
            color: #6b7280 !important;
            font-size: 0.875rem !important;
        }

        .media-actions {
            display: flex !important;
            gap: 12px !important;
        }

        .media-actions.enhanced-actions {
            padding: 16px 20px;
            background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
            border-top: 1px solid rgba(226, 232, 240, 0.5);
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: auto;
            flex-shrink: 0;
        }

        .action-group {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .action-group.primary-actions {
            justify-content: center;
        }

        .action-group.secondary-actions {
            justify-content: center;
            opacity: 0.8;
        }

        .action-btn.enhanced-action {
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .action-btn.enhanced-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .action-btn.enhanced-action:hover::before {
            left: 100%;
        }

        .action-btn.enhanced-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-tooltip {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 1000;
        }

        .action-btn.enhanced-action:hover .btn-tooltip {
            opacity: 1;
        }

        .btn {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 8px 16px !important;
            border-radius: 6px !important;
            text-decoration: none !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            border: none !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }

        .btn-primary {
            background: #3b82f6 !important;
            color: white !important;
        }

        .btn-primary:hover {
            background: #2563eb !important;
        }

        .btn-secondary {
            background: #6b7280 !important;
            color: white !important;
        }

        .btn-secondary:hover {
            background: #4b5563 !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .media-player-content {
                width: 95% !important;
                max-height: 95% !important;
            }

            .media-player-footer {
                flex-direction: column !important;
                gap: 16px !important;
                align-items: stretch !important;
            }

            .media-actions {
                justify-content: center !important;
            }
        }

        /* Enhanced User Edit Page Styles */
        .user-edit-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .enhanced-form-grid {
            display: grid !important;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)) !important;
            gap: 30px !important;
            margin-bottom: 30px !important;
        }

        .form-section {
            background: #ffffff !important;
            border-radius: 12px !important;
            padding: 25px !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
            transition: all 0.3s ease !important;
        }

        .form-section:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
            border-color: #3b82f6 !important;
        }

        .section-header {
            margin-bottom: 20px !important;
            padding-bottom: 15px !important;
            border-bottom: 2px solid #f1f5f9 !important;
        }

        .section-title {
            font-size: 18px !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            margin: 0 0 8px 0 !important;
            display: flex !important;
            align-items: center !important;
        }

        .section-title i {
            margin-right: 10px !important;
            color: #3b82f6 !important;
            width: 20px !important;
        }

        .section-subtitle {
            color: #64748b !important;
            font-size: 14px !important;
            margin: 0 !important;
        }

        .form-row {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 20px !important;
            margin-bottom: 20px !important;
        }

        .form-group {
            position: relative !important;
        }

        .form-group.full-width {
            grid-column: 1 / -1 !important;
        }

        .enhanced-label {
            display: block !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            color: #374151 !important;
            margin-bottom: 8px !important;
            display: flex !important;
            align-items: center !important;
        }

        .enhanced-label i {
            margin-right: 8px !important;
            color: #6b7280 !important;
            width: 16px !important;
        }

        .enhanced-input,
        .enhanced-select,
        .enhanced-textarea {
            width: 100% !important;
            padding: 12px 16px !important;
            border: 2px solid #e5e7eb !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
            background: #ffffff !important;
        }

        .enhanced-input:focus,
        .enhanced-select:focus,
        .enhanced-textarea:focus {
            outline: none !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }

        .enhanced-input.error,
        .enhanced-select.error,
        .enhanced-textarea.error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }

        .enhanced-input-group {
            position: relative !important;
        }

        .password-toggle {
            position: absolute !important;
            right: 12px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            background: none !important;
            border: none !important;
            color: #6b7280 !important;
            cursor: pointer !important;
            padding: 4px !important;
            transition: color 0.2s ease !important;
        }

        .password-toggle:hover {
            color: #3b82f6 !important;
        }

        .toggle-switch {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
        }

        .enhanced-toggle {
            display: none !important;
        }

        .toggle-label {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            cursor: pointer !important;
            user-select: none !important;
        }

        .toggle-text {
            font-size: 14px !important;
            color: #374151 !important;
            font-weight: 500 !important;
        }

        .toggle-slider {
            width: 50px !important;
            height: 26px !important;
            background: #d1d5db !important;
            border-radius: 13px !important;
            position: relative !important;
            transition: all 0.3s ease !important;
        }

        .toggle-slider::before {
            content: '' !important;
            position: absolute !important;
            width: 20px !important;
            height: 20px !important;
            background: #ffffff !important;
            border-radius: 50% !important;
            top: 3px !important;
            left: 3px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2) !important;
        }

        .enhanced-toggle:checked+.toggle-label .toggle-slider {
            background: #3b82f6 !important;
        }

        .enhanced-toggle:checked+.toggle-label .toggle-slider::before {
            transform: translateX(24px) !important;
        }

        .enhanced-actions {
            display: flex !important;
            justify-content: center !important;
            padding: 20px 0 !important;
        }

        .action-buttons {
            display: flex !important;
            gap: 15px !important;
            align-items: center !important;
        }

        .submit-btn {
            position: relative !important;
            overflow: hidden !important;
        }

        .submit-btn::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: -100% !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent) !important;
            transition: left 0.5s ease !important;
        }

        .submit-btn:hover::before {
            left: 100% !important;
        }

        .enhanced-error {
            background: #fef2f2 !important;
            border: 1px solid #fecaca !important;
            color: #dc2626 !important;
            padding: 12px 16px !important;
            border-radius: 8px !important;
            margin-bottom: 20px !important;
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            font-weight: 500 !important;
        }

        .error-message {
            color: #dc2626 !important;
            font-size: 12px !important;
            margin-top: 5px !important;
            display: block !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .enhanced-form-grid {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }

            .form-row {
                grid-template-columns: 1fr !important;
                gap: 15px !important;
            }

            .action-buttons {
                flex-direction: column !important;
                width: 100% !important;
            }

            .action-btn {
                width: 100% !important;
            }
        }

        /* User Quick Info Card Styles */
        .user-quick-info {
            margin: 20px 0 !important;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
            border: 1px solid #cbd5e1 !important;
        }

        .quick-info-header {
            display: flex !important;
            align-items: center !important;
            gap: 20px !important;
            padding: 25px !important;
        }


        .user-summary {
            flex: 1 !important;
        }

        .user-email {
            font-size: 16px !important;
            color: #64748b !important;
            margin: 0 0 15px 0 !important;
            font-weight: 500 !important;
        }

        .user-meta {
            display: flex !important;
            gap: 20px !important;
            flex-wrap: wrap !important;
        }

        .meta-item {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            font-size: 14px !important;
            color: #64748b !important;
            background: rgba(255, 255, 255, 0.7) !important;
            padding: 6px 12px !important;
            border-radius: 20px !important;
            font-weight: 500 !important;
        }

        .meta-item i {
            color: #3b82f6 !important;
            font-size: 12px !important;
        }

        .user-status {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 10px !important;
        }

        .status-badge {
            padding: 8px 16px !important;
            border-radius: 20px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        .status-badge.active {
            background: #dcfce7 !important;
            color: #166534 !important;
            border: 1px solid #bbf7d0 !important;
        }

        .status-badge.inactive {
            background: #fef2f2 !important;
            color: #dc2626 !important;
            border: 1px solid #fecaca !important;
        }

        .status-badge i {
            font-size: 12px !important;
        }

        /* Responsive adjustments for quick info */
        @media (max-width: 768px) {
            .quick-info-header {
                flex-direction: column !important;
                text-align: center !important;
                gap: 15px !important;
            }

            .user-meta {
                justify-content: center !important;
            }

            .user-status {
                flex-direction: row !important;
            }
        }

        /* Password Strength Indicator Styles */
        .password-strength {
            margin-top: 10px !important;
            height: 6px !important;
            background: #e5e7eb !important;
            border-radius: 3px !important;
            overflow: hidden !important;
        }

        .password-strength::before {
            content: '' !important;
            display: block !important;
            height: 100% !important;
            width: 0% !important;
            transition: all 0.3s ease !important;
            border-radius: 3px !important;
        }

        .password-strength.weak::before {
            width: 25% !important;
            background: #ef4444 !important;
        }

        .password-strength.fair::before {
            width: 50% !important;
            background: #f59e0b !important;
        }

        .password-strength.good::before {
            width: 75% !important;
            background: #10b981 !important;
        }

        .password-strength.strong::before {
            width: 100% !important;
            background: #059669 !important;
        }

        .password-requirements {
            margin-top: 15px !important;
            display: grid !important;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) !important;
            gap: 8px !important;
        }

        .requirement-item {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            font-size: 12px !important;
            color: #6b7280 !important;
            transition: color 0.3s ease !important;
        }

        .requirement-item i {
            font-size: 8px !important;
            transition: all 0.3s ease !important;
        }

        .requirement-item.met {
            color: #10b981 !important;
        }

        .requirement-item.met i {
            color: #10b981 !important;
            transform: scale(1.2) !important;
        }

        .password-match {
            margin-top: 10px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }

        .password-match.match {
            color: #10b981 !important;
        }

        .password-match.no-match {
            color: #ef4444 !important;
        }

        .password-match i {
            font-size: 14px !important;
        }

        /* Enhanced Role Edit Page Styles */
        .role-edit-header {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%) !important;
        }

        .enhanced-banner {
            margin: 20px 0 !important;
            padding: 20px !important;
            border-radius: 12px !important;
            display: flex !important;
            align-items: center !important;
            gap: 15px !important;
            font-weight: 500 !important;
        }

        .enhanced-banner.inactive {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%) !important;
            border: 1px solid #f59e0b !important;
            color: #92400e !important;
        }

        .enhanced-banner i {
            font-size: 24px !important;
            color: #f59e0b !important;
        }

        .banner-content {
            display: flex !important;
            flex-direction: column !important;
            gap: 5px !important;
        }

        .banner-content strong {
            font-size: 16px !important;
            font-weight: 600 !important;
        }

        .banner-content span {
            font-size: 14px !important;
            opacity: 0.9 !important;
        }

        /* Enhanced Permissions Grid */
        .permissions-grid {
            display: flex !important;
            flex-direction: column !important;
            gap: 20px !important;
            width: 100% !important;
        }

        .permission-module {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;
            width: 100% !important;
            min-width: 0 !important;
        }

        .permission-module:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
            border-color: #8b5cf6 !important;
        }

        .module-header {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 20px !important;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
            border-bottom: 1px solid #e2e8f0 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            min-height: 60px !important;
        }

        .module-header:hover {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
        }

        .module-title {
            font-size: 18px !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            margin: 0 !important;
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            flex: 1 !important;
            min-width: 0 !important;
        }

        .module-title i {
            color: #8b5cf6 !important;
            font-size: 20px !important;
            flex-shrink: 0 !important;
        }

        .module-toggle {
            display: flex !important;
            align-items: center !important;
        }

        .toggle-module {
            background: none !important;
            border: none !important;
            color: #64748b !important;
            font-size: 16px !important;
            cursor: pointer !important;
            padding: 8px !important;
            border-radius: 6px !important;
            transition: all 0.2s ease !important;
        }

        .toggle-module:hover {
            color: #8b5cf6 !important;
            background: rgba(139, 92, 246, 0.1) !important;
        }

        .permissions-list {
            padding: 0 !important;
            max-height: 400px !important;
            overflow-y: auto !important;
            width: 100% !important;
        }

        .permissions-list::-webkit-scrollbar {
            width: 10px !important;
        }

        .permissions-list::-webkit-scrollbar-track {
            background: #f8fafc !important;
            border-radius: 6px !important;
            margin: 4px 0 !important;
        }

        .permissions-list::-webkit-scrollbar-thumb {
            background: #cbd5e1 !important;
            border-radius: 6px !important;
            border: 2px solid #f8fafc !important;
            transition: background 0.2s ease !important;
        }

        .permissions-list::-webkit-scrollbar-thumb:hover {
            background: #8b5cf6 !important;
        }

        .permissions-list::-webkit-scrollbar-corner {
            background: #f8fafc !important;
        }

        .permission-item {
            padding: 10px 20px 0px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            transition: all 0.2s ease !important;
        }

        .permission-item:last-child {
            border-bottom: none !important;
        }

        .permission-item:hover {
            background: #f8fafc !important;
        }

        .permission-checkbox {
            display: flex !important;
            align-items: center !important;
            gap: 15px !important;
            cursor: pointer !important;
            user-select: none !important;
            width: 100% !important;
            position: relative !important;
            min-height: 32px !important;
            padding: 4px 0 !important;
        }

        /* Style the standard checkboxes */
        .permission-checkbox .enhanced-checkbox {
            width: 20px !important;
            height: 20px !important;
            accent-color: #8b5cf6 !important;
            cursor: pointer !important;
            margin-top: 2px !important;
            flex-shrink: 0 !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: static !important;
        }

        .permission-checkbox .enhanced-checkbox:checked {
            background-color: #8b5cf6 !important;
            border-color: #8b5cf6 !important;
        }

        .permission-checkbox .enhanced-checkbox:focus {
            outline: 2px solid rgba(139, 92, 246, 0.3) !important;
            outline-offset: 2px !important;
        }

        /* Ensure checkboxes are visible and properly styled */
        .permission-checkbox input[type="checkbox"] {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: static !important;
            width: 20px !important;
            height: 20px !important;
            margin: 0 !important;
            padding: 0 !important;
            border: 2px solid #d1d5db !important;
            border-radius: 4px !important;
            background: #ffffff !important;
            cursor: pointer !important;
            flex-shrink: 0 !important;
        }

        .permission-checkbox input[type="checkbox"]:checked {
            background-color: #8b5cf6 !important;
            border-color: #8b5cf6 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e") !important;
            background-size: 16px 16px !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
        }

        .enhanced-checkbox {
            display: none !important;
        }



        .permission-info {
            flex: 1 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 8px !important;
            min-width: 0 !important;
            overflow: hidden !important;
        }

        /* Consolidated permission name styles */
        .permission-name {
            font-size: 15px !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            line-height: 1.3 !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            position: relative !important;
            cursor: help !important;
            border: none !important;
            outline: none !important;
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
            box-shadow: none !important;
            text-decoration: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
        }

        .permission-description {
            font-size: 13px !important;
            color: #64748b !important;
            line-height: 1.5 !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            hyphens: auto !important;
            max-width: 100% !important;
        }

        /* Consolidated border removal for all permission elements */
        .permission-item,
        .permission-checkbox,
        .permission-info,
        .permission-name,
        .permission-name:hover,
        .permission-name:focus,
        .permission-name:active,
        .permission-name *,
        .permission-checkbox label,
        .permission-checkbox label * {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }

        /* Ensure transparent background for permission names */
        .permission-name,
        .permission-name:hover,
        .permission-name:focus,
        .permission-name:active {
            background: transparent !important;
        }

        .permission-name::after {
            content: attr(data-tooltip) !important;
            position: absolute !important;
            bottom: 100% !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            background: #1e293b !important;
            color: white !important;
            padding: 8px 12px !important;
            border-radius: 6px !important;
            font-size: 12px !important;
            font-weight: 400 !important;
            line-height: 1.4 !important;
            white-space: nowrap !important;
            max-width: 300px !important;
            white-space: normal !important;
            text-align: center !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transition: all 0.2s ease !important;
            z-index: 1000 !important;
            pointer-events: none !important;
        }

        /* Only show tooltip if there's actual content */
        .permission-name[data-tooltip=""]::after,
        .permission-name[data-tooltip="No description available"]::after,
        .permission-name[data-tooltip="null"]::after,
        .permission-name[data-tooltip="undefined"]::after {
            display: none !important;
        }

        /* Hide tooltip arrow if no content */
        .permission-name[data-tooltip=""]::before,
        .permission-name[data-tooltip="No description available"]::before,
        .permission-name[data-tooltip="null"]::before,
        .permission-name[data-tooltip="undefined"]::before {
            display: none !important;
        }

        /* Handle different tooltip states */
        .permission-name.no-tooltip {
            cursor: default !important;
        }

        .permission-name.has-tooltip {
            cursor: help !important;
        }

        /* Hide tooltips for empty content */
        .permission-name.no-tooltip::after,
        .permission-name.no-tooltip::before {
            display: none !important;
        }

        .permission-name::before {
            content: '' !important;
            position: absolute !important;
            bottom: 100% !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            border: 5px solid transparent !important;
            border-top-color: #1e293b !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transition: all 0.2s ease !important;
            z-index: 1000 !important;
            pointer-events: none !important;
        }

        .permission-name:hover::after,
        .permission-name:hover::before {
            opacity: 1 !important;
            visibility: visible !important;
            bottom: calc(100% + 5px) !important;
        }

        .permission-name:hover::before {
            bottom: calc(100% + 10px) !important;
        }

        /* Priority Level Styling */
        .priority-indicator {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 6px 12px !important;
            border-radius: 20px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        .priority-low {
            background: #dcfce7 !important;
            color: #166534 !important;
        }

        .priority-medium {
            background: #fef3c7 !important;
            color: #92400e !important;
        }

        .priority-high {
            background: #fed7aa !important;
            color: #c2410c !important;
        }

        .priority-critical {
            background: #fee2e2 !important;
            color: #dc2626 !important;
        }

        /* Enhanced Form Sections for Roles */
        .role-form .form-section {
            border-left: 4px solid transparent !important;
            transition: all 0.3s ease !important;
        }

        .role-form .form-section:hover {
            border-left-color: #8b5cf6 !important;
        }

        .role-form .section-header {
            background: linear-gradient(135deg, var(--white) 0%, var(--gray-50) 100%) !important;
            margin: -25px -25px 20px -25px !important;
            padding: 20px 25px !important;
            border-bottom: 1px solid var(--gray-200) !important;
        }

        .role-form .section-title {
            color: var(--gray-900) !important;
        }

        .role-form .section-title i {
            color: var(--primary) !important;
        }

        /* Responsive adjustments for role edit */
        @media (max-width: 768px) {
            .permissions-grid {
                gap: 15px !important;
            }

            .module-header {
                padding: 15px !important;
                min-height: 50px !important;
            }

            .permission-item {
                padding: 15px !important;
                min-height: 70px !important;
            }

            .permission-checkbox {
                gap: 15px !important;
            }

            .checkmark {
                width: 22px !important;
                height: 22px !important;
            }

            .permission-name {
                font-size: 14px !important;
            }

            .permission-description {
                font-size: 12px !important;
            }

            .permissions-controls {
                gap: 8px !important;
            }

            .permissions-controls .btn {
                padding: 6px 12px !important;
                font-size: 13px !important;
            }

            .permissions-summary {
                flex-direction: column !important;
                gap: 10px !important;
            }
        }

        @media (max-width: 480px) {
            .module-title {
                font-size: 16px !important;
            }

            .permission-item {
                padding: 12px !important;
            }

            .permission-checkbox {
                gap: 12px !important;
            }

            .checkmark {
                width: 20px !important;
                height: 20px !important;
            }

            /* Disable tooltips on mobile for better UX */
            .permission-name::after,
            .permission-name::before {
                display: none !important;
            }

            .permission-name {
                cursor: default !important;
            }
        }

        /* Role Quick Info Card Styles */
        .role-quick-info {
            margin: 20px 0 !important;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
            border: 1px solid #cbd5e1 !important;
        }

        .role-avatar {
            width: 80px !important;
            height: 80px !important;
            background: linear-gradient(135deg, #8b5cf6, #7c3aed) !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: white !important;
            font-size: 2.5rem !important;
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3) !important;
        }

        .role-name {
            font-size: 24px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin: 0 0 5px 0 !important;
        }

        .role-slug {
            font-size: 16px !important;
            color: #64748b !important;
            margin: 0 0 15px 0 !important;
            font-weight: 500 !important;
            font-family: 'Courier New', monospace !important;
            background: rgba(255, 255, 255, 0.7) !important;
            padding: 4px 12px !important;
            border-radius: 20px !important;
            display: inline-block !important;
        }

        .role-meta .meta-item.priority-low {
            background: #dcfce7 !important;
            color: #166534 !important;
        }

        .role-meta .meta-item.priority-medium {
            background: #fef3c7 !important;
            color: #92400e !important;
        }

        .role-meta .meta-item.priority-high {
            background: #fed7aa !important;
            color: #c2410c !important;
        }

        .role-meta .meta-item.priority-critical {
            background: #fee2e2 !important;
            color: #dc2626 !important;
        }

        .priority-preview {
            margin-top: 10px !important;
        }

        .priority-preview .priority-indicator {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 8px 16px !important;
            border-radius: 20px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            transition: all 0.3s ease !important;
        }

        /* Permissions Controls and Summary */
        .permissions-summary {
            display: flex !important;
            gap: 20px !important;
            margin-top: 15px !important;
        }

        .summary-item {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            font-size: 14px !important;
            color: #64748b !important;
            font-weight: 500 !important;
        }

        .summary-item i {
            color: #8b5cf6 !important;
            font-size: 16px !important;
        }

        .summary-item span:last-child {
            font-weight: 600 !important;
            color: #1e293b !important;
        }

        .permissions-controls {
            display: flex !important;
            gap: 10px !important;
            margin-bottom: 20px !important;
            flex-wrap: wrap !important;
        }

        .permissions-controls .btn {
            padding: 8px 16px !important;
            font-size: 14px !important;
            border-radius: 8px !important;
            transition: all 0.2s ease !important;
        }

        .permissions-controls .btn:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2) !important;
        }

        .module-count {
            font-size: 14px !important;
            color: #64748b !important;
            font-weight: 400 !important;
            margin-left: 8px !important;
        }

        /* Additional fixes for text display issues */
        .permission-item * {
            box-sizing: border-box !important;
        }

        .permission-checkbox {
            word-break: break-word !important;
            hyphens: auto !important;
        }

        .permission-info {
            word-break: break-word !important;
            hyphens: auto !important;
        }

        /* Ensure proper text wrapping */
        .permission-name,
        .permission-description {
            word-break: break-word !important;
            overflow-wrap: break-word !important;
            hyphens: auto !important;
            max-width: 100% !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }

        /* Fix for long permission names */
        .permission-name {
            white-space: normal !important;
            line-height: 1.4 !important;
        }

        /* Fix for long descriptions */
        .permission-description {
            white-space: normal !important;
            line-height: 1.6 !important;
        }

        /* Final polish for perfect alignment */
        .permission-item:not(:last-child) {
            border-bottom: 1px solid #f1f5f9 !important;
        }

        .permission-item:last-child {
            border-bottom: none !important;
        }

        /* Ensure consistent spacing */
        .permission-item+.permission-item {
            margin-top: 0 !important;
        }

        /* Better focus states for accessibility */
        .permission-checkbox:focus-within .checkmark {
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1) !important;
        }

        /* Smooth transitions for all interactive elements */
        .permission-item,
        .permission-checkbox,
        .checkmark,
        .permission-name,
        .permission-description {
            transition: all 0.2s ease !important;
        }

        /* ===== ENHANCED NOTIFICATIONS PAGE STYLES ===== */

        /* Enhanced Statistics Grid */
        .enhanced-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-6);
            margin-bottom: var(--space-8);
        }

        .stat-card.enhanced-card {
            background: var(--white);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .stat-card.enhanced-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .stat-card.enhanced-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.02), transparent);
            transition: left 0.5s ease;
        }

        .stat-card.enhanced-card:hover::before {
            left: 100%;
        }

        .stat-icon {
            position: relative;
            width: 60px;
            height: 60px;
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--space-4);
        }

        .stat-icon i {
            font-size: 1.5rem;
            color: var(--white);
            z-index: 2;
        }

        /* Colored Stat Icons */
        .stat-icon-blue {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            box-shadow: 0 4px 15px rgba(23, 52, 120, 0.3);
        }

        .stat-icon-yellow {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .stat-icon-green {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .stat-icon-purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        }

        .icon-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            filter: blur(15px);
            opacity: 0.3;
            transition: opacity 0.3s ease;
        }

        .stat-card.enhanced-card:hover .icon-glow {
            opacity: 0.6;
        }

        /* Enhanced Actions Section */
        .enhanced-actions-section {
            margin-bottom: var(--space-8);
        }

        .actions-header {
            margin-bottom: var(--space-6);
        }

        .actions-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: var(--space-3);
            margin-bottom: var(--space-2);
        }

        .actions-title i {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .actions-subtitle {
            color: var(--gray-600);
            font-size: 1rem;
        }

        .actions-grid.enhanced-grid {
            display: flex;
            flex-direction: row;
            gap: var(--space-4);
            overflow-x: auto;
            padding-bottom: var(--space-2);
        }

        .actions-grid.enhanced-grid::-webkit-scrollbar {
            height: 8px;
        }

        .actions-grid.enhanced-grid::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: var(--radius-sm);
        }

        .actions-grid.enhanced-grid::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: var(--radius-sm);
        }

        .actions-grid.enhanced-grid::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }

        .action-card.enhanced-card {
            background: var(--white);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            position: relative;
        }

        .action-card.enhanced-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            text-decoration: none;
            color: inherit;
        }

        .action-card.enhanced-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.02), transparent);
            transition: left 0.5s ease;
        }

        .action-card.enhanced-card:hover::before {
            left: 100%;
        }

        .action-card .action-icon {
            position: relative;
            width: 50px;
            height: 50px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--space-4);
        }

        .action-card .action-icon i {
            font-size: 1.25rem;
            color: var(--white);
            z-index: 2;
        }

        .action-card .action-content h4 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
        }

        .action-card .action-content p {
            color: var(--gray-600);
            font-size: 0.875rem;
            line-height: 1.5;
        }

        /* Enhanced Notifications List */
        .enhanced-list {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }

        .notification-item.enhanced-item {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .notification-item.enhanced-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .notification-item.enhanced-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.02), transparent);
            transition: left 0.5s ease;
        }

        .notification-item.enhanced-item:hover::before {
            left: 100%;
        }

        .notification-item.unread {
            border-left: 4px solid var(--primary);
            background: linear-gradient(135deg, var(--primary-50) 0%, var(--white) 100%);
        }

        .notification-header {
            padding: var(--space-6);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: var(--space-4);
        }

        .notification-title {
            flex: 1;
            min-width: 0;
        }

        .title-text {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-3);
            line-height: 1.4;
        }

        .notification-badges {
            display: flex;
            gap: var(--space-2);
            flex-wrap: wrap;
        }

        .badge.enhanced-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-1);
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius-lg);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge.enhanced-badge i {
            font-size: 0.625rem;
        }

        .notification-body {
            padding: var(--space-6);
        }

        .notification-message {
            color: var(--gray-700);
            line-height: 1.6;
            margin: 0;
        }

        .notification-footer {
            padding: var(--space-4) var(--space-6);
            background: var(--gray-50);
            border-top: 1px solid var(--gray-200);
        }

        .notification-meta.enhanced-meta {
            display: flex;
            gap: var(--space-4);
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .meta-item i {
            color: var(--gray-500);
            font-size: 0.875rem;
        }

        /* Enhanced Empty State */
        .enhanced-empty-state {
            text-align: center;
            padding: var(--space-12);
        }

        .enhanced-empty-state .empty-icon {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto var(--space-6);
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .enhanced-empty-state .empty-icon i {
            font-size: 2rem;
            color: var(--white);
            z-index: 2;
        }

        .icon-pulse {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: inherit;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.7;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.3;
            }

            100% {
                transform: scale(1);
                opacity: 0.7;
            }
        }

        .enhanced-empty-state h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-3);
        }

        .enhanced-empty-state p {
            color: var(--gray-600);
            font-size: 1rem;
            margin-bottom: var(--space-6);
        }

        .empty-actions {
            display: flex;
            gap: var(--space-4);
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Responsive Design for Notifications */
        @media (max-width: 768px) {
            .enhanced-stats {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: var(--space-4);
            }

            .actions-grid.enhanced-grid {
                flex-direction: column;
                gap: var(--space-4);
                overflow-x: visible;
            }

            .action-card.enhanced-card {
                min-width: auto;
                width: 100%;
            }

            .notification-header {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--space-3);
            }

            .notification-actions {
                width: 100%;
                display: flex;
                gap: var(--space-2);
            }

            .notification-actions .action-btn {
                flex: 1;
            }

            .notification-meta.enhanced-meta {
                flex-direction: column;
                gap: var(--space-2);
            }

            .empty-actions {
                flex-direction: column;
                align-items: center;
            }
        }

        /* ===== ENHANCED NOTIFICATIONS CREATE PAGE STYLES ===== */

        /* Enhanced Form Sections */
        .enhanced-section {
            margin-bottom: var(--space-8);
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--space-6);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
        }

        .section-header.enhanced-header {
            margin-bottom: var(--space-6);
            padding: var(--space-4) var(--space-6);
            background: linear-gradient(135deg, var(--white) 0%, var(--gray-50) 100%);
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: var(--space-3);
            margin-bottom: var(--space-2);
        }

        .section-title i {
            color: var(--primary);
            font-size: 1.125rem;
        }

        .section-description {
            color: var(--gray-700);
            font-size: 1rem;
            line-height: 1.5;
        }

        .section-subheader.enhanced-subheader {
            margin-bottom: var(--space-4);
        }

        .section-subheader h5 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: var(--space-2);
        }

        .section-subheader p {
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        /* Enhanced Template Grid */
        .template-grid.enhanced-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-6);
        }

        .template-card.enhanced-card {
            background: var(--white);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-lg);
            border: 2px solid var(--gray-200);
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            padding: var(--space-6);
        }

        .template-card.enhanced-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary);
        }

        .template-card.enhanced-card.selected {
            border-color: var(--primary);
            background: linear-gradient(135deg, var(--primary-50) 0%, var(--white) 100%);
            box-shadow: var(--shadow-xl);
            transform: translateY(-2px);
        }

        .template-card.enhanced-card.selected .template-name {
            color: var(--primary-dark);
            font-weight: 700;
        }

        .template-card.enhanced-card.selected .template-description {
            color: var(--primary);
            font-weight: 500;
        }

        .template-card.enhanced-card.selected .template-icon {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(23, 52, 120, 0.3);
        }

        .template-card.enhanced-card.selected .template-radio .enhanced-radio-label {
            border-color: var(--primary);
            background: var(--primary);
            box-shadow: 0 0 0 3px rgba(23, 52, 120, 0.2);
        }

        .template-card.enhanced-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.02), transparent);
            transition: left 0.5s ease;
        }

        .template-card.enhanced-card:hover::before {
            left: 100%;
        }

        .template-icon {
            position: relative;
            width: 60px;
            height: 60px;
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--space-4);
        }

        .template-icon i {
            font-size: 1.5rem;
            color: var(--white);
            z-index: 2;
        }

        .template-icon-rehearsal_reminder {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .template-icon-concert_announcement {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .template-icon-general_announcement {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .template-icon-birthday_wishes {
            background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
        }

        .template-icon-event_announcement {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }

        .template-content {
            margin-bottom: var(--space-4);
        }

        .template-name {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
        }

        .template-description {
            color: var(--gray-600);
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .template-radio.enhanced-radio {
            position: absolute;
            top: var(--space-4);
            right: var(--space-4);
        }

        .enhanced-radio-input {
            display: none;
        }

        .enhanced-radio-label {
            position: relative;
            width: 20px;
            height: 20px;
            border: 2px solid var(--gray-300);
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .enhanced-radio-input:checked+.enhanced-radio-label {
            border-color: var(--primary);
            background: var(--primary);
            box-shadow: 0 0 0 3px rgba(23, 52, 120, 0.2);
            transform: scale(1.1);
        }

        .enhanced-radio-input:checked+.enhanced-radio-label::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background: var(--white);
            border-radius: 50%;
        }

        /* Enhanced Form Elements */
        .enhanced-form-row {
            margin-bottom: var(--space-6);
        }

        .enhanced-form-group {
            margin-bottom: var(--space-4);
        }

        .enhanced-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: var(--space-2);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .enhanced-input,
        .enhanced-textarea {
            width: 100%;
            padding: var(--space-3) var(--space-4);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .enhanced-input:focus,
        .enhanced-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        .enhanced-input:hover,
        .enhanced-textarea:hover {
            border-color: var(--gray-300);
        }

        .enhanced-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .enhanced-help {
            margin-top: var(--space-2);
            font-size: 0.875rem;
            color: var(--gray-500);
        }

        .char-count {
            font-weight: 600;
            color: var(--primary);
        }

        /* Enhanced Recipient Options */
        .enhanced-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-4);
        }

        .recipient-option.enhanced-option {
            position: relative;
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-xl);
            padding: var(--space-6);
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .recipient-option.enhanced-option:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .recipient-option.enhanced-option input:checked~.recipient-label {
            border-color: var(--primary);
            background: linear-gradient(135deg, var(--primary-50) 0%, var(--white) 100%);
            box-shadow: 0 0 0 3px rgba(23, 52, 120, 0.1);
        }

        .recipient-option.enhanced-option input:checked~.recipient-label .recipient-content h5 {
            color: var(--primary-dark);
            font-weight: 700;
        }

        .recipient-option.enhanced-option input:checked~.recipient-label .recipient-content p {
            color: var(--primary);
            font-weight: 500;
        }

        .recipient-option.enhanced-option input:checked~.recipient-icon.enhanced-icon {
            background: var(--primary);
            transform: scale(1.1);
        }

        .recipient-option.enhanced-option::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.02), transparent);
            transition: left 0.5s ease;
        }

        .recipient-option.enhanced-option:hover::before {
            left: 100%;
        }

        .recipient-icon.enhanced-icon {
            position: relative;
            width: 50px;
            height: 50px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--space-4);
            background: var(--primary);
        }

        .recipient-icon.enhanced-icon i {
            font-size: 1.25rem;
            color: var(--white);
            z-index: 2;
        }

        .recipient-content h5 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
        }

        .recipient-content p {
            color: var(--gray-600);
            font-size: 0.875rem;
            line-height: 1.5;
        }

        /* Enhanced Checkboxes */
        .enhanced-checkbox {
            display: none;
        }

        .recipient-item.enhanced-item {
            display: flex;
            align-items: center;
            gap: var(--space-4);
            padding: var(--space-4);
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            margin-bottom: var(--space-2);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .recipient-item.enhanced-item:hover {
            background: var(--gray-50);
            border-color: var(--primary);
        }

        .recipient-item.enhanced-item input:checked+.recipient-info {
            background: linear-gradient(135deg, var(--primary-50) 0%, var(--white) 100%);
            border-color: var(--primary);
        }

        .recipient-info.enhanced-info {
            flex: 1;
            padding: var(--space-3);
            border-radius: var(--radius-md);
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .recipient-name {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-1);
        }

        .recipient-details {
            display: flex;
            gap: var(--space-3);
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .recipient-email,
        .recipient-voice,
        .recipient-role {
            padding: var(--space-1) var(--space-2);
            background: var(--gray-100);
            border-radius: var(--radius-sm);
        }

        /* Enhanced Delivery Options */
        .delivery-options.enhanced-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-4);
        }

        .delivery-option.enhanced-option {
            position: relative;
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-xl);
            padding: var(--space-6);
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .delivery-option.enhanced-option:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .delivery-option.enhanced-option input:checked~.delivery-icon {
            background: var(--primary);
            transform: scale(1.1);
        }

        .delivery-option.enhanced-option input:checked~.delivery-content h5 {
            color: var(--primary-dark);
            font-weight: 700;
        }

        .delivery-option.enhanced-option input:checked~.delivery-content p {
            color: var(--primary);
            font-weight: 500;
        }

        .delivery-option.enhanced-option::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.02), transparent);
            transition: left 0.5s ease;
        }

        .delivery-option.enhanced-option:hover::before {
            left: 100%;
        }

        .delivery-icon.enhanced-icon {
            position: relative;
            width: 50px;
            height: 50px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--space-4);
            background: var(--gray-400);
            transition: all 0.3s ease;
        }

        .delivery-icon.enhanced-icon i {
            font-size: 1.25rem;
            color: var(--white);
            z-index: 2;
        }

        .delivery-content h5 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
        }

        .delivery-content p {
            color: var(--gray-600);
            font-size: 0.875rem;
            line-height: 1.5;
        }

        /* Enhanced Form Actions */
        .form-actions.enhanced-actions {
            display: flex;
            gap: var(--space-4);
            justify-content: flex-end;
            align-items: center;
            padding-top: var(--space-6);
            border-top: 1px solid var(--gray-200);
            margin-top: var(--space-8);
        }

        /* Enhanced Button Styling */
        .enhanced-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .enhanced-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .enhanced-btn:hover::before {
            left: 100%;
        }

        .enhanced-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Enhanced Recipient List */
        .recipient-list.enhanced-list {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: var(--space-4);
            background: var(--gray-50);
        }

        /* Recipient Section Visibility */
        .recipient-section {
            margin-top: var(--space-4);
            padding: var(--space-4);
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
        }

        .recipient-section.hidden {
            display: none;
        }

        .recipient-section:not(.hidden) {
            display: block;
        }

        /* Enhanced Checkbox Styling */
        .enhanced-checkbox {
            display: none;
        }

        .recipient-item.enhanced-item input:checked~.recipient-info.enhanced-info {
            background: linear-gradient(135deg, var(--primary-50) 0%, var(--white) 100%);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(23, 52, 120, 0.1);
        }

        .recipient-item.enhanced-item input:checked~.recipient-info.enhanced-info .recipient-name {
            color: var(--primary-dark);
            font-weight: 700;
        }

        /* Enhanced Radio Input Styling */
        .enhanced-radio-input {
            display: none;
        }

        .recipient-option.enhanced-option input:checked~.recipient-content h5 {
            color: var(--primary-dark);
            font-weight: 700;
        }

        .recipient-option.enhanced-option input:checked~.recipient-content p {
            color: var(--primary);
            font-weight: 500;
        }

        /* Enhanced Visual Feedback for Selected States */
        .recipient-option.enhanced-option input:checked~.recipient-label {
            border-color: var(--primary);
            background: linear-gradient(135deg, var(--primary-50) 0%, var(--white) 100%);
            box-shadow: 0 0 0 3px rgba(23, 52, 120, 0.1);
            transform: translateY(-2px);
        }

        .delivery-option.enhanced-option input:checked~.delivery-icon {
            background: var(--primary);
            transform: scale(1.1);
        }

        .delivery-option.enhanced-option input:checked~.delivery-content h5 {
            color: var(--primary-dark);
            font-weight: 700;
        }

        .delivery-option.enhanced-option input:checked~.delivery-content p {
            color: var(--primary);
            font-weight: 500;
        }

        /* Enhanced Form Validation Styles */
        .form-input.error,
        .form-textarea.error {
            border-color: var(--error);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .error-message {
            color: var(--error);
            font-size: 0.875rem;
            margin-top: var(--space-2);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .error-message::before {
            content: '⚠';
            font-size: 1rem;
        }

        .recipient-list.enhanced-list::-webkit-scrollbar {
            width: 8px;
        }

        .recipient-list.enhanced-list::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: var(--radius-sm);
        }

        .recipient-list.enhanced-list::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }

        /* Responsive Design for Notifications Create */
        @media (max-width: 768px) {
            .template-grid.enhanced-grid {
                grid-template-columns: 1fr;
                gap: var(--space-4);
            }

            .enhanced-options {
                grid-template-columns: 1fr;
                gap: var(--space-3);
            }

            .form-actions.enhanced-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .form-actions.enhanced-actions .enhanced-btn {
                width: 100%;
            }

            .recipient-item.enhanced-item {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--space-3);
            }

            .recipient-details {
                flex-direction: column;
                gap: var(--space-2);
            }
        }

        /* ===== PROFILE PAGE SPECIFIC STYLES ===== */
        /* These styles are shared across all admin pages to eliminate duplication */

        /* Profile Content */
        .profile-content {
            margin-top: var(--space-8);
        }

        /* Enhanced Profile Header - Extends admin layout .page-header */
        .profile-header {
            background: linear-gradient(135deg, var(--primary, #1e3a8a) 0%, var(--primary-light, #3b82f6) 50%, var(--accent, #1d4ed8) 100%);
            color: var(--white, #ffffff);
            margin-bottom: var(--space-8);
            position: relative;
            overflow: hidden;
            border-radius: var(--radius-xl);
            box-shadow: 0 10px 25px -5px rgba(30, 58, 138, 0.3);
            /* Override admin layout defaults */
            padding: 0;
            border: none;
        }

        .header-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        .header-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            opacity: 0.6;
        }

        .header-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            right: -50%;
            bottom: -50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: headerGlow 8s ease-in-out infinite;
        }

        @keyframes headerGlow {

            0%,
            100% {
                transform: scale(1) rotate(0deg);
                opacity: 0.3;
            }

            50% {
                transform: scale(1.2) rotate(180deg);
                opacity: 0.6;
            }
        }

        .profile-header .header-content {
            position: relative;
            z-index: 2;
            padding: var(--space-8) var(--space-8);
            min-height: 200px;
        }

        .profile-header .header-text {
            display: flex;
            align-items: flex-start;
            gap: var(--space-6);
            margin-bottom: var(--space-6);
        }

        .profile-header .header-icon-wrapper {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            position: relative;
            flex-shrink: 0;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .profile-header .icon-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.4) 0%, transparent 70%);
            border-radius: 50%;
            animation: iconPulse 3s ease-in-out infinite;
        }

        @keyframes iconPulse {

            0%,
            100% {
                opacity: 0.4;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.1);
            }
        }

        .profile-header .header-details {
            flex: 1;
        }

        .profile-header .welcome-section {
            margin-bottom: var(--space-6);
        }

        .profile-header .header-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: var(--space-2);
            background: linear-gradient(135deg, var(--white, #ffffff) 0%, rgba(255, 255, 255, 0.9) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-header .header-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: var(--space-4);
            line-height: 1.5;
        }

        .profile-header .current-time {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.95rem;
            opacity: 0.8;
            background: rgba(255, 255, 255, 0.1);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-lg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: fit-content;
        }

        .profile-header .current-time i {
            color: var(--warning, #f59e0b);
        }

        .profile-header .header-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-4);
        }

        .profile-header .stat-item {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            background: rgba(255, 255, 255, 0.1);
            padding: var(--space-4);
            border-radius: var(--radius-xl);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .profile-header .stat-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .profile-header .stat-icon-small {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: var(--white);
            flex-shrink: 0;
        }

        .profile-header .stat-content {
            flex: 1;
        }

        .profile-header .stat-number {
            display: block;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: var(--space-1);
            color: var(--white);
        }

        .profile-header .stat-label {
            display: block;
            font-size: 0.875rem;
            opacity: 0.8;
            font-weight: 500;
        }

        .profile-header .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: var(--space-6);
        }

        .profile-header .action-group {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }

        .profile-header .status-indicator {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            background: rgba(255, 255, 255, 0.1);
            padding: var(--space-3) var(--space-4);
            border-radius: var(--radius-lg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .profile-header .status-dot {
            width: 12px;
            height: 12px;
            background: var(--success, #10b981);
            border-radius: 50%;
            position: relative;
        }

        .profile-header .status-pulse {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            background: var(--success, #10b981);
            border-radius: 50%;
            opacity: 0.6;
            animation: statusPulse 2s ease-in-out infinite;
        }

        @keyframes statusPulse {
            0% {
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 0.6;
            }

            50% {
                transform: translate(-50%, -50%) scale(1.2);
                opacity: 0.3;
            }

            100% {
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 0.6;
            }
        }

        .profile-header .quick-stats {
            display: flex;
            gap: var(--space-3);
        }

        .profile-header .quick-stat {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            background: rgba(255, 255, 255, 0.1);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .profile-header .quick-stat i {
            color: var(--success, #10b981);
            font-size: 0.75rem;
        }

        .profile-header .action-buttons {
            display: flex;
            gap: var(--space-3);
            flex-shrink: 0;
        }

        .profile-header .action-buttons .btn {
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .profile-header .action-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .profile-header .btn-outline {
            background: rgba(255, 255, 255, 0.1);
            color: var(--white);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .profile-header .btn-outline:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
        }

        /* Profile Cards */
        .profile-card,
        .profile-form-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: var(--space-6);
        }

        .profile-card .card-header,
        .profile-form-card .card-header {
            background: linear-gradient(135deg, var(--white) 0%, var(--gray-50) 100%);
            padding: var(--space-6);
            border-bottom: 1px solid var(--gray-200);
        }

        .profile-card .header-content,
        .profile-form-card .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile-card .card-title,
        .profile-form-card .card-title {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-900);
            margin: 0;
        }

        .profile-card .card-title i,
        .profile-form-card .card-title i {
            color: var(--accent);
            font-size: 1.1rem;
        }

        .profile-card .header-badge,
        .profile-form-card .header-badge {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
            color: var(--gray-600);
            font-weight: 500;
        }

        .profile-card .badge-dot,
        .profile-form-card .badge-dot {
            width: 8px;
            height: 8px;
            background: var(--accent);
            border-radius: 50%;
        }

        .profile-card .card-content,
        .profile-form-card .card-content {
            padding: var(--space-6);
        }

        /* Profile Overview */
        .profile-overview {
            display: flex;
            gap: var(--space-6);
            align-items: flex-start;
        }

        .profile-avatar {
            position: relative;
            flex-shrink: 0;
        }

        .avatar-initial {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: var(--space-3);
        }

        .avatar-status {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            background: var(--success-light);
            color: var(--success-dark);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 500;
            justify-content: center;
        }

        .avatar-status i {
            color: var(--success);
            font-size: 0.75rem;
        }

        .profile-details {
            flex: 1;
        }

        .profile-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
        }

        .profile-email {
            font-size: 1.1rem;
            color: var(--gray-600);
            margin-bottom: var(--space-1);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .profile-phone {
            font-size: 1rem;
            color: var(--gray-600);
            margin-bottom: var(--space-3);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .profile-role {
            margin-bottom: var(--space-4);
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            background: var(--accent-light);
            color: var(--accent-dark);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: var(--space-2);
        }

        .role-badge.no-role {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .role-description {
            color: var(--gray-600);
            font-size: 0.875rem;
            line-height: 1.4;
        }

        .profile-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-3);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .meta-item i {
            color: var(--accent);
            font-size: 0.75rem;
        }

        /* Form Styling */
        .form-section {
            margin-bottom: var(--space-6);
        }

        .section-header {
            margin-bottom: var(--space-4);
            padding-bottom: var(--space-3);
            border-bottom: 1px solid var(--gray-100);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: var(--space-1);
        }

        .section-title i {
            color: var(--accent);
            font-size: 1rem;
        }

        .section-subtitle {
            color: var(--gray-600);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-4);
            margin-bottom: var(--space-4);
        }

        .form-group {
            margin-bottom: var(--space-4);
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: var(--space-2);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .form-label i {
            color: var(--accent);
            font-size: 0.875rem;
        }

        .form-input {
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

        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: var(--gray-50);
        }

        .form-input:hover {
            border-color: var(--gray-300);
        }

        .input-focus-border {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s ease;
        }

        .form-input:focus~.input-focus-border {
            width: 100%;
        }

        .input-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: var(--space-3);
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-500);
            cursor: pointer;
            padding: var(--space-1);
            border-radius: var(--radius);
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--accent);
            background: var(--gray-100);
        }

        .error-message {
            display: block;
            margin-top: var(--space-2);
            color: var(--error);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: var(--space-6);
            padding-top: var(--space-4);
            border-top: 1px solid var(--gray-200);
        }

        /* Security Options */
        .security-options {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }

        .security-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--space-4);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            background: var(--white);
            transition: all 0.3s ease;
        }

        .security-item:hover {
            border-color: var(--accent);
            background: var(--gray-100);
            transform: translateX(5px);
        }

        .security-info {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .security-icon {
            width: 50px;
            height: 50px;
            background: var(--gray-100);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: var(--gray-600);
        }

        .security-content h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-1);
        }

        .security-content p {
            color: var(--gray-600);
            font-size: 0.875rem;
            line-height: 1.4;
            margin: 0;
        }

        .security-status {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .status-badge {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.verified {
            background: var(--success-light);
            color: var(--success-dark);
        }

        .status-badge.unverified {
            background: var(--warning-light);
            color: var(--warning-dark);
        }

        .status-badge.disabled {
            background: var(--gray-100);
            color: var(--gray-600);
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }



        /* Button Loading State */
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

        /* Profile Page Responsive Design */
        @media (max-width: 768px) {
            .profile-header .header-content {
                padding: var(--space-6) var(--space-4);
            }

            .profile-header .header-text {
                flex-direction: column;
                text-align: center;
                gap: var(--space-4);
            }

            .profile-header .header-icon-wrapper {
                margin: 0 auto var(--space-4);
            }

            .profile-header .header-title {
                font-size: 2rem;
                text-align: center;
            }

            .profile-header .header-subtitle {
                text-align: center;
            }

            .profile-header .current-time {
                margin: 0 auto;
            }

            .profile-header .header-stats {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: var(--space-3);
            }

            .profile-header .stat-item {
                padding: var(--space-3);
            }

            .profile-header .stat-number {
                font-size: 1.25rem;
            }

            .profile-header .header-actions {
                flex-direction: column;
                gap: var(--space-4);
                align-items: center;
            }

            .profile-header .action-group {
                align-items: center;
            }

            .profile-header .quick-stats {
                justify-content: center;
            }

            .profile-header .action-buttons {
                width: 100%;
                justify-content: center;
            }

            .profile-header .action-buttons .btn {
                flex: 1;
                max-width: 200px;
            }

            .profile-overview {
                flex-direction: column;
                text-align: center;
            }

            .profile-avatar {
                align-self: center;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .security-item {
                flex-direction: column;
                gap: var(--space-4);
                text-align: center;
            }

            .security-status {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {

            .profile-card,
            .profile-form-card {
                padding: var(--space-4);
            }

            .profile-card .card-header,
            .profile-form-card .card-header,
            .profile-card .card-content,
            .profile-form-card .card-content {
                padding: var(--space-4);
            }

            .security-item {
                padding: var(--space-3);
            }
        }

        /* Enhanced Statistics Styles - Reusable Components */
        .enhanced-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin-bottom: 16px;
            position: relative;
        }

        .stat-icon-blue {
            background: linear-gradient(135deg, #3B82F6, #1D4ED8);
        }

        .stat-icon-green {
            background: linear-gradient(135deg, #10B981, #059669);
        }

        .stat-icon-purple {
            background: linear-gradient(135deg, #8B5CF6, #7C3AED);
        }

        .stat-icon-orange {
            background: linear-gradient(135deg, #F59E0B, #D97706);
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 14px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .stat-description {
            font-size: 12px;
            color: #9ca3af;
            margin-bottom: 16px;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #6b7280;
        }

        /* Analytics Section */
        .analytics-section {
            margin-bottom: 32px;
        }

        .analytics-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .analytics-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-title i {
            color: #3B82F6;
            font-size: 18px;
        }

        .card-title h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
        }

        .card-actions {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border: none;
            background: #e2e8f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-icon:hover {
            background: #cbd5e1;
            transform: scale(1.05);
        }

        .card-content {
            padding: 24px;
        }

        /* Chart Styles */
        .chart-container {
            height: 200px;
            margin-bottom: 20px;
            position: relative;
        }

        .chart-legend {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 0;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .legend-label {
            flex: 1;
            font-size: 14px;
            color: #374151;
        }

        .legend-value {
            font-weight: 600;
            color: #1f2937;
        }

        /* Enhanced User Activity List */
        .user-activity-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .enhanced-user-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .enhanced-user-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .enhanced-user-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-color: #3B82F6;
        }

        .enhanced-user-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #3B82F6, #1D4ED8);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .enhanced-user-item:hover::before {
            opacity: 1;
        }

        .user-rank {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 50px;
        }

        .rank-badge {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: white;
            position: relative;
        }

        .rank-1 {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
        }

        .rank-2 {
            background: linear-gradient(135deg, #C0C0C0, #A8A8A8);
            box-shadow: 0 4px 15px rgba(192, 192, 192, 0.3);
        }

        .rank-3 {
            background: linear-gradient(135deg, #CD7F32, #B8860B);
            box-shadow: 0 4px 15px rgba(205, 127, 50, 0.3);
        }

        .rank-badge:not(.rank-1):not(.rank-2):not(.rank-3) {
            background: linear-gradient(135deg, #6B7280, #4B5563);
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
        }

        .enhanced-avatar {
            width: 48px;
            height: 48px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-inner {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3B82F6, #1D4ED8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            position: relative;
            z-index: 2;
        }

        .avatar-ring {
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            border: 2px solid #E5E7EB;
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .enhanced-user-item:hover .avatar-ring {
            opacity: 1;
            border-color: #3B82F6;
        }

        .user-details {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-weight: 700;
            color: #1f2937;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .user-email {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .user-role {
            font-size: 11px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .activity-stats {
            text-align: center;
            min-width: 80px;
            padding: 8px 12px;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .activity-count {
            font-size: 20px;
            font-weight: 800;
            color: #1f2937;
            line-height: 1;
            margin-bottom: 2px;
        }

        .activity-label {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .activity-percentage {
            font-size: 11px;
            color: #3B82F6;
            font-weight: 600;
        }

        .activity-visual {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-width: 120px;
        }

        .activity-bar {
            width: 100%;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
            position: relative;
        }

        .activity-progress {
            height: 100%;
            background: linear-gradient(90deg, #3B82F6, #1D4ED8);
            border-radius: 3px;
            transition: width 0.6s ease;
            position: relative;
        }

        .activity-progress::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .activity-sparkline {
            display: flex;
            gap: 3px;
            justify-content: center;
            align-items: end;
            height: 20px;
        }

        .sparkline-dot {
            width: 4px;
            background: linear-gradient(180deg, #3B82F6, #1D4ED8);
            border-radius: 2px;
            animation: sparkle 1.5s ease-in-out infinite;
        }

        .sparkline-dot:nth-child(1) {
            height: 8px;
            animation-delay: 0s;
        }

        .sparkline-dot:nth-child(2) {
            height: 12px;
            animation-delay: 0.2s;
        }

        .sparkline-dot:nth-child(3) {
            height: 16px;
            animation-delay: 0.4s;
        }

        .sparkline-dot:nth-child(4) {
            height: 10px;
            animation-delay: 0.6s;
        }

        @keyframes sparkle {

            0%,
            100% {
                opacity: 0.4;
            }

            50% {
                opacity: 1;
            }
        }

        /* Enhanced Timeline Section */
        .timeline-section {
            margin-bottom: 32px;
        }

        .timeline-enhanced {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .timeline-controls {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .live-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            background: linear-gradient(135deg, #10B981, #059669);
            border-radius: 20px;
            color: white;
            font-size: 12px;
            font-weight: 600;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.2);
            }
        }

        .enhanced-filter {
            padding: 8px 16px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            background: white;
            font-size: 14px;
            color: #374151;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .enhanced-filter:focus {
            outline: none;
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .enhanced-timeline {
            padding: 24px;
            position: relative;
        }

        .enhanced-timeline::before {
            content: '';
            position: absolute;
            left: 32px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, #e2e8f0, #f1f5f9);
        }

        .enhanced-timeline-item {
            display: flex;
            gap: 20px;
            padding: 20px 0;
            position: relative;
            transition: all 0.3s ease;
        }

        .enhanced-timeline-item:hover {
            transform: translateX(4px);
        }

        .enhanced-timeline-item:last-child {
            padding-bottom: 0;
        }

        .enhanced-timeline-item::before {
            content: '';
            position: absolute;
            left: 22px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            background: white;
            border: 3px solid #e2e8f0;
            border-radius: 50%;
            z-index: 2;
        }

        .enhanced-timeline-item[data-type="success"]::before {
            border-color: #10B981;
        }

        .enhanced-timeline-item[data-type="info"]::before {
            border-color: #3B82F6;
        }

        .enhanced-timeline-item[data-type="warning"]::before {
            border-color: #F59E0B;
        }

        .enhanced-timeline-item[data-type="error"]::before {
            border-color: #EF4444;
        }

        .timeline-marker {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            flex-shrink: 0;
            position: relative;
            z-index: 3;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .timeline-marker-success {
            background: linear-gradient(135deg, #10B981, #059669);
        }

        .timeline-marker-info {
            background: linear-gradient(135deg, #3B82F6, #1D4ED8);
        }

        .timeline-marker-warning {
            background: linear-gradient(135deg, #F59E0B, #D97706);
        }

        .timeline-marker-error {
            background: linear-gradient(135deg, #EF4444, #DC2626);
        }

        .marker-pulse {
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            border-radius: 50%;
            opacity: 0;
            animation: markerPulse 2s infinite;
        }

        .timeline-marker-success .marker-pulse {
            background: rgba(16, 185, 129, 0.3);
        }

        .timeline-marker-info .marker-pulse {
            background: rgba(59, 130, 246, 0.3);
        }

        .timeline-marker-warning .marker-pulse {
            background: rgba(245, 158, 11, 0.3);
        }

        .timeline-marker-error .marker-pulse {
            background: rgba(239, 68, 68, 0.3);
        }

        @keyframes markerPulse {
            0% {
                opacity: 0;
                transform: scale(1);
            }

            50% {
                opacity: 1;
                transform: scale(1.1);
            }

            100% {
                opacity: 0;
                transform: scale(1.2);
            }
        }

        .timeline-content {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .enhanced-timeline-item:hover .timeline-content {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            border-color: #3B82F6;
        }

        .timeline-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .timeline-title {
            font-weight: 700;
            color: #1f2937;
            font-size: 16px;
            margin: 0;
        }

        .timeline-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .success-badge {
            background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
            color: #065F46;
        }

        .info-badge {
            background: linear-gradient(135deg, #DBEAFE, #BFDBFE);
            color: #1E40AF;
        }

        .warning-badge {
            background: linear-gradient(135deg, #FEF3C7, #FDE68A);
            color: #92400E;
        }

        .error-badge {
            background: linear-gradient(135deg, #FEE2E2, #FECACA);
            color: #991B1B;
        }

        .timeline-description {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .timeline-meta {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 12px;
        }

        .timeline-time,
        .timeline-source {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #9ca3af;
        }

        .timeline-time i,
        .timeline-source i {
            font-size: 11px;
        }

        /* Enhanced Empty State */
        .enhanced-empty {
            text-align: center;
            padding: 60px 20px;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-radius: 16px;
            border: 2px dashed #cbd5e1;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #6b7280;
            font-size: 32px;
        }

        .enhanced-empty h4 {
            font-size: 18px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .enhanced-empty p {
            color: #6b7280;
            font-size: 14px;
            margin: 0;
        }

        /* Enhanced Card Headers */
        .title-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #3B82F6, #1D4ED8);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            position: relative;
        }

        .title-icon .icon-glow {
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, #3B82F6, #1D4ED8);
            border-radius: 14px;
            opacity: 0.3;
            z-index: -1;
        }

        .title-content h3 {
            margin: 0 0 4px 0;
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }

        .title-subtitle {
            margin: 0;
            font-size: 13px;
            color: #6b7280;
            font-weight: 500;
        }

        .enhanced-btn-icon {
            width: 36px;
            height: 36px;
            border: none;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #6b7280;
        }

        .enhanced-btn-icon:hover {
            background: linear-gradient(135deg, #3B82F6, #1D4ED8);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* Responsive Design for Enhanced Components */
        @media (max-width: 768px) {
            .analytics-grid {
                grid-template-columns: 1fr;
            }

            .enhanced-stats {
                grid-template-columns: 1fr;
            }

            .enhanced-user-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
                padding: 16px;
            }

            .user-info {
                width: 100%;
            }

            .activity-visual {
                width: 100%;
            }

            .activity-bar {
                width: 100%;
            }

            .timeline-controls {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }

            .enhanced-timeline-item {
                flex-direction: column;
                gap: 16px;
            }

            .timeline-marker {
                align-self: flex-start;
            }

            .enhanced-timeline::before {
                left: 24px;
            }

            .enhanced-timeline-item::before {
                left: 14px;
            }
        }

        @media (max-width: 480px) {
            .enhanced-user-item {
                padding: 12px;
            }

            .timeline-content {
                padding: 16px;
            }

            .timeline-meta {
                flex-direction: column;
                gap: 8px;
                align-items: flex-start;
            }
        }

        /* Tabbed Interface Styles */
        .upload-tabs,
        .details-tabs {
            margin-top: 1rem;
        }

        .tab-nav {
            display: flex;
            background: #f8fafc;
            border-radius: 12px;
            padding: 4px;
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .tab-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            background: transparent;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .tab-btn:hover {
            color: #475569;
            background: rgba(255, 255, 255, 0.5);
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }

        .tab-btn i {
            font-size: 1rem;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* WYSIWYG Editor Styles */
        .wysiwyg-editor {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            transition: border-color 0.2s ease;
        }

        .wysiwyg-editor:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* TinyMCE Custom Styling */
        .tox-tinymce {
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
        }

        .tox .tox-toolbar__primary {
            background: #f8fafc !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }

        .tox .tox-edit-area__iframe {
            border-radius: 0 0 8px 8px !important;
        }

        .tox .tox-tbtn {
            border-radius: 4px !important;
        }

        .tox .tox-tbtn:hover {
            background: #e2e8f0 !important;
        }

        .tox .tox-tbtn--enabled {
            background: #3b82f6 !important;
            color: white !important;
        }

        /* Lyrics Display Styles */
        .lyrics-content {
            font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
            font-size: 16px;
            line-height: 1.8;
            color: #374151;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 2rem;
            margin: 1rem 0;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .lyrics-content h1,
        .lyrics-content h2,
        .lyrics-content h3,
        .lyrics-content h4,
        .lyrics-content h5,
        .lyrics-content h6 {
            color: #1f2937;
            margin: 1.5rem 0 1rem 0;
            font-weight: 600;
        }

        .lyrics-content p {
            margin: 1rem 0;
            line-height: 1.8;
        }

        .lyrics-content strong {
            color: #1f2937;
            font-weight: 600;
        }

        .lyrics-content em {
            font-style: italic;
            color: #6b7280;
        }

        .lyrics-content ul,
        .lyrics-content ol {
            margin: 1rem 0;
            padding-left: 2rem;
        }

        .lyrics-content li {
            margin: 0.5rem 0;
            line-height: 1.6;
        }

        .lyrics-content blockquote {
            border-left: 4px solid #3b82f6;
            padding-left: 1rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: #6b7280;
            background: #f1f5f9;
            padding: 1rem;
            border-radius: 8px;
        }

        .lyrics-content a {
            color: #3b82f6;
            text-decoration: underline;
        }

        .lyrics-content a:hover {
            color: #1d4ed8;
        }

        .lyrics-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        .lyrics-content th,
        .lyrics-content td {
            border: 1px solid #e2e8f0;
            padding: 0.75rem;
            text-align: left;
        }

        .lyrics-content th {
            background: #f8fafc;
            font-weight: 600;
        }

        /* Print styles for lyrics */
        @media print {
            .lyrics-content {
                background: white;
                border: 1px solid #000;
                box-shadow: none;
            }
        }

        /* Enhanced Certificate Styles */
        .certificate-container {
            position: relative;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 3px solid #1e40af;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            font-family: 'Times New Roman', serif;
            color: #1e293b;
            min-height: 600px;
        }

        /* Musical Staff Background */
        .musical-staff-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.1;
            z-index: 1;
            pointer-events: none;
        }

        .staff-lines {
            position: absolute;
            top: 50%;
            left: 10%;
            right: 10%;
            height: 2px;
            background: repeating-linear-gradient(to right,
                    #1e40af 0px,
                    #1e40af 20px,
                    transparent 20px,
                    transparent 40px);
            transform: translateY(-50%);
        }

        .staff-lines::before,
        .staff-lines::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            height: 2px;
            background: #1e40af;
        }

        .staff-lines::before {
            top: -20px;
        }

        .staff-lines::after {
            top: 20px;
        }

        .musical-notes {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .note {
            position: absolute;
            font-size: 2rem;
            color: #1e40af;
            animation: float 6s ease-in-out infinite;
        }

        .note-1 {
            top: 20%;
            left: 15%;
            animation-delay: 0s;
        }

        .note-2 {
            top: 30%;
            right: 20%;
            animation-delay: 1s;
        }

        .note-3 {
            top: 60%;
            left: 25%;
            animation-delay: 2s;
        }

        .note-4 {
            top: 70%;
            right: 15%;
            animation-delay: 3s;
        }

        .note-5 {
            top: 40%;
            left: 60%;
            animation-delay: 4s;
        }

        .note-6 {
            top: 80%;
            right: 40%;
            animation-delay: 5s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) rotate(5deg);
            }
        }

        /* Decorative Border */
        .certificate-border {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 2;
            pointer-events: none;
        }

        .corner-decoration {
            position: absolute;
            width: 60px;
            height: 60px;
            border: 3px solid #1e40af;
            opacity: 0.6;
        }

        .corner-decoration.top-left {
            top: 20px;
            left: 20px;
            border-right: none;
            border-bottom: none;
        }

        .corner-decoration.top-right {
            top: 20px;
            right: 20px;
            border-left: none;
            border-bottom: none;
        }

        .corner-decoration.bottom-left {
            bottom: 20px;
            left: 20px;
            border-right: none;
            border-top: none;
        }

        .corner-decoration.bottom-right {
            bottom: 20px;
            right: 20px;
            border-left: none;
            border-top: none;
        }

        /* Certificate Content */
        .certificate-content {
            position: relative;
            z-index: 3;
            padding: 40px;
            text-align: center;
        }

        /* Header Section */
        .certificate-header-section {
            margin-bottom: 30px;
        }

        .logo-section {
            margin-bottom: 20px;
        }

        .choir-logo {
            display: inline-block;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 8px 16px rgba(30, 64, 175, 0.3);
        }

        .choir-logo i {
            font-size: 2.5rem;
            color: white;
        }

        .main-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: 2px;
        }

        .subtitle {
            font-size: 1.5rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .title-underline {
            width: 200px;
            height: 3px;
            background: linear-gradient(90deg, #1e40af, #3b82f6);
            margin: 0 auto 20px;
            border-radius: 2px;
        }

        .presenter-line {
            font-size: 1rem;
            color: #6b7280;
            font-style: italic;
        }

        /* Member Name Section */
        .member-name-section {
            margin: 40px 0;
        }

        .name-underline {
            width: 300px;
            height: 4px;
            background: linear-gradient(90deg, #1e40af, #3b82f6, #8b5cf6);
            margin: 0 auto;
            border-radius: 2px;
        }

        /* Scripture Section */
        .scripture-section {
            margin: 40px 0;
            padding: 30px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 15px;
            border: 2px solid #e2e8f0;
        }

        .scripture-quote {
            position: relative;
        }

        .quote-marks {
            font-size: 4rem;
            color: #1e40af;
            font-weight: 700;
            line-height: 1;
            opacity: 0.3;
        }

        .verse-text {
            font-size: 1.2rem;
            color: #374151;
            font-style: italic;
            margin: 20px 0;
            line-height: 1.6;
        }

        .verse-reference {
            font-size: 1rem;
            color: #1e40af;
            font-weight: 600;
            margin-top: 15px;
        }

        /* Appreciation Section */
        .appreciation-section {
            margin: 40px 0;
        }

        .appreciation-text {
            font-size: 1.1rem;
            color: #374151;
            line-height: 1.8;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Member Details Section */
        .member-details-section {
            margin: 40px 0;
        }

        .member-info-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .member-info {
            font-size: 1.2rem;
            color: #374151;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .member-id {
            font-size: 1rem;
            color: #1e40af;
            font-weight: 600;
            background: #e0e7ff;
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
        }

        /* Signature Section */
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin: 50px 0 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .signature-line {
            text-align: center;
            flex: 1;
            margin: 0 20px;
        }

        .signature-line .line {
            width: 150px;
            height: 2px;
            background: #1e40af;
            margin: 0 auto 10px;
        }

        .signature-line .label {
            font-size: 0.9rem;
            color: #6b7280;
            font-weight: 600;
        }

        /* Date Section */
        .date-section {
            margin: 30px 0;
        }

        .certificate-date {
            font-size: 1.1rem;
            color: #374151;
            font-weight: 600;
        }

        /* Certificate Number */
        .certificate-number {
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: 0.9rem;
            color: #6b7280;
            font-weight: 600;
            background: #f8fafc;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 8rem;
            color: rgba(30, 64, 175, 0.05);
            font-weight: 900;
            pointer-events: none;
            z-index: 1;
        }

        /* Certificate Actions */
        .certificate-actions {
            margin: 2rem 0;
            text-align: center;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid #e2e8f0;
        }

        .certificate-actions .action-buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
        }

        .certificate-actions .primary-download {
            min-width: 250px;
            font-size: 1.1rem;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            box-shadow: 0 8px 16px rgba(16, 185, 129, 0.3);
            transform: scale(1.05);
        }

        .certificate-actions .primary-download:hover {
            transform: scale(1.08);
            box-shadow: 0 12px 24px rgba(16, 185, 129, 0.4);
        }

        .certificate-actions .primary-download.downloading {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            transform: scale(1.02);
            cursor: not-allowed;
        }

        .certificate-actions .secondary-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .certificate-actions .secondary-actions .btn {
            min-width: 120px;
        }

        .download-info {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .download-info .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .download-info .info-item i {
            color: #10b981;
            font-size: 1rem;
        }

        .direct-download-link {
            color: #3b82f6;
            text-decoration: underline;
            font-weight: 600;
        }

        .direct-download-link:hover {
            color: #1d4ed8;
            text-decoration: none;
        }

        /* Certificate Wrapper */
        .certificate-wrapper {
            background: #f8fafc;
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Zoom Controls */
        .zoom-controls {
            display: flex;
            gap: 0.5rem;
            margin-left: auto;
        }

        .zoom-btn {
            width: 40px;
            height: 40px;
            border: 1px solid #e2e8f0;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .zoom-btn:hover {
            background: #f8fafc;
            border-color: #3b82f6;
        }

        .zoom-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Print Styles for Certificate */
        @media print {
            .certificate-container {
                box-shadow: none;
                border: 3px solid #000;
                background: white;
            }

            .musical-staff-bg {
                opacity: 0.15;
            }

            .note {
                animation: none;
            }

            .main-title {
                color: #000;
            }

            .subtitle {
                color: #333;
            }

            .member-name {
                color: #000;
            }

            .watermark {
                opacity: 0.1;
            }
        }
    </style>

    <!-- TinyMCE WYSIWYG Editor -->
    <script src="https://cdn.tiny.cloud/1/s13kred5sbpmspsjbqxccuer6faly6x2yvza6tytdayd01io/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
</head>

<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <!-- Horizontal logo (shown when sidebar is open) -->
                    <img src="{{ asset('ths-logo-horizontal.svg') }}" alt="The Harmony Singers"
                        class="sidebar-logo-horizontal">

                    <!-- Circular logo (shown when sidebar is collapsed) -->
                    <img src="{{ asset('ths-logo.svg') }}" alt="THS" class="sidebar-logo-circular">
                </div>

            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Main</div>
                    @permission('view_dashboard')
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                    @endpermission
                    <a href="{{ route('admin.profile') }}"
                        class="nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}" title="Profile">
                        <i class="fas fa-user nav-icon"></i>
                        <span class="nav-text">Profile</span>
                    </a>
                </div>

                @permission('view_members')
                <div class="nav-section">
                    <div class="nav-section-title">Member Management</div>
                    <a href="{{ route('admin.members.index') }}"
                        class="nav-item {{ request()->routeIs('admin.members.*') ? 'active' : '' }}"
                        title="All Members">
                        <i class="fas fa-users nav-icon"></i>
                        <span class="nav-text">All Members</span>
                    </a>
                    <a href="{{ route('admin.members.index', ['type' => 'singer']) }}"
                        class="nav-item {{ request('type') === 'singer' ? 'active' : '' }}" title="Singers">
                        <i class="fas fa-music nav-icon"></i>
                        <span class="nav-text">Singers</span>
                    </a>
                    <a href="{{ route('admin.members.index', ['type' => 'general']) }}"
                        class="nav-item {{ request('type') === 'general' ? 'active' : '' }}" title="General Members">
                        <i class="fas fa-user-friends nav-icon"></i>
                        <span class="nav-text">General Members</span>
                    </a>
                    @endpermission

                    @permission('view_concerts')
                    <a href="{{ route('admin.concerts.index') }}"
                        class="nav-item {{ request()->routeIs('admin.concerts.*') ? 'active' : '' }}" title="Concerts">
                        <i class="fas fa-music nav-icon"></i>
                        <span class="nav-text">Concerts</span>
                    </a>
                    @endpermission

                    @permission('view_songs')
                    <a href="{{ route('admin.songs.index') }}"
                        class="nav-item {{ request()->routeIs('admin.songs.*') ? 'active' : '' }}" title="Songs">
                        <i class="fas fa-music nav-icon"></i>
                        <span class="nav-text">Songs</span>
                    </a>
                    @endpermission

                    @permission('view_albums')
                    <a href="{{ route('admin.albums.index') }}"
                        class="nav-item {{ request()->routeIs('admin.albums.*') ? 'active' : '' }}" title="Albums">
                        <i class="fas fa-images nav-icon"></i>
                        <span class="nav-text">Albums</span>
                    </a>
                    @endpermission

                    @permission('view_media')
                    <a href="{{ route('admin.media.index') }}"
                        class="nav-item {{ request()->routeIs('admin.media.*') ? 'active' : '' }}" title="Media">
                        <i class="fas fa-photo-video nav-icon"></i>
                        <span class="nav-text">Media</span>
                    </a>
                    @endpermission

                    @permission('view_practice_sessions')
                    <a href="{{ route('admin.practice-sessions.index') }}"
                        class="nav-item {{ request()->routeIs('admin.practice-sessions.*') ? 'active' : '' }}"
                        title="Practice Sessions">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <span class="nav-text">Practice Sessions</span>
                    </a>
                    @endpermission
                </div>

                @permission('view_contribution_campaigns')
                <div class="nav-section">
                    <div class="nav-section-title">Financial</div>
                    <a href="{{ route('admin.contribution-campaigns.index') }}"
                        class="nav-item {{ request()->routeIs('admin.contribution-campaigns.*') ? 'active' : '' }}"
                        title="Contribution Campaigns">
                        <i class="fas fa-hand-holding-heart nav-icon"></i>
                        <span class="nav-text">Contribution Campaigns</span>
                    </a>
                    @endpermission

                    @permission('view_sponsors')
                    <a href="{{ route('admin.sponsors.index') }}"
                        class="nav-item {{ request()->routeIs('admin.sponsors.*') ? 'active' : '' }}" title="Sponsors">
                        <i class="fas fa-handshake nav-icon"></i>
                        <span class="nav-text">Sponsors</span>
                    </a>
                    @endpermission

                    @permission('manage_chart_of_accounts')
                    <a href="{{ route('admin.chart-of-accounts.index') }}"
                        class="nav-item {{ request()->routeIs('admin.chart-of-accounts.*') ? 'active' : '' }}"
                        title="Chart of Accounts">
                        <i class="fas fa-chart-line nav-icon"></i>
                        <span class="nav-text">Chart of Accounts</span>
                    </a>
                    @endpermission
                    @permission('manage_expenses')
                    <a href="{{ route('admin.expenses.index') }}"
                        class="nav-item {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}" title="Expenses">
                        <i class="fas fa-receipt nav-icon"></i>
                        <span class="nav-text">Expenses</span>
                    </a>
                    @endpermission
                    @permission('view_financial_reports')
                    <a href="{{ route('admin.financial-reports.index') }}"
                        class="nav-item {{ request()->routeIs('admin.financial-reports.*') ? 'active' : '' }}"
                        title="Financial Reports">
                        <i class="fas fa-chart-bar nav-icon"></i>
                        <span class="nav-text">Financial Reports</span>
                    </a>
                    @endpermission

                    @permission('view_audit_logs')
                    <a href="{{ route('admin.audit-logs.index') }}"
                        class="nav-item {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}"
                        title="Audit Logs">
                        <i class="fas fa-clipboard-list nav-icon"></i>
                        <span class="nav-text">Audit Logs</span>
                    </a>
                    @endpermission
                </div>

                @permission('view_instruments')
                <div class="nav-section">
                    <div class="nav-section-title">Resources</div>
                    <a href="{{ route('admin.instruments.index') }}"
                        class="nav-item {{ request()->routeIs('admin.instruments.*') ? 'active' : '' }}"
                        title="Instruments">
                        <i class="fas fa-guitar nav-icon"></i>
                        <span class="nav-text">Instruments</span>
                    </a>
                    @endpermission

                    @permission('view_plans')
                    <a href="{{ route('admin.plans.index') }}"
                        class="nav-item {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}" title="Year Plans">
                        <i class="fas fa-calendar-check nav-icon"></i>
                        <span class="nav-text">Year Plans</span>
                    </a>
                    @endpermission
                </div>

                @permission('view_users')
                <div class="nav-section">
                    <div class="nav-section-title">Administration</div>
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" title="Users">
                        <i class="fas fa-user-cog nav-icon"></i>
                        <span class="nav-text">Users</span>
                    </a>
                    @permission('manage_roles')
                    <a href="{{ route('admin.roles.index') }}"
                        class="nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" title="Roles">
                        <i class="fas fa-user-tag nav-icon"></i>
                        <span class="nav-text">Roles</span>
                    </a>
                    <a href="{{ route('admin.permissions.index') }}"
                        class="nav-item {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}"
                        title="Permissions">
                        <i class="fas fa-shield-alt nav-icon"></i>
                        <span class="nav-text">Permissions</span>
                    </a>
                    @endpermission

                    @permission('send_notifications')
                    <a href="{{ route('admin.notifications.index') }}"
                        class="nav-item {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}"
                        title="Notifications">
                        <i class="fas fa-bell nav-icon"></i>
                        <span class="nav-text">Notifications</span>
                    </a>
                    @endpermission
                </div>
                @endpermission
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="sidebar-toggle-btn" id="sidebarToggleBtn" onclick="toggleSidebar()"
                        title="Toggle Sidebar">
                        <i class="fas fa-bars" id="sidebarToggleIcon"></i>
                    </button>
                    <div class="page-title-section">
                        <h1 class="page-title">@yield('page-title', 'Admin Dashboard')</h1>
                    </div>
                </div>

                <div class="header-actions">
                    <div class="user-menu">
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                        </div>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>

                        <div class="user-dropdown">
                            <a href="{{ route('admin.profile') }}" class="user-dropdown-item">
                                <i class="fas fa-user"></i>
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="user-dropdown-item logout-btn">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Backdrop -->
    <div class="mobile-backdrop" id="mobileBackdrop" onclick="closeSidebar()"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const mobileBackdrop = document.getElementById('mobileBackdrop');
            const toggleIcon = document.getElementById('sidebarToggleIcon');

            // Check if we're on mobile or desktop
            if (window.innerWidth <= 1024) {
                // Mobile behavior
                const isOpening = !sidebar.classList.contains('open');
                sidebar.classList.toggle('open');
                mobileBackdrop.classList.toggle('active');
                toggleBodyScroll(isOpening);
            } else {
                // Desktop behavior - collapse/expand
                const layout = document.querySelector('.admin-layout');
                sidebar.classList.toggle('collapsed');
                layout.classList.toggle('sidebar-collapsed');

                // Save state to localStorage
                const isCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);

                // Update icon rotation
                if (isCollapsed) {
                    toggleIcon.style.transform = 'rotate(180deg)';
                } else {
                    toggleIcon.style.transform = 'rotate(0deg)';
                }
            }
        }

        // Initialize sidebar state from localStorage
        function initializeSidebarState() {
            // Only apply collapsed state on desktop screens
            if (window.innerWidth <= 1024) {
                return;
            }

            const sidebar = document.getElementById('adminSidebar');
            const layout = document.querySelector('.admin-layout');
            const toggleIcon = document.getElementById('sidebarToggleIcon');

            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                layout.classList.add('sidebar-collapsed');
                if (toggleIcon) toggleIcon.style.transform = 'rotate(180deg)';
            }
        }

        function closeSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const mobileBackdrop = document.getElementById('mobileBackdrop');
            sidebar.classList.remove('open');
            mobileBackdrop.classList.remove('active');
            toggleBodyScroll(false);
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('adminSidebar');
            const mobileToggle = document.querySelector('.mobile-menu-toggle');
            const mobileBackdrop = document.getElementById('mobileBackdrop');

            if (window.innerWidth <= 1024 &&
                !sidebar.contains(event.target) &&
                !mobileToggle.contains(event.target) &&
                !mobileBackdrop.contains(event.target)) {
                sidebar.classList.remove('open');
                mobileBackdrop.classList.remove('active');
            }
        });

        // Prevent body scroll when sidebar is open on mobile
        function toggleBodyScroll(disable) {
            if (window.innerWidth <= 1024) {
                if (disable) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }
        }

        // Handle keyboard events
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const sidebar = document.getElementById('adminSidebar');
                const mobileBackdrop = document.getElementById('mobileBackdrop');
                if (window.innerWidth <= 1024 && sidebar.classList.contains('open')) {
                    sidebar.classList.remove('open');
                    mobileBackdrop.classList.remove('active');
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('adminSidebar');
            const mobileBackdrop = document.getElementById('mobileBackdrop');

            if (window.innerWidth > 1024) {
                // Switching to desktop - close mobile sidebar and restore desktop state
                sidebar.classList.remove('open');
                mobileBackdrop.classList.remove('active');
                toggleBodyScroll(false);

                // Re-initialize desktop sidebar state
                initializeSidebarState();
            } else {
                // Switching to mobile - ensure sidebar is closed and remove collapsed state
                sidebar.classList.remove('open', 'collapsed');
                mobileBackdrop.classList.remove('active');
                toggleBodyScroll(false);
            }
        });

        // Add touch support for mobile devices
        let touchStartX = 0;
        let touchEndX = 0;

        document.addEventListener('touchstart', function(event) {
            touchStartX = event.changedTouches[0].screenX;
        });

        document.addEventListener('touchend', function(event) {
            touchEndX = event.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const sidebar = document.getElementById('adminSidebar');
            const mobileBackdrop = document.getElementById('mobileBackdrop');
            const swipeThreshold = 50;

            if (touchEndX < touchStartX - swipeThreshold) {
                // Swipe left - close sidebar
                if (window.innerWidth <= 1024 && sidebar.classList.contains('open')) {
                    sidebar.classList.remove('open');
                    mobileBackdrop.classList.remove('active');
                    toggleBodyScroll(false);
                }
            } else if (touchEndX > touchStartX + swipeThreshold) {
                // Swipe right - open sidebar
                if (window.innerWidth <= 1024 && !sidebar.classList.contains('open')) {
                    sidebar.classList.add('open');
                    mobileBackdrop.classList.add('active');
                    toggleBodyScroll(true);
                }
            }
        }

        // User dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize sidebar state
            initializeSidebarState();

            const userMenu = document.querySelector('.user-menu');
            const userDropdown = document.querySelector('.user-dropdown');
            const mobileBackdrop = document.getElementById('mobileBackdrop');

            if (userMenu && userDropdown) {
                // Toggle dropdown on click
                userMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userMenu.classList.toggle('active');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userMenu.contains(e.target)) {
                        userMenu.classList.remove('active');
                    }
                });

                // Close dropdown on escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        userMenu.classList.remove('active');
                    }
                });
            }
        });

        // Toast Notification System
        class ToastManager {
            constructor() {
                this.container = this.createContainer();
                this.toasts = [];
                this.maxToasts = 5;
            }

            createContainer() {
                const container = document.createElement('div');
                container.id = 'toast-container';
                container.className = 'toast-container';
                document.body.appendChild(container);
                return container;
            }

            show(message, type = 'info', duration = 5000) {
                const toast = this.createToast(message, type);
                this.container.appendChild(toast);
                this.toasts.push(toast);

                // Limit number of toasts
                if (this.toasts.length > this.maxToasts) {
                    const oldToast = this.toasts.shift();
                    if (oldToast && oldToast.parentNode) {
                        oldToast.parentNode.removeChild(oldToast);
                    }
                }

                // Auto-remove after duration
                setTimeout(() => {
                    this.removeToast(toast);
                }, duration);

                // Trigger entrance animation
                setTimeout(() => {
                    toast.classList.add('show');
                }, 10);

                return toast;
            }

            createToast(message, type) {
                const toast = document.createElement('div');
                toast.className = `toast toast-${type}`;

                const icon = this.getIconForType(type);
                const typeText = type.charAt(0).toUpperCase() + type.slice(1);

                toast.innerHTML = `
                    <div class="toast-icon">
                        <i class="${icon}"></i>
                    </div>
                    <div class="toast-content">
                        <div class="toast-title">${typeText}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                    <button class="toast-close" onclick="window.toastManager.removeToast(this.parentElement)">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="toast-progress"></div>
                `;

                return toast;
            }

            getIconForType(type) {
                const icons = {
                    success: 'fas fa-check-circle',
                    error: 'fas fa-exclamation-circle',
                    warning: 'fas fa-exclamation-triangle',
                    info: 'fas fa-info-circle'
                };
                return icons[type] || icons.info;
            }

            removeToast(toast) {
                toast.classList.remove('show');
                toast.classList.add('hiding');

                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                        this.toasts = this.toasts.filter(t => t !== toast);
                    }
                }, 300);
            }

            success(message, duration) {
                return this.show(message, 'success', duration);
            }

            error(message, duration) {
                return this.show(message, 'error', duration);
            }

            warning(message, duration) {
                return this.show(message, 'warning', duration);
            }

            info(message, duration) {
                return this.show(message, 'info', duration);
            }

            clearAll() {
                this.toasts.forEach(toast => {
                    this.removeToast(toast);
                });
            }
        }

        // Initialize toast manager
        window.toastManager = new ToastManager();

        // Auto-show session messages
        document.addEventListener('DOMContentLoaded', function() {
            // Check for Laravel session messages
            const successMessage = '{{ session("success") }}';
            const errorMessage = '{{ session("error") }}';
            const warningMessage = '{{ session("warning") }}';
            const infoMessage = '{{ session("info") }}';

            if (successMessage) {
                window.toastManager.success(successMessage);
            }
            if (errorMessage) {
                window.toastManager.error(errorMessage);
            }
            if (warningMessage) {
                window.toastManager.warning(warningMessage);
            }
            if (infoMessage) {
                window.toastManager.info(infoMessage);
            }

            // Check for validation errors
            const validationErrors = document.querySelectorAll('.error-message');
            if (validationErrors.length > 0) {
                validationErrors.forEach(error => {
                    if (error.textContent.trim()) {
                        window.toastManager.error(error.textContent.trim());
                    }
                });
            }
        });

        // Global toast functions for easy access
        window.showToast = function(message, type = 'info', duration = 5000) {
            return window.toastManager.show(message, type, duration);
        };

        window.showSuccess = function(message, duration = 5000) {
            return window.toastManager.success(message, duration);
        };

        window.showError = function(message, duration = 5000) {
            return window.toastManager.error(message, duration);
        };

        window.showWarning = function(message, duration = 5000) {
            return window.toastManager.warning(message, duration);
        };

        window.showInfo = function(message, duration = 5000) {
            return window.toastManager.info(message, duration);
        };
    </script>

    <!-- Render scripts pushed from views -->
    @stack('scripts')

    <!-- General Responsive Content Management Script -->
    <script>
        // General responsive content management for all admin pages
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const html = document.documentElement;

            // Prevent body and html horizontal scroll
            body.style.overflowX = 'hidden';
            body.style.maxWidth = '100vw';
            html.style.overflowX = 'hidden';
            html.style.maxWidth = '100vw';

            // Ensure all page elements fit within viewport
            const allElements = document.querySelectorAll('*');
            allElements.forEach(element => {
                // Skip table containers as they need their own scroll
                if (!element.classList.contains('table-container')) {
                    element.style.maxWidth = '100%';
                    element.style.boxSizing = 'border-box';
                }
            });

            // Handle table containers specifically
            const tableContainers = document.querySelectorAll('.table-container');
            tableContainers.forEach(container => {
                // Handle table scroll to prevent page scroll
                container.addEventListener('wheel', function(e) {
                    if (e.deltaX !== 0) {
                        e.preventDefault();
                        this.scrollLeft += e.deltaX;
                    }
                }, {
                    passive: false
                });

                // Prevent page scroll when table is at scroll boundaries
                container.addEventListener('scroll', function() {
                    if (this.scrollLeft <= 0) {
                        this.scrollLeft = 0;
                    }
                    const maxScroll = this.scrollWidth - this.clientWidth;
                    if (this.scrollLeft >= maxScroll) {
                        this.scrollLeft = maxScroll;
                    }
                });
            });

            // Handle window resize to ensure content fits
            window.addEventListener('resize', function() {
                const viewportWidth = window.innerWidth;
                const mainContent = document.querySelector('.main-content');
                if (mainContent) {
                    const contentWidth = mainContent.scrollWidth;
                    if (contentWidth > viewportWidth) {
                        mainContent.style.maxWidth = viewportWidth + 'px';
                    }
                }
            });
        });
    </script>
</body>

</html>
    <!-- General Responsive Content Management Script -->
    <script>
        // General responsive content management for all admin pages
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const html = document.documentElement;

            // Prevent body and html horizontal scroll
            body.style.overflowX = 'hidden';
            body.style.maxWidth = '100vw';
            html.style.overflowX = 'hidden';
            html.style.maxWidth = '100vw';

            // Ensure all page elements fit within viewport
            const allElements = document.querySelectorAll('*');
            allElements.forEach(element => {
                // Skip table containers as they need their own scroll
                if (!element.classList.contains('table-container')) {
                    element.style.maxWidth = '100%';
                    element.style.boxSizing = 'border-box';
                }
            });

            // Handle table containers specifically
            const tableContainers = document.querySelectorAll('.table-container');
            tableContainers.forEach(container => {
                // Handle table scroll to prevent page scroll
                container.addEventListener('wheel', function(e) {
                    if (e.deltaX !== 0) {
                        e.preventDefault();
                        this.scrollLeft += e.deltaX;
                    }
                }, {
                    passive: false
                });

                // Prevent page scroll when table is at scroll boundaries
                container.addEventListener('scroll', function() {
                    if (this.scrollLeft <= 0) {
                        this.scrollLeft = 0;
                    }
                    const maxScroll = this.scrollWidth - this.clientWidth;
                    if (this.scrollLeft >= maxScroll) {
                        this.scrollLeft = maxScroll;
                    }
                });
            });

            // Handle window resize to ensure content fits
            window.addEventListener('resize', function() {
                const viewportWidth = window.innerWidth;
                const mainContent = document.querySelector('.main-content');
                if (mainContent) {
                    const contentWidth = mainContent.scrollWidth;
                    if (contentWidth > viewportWidth) {
                        mainContent.style.maxWidth = viewportWidth + 'px';
                    }
                }
            });
        });
    </script>
</body>

</html>