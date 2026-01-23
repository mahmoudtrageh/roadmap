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
        Schema::create('resource_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('resource_url');
            $table->integer('rating')->unsigned()->comment('Rating from 1 to 5');
            $table->timestamps();

            // Ensure one rating per user per resource
            $table->unique(['task_id', 'user_id', 'resource_url']);

            // Index for faster lookups
            $table->index(['task_id', 'resource_url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_ratings');
    }
};
