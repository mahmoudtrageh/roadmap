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
        User::firstOrCreate(
            ['email' => 'admin@roadmap.camp'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create Instructor User
        User::firstOrCreate(
            ['email' => 'instructor@roadmap.camp'],
            [
                'name' => 'John Instructor',
                'password' => Hash::make('password'),
                'role' => 'instructor',
                'email_verified_at' => now(),
            ]
        );

        // Create Student Users
        User::firstOrCreate(
            ['email' => 'alice@roadmap.camp'],
            [
                'name' => 'Alice Student',
                'password' => Hash::make('password'),
                'role' => 'student',
                'learning_style' => 'visual',
                'current_streak' => 5,
                'longest_streak' => 12,
                'last_activity_date' => now()->subDay(),
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'bob@roadmap.camp'],
            [
                'name' => 'Bob Student',
                'password' => Hash::make('password'),
                'role' => 'student',
                'learning_style' => 'kinesthetic',
                'current_streak' => 0,
                'longest_streak' => 7,
                'last_activity_date' => now()->subDays(3),
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'charlie@roadmap.camp'],
            [
                'name' => 'Charlie Student',
                'password' => Hash::make('password'),
                'role' => 'student',
                'learning_style' => 'reading_writing',
                'current_streak' => 15,
                'longest_streak' => 15,
                'last_activity_date' => now(),
                'email_verified_at' => now(),
            ]
        );
    }
}
