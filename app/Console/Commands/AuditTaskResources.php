<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Illuminate\Support\Facades\Http;

class AuditTaskResources extends Command
{
    protected $signature = 'tasks:audit-resources {--check-links : Check if URLs are accessible} {--fix : Automatically fix issues}';
    protected $description = 'Audit task resources for quality, completeness, and accessibility';

    private array $issues = [];
    private array $stats = [
        'total_tasks' => 0,
        'tasks_with_resources' => 0,
        'tasks_without_resources' => 0,
        'tasks_with_few_resources' => 0,
        'total_resources' => 0,
        'resources_with_titles' => 0,
        'resources_without_titles' => 0,
        'resources_with_metadata' => 0,
        'broken_links' => 0,
    ];

    public function handle()
    {
        $this->info('Starting resource audit...');
        $this->newLine();

        $tasks = Task::all();
        $this->stats['total_tasks'] = $tasks->count();

        $checkLinks = $this->option('check-links');
        $fix = $this->option('fix');

        $progressBar = $this->output->createProgressBar($tasks->count());
        $progressBar->start();

        foreach ($tasks as $task) {
            $this->auditTask($task, $checkLinks, $fix);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->displayReport();

        if ($fix) {
            $this->info("\n✅ Auto-fixes applied where possible.");
        }

        return 0;
    }

    private function auditTask(Task $task, bool $checkLinks, bool $fix)
    {
        $resources = $task->resources_links ?? [];

        // Check if task has resources
        if (empty($resources)) {
            $this->stats['tasks_without_resources']++;
            $this->addIssue($task, 'NO_RESOURCES', 'Task has no learning resources');
            return;
        }

        $this->stats['tasks_with_resources']++;

        // Check if task has enough resources
        if (count($resources) < 3) {
            $this->stats['tasks_with_few_resources']++;
            $this->addIssue($task, 'FEW_RESOURCES', "Task has only " . count($resources) . " resource(s), recommended: 3+");
        }

        // Audit each resource
        foreach ($resources as $index => $resource) {
            $this->stats['total_resources']++;

            if (is_string($resource)) {
                // Old format: just URL string
                $this->stats['resources_without_titles']++;
                $this->addIssue($task, 'NO_TITLE', "Resource #" . ($index + 1) . " has no title: " . substr($resource, 0, 50));

                if ($fix) {
                    $this->fixResource($task, $index, $resource);
                }
            } else {
                // New format: array with metadata
                $url = $resource['url'] ?? '';
                $title = $resource['title'] ?? '';

                if (empty($title)) {
                    $this->stats['resources_without_titles']++;
                    $this->addIssue($task, 'NO_TITLE', "Resource #" . ($index + 1) . " has no title");

                    if ($fix) {
                        $this->fixResource($task, $index, $resource);
                    }
                } else {
                    $this->stats['resources_with_titles']++;
                }

                // Check if resource has enhanced metadata
                if (isset($resource['type']) && isset($resource['difficulty'])) {
                    $this->stats['resources_with_metadata']++;
                }

                // Check if link is accessible
                if ($checkLinks && !empty($url)) {
                    $this->checkLinkAccessibility($task, $url, $index);
                }
            }
        }
    }

    private function fixResource(Task $task, int $index, $resource)
    {
        $resources = $task->resources_links;
        $url = is_string($resource) ? $resource : ($resource['url'] ?? '');

        if (empty($url)) {
            return;
        }

        // Generate title from URL
        $title = $this->generateTitleFromUrl($url);

        // Detect type and difficulty
        $type = $this->detectResourceType($url);
        $difficulty = 'beginner'; // Default to beginner
        $estimatedTime = $this->estimateReadingTime($type);
        $isFree = !str_contains($url, 'amazon.com') && !str_contains($url, 'udemy.com');

        // Update resource with metadata
        $resources[$index] = [
            'title' => $title,
            'url' => $url,
            'type' => $type,
            'difficulty' => $difficulty,
            'estimated_time' => $estimatedTime,
            'is_free' => $isFree,
        ];

        $task->resources_links = $resources;
        $task->save();
    }

    private function generateTitleFromUrl(string $url): string
    {
        // Extract meaningful title from URL
        $domain = parse_url($url, PHP_URL_HOST);
        $path = parse_url($url, PHP_URL_PATH);

        // Known patterns
        if (str_contains($url, 'freecodecamp.org')) {
            return 'FreeCodeCamp - ' . ucwords(str_replace('-', ' ', basename($path, '.html')));
        }

        if (str_contains($url, 'eloquentjavascript.net')) {
            return 'Eloquent JavaScript';
        }

        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            return 'Video Tutorial';
        }

        if (str_contains($url, 'mdn.') || str_contains($url, 'developer.mozilla.org')) {
            return 'MDN Documentation';
        }

        // Fallback: clean domain name
        return ucfirst(str_replace(['www.', '.com', '.org', '.io', '.net'], '', $domain ?? 'Resource'));
    }

    private function detectResourceType(string $url): string
    {
        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be') || str_contains($url, 'vimeo.com')) {
            return 'video';
        }

        if (str_contains($url, 'github.com')) {
            return 'code';
        }

        if (str_contains($url, 'codepen.io') || str_contains($url, 'jsfiddle') || str_contains($url, 'codesandbox')) {
            return 'interactive';
        }

        if (str_contains($url, '/tutorial') || str_contains($url, '/guide')) {
            return 'tutorial';
        }

        return 'article';
    }

    private function estimateReadingTime(string $type): int
    {
        return match($type) {
            'video' => 15,
            'interactive' => 20,
            'tutorial' => 30,
            'article' => 10,
            'code' => 15,
            default => 10,
        };
    }

    private function checkLinkAccessibility(Task $task, string $url, int $index)
    {
        try {
            $response = Http::timeout(5)->head($url);

            if (!$response->successful()) {
                $this->stats['broken_links']++;
                $this->addIssue($task, 'BROKEN_LINK', "Resource #" . ($index + 1) . " returned status " . $response->status() . ": " . substr($url, 0, 50));
            }
        } catch (\Exception $e) {
            $this->stats['broken_links']++;
            $this->addIssue($task, 'BROKEN_LINK', "Resource #" . ($index + 1) . " is not accessible: " . substr($url, 0, 50));
        }
    }

    private function addIssue(Task $task, string $type, string $message)
    {
        $this->issues[] = [
            'task_id' => $task->id,
            'task_title' => $task->title,
            'roadmap' => $task->roadmap->title ?? 'Unknown',
            'day' => $task->day_number,
            'type' => $type,
            'message' => $message,
        ];
    }

    private function displayReport()
    {
        $this->info('=== RESOURCE AUDIT REPORT ===');
        $this->newLine();

        // Overall stats
        $this->table(
            ['Metric', 'Count', 'Percentage'],
            [
                ['Total Tasks', $this->stats['total_tasks'], '100%'],
                ['Tasks with Resources', $this->stats['tasks_with_resources'], round(($this->stats['tasks_with_resources'] / $this->stats['total_tasks']) * 100) . '%'],
                ['Tasks without Resources', $this->stats['tasks_without_resources'], round(($this->stats['tasks_without_resources'] / $this->stats['total_tasks']) * 100) . '%'],
                ['Tasks with <3 Resources', $this->stats['tasks_with_few_resources'], round(($this->stats['tasks_with_few_resources'] / $this->stats['total_tasks']) * 100) . '%'],
                ['Total Resources', $this->stats['total_resources'], '-'],
                ['Resources with Titles', $this->stats['resources_with_titles'], $this->stats['total_resources'] > 0 ? round(($this->stats['resources_with_titles'] / $this->stats['total_resources']) * 100) . '%' : '0%'],
                ['Resources without Titles', $this->stats['resources_without_titles'], $this->stats['total_resources'] > 0 ? round(($this->stats['resources_without_titles'] / $this->stats['total_resources']) * 100) . '%' : '0%'],
                ['Resources with Metadata', $this->stats['resources_with_metadata'], $this->stats['total_resources'] > 0 ? round(($this->stats['resources_with_metadata'] / $this->stats['total_resources']) * 100) . '%' : '0%'],
            ]
        );

        if ($this->stats['broken_links'] > 0) {
            $this->warn("\n⚠️  Found {$this->stats['broken_links']} broken/inaccessible links");
        }

        // Issues by type
        $issueTypes = collect($this->issues)->groupBy('type');

        $this->newLine();
        $this->info('=== ISSUES BY TYPE ===');
        foreach ($issueTypes as $type => $issues) {
            $this->line("{$type}: " . count($issues) . " issues");
        }

        // Top issues to fix
        $this->newLine();
        $this->info('=== TOP ISSUES TO FIX ===');

        $topIssues = collect($this->issues)
            ->take(20)
            ->map(fn($issue) => [
                $issue['task_title'],
                'Day ' . $issue['day'],
                $issue['type'],
                substr($issue['message'], 0, 60)
            ])
            ->toArray();

        if (!empty($topIssues)) {
            $this->table(['Task', 'Day', 'Type', 'Issue'], $topIssues);
        } else {
            $this->info('✅ No major issues found!');
        }

        // Export full report
        $this->exportIssues();
    }

    private function exportIssues()
    {
        if (empty($this->issues)) {
            return;
        }

        $reportPath = storage_path('app/resource-audit-report.json');
        file_put_contents($reportPath, json_encode([
            'generated_at' => now()->toIso8601String(),
            'stats' => $this->stats,
            'issues' => $this->issues,
        ], JSON_PRETTY_PRINT));

        $this->newLine();
        $this->info("📄 Full report saved to: {$reportPath}");
    }
}
