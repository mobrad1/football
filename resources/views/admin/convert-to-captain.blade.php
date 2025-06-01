<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Convert Player to Captain') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Convert to Captain</h3>
                        <a href="{{ route('admin.players') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Players
                        </a>
                    </div>

                    <!-- Player Info -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Player Information</h4>
                        <div class="flex items-center mb-4">
                            <img src="{{ $player->photo_url }}" alt="{{ $player->name }}" class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <div class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $player->name }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ $player->email }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    Position: {{ $player->position }} | Rating: {{ $player->self_rating }} | XP Cost: {{ $player->xp_cost }}
                                </div>
                            </div>
                        </div>
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                            <p class="font-bold">Warning:</p>
                            <p>Converting this player to a captain will:</p>
                            <ul class="list-disc list-inside mt-2">
                                <li>Change their role from player to captain</li>
                                <li>Remove their player-specific data (position, rating, XP cost)</li>
                                <li>Create a new team for them</li>
                                <li>Give them the specified XP and coins</li>
                                <li>This action cannot be easily undone</li>
                            </ul>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.convert-to-captain', $player) }}" class="space-y-6">
                        @csrf

                        <!-- XP Remaining -->
                        <div>
                            <label for="xp_remaining" class="block text-sm font-medium text-gray-700 dark:text-gray-300">XP Remaining (100-1000)</label>
                            <input type="number" name="xp_remaining" id="xp_remaining" min="100" max="1000" value="{{ old('xp_remaining', 500) }}" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <p class="mt-1 text-sm text-gray-500">Default: 500 XP</p>
                            @error('xp_remaining')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Coins -->
                        <div>
                            <label for="coins" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Coins (100-2000)</label>
                            <input type="number" name="coins" id="coins" min="100" max="2000" value="{{ old('coins', 500) }}" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <p class="mt-1 text-sm text-gray-500">Default: 500 coins</p>
                            @error('coins')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Status -->
                        <div>
                            <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Status</label>
                            <select name="payment_status" id="payment_status" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="pending" {{ old('payment_status', $player->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ old('payment_status', $player->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ old('payment_status', $player->payment_status) == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            @error('payment_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmation -->
                        <div class="flex items-center">
                            <input type="checkbox" id="confirm" name="confirm" required
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="confirm" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                I understand that this action will convert {{ $player->name }} from a player to a captain and cannot be easily undone.
                            </label>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.players') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Convert to Captain
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 