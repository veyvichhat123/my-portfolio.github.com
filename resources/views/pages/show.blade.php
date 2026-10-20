@extends('layouts.app')

@section('title', $page->title . ' | ' . config('app.name'))

@section('content')
    <div class="mb-10 max-w-2xl">
        <h1 class="text-gradient pb-1 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ $page->title }}</h1>
    </div>

    <div class="max-w-3xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="rich">{!! $page->content !!}</div>
    </div>
@endsection
