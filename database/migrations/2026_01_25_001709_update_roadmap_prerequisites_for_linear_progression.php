<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update roadmap prerequisites to create a linear progression
        // Each roadmap now requires the previous roadmap in order

        $roadmaps = DB::table('roadmaps')->orderBy('order')->get(['id', 'order']);

        $previousId = null;
        foreach ($roadmaps as $roadmap) {
            if ($previousId) {
                DB::table('roadmaps')
                    ->where('id', $roadmap->id)
                    ->update(['prerequisite_roadmap_id' => $previousId]);
            } else {
                // First roadmap has no prerequisite
                DB::table('roadmaps')
                    ->where('id', $roadmap->id)
                    ->update(['prerequisite_roadmap_id' => null]);
            }
            $previousId = $roadmap->id;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is destructive - can't easily reverse
        // Would need to restore original prerequisite structure manually
    }
};
