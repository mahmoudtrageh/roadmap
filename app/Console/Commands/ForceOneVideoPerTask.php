<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ForceOneVideoPerTask extends Command
{
    protected $signature = 'tasks:force-one-video';
    protected $description = 'Force only ONE video per task - remove all duplicate videos';

    public function handle()
    {
        $this->info('Forcing one video per task...');
        $this->newLine();

        // Priority ranking for video channels
        $priority = [
            'freeCodeCamp' => 100,
            'Traversy Media' => 90,
            'The Net Ninja' => 80,
            'Web Dev Simplified' => 75,
            'Academind' => 70,
            'Kevin Powell' => 65,
            'Programming with Mosh' => 60,
            'Laracasts' => 55,
        ];

        $tasks = DB::table('tasks')->orderBy('roadmap_id')->orderBy('day_number')->get();
        $updatedCount = 0;

        foreach ($tasks as $task) {
            $resources = json_decode($task->resources, true);

            if (!is_array($resources)) continue;

            $videoResources = array_filter($resources, fn($r) => $r['type'] === 'video');

            // Skip if already has 1 or 0 videos
            if (count($videoResources) <= 1) continue;

            // Select the BEST video
            $bestVideo = null;
            $highestScore = -1;

            foreach ($videoResources as $video) {
                $score = 0;

                // Check channel priority
                foreach ($priority as $channel => $points) {
                    if (stripos($video['title'], $channel) !== false) {
                        $score = $points;
                        break;
                    }
                }

                // Prefer videos between 30 min and 3 hours
                $duration = isset($video['duration_seconds']) ? $video['duration_seconds'] / 60 : 0;
                if ($duration >= 30 && $duration <= 180) {
                    $score += 10;
                }

                // Prefer "crash course" or "full course"
                if (stripos($video['title'], 'crash course') !== false ||
                    stripos($video['title'], 'full course') !== false) {
                    $score += 5;
                }

                if ($score > $highestScore) {
                    $highestScore = $score;
                    $bestVideo = $video;
                }
            }

            if (!$bestVideo) {
                $bestVideo = reset($videoResources);
            }

            // Cap duration at 120 minutes if needed
            $videoDuration = isset($bestVideo['duration_seconds'])
                ? round($bestVideo['duration_seconds'] / 60)
                : 0;

            if ($videoDuration > 120) {
                $bestVideo['duration_seconds'] = 120 * 60;
                if (stripos($bestVideo['title'], 'Watch first') === false) {
                    $bestVideo['title'] .= ' (Watch first 2 hours only)';
                }
            }

            // Keep only best video + all non-video resources
            $newResources = [$bestVideo];
            foreach ($resources as $resource) {
                if ($resource['type'] !== 'video') {
                    $newResources[] = $resource;
                }
            }

            // Update estimated time
            $duration = isset($bestVideo['duration_seconds']) ? round($bestVideo['duration_seconds'] / 60) : 60;
            $newEstimation = min(120, max(30, $duration));

            // Update task
            DB::table('tasks')->where('id', $task->id)->update([
                'resources' => json_encode($newResources),
                'estimated_time_minutes' => $newEstimation
            ]);

            $this->line("<fg=green>✓</> Task {$task->id}: {$task->title}");
            $this->line("  Videos: " . count($videoResources) . " → 1");
            $this->line("  Selected: {$bestVideo['title']}");
            $this->line("  Time: {$newEstimation} min");
            $this->newLine();

            $updatedCount++;
        }

        $this->newLine();
        $this->info("Successfully updated {$updatedCount} tasks!");

        return Command::SUCCESS;
    }
}
