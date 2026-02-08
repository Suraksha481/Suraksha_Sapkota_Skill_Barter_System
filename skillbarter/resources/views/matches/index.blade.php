<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Find Skills') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search & Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('matches.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
                        <!-- Search Bar -->
                        <div class="flex-1">
                            <label for="query" class="block text-sm font-medium text-gray-700 mb-1">Search Skills</label>
                            <input type="text" name="query" id="query" value="{{ $query ?? '' }}"
                                   placeholder="Search by skill name..."
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Category Filter -->
                        <div class="w-full md:w-48">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category" id="category"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ ($category ?? '') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Level Filter -->
                        <div class="w-full md:w-40">
                            <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                            <select name="level" id="level"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Levels</option>
                                <option value="beginner" {{ ($level ?? '') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ ($level ?? '') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ ($level ?? '') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                <option value="expert" {{ ($level ?? '') == 'expert' ? 'selected' : '' }}>Expert</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                    class="w-full md:w-auto px-6 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Grid -->
            @if($matches->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($matches as $match)
                        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden {{ in_array($match->skill_id, $wantedSkillIds ?? []) ? 'ring-2 ring-green-500' : '' }}">
                            <!-- Wanted Skill Badge -->
                            @if(in_array($match->skill_id, $wantedSkillIds ?? []))
                                <div class="bg-green-500 text-white text-xs font-semibold px-3 py-1 text-center">
                                    ✓ Matches Your Wanted Skills
                                </div>
                            @endif

                            <div class="p-5">
                                <!-- Provider Info -->
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0">
                                        @if($match->user->avatar)
                                            <img src="{{ asset('storage/' . $match->user->avatar) }}"
                                                 alt="{{ $match->user->name }}"
                                                 class="h-12 w-12 rounded-full object-cover">
                                        @else
                                            <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center">
                                                <span class="text-white font-semibold text-lg">
                                                    {{ strtoupper(substr($match->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $match->user->name }}</p>
                                        <!-- Rating -->
                                        <div class="flex items-center">
                                            @php
                                                $rating = $match->user->feedbacksReceived->avg('rating') ?? 0;
                                            @endphp
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="h-4 w-4 {{ $i <= round($rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                            <span class="ml-1 text-xs text-gray-500">({{ number_format($rating, 1) }})</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Skill Info -->
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                    <a href="{{ route('matches.show', $match) }}" class="hover:text-indigo-600 transition">
                                        {{ $match->skill->name }}
                                    </a>
                                </h3>

                                <!-- Level Badge -->
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @switch($match->level)
                                        @case('beginner') bg-green-100 text-green-800 @break
                                        @case('intermediate') bg-blue-100 text-blue-800 @break
                                        @case('advanced') bg-purple-100 text-purple-800 @break
                                        @case('expert') bg-red-100 text-red-800 @break
                                        @default bg-gray-100 text-gray-800
                                    @endswitch">
                                    {{ ucfirst($match->level) }}
                                </span>

                                @if($match->price)
                                    <span class="ml-2 text-sm text-gray-600">
                                        ${{ number_format($match->price, 2) }}/hr
                                    </span>
                                @endif

                                <!-- Request Button -->
                                <div class="mt-4">
                                    <a href="{{ route('requests.create', $match) }}"
                                       class="block w-full text-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                        Request Session
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $matches->withQueryString()->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No skills found</h3>
                    <p class="mt-2 text-gray-500">Try adjusting your search or filter criteria.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
