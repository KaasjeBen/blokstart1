<x-app-layout>
    <x-slot name="title">
        {{ $portfolio->name }}
    </x-slot>

    <x-slot name="description">
        {{ $portfolio->description }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">{{ $portfolio->title }}</h1>
                    <img src="{{ asset('storage/' . $portfolio->image) }}" alt="image">
                    <p>{{ $portfolio->phone }}</p>
                    <p>{{ $portfolio->email }}</p>
                    <p>{{ $portfolio->description }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>