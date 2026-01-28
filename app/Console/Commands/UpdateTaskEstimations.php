<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;

class UpdateTaskEstimations extends Command
{
    protected $signature = 'tasks:update-estimations
                          {--task-id= : Update a specific task}
                          {--roadmap-id= : Update tasks for a specific roadmap}
                          {--dry-run : Show what would be updated without making changes}
                          {--buffer=20 : Extra percentage to add for reading/practice time (default 20%)}';

    protected $description = 'Update task estimated_time_minutes based on actual resource durations';

    public function handle(): int
    {
        $this->info('Updating Task Time Estimations');
        $this->newLine();

        $query = Task::whereNotNull('resources');

        if ($taskId = $this->option('task-id')) {
            $query->where('id', $taskId);
        }

        if ($roadmapId = $this->option('roadmap-id')) {
            $query->where('roadmap_id', $roadmapId);
        }

        $tasks = $query->get();

        if ($tasks->isEmpty()) {
            $this->warn('No tasks found with resources.');
            return 0;
        }

        $isDryRun = $this->option('dry-run');
        $bufferPercent = (int) $this->option('buffer');

        if ($isDryRun) {
            $this->warn('Running in dry-run mode - no changes will be made');
            $this->newLine();
        }

        $this->info("Processing {$tasks->count()} tasks with {$bufferPercent}% buffer for reading/practice time...");
        $this->newLine();

        $updated = 0;
        $results = [];

        foreach ($tasks as $task) {
            $resources = $task->resources;

            if (!is_array($resources) || empty($resources)) {
                continue;
            }

            $totalSeconds = 0;
            $videoCount = 0;
            $articleCount = 0;
            $bookCount = 0;
            $interactiveCount = 0;

            foreach ($resources as $resource) {
                $type = $resource['type'] ?? 'unknown';

                // Add duration from videos/playlists
                if (!empty($resource['duration_seconds'])) {
                    $totalSeconds += (int) $resource['duration_seconds'];
                    $videoCount++;
                } elseif ($type === 'article') {
                    // Estimate 10 minutes per article
                    $totalSeconds += 10 * 60;
                    $articleCount++;
                } elseif ($type === 'book') {
                    // Estimate 30 minutes per book chapter
                    $totalSeconds += 30 * 60;
                    $bookCount++;
                } elseif ($type === 'interactive') {
                    // Estimate 20 minutes per interactive resource
                    $totalSeconds += 20 * 60;
                    $interactiveCount++;
                }
            }

            if ($totalSeconds === 0) {
                continue;
            }

            // Convert to minutes
            $totalMinutes = ceil($totalSeconds / 60);

            // Add buffer for note-taking, practice, and comprehension
            $bufferMinutes = ceil($totalMinutes * ($bufferPercent / 100));
            $estimatedMinutes = $totalMinutes + $bufferMinutes;

            // Round to nearest 5 minutes for cleaner display
            $estimatedMinutes = ceil($estimatedMinutes / 5) * 5;

            // Minimum 15 minutes, no maximum - reflect actual content duration
            $estimatedMinutes = max(15, $estimatedMinutes);

            $oldEstimate = $task->estimated_time_minutes;

            $results[] = [
                'id' => $task->id,
                'title' => \Illuminate\Support\Str::limit($task->title, 40),
                'videos' => $videoCount,
                'articles' => $articleCount,
                'books' => $bookCount,
                'old' => $oldEstimate . ' min',
                'new' => $estimatedMinutes . ' min',
                'change' => ($estimatedMinutes - $oldEstimate) . ' min',
            ];

            if (!$isDryRun) {
                $task->update(['estimated_time_minutes' => $estimatedMinutes]);
            }

            $updated++;
        }

        // Display results table
        $this->table(
            ['ID', 'Task', 'Videos', 'Articles', 'Books', 'Old Est.', 'New Est.', 'Change'],
            $results
        );

        $this->newLine();
        $this->info("Tasks processed: {$updated}");

        if ($isDryRun) {
            $this->newLine();
            $this->warn('This was a dry run. Run without --dry-run to apply changes.');
        } else {
            $this->info('Task estimations updated successfully!');
        }

        return 0;
    }
}
