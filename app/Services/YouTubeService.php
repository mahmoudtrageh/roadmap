<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class YouTubeService
{
    /**
     * YouTube Data API v3 base URL.
     */
    protected const API_BASE_URL = 'https://www.googleapis.com/youtube/v3';

    /**
     * API key for YouTube Data API.
     */
    protected ?string $apiKey;

    /**
     * Create a new YouTubeService instance.
     */
    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key');
    }

    /**
     * Check if the service is properly configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * Extract video ID from various YouTube URL formats.
     *
     * Supported formats:
     * - https://www.youtube.com/watch?v=VIDEO_ID
     * - https://youtube.com/watch?v=VIDEO_ID
     * - https://youtu.be/VIDEO_ID
     * - https://www.youtube.com/embed/VIDEO_ID
     * - https://www.youtube.com/v/VIDEO_ID
     * - https://www.youtube.com/shorts/VIDEO_ID
     *
     * @param string $url The YouTube URL
     * @return string|null The video ID or null if not found
     */
    public function extractVideoId(string $url): ?string
    {
        // Clean the URL
        $url = trim($url);

        // Pattern for youtube.com/watch?v=
        if (preg_match('/[?&]v=([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            return $matches[1];
        }

        // Pattern for youtu.be/
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            return $matches[1];
        }

        // Pattern for youtube.com/embed/ or youtube.com/v/
        if (preg_match('/youtube\.com\/(?:embed|v)\/([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            return $matches[1];
        }

        // Pattern for youtube.com/shorts/
        if (preg_match('/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Check if a URL is a YouTube video URL.
     *
     * @param string $url The URL to check
     * @return bool True if it's a YouTube URL
     */
    public function isYouTubeUrl(string $url): bool
    {
        return (bool) preg_match('/(?:youtube\.com|youtu\.be)/', $url);
    }

    /**
     * Check if a URL is a YouTube playlist URL.
     *
     * @param string $url The URL to check
     * @return bool True if it's a playlist URL
     */
    public function isPlaylistUrl(string $url): bool
    {
        return (bool) preg_match('/[?&]list=/', $url);
    }

    /**
     * Extract playlist ID from YouTube URL.
     *
     * @param string $url The YouTube playlist URL
     * @return string|null The playlist ID or null if not found
     */
    public function extractPlaylistId(string $url): ?string
    {
        if (preg_match('/[?&]list=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    /**
     * Get playlist details including total duration.
     *
     * @param string $playlistId The YouTube playlist ID
     * @return array|null Playlist details or null on failure
     */
    public function getPlaylistDetails(string $playlistId): ?array
    {
        if (!$this->isConfigured()) {
            Log::warning('YouTubeService: API key not configured');
            return null;
        }

        $cacheKey = "youtube_playlist_{$playlistId}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            // First get playlist info
            $playlistResponse = Http::get(self::API_BASE_URL . '/playlists', [
                'part' => 'snippet,contentDetails',
                'id' => $playlistId,
                'key' => $this->apiKey,
            ]);

            if (!$playlistResponse->successful() || empty($playlistResponse->json()['items'])) {
                Log::warning('YouTubeService: Playlist not found', ['playlist_id' => $playlistId]);
                return null;
            }

            $playlistData = $playlistResponse->json()['items'][0];
            $videoCount = $playlistData['contentDetails']['itemCount'] ?? 0;

            // Get all video IDs from playlist (paginate through all)
            $videoIds = [];
            $nextPageToken = null;

            do {
                $params = [
                    'part' => 'contentDetails',
                    'playlistId' => $playlistId,
                    'maxResults' => 50,
                    'key' => $this->apiKey,
                ];

                if ($nextPageToken) {
                    $params['pageToken'] = $nextPageToken;
                }

                $itemsResponse = Http::get(self::API_BASE_URL . '/playlistItems', $params);

                if ($itemsResponse->successful()) {
                    $itemsData = $itemsResponse->json();
                    foreach ($itemsData['items'] ?? [] as $item) {
                        $videoIds[] = $item['contentDetails']['videoId'];
                    }
                    $nextPageToken = $itemsData['nextPageToken'] ?? null;
                } else {
                    break;
                }
            } while ($nextPageToken && count($videoIds) < 200); // Limit to 200 videos

            // Get durations for all videos
            $totalSeconds = 0;
            if (!empty($videoIds)) {
                $videoDetails = $this->getMultipleVideoDetails($videoIds);
                foreach ($videoDetails as $video) {
                    $totalSeconds += $video['duration_seconds'] ?? 0;
                }
            }

            $details = [
                'id' => $playlistId,
                'title' => $playlistData['snippet']['title'] ?? null,
                'description' => $playlistData['snippet']['description'] ?? null,
                'channel_title' => $playlistData['snippet']['channelTitle'] ?? null,
                'video_count' => $videoCount,
                'duration_seconds' => $totalSeconds,
                'duration_formatted' => $this->formatDuration($totalSeconds),
                'thumbnail' => $playlistData['snippet']['thumbnails']['medium']['url'] ?? null,
            ];

            // Cache for 24 hours
            Cache::put($cacheKey, $details, now()->addHours(24));

            return $details;

        } catch (\Exception $e) {
            Log::error('YouTubeService: Exception fetching playlist', [
                'playlist_id' => $playlistId,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Fetch video details from YouTube Data API.
     *
     * @param string $videoId The YouTube video ID
     * @return array|null Video details or null on failure
     */
    public function getVideoDetails(string $videoId): ?array
    {
        if (!$this->isConfigured()) {
            Log::warning('YouTubeService: API key not configured');
            return null;
        }

        // Check cache first (cache for 24 hours)
        $cacheKey = "youtube_video_{$videoId}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = Http::get(self::API_BASE_URL . '/videos', [
                'part' => 'contentDetails,snippet,statistics',
                'id' => $videoId,
                'key' => $this->apiKey,
            ]);

            if (!$response->successful()) {
                Log::error('YouTubeService: API request failed', [
                    'video_id' => $videoId,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }

            $data = $response->json();

            if (empty($data['items'])) {
                Log::warning('YouTubeService: Video not found', ['video_id' => $videoId]);
                return null;
            }

            $video = $data['items'][0];
            $details = [
                'id' => $videoId,
                'title' => $video['snippet']['title'] ?? null,
                'description' => $video['snippet']['description'] ?? null,
                'channel_title' => $video['snippet']['channelTitle'] ?? null,
                'published_at' => $video['snippet']['publishedAt'] ?? null,
                'duration_iso' => $video['contentDetails']['duration'] ?? null,
                'duration_formatted' => $this->parseIsoDuration($video['contentDetails']['duration'] ?? ''),
                'duration_seconds' => $this->isoDurationToSeconds($video['contentDetails']['duration'] ?? ''),
                'view_count' => (int) ($video['statistics']['viewCount'] ?? 0),
                'like_count' => (int) ($video['statistics']['likeCount'] ?? 0),
                'thumbnail' => $video['snippet']['thumbnails']['medium']['url'] ?? null,
            ];

            // Cache the result for 24 hours
            Cache::put($cacheKey, $details, now()->addHours(24));

            return $details;

        } catch (\Exception $e) {
            Log::error('YouTubeService: Exception occurred', [
                'video_id' => $videoId,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Fetch details for multiple videos in a single API call.
     *
     * @param array $videoIds Array of video IDs (max 50 per call)
     * @return array Associative array of video_id => details
     */
    public function getMultipleVideoDetails(array $videoIds): array
    {
        if (!$this->isConfigured()) {
            Log::warning('YouTubeService: API key not configured');
            return [];
        }

        $results = [];
        $uncachedIds = [];

        // Check cache for each video
        foreach ($videoIds as $videoId) {
            $cacheKey = "youtube_video_{$videoId}";
            if (Cache::has($cacheKey)) {
                $results[$videoId] = Cache::get($cacheKey);
            } else {
                $uncachedIds[] = $videoId;
            }
        }

        // If all videos were cached, return early
        if (empty($uncachedIds)) {
            return $results;
        }

        // YouTube API allows max 50 IDs per request
        $chunks = array_chunk($uncachedIds, 50);

        foreach ($chunks as $chunk) {
            try {
                $response = Http::get(self::API_BASE_URL . '/videos', [
                    'part' => 'contentDetails,snippet,statistics',
                    'id' => implode(',', $chunk),
                    'key' => $this->apiKey,
                ]);

                if (!$response->successful()) {
                    Log::error('YouTubeService: Batch API request failed', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]);
                    continue;
                }

                $data = $response->json();

                foreach ($data['items'] ?? [] as $video) {
                    $videoId = $video['id'];
                    $details = [
                        'id' => $videoId,
                        'title' => $video['snippet']['title'] ?? null,
                        'description' => $video['snippet']['description'] ?? null,
                        'channel_title' => $video['snippet']['channelTitle'] ?? null,
                        'published_at' => $video['snippet']['publishedAt'] ?? null,
                        'duration_iso' => $video['contentDetails']['duration'] ?? null,
                        'duration_formatted' => $this->parseIsoDuration($video['contentDetails']['duration'] ?? ''),
                        'duration_seconds' => $this->isoDurationToSeconds($video['contentDetails']['duration'] ?? ''),
                        'view_count' => (int) ($video['statistics']['viewCount'] ?? 0),
                        'like_count' => (int) ($video['statistics']['likeCount'] ?? 0),
                        'thumbnail' => $video['snippet']['thumbnails']['medium']['url'] ?? null,
                    ];

                    // Cache each result
                    Cache::put("youtube_video_{$videoId}", $details, now()->addHours(24));
                    $results[$videoId] = $details;
                }

            } catch (\Exception $e) {
                Log::error('YouTubeService: Exception in batch request', [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $results;
    }

    /**
     * Parse ISO 8601 duration format to human-readable string.
     *
     * Examples:
     * - PT1H2M3S -> "1h 2m"
     * - PT5M30S  -> "5m 30s"
     * - PT45S    -> "45s"
     * - PT1H     -> "1h"
     *
     * @param string $isoDuration The ISO 8601 duration string
     * @return string Human-readable duration
     */
    public function parseIsoDuration(string $isoDuration): string
    {
        if (empty($isoDuration)) {
            return '';
        }

        // Parse ISO 8601 duration: PT1H2M3S
        $pattern = '/PT(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?/';

        if (!preg_match($pattern, $isoDuration, $matches)) {
            return '';
        }

        $hours = isset($matches[1]) && $matches[1] !== '' ? (int) $matches[1] : 0;
        $minutes = isset($matches[2]) && $matches[2] !== '' ? (int) $matches[2] : 0;
        $seconds = isset($matches[3]) && $matches[3] !== '' ? (int) $matches[3] : 0;

        $parts = [];

        if ($hours > 0) {
            $parts[] = "{$hours}h";
        }

        if ($minutes > 0) {
            $parts[] = "{$minutes}m";
        }

        // Only show seconds if duration is less than 1 hour and there are seconds
        // or if duration is only seconds
        if ($seconds > 0 && $hours === 0) {
            $parts[] = "{$seconds}s";
        }

        // If no parts (e.g., livestream or invalid), return empty
        if (empty($parts)) {
            return '';
        }

        return implode(' ', $parts);
    }

    /**
     * Convert ISO 8601 duration to total seconds.
     *
     * @param string $isoDuration The ISO 8601 duration string
     * @return int Total seconds
     */
    public function isoDurationToSeconds(string $isoDuration): int
    {
        if (empty($isoDuration)) {
            return 0;
        }

        $pattern = '/PT(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?/';

        if (!preg_match($pattern, $isoDuration, $matches)) {
            return 0;
        }

        $hours = isset($matches[1]) && $matches[1] !== '' ? (int) $matches[1] : 0;
        $minutes = isset($matches[2]) && $matches[2] !== '' ? (int) $matches[2] : 0;
        $seconds = isset($matches[3]) && $matches[3] !== '' ? (int) $matches[3] : 0;

        return ($hours * 3600) + ($minutes * 60) + $seconds;
    }

    /**
     * Format seconds to human-readable duration string.
     *
     * @param int $totalSeconds Total seconds
     * @return string Human-readable duration
     */
    public function formatDuration(int $totalSeconds): string
    {
        if ($totalSeconds <= 0) {
            return '';
        }

        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        $parts = [];

        if ($hours > 0) {
            $parts[] = "{$hours}h";
        }

        if ($minutes > 0) {
            $parts[] = "{$minutes}m";
        }

        if ($seconds > 0 && $hours === 0) {
            $parts[] = "{$seconds}s";
        }

        return implode(' ', $parts);
    }

    /**
     * Clear the cache for a specific video.
     *
     * @param string $videoId The video ID
     * @return bool True if cache was cleared
     */
    public function clearVideoCache(string $videoId): bool
    {
        return Cache::forget("youtube_video_{$videoId}");
    }
}
