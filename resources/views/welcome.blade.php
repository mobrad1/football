<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Fantasy Football Draft') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gradient-to-br from-gray-900 to-gray-800 text-white min-h-screen">
        <div class="relative min-h-screen" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('images/background.jpg') }}'); background-size: cover; background-position: center;">
            <!-- Hero Section -->
            <div class="relative overflow-hidden">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="relative z-10 py-8 sm:py-16 md:py-20 lg:py-28">
                        <div class="text-center">
                            <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                                <span class="block">Eagle Island Fantasy Football</span>
                                <span class="block text-indigo-400">Draft Game</span>
                            </h1>
                            <p class="mt-3 max-w-md mx-auto text-base text-gray-300 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                                Join the ultimate Eagle Islandfantasy football experience where players and captains come together to form the best teams.
                            </p>
                            <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                                @guest
                                    <div class="rounded-md shadow">
                                        <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                            Register Now
                                        </a>
                                    </div>
                                    <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                            Log In
                                        </a>
                                    </div>
                                @else
                                    <div class="rounded-md shadow">
                                        <a href="{{ url('/dashboard') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                            Go to Dashboard
                                        </a>
                                    </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Game Rules Section -->
            <div class="py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="lg:text-center">
                        <h2 class="text-base text-indigo-400 font-semibold tracking-wide uppercase">How It Works</h2>
                        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-white sm:text-4xl">
                            Game Rules & Instructions
                        </p>
                    </div>

                    <div class="mt-10">
                        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                            <div class="bg-gray-700/50 backdrop-blur-sm rounded-lg shadow-lg overflow-hidden">
                                <div class="px-6 py-8">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                        </div>
                                        <h3 class="ml-4 text-xl font-medium text-white">Game Rules</h3>
                                    </div>
                                    <div class="mt-4 text-gray-300">
                                        <ol class="space-y-3 list-decimal list-inside">
                                            <li>Players register and set their position, self-rating, and XP cost</li>
                                            <li>Captains scout players and make offers to draft them</li>
                                            <li>Players can accept or reject offers</li>
                                            <li>Captains have limited XP to spend on drafting players</li>
                                            <li>Once drafted, players join the captain's team</li>
                                            <li>Teams compete in matches based on player ratings</li>
                                            <li>Captains can trade players with other captains</li>
                                            <li>The Max xp a captain can spend on a player is 100</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-700/50 backdrop-blur-sm rounded-lg shadow-lg overflow-hidden">
                                <div class="px-6 py-8">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                        </div>
                                        <h3 class="ml-4 text-xl font-medium text-white">How to Play</h3>
                                    </div>
                                    <div class="mt-4 text-gray-300">
                                        <h4 class="font-semibold text-white mb-2">For Players:</h4>
                                        <ol class="space-y-1 list-decimal list-inside mb-4">
                                            <li>Register with your details and upload a profile photo</li>
                                            <li>Set your position (GK, DEF, MID, FWD)</li>
                                            <li>Rate your skills (1-100)</li>
                                            <li>Set your XP cost for captains</li>
                                            <li>Wait for and respond to offers</li>
                                        </ol>
                                        
                                        <h4 class="font-semibold text-white mb-2">For Captains:</h4>
                                        <ol class="space-y-1 list-decimal list-inside">
                                            <li>Register as a captain</li>
                                            <li>Scout available players</li>
                                            <li>Make offers using your XP</li>
                                            <li>Build your team</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Players Section -->
            <div class="py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="lg:text-center mb-10">
                        <h2 class="text-base text-indigo-400 font-semibold tracking-wide uppercase">Player Marketplace</h2>
                        <p class="mt-4 max-w-2xl text-xl text-gray-300 lg:mx-auto">
                            Browse the list of players ready to be drafted
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @forelse($players->where('status', 'free')->where('payment_status', 'paid')->take(6) as $player)
                            <div class="bg-gray-700/50 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden transform transition duration-500 hover:scale-105">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            <img class="h-16 w-16 rounded-full object-cover border-2 border-indigo-500" src="{{ $player->photo_url }}" alt="{{ $player->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-bold text-white">{{ $player->name }}</h3>
                                            <div class="flex items-center mt-1">
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-500 text-white">
                                                    {{ $player->position }}
                                                </span>
                                                <div class="ml-2 flex items-center">
                                                    <svg class="h-4 w-4 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    <span class="ml-1 text-sm text-gray-300">{{ $player->self_rating }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-600">
                                        <div class="flex justify-between items-center">
                                            <div class="text-sm text-gray-300">
                                                <span class="font-medium text-white">XP Cost:</span> 
                                                <span class="text-indigo-400 font-bold">{{ $player->xp_cost }}</span>
                                            </div>
                                            @auth
                                                @if(auth()->user()->role === 'captain')
                                                    <a href="{{ route('captain.make-offer', $player) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        Make Offer
                                                    </a>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                    Login to Draft
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 bg-gray-700/50 backdrop-blur-sm rounded-lg shadow-lg p-8 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-300">No players available</h3>
                                <p class="mt-1 text-sm text-gray-400">Be the first to register as a player!</p>
                                <div class="mt-6">
                                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Register Now
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if($players->where('status', 'free')->count() > 6)
                        <div class="mt-10 text-center">
                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                View All Players
                                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Prize Pool Section -->
            <div class="py-12 bg-gradient-to-r">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-base text-indigo-400 font-semibold tracking-wide uppercase">Prize Pool</h2>
                        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-white sm:text-4xl">
                            ₦1,000,000 Total Prize Pool
                        </p>
                        <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-300">
                            Compete for a share of the one million naira prize pool
                        </p>
                    </div>

                    <div class="mt-10">
                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-3">
                            <!-- First Place -->
                            <div class="relative bg-white dark:bg-gray-800 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-0 right-0 -mt-3 -mr-3">
                                    <span class="inline-flex items-center justify-center px-4 py-1 text-xs font-bold leading-none text-white transform rotate-12 bg-yellow-500 rounded-full">1st Place</span>
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-12 w-12 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1zm-5 8.274l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L5 10.274zm10 0l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L15 10.274z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-5">
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white">₦500,000</div>
                                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Champion's Prize</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Second Place -->
                            <div class="relative bg-white dark:bg-gray-800 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-0 right-0 -mt-3 -mr-3">
                                    <span class="inline-flex items-center justify-center px-4 py-1 text-xs font-bold leading-none text-white transform rotate-12 bg-gray-400 rounded-full">2nd Place</span>
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-12 w-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1zm-5 8.274l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L5 10.274zm10 0l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L15 10.274z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-5">
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white">₦300,000</div>
                                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Runner-up Prize</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Third Place -->
                            <div class="relative bg-white dark:bg-gray-800 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-0 right-0 -mt-3 -mr-3">
                                    <span class="inline-flex items-center justify-center px-4 py-1 text-xs font-bold leading-none text-white transform rotate-12 bg-amber-700 rounded-full">3rd Place</span>
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-12 w-12 text-amber-700" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1zm-5 8.274l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L5 10.274zm10 0l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L15 10.274z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-5">
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white">₦200,000</div>
                                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Third Place Prize</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 text-center">
                        <p class="text-gray-300">
                            <span class="font-semibold text-white">Entry Fee:</span> ₦1,000 per player
                        </p>
                        <p class="mt-2 text-gray-300">
                            <span class="font-semibold text-white">Sponsored by:</span> Bradley Yarrow
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="bg-gray-800">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col items-center justify-between md:flex-row">            
                        <div class="mt-8 md:mt-0">
                            <p class="text-center text-base text-gray-400">
                                Sponsored by <span class="text-indigo-400 font-medium">Bradley Yarrow</span>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
