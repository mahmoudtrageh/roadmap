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
        Schema::table('resource_ratings', function (Blueprint $table) {
            // Drop the old unique constraint
            $table->dropUnique(['task_id', 'user_id', 'resource_url']);

            // Add resource_index column
            $table->integer('resource_index')->after('task_id')->nullable();

            // Add new unique constraint with resource_index
            $table->unique(['task_id', 'user_id', 'resource_index']);

            // Add index for faster lookups
            $table->index(['task_id', 'resource_index']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resource_ratings', function (Blueprint $table) {
            // Drop new constraints
            $table->dropUnique(['task_id', 'user_id', 'resource_index']);
            $table->dropIndex(['task_id', 'resource_index']);

            // Drop resource_index column
            $table->dropColumn('resource_index');

            // Restore old unique constraint
            $table->unique(['task_id', 'user_id', 'resource_url']);
        });
    }
};
