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
        if (Schema::hasColumn('task_completions', 'self_notes')) {
            Schema::table('task_completions', function (Blueprint $table) {
                $table->dropColumn('self_notes');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_completions', function (Blueprint $table) {
            $table->text('self_notes')->nullable();
        });
    }
};
