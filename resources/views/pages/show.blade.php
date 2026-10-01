@extends('layouts.app')

@section('title', $page->title)

@section('content')
    <h1 class="mb-6 text-3xl font-bold">{{ $page->title }}</h1>
    <div class="rich">{!! $page->content !!}</div>
@endsection
