<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'captain_id',
        'xp_remaining',
        'xp_total',
    ];

    /**
     * Get the captain of the team.
     */
    public function captain()
    {
        return $this->belongsTo(User::class, 'captain_id');
    }

    /**
     * Get the players in the team.
     */
    public function players()
    {
        return $this->hasMany(User::class, 'team_id')->where('role', 'player');
    }
}
