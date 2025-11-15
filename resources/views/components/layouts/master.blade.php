<x-layouts.app>
    <x-slot:title>{{ __($title) ?? __('Page') }}</x-slot:title>

    <main class="flex-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                 rounded-2xl p-6 m-4 shadow-sm transition-colors duration-300">
        {{ $slot }}
    </main>
</x-layouts.app>
