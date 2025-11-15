<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl"
      x-data="themeSwitcher()"
      x-init="initTheme()"
      :class="{ 'dark': isDarkMode }"
      class="scroll-smooth antialiased transition-colors duration-300">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        @font-face {
            font-family: 'Vazir';
            src: url('{{ asset('vasir.woff') }}') format('woff');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'Vazir', sans-serif;
        }
    </style>
</head>

<body class="bg-white text-gray-800 dark:bg-gray-900 dark:text-gray-100 min-h-flex min-w-full flex-col transition-colors duration-300 relative">

    <!-- Background Animal Image -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-50/50 via-white/30 to-gray-100/50 dark:from-gray-900/50 dark:via-gray-950/30 dark:to-gray-900/50"></div>
        <img src="https://www.beytoote.com/images/stories/fun/hhf63.jpg" 
             alt="Animal background" 
             class="absolute inset-0 w-full h-full object-cover opacity-10 dark:opacity-5 blur-sm"
             style="object-position: center;">
    </div>

    <div class="relative z-10">
        @if(isset($header))
            {{$header}}
        @else
            @include('components.partials.header')
        @endif

        <main class="flex-1 container mx-auto ">
            {{ $slot }}
        </main>

        @include('components.partials.footer')
    </div>

@livewireScripts
<x-toaster-hub />
<livewire:confirm-modal />
<script>
    function themeSwitcher() {
        return {
            isDarkMode: localStorage.getItem('theme') === 'dark',
            toggleTheme() {
                this.isDarkMode = !this.isDarkMode;
                localStorage.setItem('theme', this.isDarkMode ? 'dark' : 'light');
                document.documentElement.classList.toggle('dark', this.isDarkMode);
            },
            initTheme() {
                const storedTheme = localStorage.getItem('theme');
                if (storedTheme === 'dark' || (!storedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    this.isDarkMode = true;
                    document.documentElement.classList.add('dark');
                } else {
                    this.isDarkMode = false;
                    document.documentElement.classList.remove('dark');
                }
            }
        }
    }
</script>
</body>
</html>
