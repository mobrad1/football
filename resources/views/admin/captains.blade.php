<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Captains') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Captains ({{ $captains->count() }})
                        </h3>
                        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Dashboard
                        </a>
                    </div>

                    @if($captains->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($captains as $captain)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                                <div class="flex items-center mb-4">
                                    <img src="{{ $captain->photo_url }}" alt="{{ $captain->name }}" class="w-16 h-16 rounded-full mr-4">
                                    <div>
                                        <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $captain->name }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $captain->email }}</p>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">XP Remaining:</span>
                                        <span class="font-semibold text-blue-600">{{ $captain->xp_remaining ?? 400 }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Coins:</span>
                                        <span class="font-semibold text-green-600">{{ $captain->coins ?? 500 }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Registered:</span>
                                        <span class="text-sm text-gray-500">{{ $captain->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 dark:text-gray-400">No captains registered yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 