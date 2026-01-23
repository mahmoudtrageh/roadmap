<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AnalyzeResourceRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:analyze-ratings
                            {--report : Generate detailed JSON report}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyze resource ratings and identify highly rated and poorly rated resources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('⭐ Analyzing Resource Ratings...');
        $this->newLine();

        // Get all resource ratings
        $ratings = \App\Models\ResourceRating::with('task')->get();

        $stats = [
            'total_ratings' => $ratings->count(),
            'highly_rated' => [],
            'poorly_rated' => [],
            'by_task' => [],
            'overall' => [
                'avg_rating' => 0,
                'tasks_with_ratings' => 0,
                'tasks_without_ratings' => 0,
            ],
        ];

        // Group ratings by task and resource index
        $ratingsByTaskResource = [];
        foreach ($ratings as $rating) {
            $key = $rating->task_id . '-' . $rating->resource_index;
            if (!isset($ratingsByTaskResource[$key])) {
                $ratingsByTaskResource[$key] = [
                    'task_id' => $rating->task_id,
                    'task_title' => $rating->task->title ?? 'Unknown',
                    'resource_index' => $rating->resource_index,
                    'ratings' => [],
                    'avg' => 0,
                    'count' => 0,
                ];
            }
            $ratingsByTaskResource[$key]['ratings'][] = $rating->rating;
        }

        // Calculate averages
        foreach ($ratingsByTaskResource as $key => &$data) {
            $data['avg'] = round(array_sum($data['ratings']) / count($data['ratings']), 2);
            $data['count'] = count($data['ratings']);

            // Categorize
            if ($data['avg'] >= 4.0 && $data['count'] >= 3) {
                $stats['highly_rated'][] = $data;
            } elseif ($data['avg'] < 3.0 && $data['count'] >= 3) {
                $stats['poorly_rated'][] = $data;
            }
        }

        // Sort
        usort($stats['highly_rated'], fn($a, $b) => $b['avg'] <=> $a['avg']);
        usort($stats['poorly_rated'], fn($a, $b) => $a['avg'] <=> $b['avg']);

        // Overall stats
        if (count($ratingsByTaskResource) > 0) {
            $allAvgs = array_column($ratingsByTaskResource, 'avg');
            $stats['overall']['avg_rating'] = round(array_sum($allAvgs) / count($allAvgs), 2);
        }

        $tasks = \App\Models\Task::all();
        $tasksWithRatings = collect($ratingsByTaskResource)->pluck('task_id')->unique()->count();
        $stats['overall']['tasks_with_ratings'] = $tasksWithRatings;
        $stats['overall']['tasks_without_ratings'] = $tasks->count() - $tasksWithRatings;

        // Display results
        $this->newLine();
        $this->info('📊 Overall Statistics:');
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Ratings', $stats['total_ratings']],
                ['Unique Resources Rated', count($ratingsByTaskResource)],
                ['Average Rating', $stats['overall']['avg_rating'] . ' / 5.0'],
                ['Tasks with Ratings', $stats['overall']['tasks_with_ratings']],
                ['Tasks without Ratings', $stats['overall']['tasks_without_ratings']],
                ['Highly Rated Resources (≥4.0)', count($stats['highly_rated'])],
                ['Poorly Rated Resources (<3.0)', count($stats['poorly_rated'])],
            ]
        );

        // Show highly rated resources
        if (count($stats['highly_rated']) > 0) {
            $this->newLine();
            $this->info('🌟 Highly Rated Resources (Top 10):');
            $top10 = array_slice($stats['highly_rated'], 0, 10);
            $table = [];
            foreach ($top10 as $res) {
                $table[] = [
                    'Task ' . $res['task_id'],
                    substr($res['task_title'], 0, 40),
                    'Resource #' . ($res['resource_index'] + 1),
                    $res['avg'] . ' ⭐',
                    $res['count'] . ' ratings',
                ];
            }
            $this->table(['Task ID', 'Task Title', 'Resource', 'Avg Rating', 'Count'], $table);
        }

        // Show poorly rated resources
        if (count($stats['poorly_rated']) > 0) {
            $this->newLine();
            $this->warn('⚠️  Poorly Rated Resources (Need Alternatives):');
            $table = [];
            foreach ($stats['poorly_rated'] as $res) {
                $table[] = [
                    'Task ' . $res['task_id'],
                    substr($res['task_title'], 0, 40),
                    'Resource #' . ($res['resource_index'] + 1),
                    $res['avg'] . ' ⭐',
                    $res['count'] . ' ratings',
                ];
            }
            $this->table(['Task ID', 'Task Title', 'Resource', 'Avg Rating', 'Count'], $table);

            $this->newLine();
            $this->info('💡 Suggestion: Add alternative resources for these ' . count($stats['poorly_rated']) . ' poorly rated items');
        }

        // Generate report if requested
        if ($this->option('report')) {
            $reportPath = storage_path('app/rating-analysis-report.json');
            file_put_contents($reportPath, json_encode($stats, JSON_PRETTY_PRINT));
            $this->newLine();
            $this->info("📄 Report saved to: {$reportPath}");
        }

        $this->newLine();
        $this->info('✅ Rating analysis complete!');

        return 0;
    }
}
