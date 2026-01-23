<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ContentQualityAudit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:quality-audit
                            {--report : Generate detailed JSON report}
                            {--fix : Show fix suggestions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run comprehensive content quality audit on all tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Running Content Quality Audit...');
        $this->newLine();

        $tasks = \App\Models\Task::orderBy('day_number')->orderBy('order')->get();

        $issues = [
            'missing_description' => [],
            'missing_resources' => [],
            'missing_objectives' => [],
            'missing_skills' => [],
            'missing_time_estimate' => [],
            'missing_category' => [],
            'missing_difficulty' => [],
            'order_gaps' => [],
            'duplicate_orders' => [],
            'missing_checklists' => [],
            'missing_quizzes' => [],
            'missing_examples' => [],
            'missing_hints' => [],
        ];

        $stats = [
            'total_tasks' => $tasks->count(),
            'perfect_tasks' => 0,
            'tasks_with_issues' => 0,
        ];

        $this->info("Auditing {$tasks->count()} tasks...");
        $progressBar = $this->output->createProgressBar($tasks->count());
        $progressBar->start();

        foreach ($tasks as $task) {
            $taskIssues = 0;

            // Check required fields
            if (empty($task->description)) {
                $issues['missing_description'][] = $task->id;
                $taskIssues++;
            }

            if (empty($task->resources_links) || count($task->resources_links) === 0) {
                $issues['missing_resources'][] = $task->id;
                $taskIssues++;
            }

            if (empty($task->learning_objectives) || count($task->learning_objectives) === 0) {
                $issues['missing_objectives'][] = $task->id;
                $taskIssues++;
            }

            if (empty($task->skills_gained) || count($task->skills_gained) === 0) {
                $issues['missing_skills'][] = $task->id;
                $taskIssues++;
            }

            if (!$task->estimated_time_minutes || $task->estimated_time_minutes === 0) {
                $issues['missing_time_estimate'][] = $task->id;
                $taskIssues++;
            }

            if (empty($task->category)) {
                $issues['missing_category'][] = $task->id;
                $taskIssues++;
            }

            if (empty($task->difficulty_level)) {
                $issues['missing_difficulty'][] = $task->id;
                $taskIssues++;
            }

            // Check for interactive elements
            if (!$task->checklists()->exists()) {
                $issues['missing_checklists'][] = $task->id;
            }

            if (!$task->quizzes()->exists()) {
                $issues['missing_quizzes'][] = $task->id;
            }

            if (in_array($task->task_type, ['coding', 'exercise', 'project']) && !$task->examples()->exists()) {
                $issues['missing_examples'][] = $task->id;
            }

            if (in_array($task->difficulty_level, ['intermediate', 'advanced']) && !$task->hints()->exists()) {
                $issues['missing_hints'][] = $task->id;
            }

            if ($taskIssues === 0) {
                $stats['perfect_tasks']++;
            } else {
                $stats['tasks_with_issues']++;
            }

            $progressBar->advance();
        }

        // Check for order issues
        $orderCounts = [];
        foreach ($tasks as $task) {
            $key = $task->roadmap_id . '-' . $task->order;
            if (!isset($orderCounts[$key])) {
                $orderCounts[$key] = [];
            }
            $orderCounts[$key][] = $task->id;
        }

        foreach ($orderCounts as $key => $taskIds) {
            if (count($taskIds) > 1) {
                $issues['duplicate_orders'] = array_merge($issues['duplicate_orders'], $taskIds);
            }
        }

        $progressBar->finish();
        $this->newLine(2);

        // Display results
        $this->info('📊 Audit Results:');
        $this->newLine();

        $this->table(
            ['Metric', 'Count', 'Percentage'],
            [
                ['Total Tasks', $stats['total_tasks'], '100%'],
                ['Perfect Tasks', $stats['perfect_tasks'], round(($stats['perfect_tasks'] / $stats['total_tasks']) * 100, 1) . '%'],
                ['Tasks with Issues', $stats['tasks_with_issues'], round(($stats['tasks_with_issues'] / $stats['total_tasks']) * 100, 1) . '%'],
            ]
        );

        $this->newLine();
        $this->info('🚨 Issues Found:');
        $this->newLine();

        $issueTable = [];
        foreach ($issues as $type => $taskIds) {
            if (count($taskIds) > 0) {
                $issueTable[] = [
                    ucwords(str_replace('_', ' ', $type)),
                    count($taskIds),
                    round((count($taskIds) / $stats['total_tasks']) * 100, 1) . '%',
                ];
            }
        }

        if (count($issueTable) > 0) {
            $this->table(['Issue Type', 'Count', 'Percentage'], $issueTable);
        } else {
            $this->info('✅ No issues found! All tasks are perfect!');
        }

        // Show critical issues
        if (count($issues['missing_description']) > 0) {
            $this->newLine();
            $this->error('⚠️  Critical: ' . count($issues['missing_description']) . ' tasks missing descriptions');
            $this->line('Task IDs: ' . implode(', ', array_slice($issues['missing_description'], 0, 20)));
            if (count($issues['missing_description']) > 20) {
                $this->line('... and ' . (count($issues['missing_description']) - 20) . ' more');
            }
        }

        if (count($issues['missing_resources']) > 0) {
            $this->newLine();
            $this->error('⚠️  Critical: ' . count($issues['missing_resources']) . ' tasks missing resources');
            $this->line('Task IDs: ' . implode(', ', array_slice($issues['missing_resources'], 0, 20)));
            if (count($issues['missing_resources']) > 20) {
                $this->line('... and ' . (count($issues['missing_resources']) - 20) . ' more');
            }
        }

        // Generate report if requested
        if ($this->option('report')) {
            $report = [
                'stats' => $stats,
                'issues' => $issues,
                'timestamp' => now()->toIso8601String(),
            ];

            $reportPath = storage_path('app/content-quality-report.json');
            file_put_contents($reportPath, json_encode($report, JSON_PRETTY_PRINT));
            $this->newLine();
            $this->info("📄 Detailed report saved to: {$reportPath}");
        }

        // Show fix suggestions
        if ($this->option('fix')) {
            $this->newLine();
            $this->info('💡 Fix Suggestions:');
            $this->newLine();

            if (count($issues['missing_description']) > 0) {
                $this->line('• Add descriptions to ' . count($issues['missing_description']) . ' tasks');
            }
            if (count($issues['missing_resources']) > 0) {
                $this->line('• Add learning resources to ' . count($issues['missing_resources']) . ' tasks');
            }
            if (count($issues['missing_checklists']) > 0) {
                $this->line('• Run: php artisan tasks:generate-checklists --force');
            }
            if (count($issues['missing_quizzes']) > 0) {
                $this->line('• Run: php artisan tasks:generate-quizzes --force');
            }
            if (count($issues['missing_examples']) > 0) {
                $this->line('• Run: php artisan tasks:generate-examples --force');
            }
            if (count($issues['missing_hints']) > 0) {
                $this->line('• Run: php artisan tasks:generate-hints --force');
            }
        }

        $this->newLine();
        $this->info('✅ Content quality audit complete!');

        return 0;
    }
}
