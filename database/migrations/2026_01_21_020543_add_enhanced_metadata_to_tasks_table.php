<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Success criteria - checklist items for task completion
            $table->json('success_criteria')->nullable()->after('skills_gained');

            // Common mistakes - pitfalls to avoid
            $table->text('common_mistakes')->nullable()->after('success_criteria');

            // Quick tips - practical tips for success
            $table->text('quick_tips')->nullable()->after('common_mistakes');

            // Prerequisites - task IDs that must be completed first
            $table->json('prerequisites')->nullable()->after('quick_tips');

            // Recommended tasks - helpful but not required task IDs
            $table->json('recommended_tasks')->nullable()->after('prerequisites');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn([
                'success_criteria',
                'common_mistakes',
                'quick_tips',
                'prerequisites',
                'recommended_tasks'
            ]);
        });
    }
};
