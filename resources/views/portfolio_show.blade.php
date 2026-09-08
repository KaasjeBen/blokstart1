<x-app-layout>
    <x-slot name="title">
        {{ $portfolio->title }}
    </x-slot>

    <x-slot name="description">
        {{ $portfolio->description }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">{{ $portfolio->title }}</h1>
                    @if ($portfolio->image)
                    <img src="{{ asset('storage/' . $portfolio->image) }}" alt="{{ $portfolio->title }}" class="max-w-full h-auto">
                    @endif
                    <p>{{ $portfolio->phone }}</p>
                    <p>{{ $portfolio->email }}</p>
                    <p>{{ $portfolio->description }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('portfolio.edit', $portfolio->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                <form action="{{ route('portfolio.destroy', $portfolio->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>