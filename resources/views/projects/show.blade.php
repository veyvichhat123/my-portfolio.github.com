@extends('layouts.app')

@section('title', $project->tr('title') . ' | ' . config('app.name'))
@section('description', \Illuminate\Support\Str::limit((string) $project->tr('description'), 155))

@push('meta')
    <meta property="og:title" content="{{ $project->tr('title') }}">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit((string) $project->tr('description'), 155) }}">
    @if ($project->thumbnail)
        <meta property="og:image" content="{{ asset('storage/' . $project->thumbnail) }}">
    @endif
@endpush

@section('content')
    <a href="{{ route('projects.index') }}" class="link-accent c-accent text-sm font-semibold">&larr; {{ __('Back to projects') }}</a>

    <h1 class="font-display mt-6 text-5xl c-ink sm:text-6xl">{{ $project->tr('title') }}</h1>

    @if ($project->tr('description'))
        <p class="mt-5 max-w-2xl text-lg c-muted">{{ $project->tr('description') }}</p>
    @endif

    <div class="mt-5 flex flex-wrap items-center gap-3">
        @if ($project->url)
            <a href="{{ $project->url }}" target="_blank" rel="noopener"
               class="bg-ink rounded-md px-5 py-2.5 text-sm font-semibold text-white hover:opacity-90">{{ __('Live demo') }}</a>
        @endif
        @if ($project->github_url)
            <a href="{{ $project->github_url }}" target="_blank" rel="noopener"
               class="b-line rounded-md border bg-white px-5 py-2.5 text-sm font-semibold c-ink hover:bg-gray-50">{{ __('GitHub') }}</a>
        @endif
    </div>

    @if ($project->thumbnail)
        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->tr('title') }}"
             class="mt-8 w-full rounded-lg border b-line object-cover">
    @endif

    @if (! empty($project->technologies))
        <div class="mt-8">
            <h2 class="mb-3 text-sm font-semibold c-muted">{{ __('Technologies') }}</h2>
            <div class="flex flex-wrap gap-2">
                @foreach ($project->technologies as $tech)
                    <span class="b-line rounded-md border bg-white px-3 py-1 text-sm font-medium c-ink">{{ $tech }}</span>
                @endforeach
            </div>
        </div>
    @endif

    @if ($project->tr('content'))
        <section class="mt-10">
            <h2 class="font-display mb-5 text-4xl c-ink">{{ __('Highlights') }}</h2>
            <div class="rich max-w-3xl">{!! $project->tr('content') !!}</div>
        </section>
    @endif

    @if ($project->video_embed_url || $project->video_file)
        <section class="mt-10">
            <h2 class="font-display mb-5 text-4xl c-ink">{{ __('Video') }}</h2>
            @if ($project->video_embed_url)
                <div class="aspect-video w-full overflow-hidden rounded-lg border b-line bg-black">
                    <iframe src="{{ $project->video_embed_url }}" class="h-full w-full" loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
            @else
                <video controls preload="metadata" class="w-full rounded-lg border b-line bg-black">
                    <source src="{{ asset('storage/' . $project->video_file) }}">
                </video>
            @endif
        </section>
    @endif

    @if (! empty($project->gallery))
        <section class="mt-10">
            <h2 class="font-display mb-5 text-4xl c-ink">{{ __('Gallery') }}</h2>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($project->gallery as $image)
                    <a href="{{ asset('storage/' . $image) }}" target="_blank" rel="noopener">
                        <img src="{{ asset('storage/' . $image) }}" alt="" loading="lazy"
                             class="aspect-video w-full rounded-lg border b-line object-cover transition hover:opacity-90">
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection
