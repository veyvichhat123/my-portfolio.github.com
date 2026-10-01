@php
    $locale = app()->getLocale();
    $from = $item->start_date?->locale($locale)->translatedFormat('M Y');
    $to = $item->is_current || ! $item->end_date
        ? __('Present')
        : $item->end_date->locale($locale)->translatedFormat('M Y');
@endphp
@if ($from)
    <span>{{ $from }} &ndash; {{ $to }}</span>
@endif
