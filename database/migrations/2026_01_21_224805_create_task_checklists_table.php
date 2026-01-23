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
        Schema::create('task_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->json('items'); // Array of checklist items
            $table->text('description')->nullable(); // Optional description of the checklist
            $table->boolean('is_active')->default(true); // Can deactivate old checklists
            $table->timestamps();

            $table->index('task_id');
        });

        // Table to track student's checklist progress
        Schema::create('student_checklist_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('task_checklist_id')->constrained('task_checklists')->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained('roadmap_enrollments')->onDelete('cascade');
            $table->json('checked_items')->nullable(); // Array of checked item indices [0, 2, 4]
            $table->integer('completion_percentage')->default(0); // 0-100
            $table->timestamps();

            $table->unique(['student_id', 'task_checklist_id', 'enrollment_id'], 'student_checklist_unique');
            $table->index(['student_id', 'enrollment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_checklist_progress');
        Schema::dropIfExists('task_checklists');
    }
};
