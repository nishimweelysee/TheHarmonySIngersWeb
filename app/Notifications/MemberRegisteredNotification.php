<?php

namespace App\Notifications;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberRegisteredNotification extends Notification implements ShouldQueue
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
            ->subject('🎵 Welcome to The Harmony Singers Choir! 🎵')
            ->greeting('Hello ' . $this->member->first_name . '!')
            ->line('🎉 Welcome to The Harmony Singers Choir! We are thrilled to have you join our musical family.')
            ->line('Your voice and passion for music will enrich our choir and help us create beautiful harmonies together.')
            ->line('📋 **Membership Details:**')
            ->line('• **Name:** ' . $this->member->full_name)
            ->line('• **Member Type:** ' . ucfirst($this->member->type))
            ->line('• **Join Date:** ' . $this->member->join_date->format('F j, Y'))
            ->line('• **Voice Part:** ' . ($this->member->voice_part ? ucfirst($this->member->voice_part) : 'To be determined'))
            ->line('')
            ->line('🎼 **What\'s Next?**')
            ->line('• You\'ll receive rehearsal schedules and event updates')
            ->line('• Join our choir WhatsApp group for communication')
            ->line('• Prepare for upcoming performances and recordings')
            ->action('🎭 Visit Our Website', url('/'))
            ->line('')
            ->line('🌟 **Our Mission:**')
            ->line('To spread joy through music, inspire communities, and create lasting harmonies that touch hearts.')
            ->line('')
            ->line('Thank you for choosing to be part of The Harmony Singers Choir!')
            ->line('')
            ->line('With musical joy,')
            ->line('The Harmony Singers Team 🎵');
    }

    public function toArray($notifiable): array
    {
        return [
            'member_id' => $this->member->id,
            'member_name' => $this->member->full_name,
            'type' => 'member_registered',
            'message' => 'New member ' . $this->member->full_name . ' has been registered.'
        ];
    }
}
