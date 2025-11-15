
<div class="max-w-md mx-auto bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">{{ __('Sign Up') }}</h2>


    <form wire:submit.prevent="register" class="space-y-4">

        <div>
            <x-form.label for="email">{{ __('Email') }}</x-form.label>
            <x-form.input type="email" wire="email" name="email" placeholder="{{ __('Email') }}" />
            <x-form.error name="Email" />
        </div>

        <div>
            <x-form.label for="password">{{ __('password') }}</x-form.label>
            <x-form.input type="password" wire="password" name="password" placeholder="{{ __('password') }}" />
            <x-form.error name="password" />
        </div>

        <div>
            <x-form.label for="password_confirmation">{{ __('new password confirmation') }}</x-form.label>
            <x-form.input type="password" wire="password_confirmation" name="password_confirmation" placeholder="{{ __('password confirmation') }}" />
            <x-form.error name="password_confirmation" />

        </div>

        <x-button-primary type="submit">{{ __('Submit') }}</x-button-primary>
    </form>
</div>
