<x-guest-layout>
    <div class="mb-6 p-4 bg-blue-50 dark:bg-gray-800 rounded-lg border border-blue-200 dark:border-gray-700">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-700 dark:text-blue-400">Payment Required</h3>
                <div class="mt-1 text-sm text-blue-600 dark:text-blue-300">
                    <p>Registration requires a one-time payment of <strong>₦1,000</strong>. You will be redirected to the payment page after completing this form.</p>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('payment.initiate') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
            <div id="name-error" class="text-red-600 mt-1 text-sm hidden"></div>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <div id="email-error" class="text-red-600 mt-1 text-sm hidden"></div>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <div id="password-error" class="text-red-600 mt-1 text-sm hidden"></div>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            <div id="password-confirmation-error" class="text-red-600 mt-1 text-sm hidden"></div>
        </div>

        <!-- Player Position -->
        <div class="mt-4">
            <x-input-label for="position" :value="__('Position')" />
            <select id="position" name="position" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                <option value="">Select Position</option>
                <option value="GK" {{ old('position') == 'GK' ? 'selected' : '' }}>Goalkeeper (GK)</option>
                <option value="DEF" {{ old('position') == 'DEF' ? 'selected' : '' }}>Defender (DEF)</option>
                <option value="MID" {{ old('position') == 'MID' ? 'selected' : '' }}>Midfielder (MID)</option>
                <option value="FWD" {{ old('position') == 'FWD' ? 'selected' : '' }}>Forward (FWD)</option>
            </select>
            <x-input-error :messages="$errors->get('position')" class="mt-2" />
            <div id="position-error" class="text-red-600 mt-1 text-sm hidden"></div>
        </div>

        <!-- Self Rating -->
        <div class="mt-4">
            <x-input-label for="self_rating" :value="__('Self Rating (1-100)')" />
            <x-text-input id="self_rating" class="block mt-1 w-full" type="number" name="self_rating" :value="old('self_rating')" min="1" max="100" required />
            <x-input-error :messages="$errors->get('self_rating')" class="mt-2" />
            <div id="self-rating-error" class="text-red-600 mt-1 text-sm hidden"></div>
        </div>

        <!-- XP Cost -->
        <div class="mt-4">
            <x-input-label for="xp_cost" :value="__('XP Cost (1-100)')" />
            <x-text-input id="xp_cost" class="block mt-1 w-full" type="number" name="xp_cost" :value="old('xp_cost')" min="1" max="100" required />
            <x-input-error :messages="$errors->get('xp_cost')" class="mt-2" />
            <div id="xp-cost-error" class="text-red-600 mt-1 text-sm hidden"></div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button id="submit-button" class="ms-4">
                {{ __('Proceed to Payment (₦1,000)') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitButton = document.getElementById('submit-button');
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const positionSelect = document.getElementById('position');
            const selfRatingInput = document.getElementById('self_rating');
            const xpCostInput = document.getElementById('xp_cost');
            
            // Error message elements
            const nameError = document.getElementById('name-error');
            const emailError = document.getElementById('email-error');
            const passwordError = document.getElementById('password-error');
            const passwordConfirmationError = document.getElementById('password-confirmation-error');
            const positionError = document.getElementById('position-error');
            const selfRatingError = document.getElementById('self-rating-error');
            const xpCostError = document.getElementById('xp-cost-error');
            
            // Add input event listeners to all form fields
            [nameInput, emailInput, passwordInput, confirmPasswordInput, positionSelect, selfRatingInput, xpCostInput].forEach(field => {
                field.addEventListener('input', validateForm);
                field.addEventListener('change', validateForm);
                field.addEventListener('blur', validateForm);
            });
            
            // Validate the form on submit
            form.addEventListener('submit', function(event) {
                const validationResult = validateFormWithMessages();
                if (!validationResult.isValid) {
                    event.preventDefault();
                    // Focus on the first field with an error
                    validationResult.firstErrorField?.focus();
                }
            });
            
            // Initial validation
            validateForm();
            
            function validateForm() {
                const validationResult = validateFormWithMessages();
                submitButton.disabled = !validationResult.isValid;
                
                // Add visual feedback
                if (validationResult.isValid) {
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }
            
            function validateFormWithMessages() {
                // Reset all error messages
                nameError.textContent = '';
                nameError.classList.add('hidden');
                emailError.textContent = '';
                emailError.classList.add('hidden');
                passwordError.textContent = '';
                passwordError.classList.add('hidden');
                passwordConfirmationError.textContent = '';
                passwordConfirmationError.classList.add('hidden');
                positionError.textContent = '';
                positionError.classList.add('hidden');
                selfRatingError.textContent = '';
                selfRatingError.classList.add('hidden');
                xpCostError.textContent = '';
                xpCostError.classList.add('hidden');
                
                let isValid = true;
                let firstErrorField = null;
                
                // Validate name
                if (!nameInput.value.trim()) {
                    nameError.textContent = 'Name is required';
                    nameError.classList.remove('hidden');
                    isValid = false;
                    firstErrorField = firstErrorField || nameInput;
                }
                
                // Validate email
                if (!emailInput.value.trim()) {
                    emailError.textContent = 'Email is required';
                    emailError.classList.remove('hidden');
                    isValid = false;
                    firstErrorField = firstErrorField || emailInput;
                } else {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test(emailInput.value.trim())) {
                        emailError.textContent = 'Please enter a valid email address';
                        emailError.classList.remove('hidden');
                        isValid = false;
                        firstErrorField = firstErrorField || emailInput;
                    }
                }
                
                // Validate password
                if (!passwordInput.value) {
                    passwordError.textContent = 'Password is required';
                    passwordError.classList.remove('hidden');
                    isValid = false;
                    firstErrorField = firstErrorField || passwordInput;
                } else if (passwordInput.value.length < 8) {
                    passwordError.textContent = 'Password must be at least 8 characters';
                    passwordError.classList.remove('hidden');
                    isValid = false;
                    firstErrorField = firstErrorField || passwordInput;
                }
                
                // Validate password confirmation
                if (!confirmPasswordInput.value) {
                    passwordConfirmationError.textContent = 'Please confirm your password';
                    passwordConfirmationError.classList.remove('hidden');
                    isValid = false;
                    firstErrorField = firstErrorField || confirmPasswordInput;
                } else if (passwordInput.value !== confirmPasswordInput.value) {
                    passwordConfirmationError.textContent = 'Passwords do not match';
                    passwordConfirmationError.classList.remove('hidden');
                    isValid = false;
                    firstErrorField = firstErrorField || confirmPasswordInput;
                }
                
                // Validate position
                if (!positionSelect.value) {
                    positionError.textContent = 'Please select your position';
                    positionError.classList.remove('hidden');
                    isValid = false;
                    firstErrorField = firstErrorField || positionSelect;
                }
                
                // Validate self rating
                if (!selfRatingInput.value) {
                    selfRatingError.textContent = 'Self rating is required';
                    selfRatingError.classList.remove('hidden');
                    isValid = false;
                    firstErrorField = firstErrorField || selfRatingInput;
                } else {
                    const selfRating = parseInt(selfRatingInput.value);
                    if (isNaN(selfRating) || selfRating < 1 || selfRating > 100) {
                        selfRatingError.textContent = 'Self rating must be between 1 and 100';
                        selfRatingError.classList.remove('hidden');
                        isValid = false;
                        firstErrorField = firstErrorField || selfRatingInput;
                    }
                }
                
                // Validate XP cost
                if (!xpCostInput.value) {
                    xpCostError.textContent = 'XP cost is required';
                    xpCostError.classList.remove('hidden');
                    isValid = false;
                    firstErrorField = firstErrorField || xpCostInput;
                } else {
                    const xpCost = parseInt(xpCostInput.value);
                    if (isNaN(xpCost) || xpCost < 1 || xpCost > 100) {
                        xpCostError.textContent = 'XP cost must be between 1 and 100';
                        xpCostError.classList.remove('hidden');
                        isValid = false;
                        firstErrorField = firstErrorField || xpCostInput;
                    }
                }
                
                return { isValid, firstErrorField };
            }
        });
    </script>
</x-guest-layout>
