<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'player',
            'position' => fake()->randomElement(['GK', 'DEF', 'MID', 'FWD']),
            'self_rating' => fake()->numberBetween(60, 95),
            'xp_cost' => fake()->numberBetween(50, 100),
            'status' => 'free',
            'photo' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
    
    /**
     * Configure the model as a captain.
     */
    public function captain(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'captain',
            'xp_remaining' => 400,
            'coins' => 500,
            'position' => null,
            'self_rating' => null,
            'xp_cost' => null,
        ]);
    }
    
    /**
     * Configure the model as an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'position' => null,
            'self_rating' => null,
            'xp_cost' => null,
        ]);
    }
}
