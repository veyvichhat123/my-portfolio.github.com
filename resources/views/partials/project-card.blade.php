<a href="{{ route('projects.show', $project) }}"
   class="group grid items-start gap-5 border-b b-line py-7 sm:grid-cols-[240px_1fr] sm:gap-8">
    @if ($project->thumbnail)
        <img src="{{ asset('storage/' . $project->thumbnail) }}"
             alt="{{ $project->tr('title') }}"
             loading="lazy"
             class="aspect-[4/3] w-full rounded-md object-cover">
    @else
        <div class="font-display flex aspect-[4/3] w-full items-center justify-center rounded-md bg-ink text-5xl text-white">
            {{ \Illuminate\Support\Str::of((string) $project->tr('title'))->substr(0, 1) }}
        </div>
    @endif

    <div>
        <h3 class="font-display text-3xl c-ink group-hover:underline group-hover:decoration-[#0E7C7B] group-hover:underline-offset-4">
            {{ $project->tr('title') }}
        </h3>

        @if ($project->tr('description'))
            <p class="mt-3 line-clamp-3 max-w-xl c-muted">{{ $project->tr('description') }}</p>
        @endif

        @if (! empty($project->technologies))
            <p class="mt-4 text-sm font-medium c-accent">{{ implode(', ', array_slice($project->technologies, 0, 5)) }}</p>
        @endif
    </div>
</a>
