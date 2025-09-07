<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SendVerificationEmails extends Command
{
    protected $signature = 'emails:send-verification {email?}';
    protected $description = 'Send verification emails to unverified users';

    public function handle(): int
    {
        $email = $this->argument('email');

        if ($email) {
            $user = User::where('email', $email)->first();
            if (!$user) {
                $this->error("User with email {$email} not found.");
                return 1;
            }

            if ($user->hasVerifiedEmail()) {
                $this->info("User {$email} is already verified.");
                return 0;
            }

            $this->sendVerificationEmail($user);
        } else {
            $unverifiedUsers = User::whereNull('email_verified_at')->get();

            if ($unverifiedUsers->isEmpty()) {
                $this->info('No unverified users found.');
                return 0;
            }

            $this->info("Found {$unverifiedUsers->count()} unverified users.");

            foreach ($unverifiedUsers as $user) {
                $this->sendVerificationEmail($user);
            }
        }

        return 0;
    }

    private function sendVerificationEmail(User $user): void
    {
        try {
            $user->sendEmailVerificationNotification();
            $this->info("✓ Verification email sent to {$user->email}");
        } catch (\Exception $e) {
            $this->error("✗ Failed to send verification email to {$user->email}: {$e->getMessage()}");
        }
    }
}
