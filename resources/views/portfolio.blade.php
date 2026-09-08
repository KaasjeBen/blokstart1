<x-app-layout>

    <x-nav-link :href="route('portfolio.create')" :active="request()->routeIs('portfolio.create')">
        {{ __('create portfolio') }}
    </x-nav-link>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="GET" action="{{ route('portfolio.index') }}" class="mb-6 flex items-end gap-4">
                        <div>
                            <label for="tag" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search by tag</label>
                            <select id="tag" name="tag" class="mt-1 rounded-md border-gray-300">
                                <option value="">All tags</option>
                                @foreach ($availableTags as $tagValue => $tagLabel)
                                <option value="{{ $tagValue }}" @selected($selectedTag===$tagValue)>{{ $tagLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-primary-button>Search</x-primary-button>
                    </form>

                    @foreach ($portfolios as $portfolio)
                    <div class="mb-4">
                        <a class="text-black-500 hover:text-blue-500" href="{{ route('portfolio.show', $portfolio->id) }}">{{ $portfolio->title }}</a>
                        <div class="mt-1 flex flex-wrap gap-2">
                            @foreach ($portfolio->tags ?? [] as $tag)
                            <span class="rounded bg-gray-100 px-2 py-1 text-xs text-gray-700 dark:bg-gray-700 dark:text-gray-200">{{ $availableTags[$tag] ?? $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>