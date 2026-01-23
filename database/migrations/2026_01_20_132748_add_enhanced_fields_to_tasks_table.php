<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Add enhanced fields to support:
     * - Task splitting and multi-part tasks (120-minute maximum)
     * - Learning objectives and skills tracking
     * - Advanced search and filtering
     * - Analytics and performance metrics
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // ====================================================================
            // PHASE 1: Task Splitting & Relationship Fields
            // Purpose: Support 120-minute maximum by tracking split tasks
            // ====================================================================

            // Link to original task if this is a split part
            $table->foreignId('parent_task_id')
                ->nullable()
                ->after('id')
                ->constrained('tasks')
                ->onDelete('set null')
                ->comment('Original task ID if this task was split from a larger task');

            // Indicates if task was created by splitting a larger task
            $table->boolean('is_split_task')
                ->default(false)
                ->after('parent_task_id')
                ->comment('True if this task was split from a task exceeding 120 minutes');

            // Which part number (1, 2, 3, etc.) if this is a split task
            $table->integer('part_number')
                ->nullable()
                ->after('is_split_task')
                ->comment('Part number if split task (1, 2, 3...)');

            // Total number of parts the original task was split into
            $table->integer('total_parts')
                ->nullable()
                ->after('part_number')
                ->comment('Total parts if split task (e.g., 3 for "Part 1 of 3")');

            // ====================================================================
            // PHASE 2: Learning Experience Enhancement
            // Purpose: Better learning outcomes and searchability
            // ====================================================================

            // Specific learning outcomes for this task
            $table->json('learning_objectives')
                ->nullable()
                ->after('description')
                ->comment('Array of specific learning outcomes (e.g., ["Understand CSS Grid", "Build responsive layout"])');

            // Skills and technologies gained from this task
            $table->json('skills_gained')
                ->nullable()
                ->after('learning_objectives')
                ->comment('Array of skills/technologies learned (e.g., ["React Hooks", "API Integration"])');

            // Searchable tags for content organization
            $table->json('tags')
                ->nullable()
                ->after('category')
                ->comment('Array of tags for search/filtering (e.g., ["frontend", "responsive", "css-grid"])');

            // Task-level difficulty (more granular than roadmap-level)
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced'])
                ->default('beginner')
                ->after('task_type')
                ->comment('Task-specific difficulty level');

            // ====================================================================
            // PHASE 3: Analytics & Performance Metrics
            // Purpose: Track task effectiveness and identify improvements
            // ====================================================================

            // Cached average actual completion time from student data
            $table->integer('actual_avg_time_minutes')
                ->nullable()
                ->after('estimated_time_minutes')
                ->comment('Calculated average actual time from student completions (cached)');

            // Total number of times task has been completed
            $table->integer('completion_count')
                ->default(0)
                ->after('has_quality_rating')
                ->comment('Total completions (cached, updated via events)');

            // Average quality rating from students
            $table->decimal('average_rating', 3, 2)
                ->nullable()
                ->after('completion_count')
                ->comment('Average quality rating 1-10 (cached, updated via events)');

            // Number of times task was skipped
            $table->integer('skip_count')
                ->default(0)
                ->after('average_rating')
                ->comment('Times task was skipped (cached)');

            // ====================================================================
            // Indexes for Performance Optimization
            // ====================================================================

            $table->index('parent_task_id', 'idx_tasks_parent_id');
            $table->index('is_split_task', 'idx_tasks_is_split');
            $table->index('difficulty_level', 'idx_tasks_difficulty');
            $table->index('completion_count', 'idx_tasks_completion_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Drop foreign key constraint FIRST (before dropping related index)
            $table->dropForeign(['parent_task_id']);

            // Then drop indexes
            $table->dropIndex('idx_tasks_parent_id');
            $table->dropIndex('idx_tasks_is_split');
            $table->dropIndex('idx_tasks_difficulty');
            $table->dropIndex('idx_tasks_completion_count');

            // Finally drop columns in reverse order
            $table->dropColumn([
                'skip_count',
                'average_rating',
                'completion_count',
                'actual_avg_time_minutes',
                'difficulty_level',
                'tags',
                'skills_gained',
                'learning_objectives',
                'total_parts',
                'part_number',
                'is_split_task',
                'parent_task_id',
            ]);
        });
    }
};
