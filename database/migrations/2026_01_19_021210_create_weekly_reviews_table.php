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
        Schema::create('weekly_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained('roadmap_enrollments')->onDelete('cascade');
            $table->integer('week_number');
            $table->date('week_start_date');
            $table->date('week_end_date');
            $table->text('what_learned')->nullable();
            $table->text('applied_to_code')->nullable();
            $table->text('next_week_focus')->nullable();
            $table->integer('code_quality_rating')->nullable();
            $table->text('improvements')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_reviews');
    }
};
