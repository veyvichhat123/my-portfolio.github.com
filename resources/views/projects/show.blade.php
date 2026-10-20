@extends('layouts.app')

@section('title', $project->tr('title') . ' | ' . config('app.name'))
@section('description', \Illuminate\Support\Str::limit((string) $project->tr('description'), 155))

@push('meta')
    <meta property="og:title" content="{{ $project->tr('title') }}">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit((string) $project->tr('description'), 155) }}">
    @if ($project->thumbnail)
        <meta property="og:image" content="{{ \Illuminate\Support\Facades\Storage::url($project->thumbnail) }}">
    @endif
@endpush

@section('content')

    <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-600 transition-colors hover:text-indigo-700">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
        {{ __('Back to projects') }}
    </a>

    <header class="mt-6 max-w-3xl">
        <h1 class="text-gradient pb-1 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ $project->tr('title') }}</h1>

        @if ($project->tr('description'))
            <p class="mt-4 max-w-prose text-lg leading-relaxed text-slate-600">{{ $project->tr('description') }}</p>
        @endif

        @if ($project->url || $project->github_url)
            <div class="mt-6 flex flex-wrap items-center gap-3">
                @if ($project->url)
                    <a href="{{ $project->url }}" target="_blank" rel="noopener" class="btn-gradient">{{ __('Live demo') }}</a>
                @endif
                @if ($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank" rel="noopener"
                       class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-5 py-[.7rem] font-semibold text-slate-800 transition hover:border-indigo-300 hover:text-indigo-700">{{ __('GitHub') }}</a>
                @endif
            </div>
        @endif
    </header>

    @if ($project->thumbnail)
        <img src="{{ \Illuminate\Support\Facades\Storage::url($project->thumbnail) }}" alt="{{ $project->tr('title') }}"
             class="mt-10 w-full rounded-2xl border border-slate-200 object-cover shadow-sm">
    @endif

    <div class="mt-10 grid gap-8 lg:grid-cols-[1fr_17rem] lg:items-start">

        @if (! empty($project->technologies))
            <aside class="order-first rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:order-last lg:sticky lg:top-24">
                <h2 class="text-xs font-semibold text-slate-500">{{ __('Technologies') }}</h2>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($project->technologies as $tech)
                        <span class="chip">{{ $tech }}</span>
                    @endforeach
                </div>
            </aside>
        @endif

        <div class="space-y-8">

            @if ($project->tr('content'))
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <h2 class="mb-4 text-2xl font-bold tracking-tight text-slate-900">{{ __('Highlights') }}</h2>
                    <div class="rich">{!! $project->tr('content') !!}</div>
                </section>
            @endif

            @if ($project->video_embed_url || $project->video_file)
                <section>
                    <h2 class="mb-4 text-2xl font-bold tracking-tight text-slate-900">{{ __('Video') }}</h2>
                    @if ($project->video_embed_url)
                        <div class="aspect-video w-full overflow-hidden rounded-2xl border border-slate-200 bg-black shadow-sm">
                            <iframe src="{{ $project->video_embed_url }}" class="h-full w-full" loading="lazy"
                                    title="{{ $project->tr('title') }}"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        </div>
                    @else
                        <video controls preload="metadata" class="w-full rounded-2xl border border-slate-200 bg-black shadow-sm">
                            <source src="{{ \Illuminate\Support\Facades\Storage::url($project->video_file) }}">
                        </video>
                    @endif
                </section>
            @endif

        </div>
    </div>

    @if (! empty($project->gallery))
        <section class="mt-12">
            <h2 class="mb-4 text-2xl font-bold tracking-tight text-slate-900">{{ __('Gallery') }}</h2>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($project->gallery as $image)
                    <a href="{{ \Illuminate\Support\Facades\Storage::url($image) }}" target="_blank" rel="noopener" class="lift block overflow-hidden rounded-2xl border border-slate-200 bg-white">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($image) }}" alt="" loading="lazy" class="aspect-video w-full object-cover">
                    </a>
                @endforeach
            </div>
        </section>
    @endif

@endsection
