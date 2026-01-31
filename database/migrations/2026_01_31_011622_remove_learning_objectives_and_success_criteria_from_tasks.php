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
        // Update all tasks to have empty learning_objectives and success_criteria
        DB::table('tasks')->update([
            'learning_objectives' => json_encode([]),
            'success_criteria' => json_encode([])
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reversal needed - we can't restore the original data
    }
};
