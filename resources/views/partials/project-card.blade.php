
@php
    $thumb = filled($project->thumbnail)
        ? \Illuminate\Support\Facades\Storage::url($project->thumbnail)
        : null;
@endphp

<article class="lift group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    {{-- Project thumbnail --}}
    <div class="aspect-video overflow-hidden bg-slate-100">

        @if ($thumb)
            <img
                src="{{ $thumb }}"
                alt="{{ $project->tr('title') }}"
                loading="lazy"
                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
            >
        @else
            <div
                class="logo-badge font-code flex h-full w-full items-center justify-center text-3xl font-bold text-white"
                aria-hidden="true"
            >
                &lt;/&gt;
            </div>
        @endif

    </div>

    <div class="flex flex-1 flex-col p-5">

        {{-- Project title --}}
        <h2 class="text-lg font-bold tracking-tight text-slate-900">
            <a
                href="{{ route('projects.show', $project) }}"
                class="transition-colors hover:text-indigo-700 after:absolute after:inset-0"
            >
                {{ $project->tr('title') }}
            </a>
        </h2>

        {{-- Description --}}
        @if ($project->tr('description'))
            <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-slate-600">
                {{ $project->tr('description') }}
            </p>
        @endif

        {{-- Technologies --}}
        @if (!empty($project->technologies))
            <div class="mt-4 flex flex-wrap gap-1.5">

                @foreach (array_slice((array) $project->technologies, 0, 4) as $tech)
                    <span class="chip">
                        {{ $tech }}
                    </span>
                @endforeach

                @if (count((array) $project->technologies) > 4)
                    <span class="chip">
                        +{{ count((array) $project->technologies) - 4 }}
                    </span>
                @endif

            </div>
        @endif

        {{-- View details --}}
        <p class="mt-auto inline-flex items-center gap-1.5 pt-5 text-sm font-semibold text-slate-700 transition-colors group-hover:text-indigo-700">
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

    </div>
</article>
