@extends('layouts.app')

@section('title', $experience->tr('position') . ' · ' . $experience->tr('company') . ' | ' . config('app.name'))
@section('description', \Illuminate\Support\Str::limit((string) $experience->tr('description'), 155))

@section('content')
    @include('partials.detail', [
        'item'      => $experience,
        'backUrl'   => route('experience.index'),
        'backLabel' => __('Back to experience'),
        'title'     => $experience->tr('company'),
        'subtitle'  => $experience->tr('position'),
        'summary'   => $experience->tr('description'),
        'content'   => $experience->tr('content'),
        'facts'     => [
            __('Position') => $experience->tr('position'),
            __('Location') => $experience->tr('location'),
        ],
    ])
@endsection
