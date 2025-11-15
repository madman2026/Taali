@auth
    <div class="relative">
        {{-- دکمه باز شدن منو --}}
        <button id="dropdownUserButton"
                data-dropdown-toggle="dropdownUserMenu"
                class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800
                   border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700
                   focus:ring-2 focus:ring-indigo-500 transition">
                @if(Auth::user()->image->first()?->path)
                    <img src="{{ asset(Auth::user()->image->first()->path) }}" alt="{{ Auth::user()->image->first()->name ?? 'User Image' }}" class="w-5 h-5  object-cover rounded-full">

                @else
                    <x-heroicon-o-user class="w-5 h-5" />

                @endif

                <span>{{ auth()->user()->name }}</span>
            <x-heroicon-o-chevron-down class="w-4 h-4" />
        </button>

        {{-- منو --}}
        <div id="dropdownUserMenu"
             class="hidden z-50 absolute right-0 mt-2 w-44 bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-800 dark:divide-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <x-heroicon-o-home class="w-5 h-5" />
                        {{ __('Dashboard') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings') }}"
                       class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <x-heroicon-o-cog-6-tooth class="w-5 h-5" />
                        {{ __('Settings') }}
                    </a>
                </li>
            </ul>
            <div class="py-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-2 px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5" />
                        {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="flex items-center gap-2">
        <a href="{{ route('login') }}"
           class="text-sm px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
            {{ __('Login') }}
        </a>
        @if (Route::has('register'))
            <a href="{{ route('register') }}"
               class="text-sm px-4 py-2 rounded-lg border border-indigo-500 text-indigo-600 hover:bg-indigo-50 dark:hover:bg-gray-700 transition">
                {{ __('Register') }}
            </a>
        @endif
    </div>
@endauth
