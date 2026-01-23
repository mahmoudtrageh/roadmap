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
        Schema::create('task_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->json('questions'); // Array of question objects
            $table->text('introduction')->nullable(); // Optional quiz intro text
            $table->integer('passing_score')->default(60); // Percentage required to pass
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('task_id');
        });

        // Table to track student quiz attempts
        Schema::create('student_quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('task_quiz_id')->constrained('task_quizzes')->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained('roadmap_enrollments')->onDelete('cascade');
            $table->json('answers')->nullable(); // Student's answers [0, 2, 1, 3, 0]
            $table->integer('score')->default(0); // Percentage score
            $table->integer('correct_count')->default(0);
            $table->integer('total_questions')->default(0);
            $table->boolean('passed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['student_id', 'task_quiz_id', 'enrollment_id'], 'quiz_attempt_student_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_quiz_attempts');
        Schema::dropIfExists('task_quizzes');
    }
};
