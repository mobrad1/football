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
            $table->string('role')->default('player');
            $table->string('position')->nullable();
            $table->integer('self_rating')->nullable();
            $table->integer('xp_cost')->nullable();
            $table->string('status')->default('free');
            $table->foreignId('team_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('coins')->default(0);
            $table->integer('xp_remaining')->default(0);
            $table->integer('xp_purchased')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'position',
                'self_rating',
                'xp_cost',
                'status',
                'team_id',
                'coins',
                'xp_remaining',
                'xp_purchased',
            ]);
        });
    }
};
