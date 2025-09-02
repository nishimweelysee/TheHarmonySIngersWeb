<?php

namespace App\Listeners;

use App\Notifications\UserWelcomeNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
            // Send welcome notification after email verification
            $user->notify(new UserWelcomeNotification($user));

            // Create inbox notification
            $user->inboxNotifications()->create([
                'type' => 'inbox',
                'title' => 'Welcome to The Harmony Singers Choir Portal!',
                'message' => "Welcome {$user->name}! Your email has been verified and your account is now active.\n\n" .
                    "You can now access all the features of our portal. If you have any questions, feel free to contact our support team.",
                'notifiable_type' => \App\Models\User::class,
                'notifiable_id' => $user->id,
                'status' => 'unread',
                'sent_at' => now()
            ]);
        }
    }
}
