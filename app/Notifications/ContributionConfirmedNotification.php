<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\IndividualContribution;
use App\Models\ContributionCampaign;

class ContributionConfirmedNotification extends Notification
{

    protected $contribution;
    protected $campaign;

    /**
     * Create a new notification instance.
     */
    public function __construct(IndividualContribution $contribution, ContributionCampaign $campaign)
    {
        $this->contribution = $contribution;
        $this->campaign = $campaign;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusText = $this->contribution->status === 'confirmed' ? 'confirmed' : 'completed';

        return (new MailMessage)
            ->subject('Contribution ' . ucfirst($statusText) . ' - The Harmony Singers Choir')
            ->greeting('Dear ' . $this->contribution->contributor_name . ',')
            ->line('We are pleased to inform you that your contribution has been **' . $statusText . '**!')
            ->line('**Campaign:** ' . $this->campaign->name)
            ->line('**Amount:** ' . $this->contribution->currency . ' ' . number_format($this->contribution->amount, 2))
            ->line('**Date:** ' . $this->contribution->contribution_date->format('F j, Y'))
            ->line('**Payment Method:** ' . ucfirst(str_replace('_', ' ', $this->contribution->payment_method)))
            ->line('**Status:** ' . ucfirst($this->contribution->status))
            ->when($this->contribution->reference_number, function ($message) {
                return $message->line('**Reference Number:** ' . $this->contribution->reference_number);
            })
            ->when($this->contribution->notes, function ($message) {
                return $message->line('**Notes:** ' . $this->contribution->notes);
            })
            ->line('Thank you for your generous contribution to The Harmony Singers Choir. Your support helps us continue our mission of bringing beautiful music to our community.')
            ->line('If you have any questions about your contribution, please don\'t hesitate to contact us.')
            ->salutation('Best regards,')
            ->line('The Harmony Singers Choir Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'contribution_id' => $this->contribution->id,
            'campaign_id' => $this->campaign->id,
            'campaign_name' => $this->campaign->name,
            'contributor_name' => $this->contribution->contributor_name,
            'amount' => $this->contribution->amount,
            'currency' => $this->contribution->currency,
            'status' => $this->contribution->status,
            'contribution_date' => $this->contribution->contribution_date,
        ];
    }
}
