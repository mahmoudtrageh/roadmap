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
        Schema::create('community_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->string('category')->default('general'); // general, issue, question, achievement, tip
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_resolved')->default(false); // for issues/questions
            $table->timestamps();

            $table->index(['category', 'created_at']);
            $table->index(['is_pinned', 'created_at']);
        });

        Schema::create('community_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('community_posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->integer('likes_count')->default(0);
            $table->boolean('is_solution')->default(false); // for marking helpful answers
            $table->timestamps();

            $table->index(['post_id', 'created_at']);
        });

        Schema::create('community_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('likeable_type'); // Post or Comment
            $table->unsignedBigInteger('likeable_id');
            $table->timestamps();

            $table->unique(['user_id', 'likeable_type', 'likeable_id']);
            $table->index(['likeable_type', 'likeable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_likes');
        Schema::dropIfExists('community_comments');
        Schema::dropIfExists('community_posts');
    }
};
