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
            CompanySeeder::class,
            AchievementSeeder::class,

            // Roadmap 1: Translation (Start here for Arabic speakers)
            TechnicalTermsTranslationSeeder::class,     // Phase 1 - 14 tasks (English↔Arabic terms)

            // Core Foundation (Phase 2)
            FoundationRoadmapSeeder::class,             // Phase 2 - 16 tasks

            // Frontend Track (Phases 3-5)
            FrontendBasicsRoadmapSeeder::class,         // Phase 3 - 14 tasks
            FrontendIntermediateRoadmapSeeder::class,   // Phase 4 - 13 tasks
            FrontendProjectsSeeder::class,              // Phase 5 - 10 tasks (Apply frontend skills)

            // Backend Track (Phases 6-8)
            BackendBasicsRoadmapSeeder::class,          // Phase 6 - 8 tasks
            BackendIntermediateRoadmapSeeder::class,    // Phase 7 - 5 tasks
            BackendProjectsSeeder::class,               // Phase 8 - 10 tasks (Apply backend skills)

            // Full Stack Integration (Phase 9)
            FullStackProjectSeeder::class,              // Phase 9 - 15 tasks (Complete capstone)

            // Advanced Skills (Phases 10-12)
            DevOpsBasicsRoadmapSeeder::class,           // Phase 10 - 6 tasks
            MidLevelSkillsRoadmapSeeder::class,         // Phase 11 - 13 tasks
            ProfessionalSkillsRoadmapSeeder::class,     // Phase 12 - 2 tasks

            // Algorithms & Data Structures (Phase 13)
            AlgorithmsDataStructuresRoadmapSeeder::class, // Phase 13 - 30 tasks (Master DSA)

            // Career & Interview Preparation (End)
            CareerSkillsSeeder::class,                  // Phase 14 - 14 tasks (CV & Interview skills)
        ]);
    }
}
