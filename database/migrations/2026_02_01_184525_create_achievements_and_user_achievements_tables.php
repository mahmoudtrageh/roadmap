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
        // Achievements table - defines available achievements
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // e.g., 'first_task', 'tasks_10', 'streak_7'
            $table->string('name'); // Display name
            $table->text('description');
            $table->string('icon')->nullable(); // Emoji or icon class
            $table->string('category'); // 'milestone', 'streak', 'quality', 'time'
            $table->integer('requirement_value')->nullable(); // e.g., 10 for '10 tasks'
            $table->string('badge_color')->default('blue'); // For UI styling
            $table->integer('points')->default(0); // Optional points value
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // User achievements - tracks which users earned which achievements
        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('achievement_id')->constrained()->onDelete('cascade');
            $table->timestamp('earned_at')->useCurrent();
            $table->json('metadata')->nullable(); // Store extra data like task count at time of earning
            $table->timestamps();

            $table->unique(['user_id', 'achievement_id']); // Can't earn same achievement twice
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('achievements');
    }
};
