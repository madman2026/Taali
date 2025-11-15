@props(['for'])

<label for="{{ $for }}" class="block text-gray-700 dark:text-gray-300 mb-1">
    {{ $slot }}
</label>
