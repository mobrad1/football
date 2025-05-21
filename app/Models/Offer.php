<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'captain_id',
        'status',
    ];

    /**
     * Get the player that received the offer.
     */
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    /**
     * Get the captain that sent the offer.
     */
    public function captain()
    {
        return $this->belongsTo(User::class, 'captain_id');
    }
}
