<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConcertController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PublicMemberController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\ContributionController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\NotificationManagementController;
use App\Http\Controllers\Admin\PracticeSessionController;
use App\Http\Controllers\Admin\ChartOfAccountsController;
use App\Http\Controllers\Admin\ExpensesController;
use App\Http\Controllers\Admin\FinancialReportsController;
use App\Http\Controllers\Admin\AuditLogController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/concerts', [ConcertController::class, 'index'])->name('concerts.index');
Route::get('/concerts/{concert}', [ConcertController::class, 'show'])->name('concerts.show');
Route::get('/media', [MediaController::class, 'index'])->name('media.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Public member registration routes (no authentication required)
Route::get('/join', [PublicMemberController::class, 'create'])->name('public.member-register');
Route::post('/join', [PublicMemberController::class, 'store'])->name('public.member-register.store');



// Notification routes (protected by auth middleware)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

// Admin routes (protected by auth middleware)
Route::middleware(['auth', 'verified', \App\Http\Middleware\HandleLargeUploads::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('permission:view_dashboard')->name('dashboard');
    Route::get('/profile', function () {
        return view('admin.profile');
    })->name('profile');

    // Resource routes for admin management with permission checks
    Route::middleware('permission:view_members')->group(function () {
        Route::get('members', [MemberController::class, 'index'])->name('members.index');

        // Create routes must come BEFORE dynamic {member} routes to prevent conflicts
        Route::middleware('permission:create_members')->group(function () {
            Route::get('members/create', [MemberController::class, 'create'])->name('members.create');
            Route::post('members', [MemberController::class, 'store'])->name('members.store');
        });

        // Dynamic routes with parameters come AFTER static routes
        Route::get('members/{member}', [MemberController::class, 'show'])->name('members.show');
        Route::get('members/{member}/certificate/download', [MemberController::class, 'downloadCertificate'])->name('members.certificate.download');

        // Certificate printing routes
        Route::post('members/print-certificates', [MemberController::class, 'printCertificates'])->name('members.print-certificates');
        Route::post('members/print-filtered-certificates', [MemberController::class, 'printFilteredCertificates'])->name('members.print-filtered-certificates');
        Route::get('members/certificate-stats', [MemberController::class, 'getCertificateStats'])->name('members.certificate-stats');

        Route::middleware('permission:edit_members')->group(function () {
            Route::get('members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
            Route::put('members/{member}', [MemberController::class, 'update'])->name('members.update');
        });

        Route::middleware('permission:delete_members')->group(function () {
            Route::delete('members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
        });
    });

    Route::get('members/search', [MemberController::class, 'search'])->middleware('permission:view_members')->name('members.search');

    // Export routes for members
    Route::middleware('permission:view_members')->group(function () {
        Route::get('members/export/excel', [MemberController::class, 'exportExcel'])->name('members.export.excel');
        Route::get('members/export/pdf', [MemberController::class, 'exportPdf'])->name('members.export.pdf');
    });

    // Export routes for users
    Route::middleware('permission:view_users')->group(function () {
        Route::get('users/export/excel', [\App\Http\Controllers\Admin\UserController::class, 'exportExcel'])->name('users.export.excel');
        Route::get('users/export/pdf', [\App\Http\Controllers\Admin\UserController::class, 'exportPdf'])->name('users.export.pdf');
    });

    // Export routes for songs
    Route::middleware('permission:view_songs')->group(function () {
        Route::get('songs/export/excel', [\App\Http\Controllers\Admin\SongController::class, 'exportExcel'])->name('songs.export.excel');
        Route::get('songs/export/pdf', [\App\Http\Controllers\Admin\SongController::class, 'exportPdf'])->name('songs.export.pdf');
    });

    // Export routes for concerts
    Route::middleware('permission:view_concerts')->group(function () {
        Route::get('concerts/export/excel', [\App\Http\Controllers\Admin\ConcertController::class, 'exportExcel'])->name('concerts.export.excel');
        Route::get('concerts/export/pdf', [\App\Http\Controllers\Admin\ConcertController::class, 'exportPdf'])->name('concerts.export.pdf');
    });

    // Export routes for albums
    Route::middleware('permission:view_albums')->group(function () {
        Route::get('albums/export/excel', [\App\Http\Controllers\Admin\AlbumController::class, 'exportExcel'])->name('albums.export.excel');
        Route::get('albums/export/pdf', [\App\Http\Controllers\Admin\AlbumController::class, 'exportPdf'])->name('albums.export.pdf');
    });

    // Export routes for instruments
    Route::middleware('permission:view_instruments')->group(function () {
        Route::get('instruments/export/excel', [\App\Http\Controllers\Admin\InstrumentController::class, 'exportExcel'])->name('instruments.export.excel');
        Route::get('instruments/export/pdf', [\App\Http\Controllers\Admin\InstrumentController::class, 'exportPdf'])->name('instruments.export.pdf');
    });

    // Export routes for roles
    Route::middleware('permission:view_roles')->group(function () {
        Route::get('roles/export/excel', [\App\Http\Controllers\Admin\RoleController::class, 'exportExcel'])->name('roles.export.excel');
        Route::get('roles/export/pdf', [\App\Http\Controllers\Admin\RoleController::class, 'exportPdf'])->name('roles.export.pdf');
    });

    // Export routes for permissions
    Route::middleware('permission:view_permissions')->group(function () {
        Route::get('permissions/export/excel', [\App\Http\Controllers\Admin\PermissionController::class, 'exportExcel'])->name('permissions.export.excel');
        Route::get('permissions/export/pdf', [\App\Http\Controllers\Admin\PermissionController::class, 'exportPdf'])->name('permissions.export.pdf');
    });

    // Export routes for other resources
    Route::middleware('permission:view_sponsors')->group(function () {
        Route::get('sponsors/export/excel', [\App\Http\Controllers\Admin\SponsorController::class, 'exportExcel'])->name('sponsors.export.excel');
        Route::get('sponsors/export/pdf', [\App\Http\Controllers\Admin\SponsorController::class, 'exportPdf'])->name('sponsors.export.pdf');
    });

    Route::middleware('permission:view_plans')->group(function () {
        Route::get('plans/export/excel', [\App\Http\Controllers\Admin\PlanController::class, 'exportExcel'])->name('plans.export.excel');
        Route::get('plans/export/pdf', [\App\Http\Controllers\Admin\PlanController::class, 'exportPdf'])->name('plans.export.pdf');
    });

    Route::middleware('permission:view_contribution_campaigns')->group(function () {
        Route::get('contribution-campaigns/export/excel', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'exportExcel'])->name('contribution-campaigns.export.excel');
        Route::get('contribution-campaigns/export/pdf', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'exportPdf'])->name('contribution-campaigns.export.pdf');
    });

    Route::middleware('permission:view_contributions')->group(function () {
        Route::get('contributions/export/excel', [\App\Http\Controllers\Admin\ContributionController::class, 'exportExcel'])->name('contributions.export.excel');
        Route::get('contributions/export/pdf', [\App\Http\Controllers\Admin\ContributionController::class, 'exportPdf'])->name('contributions.export.pdf');
    });

    // Contribution campaigns with permission checks
    Route::middleware('permission:view_contribution_campaigns')->group(function () {
        Route::get('contribution-campaigns', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'index'])->name('contribution-campaigns.index');
        Route::get('contribution-campaigns/export/excel', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'exportExcel'])->name('contribution-campaigns.export.excel');
        Route::get('contribution-campaigns/export/pdf', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'exportPdf'])->name('contribution-campaigns.export.pdf');

        // Create routes must come BEFORE dynamic {contributionCampaign} routes to prevent conflicts
        Route::middleware('permission:create_contribution_campaigns')->group(function () {
            Route::get('contribution-campaigns/create', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'create'])->name('contribution-campaigns.create');
            Route::post('contribution-campaigns', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'store'])->name('contribution-campaigns.store');
        });

        // Dynamic routes with parameters come AFTER static routes
        Route::get('contribution-campaigns/{contributionCampaign}', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'show'])->name('contribution-campaigns.show');

        Route::middleware('permission:edit_contribution_campaigns')->group(function () {
            Route::get('contribution-campaigns/{contributionCampaign}/edit', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'edit'])->name('contribution-campaigns.edit');
            Route::put('contribution-campaigns/{contributionCampaign}', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'update'])->name('contribution-campaigns.update');
        });

        Route::middleware('permission:delete_contribution_campaigns')->group(function () {
            Route::delete('contribution-campaigns/{contributionCampaign}', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'destroy'])->name('contribution-campaigns.destroy');
        });

        // Contribution management within campaigns
        Route::middleware('permission:manage_campaign_contributions')->group(function () {
            Route::get('contribution-campaigns/{contributionCampaign}/add-contribution', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'showAddContributionForm'])->name('contribution-campaigns.add-contribution');
            Route::post('contribution-campaigns/{contributionCampaign}/add-contribution', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'addContribution'])->name('contribution-campaigns.store-contribution');
            Route::get('contribution-campaigns/{contributionCampaign}/contributions/{contribution}/edit', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'editContribution'])->name('contribution-campaigns.edit-contribution');
            Route::put('contribution-campaigns/{contributionCampaign}/contributions/{contribution}', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'updateContribution'])->name('contribution-campaigns.update-contribution');
            Route::delete('contribution-campaigns/{contributionCampaign}/contributions/{contribution}', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'removeContribution'])->name('contribution-campaigns.remove-contribution');
        });

        // Contributor exports
        Route::middleware('permission:view_contribution_campaigns')->group(function () {
            Route::get('contribution-campaigns/{contributionCampaign}/export-contributors/excel', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'exportContributorsExcel'])->name('contribution-campaigns.export-contributors.excel');
            Route::get('contribution-campaigns/{contributionCampaign}/export-contributors/pdf', [\App\Http\Controllers\Admin\ContributionCampaignController::class, 'exportContributorsPdf'])->name('contribution-campaigns.export-contributors.pdf');
        });
    });

    // Contributions with permission checks
    Route::middleware('permission:view_contributions')->group(function () {
        Route::get('contributions', [\App\Http\Controllers\Admin\ContributionController::class, 'index'])->name('contributions.index');
        Route::get('contributions/create', [\App\Http\Controllers\Admin\ContributionController::class, 'create'])->name('contributions.create');
        Route::post('contributions', [\App\Http\Controllers\Admin\ContributionController::class, 'store'])->name('contributions.store');
        Route::get('contributions/{contribution}', [\App\Http\Controllers\Admin\ContributionController::class, 'show'])->name('contributions.show');
        Route::get('contributions/{contribution}/edit', [\App\Http\Controllers\Admin\ContributionController::class, 'edit'])->name('contributions.edit');
        Route::put('contributions/{contribution}', [\App\Http\Controllers\Admin\ContributionController::class, 'update'])->name('contributions.update');
        Route::delete('contributions/{contribution}', [\App\Http\Controllers\Admin\ContributionController::class, 'destroy'])->name('contributions.destroy');
    });

    // Donations with permission checks
    Route::middleware('permission:view_donations')->group(function () {
        Route::get('donations', [\App\Http\Controllers\Admin\DonationController::class, 'index'])->name('donations.index');
        Route::get('donations/create', [\App\Http\Controllers\Admin\DonationController::class, 'create'])->name('donations.create');
        Route::post('donations', [\App\Http\Controllers\Admin\DonationController::class, 'store'])->name('donations.store');
        Route::get('donations/{donation}', [\App\Http\Controllers\Admin\DonationController::class, 'show'])->name('donations.show');
        Route::get('donations/{donation}/edit', [\App\Http\Controllers\Admin\DonationController::class, 'edit'])->name('donations.edit');
        Route::put('donations/{donation}', [\App\Http\Controllers\Admin\DonationController::class, 'update'])->name('donations.update');
        Route::delete('donations/{donation}', [\App\Http\Controllers\Admin\DonationController::class, 'destroy'])->name('donations.destroy');
    });

    // Sponsors with permission checks
    Route::middleware('permission:view_sponsors')->group(function () {
        Route::get('sponsors', [SponsorController::class, 'index'])->name('sponsors.index');
        Route::get('sponsors/export/excel', [SponsorController::class, 'exportExcel'])->name('sponsors.export.excel');
        Route::get('sponsors/export/pdf', [SponsorController::class, 'exportPdf'])->name('sponsors.export.pdf');

        // Create routes must come BEFORE dynamic {sponsor} routes to prevent conflicts
        Route::middleware('permission:create_sponsors')->group(function () {
            Route::get('sponsors/create', [SponsorController::class, 'create'])->name('sponsors.create');
            Route::post('sponsors', [SponsorController::class, 'store'])->name('sponsors.store');
        });

        // Dynamic routes with parameters come AFTER static routes
        Route::get('sponsors/{sponsor}', [SponsorController::class, 'show'])->name('sponsors.show');

        Route::middleware('permission:edit_sponsors')->group(function () {
            Route::get('sponsors/{sponsor}/edit', [SponsorController::class, 'edit'])->name('sponsors.edit');
            Route::put('sponsors/{sponsor}', [SponsorController::class, 'update'])->name('sponsors.update');
        });

        Route::middleware('permission:delete_sponsors')->group(function () {
            Route::delete('sponsors/{sponsor}', [SponsorController::class, 'destroy'])->name('sponsors.destroy');
        });
    });

    // Albums with permission checks
    Route::middleware('permission:view_albums')->group(function () {
        Route::get('albums', [AlbumController::class, 'index'])->name('albums.index');

        // Create routes must come BEFORE dynamic {album} routes to prevent conflicts
        Route::middleware('permission:create_albums')->group(function () {
            Route::get('albums/create', [AlbumController::class, 'create'])->name('albums.create');
            Route::post('albums', [AlbumController::class, 'store'])->name('albums.store');
        });

        // Dynamic routes with parameters come AFTER static routes
        Route::get('albums/{album}', [AlbumController::class, 'show'])->name('albums.show');

        Route::middleware('permission:edit_albums')->group(function () {
            Route::get('albums/{album}/edit', [AlbumController::class, 'edit'])->name('albums.edit');
            Route::put('albums/{album}', [AlbumController::class, 'update'])->name('albums.update');
        });

        Route::middleware('permission:delete_albums')->group(function () {
            Route::delete('albums/{album}', [AlbumController::class, 'destroy'])->name('albums.destroy');
        });
    });

    // Media with permission checks
    Route::middleware('permission:view_media')->group(function () {
        Route::get('media', [\App\Http\Controllers\Admin\MediaController::class, 'index'])->name('media.index');

        // Create routes must come BEFORE dynamic {media} routes to prevent conflicts
        Route::middleware('permission:upload_media')->group(function () {
            Route::get('media/create', [\App\Http\Controllers\Admin\MediaController::class, 'create'])->name('media.create');
            Route::post('media', [\App\Http\Controllers\Admin\MediaController::class, 'store'])->name('media.store');
            Route::post('media/upload-large', [\App\Http\Controllers\Admin\MediaController::class, 'storeLarge'])->name('media.upload-large');
        });

        // Dynamic routes with parameters come AFTER static routes
        Route::get('media/{media}', [\App\Http\Controllers\Admin\MediaController::class, 'show'])->name('media.show');

        Route::middleware('permission:edit_media')->group(function () {
            Route::get('media/{media}/edit', [\App\Http\Controllers\Admin\MediaController::class, 'edit'])->name('media.edit');
            Route::put('media/{media}', [\App\Http\Controllers\Admin\MediaController::class, 'update'])->name('media.update');
        });

        Route::middleware('permission:delete_media')->group(function () {
            Route::delete('media/{media}', [\App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('media.destroy');
        });
    });

    // Concerts with permission checks
    Route::middleware('permission:view_concerts')->group(function () {
        Route::get('concerts', [\App\Http\Controllers\Admin\ConcertController::class, 'index'])->name('concerts.index');

        // Create routes must come BEFORE dynamic {concert} routes to prevent conflicts
        Route::middleware('permission:create_concerts')->group(function () {
            Route::get('concerts/create', [\App\Http\Controllers\Admin\ConcertController::class, 'create'])->name('concerts.create');
            Route::post('concerts', [\App\Http\Controllers\Admin\ConcertController::class, 'store'])->name('concerts.store');
        });

        // Dynamic routes with parameters come AFTER static routes
        Route::get('concerts/{concert}', [\App\Http\Controllers\Admin\ConcertController::class, 'show'])->name('concerts.show');

        Route::middleware('permission:edit_concerts')->group(function () {
            Route::get('concerts/{concert}/edit', [\App\Http\Controllers\Admin\ConcertController::class, 'edit'])->name('concerts.edit');
            Route::put('concerts/{concert}', [\App\Http\Controllers\Admin\ConcertController::class, 'update'])->name('concerts.update');
        });

        Route::middleware('permission:delete_concerts')->group(function () {
            Route::delete('concerts/{concert}', [\App\Http\Controllers\Admin\ConcertController::class, 'destroy'])->name('concerts.destroy');
        });
    });

    // Songs with permission checks
    Route::middleware('permission:view_songs')->group(function () {
        Route::get('songs', [\App\Http\Controllers\Admin\SongController::class, 'index'])->name('songs.index');

        // Create routes must come BEFORE dynamic {song} routes to prevent conflicts
        Route::middleware('permission:create_songs')->group(function () {
            Route::get('songs/create', [\App\Http\Controllers\Admin\SongController::class, 'create'])->name('songs.create');
            Route::post('songs', [\App\Http\Controllers\Admin\SongController::class, 'store'])->name('songs.store');
        });

        // Dynamic routes with parameters come AFTER static routes
        Route::get('songs/{song}', [\App\Http\Controllers\Admin\SongController::class, 'show'])->name('songs.show');

        Route::middleware('permission:edit_songs')->group(function () {
            Route::get('songs/{song}/edit', [\App\Http\Controllers\Admin\SongController::class, 'edit'])->name('songs.edit');
            Route::put('songs/{song}', [\App\Http\Controllers\Admin\SongController::class, 'update'])->name('songs.update');
        });

        Route::middleware('permission:delete_songs')->group(function () {
            Route::delete('songs/{song}', [\App\Http\Controllers\Admin\SongController::class, 'destroy'])->name('songs.destroy');
        });
    });

    // Practice Sessions with permission checks
    Route::middleware('permission:view_practice_sessions')->group(function () {
        Route::get('practice-sessions', [PracticeSessionController::class, 'index'])->name('practice-sessions.index');

        // Create routes must come BEFORE dynamic {practiceSession} routes to prevent conflicts
        Route::middleware('permission:create_practice_sessions')->group(function () {
            Route::get('practice-sessions/create', [PracticeSessionController::class, 'create'])->name('practice-sessions.create');
            Route::post('practice-sessions', [PracticeSessionController::class, 'store'])->name('practice-sessions.store');
        });

        // Dynamic routes with parameters come AFTER static routes
        Route::get('practice-sessions/{practiceSession}', [PracticeSessionController::class, 'show'])->name('practice-sessions.show');

        Route::middleware('permission:edit_practice_sessions')->group(function () {
            Route::get('practice-sessions/{practiceSession}/edit', [PracticeSessionController::class, 'edit'])->name('practice-sessions.edit');
            Route::put('practice-sessions/{practiceSession}', [PracticeSessionController::class, 'update'])->name('practice-sessions.update');
        });

        Route::middleware('permission:delete_practice_sessions')->group(function () {
            Route::delete('practice-sessions/{practiceSession}', [PracticeSessionController::class, 'destroy'])->name('practice-sessions.destroy');
        });

        // Attendance management
        Route::middleware('permission:manage_practice_attendance')->group(function () {
            Route::get('practice-sessions/{practiceSession}/attendance', [PracticeSessionController::class, 'attendance'])->name('practice-sessions.attendance');
            Route::post('practice-sessions/{practiceSession}/attendance', [PracticeSessionController::class, 'updateAttendance'])->name('practice-sessions.update-attendance');
            Route::get('practice-sessions/{practiceSession}/export-attendance', [PracticeSessionController::class, 'exportAttendance'])->name('practice-sessions.export-attendance');
            Route::get('practice-sessions/{practiceSession}/export-attendance/excel', [PracticeSessionController::class, 'exportAttendanceExcel'])->name('practice-sessions.export-attendance.excel');
            Route::get('practice-sessions/{practiceSession}/export-attendance/pdf', [PracticeSessionController::class, 'exportAttendancePdf'])->name('practice-sessions.export-attendance.pdf');
        });
    });

    // Instruments with permission checks
    Route::middleware('permission:view_instruments')->group(function () {
        Route::get('instruments', [\App\Http\Controllers\Admin\InstrumentController::class, 'index'])->name('instruments.index');
        Route::get('instruments/export/excel', [\App\Http\Controllers\Admin\InstrumentController::class, 'exportExcel'])->name('instruments.export.excel');
        Route::get('instruments/export/pdf', [\App\Http\Controllers\Admin\InstrumentController::class, 'exportPdf'])->name('instruments.export.pdf');

        // Create routes must come BEFORE dynamic {instrument} routes to prevent conflicts
        Route::middleware('permission:create_instruments')->group(function () {
            Route::get('instruments/create', [\App\Http\Controllers\Admin\InstrumentController::class, 'create'])->name('instruments.create');
            Route::post('instruments', [\App\Http\Controllers\Admin\InstrumentController::class, 'store'])->name('instruments.store');
        });

        // Dynamic routes with parameters come AFTER static routes
        Route::get('instruments/{instrument}', [\App\Http\Controllers\Admin\InstrumentController::class, 'show'])->name('instruments.show');

        Route::middleware('permission:edit_instruments')->group(function () {
            Route::get('instruments/{instrument}/edit', [\App\Http\Controllers\Admin\InstrumentController::class, 'edit'])->name('instruments.edit');
            Route::put('instruments/{instrument}', [\App\Http\Controllers\Admin\InstrumentController::class, 'update'])->name('instruments.update');
        });

        Route::middleware('permission:delete_instruments')->group(function () {
            Route::delete('instruments/{instrument}', [\App\Http\Controllers\Admin\InstrumentController::class, 'destroy'])->name('instruments.destroy');
        });
    });

    // Plans with permission checks
    Route::middleware('permission:view_plans')->group(function () {
        Route::get('plans', [\App\Http\Controllers\Admin\PlanController::class, 'index'])->name('plans.index');
        Route::get('plans/export/excel', [\App\Http\Controllers\Admin\PlanController::class, 'exportExcel'])->name('plans.export.excel');
        Route::get('plans/export/pdf', [\App\Http\Controllers\Admin\PlanController::class, 'exportPdf'])->name('plans.export.pdf');

        // Create routes must come BEFORE dynamic {plan} routes to prevent conflicts
        Route::middleware('permission:create_plans')->group(function () {
            Route::get('plans/create', [\App\Http\Controllers\Admin\PlanController::class, 'create'])->name('plans.create');
            Route::post('plans', [\App\Http\Controllers\Admin\PlanController::class, 'store'])->name('plans.store');
        });

        // Dynamic routes with parameters come AFTER static routes
        Route::get('plans/{plan}', [\App\Http\Controllers\Admin\PlanController::class, 'show'])->name('plans.show');

        Route::middleware('permission:edit_plans')->group(function () {
            Route::get('plans/{plan}/edit', [\App\Http\Controllers\Admin\PlanController::class, 'edit'])->name('plans.edit');
            Route::put('plans/{plan}', [\App\Http\Controllers\Admin\PlanController::class, 'update'])->name('plans.update');
        });

        Route::middleware('permission:delete_plans')->group(function () {
            Route::delete('plans/{plan}', [\App\Http\Controllers\Admin\PlanController::class, 'destroy'])->name('plans.destroy');
        });
    });

    // User management with permission checks
    Route::middleware('permission:view_users')->group(function () {
        Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');

        // Create routes must come BEFORE dynamic {user} routes to prevent conflicts
        Route::middleware('permission:create_users')->group(function () {
            Route::get('users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
            Route::post('users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
        });

        // Dynamic routes with parameters come AFTER static routes
        Route::get('users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');

        Route::middleware('permission:edit_users')->group(function () {
            Route::get('users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
            Route::put('users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        });

        Route::middleware('permission:delete_users')->group(function () {
            Route::delete('users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
        });

        Route::middleware('permission:manage_roles')->group(function () {
            Route::get('users/{user}/edit-role', [\App\Http\Controllers\Admin\UserController::class, 'editRole'])->name('users.edit-role');
            Route::put('users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.update-role');
        });
    });

    // Roles management with permission checks
    Route::middleware('permission:manage_roles')->group(function () {
        Route::get('roles', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index');

        // Create routes must come BEFORE dynamic {role} routes to prevent conflicts
        Route::get('roles/create', [\App\Http\Controllers\Admin\RoleController::class, 'create'])->name('roles.create');
        Route::post('roles', [\App\Http\Controllers\Admin\RoleController::class, 'store'])->name('roles.store');

        // Dynamic routes with parameters come AFTER static routes
        Route::get('roles/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'show'])->name('roles.show');
        Route::get('roles/{role}/edit', [\App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'update'])->name('roles.update');
        Route::delete('roles/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('roles.destroy');
        Route::patch('roles/{role}/toggle-status', [\App\Http\Controllers\Admin\RoleController::class, 'toggleStatus'])->name('roles.toggle-status');
    });

    // Permissions management with permission checks
    Route::middleware('permission:view_permissions')->group(function () {
        Route::get('permissions', [\App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('permissions.index');

        // Create routes must come BEFORE dynamic {permission} routes to prevent conflicts
        Route::middleware('permission:create_permissions')->group(function () {
            Route::get('permissions/create', [\App\Http\Controllers\Admin\PermissionController::class, 'create'])->name('permissions.create');
            Route::post('permissions', [\App\Http\Controllers\Admin\PermissionController::class, 'store'])->name('permissions.store');
        });

        // Dynamic routes with parameters come AFTER static routes
        Route::get('permissions/{permission}', [\App\Http\Controllers\Admin\PermissionController::class, 'show'])->name('permissions.show');

        Route::middleware('permission:edit_permissions')->group(function () {
            Route::get('permissions/{permission}/edit', [\App\Http\Controllers\Admin\PermissionController::class, 'edit'])->name('permissions.edit');
            Route::put('permissions/{permission}', [\App\Http\Controllers\Admin\PermissionController::class, 'update'])->name('permissions.update');
            Route::patch('permissions/{permission}/toggle-status', [\App\Http\Controllers\Admin\PermissionController::class, 'toggleStatus'])->name('permissions.toggle-status');
        });

        Route::middleware('permission:delete_permissions')->group(function () {
            Route::delete('permissions/{permission}', [\App\Http\Controllers\Admin\PermissionController::class, 'destroy'])->name('permissions.destroy');
        });

        Route::get('permissions/module/{module}', [\App\Http\Controllers\Admin\PermissionController::class, 'byModule'])->name('permissions.by-module');
    });

    // Notification management with permission checks
    Route::middleware('permission:send_notifications')->group(function () {
        Route::get('notifications', [NotificationManagementController::class, 'index'])->middleware('permission:view_notification_history')->name('notifications.index');
        Route::get('notifications/export/excel', [NotificationManagementController::class, 'exportExcel'])->middleware('permission:view_notification_history')->name('notifications.export.excel');
        Route::get('notifications/export/pdf', [NotificationManagementController::class, 'exportPdf'])->middleware('permission:view_notification_history')->name('notifications.export.pdf');
        Route::get('notifications/create', [NotificationManagementController::class, 'create'])->name('notifications.create');
        Route::post('notifications', [NotificationManagementController::class, 'store'])->name('notifications.store');
        Route::get('notifications/stats', [NotificationManagementController::class, 'stats'])->middleware('permission:view_notification_history')->name('notifications.stats');
    });

    Route::middleware('permission:delete_notifications')->group(function () {
        Route::delete('notifications/{notification}', [NotificationManagementController::class, 'destroy'])->name('notifications.destroy');
    });

    // Chart of Accounts routes
    Route::middleware('permission:manage_chart_of_accounts')->group(function () {
        Route::get('chart-of-accounts', [ChartOfAccountsController::class, 'index'])->name('chart-of-accounts.index');
        Route::get('chart-of-accounts/create', [ChartOfAccountsController::class, 'create'])->name('chart-of-accounts.create');
        Route::post('chart-of-accounts', [ChartOfAccountsController::class, 'store'])->name('chart-of-accounts.store');
        Route::get('chart-of-accounts/{chartOfAccount}/edit', [ChartOfAccountsController::class, 'edit'])->name('chart-of-accounts.edit');
        Route::put('chart-of-accounts/{chartOfAccount}', [ChartOfAccountsController::class, 'update'])->name('chart-of-accounts.update');
        Route::delete('chart-of-accounts/{chartOfAccount}', [ChartOfAccountsController::class, 'destroy'])->name('chart-of-accounts.destroy');
        Route::patch('chart-of-accounts/{chartOfAccount}/toggle-status', [ChartOfAccountsController::class, 'toggleStatus'])->name('chart-of-accounts.toggle-status');
    });

    // Expenses routes
    Route::middleware('permission:manage_expenses')->group(function () {
        Route::get('expenses', [ExpensesController::class, 'index'])->name('expenses.index');
        Route::get('expenses/create', [ExpensesController::class, 'create'])->name('expenses.create');
        Route::post('expenses', [ExpensesController::class, 'store'])->name('expenses.store');
        Route::get('expenses/{expense}', [ExpensesController::class, 'show'])->name('expenses.show');
        Route::get('expenses/{expense}/edit', [ExpensesController::class, 'edit'])->name('expenses.edit');
        Route::put('expenses/{expense}', [ExpensesController::class, 'update'])->name('expenses.update');
        Route::delete('expenses/{expense}', [ExpensesController::class, 'destroy'])->name('expenses.destroy');

        // Expense actions
        Route::post('expenses/{expense}/submit-approval', [ExpensesController::class, 'submitForApproval'])->name('expenses.submit-approval');
        Route::post('expenses/{expense}/approve', [ExpensesController::class, 'approve'])->name('expenses.approve');
        Route::post('expenses/{expense}/mark-paid', [ExpensesController::class, 'markAsPaid'])->name('expenses.mark-paid');
        Route::post('expenses/{expense}/cancel', [ExpensesController::class, 'cancel'])->name('expenses.cancel');
    });

    // Financial Reports routes
    Route::middleware('permission:view_financial_reports')->group(function () {
        Route::get('financial-reports', [FinancialReportsController::class, 'index'])->name('financial-reports.index');
        Route::get('financial-reports/trial-balance', [FinancialReportsController::class, 'trialBalance'])->name('financial-reports.trial-balance');
        Route::get('financial-reports/balance-sheet', [FinancialReportsController::class, 'balanceSheet'])->name('financial-reports.balance-sheet');
        Route::get('financial-reports/income-statement', [FinancialReportsController::class, 'incomeStatement'])->name('financial-reports.income-statement');
        Route::get('financial-reports/cash-flow', [FinancialReportsController::class, 'cashFlow'])->name('financial-reports.cash-flow');
        Route::get('financial-reports/general-ledger', [FinancialReportsController::class, 'generalLedger'])->name('financial-reports.general-ledger');
    });

    // Export reports (requires export permission)
    Route::middleware('permission:export_financial_reports')->group(function () {
        Route::get('financial-reports/export/{reportType}', [FinancialReportsController::class, 'export'])->name('financial-reports.export');
        Route::get('financial-reports/export/trial-balance', [FinancialReportsController::class, 'exportTrialBalance'])->name('financial-reports.export-trial-balance');
        Route::get('financial-reports/export/balance-sheet', [FinancialReportsController::class, 'exportBalanceSheet'])->name('financial-reports.export-balance-sheet');
    });

    // Audit Logs routes
    Route::middleware('permission:view_audit_logs')->group(function () {
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('audit-logs/export/excel', [AuditLogController::class, 'exportExcel'])->name('audit-logs.export.excel');
        Route::get('audit-logs/export/pdf', [AuditLogController::class, 'exportPdf'])->name('audit-logs.export.pdf');
        Route::get('audit-logs/statistics', [AuditLogController::class, 'statistics'])->name('audit-logs.statistics');
        Route::get('audit-logs/model/{modelType}/{modelId}', [AuditLogController::class, 'forModel'])->name('audit-logs.model');
        Route::get('audit-logs/user/{user}', [AuditLogController::class, 'forUser'])->name('audit-logs.user');
        Route::get('audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');
    });
});

// User profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return redirect()->route('admin.profile');
    })->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

require __DIR__ . '/auth.php';
