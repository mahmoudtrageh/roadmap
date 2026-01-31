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
        // Drop leaderboard-related columns from users table
        if (Schema::hasColumn('users', 'show_on_leaderboard')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('show_on_leaderboard');
            });
        }

        if (Schema::hasColumn('users', 'leaderboard_display_name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('leaderboard_display_name');
            });
        }

        // Drop points and levels columns from users table
        if (Schema::hasColumn('users', 'total_points')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('total_points');
            });
        }

        if (Schema::hasColumn('users', 'current_level')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('current_level');
            });
        }

        if (Schema::hasColumn('users', 'level_title')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('level_title');
            });
        }

        // Drop certificates table
        Schema::dropIfExists('certificates');

        // Drop achievements tables
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('achievements');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate leaderboard columns
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('show_on_leaderboard')->default(false)->after('theme_preference');
            $table->string('leaderboard_display_name', 100)->nullable()->after('show_on_leaderboard');
        });

        // Recreate points and levels columns
        Schema::table('users', function (Blueprint $table) {
            $table->integer('total_points')->default(0)->after('daily_study_hours');
            $table->integer('current_level')->default(1)->after('total_points');
            $table->string('level_title')->default('Beginner')->after('current_level');
        });

        // Recreate certificates table
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('roadmap_id')->constrained()->onDelete('cascade');
            $table->string('certificate_code')->unique();
            $table->string('file_path');
            $table->timestamp('issued_at');
            $table->timestamps();
        });

        // Recreate achievements tables
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('icon')->nullable();
            $table->string('category');
            $table->json('criteria');
            $table->integer('points')->default(0);
            $table->timestamps();
        });

        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('achievement_id')->constrained()->onDelete('cascade');
            $table->timestamp('earned_at');
            $table->timestamps();

            $table->unique(['user_id', 'achievement_id']);
        });
    }
};
