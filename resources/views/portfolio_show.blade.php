<x-app-layout>
    <x-slot name="title">
        {{ $portfolio->title }}
    </x-slot>

    <x-slot name="description">
        {{ $portfolio->description }}
    </x-slot>

    <div class="py-10 sm:py-14">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="portfolio-panel overflow-hidden">
                <div class="p-6 sm:p-10">
                    <p class="portfolio-kicker">Portfolio item {{ str_pad((string) $portfolio->id, 2, '0', STR_PAD_LEFT) }}</p>
                    <h1 class="mt-2 text-4xl font-semibold tracking-tight text-[#172033] dark:text-[#e9e5dc]">{{ $portfolio->title }}</h1>
                    @if ($portfolio->imageUrls)
                    <div class="mt-8 grid gap-4 sm:grid-cols-2">
                        @foreach ($portfolio->imageUrls as $imageUrl)
                        <img src="{{ $imageUrl }}" alt="{{ $portfolio->title }}" class="max-h-[34rem] w-full object-cover">
                        @endforeach
                    </div>
                    @endif
                    <p class="mt-8 max-w-2xl text-base leading-7 text-[#4e5868] dark:text-[#c7cdd6]">{{ $portfolio->description }}</p>
                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach ($portfolio->tags ?? [] as $tag)
                        <span class="portfolio-tag">{{ \App\Models\Portfolio::availableTags()[$tag] ?? $tag }}</span>
                        @endforeach
                    </div>
                    <div class="mt-8 grid gap-3 border-t border-[#d8d1c4] pt-5 text-sm text-[#5d6573] dark:border-[#303949] dark:text-[#aeb6c4] sm:grid-cols-2">
                        <p>{{ $portfolio->email }}</p>
                        <p>{{ $portfolio->phone }}</p>
                    </div>
                </div>
            </div>
            @auth
            <div x-data="{ confirmingDeletion: @json($errors->has('title_confirmation')) }" class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('portfolio.edit', $portfolio->id) }}" class="inline-flex items-center rounded border border-[#172033] px-4 py-2 text-sm font-semibold text-[#172033] transition hover:bg-[#172033] hover:text-[#fbfaf7] focus:outline-none focus:ring-2 focus:ring-[#b06b35] focus:ring-offset-2 dark:border-[#e9e5dc] dark:text-[#e9e5dc] dark:hover:bg-[#e9e5dc] dark:hover:text-[#172033] dark:focus:ring-[#e8a15b] dark:focus:ring-offset-[#121722]">Edit item</a>
                <button type="button" x-show="!confirmingDeletion" x-on:click="confirmingDeletion = true" class="inline-flex items-center rounded border border-[#b4534b] px-4 py-2 text-sm font-semibold text-[#a23e37] transition hover:bg-[#a23e37] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#b4534b] focus:ring-offset-2 dark:border-[#e58d85] dark:text-[#f0aaa2] dark:hover:bg-[#b4534b] dark:hover:text-white dark:focus:ring-[#e58d85] dark:focus:ring-offset-[#121722]">Delete</button>
                <form x-show="confirmingDeletion" action="{{ route('portfolio.destroy', $portfolio->id) }}" method="POST" class="basis-full max-w-2xl space-y-4 rounded-lg border border-[#e5b8b2] bg-[#fff7f5] p-5 shadow-sm dark:border-[#75423e] dark:bg-[#2a1d21]">
                    @csrf
                    @method('DELETE')
                    <div class="space-y-1">
                        <p class="text-sm font-semibold text-[#8f322c] dark:text-[#f0aaa2]">Delete this project?</p>
                        <p class="text-sm leading-6 text-[#654a47] dark:text-[#d9b9b5]">This action cannot be undone. Type the project name to confirm:</p>
                    </div>
                    <label for="title_confirmation" class="block text-sm font-semibold text-[#172033] dark:text-[#e9e5dc]">{{ $portfolio->title }}</label>
                    <input id="title_confirmation" name="title_confirmation" type="text" required autocomplete="off" placeholder="Enter the project name" class="block w-full rounded border border-[#c9aaa5] bg-white px-3 py-2 text-sm text-[#172033] placeholder:text-[#8f7773] focus:border-[#a23e37] focus:outline-none focus:ring-2 focus:ring-[#e5b8b2] dark:border-[#75423e] dark:bg-[#1a2130] dark:text-[#e9e5dc] dark:placeholder:text-[#ad8984] dark:focus:border-[#e58d85] dark:focus:ring-[#75423e]" aria-describedby="title-confirmation-error" value="{{ old('title_confirmation') }}">
                    @error('title_confirmation')
                    <p id="title-confirmation-error" class="text-sm text-[#a23e37] dark:text-[#f0aaa2]">{{ $message }}</p>
                    @enderror
                    <div class="flex flex-wrap gap-3">
                        <button type="submit" class="inline-flex items-center rounded bg-[#a23e37] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#8f322c] focus:outline-none focus:ring-2 focus:ring-[#b4534b] focus:ring-offset-2 dark:bg-[#b4534b] dark:hover:bg-[#c5655d] dark:focus:ring-[#e58d85] dark:focus:ring-offset-[#2a1d21]">Confirm deletion</button>
                        <button type="button" x-on:click="confirmingDeletion = false" class="inline-flex items-center rounded border border-[#172033] px-4 py-2 text-sm font-semibold text-[#172033] transition hover:bg-[#172033] hover:text-[#fbfaf7] focus:outline-none focus:ring-2 focus:ring-[#b06b35] focus:ring-offset-2 dark:border-[#e9e5dc] dark:text-[#e9e5dc] dark:hover:bg-[#e9e5dc] dark:hover:text-[#172033] dark:focus:ring-[#e8a15b] dark:focus:ring-offset-[#2a1d21]">Cancel</button>
                    </div>
                </form>
            </div>
            @endauth
        </div>
    </div>
</x-app-layout>