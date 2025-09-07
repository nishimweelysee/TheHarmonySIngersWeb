<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Media;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $media = [
            [
                'title' => 'Holiday Concert Highlights',
                'description' => 'Beautiful moments from our Holiday Harmonies 2024 concert',
                'type' => 'photo',
                'file_path' => 'media/holiday-concert-1.jpg',
                'file_name' => 'holiday-concert-1.jpg',
                'is_featured' => true,
                'is_public' => true,
                'event_date' => '2024-12-20',
            ],
            [
                'title' => 'Silent Night Performance',
                'description' => 'Our rendition of Silent Night from the holiday concert',
                'type' => 'audio',
                'file_path' => 'media/silent-night.mp3',
                'file_name' => 'silent-night.mp3',
                'is_featured' => true,
                'is_public' => true,
                'event_date' => '2024-12-20',
            ],
            [
                'title' => 'Choir Rehearsal Session',
                'description' => 'Behind the scenes footage of our preparation for the spring concert',
                'type' => 'video',
                'file_path' => 'media/rehearsal-footage.mp4',
                'file_name' => 'rehearsal-footage.mp4',
                'is_featured' => true,
                'is_public' => true,
                'event_date' => '2025-03-15',
            ],
            [
                'title' => 'Group Photo 2024',
                'description' => 'The Harmony Singers family photo from 2024',
                'type' => 'photo',
                'file_path' => 'media/group-photo-2024.jpg',
                'file_name' => 'group-photo-2024.jpg',
                'is_featured' => true,
                'is_public' => true,
                'event_date' => '2024-12-01',
            ],
        ];

        foreach ($media as $item) {
            Media::create($item);
        }
    }
}
