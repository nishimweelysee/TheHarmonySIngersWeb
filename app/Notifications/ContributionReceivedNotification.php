<?php

namespace App\Notifications;

use App\Models\Contribution;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContributionReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Contribution $contribution;

    public function __construct(Contribution $contribution)
    {
        $this->contribution = $contribution;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🎵 Thank You for Your Contribution to THS! 🎵')
            ->greeting('Dear ' . $this->contribution->contributor_name . ',')
            ->line('🎉 **Thank you for your generous contribution to The Harmony Singers Choir!**')
            ->line('Your support enables us to continue creating beautiful music and inspiring communities through harmony.')
            ->line('')
            ->line('📊 **Contribution Details:**')
            ->line('• **Amount:** ' . $this->contribution->currency . ' ' . number_format($this->contribution->amount, 2))
            ->line('• **Type:** ' . ucfirst($this->contribution->type))
            ->line('• **Date:** ' . $this->contribution->contribution_date->format('F j, Y'))
            ->line('• **Reference:** ' . ($this->contribution->reference_number ?? 'N/A'))
            ->line('')
            ->line('🎼 **How Your Contribution Helps:**')
            ->line('• Purchasing musical instruments and equipment')
            ->line('• Funding recording sessions and performances')
            ->line('• Supporting community outreach programs')
            ->line('• Maintaining our rehearsal facilities')
            ->line('• Providing opportunities for young musicians')
            ->line('')
            ->action('🎭 View Contribution Details', route('admin.contributions.show', $this->contribution))
            ->line('')
            ->line('🌟 **Our Promise:**')
            ->line('We will use your contribution wisely to create more beautiful music, inspire more people, and build stronger communities through the power of harmony.')
            ->line('')
            ->line('Thank you for believing in our mission and supporting The Harmony Singers Choir!')
            ->line('')
            ->line('With heartfelt gratitude,')
            ->line('The Harmony Singers Team 🎵');
    }

    public function toArray($notifiable): array
    {
        return [
            'contribution_id' => $this->contribution->id,
            'contributor_name' => $this->contribution->contributor_name,
            'amount' => $this->contribution->amount,
            'type' => 'contribution_received',
            'message' => 'Contribution of ' . $this->contribution->currency . ' ' . number_format($this->contribution->amount, 2) . ' received from ' . $this->contribution->contributor_name
        ];
    }
}
