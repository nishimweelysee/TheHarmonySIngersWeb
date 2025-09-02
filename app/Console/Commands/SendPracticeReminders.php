<?php

namespace App\Console\Commands;

use App\Models\PracticeSession;
use App\Models\Member;
use App\Notifications\PracticeReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class SendPracticeReminders extends Command
{
    protected $signature = 'practice:send-reminders';
    protected $description = 'Send practice reminders to all active singers';

    public function handle(): int
    {
        $this->info('🎵 Checking for practice sessions that need reminders...');

        $now = now();
        $sessionsNeedingReminders = PracticeSession::where('status', 'scheduled')
            ->where('reminders_sent', false)
            ->get()
            ->filter(function ($session) use ($now) {
                return $this->shouldSendReminder($session, $now);
            });

        if ($sessionsNeedingReminders->isEmpty()) {
            $this->info('No practice sessions need reminders at this time.');
            return 0;
        }

        $this->info("Found {$sessionsNeedingReminders->count()} practice session(s) needing reminders.");

        $activeSingers = Member::active()->singers()->get();
        $this->info("Sending reminders to {$activeSingers->count()} active singers.");

        foreach ($sessionsNeedingReminders as $session) {
            $this->info("Processing reminders for: {$session->title} on {$session->practice_date->format('F j, Y')}");

            $reminderType = $this->getReminderType($session, $now);
            $this->info("  Reminder type: {$reminderType}");

            $sentCount = 0;
            $errors = [];

            foreach ($activeSingers as $singer) {
                try {
                    $singer->notify(new PracticeReminderNotification($session, $reminderType));
                    $sentCount++;
                    $this->info("    ✓ Reminder sent to {$singer->full_name} ({$singer->email})");
                } catch (\Exception $e) {
                    $errors[] = "Failed to send reminder to {$singer->full_name}: " . $e->getMessage();
                    $this->warn("    ✗ Failed to send reminder to {$singer->full_name}");
                }
            }

            $this->info("  Sent {$sentCount} reminders successfully.");

            if (!empty($errors)) {
                $this->warn("  Errors encountered:");
                foreach ($errors as $error) {
                    $this->warn("    - {$error}");
                }
            }

            // Mark reminders as sent for this session
            $session->markRemindersSent();
            $this->info("  ✓ Marked reminders as sent for this session.");
        }

        $this->info('🎵 Practice reminder process completed!');
        return 0;
    }

    private function shouldSendReminder(PracticeSession $session, Carbon $now): bool
    {
        $practiceDateTime = Carbon::parse($session->practice_date . ' ' . $session->start_time);
        $hoursUntilPractice = $now->diffInHours($practiceDateTime, false);

        // Send reminders at specific intervals
        return in_array($hoursUntilPractice, [24, 0, -0.5]); // 1 day before, morning of, 30 minutes before
    }

    private function getReminderType(PracticeSession $session, Carbon $now): string
    {
        $practiceDateTime = Carbon::parse($session->practice_date . ' ' . $session->start_time);
        $hoursUntilPractice = $now->diffInHours($practiceDateTime, false);

        return match (true) {
            $hoursUntilPractice == 24 => 'day_before',
            $hoursUntilPractice == 0 => 'morning',
            $hoursUntilPractice == -0.5 => 'thirty_minutes',
            default => 'general'
        };
    }
}
