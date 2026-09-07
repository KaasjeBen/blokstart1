<x-app-layout>

    <x-nav-link :href="route('portfolio.create')" :active="request()->routeIs('portfolio.create')">
                            {{ __('create portfolio') }}
                        </x-nav-link>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @foreach ($portfolios as $portfolio)
                        <div class="mb-4">
                            <a class="text-black-500 hover:text-blue-500" href="{{ route('portfolio.show', $portfolio->id) }}">{{ $portfolio->title }}</a>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>