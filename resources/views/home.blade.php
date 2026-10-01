@extends('layouts.app')

@section('title', config('app.name'))

@section('content')
    {{-- Hero --}}
    <section class="rounded-3xl bg-gradient-to-br from-amber-100 via-orange-50 to-white px-6 py-16 text-center sm:py-24">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">{{ __('Welcome to my portfolio') }}</h1>
        <p class="mx-auto mt-4 max-w-2xl text-gray-600">
            {{ __('Here you can see the projects I built, where I worked, and what I studied.') }}
        </p>
        <a href="{{ route('projects.index') }}"
           class="mt-8 inline-block rounded-xl bg-amber-500 px-6 py-3 font-semibold text-white shadow hover:bg-amber-600">
            {{ __('View my projects') }}
        </a>
    </section>

    {{-- Featured projects --}}
    <section class="mt-16">
        <div class="mb-6 flex items-end justify-between">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Featured Projects') }}</h2>
            <a href="{{ route('projects.index') }}" class="text-sm font-medium text-amber-700 hover:underline">{{ __('View all') }} &rarr;</a>
        </div>

        @if ($featured->isEmpty())
            <p class="text-gray-500">{{ __('Nothing here yet.') }}</p>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featured as $project)
                    @include('partials.project-card', ['project' => $project])
                @endforeach
            </div>
        @endif
    </section>

    {{-- Latest experience --}}
    <section class="mt-16">
        <div class="mb-6 flex items-end justify-between">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Latest Experience') }}</h2>
            <a href="{{ route('experience.index') }}" class="text-sm font-medium text-amber-700 hover:underline">{{ __('View all') }} &rarr;</a>
        </div>

        @if ($experiences->isEmpty())
            <p class="text-gray-500">{{ __('Nothing here yet.') }}</p>
        @else
            <div class="space-y-4">
                @foreach ($experiences as $item)
                    @include('partials.timeline-item', [
                        'item' => $item,
                        'title' => $item->tr('company'),
                        'subtitle' => $item->tr('position'),
                        'meta' => $item->tr('location'),
                        'summary' => $item->tr('description'),
                    ])
                @endforeach
            </div>
        @endif
    </section>
@endsection
