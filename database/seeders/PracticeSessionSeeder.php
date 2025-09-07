<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PracticeSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing practice sessions
        DB::table('practice_sessions')->truncate();

        // Get current date
        $currentDate = Carbon::now();

        // Start from the next Friday if today is not Friday
        $startDate = $currentDate->copy();
        if ($startDate->dayOfWeek !== Carbon::FRIDAY) {
            $startDate->next(Carbon::FRIDAY);
        }

        // Generate practice sessions for the next 3 months (approximately 26 weeks)
        $sessions = [];
        $sessionId = 1;

        for ($week = 0; $week < 26; $week++) {
            // Friday session: 19:30-20:30
            $fridayDate = $startDate->copy()->addWeeks($week);
            $sessions[] = [
                'id' => $sessionId++,
                'title' => 'Friday Practice Session',
                'description' => 'Weekly Friday evening practice session for all choir members.',
                'practice_date' => $fridayDate->format('Y-m-d'),
                'start_time' => '19:30:00',
                'end_time' => '20:30:00',
                'venue' => 'Main Rehearsal Hall',
                'venue_address' => '123 Harmony Street, Music District',
                'status' => $fridayDate->isPast() ? 'completed' : 'scheduled',
                'notes' => 'Focus on vocal warm-ups and current repertoire.',
                'reminders_sent' => false,
                'reminder_sent_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Saturday session: 15:00-18:00
            $saturdayDate = $fridayDate->copy()->addDay();
            $sessions[] = [
                'id' => $sessionId++,
                'title' => 'Saturday Practice Session',
                'description' => 'Extended Saturday afternoon practice session for intensive rehearsal.',
                'practice_date' => $saturdayDate->format('Y-m-d'),
                'start_time' => '15:00:00',
                'end_time' => '18:00:00',
                'venue' => 'Main Rehearsal Hall',
                'venue_address' => '123 Harmony Street, Music District',
                'status' => $saturdayDate->isPast() ? 'completed' : 'scheduled',
                'notes' => 'Extended session for complex pieces and sectionals.',
                'reminders_sent' => false,
                'reminder_sent_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert all sessions
        DB::table('practice_sessions')->insert($sessions);

        $this->command->info('Practice sessions seeded successfully!');
        $this->command->info('Created ' . count($sessions) . ' practice sessions for the next 26 weeks.');
        $this->command->info('Schedule: Friday 19:30-20:30, Saturday 15:00-18:00');

        // Show sample of created sessions
        $this->command->info('Sample sessions:');
        $sampleSessions = DB::table('practice_sessions')
            ->orderBy('practice_date', 'asc')
            ->limit(6)
            ->get(['id', 'title', 'practice_date', 'start_time', 'end_time']);

        foreach ($sampleSessions as $session) {
            $this->command->info("ID: {$session->id} | {$session->title} | {$session->practice_date} | {$session->start_time}-{$session->end_time}");
        }
    }
}
