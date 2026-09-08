<x-app-layout>
    <div class="py-10 sm:py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-5 border-b border-[#d8d1c4] pb-8 dark:border-[#303949] sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="portfolio-kicker">Selected work</p>
                    <h1 class="mt-2 text-4xl font-semibold tracking-tight text-[#172033] dark:text-[#e9e5dc]">portfolio / werk.</h1>
                    <p class="mt-3 max-w-xl text-sm leading-6 text-[#5d6573] dark:text-[#aeb6c4]">een lijst met portfolio's, ideeën en projecten.</p>
                </div>
                <a href="{{ route('portfolio.create') }}" class="inline-flex items-center justify-center rounded border border-[#172033] px-4 py-2 text-sm font-semibold text-[#172033] transition hover:bg-[#172033] hover:text-[#fbfaf7] dark:border-[#e9e5dc] dark:text-[#e9e5dc] dark:hover:bg-[#e9e5dc] dark:hover:text-[#172033]">Create portfolio</a>
            </div>

            <div class="portfolio-panel mb-8 p-5">
                <form method="GET" action="{{ route('portfolio.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                    <div class="flex-1">
                        <label for="tag" class="portfolio-kicker">Filter by tag</label>
                        <select id="tag" name="tag" class="mt-2 block w-full rounded border-[#d8d1c4] bg-[#fbfaf7] text-sm text-[#172033] focus:border-[#d9944f] focus:ring-[#d9944f] dark:border-[#3b4658] dark:bg-[#1a2130] dark:text-[#e9e5dc]">
                            <option value="">All tags</option>
                            @foreach ($availableTags as $tagValue => $tagLabel)
                            <option value="{{ $tagValue }}" @selected($selectedTag===$tagValue)>{{ $tagLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-primary-button>Filter work</x-primary-button>
                </form>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                @foreach ($portfolios as $portfolio)
                <article class="portfolio-panel overflow-hidden transition hover:-translate-y-0.5 hover:border-[#b9753d]">
                    @if ($portfolio->image)
                    <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}" class="aspect-[16/9] w-full object-cover">
                    @else
                    <div class="flex aspect-[16/9] items-end bg-[#e8e0d2] p-5 dark:bg-[#242d3b]"><span class="portfolio-kicker">No image</span></div>
                    @endif
                    <div class="p-5">
                        <p class="text-xs text-[#8b6d52] dark:text-[#d99a61]">{{ str_pad((string) $portfolio->id, 2, '0', STR_PAD_LEFT) }}</p>
                        <a class="mt-2 block text-xl font-semibold text-[#172033] hover:text-[#b06b35] dark:text-[#e9e5dc] dark:hover:text-[#e8a15b]" href="{{ route('portfolio.show', $portfolio->id) }}">{{ $portfolio->title }}</a>
                        <p class="mt-2 line-clamp-2 text-sm leading-6 text-[#5d6573] dark:text-[#aeb6c4]">{{ $portfolio->description }}</p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach ($portfolio->tags ?? [] as $tag)
                            <span class="portfolio-tag">{{ $availableTags[$tag] ?? $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
            @if ($portfolios->isEmpty())
            <div class="portfolio-panel p-10 text-center">
                <p class="portfolio-kicker">Nothing found</p>
                <p class="mt-2 text-sm text-[#5d6573] dark:text-[#aeb6c4]">Try another tag or create your first portfolio item.</p>
            </div>
            @endif
        </div>
    </div>
    </div>
</x-app-layout>