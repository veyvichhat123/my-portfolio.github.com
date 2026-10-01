@extends('layouts.app')

@section('title', __('Education') . ' | ' . config('app.name'))

@section('content')
    <h1 class="font-display mb-10 text-5xl c-ink sm:text-6xl">{{ __('Education') }}</h1>

    @if ($education->isEmpty())
        <p class="c-muted">{{ __('Nothing here yet.') }}</p>
    @else
        <div class="border-b b-line">
            @foreach ($education as $item)
                @include('partials.timeline-item', [
                    'item' => $item,
                    'title' => $item->tr('school'),
                    'subtitle' => trim($item->tr('degree') . ($item->tr('field') ? ', ' . $item->tr('field') : '')),
                    'summary' => $item->tr('description'),
                    'content' => $item->tr('content'),
                ])
            @endforeach
        </div>
    @endif
@endsection
