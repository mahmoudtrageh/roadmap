<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@roadmap.camp',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Instructor User
        User::create([
            'name' => 'John Instructor',
            'email' => 'instructor@roadmap.camp',
            'password' => Hash::make('password'),
            'role' => 'instructor',
            'email_verified_at' => now(),
        ]);

        // Create Student Users
        User::create([
            'name' => 'Alice Student',
            'email' => 'alice@roadmap.camp',
            'password' => Hash::make('password'),
            'role' => 'student',
            'current_streak' => 5,
            'longest_streak' => 12,
            'last_activity_date' => now()->subDay(),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Bob Student',
            'email' => 'bob@roadmap.camp',
            'password' => Hash::make('password'),
            'role' => 'student',
            'current_streak' => 0,
            'longest_streak' => 7,
            'last_activity_date' => now()->subDays(3),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Charlie Student',
            'email' => 'charlie@roadmap.camp',
            'password' => Hash::make('password'),
            'role' => 'student',
            'current_streak' => 15,
            'longest_streak' => 15,
            'last_activity_date' => now(),
            'email_verified_at' => now(),
        ]);
    }
}
