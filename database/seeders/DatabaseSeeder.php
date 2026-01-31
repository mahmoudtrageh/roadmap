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

            // Roadmap 1: Translation (Start here for Arabic speakers)
            TechnicalTermsTranslationSeeder::class,     // Phase 1 - 14 tasks (English↔Arabic terms)

            // Core Foundation (Phase 2)
            FoundationRoadmapSeeder::class,             // Phase 2 - 16 tasks

            // Frontend Track (Phases 3-5)
            FrontendBasicsRoadmapSeeder::class,         // Phase 3 - 14 tasks
            FrontendIntermediateRoadmapSeeder::class,   // Phase 4 - 13 tasks
            FrontendProjectsSeeder::class,              // Phase 5 - 10 tasks (Apply frontend skills)

            // Backend Track
            BackendBasicsRoadmapSeeder::class,          // 6 - 8 tasks
            BackendIntermediateRoadmapSeeder::class,    // 7 - 5 tasks
            BackendProjectsSeeder::class,               // 8 - 10 tasks (Apply backend skills)

            // Advanced Skills
            DevOpsBasicsRoadmapSeeder::class,           // 10 - 6 tasks
            MidLevelSkillsRoadmapSeeder::class,         // 11 - 13 tasks
            ProfessionalSkillsRoadmapSeeder::class,     // 12 - 2 tasks

            // System Design & Capstone
            SystemDesignRoadmapSeeder::class,           // 13 - 20 tasks (System Design)
            FullStackProjectSeeder::class,              // 14 - 15 tasks (Complete capstone)

            // Algorithms & Data Structures
            AlgorithmsDataStructuresRoadmapSeeder::class, // 15 - 30 tasks (Master DSA)

            // Career & Interview Preparation (End)
            CareerSkillsSeeder::class,                  // 16 - 14 tasks (CV & Interview skills)
        ]);
    }
}
