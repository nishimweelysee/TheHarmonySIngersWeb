<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Concert;

class ConcertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $concerts = [
            [
                'title' => 'Spring Serenade 2025',
                'description' => 'Join us for an enchanting evening of spring-themed classical and contemporary pieces that celebrate renewal and hope.',
                'date' => '2025-04-15',
                'time' => '19:30',
                'venue' => 'Central Community Theater',
                'type' => 'regular',
                'status' => 'upcoming',
                'ticket_price' => 25.00,
                'max_attendees' => 300,
                'is_featured' => true,
            ],
            [
                'title' => 'Holiday Harmonies 2024',
                'description' => 'A magical celebration of the holiday season with traditional carols and festive favorites.',
                'date' => '2024-12-20',
                'time' => '20:00',
                'venue' => 'St. Mary\'s Cathedral',
                'type' => 'special',
                'status' => 'completed',
                'ticket_price' => 20.00,
                'max_attendees' => 400,
                'is_featured' => true,
            ],
            [
                'title' => 'Summer Concert in the Park',
                'description' => 'An outdoor concert featuring light classical pieces and popular favorites under the stars.',
                'date' => '2025-07-12',
                'time' => '18:00',
                'venue' => 'Riverside Park Amphitheater',
                'type' => 'festival',
                'status' => 'upcoming',
                'ticket_price' => null,
                'max_attendees' => 500,
                'is_featured' => false,
            ],
        ];

        foreach ($concerts as $concert) {
            Concert::create($concert);
        }
    }
}
