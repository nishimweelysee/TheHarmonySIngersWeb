<?php

namespace App\Listeners;

use App\Models\Role;
use App\Notifications\UserWelcomeNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendWelcomeNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        $user = $event->user;

        // Cast to User model to access notification methods
        if ($user instanceof \App\Models\User) {
            // Assign default "user" role if user doesn't have a role yet
            if (!$user->role_id) {
                $userRole = Role::where('name', 'user')->first();
                if ($userRole) {
                    $user->update(['role_id' => $userRole->id]);
                    Log::info("Assigned default 'user' role to verified user: {$user->email}");
                } else {
                    Log::warning("Default 'user' role not found when trying to assign to user: {$user->email}");
                }
            }

            // Send welcome notification after email verification
            $user->notify(new UserWelcomeNotification());

            // Create inbox notification
            $user->inboxNotifications()->create([
                'type' => 'inbox',
                'title' => 'Welcome to The Harmony Singers Choir Portal!',
                'message' => "Welcome {$user->name}! Your email has been verified and your account is now active.\n\n" .
                    "You have been assigned the Regular User role, which gives you access to view content in our portal. " .
                    "If you need additional permissions, please contact an administrator.\n\n" .
                    "If you have any questions, feel free to contact our support team.",
                'notifiable_type' => \App\Models\User::class,
                'notifiable_id' => $user->id,
                'status' => 'unread',
                'sent_at' => now()
            ]);
        }
    }
}
