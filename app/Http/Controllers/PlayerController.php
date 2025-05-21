<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PlayerController extends Controller
{
    /**
     * Display the player dashboard.
     */
    public function dashboard()
    {
        $player = Auth::user();
        $offers = $player->receivedOffers()->with('captain')->get();
        
        return view('player.dashboard', compact('player', 'offers'));
    }

    /**
     * Update player profile.
     */
    public function updateProfile(Request $request)
    {
        $player = Auth::user();
        
        // Only allow updates if player is not drafted
        if ($player->status !== 'free') {
            return redirect()->route('player.dashboard')
                ->with('error', 'You cannot update your profile after being drafted.');
        }
        
        $validated = $request->validate([
            'position' => ['required', Rule::in(['GK', 'DEF', 'MID', 'FWD'])],
            'self_rating' => 'required|integer|min:1|max:100',
            'xp_cost' => 'required|integer|min:1|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($player->photo) {
                Storage::disk('public')->delete($player->photo);
            }
            
            $validated['photo'] = $request->file('photo')->store('player-photos', 'public');
        }
        
        $player->update($validated);
        
        return redirect()->route('player.dashboard')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Respond to an offer.
     */
    public function respondToOffer(Request $request, Offer $offer)
    {
        $player = Auth::user();
        
        // Ensure the offer belongs to this player
        if ($offer->player_id !== $player->id) {
            return redirect()->route('player.dashboard')
                ->with('error', 'This offer does not belong to you.');
        }
        
        // Ensure the player is not already drafted
        if ($player->status !== 'free') {
            return redirect()->route('player.dashboard')
                ->with('error', 'You have already been drafted.');
        }
        
        $validated = $request->validate([
            'response' => ['required', Rule::in(['accept', 'reject'])],
        ]);
        
        if ($validated['response'] === 'accept') {
            // Check if captain has enough XP
            $captain = $offer->captain;
            if ($captain->xp_remaining < $player->xp_cost) {
                return redirect()->route('player.dashboard')
                    ->with('error', 'The captain does not have enough XP to draft you.');
            }
            
            // Update offer status
            $offer->update(['status' => 'accepted']);
            
            // Update player status
            $player->update([
                'status' => 'drafted',
                'team_id' => $captain->team->id,
            ]);
            
            // Deduct XP from captain
            $captain->update([
                'xp_remaining' => $captain->xp_remaining - $player->xp_cost,
            ]);
            
            // Reject all other offers for this player
            Offer::where('player_id', $player->id)
                ->where('id', '!=', $offer->id)
                ->update(['status' => 'rejected']);
                
            return redirect()->route('player.dashboard')
                ->with('success', 'You have accepted the offer and joined the team.');
        } else {
            // Update offer status to rejected
            $offer->update(['status' => 'rejected']);
            
            return redirect()->route('player.dashboard')
                ->with('success', 'You have rejected the offer.');
        }
    }
}
