<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CaptainController extends Controller
{
    /**
     * Display the captain dashboard.
     */
    public function dashboard()
    {
        $captain = Auth::user();
        
        // Get or create team for captain
        $team = $captain->team ?? $this->createTeamForCaptain($captain);
        
        $teamPlayers = User::where('team_id', $team->id)
                          ->where('role', 'player')
                          ->get();
        
        $sentOffers = $captain->sentOffers()
                             ->with('player')
                             ->orderBy('created_at', 'desc')
                             ->get();
        
        $availablePlayers = User::where('role', 'player')
                               ->where('status', 'free')
                               ->orderBy('self_rating', 'desc')
                               ->get();
        
        return view('captain.dashboard', compact(
            'captain', 
            'team', 
            'teamPlayers', 
            'sentOffers', 
            'availablePlayers'
        ));
    }

    /**
     * Show available players for drafting.
     */
    public function players(Request $request)
    {
        $query = User::where('role', 'player')->where('status', 'free');
        
        // Filter by position
        if ($request->has('position') && $request->position !== '') {
            $query->where('position', $request->position);
        }
        
        // Filter by rating range
        if ($request->has('min_rating') && $request->min_rating !== '') {
            $query->where('self_rating', '>=', $request->min_rating);
        }
        
        if ($request->has('max_rating') && $request->max_rating !== '') {
            $query->where('self_rating', '<=', $request->max_rating);
        }
        
        // Filter by XP cost range
        if ($request->has('max_xp_cost') && $request->max_xp_cost !== '') {
            $query->where('xp_cost', '<=', $request->max_xp_cost);
        }
        
        $players = $query->orderBy('self_rating', 'desc')->paginate(20);
        
        return view('captain.players', compact('players'));
    }

    /**
     * Make an offer to a player.
     */
    public function makeOffer(Request $request, User $player)
    {
        $captain = Auth::user();
        
        // Check if player is available
        if ($player->status !== 'free') {
            return redirect()->back()->with('error', 'This player is no longer available.');
        }
        
        // Check if captain has enough XP
        if ($captain->xp_remaining < $player->xp_cost) {
            return redirect()->back()->with('error', 'You do not have enough XP to make this offer.');
        }
        
        // Check if offer already exists
        $existingOffer = Offer::where('captain_id', $captain->id)
                             ->where('player_id', $player->id)
                             ->where('status', 'pending')
                             ->first();
        
        if ($existingOffer) {
            return redirect()->back()->with('error', 'You have already made an offer to this player.');
        }
        
        // Create the offer
        Offer::create([
            'captain_id' => $captain->id,
            'player_id' => $player->id,
            'xp_cost' => $player->xp_cost,
            'status' => 'pending',
        ]);
        
        return redirect()->back()->with('success', 'Offer sent successfully to ' . $player->name);
    }

    /**
     * Create a team for the captain if they don't have one.
     */
    private function createTeamForCaptain($captain)
    {
        $team = Team::create([
            'name' => $captain->name . "'s Team",
            'captain_id' => $captain->id,
            'xp_remaining' => $captain->xp_remaining ?? 400,
            'xp_total' => $captain->xp_remaining ?? 400,
        ]);
        
        $captain->update(['team_id' => $team->id]);
        
        return $team;
    }
} 