<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_as_players(): void
    {
        Storage::fake('public');
        
        $file = UploadedFile::fake()->image('player.jpg');
        
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'position' => 'MID',
            'self_rating' => 80,
            'xp_cost' => 65,
            'photo' => $file,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
        
        // Check that the user was created with the correct role and attributes
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'player',
            'position' => 'MID',
            'self_rating' => 80,
            'xp_cost' => 65,
            'status' => 'free',
        ]);
        
        // Get the created user
        $user = \App\Models\User::where('email', 'test@example.com')->first();
        
        // Check that the photo was stored
        $this->assertNotNull($user->photo);
        Storage::disk('public')->assertExists($user->photo);
    }
}
