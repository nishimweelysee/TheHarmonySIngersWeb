<?php

namespace App\Http\Controllers;

use App\Models\Notification as AppNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the user's notifications.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $notifications = $user->inboxNotifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(AppNotification $notification)
    {
        // Check if the notification belongs to the authenticated user
        if (
            $notification->notifiable_type === get_class(Auth::user()) &&
            $notification->notifiable_id === Auth::id()
        ) {

            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->inboxNotifications()
            ->where('status', 'unread')
            ->update([
                'status' => 'read',
                'read_at' => now()
            ]);

        return response()->json(['success' => true]);
    }

    /**
     * Get unread notifications count for AJAX requests.
     */
    public function unreadCount()
    {
        /** @var User $user */
        $user = Auth::user();
        $count = $user->inboxNotifications()->unread()->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Delete a notification.
     */
    public function destroy(AppNotification $notification)
    {
        // Check if the notification belongs to the authenticated user
        if (
            $notification->notifiable_type === get_class(Auth::user()) &&
            $notification->notifiable_id === Auth::id()
        ) {

            $notification->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }
}