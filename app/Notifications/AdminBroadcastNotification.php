<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminBroadcastNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $title;
    protected $message;
    protected $template;

    public function __construct($title, $message, $template = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->template = $template;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject('🎵 ' . $this->title . ' - The Harmony Singers Choir 🎵')
            ->greeting('Hello!')
            ->line($this->message)
            ->line('Thank you for being part of The Harmony Singers Choir community!')
            ->salutation('Best regards, The Harmony Singers Choir Team');

        // Add template-specific content if provided
        if ($this->template) {
            $mailMessage->line('')
                ->line('---')
                ->line('This message was sent using the ' . $this->template . ' template.');
        }

        return $mailMessage;
    }
}
