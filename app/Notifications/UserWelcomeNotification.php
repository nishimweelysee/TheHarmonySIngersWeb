<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserWelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        // Don't store user in constructor to avoid serialization issues
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🎵 Welcome to The Harmony Singers Choir Portal! 🎵')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('🎉 Congratulations! Your email has been verified and your account is now fully active.')
            ->line('Welcome to The Harmony Singers Choir Portal - your gateway to managing our musical community.')
            ->line('')
            ->line('🚀 **What You Can Do Now:**')
            ->line('• Access the admin dashboard to manage choir operations')
            ->line('• View and manage member information')
            ->line('• Track contributions and donations')
            ->line('• Coordinate events and performances')
            ->line('• Access choir resources and materials')
            ->line('')
            ->action('🎭 Access Your Dashboard', route('admin.dashboard'))
            ->line('')
            ->line('📞 **Need Help?**')
            ->line('Our support team is here to assist you with any questions about the portal.')
            ->line('')
            ->line('🌟 **Our Vision:**')
            ->line('Empowering our choir leaders to create beautiful music and build stronger communities through technology and innovation.')
            ->line('')
            ->line('Thank you for being part of The Harmony Singers Choir leadership team!')
            ->line('')
            ->line('With gratitude,')
            ->line('The Harmony Singers Team 🎵');
    }

    public function toArray($notifiable): array
    {
        return [
            'user_id' => $notifiable->id,
            'user_name' => $notifiable->name,
            'type' => 'user_welcome',
            'message' => 'Welcome ' . $notifiable->name . '! Your account is now active.'
        ];
    }
}
