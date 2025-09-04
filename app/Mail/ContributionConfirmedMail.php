<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\IndividualContribution;
use App\Models\ContributionCampaign;

class ContributionConfirmedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $contribution;
    public $campaign;

    /**
     * Create a new message instance.
     */
    public function __construct(IndividualContribution $contribution, ContributionCampaign $campaign)
    {
        $this->contribution = $contribution;
        $this->campaign = $campaign;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusText = $this->contribution->status === 'confirmed' ? 'Confirmed' : 'Completed';
        return new Envelope(
            subject: 'Contribution ' . $statusText . ' - The Harmony Singers Choir',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contribution-confirmed',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
