<div class="max-w-3xl mx-auto p-6 sm:p-8 bg-white dark:bg-gray-900 rounded-2xl shadow-lg dark:shadow-xl transition-colors duration-300">

    <h1 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-gray-100">
        {{ __('Update Content') }}
    </h1>

    <form wire:submit.prevent="update" class="space-y-6">

        <x-form.input
            type="text"
            label="title"
            name="title"
            placeholder="{{ __('Enter title') }}"
        />

        <x-form.textarea
            label="excerpt"
            name="excerpt"
            placeholder="{{ __('Full excerpt or content body') }}"
        />

        <x-form.textarea
            label="description"
            name="description"
            placeholder="{{ __('Full description or content body') }}"
        />

        {{-- Image --}}
        <x-form.file
            label="image"
            name="image"
            placeholder="{{ __('Image') }}"
            accept="image/*"
        />

        @if($currentImage)
            <div class="mt-2 flex items-center gap-3">
                <img src="{{ $currentImage }}" class="h-20 w-20 rounded-xl object-cover shadow" alt="current image">
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Current image') }}</p>
            </div>
        @endif

        {{-- Audio --}}
        <x-form.file
            label="audio"
            name="audio"
            placeholder="{{ __('Audio File') }}"
            accept="audio/*"
        />

        @if($currentAudio)
            <div class="mt-2">
                <audio controls class="w-full">
                    <source src="{{ $currentAudio }}">
                </audio>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Current audio file') }}</p>
            </div>
        @endif

        {{-- Video URL --}}
        <x-form.input
            type="text"
            label="videoUrl"
            name="videoUrl"
            placeholder="{{ __('Video URL') }}"
        />

        @if($videoHash)
            <div class="mt-3 rounded-xl overflow-hidden border border-gray-300 dark:border-gray-700 shadow">
                <div class="relative pb-[57%] h-0">
                    <iframe
                        class="absolute top-0 left-0 w-full h-full"
                        src="https://www.aparat.com/video/video/embed/videohash/{{ $videoHash }}/vt/frame"
                        allowfullscreen
                        webkitallowfullscreen
                        mozallowfullscreen>
                    </iframe>
                </div>
            </div>
        @endif

        <x-form.button type="submit" variant="primary" class="w-full py-2.5 text-sm">
            {{ __('Update Content') }}
        </x-form.button>

    </form>
</div>
