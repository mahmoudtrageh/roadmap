<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update Full Stack Capstone to order 14 and remove prerequisite
        DB::table('roadmaps')
            ->where('slug', 'fullstack-capstone')
            ->update([
                'order' => 14,
                'prerequisite_roadmap_id' => null
            ]);

        // Update Algorithms & DS to order 15 and remove prerequisite
        DB::table('roadmaps')
            ->where('slug', 'algorithms-data-structures-mastery')
            ->update([
                'order' => 15,
                'prerequisite_roadmap_id' => null
            ]);

        // Update CV & Interview to order 16 and remove prerequisite
        DB::table('roadmaps')
            ->where('slug', 'cv-interview-skills')
            ->update([
                'order' => 16,
                'prerequisite_roadmap_id' => null
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert order changes
        DB::table('roadmaps')
            ->where('slug', 'fullstack-capstone')
            ->update(['order' => 9]);

        DB::table('roadmaps')
            ->where('slug', 'algorithms-data-structures-mastery')
            ->update(['order' => 13]);

        DB::table('roadmaps')
            ->where('slug', 'cv-interview-skills')
            ->update(['order' => 13]);
    }
};
