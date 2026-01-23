<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateActualTaskTimes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:update-actual-times';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and update actual average completion times from student data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📊 Updating Actual Task Times...');
        $this->newLine();

        $tasks = \App\Models\Task::all();
        $updated = 0;

        $progressBar = $this->output->createProgressBar($tasks->count());
        $progressBar->start();

        foreach ($tasks as $task) {
            // Get all completed task completions with time spent
            $completions = \App\Models\TaskCompletion::where('task_id', $task->id)
                ->where('status', 'completed')
                ->whereNotNull('time_spent_minutes')
                ->where('time_spent_minutes', '>', 0)
                ->get();

            if ($completions->count() > 0) {
                $avgTime = round($completions->avg('time_spent_minutes'));
                $completionCount = $completions->count();

                $task->actual_avg_time_minutes = $avgTime;
                $task->completion_count = $completionCount;
                $task->save();

                $updated++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("✅ Updated {$updated} tasks with actual time data");

        return 0;
    }
}
