<div class="w-full mx-auto
            bg-white dark:bg-gray-900
            p-6 sm:p-7
            rounded-2xl
            shadow-lg dark:shadow-xl
            border border-gray-200 dark:border-gray-800
            transition-all duration-300">

    <h2 class="text-xl font-semibold mb-6
               text-gray-900 dark:text-gray-200">
        {{ __('Update Profile') }}
    </h2>

    <form wire:submit.prevent="updateUser" class="space-y-5">

        <!-- Avatar Preview -->
        <div class="flex justify-center mb-2"
             wire:target="uploadedImage"
             wire:loading.class="blur-sm">

            @if($existingImagePath)
                <img class="w-24 h-24 object-cover rounded-full border border-gray-300 dark:border-gray-700 shadow-sm"
                     src="{{ asset($existingImagePath) }}" alt="Current Avatar">
            @else
                <img class="w-24 h-24 object-cover rounded-full border border-gray-300 dark:border-gray-700 shadow-sm"
                     src="{{ asset('profile-pictures/default-avatar.png') }}" alt="Default Avatar">
            @endif
        </div>

        <!-- Name -->
        <x-form.input type="text" wire="name" label="name" name="name" placeholder="{{ __('Your Name') }}" />

        <!-- Email -->
        <x-form.input type="email" wire="email" label="email" name="email" placeholder="{{ __('Your Email') }}" />

        <x-form.file accept="image/*" label="{{ __('Profile Picture') }}" name="uploadedImage" placeholder="{{ __('Profile Picture') }}" />

        <!-- Submit Button -->
        <x-form.button type="submit" variant="primary" class="w-full py-2.5 text-sm">
            {{ __('Update Profile') }}
        </x-form.button>

    </form>
</div>
