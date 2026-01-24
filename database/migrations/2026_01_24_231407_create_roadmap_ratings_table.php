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
        Schema::create('roadmap_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('roadmap_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned()->comment('1-5 stars');
            $table->text('review')->nullable();
            $table->timestamps();

            // Ensure one rating per student per roadmap
            $table->unique(['student_id', 'roadmap_id']);
        });

        // Add average rating and rating count to roadmaps table
        Schema::table('roadmaps', function (Blueprint $table) {
            $table->decimal('average_rating', 3, 2)->default(0)->after('description');
            $table->unsignedInteger('rating_count')->default(0)->after('average_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roadmaps', function (Blueprint $table) {
            $table->dropColumn(['average_rating', 'rating_count']);
        });

        Schema::dropIfExists('roadmap_ratings');
    }
};
