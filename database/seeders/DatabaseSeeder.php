<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear existing data
        \App\Models\Task::query()->delete();
        \App\Models\Roadmap::query()->delete();

        $this->call([
            UserSeeder::class,
            ProgrammingFundamentalsSeeder::class,
            FullStackRoadmapSeeder::class,
            CompanySeeder::class,
            EnhancedTaskDataSeeder::class,
        ]);
    }
}
