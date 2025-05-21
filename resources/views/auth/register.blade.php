<x-guest-layout>
    <form method="POST" action="{{ route('payment.initiate') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Player Position -->
        <div class="mt-4">
            <x-input-label for="position" :value="__('Position')" />
            <select id="position" name="position" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                <option value="" disabled selected>Select your position</option>
                <option value="GK" {{ old('position') === 'GK' ? 'selected' : '' }}>Goalkeeper (GK)</option>
                <option value="DEF" {{ old('position') === 'DEF' ? 'selected' : '' }}>Defender (DEF)</option>
                <option value="MID" {{ old('position') === 'MID' ? 'selected' : '' }}>Midfielder (MID)</option>
                <option value="FWD" {{ old('position') === 'FWD' ? 'selected' : '' }}>Forward (FWD)</option>
            </select>
            <x-input-error :messages="$errors->get('position')" class="mt-2" />
        </div>

        <!-- Self Rating -->
        <div class="mt-4">
            <x-input-label for="self_rating" :value="__('Self Rating (1-100)')" />
            <x-text-input id="self_rating" class="block mt-1 w-full" type="number" name="self_rating" :value="old('self_rating')" min="1" max="100" required />
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Rate your skill level from 1 (beginner) to 100 (professional).</p>
            <x-input-error :messages="$errors->get('self_rating')" class="mt-2" />
        </div>

        <!-- XP Cost -->
        <div class="mt-4">
            <x-input-label for="xp_cost" :value="__('XP Cost (1-100)')" />
            <x-text-input id="xp_cost" class="block mt-1 w-full" type="number" name="xp_cost" :value="old('xp_cost')" required min="1" max="100" />
            <x-input-error :messages="$errors->get('xp_cost')" class="mt-2" />
        </div>

        <!-- Photo Upload -->
        <div class="mt-4">
            <x-input-label for="photo" :value="__('Profile Photo (Optional)')" />
            <input type="file" id="photo" name="photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">
            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
        </div>

        <!-- Registration Fee Notice -->
        <div class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900 rounded-md">
            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                <strong>Registration Fee:</strong> A non-refundable fee of ₦1,000 will be charged to complete your registration. You'll be redirected to Paystack to make this payment.
            </p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Proceed to Payment') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
