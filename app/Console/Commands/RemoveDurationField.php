<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveDurationField extends Command
{
    protected $signature = 'tasks:remove-duration-field';
    protected $description = 'Remove the duration field from capped videos to avoid confusion';

    public function handle()
    {
        $this->info('Removing duration field from capped videos...');
        $this->newLine();

        $tasks = DB::table('tasks')->get();
        $updatedCount = 0;

        foreach ($tasks as $task) {
            $resources = json_decode($task->resources, true);

            if (!is_array($resources)) continue;

            $modified = false;
            $newResources = [];

            foreach ($resources as $resource) {
                // If video has duration_seconds and it's capped at 120 min (7200 sec)
                if ($resource['type'] === 'video' &&
                    isset($resource['duration_seconds']) &&
                    $resource['duration_seconds'] == 7200 &&
                    isset($resource['duration'])) {

                    // Remove the duration field to avoid showing wrong duration
                    unset($resource['duration']);
                    $modified = true;
                }

                $newResources[] = $resource;
            }

            if ($modified) {
                DB::table('tasks')->where('id', $task->id)->update([
                    'resources' => json_encode($newResources)
                ]);

                $this->line("<fg=green>✓</> Task {$task->id}: {$task->title}");
                $updatedCount++;
            }
        }

        $this->newLine();
        $this->info("Successfully updated {$updatedCount} tasks!");

        return Command::SUCCESS;
    }
}
