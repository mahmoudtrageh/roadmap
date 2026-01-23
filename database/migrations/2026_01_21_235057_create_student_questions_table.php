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
        Schema::create('student_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained('roadmap_enrollments')->onDelete('cascade');
            $table->text('question');
            $table->text('answer')->nullable(); // For future: admin/instructor answers
            $table->string('status')->default('pending'); // pending, answered, archived
            $table->foreignId('answered_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('answered_at')->nullable();
            $table->boolean('is_public')->default(false); // Can be shared with other students
            $table->integer('helpful_count')->default(0); // How many students found this helpful
            $table->timestamps();

            $table->index(['student_id', 'enrollment_id']);
            $table->index(['task_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_questions');
    }
};
