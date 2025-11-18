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

            @if ($uploadedImage)
                <img class="w-24 h-24 object-cover rounded-full border border-gray-300 dark:border-gray-700 shadow-sm"
                     src="{{ $uploadedImage->temporaryUrl() }}" alt="Preview">
            @elseif ($existingImagePath)
                <img class="w-24 h-24 object-cover rounded-full border border-gray-300 dark:border-gray-700 shadow-sm"
                     src="{{ asset($existingImagePath) }}" alt="Current Avatar">
            @else
                <img class="w-24 h-24 object-cover rounded-full border border-gray-300 dark:border-gray-700 shadow-sm"
                     src="{{ asset('profile-pictures/default-avatar.png') }}" alt="Default Avatar">
            @endif
        </div>

        <!-- Name -->
        <div class="space-y-1">
            <x-form.label for="name">{{ __('Name') }}</x-form.label>
            <x-form.input type="text" wire:model="name" name="name"
                          class="bg-gray-50 dark:bg-gray-800 border-gray-300 dark:border-gray-700
                                 text-gray-900 dark:text-gray-200"
                          placeholder="Your Name" />
            <x-form.error name="name" />
        </div>

        <!-- Email -->
        <div class="space-y-1">
            <x-form.label for="email">{{ __('Email') }}</x-form.label>
            <x-form.input type="email" wire:model="email" name="email"
                          class="bg-gray-50 dark:bg-gray-800 border-gray-300 dark:border-gray-700
                                 text-gray-900 dark:text-gray-200"
                          placeholder="you@example.com" />
            <x-form.error name="email" />
        </div>

        <!-- Image Upload -->
        <div class="space-y-1">
            <x-form.label for="image">{{ __('Profile Picture') }}</x-form.label>
            <x-form.file wire:model="uploadedImage"
                         class="dark:bg-gray-800 dark:border-gray-700 text-gray-200" />
            <x-form.error name="image" />

            <div wire:loading wire:target="uploadedImage"
                 class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                {{ __('Uploading...') }}
            </div>
        </div>

        <!-- Submit Button -->
        <x-button-primary type="submit" class="w-full py-2.5 text-sm">
            {{ __('Update Profile') }}
        </x-button-primary>

    </form>
</div>
