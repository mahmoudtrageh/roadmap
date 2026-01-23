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
        Schema::create('student_hint_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained('roadmap_enrollments')->onDelete('cascade');
            $table->integer('hints_revealed')->default(0);
            $table->json('revealed_at')->nullable();
            $table->timestamps();

            // Unique constraint to prevent duplicate records
            $table->unique(['student_id', 'task_id', 'enrollment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_hint_usages');
    }
};
