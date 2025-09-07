<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use App\Models\Notification as AppNotification;
use App\Services\NotificationExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


class NotificationManagementController extends Controller
{
    /**
     * Display the notification management dashboard.
     */
    public function index(Request $request)
    {
        $query = AppNotification::with('notifiable');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $perPage = $request->get('per_page', 10);
        $recentNotifications = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $stats = [
            'total_notifications' => AppNotification::count(),
            'unread_notifications' => AppNotification::where('status', 'unread')->count(),
            'total_members' => Member::count(),
            'total_users' => User::count(),
        ];

        return view('admin.notifications.index', compact('recentNotifications', 'stats'));
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        $exportService = new NotificationExportService();
        return $exportService->exportToExcel($request);
    }

    /**
     * Export to PDF
     */
    public function exportPdf(Request $request)
    {
        $exportService = new NotificationExportService();
        return $exportService->exportToPdf($request);
    }

    /**
     * Show the form for sending new notifications.
     */
    public function create()
    {

        $members = Member::select('id', 'first_name', 'last_name', 'email', 'type', 'voice_part')
            ->orderBy('first_name')
            ->get();

        $users = User::select('id', 'name', 'email', 'role_id')
            ->with('role')
            ->orderBy('name')
            ->get();

        $notificationTemplates = $this->getNotificationTemplates();

        return view('admin.notifications.create', compact('members', 'users', 'notificationTemplates'));
    }

    /**
     * Send notifications to selected recipients.
     */
    public function store(Request $request)
    {
        // Log the incoming request for debugging
        Log::info('Notification form submitted', [
            'request_data' => $request->all(),
            'user_id' => Auth::id()
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'recipient_type' => 'required|in:all_members,all_users,selected_members,selected_users,custom',
            'selected_recipients' => 'required_if:recipient_type,selected_members,selected_users|array',
            'custom_emails' => 'nullable|string|required_if:recipient_type,custom',
            'send_email' => 'boolean',
            'send_sms' => 'boolean',
            'send_inbox' => 'boolean',
            'template' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $recipients = $this->getRecipients($request);

            // Auto-populate custom_emails for selected recipients
            if (in_array($request->recipient_type, ['selected_members', 'selected_users']) && !empty($recipients)) {
                $emails = collect($recipients)->pluck('email')->filter()->implode(', ');
                $request->merge(['custom_emails' => $emails]);

                Log::info('Auto-populated custom_emails', [
                    'emails' => $emails,
                    'recipient_type' => $request->recipient_type
                ]);
            }

            // Log recipients for debugging
            Log::info('Recipients determined', [
                'recipient_type' => $request->recipient_type,
                'recipients_count' => count($recipients),
                'recipients' => $recipients
            ]);

            $notificationData = [
                'title' => $request->title,
                'message' => $request->message,
                'type' => 'admin_broadcast',
                'data' => [
                    'template' => $request->template,
                    'sent_by' => Auth::id(),
                    'recipient_type' => $request->recipient_type,
                    'custom_emails' => $request->custom_emails,
                    'delivery_methods' => [
                        'email' => $request->boolean('send_email'),
                        'sms' => $request->boolean('send_sms'),
                        'inbox' => $request->boolean('send_inbox'),
                    ]
                ],
                'sent_at' => now(),
            ];

            // Log notification data for debugging
            Log::info('Notification data prepared', [
                'notification_data' => $notificationData,
                'custom_emails' => $request->custom_emails,
                'recipient_type' => $request->recipient_type
            ]);

            $sentCount = 0;
            $errors = [];

            foreach ($recipients as $recipient) {
                try {
                    $this->sendNotificationToRecipient($recipient, $notificationData);
                    $sentCount++;
                } catch (\Exception $e) {
                    $errors[] = "Failed to send to {$recipient['email']}: " . $e->getMessage();
                    Log::error('Notification delivery failed', [
                        'recipient' => $recipient,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            DB::commit();

            Log::info('Notifications sent successfully', [
                'sent_count' => $sentCount,
                'errors_count' => count($errors)
            ]);

            return redirect()->route('admin.notifications.index')
                ->with('success', "Successfully sent notifications to {$sentCount} recipients." .
                    (count($errors) > 0 ? ' ' . count($errors) . ' failed.' : ''));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to send notifications', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return back()->withInput()
                ->with('error', 'Failed to send notifications: ' . $e->getMessage());
        }
    }

    /**
     * Get recipients based on request parameters.
     */
    private function getRecipients(Request $request): array
    {
        $recipients = [];

        switch ($request->recipient_type) {
            case 'all_members':
                $recipients = Member::whereNotNull('email')
                    ->select('id', 'first_name', 'last_name', 'email', 'phone')
                    ->get()
                    ->map(function ($member) {
                        return [
                            'id' => $member->id,
                            'name' => $member->full_name,
                            'email' => $member->email,
                            'phone' => $member->phone,
                            'type' => 'member'
                        ];
                    })
                    ->toArray();
                break;

            case 'all_users':
                $recipients = User::select('id', 'name', 'email')
                    ->get()
                    ->map(function ($user) {
                        return [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'phone' => null,
                            'type' => 'user'
                        ];
                    })
                    ->toArray();
                break;

            case 'selected_members':
                $memberIds = collect($request->selected_recipients)
                    ->filter(function ($value) {
                        return str_starts_with($value, 'member_');
                    })
                    ->map(function ($value) {
                        return (int) str_replace('member_', '', $value);
                    })
                    ->toArray();

                $recipients = Member::whereIn('id', $memberIds)
                    ->select('id', 'first_name', 'last_name', 'email', 'phone')
                    ->get()
                    ->map(function ($member) {
                        return [
                            'id' => $member->id,
                            'name' => $member->full_name,
                            'email' => $member->email,
                            'phone' => $member->phone,
                            'type' => 'member'
                        ];
                    })
                    ->toArray();
                break;

            case 'selected_users':
                $userIds = collect($request->selected_recipients)
                    ->filter(function ($value) {
                        return str_starts_with($value, 'user_');
                    })
                    ->map(function ($value) {
                        return (int) str_replace('user_', '', $value);
                    })
                    ->toArray();

                $recipients = User::whereIn('id', $userIds)
                    ->select('id', 'name', 'email')
                    ->get()
                    ->map(function ($user) {
                        return [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'phone' => null,
                            'type' => 'user'
                        ];
                    })
                    ->toArray();
                break;

            case 'custom':
                $emails = array_filter(array_map('trim', explode(',', $request->custom_emails)));
                foreach ($emails as $email) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $recipients[] = [
                            'id' => null,
                            'name' => 'Custom Recipient',
                            'email' => $email,
                            'phone' => null,
                            'type' => 'custom'
                        ];
                    }
                }
                break;
        }

        return $recipients;
    }

    /**
     * Send notification to a single recipient.
     */
    private function sendNotificationToRecipient(array $recipient, array $notificationData): void
    {
        $deliveryMethods = $notificationData['data']['delivery_methods'];

        // Send inbox notification
        if ($deliveryMethods['inbox'] && $recipient['type'] !== 'custom') {
            $this->createInboxNotification($recipient, $notificationData);
        }

        // Send email notification
        if ($deliveryMethods['email'] && $recipient['email']) {
            $this->sendEmailNotification($recipient, $notificationData);
        }

        // Send SMS notification
        if ($deliveryMethods['sms'] && $recipient['phone']) {
            $this->sendSmsNotification($recipient, $notificationData);
        }
    }

    /**
     * Create inbox notification.
     */
    private function createInboxNotification(array $recipient, array $notificationData): void
    {
        $notifiableType = $recipient['type'] === 'member' ? Member::class : User::class;

        AppNotification::create([
            'type' => 'admin_broadcast',
            'title' => $notificationData['title'],
            'message' => $notificationData['message'],
            'notifiable_type' => $notifiableType,
            'notifiable_id' => $recipient['id'],
            'status' => 'unread',
            'data' => $notificationData['data'],
            'sent_at' => $notificationData['sent_at'],
        ]);
    }

    /**
     * Send email notification.
     */
    private function sendEmailNotification(array $recipient, array $notificationData): void
    {
        try {
            // Send the email notification using Notification facade
            \Illuminate\Support\Facades\Notification::route('mail', $recipient['email'])
                ->notify(new \App\Notifications\AdminBroadcastNotification(
                    $notificationData['title'],
                    $notificationData['message'],
                    $notificationData['data']['template'] ?? null
                ));

            Log::info('Email notification sent successfully', [
                'recipient' => $recipient['email'],
                'title' => $notificationData['title']
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send email notification', [
                'recipient' => $recipient['email'],
                'title' => $notificationData['title'],
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send SMS notification.
     */
    private function sendSmsNotification(array $recipient, array $notificationData): void
    {
        // For now, we'll log the SMS notification
        // In a production system, you'd integrate with an SMS service
        Log::info('SMS notification sent', [
            'recipient' => $recipient['phone'],
            'title' => $notificationData['title'],
            'message' => $notificationData['message']
        ]);
    }

    /**
     * Get notification templates.
     */
    private function getNotificationTemplates(): array
    {
        return [
            'general_announcement' => [
                'name' => 'General Announcement',
                'title' => '🎵 Important Announcement from THS',
                'message' => "Dear THS Family,\n\nWe have an important announcement to share with you.\n\nPlease read the details below and take any necessary action.\n\nThank you for your attention.\n\nBest regards,\nThe Harmony Singers Team"
            ],
            'rehearsal_reminder' => [
                'name' => 'Rehearsal Reminder',
                'title' => '🎭 Rehearsal Reminder - The Harmony Singers',
                'message' => "Hello THS Members!\n\nThis is a friendly reminder about our upcoming rehearsal.\n\nPlease ensure you arrive on time and bring your music sheets.\n\nWe look forward to creating beautiful music together!\n\nSee you there!\n\nBest regards,\nThe Harmony Singers Team"
            ],
            'concert_announcement' => [
                'name' => 'Concert Announcement',
                'title' => '🎼 Concert Announcement - The Harmony Singers',
                'message' => "Dear THS Family,\n\nWe are excited to announce our upcoming concert!\n\nThis will be a wonderful opportunity to showcase our talent and share beautiful music with our community.\n\nPlease mark your calendars and spread the word!\n\nBest regards,\nThe Harmony Singers Team"
            ],
            'event_announcement' => [
                'name' => 'Event Announcement',
                'title' => '🌟 Exciting Event Announcement - THS',
                'message' => "Dear THS Family,\n\nWe have exciting news about an upcoming event!\n\nPlease read the details below and mark your calendars.\n\nThis promises to be a wonderful opportunity for our choir.\n\nBest regards,\nThe Harmony Singers Team"
            ],
            'birthday_wishes' => [
                'name' => 'Birthday Wishes',
                'title' => '🎂 Happy Birthday from THS! 🎂',
                'message' => "Dear {name},\n\n🎉 Happy Birthday! 🎉\n\nOn this special day, we want to wish you a wonderful birthday filled with joy, music, and happiness!\n\nThank you for being part of The Harmony Singers Choir family.\n\nMay your day be as beautiful as the music we create together! 🎵\n\nWith warmest wishes,\nThe Harmony Singers Team"
            ],
            'custom' => [
                'name' => 'Custom Message',
                'title' => '',
                'message' => ''
            ]
        ];
    }

    /**
     * Delete a notification.
     */
    public function destroy(AppNotification $notification)
    {

        try {
            $notification->delete();
            return redirect()->route('admin.notifications.index')
                ->with('success', 'Notification deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete notification', [
                'notification_id' => $notification->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to delete notification: ' . $e->getMessage());
        }
    }

    /**
     * Get notification statistics for dashboard.
     */
    public function stats()
    {

        $stats = [
            'total_sent_today' => AppNotification::whereDate('created_at', today())->count(),
            'total_sent_this_week' => AppNotification::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'total_sent_this_month' => AppNotification::whereMonth('created_at', now()->month)->count(),
            'delivery_success_rate' => 95.5, // This would be calculated based on actual delivery tracking
        ];

        return response()->json($stats);
    }
}
