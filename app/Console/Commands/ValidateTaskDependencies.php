<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ValidateTaskDependencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:validate-dependencies
                            {--fix : Automatically fix invalid dependencies}
                            {--roadmap= : Validate only specific roadmap ID}
                            {--report : Generate detailed validation report}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate task dependencies for circular references and invalid task IDs';

    private array $errors = [];
    private array $warnings = [];
    private array $fixes = [];
    private array $visitedNodes = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Starting Task Dependency Validation...');
        $this->newLine();

        // Get tasks to validate
        $query = Task::query();

        if ($roadmapId = $this->option('roadmap')) {
            $query->where('roadmap_id', $roadmapId);
            $this->info("Validating roadmap ID: {$roadmapId}");
        } else {
            $this->info('Validating all roadmaps');
        }

        $tasks = $query->get();
        $this->info("Found {$tasks->count()} tasks to validate");
        $this->newLine();

        // Run validation checks
        $this->validateInvalidTaskIds($tasks);
        $this->validateCircularDependencies($tasks);
        $this->validateDependencyOrder($tasks);
        $this->validateSelfReferences($tasks);

        // Display results
        $this->displayResults();

        // Apply fixes if requested
        if ($this->option('fix') && count($this->fixes) > 0) {
            $this->applyFixes();
        }

        // Generate report if requested
        if ($this->option('report')) {
            $this->generateReport($tasks);
        }

        // Return status
        if (count($this->errors) > 0) {
            $this->error('❌ Validation failed with errors');
            return 1;
        }

        $this->info('✅ All dependency validations passed!');
        return 0;
    }

    /**
     * Validate that all prerequisite and recommended task IDs exist
     */
    private function validateInvalidTaskIds($tasks)
    {
        $this->info('📋 Checking for invalid task IDs...');

        $validTaskIds = $tasks->pluck('id')->toArray();
        $invalidCount = 0;

        foreach ($tasks as $task) {
            // Check prerequisites
            if ($task->prerequisites && is_array($task->prerequisites)) {
                foreach ($task->prerequisites as $prereqId) {
                    if (!in_array($prereqId, $validTaskIds)) {
                        $this->errors[] = [
                            'task_id' => $task->id,
                            'task_title' => $task->title,
                            'type' => 'invalid_prerequisite',
                            'message' => "Prerequisite task ID {$prereqId} does not exist",
                        ];

                        $this->fixes[] = [
                            'task_id' => $task->id,
                            'action' => 'remove_invalid_prerequisite',
                            'value' => $prereqId,
                        ];

                        $invalidCount++;
                    }
                }
            }

            // Check recommended tasks
            if ($task->recommended_tasks && is_array($task->recommended_tasks)) {
                foreach ($task->recommended_tasks as $recId) {
                    if (!in_array($recId, $validTaskIds)) {
                        $this->warnings[] = [
                            'task_id' => $task->id,
                            'task_title' => $task->title,
                            'type' => 'invalid_recommended',
                            'message' => "Recommended task ID {$recId} does not exist",
                        ];

                        $this->fixes[] = [
                            'task_id' => $task->id,
                            'action' => 'remove_invalid_recommended',
                            'value' => $recId,
                        ];
                    }
                }
            }
        }

        if ($invalidCount === 0) {
            $this->line('  ✓ No invalid task IDs found');
        }
    }

    /**
     * Detect circular dependencies using depth-first search
     */
    private function validateCircularDependencies($tasks)
    {
        $this->info('🔄 Checking for circular dependencies...');

        $taskMap = $tasks->keyBy('id');
        $circularCount = 0;

        foreach ($tasks as $task) {
            if ($task->prerequisites && is_array($task->prerequisites) && count($task->prerequisites) > 0) {
                $this->visitedNodes = [];
                $path = [];

                if ($this->hasCircularDependency($task->id, $taskMap, $path)) {
                    $cycleDisplay = implode(' → ', $path) . ' → ' . $task->id;

                    $this->errors[] = [
                        'task_id' => $task->id,
                        'task_title' => $task->title,
                        'type' => 'circular_dependency',
                        'message' => "Circular dependency detected: {$cycleDisplay}",
                    ];

                    $circularCount++;
                }
            }
        }

        if ($circularCount === 0) {
            $this->line('  ✓ No circular dependencies found');
        }
    }

    /**
     * Recursive function to detect cycles using DFS
     */
    private function hasCircularDependency($taskId, $taskMap, &$path)
    {
        // If we've seen this node in current path, we found a cycle
        if (in_array($taskId, $path)) {
            return true;
        }

        // If we've fully explored this node before, skip it
        if (isset($this->visitedNodes[$taskId])) {
            return false;
        }

        // Add to current path
        $path[] = $taskId;

        // Get task
        $task = $taskMap->get($taskId);

        if ($task && $task->prerequisites && is_array($task->prerequisites)) {
            foreach ($task->prerequisites as $prereqId) {
                if ($this->hasCircularDependency($prereqId, $taskMap, $path)) {
                    return true;
                }
            }
        }

        // Mark as fully explored
        $this->visitedNodes[$taskId] = true;

        // Remove from current path
        array_pop($path);

        return false;
    }

    /**
     * Validate that prerequisites come before the task in order
     */
    private function validateDependencyOrder($tasks)
    {
        $this->info('📊 Checking dependency order logic...');

        $orderViolations = 0;

        foreach ($tasks as $task) {
            if ($task->prerequisites && is_array($task->prerequisites)) {
                foreach ($task->prerequisites as $prereqId) {
                    $prereqTask = $tasks->firstWhere('id', $prereqId);

                    if ($prereqTask) {
                        // Check if they're in the same roadmap
                        if ($prereqTask->roadmap_id === $task->roadmap_id) {
                            // Prerequisite should have lower order number
                            if ($prereqTask->order >= $task->order) {
                                $this->warnings[] = [
                                    'task_id' => $task->id,
                                    'task_title' => $task->title,
                                    'type' => 'order_violation',
                                    'message' => "Prerequisite '{$prereqTask->title}' (order: {$prereqTask->order}) comes after or same as task (order: {$task->order})",
                                ];

                                $orderViolations++;
                            }
                        }
                    }
                }
            }
        }

        if ($orderViolations === 0) {
            $this->line('  ✓ All prerequisites come before their tasks');
        }
    }

    /**
     * Check for tasks that reference themselves
     */
    private function validateSelfReferences($tasks)
    {
        $this->info('🔗 Checking for self-references...');

        $selfRefCount = 0;

        foreach ($tasks as $task) {
            // Check prerequisites
            if ($task->prerequisites && is_array($task->prerequisites) && in_array($task->id, $task->prerequisites)) {
                $this->errors[] = [
                    'task_id' => $task->id,
                    'task_title' => $task->title,
                    'type' => 'self_reference_prerequisite',
                    'message' => 'Task references itself as a prerequisite',
                ];

                $this->fixes[] = [
                    'task_id' => $task->id,
                    'action' => 'remove_self_prerequisite',
                    'value' => $task->id,
                ];

                $selfRefCount++;
            }

            // Check recommended
            if ($task->recommended_tasks && is_array($task->recommended_tasks) && in_array($task->id, $task->recommended_tasks)) {
                $this->warnings[] = [
                    'task_id' => $task->id,
                    'task_title' => $task->title,
                    'type' => 'self_reference_recommended',
                    'message' => 'Task references itself as recommended',
                ];

                $this->fixes[] = [
                    'task_id' => $task->id,
                    'action' => 'remove_self_recommended',
                    'value' => $task->id,
                ];
            }
        }

        if ($selfRefCount === 0) {
            $this->line('  ✓ No self-references found');
        }
    }

    /**
     * Display validation results
     */
    private function displayResults()
    {
        $this->newLine();
        $this->info('═══════════════════════════════════════════════════════════');
        $this->info('                    VALIDATION RESULTS                     ');
        $this->info('═══════════════════════════════════════════════════════════');
        $this->newLine();

        // Display errors
        if (count($this->errors) > 0) {
            $this->error('❌ ERRORS (' . count($this->errors) . ')');
            $this->newLine();

            foreach ($this->errors as $error) {
                $this->line("  Task #{$error['task_id']}: {$error['task_title']}");
                $this->line("  Type: {$error['type']}");
                $this->error("  ✗ {$error['message']}");
                $this->newLine();
            }
        }

        // Display warnings
        if (count($this->warnings) > 0) {
            $this->warn('⚠️  WARNINGS (' . count($this->warnings) . ')');
            $this->newLine();

            foreach ($this->warnings as $warning) {
                $this->line("  Task #{$warning['task_id']}: {$warning['task_title']}");
                $this->line("  Type: {$warning['type']}");
                $this->warn("  ⚠ {$warning['message']}");
                $this->newLine();
            }
        }

        // Summary
        $this->info('───────────────────────────────────────────────────────────');
        $this->line('Summary:');
        $this->line("  Errors: " . count($this->errors));
        $this->line("  Warnings: " . count($this->warnings));
        $this->line("  Fixable issues: " . count($this->fixes));
        $this->info('═══════════════════════════════════════════════════════════');
    }

    /**
     * Apply automatic fixes
     */
    private function applyFixes()
    {
        if (!$this->confirm('Apply ' . count($this->fixes) . ' automatic fixes?', true)) {
            $this->info('Fixes not applied');
            return;
        }

        $this->info('Applying fixes...');

        $fixedCount = 0;

        foreach ($this->fixes as $fix) {
            $task = Task::find($fix['task_id']);

            if (!$task) {
                continue;
            }

            switch ($fix['action']) {
                case 'remove_invalid_prerequisite':
                case 'remove_self_prerequisite':
                    $prerequisites = $task->prerequisites ?? [];
                    $prerequisites = array_values(array_diff($prerequisites, [$fix['value']]));
                    $task->prerequisites = $prerequisites;
                    $task->save();
                    $fixedCount++;
                    break;

                case 'remove_invalid_recommended':
                case 'remove_self_recommended':
                    $recommended = $task->recommended_tasks ?? [];
                    $recommended = array_values(array_diff($recommended, [$fix['value']]));
                    $task->recommended_tasks = $recommended;
                    $task->save();
                    $fixedCount++;
                    break;
            }
        }

        $this->info("✅ Applied {$fixedCount} fixes");
    }

    /**
     * Generate detailed validation report
     */
    private function generateReport($tasks)
    {
        $report = [
            'timestamp' => now()->toIso8601String(),
            'total_tasks' => $tasks->count(),
            'tasks_with_prerequisites' => $tasks->filter(fn($t) => $t->prerequisites && count($t->prerequisites) > 0)->count(),
            'tasks_with_recommended' => $tasks->filter(fn($t) => $t->recommended_tasks && count($t->recommended_tasks) > 0)->count(),
            'total_errors' => count($this->errors),
            'total_warnings' => count($this->warnings),
            'errors' => $this->errors,
            'warnings' => $this->warnings,
            'dependency_stats' => $this->calculateDependencyStats($tasks),
        ];

        $reportPath = storage_path('app/dependency-validation-report.json');
        file_put_contents($reportPath, json_encode($report, JSON_PRETTY_PRINT));

        $this->info("📄 Report saved to: {$reportPath}");
    }

    /**
     * Calculate dependency statistics
     */
    private function calculateDependencyStats($tasks)
    {
        $stats = [
            'max_prerequisites' => 0,
            'avg_prerequisites' => 0,
            'max_recommended' => 0,
            'avg_recommended' => 0,
            'tasks_by_dependency_count' => [],
        ];

        $prereqCounts = [];
        $recCounts = [];

        foreach ($tasks as $task) {
            $prereqCount = $task->prerequisites ? count($task->prerequisites) : 0;
            $recCount = $task->recommended_tasks ? count($task->recommended_tasks) : 0;

            $prereqCounts[] = $prereqCount;
            $recCounts[] = $recCount;

            $stats['max_prerequisites'] = max($stats['max_prerequisites'], $prereqCount);
            $stats['max_recommended'] = max($stats['max_recommended'], $recCount);
        }

        $stats['avg_prerequisites'] = count($prereqCounts) > 0 ? round(array_sum($prereqCounts) / count($prereqCounts), 2) : 0;
        $stats['avg_recommended'] = count($recCounts) > 0 ? round(array_sum($recCounts) / count($recCounts), 2) : 0;

        return $stats;
    }
}
