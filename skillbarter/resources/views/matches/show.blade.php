<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $userSkill->skill->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Skill Details Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-6">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $userSkill->skill->name }}</h1>
                                    <div class="mt-2 flex flex-wrap items-center gap-2">
                                        <!-- Level Badge -->
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            @switch($userSkill->level)
                                                @case('beginner') bg-green-100 text-green-800 @break
                                                @case('intermediate') bg-blue-100 text-blue-800 @break
                                                @case('advanced') bg-purple-100 text-purple-800 @break
                                                @case('expert') bg-red-100 text-red-800 @break
                                                @default bg-gray-100 text-gray-800
                                            @endswitch">
                                            {{ ucfirst($userSkill->level) }}
                                        </span>

                                        @if($userSkill->price)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                                ${{ number_format($userSkill->price, 2) }}/hr
                                            </span>
                                        @endif

                                        @if($userSkill->location)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                {{ $userSkill->location }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            @if($userSkill->skill->description)
                                <div class="prose max-w-none">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">About this skill</h3>
                                    <p class="text-gray-600">{{ $userSkill->skill->description }}</p>
                                </div>
                            @endif

                            <!-- Request Session Button (Mobile) -->
                            <div class="mt-6 lg:hidden">
                                <a href="{{ route('requests.create', $userSkill) }}"
                                   class="block w-full text-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                    Request Session
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Other Skills by Provider -->
                    @if($otherSkills->count() > 0)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Other skills by {{ $provider->name }}</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($otherSkills as $skill)
                                        <a href="{{ route('matches.show', $skill) }}"
                                           class="block p-4 border border-gray-200 rounded-lg hover:border-indigo-300 hover:bg-indigo-50 transition">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="font-medium text-gray-900">{{ $skill->skill->name }}</h4>
                                                    <span class="text-xs text-gray-500">{{ ucfirst($skill->level) }}</span>
                                                </div>
                                                @if($skill->price)
                                                    <span class="text-sm font-medium text-indigo-600">${{ number_format($skill->price, 2) }}/hr</span>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar - Provider Info -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6">
                            <!-- Provider Avatar & Name -->
                            <div class="text-center mb-6">
                                @if($provider->avatar)
                                    <img src="{{ asset('storage/' . $provider->avatar) }}"
                                         alt="{{ $provider->name }}"
                                         class="mx-auto h-24 w-24 rounded-full object-cover ring-4 ring-indigo-100">
                                @else
                                    <div class="mx-auto h-24 w-24 rounded-full bg-indigo-600 flex items-center justify-center ring-4 ring-indigo-100">
                                        <span class="text-white font-bold text-3xl">
                                            {{ strtoupper(substr($provider->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                                <h3 class="mt-4 text-xl font-semibold text-gray-900">{{ $provider->name }}</h3>

                                <!-- Rating -->
                                <div class="mt-2 flex items-center justify-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="h-5 w-5 {{ $i <= round($rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                    <span class="ml-2 text-sm text-gray-600">({{ number_format($rating, 1) }})</span>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="border-t border-gray-200 pt-4 mb-6">
                                <div class="flex justify-around text-center">
                                    <div>
                                        <p class="text-2xl font-bold text-indigo-600">{{ $sessionsCount }}</p>
                                        <p class="text-xs text-gray-500">Sessions</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-indigo-600">{{ number_format($rating, 1) }}</p>
                                        <p class="text-xs text-gray-500">Rating</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Bio -->
                            @if($provider->bio)
                                <div class="border-t border-gray-200 pt-4 mb-6">
                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">About</h4>
                                    <p class="text-sm text-gray-600">{{ $provider->bio }}</p>
                                </div>
                            @endif

                            <!-- Request Button (Desktop) -->
                            <div class="hidden lg:block">
                                <a href="{{ route('requests.create', $userSkill) }}"
                                   class="block w-full text-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                    Request Session
                                </a>
                            </div>

                            <!-- Back Link -->
                            <div class="mt-4 text-center">
                                <a href="{{ route('matches.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                                    Back to all skills
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
