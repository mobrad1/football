<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('teams', 'captain_id')) {
                $table->foreignId('captain_id')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('teams', 'xp_remaining')) {
                $table->integer('xp_remaining')->default(400);
            }
            if (!Schema::hasColumn('teams', 'xp_total')) {
                $table->integer('xp_total')->default(400);
            }
        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign(['captain_id']);
            $table->dropColumn(['captain_id', 'xp_remaining', 'xp_total']);
        });
    }
}; 