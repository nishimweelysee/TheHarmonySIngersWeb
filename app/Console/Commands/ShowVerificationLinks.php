<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowVerificationLinks extends Command
{
    protected $signature = 'emails:show-links {email?}';
    protected $description = 'Show verification links from logs for development';

    public function handle(): int
    {
        $email = $this->argument('email');
        $logFile = storage_path('logs/laravel.log');

        if (!file_exists($logFile)) {
            $this->error('Log file not found.');
            return 1;
        }

        $logContent = file_get_contents($logFile);

        // Find verification links
        preg_match_all('/http:\/\/localhost\/verify-email\/\d+\/[a-f0-9]+\?expires=\d+&signature=[a-f0-9]+/', $logContent, $matches);

        if (empty($matches[0])) {
            $this->info('No verification links found in logs.');
            return 0;
        }

        $this->info('Found verification links in logs:');
        $this->info('');

        foreach ($matches[0] as $index => $link) {
            $this->line(($index + 1) . '. ' . $link);
        }

        $this->info('');
        $this->info('Copy any of these links and paste them in your browser to verify your email.');
        $this->info('Note: Links expire after a certain time, so use the most recent ones.');

        return 0;
    }
}
