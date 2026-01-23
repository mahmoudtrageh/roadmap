<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AuditTaskTimes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:audit-times
                            {--report : Generate detailed JSON report}
                            {--fix : Suggest time estimate improvements}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Audit task time estimates and identify issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('⏱️  Auditing Task Time Estimates...');
        $this->newLine();

        $tasks = \App\Models\Task::all();

        $stats = [
            'total_tasks' => $tasks->count(),
            'no_estimate' => 0,
            'too_long' => [],
            'too_short' => [],
            'reasonable' => 0,
            'by_type' => [],
        ];

        foreach ($tasks as $task) {
            $estimate = $task->estimated_time_minutes;

            // Track by type
            $type = $task->task_type;
            if (!isset($stats['by_type'][$type])) {
                $stats['by_type'][$type] = [
                    'count' => 0,
                    'avg_estimate' => 0,
                    'total_minutes' => 0,
                ];
            }
            $stats['by_type'][$type]['count']++;
            $stats['by_type'][$type]['total_minutes'] += $estimate ?? 0;

            // Check for issues
            if (!$estimate || $estimate === 0) {
                $stats['no_estimate']++;
            } elseif ($estimate > 120) {
                $stats['too_long'][] = [
                    'id' => $task->id,
                    'title' => $task->title,
                    'type' => $task->task_type,
                    'estimate' => $estimate,
                    'day' => $task->day_number,
                ];
            } elseif ($estimate < 5) {
                $stats['too_short'][] = [
                    'id' => $task->id,
                    'title' => $task->title,
                    'type' => $task->task_type,
                    'estimate' => $estimate,
                ];
            } else {
                $stats['reasonable']++;
            }
        }

        // Calculate averages by type
        foreach ($stats['by_type'] as $type => &$data) {
            if ($data['count'] > 0) {
                $data['avg_estimate'] = round($data['total_minutes'] / $data['count'], 1);
            }
        }

        // Display summary
        $this->newLine();
        $this->info('📊 Summary:');
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Tasks', $stats['total_tasks']],
                ['No Time Estimate', $stats['no_estimate']],
                ['Too Long (>120 min)', count($stats['too_long'])],
                ['Too Short (<5 min)', count($stats['too_short'])],
                ['Reasonable (5-120 min)', $stats['reasonable']],
            ]
        );

        $this->newLine();
        $this->info('📋 Average Time by Task Type:');
        $typeTable = [];
        foreach ($stats['by_type'] as $type => $data) {
            $typeTable[] = [
                ucfirst($type),
                $data['count'],
                $data['avg_estimate'] . ' min',
            ];
        }
        $this->table(['Type', 'Count', 'Avg Time'], $typeTable);

        // Show tasks that are too long
        if (count($stats['too_long']) > 0) {
            $this->newLine();
            $this->warn('⚠️  Tasks Over 120 Minutes (Consider Splitting):');
            $longTable = [];
            foreach ($stats['too_long'] as $task) {
                $longTable[] = [
                    $task['id'],
                    substr($task['title'], 0, 50),
                    ucfirst($task['type']),
                    'Day ' . $task['day'],
                    $task['estimate'] . ' min',
                ];
            }
            $this->table(['ID', 'Title', 'Type', 'Day', 'Estimate'], $longTable);

            if ($this->option('fix')) {
                $this->newLine();
                $this->info('💡 Suggestions:');
                foreach ($stats['too_long'] as $task) {
                    $parts = ceil($task['estimate'] / 90);
                    $this->line("  Task {$task['id']}: Split into {$parts} parts (~" . round($task['estimate'] / $parts) . " min each)");
                }
            }
        }

        // Generate report if requested
        if ($this->option('report')) {
            $reportPath = storage_path('app/time-audit-report.json');
            file_put_contents($reportPath, json_encode($stats, JSON_PRETTY_PRINT));
            $this->newLine();
            $this->info("📄 Report saved to: {$reportPath}");
        }

        $this->newLine();
        $this->info('✅ Time audit complete!');

        return 0;
    }
}
