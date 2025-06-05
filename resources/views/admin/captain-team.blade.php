<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $team->name }} - Team Details
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Dashboard
            </a>
        </div>
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

            <!-- Captain & Team Header -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="{{ $captain->photo_url }}" alt="{{ $captain->name }}" class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $team->name }}</h3>
                                <p class="text-lg text-gray-600 dark:text-gray-400">Captain: {{ $captain->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-300">{{ $captain->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-blue-50 dark:bg-blue-900 p-3 rounded">
                                    <div class="text-2xl font-bold text-blue-600">{{ $team->xp_remaining ?? 0 }}</div>
                                    <div class="text-xs text-blue-500">XP Remaining</div>
                                </div>
                                <div class="bg-green-50 dark:bg-green-900 p-3 rounded">
                                    <div class="text-2xl font-bold text-green-600">{{ $captain->coins ?? 0 }}</div>
                                    <div class="text-xs text-green-500">Coins</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-2xl font-bold text-blue-600">{{ $totalPlayers }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Players</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-2xl font-bold text-red-600">{{ $totalXpUsed ?? 0 }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">XP Used</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-2xl font-bold text-green-600">{{ number_format($averageRating ?? 0, 1) }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Avg Rating</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-2xl font-bold text-purple-600">{{ ($team->xp_total ?? 0) - ($totalXpUsed ?? 0) }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Budget Left</div>
                    </div>
                </div>
            </div>

            <!-- Team Roster -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Team Roster</h3>
                    
                    @if($totalPlayers > 0)
                        @if($playersByPosition->count() > 0)
                            <!-- Players grouped by position -->
                            @foreach(['GK' => 'Goalkeepers', 'DEF' => 'Defenders', 'MID' => 'Midfielders', 'FWD' => 'Forwards'] as $position => $positionName)
                                @if($playersByPosition->has($position))
                                    <div class="mb-8">
                                        <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                                            {{ $positionName }} ({{ $playersByPosition[$position]->count() }})
                                        </h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach($playersByPosition[$position] as $player)
                                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                                                    <div class="flex items-center mb-3">
                                                        <img src="{{ $player->photo_url }}" alt="{{ $player->name }}" class="w-12 h-12 rounded-full mr-3">
                                                        <div class="flex-1">
                                                            <h5 class="font-semibold text-gray-900 dark:text-gray-100">{{ $player->name }}</h5>
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $player->email }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="grid grid-cols-3 gap-2 text-center">
                                                        <div class="bg-blue-50 dark:bg-blue-900 p-2 rounded">
                                                            <div class="text-sm font-semibold text-blue-600">{{ $player->position }}</div>
                                                            <div class="text-xs text-blue-500">Position</div>
                                                        </div>
                                                        <div class="bg-green-50 dark:bg-green-900 p-2 rounded">
                                                            <div class="text-sm font-semibold text-green-600">{{ $player->self_rating }}</div>
                                                            <div class="text-xs text-green-500">Rating</div>
                                                        </div>
                                                        <div class="bg-orange-50 dark:bg-orange-900 p-2 rounded">
                                                            <div class="text-sm font-semibold text-orange-600">{{ $player->xp_cost ?? 0 }}</div>
                                                            <div class="text-xs text-orange-500">XP Cost</div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3">
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                            @if($player->payment_status === 'paid') bg-green-100 text-green-800
                                                            @elseif($player->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                                            @else bg-red-100 text-red-800 @endif">
                                                            {{ ucfirst($player->payment_status ?? 'pending') }}
                                                        </span>
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full ml-2 bg-blue-100 text-blue-800">
                                                            {{ ucfirst($player->status ?? 'drafted') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <!-- Fallback if no position grouping -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($team->players as $player)
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <img src="{{ $player->photo_url }}" alt="{{ $player->name }}" class="w-12 h-12 rounded-full mr-3">
                                            <div>
                                                <h5 class="font-semibold text-gray-900 dark:text-gray-100">{{ $player->name }}</h5>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $player->email }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-3 gap-2 text-center">
                                            <div class="bg-blue-50 dark:bg-blue-900 p-2 rounded">
                                                <div class="text-sm font-semibold text-blue-600">{{ $player->position }}</div>
                                                <div class="text-xs text-blue-500">Position</div>
                                            </div>
                                            <div class="bg-green-50 dark:bg-green-900 p-2 rounded">
                                                <div class="text-sm font-semibold text-green-600">{{ $player->self_rating }}</div>
                                                <div class="text-xs text-green-500">Rating</div>
                                            </div>
                                            <div class="bg-orange-50 dark:bg-orange-900 p-2 rounded">
                                                <div class="text-sm font-semibold text-orange-600">{{ $player->xp_cost ?? 0 }}</div>
                                                <div class="text-xs text-orange-500">XP Cost</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">No Players Drafted</h4>
                            <p class="text-gray-500 dark:text-gray-400">{{ $captain->name }} hasn't drafted any players yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 