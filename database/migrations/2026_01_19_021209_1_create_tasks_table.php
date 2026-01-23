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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('roadmap_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->integer('day_number');
            $table->integer('estimated_time_minutes')->default(60);
            $table->enum('task_type', ['reading', 'video', 'exercise', 'project', 'quiz'])->default('exercise');
            $table->string('category')->nullable();
            $table->integer('order')->default(0);
            $table->json('resources_links')->nullable();
            $table->boolean('has_code_submission')->default(false);
            $table->boolean('has_quality_rating')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
