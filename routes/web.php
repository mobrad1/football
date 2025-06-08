<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CaptainController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $players = User::where('role', 'player')
                  ->where('status', 'free')
                  ->get();
    
    return view('welcome', compact('players'));
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'captain') {
        return redirect()->route('captain.dashboard');
    } else {
        return redirect()->route('player.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Player routes
Route::middleware(['auth', 'player'])->group(function () {
    Route::get('/player/dashboard', [PlayerController::class, 'dashboard'])->name('player.dashboard');
    Route::put('/player/profile', [PlayerController::class, 'updateProfile'])->name('player.update-profile');
    Route::put('/player/offers/{offer}/respond', [PlayerController::class, 'respondToOffer'])->name('player.respond-to-offer');
});

// Captain routes
Route::middleware(['auth', 'captain'])->group(function () {
    Route::get('/captain/dashboard', [CaptainController::class, 'dashboard'])->name('captain.dashboard');
    Route::get('/captain/players', [CaptainController::class, 'players'])->name('captain.players');
    Route::post('/captain/make-offer/{player}', [CaptainController::class, 'makeOffer'])->name('captain.make-offer');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/players', [AdminController::class, 'players'])->name('admin.players');
    Route::get('/admin/captains', [AdminController::class, 'captains'])->name('admin.captains');
    Route::get('/admin/captains/{captain}/team', [AdminController::class, 'showCaptainTeam'])->name('admin.captain-team');
    
    // Captain management
    Route::get('/admin/captains/{captain}/edit', [AdminController::class, 'showEditCaptain'])->name('admin.edit-captain');
    Route::put('/admin/captains/{captain}', [AdminController::class, 'updateCaptain'])->name('admin.update-captain');
    
    // Registration routes
    Route::get('/admin/register-player', [AdminController::class, 'showRegisterPlayer'])->name('admin.register-player');
    Route::post('/admin/register-player', [AdminController::class, 'registerPlayer']);
    Route::get('/admin/register-captain', [AdminController::class, 'showRegisterCaptain'])->name('admin.register-captain');
    Route::post('/admin/register-captain', [AdminController::class, 'registerCaptain']);
    
    // Convert player to captain
    Route::get('/admin/players/{player}/convert-to-captain', [AdminController::class, 'showConvertToCapt'])->name('admin.convert-to-captain');
    Route::post('/admin/players/{player}/convert-to-captain', [AdminController::class, 'convertToCapt']);
    
    // User management
    Route::post('/admin/users/{user}/payment-status', [AdminController::class, 'updatePaymentStatus'])->name('admin.update-payment-status');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
});

Route::post('/payment/initiate', [App\Http\Controllers\PaymentController::class, 'initiatePayment'])->name('payment.initiate');
Route::get('/payment/callback', [App\Http\Controllers\PaymentController::class, 'handleCallback'])->name('payment.callback');
Route::get('/register/complete', [App\Http\Controllers\Auth\RegisteredUserController::class, 'completeRegistration'])->name('register.complete');

require __DIR__.'/auth.php';
