<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
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
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&family=Noto+Sans+Khmer:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>
@vite(['resources/css/app.css', 'resources/js/app.js'])

{{-- Marks that JS is available, so scroll-reveal can hide things safely --}}
<script>document.documentElement.classList.add('js');</script>

@php
    /*
    |--------------------------------------------------------------------------
    | Build the navigation once (parents + children, URLs, titles, active state)
    |--------------------------------------------------------------------------
    */

    $isKm = app()->getLocale() === 'km';

    $resolveUrl = function ($item) {
        if ($item->page_type === 'route') {
            return route($item->slug);
        }

        if ($item->page_type === 'page') {
            return route('page.show', $item->slug);
        }

        return url($item->slug);
    };

    $resolveTitle = fn ($item) => $isKm
        ? ($item->title_km ?? $item->title_en)
        : $item->title_en;

    $navItems = \App\Models\Menu::with('children')
        ->whereNull('parent_id')
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get()
        ->map(function ($menu) use ($resolveUrl, $resolveTitle) {
            $url = $resolveUrl($menu);

            $children = $menu->children->map(function ($child) use ($resolveUrl, $resolveTitle) {
                $childUrl = $resolveUrl($child);

                return [
                    'url'    => $childUrl,
                    'title'  => $resolveTitle($child),
                    'active' => request()->url() === $childUrl,
                ];
            });

            return [
                'url'      => $url,
                'title'    => $resolveTitle($menu),
                'children' => $children,
                'active'   => request()->url() === $url || $children->contains('active', true),
            ];
        });

    $languages = ['en' => 'EN', 'km' => 'ខ្មែរ'];
@endphp

<style>
    /*
    |--------------------------------------------------------------------------
    | Design tokens
    |--------------------------------------------------------------------------
    */

    :root {
        --c-cyan:   #06b6d4;
        --c-indigo: #6366f1;
        --c-violet: #8b5cf6;
        --c-pink:   #ec4899;
        --c-amber:  #f59e0b;

        --grad: linear-gradient(120deg, var(--c-cyan), var(--c-indigo) 35%, var(--c-violet) 65%, var(--c-pink));
    }

    body {
        font-family: 'Inter', 'Noto Sans Khmer', system-ui, sans-serif;
        background-color: #f8fafc;
        position: relative;
    }

    html[lang="km"] body {
        font-family: 'Noto Sans Khmer', 'Inter', system-ui, sans-serif;
        line-height: 1.8;
    }

    .font-code {
        font-family: 'JetBrains Mono', ui-monospace, 'SFMono-Regular', Menlo, monospace;
    }

    /* Visible keyboard focus everywhere */
    a:focus-visible,
    button:focus-visible,
    summary:focus-visible {
        outline: 2px solid var(--c-indigo);
        outline-offset: 2px;
        border-radius: .5rem;
    }

    /*
    |--------------------------------------------------------------------------
    | Background: dot grid + soft colour glows
    |--------------------------------------------------------------------------
    */

    .bg-scene {
        position: fixed;
        inset: 0;
        z-index: -1;
        overflow: hidden;
        pointer-events: none;
        background-image: radial-gradient(#d5dbe5 1px, transparent 1px);
        background-size: 22px 22px;
    }

    .glow {
        position: absolute;
        width: 42rem;
        height: 42rem;
        border-radius: 9999px;
        opacity: .45;
    }

    .glow-1 {
        top: -14rem;
        left: -10rem;
        background: radial-gradient(circle, rgba(99, 102, 241, .45), transparent 65%);
    }

    .glow-2 {
        top: 10%;
        right: -14rem;
        background: radial-gradient(circle, rgba(236, 72, 153, .35), transparent 65%);
    }

    .glow-3 {
        bottom: -16rem;
        left: 25%;
        background: radial-gradient(circle, rgba(6, 182, 212, .38), transparent 65%);
    }

    /*
    |--------------------------------------------------------------------------
    | Reusable helpers (use these class names in your pages)
    |--------------------------------------------------------------------------
    */

    /* Gradient headline / word:  <h1 class="text-gradient"> */
    .text-gradient {
        background: var(--grad);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        -webkit-text-fill-color: transparent;
    }

    /* Gradient button:  <a class="btn-gradient"> */
    .btn-gradient {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        border-radius: .75rem;
        padding: .7rem 1.25rem;
        font-weight: 600;
        color: #fff;
        background: var(--grad);
        background-size: 200% 200%;
        box-shadow: 0 8px 24px -8px rgba(99, 102, 241, .6);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px -8px rgba(139, 92, 246, .7);
    }

    /* Card that lifts and glows on hover:  <div class="lift"> */
    .lift {
        transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    }

    .lift:hover {
        transform: translateY(-4px);
        border-color: #c7d2fe;
        box-shadow: 0 18px 40px -18px rgba(99, 102, 241, .45);
    }

    /* Pulsing dot (current item in the timeline):  <span class="dot-live"> */
    .dot-live {
        background: var(--grad);
    }

    /* Colourful tag / chip:  <span class="chip"> */
    .chip {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        padding: .2rem .7rem;
        font-size: .75rem;
        font-weight: 600;
        color: #4338ca;
        background: linear-gradient(90deg, rgba(99, 102, 241, .12), rgba(236, 72, 153, .1));
    }

    /*
    |--------------------------------------------------------------------------
    | Header
    |--------------------------------------------------------------------------
    */

    .site-header {
        transition: box-shadow .3s ease, background-color .3s ease;
    }

    .site-header.is-scrolled {
        box-shadow: 0 10px 30px -18px rgba(79, 70, 229, .45);
    }

    .header-line {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 2px;
        background: var(--grad);
        background-size: 200% 100%;
        opacity: .9;
    }

    #scroll-bar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 60;
        height: 3px;
        background: var(--grad);
        transform: scaleX(0);
        transform-origin: left;
        pointer-events: none;
    }

    .logo-badge {
        background: var(--grad);
        background-size: 200% 200%;
        box-shadow: 0 6px 18px -6px rgba(99, 102, 241, .7);
        transition: transform .35s cubic-bezier(.3, 1.6, .5, 1);
    }

    a:hover .logo-badge {
        transform: rotate(-8deg) scale(1.08);
    }

    /* Desktop nav link with gradient underline */
    .nav-link {
        position: relative;
    }

    .nav-link::after {
        content: "";
        position: absolute;
        left: .75rem;
        right: .75rem;
        bottom: .2rem;
        height: 2px;
        border-radius: 2px;
        background: linear-gradient(90deg, var(--c-indigo), var(--c-pink));
        transform: scaleX(0);
        transition: transform .25s ease;
    }

    .nav-link:hover::after,
    .nav-link.is-active::after {
        transform: scaleX(1);
    }

    .nav-link.is-active {
        color: #4338ca;
        background: rgba(99, 102, 241, .08);
    }

    .drop-item:hover {
        color: #312e81;
        background: linear-gradient(90deg, rgba(99, 102, 241, .12), rgba(236, 72, 153, .08));
    }

    .drop-item.is-active,
    .m-active {
        color: #4338ca;
        background: linear-gradient(90deg, rgba(99, 102, 241, .14), rgba(236, 72, 153, .08));
    }

    .lang-active {
        color: #fff;
        background: var(--grad);
    }

    /* Mobile accordion arrow rotates when a group is open */
    details[open] > summary .chev {
        transform: rotate(180deg);
    }

    /*
    |--------------------------------------------------------------------------
    | Back to top
    |--------------------------------------------------------------------------
    */

    #to-top {
        position: fixed;
        right: 1.25rem;
        bottom: 1.25rem;
        z-index: 50;
        display: flex;
        height: 2.75rem;
        width: 2.75rem;
        align-items: center;
        justify-content: center;
        border-radius: 9999px;
        color: #fff;
        background: var(--grad);
        box-shadow: 0 10px 24px -8px rgba(99, 102, 241, .7);
        opacity: 0;
        transform: translateY(12px);
        pointer-events: none;
        transition: opacity .25s ease, transform .25s ease;
    }

    #to-top.is-visible {
        opacity: 1;
        transform: none;
        pointer-events: auto;
    }

    /*
    |--------------------------------------------------------------------------
    | Animations (all switched off for people who prefer reduced motion)
    |--------------------------------------------------------------------------
    */

    @media (prefers-reduced-motion: no-preference) {

        .glow-1 { animation: drift-a 22s ease-in-out infinite alternate; }
        .glow-2 { animation: drift-b 26s ease-in-out infinite alternate; }
        .glow-3 { animation: drift-a 30s ease-in-out infinite alternate-reverse; }

        .logo-badge,
        .text-gradient,
        .btn-gradient,
        .header-line {
            animation: shift 8s ease-in-out infinite;
        }

        .cursor {
            animation: blink 1.1s steps(1) infinite;
        }

        .dot-live {
            animation: pulse-ring 2s ease-out infinite;
        }

        /* Headline rises in once on page load */
        main h1 {
            animation: rise .7s cubic-bezier(.2, .7, .2, 1) both;
        }

        /* Scroll reveal: only hides things when JS is running */
        .js .reveal {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity .6s ease, transform .6s cubic-bezier(.2, .7, .2, 1);
            transition-delay: var(--d, 0ms);
        }

        .js .reveal.is-visible {
            opacity: 1;
            transform: none;
        }

        /* Mobile menu slides in, links stagger one after another */
        #mobile-menu:not(.hidden) {
            animation: panel-in .25s ease both;
        }

        #mobile-menu:not(.hidden) li {
            animation: item-in .35s ease both;
            animation-delay: calc(var(--i, 0) * 45ms + 60ms);
        }

        @keyframes shift {
            0%, 100% { background-position: 0% 50%; }
            50%      { background-position: 100% 50%; }
        }

        @keyframes blink {
            50% { opacity: 0; }
        }

        @keyframes drift-a {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(6rem, 4rem) scale(1.15); }
        }

        @keyframes drift-b {
            from { transform: translate(0, 0) scale(1.1); }
            to   { transform: translate(-6rem, 5rem) scale(.95); }
        }

        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0 rgba(139, 92, 246, .55); }
            70%  { box-shadow: 0 0 0 10px rgba(139, 92, 246, 0); }
            100% { box-shadow: 0 0 0 0 rgba(139, 92, 246, 0); }
        }

        @keyframes rise {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: none; }
        }

        @keyframes panel-in {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: none; }
        }

        @keyframes item-in {
            from { opacity: 0; transform: translateX(-12px); }
            to   { opacity: 1; transform: none; }
        }
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

    .rich h1 { font-size: 1.75rem; }
    .rich h2 { font-size: 1.5rem; }
    .rich h3 { font-size: 1.25rem; }

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
        color: #7c3aed;
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    .rich img {
        max-width: 100%;
        height: auto;
        border-radius: .75rem;
        margin: 1em 0;
    }

    .rich blockquote {
        border-left: 4px solid #a78bfa;
        padding-left: 1rem;
        color: #6b7280;
        margin: 1em 0;
    }

    .rich pre,
    .rich code {
        background: #0f172a;
        color: #e2e8f0;
        border-radius: .375rem;
        font-family: 'JetBrains Mono', ui-monospace, Menlo, monospace;
        font-size: .875em;
    }

    .rich pre {
        padding: 1rem;
        overflow-x: auto;
    }

    .rich code {
        padding: .1rem .35rem;
    }

    .rich pre code {
        padding: 0;
        background: transparent;
    }
</style>
</head>

<body class="flex min-h-screen flex-col text-slate-800 antialiased">

{{-- Decorative background --}}
<div class="bg-scene" aria-hidden="true">
    <div class="glow glow-1"></div>
    <div class="glow glow-2"></div>
    <div class="glow glow-3"></div>
</div>

{{-- Reading progress --}}
<div id="scroll-bar" aria-hidden="true"></div>

<a
    href="#content"
    class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[70] focus:rounded-lg focus:bg-indigo-600 focus:px-4 focus:py-2 focus:text-white"
>
    {{ __('Skip to content') }}
</a>

{{-- ===================================================================== --}}
{{-- Header                                                                --}}
{{-- ===================================================================== --}}
<header id="site-header" class="site-header sticky top-0 z-40 bg-white/80 backdrop-blur-md">

    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">

        {{-- Logo --}}
        <a
            href="{{ route('home') }}"
            class="flex items-center gap-2.5"
            aria-label="{{ config('app.name') }}"
        >
            <span class="logo-badge font-code flex h-9 w-9 items-center justify-center rounded-xl text-sm font-bold text-white">
                &lt;/&gt;
            </span>

            <span class="text-base font-extrabold tracking-tight text-slate-900">
                {{ config('app.name') }}<span class="cursor font-code text-pink-500">_</span>
            </span>
        </a>


        {{-- Desktop navigation (lg and up) --}}
        <nav class="hidden items-center gap-1 text-sm font-medium lg:flex" aria-label="{{ __('Main navigation') }}">

            @foreach ($navItems as $item)

                @if ($item['children']->isEmpty())

                    <a
                        href="{{ $item['url'] }}"
                        @if ($item['active']) aria-current="page" @endif
                        class="nav-link rounded-lg px-3 py-2 transition-colors
                        {{ $item['active'] ? 'is-active' : 'text-slate-600 hover:text-slate-900' }}"
                    >
                        {{ $item['title'] }}
                    </a>

                @else

                    <div class="group relative">

                        <a
                            href="{{ $item['url'] }}"
                            class="nav-link flex items-center gap-1 rounded-lg px-3 py-2 transition-colors
                            {{ $item['active'] ? 'is-active' : 'text-slate-600 hover:text-slate-900' }}"
                        >
                            {{ $item['title'] }}

                            <svg class="h-3.5 w-3.5 transition-transform duration-200 group-hover:rotate-180 group-focus-within:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                            </svg>
                        </a>

                        {{-- Dropdown (pt-2 keeps hover alive across the gap) --}}
                        <div class="invisible absolute left-0 top-full min-w-52 translate-y-1 pt-2 opacity-0 transition duration-200 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">

                            <div class="rounded-xl border border-slate-200 bg-white p-1.5 shadow-xl shadow-indigo-900/10">

                                @foreach ($item['children'] as $child)
                                    <a
                                        href="{{ $child['url'] }}"
                                        class="drop-item block rounded-lg px-3 py-2 text-sm transition-colors
                                        {{ $child['active'] ? 'is-active' : 'text-slate-600' }}"
                                    >
                                        {{ $child['title'] }}
                                    </a>
                                @endforeach

                            </div>

                        </div>

                    </div>

                @endif

            @endforeach


            <span class="mx-2 h-5 w-px bg-slate-200" aria-hidden="true"></span>


            {{-- Language switcher --}}
            <div class="flex overflow-hidden rounded-lg border border-slate-200 bg-white text-xs">
                @foreach ($languages as $code => $label)
                    <a
                        href="{{ route('lang.switch', $code) }}"
                        hreflang="{{ $code }}"
                        class="px-2.5 py-1.5 transition-colors
                        {{ app()->getLocale() === $code
                            ? 'lang-active'
                            : 'text-slate-600 hover:bg-slate-100' }}"
                    >
                        {{ $label }}
                    </a>
                @endforeach
            </div>

        </nav>


        {{-- Hamburger button (below lg) --}}
        <button
            id="menu-toggle"
            type="button"
            class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 transition hover:border-indigo-300 hover:text-indigo-600 lg:hidden"
            aria-controls="mobile-menu"
            aria-expanded="false"
            aria-label="{{ __('Open menu') }}"
        >
            <svg id="icon-open" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                <path d="M4 7h16M4 12h16M4 17h16"/>
            </svg>
            <svg id="icon-close" class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                <path d="M6 6l12 12M18 6L6 18"/>
            </svg>
        </button>

    </div>


    {{-- Mobile menu panel --}}
    <div
        id="mobile-menu"
        class="hidden max-h-[calc(100vh-4rem)] overflow-y-auto border-t border-slate-200 bg-white/95 lg:hidden"
    >
        <nav class="mx-auto max-w-6xl px-4 py-3" aria-label="{{ __('Mobile navigation') }}">

            <ul class="space-y-1 text-base font-medium">

                @foreach ($navItems as $item)

                    @if ($item['children']->isEmpty())

                        <li style="--i: {{ $loop->index }}">
                            <a
                                href="{{ $item['url'] }}"
                                @if ($item['active']) aria-current="page" @endif
                                class="block rounded-lg px-3 py-3
                                {{ $item['active'] ? 'm-active' : 'text-slate-700 hover:bg-slate-100' }}"
                            >
                                {{ $item['title'] }}
                            </a>
                        </li>

                    @else

                        {{-- Accordion: no JS needed, uses native <details> --}}
                        <li style="--i: {{ $loop->index }}">
                            <details @if ($item['active']) open @endif>

                                <summary
                                    class="flex cursor-pointer list-none items-center justify-between rounded-lg px-3 py-3 [&::-webkit-details-marker]:hidden
                                    {{ $item['active'] ? 'm-active' : 'text-slate-700 hover:bg-slate-100' }}"
                                >
                                    {{ $item['title'] }}

                                    <svg class="chev h-4 w-4 transition-transform" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                                    </svg>
                                </summary>

                                <ul class="ml-3 mt-1 space-y-1 border-l-2 border-indigo-200 pl-3 text-sm">

                                    <li>
                                        <a href="{{ $item['url'] }}" class="block rounded-lg px-3 py-2.5 text-slate-600 hover:bg-slate-100">
                                            {{ $item['title'] }}
                                        </a>
                                    </li>

                                    @foreach ($item['children'] as $child)
                                        <li>
                                            <a
                                                href="{{ $child['url'] }}"
                                                class="block rounded-lg px-3 py-2.5
                                                {{ $child['active'] ? 'm-active' : 'text-slate-600 hover:bg-slate-100' }}"
                                            >
                                                {{ $child['title'] }}
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>

                            </details>
                        </li>

                    @endif

                @endforeach

            </ul>


            {{-- Language switcher (mobile) --}}
            <div class="mt-3 flex items-center justify-between border-t border-slate-200 pt-4">

                <span class="text-sm text-slate-500">{{ __('Language') }}</span>

                <div class="flex overflow-hidden rounded-lg border border-slate-200 text-sm">
                    @foreach ($languages as $code => $label)
                        <a
                            href="{{ route('lang.switch', $code) }}"
                            hreflang="{{ $code }}"
                            class="px-4 py-2
                            {{ app()->getLocale() === $code
                                ? 'lang-active'
                                : 'text-slate-600 hover:bg-slate-100' }}"
                        >
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

            </div>

        </nav>
    </div>

    <span class="header-line" aria-hidden="true"></span>

</header>


{{-- ===================================================================== --}}
{{-- Main content                                                          --}}
{{-- ===================================================================== --}}
<main id="content" class="mx-auto w-full max-w-6xl flex-1 px-4 py-10 sm:py-14">
    @yield('content')
</main>


{{-- ===================================================================== --}}
{{-- Footer                                                                --}}
{{-- ===================================================================== --}}
<footer class="relative border-t border-slate-200 bg-white/80 backdrop-blur">

    <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-3 px-4 py-7 text-sm text-slate-500 sm:flex-row">

        <p>
            &copy; {{ date('Y') }}
            <span class="text-gradient font-bold">{{ config('app.name') }}</span>.
            {{ __('All rights reserved.') }}
        </p>

        <p class="font-code text-xs text-slate-400">
            Laravel {{ app()->version() }} &middot; PHP {{ PHP_VERSION }}
        </p>

    </div>

</footer>


{{-- Back to top --}}
<button id="to-top" type="button" aria-label="{{ __('Back to top') }}">
    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M12 19V5M5 12l7-7 7 7"/>
    </svg>
</button>


<script>
    (function () {
        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        /* ---------- Mobile menu ---------- */
        var btn = document.getElementById('menu-toggle');
        var panel = document.getElementById('mobile-menu');
        var iconOpen = document.getElementById('icon-open');
        var iconClose = document.getElementById('icon-close');

        if (btn && panel) {
            var labelOpen = @json(__('Open menu'));
            var labelClose = @json(__('Close menu'));

            var setOpen = function (open) {
                panel.classList.toggle('hidden', !open);
                iconOpen.classList.toggle('hidden', open);
                iconClose.classList.toggle('hidden', !open);
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                btn.setAttribute('aria-label', open ? labelClose : labelOpen);
            };

            btn.addEventListener('click', function () {
                setOpen(btn.getAttribute('aria-expanded') !== 'true');
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') setOpen(false);
            });

            window.matchMedia('(min-width: 1024px)').addEventListener('change', function (e) {
                if (e.matches) setOpen(false);
            });
        }

        /* ---------- Scroll progress, header shadow, back-to-top ---------- */
        var bar = document.getElementById('scroll-bar');
        var header = document.getElementById('site-header');
        var toTop = document.getElementById('to-top');
        var ticking = false;

        function onScroll() {
            var y = window.scrollY;
            var max = document.documentElement.scrollHeight - window.innerHeight;

            if (bar) bar.style.transform = 'scaleX(' + (max > 0 ? Math.min(y / max, 1) : 0) + ')';
            if (header) header.classList.toggle('is-scrolled', y > 8);
            if (toTop) toTop.classList.toggle('is-visible', y > 480);

            ticking = false;
        }

        window.addEventListener('scroll', function () {
            if (!ticking) {
                ticking = true;
                requestAnimationFrame(onScroll);
            }
        }, { passive: true });

        onScroll();

        if (toTop) {
            toTop.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
            });
        }

        /* ---------- Scroll reveal ---------- */
        // Anything with data-reveal, plus every <article> in <main>
        var targets = document.querySelectorAll('[data-reveal], main article');

        if (reduceMotion || !('IntersectionObserver' in window)) {
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        targets.forEach(function (el, i) {
            el.classList.add('reveal');
            el.style.setProperty('--d', Math.min(i % 4, 3) * 70 + 'ms');
            observer.observe(el);
        });
    })();
</script>

</body>
</html>
