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
            $table->json('custom_schedule')->nullable()->after('current_day');
            $table->integer('custom_total_days')->nullable()->after('custom_schedule');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roadmap_enrollments', function (Blueprint $table) {
            $table->dropColumn(['custom_schedule', 'custom_total_days']);
        });
    }
};
