<div class="max-w-md mx-auto bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">{{ __('sign up') }}</h2>


    <form wire:submit.prevent="register()" class="space-y-4">

        <x-form.input type="email" label="email" name="email" placeholder="{{ __('your email') }}" />

        <x-form.input type="text" label="name" name="name" placeholder="{{ __('your name') }}" />

        <x-form.input type="password" label="password" name="password" placeholder="{{ __('your password') }}" />

        <x-form.input type="password" label="password_confirmation" name="password_confirmation" placeholder="{{ __('your password confirmation') }}" />

        <x-form.button type="submit" variant="primary" class="w-full py-2.5 text-sm">
            {{ __('register') }}
        </x-form.button>
    </form>
</div>
