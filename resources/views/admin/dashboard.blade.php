<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <a href="{{ route('admin.register-player') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded text-center">
                            Register Player
                        </a>
                        <a href="{{ route('admin.register-captain') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded text-center">
                            Register Captain
                        </a>
                        <a href="{{ route('admin.players') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded text-center">
                            Manage Players
                        </a>
                        <a href="{{ route('admin.captains') }}" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-3 px-4 rounded text-center">
                            Manage Captains
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-2xl font-bold text-blue-600">{{ $totalPlayers }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Players</div>
                        <div class="text-xs text-green-600 mt-1">{{ $paidPlayers }} paid</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-2xl font-bold text-green-600">{{ $totalCaptains }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Captains</div>
                        <div class="text-xs text-green-600 mt-1">{{ $paidCaptains }} paid</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-2xl font-bold text-orange-600">{{ $freePlayers }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Free Players</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-2xl font-bold text-red-600">{{ $draftedPlayers }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Drafted Players</div>
                    </div>
                </div>
            </div>

            <!-- Captains Teams -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Captains & Teams</h3>
                        <a href="{{ route('admin.captains') }}" class="text-blue-600 hover:text-blue-800">View All Captains</a>
                    </div>
                    @if($captainsWithTeams->count() > 0)
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            @foreach($captainsWithTeams as $team)
                            <a href="{{ route('admin.captain-team', $team->captain) }}" class="block border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-lg hover:border-blue-300 transition-all duration-200 cursor-pointer">
                                <!-- Team Header -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <img src="{{ $team->captain->photo_url }}" alt="{{ $team->captain->name }}" class="w-10 h-10 rounded-full mr-3">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 hover:text-blue-600 transition-colors">{{ $team->name }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Captain: {{ $team->captain->name }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-blue-600">{{ $team->xp_remaining ?? 0 }} XP</div>
                                        <div class="text-xs text-gray-500">remaining</div>
                                    </div>
                                </div>

                                <!-- Team Players -->
                                @if($team->players->count() > 0)
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Team Players ({{ $team->players->count() }})
                                        </h5>
                                        <div class="space-y-2">
                                            @foreach($team->players as $player)
                                            <div class="flex items-center justify-between py-2 px-3 bg-gray-50 dark:bg-gray-700 rounded">
                                                <div class="flex items-center">
                                                    <img src="{{ $player->photo_url }}" alt="{{ $player->name }}" class="w-6 h-6 rounded-full mr-2">
                                                    <span class="text-sm text-gray-900 dark:text-gray-100">{{ $player->name }}</span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        {{ $player->position }}
                                                    </span>
                                                    <span class="text-xs text-gray-500">{{ $player->self_rating }}</span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">No players drafted yet</p>
                                    </div>
                                @endif
                            </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No teams created yet.</p>
                    @endif
                </div>
            </div>

            <!-- Recent Players -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Players</h3>
                        <a href="{{ route('admin.players') }}" class="text-blue-600 hover:text-blue-800">View All</a>
                    </div>
                    @if($recentPlayers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Player</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Position</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rating</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Payment</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Registered</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($recentPlayers as $player)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <img src="{{ $player->photo_url }}" alt="{{ $player->name }}" class="w-8 h-8 rounded-full mr-3">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $player->name }}</div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-300">{{ $player->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $player->position }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $player->self_rating }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $player->status === 'free' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($player->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($player->payment_status === 'paid') bg-green-100 text-green-800
                                                @elseif($player->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($player->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $player->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No players registered yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 