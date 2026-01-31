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
        // Update all translation tasks to have quality rating enabled
        DB::table('tasks')
            ->where('category', 'Translation')
            ->update(['has_quality_rating' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert translation tasks to not have quality rating
        DB::table('tasks')
            ->where('category', 'Translation')
            ->update(['has_quality_rating' => false]);
    }
};
