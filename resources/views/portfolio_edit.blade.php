<x-app-layout>
    <x-slot name="title">
        Edit Portfolio
    </x-slot>

    <x-slot name="description">
        Edit your portfolio details.
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('portfolio.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 dark:text-gray-300">Title:</label>
                            <input type="text" name="title" id="title" value="{{ $portfolio->title }}" class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 dark:text-gray-300">Phone:</label>
                            <input type="text" name="phone" id="phone" value="{{ $portfolio->phone }}" class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 dark:text-gray-300">Email:</label>
                            <input type="email" name="email" id="email" value="{{ $portfolio->email }}" class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 dark:text-gray-300">Description:</label>
                            <textarea name="description" id="description" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">{{ $portfolio->description }}</textarea>
                        </div>
                        <div class="mb-4">
                            <fieldset>
                                <legend class="block text-gray-700 dark:text-gray-300">Tags:</legend>
                                <div class="mt-2 grid grid-cols-1 gap-2 sm:grid-cols-2">
                                    @foreach ($availableTags as $tagValue => $tagLabel)
                                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                            <input
                                                type="checkbox"
                                                name="tags[]"
                                                value="{{ $tagValue }}"
                                                @checked(in_array($tagValue, old('tags', $portfolio->tags ?? []), true))
                                                class="rounded border-gray-300">
                                            {{ $tagLabel }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('tags')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                @error('tags.*')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 dark:text-gray-300">Image:</label>
                            <input type="file" name="image" id="image" accept="image/*" class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">
                            @if ($portfolio->image)
                                <img src="{{ asset('storage/' . $portfolio->image) }}" alt="Current Image" class="mt-2 w-32 h-32 object-cover">
                            @endif
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
