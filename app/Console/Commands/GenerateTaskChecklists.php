<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\TaskChecklist;
use Illuminate\Console\Command;

class GenerateTaskChecklists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:generate-checklists
                            {--task= : Generate checklist for specific task ID}
                            {--roadmap= : Generate checklists for specific roadmap ID}
                            {--force : Overwrite existing checklists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate quick-start checklists for tasks with AI-powered suggestions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Generating Task Checklists...');
        $this->newLine();

        // Get tasks to process
        $query = Task::query();

        if ($taskId = $this->option('task')) {
            $query->where('id', $taskId);
        } elseif ($roadmapId = $this->option('roadmap')) {
            $query->where('roadmap_id', $roadmapId);
        }

        $tasks = $query->get();

        if ($tasks->isEmpty()) {
            $this->error('No tasks found');
            return 1;
        }

        $this->info("Found {$tasks->count()} tasks to process");
        $this->newLine();

        $generated = 0;
        $skipped = 0;
        $updated = 0;

        $progressBar = $this->output->createProgressBar($tasks->count());
        $progressBar->start();

        foreach ($tasks as $task) {
            // Check if checklist already exists
            $existingChecklist = TaskChecklist::where('task_id', $task->id)
                ->where('is_active', true)
                ->first();

            if ($existingChecklist && !$this->option('force')) {
                $skipped++;
                $progressBar->advance();
                continue;
            }

            // Generate checklist items based on task type and content
            $items = $this->generateChecklistItems($task);

            if ($existingChecklist && $this->option('force')) {
                // Update existing
                $existingChecklist->update([
                    'items' => $items,
                    'description' => 'Follow these steps to complete this task successfully',
                ]);
                $updated++;
            } else {
                // Create new
                TaskChecklist::create([
                    'task_id' => $task->id,
                    'items' => $items,
                    'description' => 'Follow these steps to complete this task successfully',
                    'is_active' => true,
                ]);
                $generated++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Summary
        $this->info('═══════════════════════════════════════════════════════════');
        $this->info('                    GENERATION SUMMARY                     ');
        $this->info('═══════════════════════════════════════════════════════════');
        $this->newLine();
        $this->line("  Generated: {$generated}");
        $this->line("  Updated: {$updated}");
        $this->line("  Skipped: {$skipped}");
        $this->line("  Total Processed: {$tasks->count()}");
        $this->info('═══════════════════════════════════════════════════════════');

        return 0;
    }

    /**
     * Generate checklist items based on task properties
     */
    private function generateChecklistItems(Task $task): array
    {
        $items = [];

        // Start with reading resources
        if ($task->resources_links && is_array($task->resources_links) && count($task->resources_links) > 0) {
            $resourceCount = count($task->resources_links);

            if ($resourceCount === 1) {
                $items[] = 'Read the provided resource carefully';
            } else {
                $items[] = "Review all {$resourceCount} learning resources";
            }
        }

        // Add task-type specific items
        switch ($task->task_type) {
            case 'reading':
                $items[] = 'Take notes on key concepts while reading';
                $items[] = 'Highlight or bookmark important sections';
                if ($task->estimated_time_minutes && $task->estimated_time_minutes > 30) {
                    $items[] = 'Take a 5-minute break if needed';
                }
                $items[] = 'Write a brief summary of what you learned';
                break;

            case 'video':
                $items[] = 'Watch the video without distractions';
                $items[] = 'Take notes on key points';
                if ($task->estimated_time_minutes && $task->estimated_time_minutes > 20) {
                    $items[] = 'Rewatch any confusing parts';
                }
                $items[] = 'Summarize the main takeaways';
                break;

            case 'coding':
                $items[] = 'Set up your development environment';
                $items[] = 'Follow along with code examples';
                $items[] = 'Write the code yourself (don\'t just copy)';
                $items[] = 'Test your code to ensure it works';
                if ($task->has_code_submission) {
                    $items[] = 'Submit your code using the submit button';
                }
                $items[] = 'Experiment with variations';
                break;

            case 'exercise':
            case 'practice':
                $items[] = 'Understand the exercise requirements';
                $items[] = 'Plan your approach before starting';
                $items[] = 'Complete the exercise step by step';
                $items[] = 'Test your solution thoroughly';
                $items[] = 'Review and refactor your work';
                break;

            case 'project':
                $items[] = 'Break down the project into smaller tasks';
                $items[] = 'Create a plan or outline';
                $items[] = 'Work on one feature at a time';
                $items[] = 'Test as you build';
                if ($task->has_code_submission) {
                    $items[] = 'Submit your project code';
                }
                $items[] = 'Document your work';
                break;

            case 'quiz':
            case 'assessment':
                $items[] = 'Review all related materials first';
                $items[] = 'Read each question carefully';
                $items[] = 'Answer what you know first';
                $items[] = 'Review your answers before submitting';
                break;

            default:
                $items[] = 'Review all provided materials';
                $items[] = 'Complete the task requirements';
                $items[] = 'Verify your work';
        }

        // Add reflection step
        if (!in_array($task->task_type, ['quiz', 'assessment'])) {
            $items[] = 'Reflect on what you learned and add notes';
        }

        // Add quality rating reminder if applicable
        if ($task->has_quality_rating) {
            $items[] = 'Rate the quality of this task (1-10)';
        }

        // Make sure we have at least 3 items
        if (count($items) < 3) {
            $items[] = 'Complete all task requirements';
            $items[] = 'Review your work';
            $items[] = 'Mark the task as complete';
        }

        return array_values(array_unique($items));
    }
}
