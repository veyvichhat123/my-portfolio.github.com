@extends('layouts.app')

@section('title', __('Projects') . ' | ' . config('app.name'))

@section('content')

    <div class="mb-12 max-w-2xl sm:mb-16">
        <h1 class="text-gradient pb-1 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ __('Projects') }}</h1>
        <p class="mt-4 text-lg text-slate-600">{{ __('Things I have built, from idea to launch.') }}</p>
    </div>

    @if ($projects->isEmpty())
        <div class="rounded-2xl border-2 border-dashed border-slate-300 bg-white/60 px-6 py-16 text-center">
            <p class="font-code text-sm text-slate-500">// {{ __('Nothing here yet.') }}</p>
        </div>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($projects as $project)
                @include('partials.project-card', ['project' => $project])
            @endforeach
        </div>
    @endif

@endsection
