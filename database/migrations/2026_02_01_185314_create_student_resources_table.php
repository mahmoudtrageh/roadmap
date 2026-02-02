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
        Schema::create('student_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('url');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type')->default('article'); // article, video, tutorial, etc.
            $table->integer('helpful_count')->default(0); // Number of students who found it helpful
            $table->boolean('is_approved')->default(true); // For moderation (future feature)
            $table->timestamps();

            $table->index(['task_id', 'is_approved']);
        });

        // Table to track which students found a resource helpful
        Schema::create('student_resource_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_resource_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_helpful')->default(true);
            $table->timestamps();

            $table->unique(['student_resource_id', 'student_id']); // One vote per student per resource
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_resource_votes');
        Schema::dropIfExists('student_resources');
    }
};
