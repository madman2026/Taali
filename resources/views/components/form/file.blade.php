@props(['wire' => null, 'accept' => 'image/png, image/jpeg'])

<input type="file"
       {{ $attributes->merge(['class' => 'w-full text-sm text-gray-600 dark:text-gray-300']) }}
       wire:model="{{ $wire }}"
       accept="{{ $accept }}">
<p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('Max 5MB, jpeg/png') }}</p>
