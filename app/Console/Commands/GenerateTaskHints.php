<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateTaskHints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:generate-hints
                            {--task= : Generate hints for specific task ID}
                            {--force : Overwrite existing hints}
                            {--limit=100 : Limit number of tasks to process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate progressive hints for difficult tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('💡 Generating Task Hints...');
        $this->newLine();

        $query = \App\Models\Task::query()
            ->where(function ($q) {
                $q->where('difficulty_level', 'intermediate')
                  ->orWhere('difficulty_level', 'advanced')
                  ->orWhereIn('task_type', ['coding', 'exercise', 'project']);
            });

        if ($taskId = $this->option('task')) {
            $query->where('id', $taskId);
        }

        $limit = (int) $this->option('limit');
        $tasks = $query->limit($limit)->get();

        if ($tasks->isEmpty()) {
            $this->error('No tasks found');
            return 1;
        }

        $this->info("Generating hints for {$tasks->count()} tasks");
        $this->newLine();

        $generated = 0;
        $skipped = 0;

        $progressBar = $this->output->createProgressBar($tasks->count());
        $progressBar->start();

        foreach ($tasks as $task) {
            $existing = \App\Models\TaskHint::where('task_id', $task->id)->exists();

            if ($existing && !$this->option('force')) {
                $skipped++;
                $progressBar->advance();
                continue;
            }

            if ($existing && $this->option('force')) {
                \App\Models\TaskHint::where('task_id', $task->id)->delete();
            }

            $hints = $this->generateHints($task);

            \App\Models\TaskHint::create([
                'task_id' => $task->id,
                'hints' => $hints,
                'introduction' => 'Stuck? Reveal hints one at a time to guide you through this task.',
                'is_active' => true,
            ]);

            $generated++;
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("✅ Generated: {$generated}");
        $this->info("⏭  Skipped: {$skipped}");

        return 0;
    }

    private function generateHints($task): array
    {
        $hints = [];
        $taskType = $task->task_type;
        $difficulty = $task->difficulty_level ?? 'beginner';

        // Determine number of hints based on difficulty
        $hintCount = match($difficulty) {
            'advanced' => 5,
            'intermediate' => 4,
            default => 3,
        };

        if ($taskType === 'coding' || $taskType === 'exercise' || $taskType === 'project') {
            $hints[] = [
                'level' => 1,
                'text' => 'Start by reading the task description carefully. Make sure you understand what is being asked before writing any code.',
            ];

            $hints[] = [
                'level' => 2,
                'text' => 'Break the problem down into smaller steps. What needs to happen first? What comes next?',
            ];

            $hints[] = [
                'level' => 3,
                'text' => 'Review the learning resources provided. Look for examples that are similar to what you need to do.',
            ];

            if ($hintCount >= 4) {
                $hints[] = [
                    'level' => 4,
                    'text' => 'Try writing pseudocode first. Describe the logic in plain language before converting it to actual code.',
                ];
            }

            if ($hintCount >= 5) {
                $hints[] = [
                    'level' => 5,
                    'text' => 'Test your code with simple inputs first. Once it works with basic cases, try more complex scenarios.',
                ];
            }
        } else {
            // For reading, video, or general tasks
            $hints[] = [
                'level' => 1,
                'text' => 'Take your time with the learning resources. Don\'t rush through the material.',
            ];

            $hints[] = [
                'level' => 2,
                'text' => 'Take notes as you go. Writing things down helps reinforce your understanding.',
            ];

            $hints[] = [
                'level' => 3,
                'text' => 'If something isn\'t clear, go back and review it. It\'s okay to read or watch content multiple times.',
            ];

            if ($hintCount >= 4) {
                $hints[] = [
                    'level' => 4,
                    'text' => 'Try to relate the concepts to something you already know. Making connections helps with retention.',
                ];
            }

            if ($hintCount >= 5) {
                $hints[] = [
                    'level' => 5,
                    'text' => 'After completing the task, summarize what you learned in your own words. This helps solidify your understanding.',
                ];
            }
        }

        return $hints;
    }
}
