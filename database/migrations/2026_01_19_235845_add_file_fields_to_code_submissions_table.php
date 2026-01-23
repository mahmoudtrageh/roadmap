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
        Schema::table('code_submissions', function (Blueprint $table) {
            $table->string('original_filename')->nullable()->after('file_path');
            $table->text('submission_notes')->nullable()->after('submission_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('code_submissions', function (Blueprint $table) {
            $table->dropColumn(['original_filename', 'submission_notes']);
        });
    }
};
