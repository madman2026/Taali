<div class="max-w-md mx-auto bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">{{ __('Reset Password') }}</h2>


    <form wire:submit.prevent="resetPassword" class="space-y-4">

        <x-form.input :label="__('Old Password')" name="oldPassword" type="password" :placeholder="__('Your Old Password')"  />
        <x-form.input :label="__('New Password')" name="newPassword" type="password" :placeholder="__('Your New Password')"  />
        <x-form.input :label="__('New Password Confirmation')" type="password" name="newPassword_confirmation" :placeholder="__('Confirm Your New Password')"  />
        <x-form.button type="submit">{{ __('Update Profile') }}</x-button>
    </form>
</div>
