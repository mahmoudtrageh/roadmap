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
        Schema::create('task_hints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->json('hints'); // Array of hints with level and text
            $table->text('introduction')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('task_id');
        });

        // Track which hints students have revealed
        Schema::create('student_hint_usage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained('roadmap_enrollments')->onDelete('cascade');
            $table->integer('hints_revealed')->default(0); // How many hints revealed
            $table->json('revealed_at')->nullable(); // Timestamps of when each hint was revealed
            $table->timestamps();

            $table->index(['student_id', 'task_id', 'enrollment_id'], 'hint_usage_student_idx');
            $table->unique(['student_id', 'task_id', 'enrollment_id'], 'hint_usage_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_hint_usage');
        Schema::dropIfExists('task_hints');
    }
};
