<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);
        
        // Create a captain
        User::factory()->create([
            'name' => 'Captain User',
            'email' => 'captain@example.com',
            'role' => 'captain',
            'xp_remaining' => 400,
            'coins' => 500,
        ]);
        
        // Create some players
        User::factory()->create([
            'name' => 'Test Player',
            'email' => 'player@example.com',
            'role' => 'player',
            'position' => 'MID',
            'self_rating' => 85,
            'xp_cost' => 75,
            'status' => 'free',
        ]);
        
        // Create more players with different positions
        User::factory()->create([
            'name' => 'Goalkeeper',
            'email' => 'gk@example.com',
            'role' => 'player',
            'position' => 'GK',
            'self_rating' => 90,
            'xp_cost' => 85,
            'status' => 'free',
        ]);
        
        User::factory()->create([
            'name' => 'Defender',
            'email' => 'def@example.com',
            'role' => 'player',
            'position' => 'DEF',
            'self_rating' => 82,
            'xp_cost' => 70,
            'status' => 'free',
        ]);
        
        User::factory()->create([
            'name' => 'Forward',
            'email' => 'fwd@example.com',
            'role' => 'player',
            'position' => 'FWD',
            'self_rating' => 88,
            'xp_cost' => 90,
            'status' => 'free',
        ]);
    }
}
