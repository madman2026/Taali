<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl"
      x-data="themeManager()"
      x-init="init()"
      :class="isDark ? 'dark' : ''"
      class="scroll-smooth antialiased transition-colors duration-300 min-h-screen flex flex-col">

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
    </style>
</head>

<body class="flex flex-col min-h-screen relative transition-colors duration-300">

<!-- Soft gradient background -->
<div class="background-gradient pointer-events-none"></div>

<div class="relative z-10 flex-1 flex flex-col">

    @if(isset($header))
        {{ $header }}
    @else
        @include('components.partials.header')
    @endif

    <main class="flex-1 container mx-auto px-4 md:px-6 lg:px-8">
        {{ $slot }}
    </main>

    @include('components.partials.footer')
</div>

@livewireScripts
<x-toaster-hub />
<livewire:confirm-modal />

<!-- Theme Manager -->
<script>
    function themeManager() {
        return {
            palette: localStorage.getItem('palette') || 'spiritual',
            isDark: JSON.parse(localStorage.getItem('darkMode')) ?? false,
            initialized: false,

            init() {
                if (this.initialized) return;
                this.initialized = true;

                document.documentElement.setAttribute('data-theme', this.palette);
            },

            toggleDark() {
                this.isDark = !this.isDark;
                localStorage.setItem('darkMode', this.isDark);
            },

            switchPalette(newPalette) {
                this.palette = newPalette;
                localStorage.setItem('palette', newPalette);
                document.documentElement.setAttribute('data-theme', newPalette);
            }
        }
    }
</script>

</body>
</html>
