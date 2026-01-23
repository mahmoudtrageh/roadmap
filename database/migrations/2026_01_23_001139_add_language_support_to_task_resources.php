<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if column already exists before adding
        if (!Schema::hasColumn('tasks', 'resources')) {
            Schema::table('tasks', function (Blueprint $table) {
                // Add new column for structured resources with language support
                $table->json('resources')->nullable()->after('resources_links');
            });
        }

        // Migrate existing data from resources_links to resources
        DB::table('tasks')->whereNotNull('resources_links')->orderBy('id')->chunk(100, function ($tasks) {
            foreach ($tasks as $task) {
                $oldResources = json_decode($task->resources_links, true);
                if (is_array($oldResources) && count($oldResources) > 0) {
                    $newResources = [];
                    foreach ($oldResources as $url) {
                        $newResources[] = [
                            'url' => $url,
                            'language' => 'en', // Default to English for existing resources
                            'title' => '', // Empty title, can be filled later
                            'type' => 'article', // Default type
                        ];
                    }
                    DB::table('tasks')
                        ->where('id', $task->id)
                        ->update(['resources' => json_encode($newResources)]);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('resources');
        });
    }
};
