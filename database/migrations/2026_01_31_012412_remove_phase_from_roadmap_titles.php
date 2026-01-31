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
        // Update roadmap titles to remove "Phase X: " prefix
        $updates = [
            'Phase 1: Foundation' => 'Foundation',
            'Phase 2: Frontend Basics' => 'Frontend Basics',
            'Phase 3: Frontend Intermediate' => 'Frontend Intermediate',
            'Phase 4: Backend Basics' => 'Backend Basics',
            'Phase 5: Backend Intermediate' => 'Backend Intermediate',
            'Phase 6: DevOps Basics' => 'DevOps Basics',
            'Phase 7: Mid-Level Skills' => 'Mid-Level Skills',
            'Phase 8: Professional Skills' => 'Professional Skills',
        ];

        foreach ($updates as $oldTitle => $newTitle) {
            DB::table('roadmaps')
                ->where('title', $oldTitle)
                ->update(['title' => $newTitle]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore phase prefixes
        $updates = [
            'Foundation' => 'Phase 1: Foundation',
            'Frontend Basics' => 'Phase 2: Frontend Basics',
            'Frontend Intermediate' => 'Phase 3: Frontend Intermediate',
            'Backend Basics' => 'Phase 4: Backend Basics',
            'Backend Intermediate' => 'Phase 5: Backend Intermediate',
            'DevOps Basics' => 'Phase 6: DevOps Basics',
            'Mid-Level Skills' => 'Phase 7: Mid-Level Skills',
            'Professional Skills' => 'Phase 8: Professional Skills',
        ];

        foreach ($updates as $oldTitle => $newTitle) {
            DB::table('roadmaps')
                ->where('title', $oldTitle)
                ->update(['title' => $newTitle]);
        }
    }
};
