
<div class="max-w-md mx-auto bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">{{ __('Sign In') }}</h2>


    <form wire:submit.prevent="login" class="space-y-4">

        <x-form.input type="email" label="email" name="email" placeholder="{{ __('Your Email') }}" />

        <x-form.input type="password" label="password" name="password" placeholder="{{ __('Your Password') }}" />

        <x-form.button type="submit" variant="primary" class="w-full py-2.5 text-sm">
            {{ __('Login') }}
        </x-form.button>
    </form>
</div>
