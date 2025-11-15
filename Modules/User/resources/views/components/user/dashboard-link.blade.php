@props([
    'href' => '#',
    'icon' => null,
    'active' => false,
    'color' => 'gray'
])

@php
    $baseClasses = "flex items-center gap-2 px-3 py-2 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-indigo-500";
    $colorClasses = $active
        ? "bg-{$color}-100 dark:bg-{$color}-900/40 text-{$color}-700 dark:text-{$color}-300"
        : "text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800";
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => "$baseClasses $colorClasses"]) }}>
    @if($icon)
        <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-5 h-5" />
    @endif
    <span>{{ $slot }}</span>
</a>
