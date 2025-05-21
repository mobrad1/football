<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'player', 'captain', 'admin'
        'position',
        'self_rating',
        'xp_cost',
        'status', // 'free', 'drafted'
        'team_id',
        'coins',
        'xp_remaining',
        'xp_purchased',
        'photo',
        'payment_status',
        'payment_reference',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'self_rating' => 'integer',
            'xp_cost' => 'integer',
            'coins' => 'integer',
            'xp_remaining' => 'integer',
            'xp_purchased' => 'integer',
        ];
    }

    /**
     * Get the player's photo URL.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Check if the user is a player.
     *
     * @return bool
     */
    public function isPlayer(): bool
    {
        return $this->role === 'player';
    }

    /**
     * Check if the user is a captain.
     *
     * @return bool
     */
    public function isCaptain(): bool
    {
        return $this->role === 'captain';
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the offers received by this player.
     */
    public function receivedOffers()
    {
        return $this->hasMany(Offer::class, 'player_id');
    }

    /**
     * Get the offers sent by this captain.
     */
    public function sentOffers()
    {
        return $this->hasMany(Offer::class, 'captain_id');
    }

    /**
     * Get the team this player belongs to.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
