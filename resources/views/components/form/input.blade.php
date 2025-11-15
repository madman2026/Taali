@props(['type' => 'text', 'wire' => null, 'placeholder' => '', 'name' => null])

<input
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => 'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring
                    focus:ring-indigo-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition-colors duration-200'
    ]) }}
    wire:model.defer="{{ $wire }}"
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
>
