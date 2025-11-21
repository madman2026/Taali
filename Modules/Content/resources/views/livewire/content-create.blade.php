<div class="max-w-3xl mx-auto p-6 sm:p-8 bg-white dark:bg-gray-900 rounded-2xl shadow-lg dark:shadow-xl transition-colors duration-300">

    <h1 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-gray-100">
        {{ __('Create Content') }}
    </h1>

    <form wire:submit.prevent="save" class="space-y-6">

        <!-- Title -->
        <div class="space-y-1">
            <x-form.label for="title">{{ __('Title') }}</x-form.label>
            <x-form.input type="text" wire="title" id="title"
                class="bg-gray-50 dark:bg-gray-800 border-gray-300 dark:border-gray-700
                       text-gray-900 dark:text-gray-100"
                placeholder="{{ __('Enter title') }}" />
            <x-form.error name="title" />
        </div>

        <!-- Excerpt -->
        <div class="space-y-1">
            <x-form.label for="excerpt">{{ __('Excerpt') }}</x-form.label>
            <textarea
                wire="excerpt"
                id="excerpt"
                rows="5"
                class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                       text-gray-900 dark:text-gray-100 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                placeholder="{{ __('Full excerpt or content body') }}"></textarea>
            <x-form.error name="excerpt" />
        </div>

        <!-- Description -->
        <div class="space-y-1">
            <x-form.label for="description">{{ __('Description') }}</x-form.label>
            <textarea
                wire="description"
                id="description"
                rows="5"
                class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                       text-gray-900 dark:text-gray-100 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                placeholder="{{ __('Full description or content body') }}"></textarea>
            <x-form.error name="description" />
        </div>

        <!-- Image -->
        <div class="space-y-1">
            <x-form.label for="image">{{ __('Image') }}</x-form.label>
            <x-form.file wire="image" id="image"
                class="bg-gray-50 dark:bg-gray-800 border-gray-300 dark:border-gray-700
                       text-gray-900 dark:text-gray-100" />
            <x-form.error name="image" />

            @if($image)
                <div class="mt-2">
                    <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                        class="w-32 h-32 object-cover rounded-lg border border-gray-300 dark:border-gray-700 shadow-sm" />
                </div>
            @endif
        </div>

        <!-- Audio -->
        <div class="space-y-1">
            <x-form.label for="audio">{{ __('Audio File') }}</x-form.label>
            <x-form.file wire="audio" id="audio" accept="audio/*"
                class="bg-gray-50 dark:bg-gray-800 border-gray-300 dark:border-gray-700
                       text-gray-900 dark:text-gray-100" />
            <x-form.error name="audio" />

            @if($audio)
                <div class="mt-2">
                    <audio controls class="w-full">
                        <source src="{{ $audio->temporaryUrl() }}">
                        {{ __('Your browser does not support the audio element.') }}
                    </audio>
                </div>
            @endif
        </div>

        <!-- Video URL -->
        <div class="space-y-1">
            <x-form.label for="video">{{ __('Video URL') }}</x-form.label>
            <x-form.input type="text" wire="videoUrl" id="videoUrl"
                class="bg-gray-50 dark:bg-gray-800 border-gray-300 dark:border-gray-700
                    text-gray-900 dark:text-gray-100"
                placeholder="لینک آپارات یا hash مثل tvj5j1e" />
            <x-form.error name="videoUrl" />

            @if($videoHash)
                <div class="mt-3 rounded-xl overflow-hidden border border-gray-300 dark:border-gray-700 shadow">
                    <div class="relative pb-[57%] h-0">
                        <iframe
                            class="absolute top-0 left-0 w-full h-full"
                            src="https://www.aparat.com/video/video/embed/videohash/{{ $videoHash }}/vt/frame"
                            allowfullscreen webkitallowfullscreen mozallowfullscreen>
                        </iframe>
                    </div>
                </div>
            @endif
        </div>

        <!-- Submit -->
        <div class="pt-4">
            <x-button-primary type="submit" class="w-full py-3 text-lg">
                {{ __('Create Content') }}
            </x-button-primary>
        </div>

    </form>
</div>
