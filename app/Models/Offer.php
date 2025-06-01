<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'captain_id',
        'player_id',
        'xp_cost',
        'status', // 'pending', 'accepted', 'rejected'
    ];

    /**
     * Get the captain who made the offer.
     */
    public function captain()
    {
        return $this->belongsTo(User::class, 'captain_id');
    }

    /**
     * Get the player who received the offer.
     */
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}
