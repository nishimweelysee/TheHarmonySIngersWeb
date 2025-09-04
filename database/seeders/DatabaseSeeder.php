<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run role and permission seeder first
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Create or update admin user
        $adminRole = Role::where('name', 'admin')->first();

        User::updateOrCreate(
            ['email' => 'theharmonysingerschoir@gmail.com'],
            [
                'name' => 'Admin User',
                'email' => 'theharmonysingerschoir@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        // Run other seeders
        $this->call([
            MemberSeeder::class,
            ConcertSeeder::class,
            MediaSeeder::class,
            PracticeSessionSeeder::class,
        ]);
    }
}
