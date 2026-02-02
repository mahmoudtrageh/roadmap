<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class RefreshRoadmaps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roadmaps:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh roadmaps and tasks data while preserving student enrollments and progress';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting roadmaps refresh...');
        $this->newLine();

        // Run pending migrations first
        $this->info('📦 Running pending migrations...');
        Artisan::call('migrate');
        $this->info(Artisan::output());

        // Confirm before truncating
        if (!$this->confirm('This will refresh roadmaps/tasks content but preserve student progress. Continue?', true)) {
            $this->warn('❌ Operation cancelled.');
            return 0;
        }

        $this->newLine();
        $this->info('💾 Backing up student progress data...');

        // Count existing enrollments and completions before refresh
        $enrollmentsCount = DB::table('roadmap_enrollments')->count();
        $completionsCount = DB::table('task_completions')->count();
        $submissionsCount = DB::table('code_submissions')->count();
        $studentResourcesCount = DB::table('student_resources')->count();
        $studentQuestionsCount = DB::table('student_questions')->count();

        $this->line("  📊 Found {$enrollmentsCount} enrollments, {$completionsCount} completions, {$submissionsCount} submissions");
        $this->line("  📊 Found {$studentResourcesCount} student resources, {$studentQuestionsCount} student questions");
        $this->newLine();

        $this->info('🗑️  Deleting old roadmaps and tasks content...');

        // Create temporary mapping of old task IDs to their roadmap and order
        $oldTaskMapping = DB::table('tasks')
            ->select('id', 'roadmap_id', 'order', 'title')
            ->get()
            ->keyBy('id')
            ->toArray();

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Only truncate roadmap/task structure tables, NOT student progress tables
        $tablesToTruncate = [
            // Task structure only (not student data)
            'task_hints',
            'task_examples',
            'task_checklists',
            'task_quizzes',
            'tasks',
            'roadmaps',
        ];

        foreach ($tablesToTruncate as $table) {
            try {
                DB::table($table)->truncate();
                $this->line("  ✓ Truncated: {$table}");
            } catch (\Exception $e) {
                $this->warn("  ⚠ Could not truncate {$table}: " . $e->getMessage());
            }
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->newLine();
        $this->info('✅ Student progress preserved:');
        $this->line("  → Enrollments: {$enrollmentsCount}");
        $this->line("  → Task Completions: {$completionsCount}");
        $this->line("  → Code Submissions: {$submissionsCount}");
        $this->line("  → Student Resources: Preserved");
        $this->line("  → Quiz Attempts: Preserved");
        $this->line("  → Notes & Questions: Preserved");

        $this->newLine();
        $this->info('🌱 Seeding roadmaps...');
        $this->newLine();

        // Seed all roadmap seeders
        $seeders = [
            'TechnicalTermsTranslationSeeder',
            'FoundationRoadmapSeeder',
            'FrontendBasicsRoadmapSeeder',
            'FrontendIntermediateRoadmapSeeder',
            'BackendBasicsRoadmapSeeder',
            'BackendIntermediateRoadmapSeeder',
            'AlgorithmsDataStructuresRoadmapSeeder',
            'DevOpsBasicsRoadmapSeeder',
            'SystemDesignRoadmapSeeder',
            'MidLevelSkillsRoadmapSeeder',
            'ProfessionalSkillsRoadmapSeeder',
            'CareerSkillsSeeder',
            'FrontendProjectsSeeder',
            'BackendProjectsSeeder',
            'FullStackProjectSeeder',
        ];

        foreach ($seeders as $seeder) {
            try {
                $this->line("  → Running: {$seeder}");
                Artisan::call('db:seed', ['--class' => $seeder]);
                $this->info("  ✓ Completed: {$seeder}");
            } catch (\Exception $e) {
                $this->error("  ✗ Failed: {$seeder}");
                $this->error("    Error: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info('🔄 Re-mapping student resources and questions to new task IDs...');

        // Create mapping of new task IDs based on roadmap and order
        $newTaskMapping = DB::table('tasks')
            ->select('id', 'roadmap_id', 'order', 'title')
            ->get()
            ->groupBy('roadmap_id')
            ->map(function ($tasks) {
                return $tasks->keyBy('order');
            })
            ->toArray();

        // Remap student resources
        $studentResources = DB::table('student_resources')->get();
        $remappedResources = 0;
        $failedResources = 0;

        foreach ($studentResources as $resource) {
            $oldTask = $oldTaskMapping[$resource->task_id] ?? null;

            if ($oldTask) {
                $roadmapId = $oldTask->roadmap_id;
                $order = $oldTask->order;

                // Find new task with same roadmap and order
                $newTask = $newTaskMapping[$roadmapId][$order] ?? null;

                if ($newTask) {
                    DB::table('student_resources')
                        ->where('id', $resource->id)
                        ->update(['task_id' => $newTask->id]);
                    $remappedResources++;
                } else {
                    $failedResources++;
                    $this->warn("  ⚠ Could not find new task for student resource {$resource->id}");
                }
            } else {
                $failedResources++;
            }
        }

        // Remap student questions
        $studentQuestions = DB::table('student_questions')->get();
        $remappedQuestions = 0;
        $failedQuestions = 0;

        foreach ($studentQuestions as $question) {
            $oldTask = $oldTaskMapping[$question->task_id] ?? null;

            if ($oldTask) {
                $roadmapId = $oldTask->roadmap_id;
                $order = $oldTask->order;

                // Find new task with same roadmap and order
                $newTask = $newTaskMapping[$roadmapId][$order] ?? null;

                if ($newTask) {
                    DB::table('student_questions')
                        ->where('id', $question->id)
                        ->update(['task_id' => $newTask->id]);
                    $remappedQuestions++;
                } else {
                    $failedQuestions++;
                    $this->warn("  ⚠ Could not find new task for student question {$question->id}");
                }
            } else {
                $failedQuestions++;
            }
        }

        $this->line("  ✓ Remapped {$remappedResources} student resources (Failed: {$failedResources})");
        $this->line("  ✓ Remapped {$remappedQuestions} student questions (Failed: {$failedQuestions})");

        $this->newLine();
        $this->info('✨ Roadmaps refresh completed successfully!');
        $this->newLine();

        // Display summary
        $roadmapsCount = DB::table('roadmaps')->count();
        $tasksCount = DB::table('tasks')->count();
        $finalEnrollmentsCount = DB::table('roadmap_enrollments')->count();
        $finalCompletionsCount = DB::table('task_completions')->count();
        $finalResourcesCount = DB::table('student_resources')->count();
        $finalQuestionsCount = DB::table('student_questions')->count();

        $this->table(
            ['Metric', 'Count'],
            [
                ['Roadmaps', $roadmapsCount],
                ['Tasks', $tasksCount],
                ['Student Enrollments', $finalEnrollmentsCount . ' (preserved)'],
                ['Task Completions', $finalCompletionsCount . ' (preserved)'],
                ['Student Resources', $finalResourcesCount . ' (preserved)'],
                ['Student Questions', $finalQuestionsCount . ' (preserved)'],
            ]
        );

        $this->newLine();
        $this->info('💡 Note: Student progress has been preserved. Enrollments still reference their roadmaps.');
        $this->info('   Students can continue from where they left off!');

        // Fetch YouTube durations
        $this->newLine();
        if ($this->confirm('Do you want to fetch YouTube video durations now?', true)) {
            $this->info('🎥 Fetching YouTube video durations...');
            $this->newLine();
            Artisan::call('youtube:fetch-durations');
            $this->info(Artisan::output());
        } else {
            $this->warn('⚠️  Skipped YouTube duration fetch. Run "php artisan youtube:fetch-durations" manually later.');
        }

        return 0;
    }
}
