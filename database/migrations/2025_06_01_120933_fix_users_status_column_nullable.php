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
        Schema::table('users', function (Blueprint $table) {
            // Make status nullable for captains and admins
            $table->string('status')->nullable()->change();
            
            // Also make other player-specific fields nullable
            $table->string('position')->nullable()->change();
            $table->integer('self_rating')->nullable()->change();
            $table->integer('xp_cost')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Note: We can't easily revert nullable changes in SQLite
            // This is mainly for documentation purposes
        });
    }
};