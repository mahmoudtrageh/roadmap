<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CapVideoDurations extends Command
{
    protected $signature = 'tasks:cap-durations';
    protected $description = 'Cap video durations at 120 minutes and add watching instructions';

    public function handle()
    {
        $this->info('Capping video durations at 120 minutes...');
        $this->newLine();

        $tasks = DB::table('tasks')->orderBy('roadmap_id')->orderBy('day_number')->get();
        $updatedCount = 0;

        foreach ($tasks as $task) {
            $resources = json_decode($task->resources, true);

            if (!is_array($resources)) continue;

            $modified = false;
            $newResources = [];

            foreach ($resources as $resource) {
                if ($resource['type'] === 'video' && isset($resource['duration_seconds'])) {
                    $durationMinutes = $resource['duration_seconds'] / 60;

                    if ($durationMinutes > 120) {
                        // Cap the duration
                        $resource['duration_seconds'] = 120 * 60;

                        // Add instruction if not already there
                        $resourceTitle = $resource['title'] ?? $resource['title_en'] ?? $resource['title_ar'] ?? '';
                        if (stripos($resourceTitle, 'Watch first') === false) {
                            if (isset($resource['title'])) {
                                $resource['title'] .= ' (Watch first 2 hours only)';
                            } elseif (isset($resource['title_en'])) {
                                $resource['title_en'] .= ' (Watch first 2 hours only)';
                            }
                        }

                        $modified = true;
                    }
                }

                $newResources[] = $resource;
            }

            if ($modified) {
                // Calculate new estimation based on capped videos
                $totalMinutes = 0;
                foreach ($newResources as $resource) {
                    if ($resource['type'] === 'video' && isset($resource['duration_seconds'])) {
                        $totalMinutes += $resource['duration_seconds'] / 60;
                    }
                }

                $newEstimation = min(120, max(30, round($totalMinutes)));

                // Update task
                DB::table('tasks')->where('id', $task->id)->update([
                    'resources' => json_encode($newResources),
                    'estimated_time_minutes' => $newEstimation
                ]);

                $this->line("<fg=green>✓</> Task {$task->id}: {$task->title}");
                $this->line("  Capped to {$newEstimation} minutes");
                $this->newLine();

                $updatedCount++;
            }
        }

        $this->newLine();
        $this->info("Successfully capped {$updatedCount} tasks!");

        return Command::SUCCESS;
    }
}
