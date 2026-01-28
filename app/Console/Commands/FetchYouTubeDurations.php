<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Services\YouTubeService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchYouTubeDurations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:fetch-durations
                          {--task-id= : Fetch for a specific task ID}
                          {--roadmap-id= : Fetch for a specific roadmap}
                          {--dry-run : Show what would be updated without making changes}
                          {--force : Force refresh even if duration already exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and update video durations for all YouTube resources in tasks';

    /**
     * Statistics for the command output.
     */
    protected array $stats = [
        'tasks_processed' => 0,
        'videos_found' => 0,
        'videos_updated' => 0,
        'videos_skipped' => 0,
        'videos_failed' => 0,
        'playlists_found' => 0,
        'playlists_updated' => 0,
        'errors' => [],
    ];

    /**
     * Execute the console command.
     */
    public function handle(YouTubeService $youtubeService): int
    {
        $this->info('YouTube Duration Fetcher');
        $this->newLine();

        // Check if API is configured
        if (!$youtubeService->isConfigured()) {
            $this->error('YouTube API key is not configured.');
            $this->line('Please set YOUTUBE_API_KEY in your .env file.');
            $this->newLine();
            $this->line('To get an API key:');
            $this->line('1. Go to https://console.cloud.google.com/');
            $this->line('2. Create a new project or select an existing one');
            $this->line('3. Enable the YouTube Data API v3');
            $this->line('4. Go to APIs & Services > Credentials');
            $this->line('5. Create an API key');
            $this->line('6. Add YOUTUBE_API_KEY=your_key_here to your .env file');
            return 1;
        }

        // Get tasks to process
        $query = Task::whereNotNull('resources');

        if ($taskId = $this->option('task-id')) {
            $query->where('id', $taskId);
        }

        if ($roadmapId = $this->option('roadmap-id')) {
            $query->where('roadmap_id', $roadmapId);
        }

        $tasks = $query->with('roadmap')->get();

        if ($tasks->isEmpty()) {
            $this->warn('No tasks found with resources.');
            return 0;
        }

        $this->info("Found {$tasks->count()} tasks to process");

        if ($this->option('dry-run')) {
            $this->warn('Running in dry-run mode - no changes will be made');
        }

        $this->newLine();

        // Collect all YouTube video IDs first for batch processing
        $videoMap = $this->collectYouTubeVideos($tasks, $youtubeService);

        if (empty($videoMap)) {
            $this->info('No YouTube videos found in task resources.');
            return 0;
        }

        $this->info("Found {$this->stats['videos_found']} YouTube videos across {$this->stats['tasks_processed']} tasks");
        $this->newLine();

        // Fetch video details in batches
        $videoIds = array_keys($videoMap);
        $this->info('Fetching video details from YouTube API...');

        $progressBar = $this->output->createProgressBar(count($videoIds));
        $progressBar->start();

        $videoDetails = $youtubeService->getMultipleVideoDetails($videoIds);

        $progressBar->finish();
        $this->newLine(2);

        // Update tasks with fetched durations
        $this->updateTaskResources($tasks, $videoDetails, $youtubeService);

        // Display results
        $this->displayResults();

        return $this->stats['videos_failed'] > 0 ? 1 : 0;
    }

    /**
     * Collect all YouTube videos from tasks.
     */
    protected function collectYouTubeVideos($tasks, YouTubeService $youtubeService): array
    {
        $videoMap = [];

        foreach ($tasks as $task) {
            if (empty($task->resources) || !is_array($task->resources)) {
                continue;
            }

            $hasVideos = false;

            foreach ($task->resources as $index => $resource) {
                if (!isset($resource['url'])) {
                    continue;
                }

                if (!$youtubeService->isYouTubeUrl($resource['url'])) {
                    continue;
                }

                // Check if it's a playlist first
                if ($youtubeService->isPlaylistUrl($resource['url'])) {
                    $this->stats['playlists_found']++;
                    // Playlists are handled separately in updateTaskResources
                    continue;
                }

                $videoId = $youtubeService->extractVideoId($resource['url']);

                if (!$videoId) {
                    $this->stats['errors'][] = [
                        'task_id' => $task->id,
                        'url' => $resource['url'],
                        'error' => 'Could not extract video ID (not a video or playlist)',
                    ];
                    continue;
                }

                // Skip if already has duration and not forcing
                if (!$this->option('force') && !empty($resource['duration'])) {
                    $this->stats['videos_skipped']++;
                    continue;
                }

                $hasVideos = true;
                $this->stats['videos_found']++;

                if (!isset($videoMap[$videoId])) {
                    $videoMap[$videoId] = [];
                }

                $videoMap[$videoId][] = [
                    'task_id' => $task->id,
                    'resource_index' => $index,
                ];
            }

            if ($hasVideos) {
                $this->stats['tasks_processed']++;
            }
        }

        return $videoMap;
    }

    /**
     * Update task resources with fetched video details.
     */
    protected function updateTaskResources($tasks, array $videoDetails, YouTubeService $youtubeService): void
    {
        $isDryRun = $this->option('dry-run');
        $force = $this->option('force');

        foreach ($tasks as $task) {
            if (empty($task->resources) || !is_array($task->resources)) {
                continue;
            }

            $resources = $task->resources;
            $hasChanges = false;

            foreach ($resources as $index => &$resource) {
                if (!isset($resource['url'])) {
                    continue;
                }

                if (!$youtubeService->isYouTubeUrl($resource['url'])) {
                    continue;
                }

                // Skip if already has duration and not forcing
                if (!$force && !empty($resource['duration'])) {
                    continue;
                }

                // Handle playlists separately
                if ($youtubeService->isPlaylistUrl($resource['url'])) {
                    $playlistId = $youtubeService->extractPlaylistId($resource['url']);
                    if ($playlistId) {
                        $playlistDetails = $youtubeService->getPlaylistDetails($playlistId);
                        if ($playlistDetails) {
                            $resource['duration'] = $playlistDetails['duration_formatted'];
                            $resource['duration_seconds'] = $playlistDetails['duration_seconds'];
                            $resource['video_count'] = $playlistDetails['video_count'];
                            $resource['is_playlist'] = true;

                            $hasChanges = true;
                            $this->stats['playlists_updated']++;

                            if ($isDryRun) {
                                $this->line("  [DRY-RUN] Task {$task->id}: Would update playlist \"{$resource['title']}\" - {$playlistDetails['video_count']} videos, {$playlistDetails['duration_formatted']}");
                            } else {
                                $this->line("  Task {$task->id}: Updated playlist \"{$resource['title']}\" - {$playlistDetails['video_count']} videos, {$playlistDetails['duration_formatted']}");
                            }
                        } else {
                            $this->stats['errors'][] = [
                                'task_id' => $task->id,
                                'url' => $resource['url'],
                                'error' => 'Could not fetch playlist details',
                            ];
                        }
                    }
                    continue;
                }

                // Handle individual videos
                $videoId = $youtubeService->extractVideoId($resource['url']);

                if (!$videoId) {
                    continue;
                }

                if (!isset($videoDetails[$videoId])) {
                    $this->stats['videos_failed']++;
                    $this->stats['errors'][] = [
                        'task_id' => $task->id,
                        'url' => $resource['url'],
                        'error' => 'Video not found or API error',
                    ];
                    continue;
                }

                $details = $videoDetails[$videoId];

                // Update the resource with duration
                $resource['duration'] = $details['duration_formatted'];
                $resource['duration_seconds'] = $details['duration_seconds'];

                $hasChanges = true;
                $this->stats['videos_updated']++;

                if ($isDryRun) {
                    $this->line("  [DRY-RUN] Task {$task->id}: Would update \"{$resource['title']}\" with duration: {$details['duration_formatted']}");
                } else {
                    $this->line("  Task {$task->id}: Updated \"{$resource['title']}\" - Duration: {$details['duration_formatted']}");
                }
            }

            if ($hasChanges && !$isDryRun) {
                $task->update(['resources' => $resources]);
                Log::info('Updated YouTube durations for task', [
                    'task_id' => $task->id,
                    'title' => $task->title,
                ]);
            }
        }
    }

    /**
     * Display command results.
     */
    protected function displayResults(): void
    {
        $this->newLine();
        $this->info('Results:');

        $this->table(
            ['Metric', 'Count'],
            [
                ['Tasks Processed', $this->stats['tasks_processed']],
                ['YouTube Videos Found', $this->stats['videos_found']],
                ['Videos Updated', $this->stats['videos_updated']],
                ['Playlists Found', $this->stats['playlists_found']],
                ['Playlists Updated', $this->stats['playlists_updated']],
                ['Videos Skipped (already had duration)', $this->stats['videos_skipped']],
                ['Videos Failed', $this->stats['videos_failed']],
            ]
        );

        if (!empty($this->stats['errors'])) {
            $this->newLine();
            $this->error('Errors encountered: ' . count($this->stats['errors']));

            $this->table(
                ['Task ID', 'URL', 'Error'],
                array_map(function ($error) {
                    return [
                        $error['task_id'],
                        \Illuminate\Support\Str::limit($error['url'], 50),
                        $error['error'],
                    ];
                }, array_slice($this->stats['errors'], 0, 10))
            );

            if (count($this->stats['errors']) > 10) {
                $this->warn('... and ' . (count($this->stats['errors']) - 10) . ' more errors');
            }
        }

        if ($this->option('dry-run')) {
            $this->newLine();
            $this->warn('This was a dry run. Run without --dry-run to apply changes.');
        }
    }
}
