<x-layouts.app>
    <x-slot:title>{{ __($title) ?? __('Page') }}</x-slot:title>

    <main class="flex-1
                 bg-white dark:bg-[#111]
                 border border-gray-200 dark:border-gray-800/70
                 rounded-2xl
                 p-6 md:p-8
                 m-4 md:m-6
                 shadow-sm dark:shadow-[0_0_10px_rgba(0,0,0,0.25)]
                 transition-all duration-300">
        {{ $slot }}
    </main>
</x-layouts.app>
