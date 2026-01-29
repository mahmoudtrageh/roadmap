<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ValidateResourceUrls extends Command
{
    protected $signature = 'resources:validate
                          {--task-id= : Validate specific task ID}
                          {--roadmap-id= : Validate specific roadmap}
                          {--fix : Automatically fix common issues}
                          {--report : Generate detailed report}';

    protected $description = 'Validate all resource URLs in tasks and identify broken links';

    private $results = [
        'total_urls' => 0,
        'working' => 0,
        'broken' => 0,
        'redirected' => 0,
        'slow' => 0,
        'errors' => [],
    ];

    public function handle()
    {
        $this->info('🔍 Starting Resource URL Validation...');
        $this->newLine();

        // Get tasks to validate
        $query = Task::query();

        if ($this->option('task-id')) {
            $query->where('id', $this->option('task-id'));
        }

        if ($this->option('roadmap-id')) {
            $query->where('roadmap_id', $this->option('roadmap-id'));
        }

        $tasks = $query->with('roadmap')->get();

        if ($tasks->isEmpty()) {
            $this->error('No tasks found to validate');
            return 1;
        }

        $this->info("Found {$tasks->count()} tasks to validate");
        $progressBar = $this->output->createProgressBar($tasks->count());
        $progressBar->start();

        foreach ($tasks as $task) {
            $this->validateTask($task);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Display results
        $this->displayResults();

        // Generate report if requested
        if ($this->option('report')) {
            $this->generateReport();
        }

        return 0;
    }

    private function validateTask(Task $task)
    {
        if (empty($task->resources_links)) {
            return;
        }

        foreach ($task->resources_links as $index => $resource) {
            $this->results['total_urls']++;

            // Handle both string URLs and object format with title/url
            if (is_string($resource)) {
                $url = $resource;
                $resourceTitle = "Resource #" . ($index + 1);
            } else {
                // Object format
                if (empty($resource['url'])) {
                    $this->results['errors'][] = [
                        'task_id' => $task->id,
                        'task_title' => $task->title,
                        'resource_title' => $resource['title'] ?? $resource['title_en'] ?? $resource['title_ar'] ?? 'Unknown',
                        'url' => 'MISSING',
                        'error' => 'No URL provided',
                        'fixable' => false,
                    ];
                    $this->results['broken']++;
                    continue;
                }
                $url = $resource['url'];
                $resourceTitle = $resource['title'] ?? $resource['title_en'] ?? $resource['title_ar'] ?? 'Unknown';
            }

            $result = $this->checkUrl($url);

            switch ($result['status']) {
                case 'ok':
                    $this->results['working']++;
                    break;

                case 'redirect':
                    $this->results['redirected']++;

                    if ($this->option('fix')) {
                        $this->fixRedirect($task, $index, $result['final_url']);
                        $this->results['working']++;
                    } else {
                        $this->results['errors'][] = [
                            'task_id' => $task->id,
                            'task_title' => $task->title,
                            'resource_title' => $resourceTitle,
                            'url' => $url,
                            'error' => 'Redirects to: ' . $result['final_url'],
                            'fixable' => true,
                        ];
                    }
                    break;

                case 'slow':
                    $this->results['slow']++;
                    $this->results['working']++; // Still works, just slow
                    $this->results['errors'][] = [
                        'task_id' => $task->id,
                        'task_title' => $task->title,
                        'resource_title' => $resourceTitle,
                        'url' => $url,
                        'error' => 'Slow response: ' . $result['time'] . 's',
                        'fixable' => false,
                    ];
                    break;

                case 'error':
                    $this->results['broken']++;
                    $this->results['errors'][] = [
                        'task_id' => $task->id,
                        'task_title' => $task->title,
                        'resource_title' => $resourceTitle,
                        'url' => $url,
                        'error' => $result['message'],
                        'fixable' => false,
                    ];
                    break;
            }
        }
    }

    private function checkUrl(string $url): array
    {
        try {
            $startTime = microtime(true);

            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Learning Platform URL Validator)',
                ])
                ->get($url);

            $endTime = microtime(true);
            $responseTime = round($endTime - $startTime, 2);

            // Check if redirected
            $finalUrl = (string) $response->effectiveUri();
            $isRedirect = !empty($finalUrl) && $finalUrl !== $url;

            if ($response->successful()) {
                if ($isRedirect) {
                    return [
                        'status' => 'redirect',
                        'final_url' => $finalUrl,
                        'time' => $responseTime,
                    ];
                }

                if ($responseTime > 5) {
                    return [
                        'status' => 'slow',
                        'time' => $responseTime,
                    ];
                }

                return ['status' => 'ok', 'time' => $responseTime];
            }

            return [
                'status' => 'error',
                'message' => 'HTTP ' . $response->status(),
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    private function fixRedirect(Task $task, int $index, string $newUrl)
    {
        $resources = $task->resources_links;

        // Handle both string URLs and object format
        if (is_string($resources[$index])) {
            $resources[$index] = $newUrl;
        } else {
            $resources[$index]['url'] = $newUrl;
        }

        $task->update(['resources_links' => $resources]);

        Log::info("Fixed redirect for task {$task->id}: {$newUrl}");
        $this->line("  ✓ Fixed redirect for task {$task->id}");
    }

    private function displayResults()
    {
        $this->info('✅ Validation Complete!');
        $this->newLine();

        $this->table(
            ['Metric', 'Count', 'Percentage'],
            [
                ['Total URLs', $this->results['total_urls'], '100%'],
                ['✅ Working', $this->results['working'], $this->percentage('working')],
                ['🔗 Redirected', $this->results['redirected'], $this->percentage('redirected')],
                ['🐌 Slow (>5s)', $this->results['slow'], $this->percentage('slow')],
                ['❌ Broken', $this->results['broken'], $this->percentage('broken')],
            ]
        );

        if (!empty($this->results['errors'])) {
            $this->newLine();
            $this->error('⚠️  Issues Found: ' . count($this->results['errors']));
            $this->newLine();

            $this->table(
                ['Task ID', 'Task Title', 'Resource', 'URL', 'Error'],
                array_map(function ($error) {
                    return [
                        $error['task_id'],
                        \Illuminate\Support\Str::limit($error['task_title'], 30),
                        \Illuminate\Support\Str::limit($error['resource_title'], 20),
                        \Illuminate\Support\Str::limit($error['url'], 40),
                        $error['error'],
                    ];
                }, array_slice($this->results['errors'], 0, 20)) // Show first 20
            );

            if (count($this->results['errors']) > 20) {
                $remaining = count($this->results['errors']) - 20;
                $this->warn("... and {$remaining} more issues (use --report to see all)");
            }

            if ($this->option('fix')) {
                $this->info('🔧 Automatic fixes applied where possible');
            } else {
                $fixable = count(array_filter($this->results['errors'], fn($e) => $e['fixable'] ?? false));
                if ($fixable > 0) {
                    $this->warn("💡 {$fixable} issues can be auto-fixed. Run with --fix");
                }
            }
        } else {
            $this->info('🎉 All URLs are working perfectly!');
        }
    }

    private function percentage(string $key): string
    {
        if ($this->results['total_urls'] === 0) {
            return '0%';
        }

        $percent = ($this->results[$key] / $this->results['total_urls']) * 100;
        return round($percent, 1) . '%';
    }

    private function generateReport()
    {
        $reportPath = storage_path('app/url-validation-report-' . date('Y-m-d-His') . '.json');

        file_put_contents($reportPath, json_encode([
            'date' => now()->toISOString(),
            'summary' => [
                'total_urls' => $this->results['total_urls'],
                'working' => $this->results['working'],
                'broken' => $this->results['broken'],
                'redirected' => $this->results['redirected'],
                'slow' => $this->results['slow'],
            ],
            'errors' => $this->results['errors'],
        ], JSON_PRETTY_PRINT));

        $this->info("📄 Detailed report saved to: {$reportPath}");
    }
}
