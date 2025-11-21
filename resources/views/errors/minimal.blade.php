<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Page Not Found')</title>
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

        .background-gradient {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #f0f0f0, #d9d9d9);
            transition: background 0.5s ease;
            z-index: -1;
        }

        .dark .background-gradient {
            background: linear-gradient(135deg, #111111, #222222);
        }
    </style>
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <div class="flex flex-col items-center justify-center min-h-screen px-4">
        <!-- Icon / Illustration -->
        <div class="text-9xl font-bold text-gray-400 dark:text-gray-600">
            @yield('code', '404')
        </div>

        <!-- Message -->
        <div class="mt-4 text-center space-y-2">
            <h1 class="text-2xl sm:text-3xl font-semibold tracking-wide">
                @yield('message', 'Page Not Found')
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                @yield('description', 'Sorry, the page you are looking for does not exist or has been moved.')
            </p>
        </div>

        <!-- Action Button -->
        <div class="mt-6">
            <a href="{{ url('/') }}"
               class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md transition-all duration-200">
                Go Home
            </a>
        </div>

        <!-- Optional Illustration -->
        <div class="mt-10 w-full max-w-md">
            @yield('illustration')
        </div>
    </div>

</body>
</html>
