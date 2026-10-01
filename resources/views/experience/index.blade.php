@extends('layouts.app')

@section('title', __('Experience') . ' | ' . config('app.name'))

@section('content')
    <h1 class="font-display mb-10 text-5xl c-ink sm:text-6xl">{{ __('Experience') }}</h1>

    @if ($experiences->isEmpty())
        <p class="c-muted">{{ __('Nothing here yet.') }}</p>
    @else
        <div class="border-b b-line">
            @foreach ($experiences as $item)
                @include('partials.timeline-item', [
                    'item' => $item,
                    'title' => $item->tr('company'),
                    'subtitle' => $item->tr('position'),
                    'meta' => $item->tr('location'),
                    'summary' => $item->tr('description'),
                    'content' => $item->tr('content'),
                ])
            @endforeach
        </div>
    @endif
@endsection
