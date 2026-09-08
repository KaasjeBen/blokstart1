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
                    @if ($portfolio->image)
                    <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}" class="mt-8 max-h-[34rem] w-full object-cover">
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
            <div class="mt-5 flex gap-3">
                <a href="{{ route('portfolio.edit', $portfolio->id) }}" class="inline-flex items-center rounded border border-[#172033] px-4 py-2 text-sm font-semibold text-[#172033] hover:bg-[#172033] hover:text-[#fbfaf7] dark:border-[#e9e5dc] dark:text-[#e9e5dc] dark:hover:bg-[#e9e5dc] dark:hover:text-[#172033]">Edit item</a>
                <form action="{{ route('portfolio.destroy', $portfolio->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this portfolio item?');" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center rounded border border-[#b4534b] px-4 py-2 text-sm font-semibold text-[#a23e37] hover:bg-[#a23e37] hover:text-white dark:text-[#e58d85] dark:hover:bg-[#a23e37]">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>