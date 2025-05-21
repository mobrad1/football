<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'position' => ['required', 'string', 'in:GK,DEF,MID,FWD'],
            'self_rating' => ['required', 'integer', 'min:1', 'max:100'],
            'xp_cost' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'player', // Default role is player
            'position' => $request->position,
            'self_rating' => $request->self_rating,
            'xp_cost' => $request->xp_cost,
            'status' => 'free',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    public function completeRegistration(Request $request)
    {
        // Get registration data from session
        $registrationData = Session::get('registration_data');
        
        if (!$registrationData) {
            return redirect()->route('register')->with('error', 'Registration data not found. Please try again.');
        }

        // Validate the data again
        $validator = Validator::make($registrationData, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'position' => ['required', 'string', 'in:GK,DEF,MID,FWD'],
            'self_rating' => ['required', 'integer', 'min:1', 'max:100'],
            'xp_cost' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $registrationData['name'],
            'email' => $registrationData['email'],
            'password' => Hash::make($registrationData['password']),
            'role' => 'player',
            'position' => $registrationData['position'],
            'self_rating' => $registrationData['self_rating'],
            'xp_cost' => $registrationData['xp_cost'],
            'status' => 'free',
            'payment_status' => 'paid',
            'payment_reference' => Session::get('payment_reference'),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
