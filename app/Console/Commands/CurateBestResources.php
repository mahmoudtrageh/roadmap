<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CurateBestResources extends Command
{
    protected $signature = 'tasks:curate-resources';
    protected $description = 'Curate best video resources - keep only 1 video per task (Option B approach)';

    public function handle()
    {
        $this->info('Curating best resources for all tasks...');
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

            if (count($videoResources) <= 1) continue;

            // Calculate total video time
            $totalMinutes = 0;
            foreach ($videoResources as $video) {
                if (isset($video['duration_seconds'])) {
                    $totalMinutes += $video['duration_seconds'] / 60;
                }
            }

            if ($totalMinutes <= 120) continue; // Already within limit

            // Select the BEST video
            $bestVideo = null;
            $highestScore = -1;

            foreach ($videoResources as $video) {
                $score = 0;
                $videoTitle = $video['title'] ?? $video['title_en'] ?? $video['title_ar'] ?? '';

                // Check channel priority
                foreach ($priority as $channel => $points) {
                    if (stripos($videoTitle, $channel) !== false) {
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
                if (stripos($videoTitle, 'crash course') !== false ||
                    stripos($videoTitle, 'full course') !== false) {
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

            // Keep only best video + all non-video resources
            $newResources = [$bestVideo];
            foreach ($resources as $resource) {
                if ($resource['type'] !== 'video') {
                    $newResources[] = $resource;
                }
            }

            // Update estimated time - cap at 120 minutes
            $videoDuration = isset($bestVideo['duration_seconds'])
                ? round($bestVideo['duration_seconds'] / 60)
                : $task->estimated_time_minutes;

            $newEstimation = min(120, max(30, $videoDuration));

            // If video exceeds 120 min, add note about watching specific portion
            if ($videoDuration > 120) {
                $hoursToWatch = 2; // 120 minutes = 2 hours
                if (isset($bestVideo['title'])) {
                    $bestVideo['title'] .= " (Watch first {$hoursToWatch} hours only)";
                } elseif (isset($bestVideo['title_en'])) {
                    $bestVideo['title_en'] .= " (Watch first {$hoursToWatch} hours only)";
                }
                $bestVideo['duration_seconds'] = 120 * 60; // Cap at 120 minutes
            }

            // Update task
            DB::table('tasks')->where('id', $task->id)->update([
                'resources' => json_encode($newResources),
                'estimated_time_minutes' => $newEstimation
            ]);

            $bestVideoDisplayTitle = $bestVideo['title'] ?? $bestVideo['title_en'] ?? $bestVideo['title_ar'] ?? 'Untitled';
            $this->line("<fg=green>✓</> Task {$task->id}: {$task->title}");
            $this->line("  Videos: " . count($videoResources) . " → 1 | Time: " . round($totalMinutes) . " min → {$newEstimation} min");
            $this->line("  Selected: {$bestVideoDisplayTitle}");
            $this->newLine();

            $updatedCount++;
        }

        $this->newLine();
        $this->info("Successfully curated {$updatedCount} tasks!");

        return Command::SUCCESS;
    }
}
