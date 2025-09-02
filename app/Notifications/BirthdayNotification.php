<?php

namespace App\Notifications;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BirthdayNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Member $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🎂 Happy Birthday, ' . $this->member->first_name . '! 🎵')
            ->greeting('🎉 Happy Birthday, ' . $this->member->first_name . '! 🎂')
            ->line('🎵 **The Harmony Singers Choir wishes you a spectacular birthday!**')
            ->line('On this special day, may your heart be filled with the same joy and harmony you bring to our choir.')
            ->line('')
            ->line('🌟 **Birthday Wishes from THS:**')
            ->line('• May your day be filled with beautiful melodies')
            ->line('• May your voice continue to inspire others')
            ->line('• May your passion for music grow stronger')
            ->line('• May you find happiness in every note')
            ->line('• May your year ahead be harmonious and joyful')
            ->line('')
            ->line('🎼 **You Are Special Because:**')
            ->line('Your unique voice and dedication make The Harmony Singers Choir what it is today.')
            ->line('Every rehearsal, every performance, every moment with you enriches our musical family.')
            ->line('')
            ->action('🎭 Visit Our Website', url('/'))
            ->line('')
            ->line('🎵 **A Musical Birthday Song for You:**')
            ->line('"May your birthday be filled with sweet harmonies,')
            ->line('Like the beautiful music we create together.')
            ->line('May your year ahead be full of joy and melody,')
            ->line('And may your voice continue to inspire forever."')
            ->line('')
            ->line('🎂 **Happy Birthday from your THS Family!** 🎵')
            ->line('')
            ->line('With love and musical joy,')
            ->line('The Harmony Singers Choir 🎭🎵');
    }

    public function toArray($notifiable): array
    {
        return [
            'member_id' => $this->member->id,
            'member_name' => $this->member->full_name,
            'type' => 'birthday',
            'message' => 'Happy Birthday, ' . $this->member->first_name . '! 🎉'
        ];
    }
}
