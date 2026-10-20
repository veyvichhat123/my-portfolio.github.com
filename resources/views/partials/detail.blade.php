
@php
    $subtitle = $subtitle ?? null;
    $summary  = $summary ?? null;
    $content  = $content ?? null;
    $facts    = $facts ?? [];

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

    $facts = collect([__('Period') => $dateLabel])
        ->merge($facts)
        ->filter(fn ($value) => filled($value));

    $hasContent = filled(strip_tags((string) $content));

    $logo = $attrs['logo'] ?? null;

    $logoUrl = filled($logo)
        ? \Illuminate\Support\Facades\Storage::url($logo)
        : null;
@endphp

<a
    href="{{ $backUrl }}"
    class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-600 transition-colors hover:text-indigo-700"
>
    <svg
        class="h-4 w-4"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2.5"
        stroke-linecap="round"
        stroke-linejoin="round"
        aria-hidden="true"
    >
        <path d="M19 12H5M11 18l-6-6 6-6"/>
    </svg>

    {{ $backLabel }}
</a>

<header class="mt-6 max-w-3xl">

    {{-- School or company logo --}}

    @if ($logoUrl)
        <div class="mb-8 flex justify-center">
            <img
                src="{{ $logoUrl }}"
                alt="{{ $title }} logo"
                loading="lazy"
                class="h-80 w-60 rounded-2xl border border-slate-100 bg-white p-3 object-contain shadow-md sm:h-80 sm:w-60"
            >
        </div>
    @endif

    @if ($isCurrent)
        <span class="chip mb-4">
            {{ __('In progress') }}
        </span>
    @endif

    <h1 class="text-gradient pb-1 text-4xl font-extrabold tracking-tight sm:text-5xl">
        {{ $title }}
    </h1>

    @if (filled($subtitle))
        <p class="mt-3 text-xl font-medium text-indigo-700">
            {{ $subtitle }}
        </p>
    @endif

    @if (filled($summary))
        <p class="mt-4 max-w-prose text-lg leading-relaxed text-slate-600">
            {{ $summary }}
        </p>
    @endif

</header>

<div class="mt-10 grid gap-8 lg:grid-cols-[1fr_17rem] lg:items-start">

    {{-- Facts panel --}}
    @if ($facts->isNotEmpty())
        <aside class="order-first rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:order-last lg:sticky lg:top-24">
            <dl class="space-y-4">

                @foreach ($facts as $label => $value)
                    <div>
                        <dt class="text-xs font-semibold text-slate-500">
                            {{ $label }}
                        </dt>

                        <dd class="mt-0.5 font-medium text-slate-900">
                            {{ $value }}
                        </dd>
                    </div>
                @endforeach

            </dl>
        </aside>
    @endif

    {{-- Main content --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

        @if ($hasContent)
            <div class="rich">
                {!! $content !!}
            </div>
        @else
            <p class="font-code text-sm text-slate-500">
                // {{ __('No further details yet.') }}
            </p>
        @endif

    </div>

</div>
