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
        $offers = $player->receivedOffers()->with('captain')->orderBy('created_at', 'desc')->get();
        
        return view('player.dashboard', compact('player', 'offers'));
    }

    /**
     * Update the player's profile.
     */
    public function updateProfile(Request $request)
    {
        $player = Auth::user();
        
        // Only allow updates if player is free
        if ($player->status !== 'free') {
            return redirect()->back()->with('error', 'You cannot update your profile after being drafted.');
        }
        
        $validated = $request->validate([
            'position' => ['required', Rule::in(['GK', 'DEF', 'MID', 'FWD'])],
            'self_rating' => 'required|integer|min:1|max:100',
            'xp_cost' => 'required|integer|min:1|max:200',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($player->photo && Storage::disk('public')->exists($player->photo)) {
                Storage::disk('public')->delete($player->photo);
            }
            
            // Store new photo
            $photoPath = $request->file('photo')->store('player-photos', 'public');
            $validated['photo'] = $photoPath;
        }

        // Update player profile
        $player->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Respond to an offer.
     */
    public function respondToOffer(Request $request, Offer $offer)
    {
        $player = Auth::user();
        
        // Check if the offer belongs to this player
        if ($offer->player_id !== $player->id) {
            return redirect()->back()->with('error', 'This offer does not belong to you.');
        }
        
        // Check if offer is still pending
        if ($offer->status !== 'pending') {
            return redirect()->back()->with('error', 'This offer has already been responded to.');
        }
        
        $response = $request->input('response', $request->query('response'));
        
        if ($response === 'accept') {
            // Accept the offer
            $offer->update(['status' => 'accepted']);
            
            // Update player status and team
            $player->update([
                'status' => 'drafted',
                'team_id' => $offer->captain->team_id
            ]);
            
            // Reject all other pending offers for this player
            Offer::where('player_id', $player->id)
                 ->where('status', 'pending')
                 ->where('id', '!=', $offer->id)
                 ->update(['status' => 'rejected']);
            
            // Deduct XP from captain
            $captain = $offer->captain;
            $captain->update([
                'xp_remaining' => $captain->xp_remaining - $offer->xp_cost
            ]);
            
            // Update team XP
            if ($captain->team) {
                $captain->team->update([
                    'xp_remaining' => $captain->xp_remaining
                ]);
            }
            
            return redirect()->back()->with('success', 'Offer accepted! You have been drafted by ' . $offer->captain->name);
            
        } elseif ($response === 'reject') {
            // Reject the offer
            $offer->update(['status' => 'rejected']);
            
            return redirect()->back()->with('success', 'Offer rejected.');
        }
        
        return redirect()->back()->with('error', 'Invalid response.');
    }
}
