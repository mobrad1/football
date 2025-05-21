<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlayerController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $players = User::where('role', 'player')
                  ->orderBy('self_rating', 'desc')
                  ->get();
    
    return view('welcome', compact('players'));
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->role === 'player') {
        return redirect()->route('player.dashboard');
    } elseif ($user->role === 'captain') {
        return redirect()->route('captain.dashboard');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Player routes
Route::middleware(['auth', 'verified', 'player'])->group(function () {
    Route::get('/player/dashboard', [PlayerController::class, 'dashboard'])->name('player.dashboard');
    Route::put('/player/profile', [PlayerController::class, 'updateProfile'])->name('player.update-profile');
    Route::put('/player/offers/{offer}', [PlayerController::class, 'respondToOffer'])->name('player.respond-to-offer');
});

Route::post('/payment/initiate', [App\Http\Controllers\PaymentController::class, 'initiatePayment'])->name('payment.initiate');
Route::get('/payment/callback', [App\Http\Controllers\PaymentController::class, 'handleCallback'])->name('payment.callback');
Route::get('/register/complete', [App\Http\Controllers\Auth\RegisteredUserController::class, 'completeRegistration'])->name('register.complete');

require __DIR__.'/auth.php';
