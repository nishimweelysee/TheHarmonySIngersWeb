<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;

class CustomVerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\Log::info('CustomVerifyEmailNotification constructor called - THS custom notification is being used!');
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        \Illuminate\Support\Facades\Log::info('CustomVerifyEmailNotification toMail called - THS custom notification is working!');

        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('🎵 Verify Your Email - The Harmony Singers Choir 🎵')
            ->greeting('Hello! 👋')
            ->line('🎉 Welcome to The Harmony Singers Choir Portal!')
            ->line('We\'re excited to have you join our musical community.')
            ->line('')
            ->line('🔐 **Email Verification Required**')
            ->line('To complete your registration and access the portal, please verify your email address by clicking the button below.')
            ->line('')
            ->line('🌟 **Why Verify?**')
            ->line('• Access to the admin dashboard')
            ->line('• Manage choir operations and members')
            ->line('• Track contributions and events')
            ->line('• Coordinate performances and rehearsals')
            ->line('')
            ->action('🎭 Verify Email Address', $verificationUrl)
            ->line('')
            ->line('⏰ **Important:** This verification link will expire in 60 minutes.')
            ->line('')
            ->line('🎵 **About The Harmony Singers Choir**')
            ->line('We create beautiful harmonies and inspire communities through the power of music.')
            ->line('')
            ->line('If you did not create an account, no further action is required.')
            ->line('')
            ->line('With musical joy,')
            ->line('The Harmony Singers Team 🎭🎵');
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        // Replace localhost with localhost:8000 if needed
        if (str_contains($url, 'http://localhost/') && !str_contains($url, ':8000')) {
            $url = str_replace('http://localhost/', 'http://localhost:8000/', $url);
        }

        \Illuminate\Support\Facades\Log::info('CustomVerifyEmailNotification verificationUrl generated: ' . $url);

        return $url;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}