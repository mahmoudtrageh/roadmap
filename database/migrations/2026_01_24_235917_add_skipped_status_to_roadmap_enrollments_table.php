<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the enum to add 'skipped' status
        DB::statement("ALTER TABLE roadmap_enrollments MODIFY COLUMN status ENUM('active', 'paused', 'completed', 'abandoned', 'skipped') DEFAULT 'active'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'skipped' from enum
        DB::statement("ALTER TABLE roadmap_enrollments MODIFY COLUMN status ENUM('active', 'paused', 'completed', 'abandoned') DEFAULT 'active'");
    }
};
