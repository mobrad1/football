<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Captain Dashboard') }}
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

            <!-- Team Info -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Team Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <div class="text-2xl font-bold text-blue-600">{{ $captain->xp_remaining ?? 400 }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">XP Remaining</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-green-600">{{ $teamPlayers->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Players Drafted</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-orange-600">{{ $sentOffers->where('status', 'pending')->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Pending Offers</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Players -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Available Players</h3>
                        <a href="{{ route('captain.players') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            View All Players
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($availablePlayers->take(6) as $player)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <img src="{{ $player->photo_url }}" alt="{{ $player->name }}" class="w-12 h-12 rounded-full mr-3">
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $player->name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $player->position }}</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Rating: {{ $player->self_rating }}</span>
                                <span class="text-sm font-semibold text-blue-600">XP: {{ $player->xp_cost }}</span>
                            </div>
                            <form action="{{ route('captain.make-offer', $player) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                    class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm
                                    {{ $captain->xp_remaining < $player->xp_cost ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $captain->xp_remaining < $player->xp_cost ? 'disabled' : '' }}>
                                    Make Offer
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- My Team -->
            @if($teamPlayers->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">My Team</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($teamPlayers as $player)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <img src="{{ $player->photo_url }}" alt="{{ $player->name }}" class="w-12 h-12 rounded-full mr-3">
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $player->name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $player->position }}</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Rating: {{ $player->self_rating }}</span>
                                <span class="text-sm font-semibold text-green-600">Cost: {{ $player->xp_cost }} XP</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Offers -->
            @if($sentOffers->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Offers</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Player</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Position</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">XP Cost</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($sentOffers->take(10) as $offer)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $offer->player->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $offer->player->position }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $offer->xp_cost }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($offer->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($offer->status === 'accepted') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($offer->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $offer->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout> 