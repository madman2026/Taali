<x-layouts.app>
    <x-slot:header>
        @auth
            <nav class="flex items-center justify-end gap-4">
                <a href="{{ route('dashboard') }}" class="btn-secondary">{{ __('Dashboard') }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-secondary">{{ __('Logout') }}</button>
                </form>
            </nav>
        @else
            <nav class="flex items-center justify-end gap-4">
                <a href="{{ route('login') }}" class="btn-primary">{{ __('Login') }}</a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-secondary">{{ __('Register') }}</a>
                @endif
            </nav>
        @endauth
    </x-slot:header>

    <div class="flex">
        <!-- Main content -->
        <section class="">
            {{ $slot }}
        </section>
    </div>
</x-layouts.app>
