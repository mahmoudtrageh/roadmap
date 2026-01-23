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
        Schema::create('monthly_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained('roadmap_enrollments')->onDelete('cascade');
            $table->integer('month_number');
            $table->date('month_start_date');
            $table->date('month_end_date');
            $table->boolean('goals_completed')->default(false);
            $table->text('code_comparison')->nullable();
            $table->text('needs_more_practice')->nullable();
            $table->boolean('ready_for_next_month')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_reviews');
    }
};
