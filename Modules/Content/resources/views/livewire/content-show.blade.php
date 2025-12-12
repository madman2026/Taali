<!-- Single Content Page (Blade + Tailwind + Alpine + Livewire + AOS) -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb -->
    <nav class="text-sm mb-4 text-gray-500 dark:text-gray-400" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1">
            <li><a href="{{ route('content.index') }}" class="hover:underline">All Contents</a></li>
            <li>/</li>
            <li class="text-gray-900 dark:text-gray-100 font-semibold">{{ $content->title }}</li>
        </ol>
    </nav>

    <!-- Title -->
    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-6" data-aos="fade-down">
        {{ $content->title }}
    </h1>

    <!-- Image -->
    @if($content->image)
        <div class="w-full mb-6 overflow-hidden rounded-2xl shadow-lg" data-aos="zoom-in">
            <img src="{{ $content->image->temporary_url }}" alt="Content Image"
                 class="w-full h-auto max-h-200 object-cover transform hover:scale-105 transition duration-500">
        </div>
    @endif

    <!-- Excerpt -->
    <div class="text-black dark:text-white max-w-full mb-6 p-2 rounded-lg border border-white" data-aos="fade-up">
        <strong class=" mb-2">{{ __('Excerpt') }}</strong>
        <p>{{ $content->excerpt }}</p>
    </div>

    <!-- Body -->
    <div class="text-black dark:text-white max-w-full mb-6" data-aos="fade-up">
        <strong class=" mb-2">{{ __('Description') }}</strong>
        <p>{{ $content->description }}</p>
    </div>

    <!-- Audio Player -->
    @if($content->audio)
        <div class="mb-6" data-aos="fade-up">
            <audio controls class="w-full rounded-lg">
                <source src="{{ $content->audio->temporary_url }}" type="{{ $content->audio->mime_type }}">
                Your browser does not support the audio element.
            </audio>
        </div>
    @endif

    <!-- Video Player -->
    @if($content->video)
        <div class="relative pb-[56.25%] h-0 mb-6 rounded-lg overflow-hidden border border-gray-300 dark:border-gray-600" data-aos="fade-up">
            <iframe class="absolute inset-0 w-full h-full"
                    src="https://www.aparat.com/video/video/embed/videohash/{{ $content->video->path }}/vt/frame"
                    allowfullscreen></iframe>
        </div>
    @endif

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-start mt-4" data-aos="fade-up">
        <x-form.button variant="secondary" href="{{ route('content.edit', $content->id) }}"
           class="px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl shadow transition">
            {{ __('Edit') }}
        </x-form.button>

        <x-form.button variant="danger" wire:click="delete({{ $content->id }})">
            {{__('Delete')}}
        </x-form.button>

        <a href="{{ route('content.index') }}"
           class="px-5 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100 rounded-xl shadow transition">
            {{__('Back to All Contents')}}
        </a>
    </div>
</div>
