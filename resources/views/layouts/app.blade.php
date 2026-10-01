<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', config('app.name'))</title>
<meta
    name="description"
    content="@yield('description', __('Here you can see the projects I built, where I worked, and what I studied.'))"
>
@stack('meta')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
>
<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+Khmer:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>
@vite(['resources/css/app.css', 'resources/js/app.js'])

@php
    /*
    |--------------------------------------------------------------------------
    | Get Active Parent Menus
    |--------------------------------------------------------------------------
    */

    $menus = \App\Models\Menu::with('children')
        ->whereNull('parent_id')
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();
@endphp

<style>

    body {
        font-family: 'Inter', 'Noto Sans Khmer', system-ui, sans-serif;
    }

    html[lang="km"] body {
        font-family: 'Noto Sans Khmer', 'Inter', system-ui, sans-serif;
        line-height: 1.8;
    }

    /*
    |--------------------------------------------------------------------------
    | Rich Editor Content
    |--------------------------------------------------------------------------
    */

    .rich {
        color: #374151;
        line-height: 1.75;
    }

    .rich h1,
    .rich h2,
    .rich h3 {
        font-weight: 700;
        color: #111827;
        margin: 1.5em 0 .5em;
    }

    .rich h1 {
        font-size: 1.75rem;
    }

    .rich h2 {
        font-size: 1.5rem;
    }

    .rich h3 {
        font-size: 1.25rem;
    }

    .rich p {
        margin: 0 0 1em;
    }

    .rich ul {
        list-style: disc;
        padding-left: 1.5rem;
        margin: 0 0 1em;
    }

    .rich ol {
        list-style: decimal;
        padding-left: 1.5rem;
        margin: 0 0 1em;
    }

    .rich a {
        color: #d97706;
        text-decoration: underline;
    }

    .rich img {
        max-width: 100%;
        height: auto;
        border-radius: .75rem;
        margin: 1em 0;
    }

    .rich blockquote {
        border-left: 4px solid #e5e7eb;
        padding-left: 1rem;
        color: #6b7280;
        margin: 1em 0;
    }

    .rich pre,
    .rich code {
        background: #f3f4f6;
        border-radius: .375rem;
    }

    .rich pre {
        padding: 1rem;
        overflow-x: auto;
    }

    .rich code {
        padding: .1rem .3rem;
    }

</style>

</head>

<body class="bg-gray-50 text-gray-800 antialiased">

<header class="sticky top-0 z-30 border-b border-gray-200 bg-white/90 backdrop-blur">

<div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">

    {{-- Logo / Website Name --}}
    <a
        href="{{ route('home') }}"
        class="text-lg font-bold text-gray-900"
    >
        {{ config('app.name') }}
    </a>


    {{-- Navigation --}}
    <nav class="flex items-center gap-1 text-sm font-medium sm:gap-2">

        @foreach ($menus as $menu)

            @php

                /*
                |--------------------------------------------------------------------------
                | Determine Menu URL
                |--------------------------------------------------------------------------
                */

                if ($menu->page_type === 'route') {

                    $url = route($menu->slug);

                } elseif ($menu->page_type === 'page') {

                    $url = route('page.show', $menu->slug);

                } else {

                    $url = url($menu->slug);

                }

                /*
                |--------------------------------------------------------------------------
                | Menu Title
                |--------------------------------------------------------------------------
                */

                $menuTitle = app()->getLocale() === 'km'
                    ? ($menu->title_km ?? $menu->title_en)
                    : $menu->title_en;

            @endphp


            {{-- Parent Menu Without Children --}}
            @if ($menu->children->isEmpty())

                <a
                    href="{{ $url }}"
                    class="rounded-lg px-2 py-2 sm:px-3
                    {{ request()->url() === $url
                        ? 'bg-amber-100 text-amber-800'
                        : 'text-gray-600 hover:bg-gray-100' }}"
                >
                    {{ $menuTitle }}
                </a>


            {{-- Parent Menu With Children --}}
            @else

                <div class="relative group">

                    <a
                        href="{{ $url }}"
                        class="rounded-lg px-2 py-2 sm:px-3 text-gray-600 hover:bg-gray-100"
                    >
                        {{ $menuTitle }}

                        <span class="ml-1 text-xs">
                            ▼
                        </span>
                    </a>


                    {{-- Sub Menu --}}
                    <div
                        class="absolute left-0 top-full hidden min-w-48 pt-2 group-hover:block"
                    >

                        <div class="rounded-xl border border-gray-200 bg-white py-2 shadow-lg">

                            @foreach ($menu->children as $child)

                                @php

                                    if ($child->page_type === 'route') {

                                        $childUrl = route($child->slug);

                                    } elseif ($child->page_type === 'page') {

                                        $childUrl = route(
                                            'page.show',
                                            $child->slug
                                        );

                                    } else {

                                        $childUrl = url($child->slug);

                                    }

                                    $childTitle = app()->getLocale() === 'km'
                                        ? ($child->title_km ?? $child->title_en)
                                        : $child->title_en;

                                @endphp

                                <a
                                    href="{{ $childUrl }}"
                                    class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900"
                                >
                                    {{ $childTitle }}
                                </a>

                            @endforeach

                        </div>

                    </div>

                </div>

            @endif

        @endforeach


        {{-- Divider --}}
        <span class="mx-1 hidden h-5 w-px bg-gray-200 sm:block"></span>


        {{-- Language Switcher --}}
        <div class="flex overflow-hidden rounded-lg border border-gray-200 text-xs">

            <a
                href="{{ route('lang.switch', 'en') }}"
                class="px-2 py-1.5
                {{ app()->getLocale() === 'en'
                    ? 'bg-gray-900 text-white'
                    : 'text-gray-600 hover:bg-gray-100' }}"
            >
                EN
            </a>

            <a
                href="{{ route('lang.switch', 'km') }}"
                class="px-2 py-1.5
                {{ app()->getLocale() === 'km'
                    ? 'bg-gray-900 text-white'
                    : 'text-gray-600 hover:bg-gray-100' }}"
            >
                ខ្មែរ
            </a>

        </div>

    </nav>

</div>

</header>

{{-- Main Content --}}

<main class="mx-auto max-w-6xl px-4 py-10">

@yield('content')

</main>

{{-- Footer --}}

<footer class="border-t border-gray-200 bg-white">

<div class="mx-auto max-w-6xl px-4 py-6 text-center text-sm text-gray-500">

    &copy; {{ date('Y') }}
    {{ config('app.name') }}.

    {{ __('All rights reserved.') }}

</div>

</footer>

</body>
</html>
