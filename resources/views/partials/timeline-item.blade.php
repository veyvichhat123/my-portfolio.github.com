{{-- Expects: $item, $title, $subtitle, $meta (optional), $summary (optional), $content (optional) --}}
<article class="grid gap-2 border-t b-line py-8 sm:grid-cols-[180px_1fr] sm:gap-8">
    <p class="text-sm font-medium c-muted sm:pt-2">
        @include('partials.date-range', ['item' => $item])
    </p>

    <div class="min-w-0">
        <div class="flex items-center gap-4">
            @if ($item->logo)
                <img src="{{ asset('storage/' . $item->logo) }}" alt="" loading="lazy"
                     class="h-12 w-12 flex-none rounded-md border b-line bg-white object-cover">
            @endif
            <div>
                <h3 class="font-display text-3xl c-ink">{{ $title }}</h3>
                <p class="font-medium">
                    {{ $subtitle }}
                    @if (! empty($meta)) <span class="c-muted font-normal">, {{ $meta }}</span> @endif
                </p>
            </div>
        </div>

        @if (! empty($summary))
            <p class="mt-4 max-w-2xl c-muted">{{ $summary }}</p>
        @endif

        @if (! empty($content))
            <div class="rich mt-4 max-w-2xl">{!! $content !!}</div>
        @endif
    </div>
</article>
