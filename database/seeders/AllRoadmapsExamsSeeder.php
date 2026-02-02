<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AllRoadmapsExamsSeeder extends Seeder
{
    /**
     * Run all roadmap exam seeders
     */
    public function run(): void
    {
        $this->command->info("🚀 Seeding exams for all roadmaps...");
        $this->command->newLine();

        // Frontend Basics
        $this->call(FrontendBasicsExamsSeeder::class);
        $this->command->newLine();

        // Backend Basics
        $this->call(BackendBasicsExamsSeeder::class);
        $this->command->newLine();

        // Backend Intermediate
        $this->call(ComprehensiveBackendExamsSeeder::class);
        $this->command->newLine();

        // Algorithms & Data Structures
        $this->call(AlgorithmsExamsSeeder::class);
        $this->command->newLine();

        $this->command->info("🎉 All roadmap exams seeded successfully!");
    }
}
