
<div class="max-w-md mx-auto bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">{{ __('Sign In') }}</h2>


    <form wire:submit.prevent="login" class="space-y-4">

        <div>
            <x-form.label for="email">{{ __('Email') }}</x-form.label>
            <x-form.input type="email" wire="email" name="email" placeholder="{{ __('Email') }}" />
            <x-form.error name="email" />
        </div>

        <div>
            <x-form.label for="Password">{{ __('password') }}</x-form.label>
            <x-form.input type="password" wire="password" name="Password" placeholder="{{ __('password') }}" />
            <x-form.error name="password" />
        </div>

        <x-button-primary type="submit">{{ __('Login') }}</x-button-primary>
    </form>
</div>
