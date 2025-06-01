<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Available Players') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Filter Players</h3>
                    <form method="GET" action="{{ route('captain.players') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Position Filter -->
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position</label>
                            <select name="position" id="position" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">All Positions</option>
                                <option value="GK" {{ request('position') == 'GK' ? 'selected' : '' }}>Goalkeeper (GK)</option>
                                <option value="DEF" {{ request('position') == 'DEF' ? 'selected' : '' }}>Defender (DEF)</option>
                                <option value="MID" {{ request('position') == 'MID' ? 'selected' : '' }}>Midfielder (MID)</option>
                                <option value="FWD" {{ request('position') == 'FWD' ? 'selected' : '' }}>Forward (FWD)</option>
                            </select>
                        </div>

                        <!-- Min Rating Filter -->
                        <div>
                            <label for="min_rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Min Rating</label>
                            <input type="number" name="min_rating" id="min_rating" min="1" max="100" value="{{ request('min_rating') }}" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        </div>

                        <!-- Max Rating Filter -->
                        <div>
                            <label for="max_rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Max Rating</label>
                            <input type="number" name="max_rating" id="max_rating" min="1" max="100" value="{{ request('max_rating') }}" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        </div>

                        <!-- Max XP Cost Filter -->
                        <div>
                            <label for="max_xp_cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Max XP Cost</label>
                            <input type="number" name="max_xp_cost" id="max_xp_cost" min="1" max="100" value="{{ request('max_xp_cost') }}" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        </div>

                        <!-- Filter Button -->
                        <div class="md:col-span-4 flex space-x-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Apply Filters
                            </button>
                            <a href="{{ route('captain.players') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Clear Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- XP Remaining Info -->
            <div class="bg-blue-50 dark:bg-gray-800 border border-blue-200 dark:border-gray-700 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            <strong>XP Remaining: {{ auth()->user()->xp_remaining ?? 400 }}</strong> - You can only make offers to players whose XP cost is within your remaining budget.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Players Grid -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Available Players ({{ $players->total() }})
                        </h3>
                        <a href="{{ route('captain.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Dashboard
                        </a>
                    </div>

                    @if($players->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($players as $player)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-lg transition-shadow">
                                <!-- Player Header -->
                                <div class="flex items-center mb-4">
                                    <img src="{{ $player->photo_url }}" alt="{{ $player->name }}" class="w-16 h-16 rounded-full mr-4">
                                    <div>
                                        <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $player->name }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $player->email }}</p>
                                    </div>
                                </div>

                                <!-- Player Stats -->
                                <div class="space-y-2 mb-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Position:</span>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $player->position }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Rating:</span>
                                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $player->self_rating }}/100</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">XP Cost:</span>
                                        <span class="font-bold text-blue-600">{{ $player->xp_cost }}</span>
                                    </div>
                                </div>

                                <!-- Rating Bar -->
                                <div class="mb-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $player->self_rating }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Skill Rating</p>
                                </div>

                                <!-- Action Button -->
                                @php
                                    $canAfford = auth()->user()->xp_remaining >= $player->xp_cost;
                                    $hasExistingOffer = auth()->user()->sentOffers()->where('player_id', $player->id)->where('status', 'pending')->exists();
                                @endphp

                                @if($hasExistingOffer)
                                    <button disabled class="w-full bg-yellow-500 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed">
                                        Offer Pending
                                    </button>
                                @elseif($canAfford)
                                    <form action="{{ route('captain.make-offer', $player) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition-colors">
                                            Make Offer
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full bg-red-500 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed">
                                        Insufficient XP
                                    </button>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $players->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No players found</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                No players match your current filters. Try adjusting your search criteria.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('captain.players') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    Clear Filters
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 