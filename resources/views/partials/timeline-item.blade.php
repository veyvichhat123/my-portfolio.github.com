
@php
    $title    = $title ?? '';
    $subtitle = $subtitle ?? null;
    $meta     = $meta ?? null;
    $summary  = $summary ?? null;
    $content  = $content ?? null;
    $href     = $href ?? null;
    $logo     = $logo ?? null;

    $attrs = $item->getAttributes();

    $pick = fn (array $keys) => collect($keys)
        ->map(fn ($key) => $attrs[$key] ?? null)
        ->first(fn ($value) => filled($value));

    $fmt = function ($value) {
        if (blank($value)) {
            return null;
        }

        if (is_numeric($value) && strlen((string) $value) === 4) {
            return (string) $value;
        }

        try {
            return \Illuminate\Support\Carbon::parse($value)
                ->translatedFormat('M Y');
        } catch (\Throwable $e) {
            return (string) $value;
        }
    };

    $start = $fmt($pick([
        'start_date',
        'started_at',
        'start_year',
        'from',
    ]));

    $end = $fmt($pick([
        'end_date',
        'ended_at',
        'end_year',
        'to',
    ]));

    $isCurrent = (bool) (
        $attrs['is_current'] ?? $attrs['current'] ?? false
    ) || ($start && ! $end);

    $dateLabel = $start
        ? $start . ' – ' . ($end ?: __('Present'))
        : $end;

    $logoUrl = filled($logo)
        ? \Illuminate\Support\Facades\Storage::url($logo)
        : null;
@endphp

<article class="grid gap-x-10 md:grid-cols-[10rem_1fr]">

    {{-- Timeline date --}}
    <div class="hidden pt-2.5 text-right md:block">
        @if ($dateLabel)
            <p class="font-code text-sm font-medium text-slate-500">
                {{ $dateLabel }}
            </p>
        @endif
    </div>

    {{-- Timeline content --}}
    <div class="relative border-l-2 border-slate-200 pb-10 pl-6 last:pb-0 sm:pl-8">

        <span
            class="absolute -left-[9px] top-3 h-4 w-4 rounded-full ring-4 ring-slate-50 {{ $isCurrent ? 'dot-live' : 'bg-slate-300' }}"
            aria-hidden="true"
        ></span>

        <div class="lift group relative rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

            {{-- School or company logo --}}

            @if ($logoUrl)
                <div class="mb-6 flex justify-center">
                    <img
                        src="{{ $logoUrl }}"
                        alt="{{ $title }} logo"
                        loading="lazy"
                        class="h-50 w-50 rounded-2xl border border-slate-200 bg-white p-2 object-contain shadow-md transition-transform duration-300 hover:scale-105 sm:h-50 sm:w-50"
                    >
                </div>
            @endif


            {{-- Title and current status --}}
            <div class="flex flex-wrap items-start justify-between gap-x-4 gap-y-2">

                <h2 class="text-xl font-bold tracking-tight text-slate-900">
                    @if ($href)
                        <a
                            href="{{ $href }}"
                            class="transition-colors hover:text-indigo-700 after:absolute after:inset-0 after:rounded-2xl"
                        >
                            {{ $title }}
                        </a>
                    @else
                        {{ $title }}
                    @endif
                </h2>

                @if ($isCurrent)
                    <span class="chip">
                        {{ __('In progress') }}
                    </span>
                @endif

            </div>

            {{-- Subtitle --}}
            @if (filled($subtitle))
                <p class="mt-1 font-medium text-indigo-700">
                    {{ $subtitle }}
                </p>
            @endif

            {{-- Additional metadata --}}
            @if (filled($meta))
                <p class="mt-1 text-sm text-slate-500">
                    {{ $meta }}
                </p>
            @endif

            {{-- Summary --}}
            @if (filled($summary))
                <p class="mt-3 max-w-prose leading-relaxed text-slate-600">
                    {{ $summary }}
                </p>
            @endif

            {{-- Details link or expandable content --}}
            @if ($href)
                <p class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-slate-700 transition-colors group-hover:text-indigo-700">
                    {{ __('View details') }}

                    <svg
                        class="h-4 w-4 transition-transform group-hover:translate-x-1"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M5 12h14M13 6l6 6-6 6"/>
                    </svg>
                </p>

            @elseif (filled(strip_tags((string) $content)))
                <details class="group mt-4 border-t border-slate-100 pt-4">

                    <summary class="inline-flex cursor-pointer list-none items-center gap-1.5 text-sm font-semibold text-slate-700 hover:text-indigo-700 [&::-webkit-details-marker]:hidden">
                        <span class="group-open:hidden">
                            {{ __('Show details') }}
                        </span>

                        <span class="hidden group-open:inline">
                            {{ __('Hide details') }}
                        </span>
                    </summary>

                    <div class="rich mt-4">
                        {!! $content !!}
                    </div>

                </details>
            @endif

        </div>
    </div>
</article>
