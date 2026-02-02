<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;

class FixResourceStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resources:fix-structure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix resource structure to ensure all resources have required fields (language, type, etc.)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Fixing resource structure...');
        $this->newLine();

        $tasks = Task::whereNotNull('resources')->get();
        $fixedCount = 0;
        $totalResources = 0;

        foreach ($tasks as $task) {
            $resources = $task->resources;

            if (!is_array($resources) || empty($resources)) {
                continue;
            }

            $modified = false;

            foreach ($resources as $index => &$resource) {
                $totalResources++;

                // Ensure it's an array
                if (!is_array($resource)) {
                    // If it's just a string URL, convert to proper structure
                    $resource = [
                        'url' => $resource,
                        'title' => '',
                        'language' => 'en',
                        'type' => 'article',
                    ];
                    $modified = true;
                    continue;
                }

                // Add missing fields with defaults
                $changed = false;

                if (!isset($resource['language'])) {
                    $resource['language'] = 'en';
                    $changed = true;
                }

                if (!isset($resource['type'])) {
                    $resource['type'] = 'article';
                    $changed = true;
                }

                if (!isset($resource['title'])) {
                    $resource['title'] = '';
                    $changed = true;
                }

                if (!isset($resource['url'])) {
                    $resource['url'] = '';
                    $changed = true;
                }

                if ($changed) {
                    $modified = true;
                }
            }

            if ($modified) {
                $task->update(['resources' => $resources]);
                $fixedCount++;
                $this->line("  ✓ Fixed resources for task: {$task->title}");
            }
        }

        $this->newLine();
        $this->info("✅ Resource structure fix completed!");
        $this->table(
            ['Metric', 'Count'],
            [
                ['Tasks Processed', $tasks->count()],
                ['Total Resources Checked', $totalResources],
                ['Tasks Fixed', $fixedCount],
            ]
        );

        return 0;
    }
}
