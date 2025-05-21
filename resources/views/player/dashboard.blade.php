<x-player-layout>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Player Profile -->
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <div class="flex items-center mb-6">
                <div class="mr-4">
                    <img src="{{ $player->photo_url }}" alt="{{ $player->name }}" class="w-24 h-24 rounded-full object-cover border-2 border-indigo-500">
                </div>
                <div>
                    <h3 class="text-lg font-semibold">{{ $player->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $player->position ?? 'No position set' }}</p>
                </div>
            </div>
            
            @if($player->status === 'free')
                <form method="POST" action="{{ route('player.update-profile') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Photo Upload -->
                    <div class="mb-4">
                        <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Profile Photo</label>
                        <input type="file" id="photo" name="photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave empty to keep current photo</p>
                        @error('photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position</label>
                        <select id="position" name="position" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="GK" {{ $player->position === 'GK' ? 'selected' : '' }}>Goalkeeper (GK)</option>
                            <option value="DEF" {{ $player->position === 'DEF' ? 'selected' : '' }}>Defender (DEF)</option>
                            <option value="MID" {{ $player->position === 'MID' ? 'selected' : '' }}>Midfielder (MID)</option>
                            <option value="FWD" {{ $player->position === 'FWD' ? 'selected' : '' }}>Forward (FWD)</option>
                        </select>
                        @error('position')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="self_rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Self Rating (1-100)</label>
                        <input type="number" id="self_rating" name="self_rating" min="1" max="100" value="{{ old('self_rating', $player->self_rating) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('self_rating')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="xp_cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300">XP Cost</label>
                        <input type="number" id="xp_cost" name="xp_cost" min="1" max="100" value="{{ old('xp_cost', $player->xp_cost) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('xp_cost')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Update Profile
                        </button>
                    </div>
                </form>
            @else
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Position:</span>
                        <span class="font-medium">{{ $player->position }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Self Rating:</span>
                        <span class="font-medium">{{ $player->self_rating }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">XP Cost:</span>
                        <span class="font-medium">{{ $player->xp_cost }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Status:</span>
                        <span class="font-medium text-green-600">Drafted</span>
                    </div>
                    @if($player->team)
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Team:</span>
                        <span class="font-medium">{{ $player->team->name }}</span>
                    </div>
                    @endif
                </div>
                <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900 rounded text-yellow-800 dark:text-yellow-200 text-sm">
                    You have been drafted and cannot update your profile.
                </div>
            @endif
        </div>
        
        <!-- Offers -->
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Offers</h3>
            
            @if($player->status === 'drafted')
                <div class="p-3 bg-green-50 dark:bg-green-900 rounded text-green-800 dark:text-green-200">
                    You have been drafted by a team.
                </div>
            @elseif($offers->isEmpty())
                <div class="p-3 bg-gray-50 dark:bg-gray-600 rounded text-gray-600 dark:text-gray-300">
                    You have no offers yet. Make sure your profile is complete to attract captains.
                </div>
            @else
                <div class="space-y-4">
                    @foreach($offers as $offer)
                        <div class="border dark:border-gray-600 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-medium">Offer from {{ $offer->captain->name }}</h4>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($offer->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @elseif($offer->status === 'accepted') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @endif">
                                    {{ ucfirst($offer->status) }}
                                </span>
                            </div>
                            
                            @if($offer->status === 'pending')
                                <form method="POST" action="{{ route('player.respond-to-offer', $offer) }}" class="flex space-x-2 mt-3">
                                    @csrf
                                    @method('PUT')
                                    
                                    <input type="hidden" name="response" value="accept">
                                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
                                        Accept
                                    </button>
                                    
                                    <button type="submit" formaction="{{ route('player.respond-to-offer', $offer) }}?response=reject" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded">
                                        Reject
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-player-layout> 