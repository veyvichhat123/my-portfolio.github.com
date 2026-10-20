@extends('layouts.app')

@section('title', __('Education') . ' | ' . config('app.name'))

@section('content')

    <div class="mb-12 max-w-2xl sm:mb-16">
        <h1 class="text-gradient pb-1 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ __('Education') }}</h1>
        <p class="mt-4 text-lg text-slate-600">{{ __('Where I studied and what I learned along the way.') }}</p>
    </div>

    @if ($education->isEmpty())
        <div class="rounded-2xl border-2 border-dashed border-slate-300 bg-white/60 px-6 py-16 text-center">
            <p class="font-code text-sm text-slate-500">// {{ __('Nothing here yet.') }}</p>
        </div>
    @else
        <div>
            @foreach ($education as $item)
                @include('partials.timeline-item', [
                    'item'     => $item,
                    'href'     => route('education.show', $item),
                    'title'    => $item->tr('school'),
                    'subtitle' => trim($item->tr('degree') . ($item->tr('field') ? ', ' . $item->tr('field') : '')),
                    'summary'  => $item->tr('description'),
                    'content'  => $item->tr('content'),
                    'logo' => $item->logo,
                ])
            @endforeach
        </div>
    @endif

@endsection
