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
        Schema::create('task_examples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('code');
            $table->string('language', 50)->default('javascript');
            $table->string('difficulty')->default('beginner'); // beginner, intermediate, advanced
            $table->integer('order')->default(0);
            $table->text('explanation')->nullable();
            $table->text('output')->nullable(); // Expected output or result
            $table->boolean('is_interactive')->default(false); // Future: allow running code
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['task_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_examples');
    }
};
