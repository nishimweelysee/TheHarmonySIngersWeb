<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Notifications\BirthdayNotification;
use App\Services\SmsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class CheckBirthdays extends Command
{
    protected $signature = 'birthdays:check';
    protected $description = 'Check for member birthdays and send notifications';

    public function handle(SmsService $smsService): int
    {
        $this->info('Checking for birthdays...');

        $today = now();
        $membersWithBirthdays = Member::where('is_active', true)
            ->whereNotNull('date_of_birth')
            ->get()
            ->filter(function ($member) use ($today) {
                return $member->date_of_birth->format('m-d') === $today->format('m-d');
            });

        if ($membersWithBirthdays->isEmpty()) {
            $this->info('No birthdays today.');
            return 0;
        }

        $this->info("Found {$membersWithBirthdays->count()} member(s) with birthdays today.");

        foreach ($membersWithBirthdays as $member) {
            $this->info("Processing birthday for: {$member->full_name}");

            try {
                // Send email notification
                if ($member->email) {
                    $member->notify(new BirthdayNotification($member));
                    $this->info("  ✓ Email notification sent to {$member->email}");
                }

                // Send SMS notification
                if ($member->phone) {
                    $smsSent = $smsService->sendBirthdaySms($member->phone, $member->first_name);
                    if ($smsSent) {
                        $this->info("  ✓ SMS notification sent to {$member->phone}");
                    } else {
                        $this->warn("  ✗ SMS notification failed for {$member->phone}");
                    }
                }

                // Create inbox notification
                $member->inboxNotifications()->create([
                    'type' => 'inbox',
                    'title' => '🎂 Happy Birthday from THS! 🎵',
                    'message' => "🎉 Happy Birthday, {$member->first_name}! 🎂\n\n" .
                        "🎵 **The Harmony Singers Choir wishes you a spectacular birthday!**\n\n" .
                        "🌟 **Birthday Wishes from THS:**\n" .
                        "• May your day be filled with beautiful melodies\n" .
                        "• May your voice continue to inspire others\n" .
                        "• May your passion for music grow stronger\n" .
                        "• May you find happiness in every note\n" .
                        "• May your year ahead be harmonious and joyful\n\n" .
                        "🎼 **You Are Special Because:**\n" .
                        "Your unique voice and dedication make The Harmony Singers Choir what it is today.\n" .
                        "Every rehearsal, every performance, every moment with you enriches our musical family.\n\n" .
                        "🎭 **Happy Birthday from your THS Family!** 🎵",
                    'notifiable_type' => Member::class,
                    'notifiable_id' => $member->id,
                    'status' => 'unread',
                    'sent_at' => now()
                ]);

                $this->info("  ✓ Inbox notification created");
            } catch (\Exception $e) {
                $this->error("  ✗ Error processing birthday for {$member->full_name}: {$e->getMessage()}");
            }
        }

        $this->info('Birthday check completed!');
        return 0;
    }
}
