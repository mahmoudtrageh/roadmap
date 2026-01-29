<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ForceOneVideoPerTask extends Command
{
    protected $signature = 'tasks:force-one-video';
    protected $description = 'Force only ONE video per language per task (1 English + 1 Arabic maximum)';

    public function handle()
    {
        $this->info('Forcing one video per language per task...');
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

            // Separate resources by language
            $englishVideos = [];
            $arabicVideos = [];
            $nonVideoResources = [];

            foreach ($resources as $resource) {
                if ($resource['type'] !== 'video') {
                    $nonVideoResources[] = $resource;
                    continue;
                }

                $lang = $resource['language'] ?? 'en';
                if ($lang === 'ar') {
                    $arabicVideos[] = $resource;
                } else {
                    $englishVideos[] = $resource;
                }
            }

            // Skip if already has 1 or 0 videos per language
            if (count($englishVideos) <= 1 && count($arabicVideos) <= 1) continue;

            $newResources = $nonVideoResources;
            $hasChanges = false;

            // Select best English video if multiple exist
            if (count($englishVideos) > 1) {
                $bestEnglishVideo = $this->selectBestVideo($englishVideos, $priority);
                $bestEnglishVideo = $this->capDuration($bestEnglishVideo);
                $newResources[] = $bestEnglishVideo;
                $hasChanges = true;

                $bestVideoTitle = $bestEnglishVideo['title'] ?? $bestEnglishVideo['title_en'] ?? $bestEnglishVideo['title_ar'] ?? 'Untitled';
                $this->line("<fg=blue>EN Video:</> {$bestVideoTitle}");
            } elseif (count($englishVideos) === 1) {
                $newResources[] = $englishVideos[0];
            }

            // Select best Arabic video if multiple exist
            if (count($arabicVideos) > 1) {
                $bestArabicVideo = $this->selectBestVideo($arabicVideos, $priority);
                $bestArabicVideo = $this->capDuration($bestArabicVideo);
                $newResources[] = $bestArabicVideo;
                $hasChanges = true;

                $bestVideoTitle = $bestArabicVideo['title_ar'] ?? $bestArabicVideo['title_en'] ?? $bestArabicVideo['title'] ?? 'عنوان غير محدد';
                $this->line("<fg=green>AR Video:</> {$bestVideoTitle}");
            } elseif (count($arabicVideos) === 1) {
                $newResources[] = $arabicVideos[0];
            }

            if (!$hasChanges) continue;

            // Update estimated time based on English video (primary)
            $primaryVideo = null;
            foreach ($newResources as $resource) {
                if ($resource['type'] === 'video' && ($resource['language'] ?? 'en') === 'en') {
                    $primaryVideo = $resource;
                    break;
                }
            }

            if (!$primaryVideo) {
                // If no English video, use Arabic video
                foreach ($newResources as $resource) {
                    if ($resource['type'] === 'video' && ($resource['language'] ?? 'en') === 'ar') {
                        $primaryVideo = $resource;
                        break;
                    }
                }
            }

            $duration = $primaryVideo && isset($primaryVideo['duration_seconds'])
                ? round($primaryVideo['duration_seconds'] / 60)
                : 60;
            $newEstimation = min(120, max(30, $duration));

            // Update task
            DB::table('tasks')->where('id', $task->id)->update([
                'resources' => json_encode($newResources),
                'estimated_time_minutes' => $newEstimation
            ]);

            $this->line("<fg=green>✓</> Task {$task->id}: {$task->title}");
            $this->line("  Videos: EN(" . count($englishVideos) . "→" . (count($englishVideos) > 0 ? 1 : 0) . ") + AR(" . count($arabicVideos) . "→" . (count($arabicVideos) > 0 ? 1 : 0) . ")");
            $this->line("  Time: {$newEstimation} min");
            $this->newLine();

            $updatedCount++;
        }

        $this->newLine();
        $this->info("Successfully updated {$updatedCount} tasks!");
        $this->info("Each task now has maximum 1 English video + 1 Arabic video");

        return Command::SUCCESS;
    }

    private function selectBestVideo(array $videos, array $priority): array
    {
        $bestVideo = null;
        $highestScore = -1;

        foreach ($videos as $video) {
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

        return $bestVideo ?? reset($videos);
    }

    private function capDuration(array $video): array
    {
        $videoDuration = isset($video['duration_seconds'])
            ? round($video['duration_seconds'] / 60)
            : 0;

        if ($videoDuration > 120) {
            $video['duration_seconds'] = 120 * 60;
            $videoTitle = $video['title'] ?? $video['title_en'] ?? $video['title_ar'] ?? '';

            if (stripos($videoTitle, 'Watch first') === false) {
                if (isset($video['title'])) {
                    $video['title'] .= ' (Watch first 2 hours only)';
                } elseif (isset($video['title_en'])) {
                    $video['title_en'] .= ' (Watch first 2 hours only)';
                }
            }
        }

        return $video;
    }
}
