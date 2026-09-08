<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Portfolio Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('portfolio.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Title
                        </label>

                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ old('title') }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300">

                        @error('title')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            class="mt-1 block w-full rounded-md border-gray-300">{{ old('description') }}</textarea>

                        @error('description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Email
                        </label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            class="mt-1 block w-full rounded-md border-gray-300">

                        @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Phone
                        </label>

                        <input
                            id="phone"
                            name="phone"
                            type="text"
                            value="{{ old('phone') }}"
                            class="mt-1 block w-full rounded-md border-gray-300">

                        @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <fieldset>
                            <legend class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tags
                            </legend>

                            <div class="mt-2 grid grid-cols-1 gap-2 sm:grid-cols-2">
                                @foreach ($availableTags as $tagValue => $tagLabel)
                                <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                    <input
                                        type="checkbox"
                                        name="tags[]"
                                        value="{{ $tagValue }}"
                                        @checked(in_array($tagValue, old('tags', []), true))
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
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Image
                        </label>

                        <input
                            id="image"
                            name="image"
                            type="file"
                            accept="image/*"
                            class="mt-1 block w-full rounded-md border-gray-300">

                        @error('image')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-primary-button>
                        {{ __('Create Portfolio Item') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>