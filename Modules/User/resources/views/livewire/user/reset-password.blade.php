<div class="max-w-md mx-auto bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">{{ __('Reset Password') }}</h2>


    <form wire:submit.prevent="resetPassword" class="space-y-4">

        <div>
            <x-form.label for="oldPassword">{{ __('Old Password') }}</x-form.label>
            <x-form.input type="password" wire="oldPassword" name="oldPassword" placeholder="{{ __('Your Old Password') }}" />
            <x-form.error name="oldPassword" />
        </div>

        <div>
            <x-form.label for="newPassword">{{ __('New Password') }}</x-form.label>
            <x-form.input type="password" wire="newPassword" name="newPassword" placeholder="{{ __('Your New Password') }}" />
            <x-form.error name="newPassword" />
        </div>

        <div>
            <x-form.label for="newPassword_confirmation">{{ __('Password Confirmation') }}</x-form.label>
            <x-form.input type="password" wire="newPassword_confirmation" name="newPassword_confirmation" placeholder="{{ __('Your New Password Again') }}" />
            <x-form.error name="newPassword_confirmation" />

        </div>

        <x-button-primary type="submit">{{ __('Update Profile') }}</x-button-primary>
    </form>
</div>
