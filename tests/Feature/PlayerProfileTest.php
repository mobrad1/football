<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PlayerProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_can_update_profile_with_photo(): void
    {
        Storage::fake('public');
        
        $player = User::factory()->create([
            'role' => 'player',
            'position' => 'MID',
            'self_rating' => 75,
            'xp_cost' => 60,
            'status' => 'free',
        ]);
        
        $file = UploadedFile::fake()->image('new-photo.jpg');
        
        $response = $this->actingAs($player)
            ->put(route('player.update-profile'), [
                'position' => 'FWD',
                'self_rating' => 85,
                'xp_cost' => 70,
                'photo' => $file,
            ]);
        
        $response->assertRedirect(route('player.dashboard'));
        $response->assertSessionHas('success', 'Profile updated successfully.');
        
        // Refresh the player model
        $player->refresh();
        
        // Check that the attributes were updated
        $this->assertEquals('FWD', $player->position);
        $this->assertEquals(85, $player->self_rating);
        $this->assertEquals(70, $player->xp_cost);
        
        // Check that the photo was stored
        $this->assertNotNull($player->photo);
        Storage::disk('public')->assertExists($player->photo);
    }
    
    public function test_drafted_player_cannot_update_profile(): void
    {
        $player = User::factory()->create([
            'role' => 'player',
            'position' => 'MID',
            'self_rating' => 75,
            'xp_cost' => 60,
            'status' => 'drafted',
        ]);
        
        $response = $this->actingAs($player)
            ->put(route('player.update-profile'), [
                'position' => 'FWD',
                'self_rating' => 85,
                'xp_cost' => 70,
            ]);
        
        $response->assertRedirect(route('player.dashboard'));
        $response->assertSessionHas('error', 'You cannot update your profile after being drafted.');
        
        // Refresh the player model
        $player->refresh();
        
        // Check that the attributes were not updated
        $this->assertEquals('MID', $player->position);
        $this->assertEquals(75, $player->self_rating);
        $this->assertEquals(60, $player->xp_cost);
    }
} 