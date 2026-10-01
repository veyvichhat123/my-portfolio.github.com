@extends('layouts.app')

@section('title', __('Projects') . ' | ' . config('app.name'))

@section('content')
    <h1 class="font-display mb-10 text-5xl c-ink sm:text-6xl">{{ __('Projects') }}</h1>

    @if ($projects->isEmpty())
        <p class="c-muted">{{ __('Nothing here yet.') }}</p>
    @else
        <div class="border-t b-line">
            @foreach ($projects as $project)
                @include('partials.project-card', ['project' => $project])
            @endforeach
        </div>
    @endif
@endsection
