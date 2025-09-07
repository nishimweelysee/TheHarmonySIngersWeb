<?php

namespace App\Notifications;

use App\Models\PracticeSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PracticeReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected PracticeSession $practiceSession;
    protected string $reminderType; // 'day_before', 'morning', 'thirty_minutes'

    public function __construct(PracticeSession $practiceSession, string $reminderType)
    {
        $this->practiceSession = $practiceSession;
        $this->reminderType = $reminderType;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $subject = $this->getSubject();
        $greeting = $this->getGreeting($notifiable);
        $urgency = $this->getUrgencyMessage();

        $mailMessage = (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line('🎵 **Practice Reminder from The Harmony Singers Choir!**')
            ->line($urgency)
            ->line('')
            ->line('📅 **Practice Details:**')
            ->line('• **Date:** ' . $this->practiceSession->practice_date->format('F j, Y'))
            ->line('• **Time:** ' . $this->practiceSession->start_time->format('g:i A') . ' - ' . $this->practiceSession->end_time->format('g:i A'))
            ->line('• **Duration:** ' . $this->practiceSession->duration)
            ->line('• **Title:** ' . $this->practiceSession->title);

        if ($this->practiceSession->venue) {
            $mailMessage->line('• **Venue:** ' . $this->practiceSession->venue);
        }

        if ($this->practiceSession->venue_address) {
            $mailMessage->line('• **Address:** ' . $this->practiceSession->venue_address);
        }

        if ($this->practiceSession->description) {
            $mailMessage->line('')
                ->line('📝 **Description:**')
                ->line($this->practiceSession->description);
        }

        $mailMessage->line('')
            ->line('🎼 **What to Bring:**')
            ->line('• Your music sheets and lyrics')
            ->line('• A positive attitude and enthusiasm')
            ->line('• Water bottle (stay hydrated!)')
            ->line('• Any questions or suggestions');

        if ($this->reminderType === 'day_before') {
            $mailMessage->line('')
                ->line('⏰ **Please confirm your attendance** by responding to this email or contacting your choir director.');
        }

        if ($this->reminderType === 'morning') {
            $mailMessage->line('')
                ->line('🌅 **Today is the day!** Please ensure you\'re ready and on time.');
        }

        if ($this->reminderType === 'thirty_minutes') {
            $mailMessage->line('')
                ->line('🚨 **Practice starts in 30 minutes!** Please make your way to the venue.');
        }

        $mailMessage->line('')
            ->line('🎭 **We can\'t wait to create beautiful music together!**')
            ->line('')
            ->action('🎵 View Practice Details', url('/admin/practice-sessions/' . $this->practiceSession->id))
            ->line('')
            ->line('Best regards,')
            ->line('The Harmony Singers Choir Team')
            ->line('🎼 Making Harmony, Creating Joy 🎵');

        return $mailMessage;
    }

    public function toArray($notifiable): array
    {
        return [
            'practice_session_id' => $this->practiceSession->id,
            'reminder_type' => $this->reminderType,
            'practice_date' => $this->practiceSession->practice_date->toDateString(),
            'start_time' => $this->practiceSession->start_time->format('H:i'),
            'title' => $this->practiceSession->title
        ];
    }

    private function getSubject(): string
    {
        return match ($this->reminderType) {
            'day_before' => '🎵 Practice Reminder - Tomorrow at ' . $this->practiceSession->start_time->format('g:i A'),
            'morning' => '🎵 Practice Today - ' . $this->practiceSession->start_time->format('g:i A'),
            'thirty_minutes' => '🚨 Practice in 30 Minutes!',
            default => '🎵 Practice Reminder - The Harmony Singers'
        };
    }

    private function getGreeting($notifiable): string
    {
        return match ($this->reminderType) {
            'day_before' => 'Hello ' . $this->getMemberName($notifiable) . '! 👋',
            'morning' => 'Good morning ' . $this->getMemberName($notifiable) . '! 🌅',
            'thirty_minutes' => 'Hi ' . $this->getMemberName($notifiable) . '! ⏰',
            default => 'Hello ' . $this->getMemberName($notifiable) . '!'
        };
    }

    private function getUrgencyMessage(): string
    {
        return match ($this->reminderType) {
            'day_before' => 'This is a friendly reminder about tomorrow\'s choir practice.',
            'morning' => 'Today is practice day! We\'re looking forward to seeing you.',
            'thirty_minutes' => 'Practice is starting very soon! Please make sure you\'re on your way.',
            default => 'This is a reminder about your upcoming choir practice.'
        };
    }

    private function getMemberName($notifiable): string
    {
        if (method_exists($notifiable, 'first_name')) {
            return $notifiable->first_name;
        }

        if (method_exists($notifiable, 'name')) {
            return $notifiable->name;
        }

        return 'there';
    }
}
