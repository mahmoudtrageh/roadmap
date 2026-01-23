<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ContentHealthReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:health-report
                            {--detailed : Show detailed breakdown by roadmap}
                            {--json : Output as JSON}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate comprehensive content health report showing quality metrics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📊 Generating Content Health Report...');
        $this->newLine();

        $totalTasks = \App\Models\Task::count();

        $health = [
            'overview' => [
                'total_tasks' => $totalTasks,
                'total_roadmaps' => \App\Models\Roadmap::count(),
                'timestamp' => now()->toIso8601String(),
            ],
            'quality_metrics' => [
                'missing_description' => \App\Models\Task::whereNull('description')->orWhere('description', '')->count(),
                'missing_resources' => \App\Models\Task::where(function($q) {
                    $q->whereNull('resources_links')->orWhereJsonLength('resources_links', 0);
                })->count(),
                'missing_objectives' => \App\Models\Task::where(function($q) {
                    $q->whereNull('learning_objectives')->orWhereJsonLength('learning_objectives', 0);
                })->count(),
                'missing_skills' => \App\Models\Task::where(function($q) {
                    $q->whereNull('skills_gained')->orWhereJsonLength('skills_gained', 0);
                })->count(),
                'missing_checklists' => \App\Models\Task::whereDoesntHave('checklists')->count(),
                'missing_quizzes' => \App\Models\Task::whereDoesntHave('quizzes')->count(),
                'missing_examples' => \App\Models\Task::whereIn('task_type', ['coding', 'exercise', 'project'])
                    ->whereDoesntHave('examples')->count(),
                'missing_hints' => \App\Models\Task::whereIn('difficulty_level', ['intermediate', 'advanced'])
                    ->whereDoesntHave('hints')->count(),
                'long_tasks' => \App\Models\Task::where('estimated_time_minutes', '>', 120)->count(),
                'no_difficulty' => \App\Models\Task::whereNull('difficulty_level')->orWhere('difficulty_level', '')->count(),
            ],
            'interactive_elements' => [
                'total_checklists' => \App\Models\TaskChecklist::count(),
                'total_quizzes' => \App\Models\TaskQuiz::count(),
                'total_examples' => \App\Models\TaskExample::count(),
                'total_hints' => \App\Models\TaskHint::count(),
            ],
            'task_breakdown' => [
                'by_type' => \App\Models\Task::selectRaw('task_type, count(*) as count')
                    ->groupBy('task_type')
                    ->pluck('count', 'task_type')
                    ->toArray(),
                'by_difficulty' => \App\Models\Task::selectRaw('difficulty_level, count(*) as count')
                    ->groupBy('difficulty_level')
                    ->pluck('count', 'difficulty_level')
                    ->toArray(),
            ],
        ];

        // Calculate perfect tasks (no issues)
        $perfectTasks = $totalTasks - \App\Models\Task::where(function($q) {
            $q->whereNull('description')
              ->orWhere('description', '')
              ->orWhereNull('resources_links')
              ->orWhereJsonLength('resources_links', 0)
              ->orWhereNull('learning_objectives')
              ->orWhereJsonLength('learning_objectives', 0)
              ->orWhereNull('skills_gained')
              ->orWhereJsonLength('skills_gained', 0)
              ->orWhereNull('difficulty_level')
              ->orWhere('difficulty_level', '');
        })->count();

        $health['overview']['perfect_tasks'] = $perfectTasks;
        $health['overview']['tasks_with_issues'] = $totalTasks - $perfectTasks;
        $health['overview']['quality_score'] = $totalTasks > 0 ? round(($perfectTasks / $totalTasks) * 100, 1) : 0;

        // JSON output
        if ($this->option('json')) {
            $this->line(json_encode($health, JSON_PRETTY_PRINT));
            return 0;
        }

        // Display overview
        $this->info('📈 Overview:');
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Tasks', $health['overview']['total_tasks']],
                ['Total Roadmaps', $health['overview']['total_roadmaps']],
                ['Perfect Tasks', $health['overview']['perfect_tasks'] . ' (' . $health['overview']['quality_score'] . '%)'],
                ['Tasks with Issues', $health['overview']['tasks_with_issues']],
                ['Quality Score', $health['overview']['quality_score'] . '%'],
            ]
        );

        $this->newLine();
        $this->info('🚨 Quality Issues:');
        $issuesTable = [];
        foreach ($health['quality_metrics'] as $metric => $count) {
            if ($count > 0) {
                $percentage = round(($count / $totalTasks) * 100, 1);
                $issuesTable[] = [
                    ucwords(str_replace('_', ' ', $metric)),
                    $count,
                    $percentage . '%'
                ];
            }
        }

        if (count($issuesTable) > 0) {
            $this->table(['Issue Type', 'Count', 'Percentage'], $issuesTable);
        } else {
            $this->info('✅ No quality issues found!');
        }

        $this->newLine();
        $this->info('🎯 Interactive Elements:');
        $this->table(
            ['Element', 'Count'],
            [
                ['Checklists', $health['interactive_elements']['total_checklists']],
                ['Quizzes', $health['interactive_elements']['total_quizzes']],
                ['Code Examples', $health['interactive_elements']['total_examples']],
                ['Hints', $health['interactive_elements']['total_hints']],
            ]
        );

        $this->newLine();
        $this->info('📊 Task Breakdown:');

        // By type
        $this->line('By Type:');
        foreach ($health['task_breakdown']['by_type'] as $type => $count) {
            $percentage = round(($count / $totalTasks) * 100, 1);
            $this->line("  • {$type}: {$count} ({$percentage}%)");
        }

        $this->newLine();
        $this->line('By Difficulty:');
        foreach ($health['task_breakdown']['by_difficulty'] as $difficulty => $count) {
            if (!empty($difficulty)) {
                $percentage = round(($count / $totalTasks) * 100, 1);
                $this->line("  • {$difficulty}: {$count} ({$percentage}%)");
            }
        }

        // Detailed breakdown by roadmap
        if ($this->option('detailed')) {
            $this->newLine(2);
            $this->info('📚 Breakdown by Roadmap:');

            $roadmaps = \App\Models\Roadmap::withCount('tasks')->get();
            foreach ($roadmaps as $roadmap) {
                $this->newLine();
                $this->line("🗺️  {$roadmap->title} ({$roadmap->tasks_count} tasks)");

                $roadmapIssues = [
                    'missing_desc' => \App\Models\Task::where('roadmap_id', $roadmap->id)
                        ->where(function($q) { $q->whereNull('description')->orWhere('description', ''); })->count(),
                    'missing_resources' => \App\Models\Task::where('roadmap_id', $roadmap->id)
                        ->where(function($q) { $q->whereNull('resources_links')->orWhereJsonLength('resources_links', 0); })->count(),
                    'missing_objectives' => \App\Models\Task::where('roadmap_id', $roadmap->id)
                        ->where(function($q) { $q->whereNull('learning_objectives')->orWhereJsonLength('learning_objectives', 0); })->count(),
                ];

                $issuesCount = array_sum($roadmapIssues);
                if ($issuesCount > 0) {
                    $this->warn("  ⚠️  {$issuesCount} issues found");
                    foreach ($roadmapIssues as $issue => $count) {
                        if ($count > 0) {
                            $this->line("     • " . ucwords(str_replace('_', ' ', $issue)) . ": {$count}");
                        }
                    }
                } else {
                    $this->info('  ✅ All tasks are perfect!');
                }
            }
        }

        $this->newLine(2);
        $this->info('✅ Content health report complete!');
        $this->line('💡 Tip: Run with --detailed for roadmap breakdown');
        $this->line('💡 Tip: Run with --json to get machine-readable output');

        return 0;
    }
}
