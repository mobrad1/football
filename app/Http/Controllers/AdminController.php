<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $totalPlayers = User::where('role', 'player')->count();
        $totalCaptains = User::where('role', 'captain')->count();
        $freePlayers = User::where('role', 'player')->where('status', 'free')->count();
        $draftedPlayers = User::where('role', 'player')->where('status', 'drafted')->count();
        $paidPlayers = User::where('role', 'player')->where('payment_status', 'paid')->count();
        $paidCaptains = User::where('role', 'captain')->where('payment_status', 'paid')->count();
        
        $recentPlayers = User::where('role', 'player')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
        
        return view('admin.dashboard', compact(
            'totalPlayers', 
            'totalCaptains', 
            'freePlayers', 
            'draftedPlayers',
            'paidPlayers',
            'paidCaptains',
            'recentPlayers'
        ));
    }

    /**
     * Show all players with filters.
     */
    public function players(Request $request)
    {
        $query = User::where('role', 'player');
        
        // Apply filters
        if ($request->has('search') && $request->search !== '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('position') && $request->position !== '') {
            $query->where('position', $request->position);
        }
        
        if ($request->has('payment_status') && $request->payment_status !== '') {
            $query->where('payment_status', $request->payment_status);
        }
        
        $players = $query->with('team')->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.players', compact('players'));
    }

    /**
     * Show all captains.
     */
    public function captains()
    {
        $captains = User::where('role', 'captain')
                       ->with('team')
                       ->orderBy('created_at', 'desc')
                       ->get();
        
        return view('admin.captains', compact('captains'));
    }

    /**
     * Show form to register a new player.
     */
    public function showRegisterPlayer()
    {
        return view('admin.register-player');
    }

    /**
     * Register a new player.
     */
    public function registerPlayer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'position' => ['required', Rule::in(['GK', 'DEF', 'MID', 'FWD'])],
            'self_rating' => 'required|integer|min:1|max:100',
            'xp_cost' => 'required|integer|min:1|max:200',
            'payment_status' => ['required', Rule::in(['pending', 'paid', 'failed'])],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('player-photos', 'public');
        }

        $player = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'player',
            'position' => $validated['position'],
            'self_rating' => $validated['self_rating'],
            'xp_cost' => $validated['xp_cost'],
            'status' => 'free',
            'payment_status' => $validated['payment_status'],
            'photo' => $photoPath,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.players')
                        ->with('success', 'Player registered successfully: ' . $player->name);
    }

    /**
     * Show form to register a new captain.
     */
    public function showRegisterCaptain()
    {
        return view('admin.register-captain');
    }

    /**
     * Register a new captain.
     */
    public function registerCaptain(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'xp_remaining' => 'required|integer|min:100|max:1000',
            'coins' => 'required|integer|min:100|max:2000',
            'payment_status' => ['required', Rule::in(['pending', 'paid', 'failed'])],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('captain-photos', 'public');
        }

        $captain = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'captain',
            'xp_remaining' => $validated['xp_remaining'],
            'coins' => $validated['coins'],
            'payment_status' => $validated['payment_status'],
            'photo' => $photoPath,
            'email_verified_at' => now(),
        ]);

        // Create team for captain
        $team = Team::create([
            'name' => $captain->name . "'s Team",
            'captain_id' => $captain->id,
            'xp_remaining' => $captain->xp_remaining,
            'xp_total' => $captain->xp_remaining,
        ]);

        $captain->update(['team_id' => $team->id]);

        return redirect()->route('admin.captains')
                        ->with('success', 'Captain registered successfully: ' . $captain->name);
    }

    /**
     * Update payment status for a user.
     */
    public function updatePaymentStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'payment_status' => ['required', Rule::in(['pending', 'paid', 'failed'])],
        ]);

        $user->update(['payment_status' => $validated['payment_status']]);

        return redirect()->back()
                        ->with('success', 'Payment status updated for ' . $user->name);
    }

    /**
     * Show form to convert player to captain.
     */
    public function showConvertToCapt(User $player)
    {
        if ($player->role !== 'player') {
            return redirect()->route('admin.players')
                            ->with('error', 'Only players can be converted to captains.');
        }

        return view('admin.convert-to-captain', compact('player'));
    }

    /**
     * Convert a player to captain.
     */
    public function convertToCapt(Request $request, User $player)
    {
        if ($player->role !== 'player') {
            return redirect()->route('admin.players')
                            ->with('error', 'Only players can be converted to captains.');
        }

        $validated = $request->validate([
            'xp_remaining' => 'required|integer|min:100|max:1000',
            'coins' => 'required|integer|min:100|max:2000',
            'payment_status' => ['required', Rule::in(['pending', 'paid', 'failed'])],
            'confirm' => 'required|accepted',
        ]);

        // Update player to captain - do this in a transaction for safety
        DB::transaction(function () use ($player, $validated) {
            // Update player to captain
            $player->update([
                'role' => 'captain',
                'xp_remaining' => $validated['xp_remaining'],
                'coins' => $validated['coins'],
                'payment_status' => $validated['payment_status'],
                'position' => null,
                'self_rating' => null,
                'xp_cost' => null,
                'status' => null,
                'team_id' => null,
            ]);

            // Create team for the new captain
            $team = Team::create([
                'name' => $player->name . "'s Team",
                'captain_id' => $player->id,
                'xp_remaining' => $player->xp_remaining,
                'xp_total' => $player->xp_remaining,
            ]);

            $player->update(['team_id' => $team->id]);
        });

        return redirect()->route('admin.captains')
                        ->with('success', $player->name . ' has been successfully converted to a captain with ' . $validated['xp_remaining'] . ' XP.');
    }

    /**
     * Delete a user.
     */
    public function deleteUser(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->back()
                            ->with('error', 'Cannot delete admin users.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->back()
                        ->with('success', 'User deleted: ' . $userName);
    }
} 