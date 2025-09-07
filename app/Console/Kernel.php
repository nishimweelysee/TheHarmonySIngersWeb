<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Check for birthdays daily at 9:00 AM
        $schedule->command('birthdays:check')
            ->dailyAt('09:00')
            ->appendOutputTo(storage_path('logs/birthday-checker.log'));

        // Send practice reminders at specific times
        $schedule->command('practice:send-reminders')
            ->everyMinute() // Check every minute for optimal timing
            ->appendOutputTo(storage_path('logs/practice-reminders.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
