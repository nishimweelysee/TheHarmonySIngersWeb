<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            ['first_name' => 'Sarah', 'last_name' => 'Johnson', 'email' => 'sarah.johnson@email.com', 'type' => 'singer', 'voice_part' => 'soprano', 'join_date' => '2020-01-15'],
            ['first_name' => 'Michael', 'last_name' => 'Chen', 'email' => 'michael.chen@email.com', 'type' => 'singer', 'voice_part' => 'tenor', 'join_date' => '2019-09-10'],
            ['first_name' => 'Emily', 'last_name' => 'Rodriguez', 'email' => 'emily.rodriguez@email.com', 'type' => 'singer', 'voice_part' => 'alto', 'join_date' => '2021-03-22'],
            ['first_name' => 'David', 'last_name' => 'Williams', 'email' => 'david.williams@email.com', 'type' => 'singer', 'voice_part' => 'bass', 'join_date' => '2018-11-05'],
            ['first_name' => 'Jessica', 'last_name' => 'Brown', 'email' => 'jessica.brown@email.com', 'type' => 'singer', 'voice_part' => 'soprano', 'join_date' => '2022-01-08'],
            ['first_name' => 'Robert', 'last_name' => 'Davis', 'email' => 'robert.davis@email.com', 'type' => 'general', 'voice_part' => null, 'join_date' => '2020-06-15'],
            ['first_name' => 'Lisa', 'last_name' => 'Anderson', 'email' => 'lisa.anderson@email.com', 'type' => 'singer', 'voice_part' => 'alto', 'join_date' => '2019-04-12'],
            ['first_name' => 'James', 'last_name' => 'Wilson', 'email' => 'james.wilson@email.com', 'type' => 'singer', 'voice_part' => 'tenor', 'join_date' => '2021-08-30'],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}
