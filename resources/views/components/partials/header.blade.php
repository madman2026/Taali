
<header class="border-b border-gray-200 dark:border-gray-700 p-4">
    <div class="flex items-center justify-between max-w-7xl mx-auto">
        <h1 class="text-lg font-semibold">{{ $title?? ''  }}</h1>
                <div class="flex items-center gap-3">
            @auth
                @include('components.partials.user-dropdown')
            @else
                <a href="{{ route('login') }}" class="btn-primary">{{ __('Login') }}</a>
                <a href="{{ route('register') }}" class="btn-secondary">{{ __('Register') }}</a>
            @endauth
            <button
                x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
                @click="
                            darkMode = !darkMode;
                            localStorage.setItem('theme', darkMode ? 'dark' : 'light');
                            document.documentElement.classList.toggle('dark', darkMode);
                        "
                class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700
                               focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700
                               rounded-lg text-sm p-2.5 transition"
                type="button">

                {{-- Moon icon (show in light mode) --}}
                <x-heroicon-o-moon x-show="!darkMode" class="w-5 h-5" />

                {{-- Sun icon (show in dark mode) --}}
                <x-heroicon-o-sun x-show="darkMode" class="w-5 h-5" />
            </button>
        </div>
    </div>
</header>
