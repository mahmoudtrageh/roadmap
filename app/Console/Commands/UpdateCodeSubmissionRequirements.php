<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateCodeSubmissionRequirements extends Command
{
    protected $signature = 'tasks:update-code-submission';
    protected $description = 'Update video tasks that involve coding to require code submission';

    public function handle()
    {
        $this->info('Updating code submission requirements for coding-related tasks...');
        $this->newLine();

        $codingKeywords = [
            'programming', 'javascript', 'js', 'php', 'laravel', 'react',
            'function', 'array', 'loop', 'dom', 'api', 'eloquent',
            'sass', 'scss', 'css', 'html', 'tailwind', 'blade',
            'migration', 'validation', 'routing', 'controller',
            'flexbox', 'grid', 'es6', 'async', 'fetch', 'module',
            'hook', 'state', 'component', 'oop', 'class', 'npm',
            'webpack', 'vite', 'command', 'terminal', 'sql', 'redux',
            'cache', 'queue', 'event', 'listener', 'test', 'tdd'
        ];

        $tasks = DB::table('tasks')
            ->join('roadmaps', 'tasks.roadmap_id', '=', 'roadmaps.id')
            ->where('tasks.task_type', 'video')
            ->where('tasks.has_code_submission', false)
            ->select('roadmaps.title as roadmap_title', 'tasks.id', 'tasks.title', 'tasks.category')
            ->orderBy('roadmaps.order')
            ->orderBy('tasks.day_number')
            ->get();

        $updatedCount = 0;
        $currentRoadmap = '';

        foreach ($tasks as $task) {
            $title = strtolower($task->title);
            $category = strtolower($task->category);

            $shouldHaveCode = false;
            foreach ($codingKeywords as $keyword) {
                if (strpos($title, $keyword) !== false || strpos($category, $keyword) !== false) {
                    $shouldHaveCode = true;
                    break;
                }
            }

            if ($shouldHaveCode) {
                if ($currentRoadmap !== $task->roadmap_title) {
                    $currentRoadmap = $task->roadmap_title;
                    $this->newLine();
                    $this->line("<fg=yellow>### {$task->roadmap_title} ###</>");
                }

                DB::table('tasks')->where('id', $task->id)->update(['has_code_submission' => true]);
                $this->line("<fg=green>  ✓</> Task {$task->id}: {$task->title}");
                $updatedCount++;
            }
        }

        $this->newLine();
        $this->info("Successfully updated {$updatedCount} tasks to require code submission.");

        return Command::SUCCESS;
    }
}
