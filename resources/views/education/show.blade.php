@extends('layouts.app')

@section('title', $education->tr('school') . ' | ' . config('app.name'))
@section('description', \Illuminate\Support\Str::limit((string) $education->tr('description'), 155))

@section('content')
    @include('partials.detail', [
        'item'      => $education,
        'backUrl'   => route('education.index'),
        'backLabel' => __('Back to education'),
        'title'     => $education->tr('school'),
        'subtitle'  => trim($education->tr('degree') . ($education->tr('field') ? ', ' . $education->tr('field') : '')),
        'summary'   => $education->tr('description'),
        'content'   => $education->tr('content'),
        'facts'     => [
            __('Degree') => $education->tr('degree'),
            __('Field')  => $education->tr('field'),
        ],
    ])
@endsection
