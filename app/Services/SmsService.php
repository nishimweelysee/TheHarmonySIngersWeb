<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send SMS notification
     */
    public function send(string $phone, string $message): bool
    {
        try {
            // For now, we'll log the SMS. In production, you would integrate with an SMS service provider
            // like Twilio, Vonage, or a local SMS gateway

            Log::info('SMS sent', [
                'phone' => $phone,
                'message' => $message,
                'timestamp' => now()
            ]);

            // TODO: Integrate with actual SMS service provider
            // Example with Twilio:
            // $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));
            // $twilio->messages->create($phone, [
            //     'from' => config('services.twilio.from'),
            //     'body' => $message
            // ]);

            return true;
        } catch (\Exception $e) {
            Log::error('SMS sending failed', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Send birthday SMS
     */
    public function sendBirthdaySms(string $phone, string $firstName): bool
    {
        $message = "🎂 Happy Birthday, {$firstName}! 🎵\n\n" .
            "🎉 The Harmony Singers Choir (THS) wishes you a spectacular birthday!\n\n" .
            "🌟 May your day be filled with beautiful melodies and sweet harmonies.\n" .
            "🎼 Your voice makes our choir complete.\n\n" .
            "🎭 Happy Birthday from your THS Family! 🎵";

        return $this->send($phone, $message);
    }

    /**
     * Send contribution confirmation SMS
     */
    public function sendContributionSms(string $phone, string $name, float $amount, string $currency): bool
    {
        $message = "🎵 Thank you {$name}! 🎉\n\n" .
            "Your contribution of {$currency} " . number_format($amount, 2) . " has been received.\n\n" .
            "🌟 Your support enables THS to:\n" .
            "• Create beautiful music\n" .
            "• Inspire communities\n" .
            "• Build lasting harmonies\n\n" .
            "🎭 The Harmony Singers Choir (THS)";

        return $this->send($phone, $message);
    }
}
