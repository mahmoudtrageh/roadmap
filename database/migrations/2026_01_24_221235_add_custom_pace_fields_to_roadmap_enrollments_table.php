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
        Schema::table('roadmap_enrollments', function (Blueprint $table) {
            $table->integer('weekly_hours')->default(10)->after('status');
            $table->json('auto_schedule')->nullable()->after('weekly_hours');
            $table->timestamp('paused_at')->nullable()->after('auto_schedule');
            $table->text('pause_reason')->nullable()->after('paused_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roadmap_enrollments', function (Blueprint $table) {
            $table->dropColumn(['weekly_hours', 'auto_schedule', 'paused_at', 'pause_reason']);
        });
    }
};
