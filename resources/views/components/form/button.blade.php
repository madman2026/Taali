@props([
    'type' => 'button',
    'variant' => 'primary',     // primary | secondary | danger | ghost | link
    'size' => 'md',             // xs | sm | md | lg
    'block' => false,
    'loading' => false,
    'disabled' => false,
    'href' => null,
    'outline' => false,
    'icon' => null,
    'iconPosition' => 'left',   // left | right
    'rounded' => 'xl',          // sm | md | lg | xl | full
])

@php
    $isDisabled = $disabled || $loading;
    $iconOnly = $icon && trim($slot) === '';

    $roundedMap = [
        'sm' => 'rounded-md',
        'md' => 'rounded-lg',
        'lg' => 'rounded-xl',
        'xl' => 'rounded-2xl',
        'full' => 'rounded-full',
    ];

    $sizes = [
        'xs' => $iconOnly ? 'p-1.5 text-xs' : 'px-2 py-1.5 text-xs',
        'sm' => $iconOnly ? 'p-2 text-sm'   : 'px-3 py-2 text-sm',
        'md' => $iconOnly ? 'p-2.5 text-base' : 'px-4 py-2.5 text-base',
        'lg' => $iconOnly ? 'p-3 text-lg'   : 'px-5 py-3 text-lg',
    ];

    $base = '
        inline-flex items-center justify-center gap-2
        font-medium
        transition-all duration-200
        focus-visible:outline-none
        focus-visible:ring-2 focus-visible:ring-offset-2
        active:scale-[0.97]
        disabled:opacity-60 disabled:cursor-not-allowed
        data-[disabled=true]:opacity-60 data-[disabled=true]:cursor-not-allowed pointer-events-auto
    ';

    $display = $block ? 'w-full' : '';
    $roundedClass = $roundedMap[$rounded] ?? $roundedMap['xl'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];

    $variants = [
        'primary' => $outline
            ? 'border border-indigo-600 text-indigo-600 hover:bg-indigo-50 focus-visible:ring-indigo-500'
            : 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm hover:shadow-md focus-visible:ring-indigo-500',

        'secondary' => $outline
            ? 'border border-gray-300 text-gray-700 hover:bg-gray-50 focus-visible:ring-gray-400'
            : 'bg-gray-100 text-gray-900 hover:bg-gray-200 focus-visible:ring-gray-400',

        'danger' => $outline
            ? 'border border-red-600 text-red-600 hover:bg-red-50 focus-visible:ring-red-500'
            : 'bg-red-600 text-white hover:bg-red-700 focus-visible:ring-red-500',

        'ghost' => 'bg-transparent text-gray-800 hover:bg-gray-100 focus-visible:ring-gray-300',

        'link' => 'bg-transparent underline text-indigo-600 hover:text-indigo-700 px-0 py-0 focus-visible:ring-indigo-500',
    ];

    $variantClass = $variants[$variant] ?? $variants['primary'];

    $classes = trim("
        {$base}
        {$display}
        {$roundedClass}
        {$sizeClass}
        {$variantClass}
        {$attributes->get('class')}
    ");
@endphp

@if ($href)
    <a
        href="{{ $isDisabled ? '#' : $href }}"
        role="button"
        data-disabled="{{ $isDisabled ? 'true' : 'false' }}"
        aria-disabled="{{ $isDisabled ? 'true' : 'false' }}"
        {{ $attributes->merge(['class' => $classes]) }}
        @if($isDisabled) tabindex="-1" onclick="event.preventDefault();" @endif
        >
        @include('components.form.button-content')
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge([
            'class' => $classes,
            'disabled' => $isDisabled,
            'aria-busy' => $loading ? 'true' : 'false',
        ]) }}
    >
        @include('components.form.button-content')
    </button>
@endif
