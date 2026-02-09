<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10
            bg-gray-50 dark:bg-gray-950">

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 dark:text-gray-400 mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center gap-2">
            <li>
                <a href="{{ route('content.index') }}"
                   class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition">
                    All Contents
                </a>
            </li>
            <li class="text-gray-400 dark:text-gray-600">/</li>
            <li class="text-gray-900 dark:text-gray-100 font-medium truncate">
                {{ $content->title }}
            </li>
        </ol>
    </nav>

    <!-- Title -->
    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-gray-50 mb-8 leading-tight">
        {{ $content->title }}
    </h1>

    <!-- Image -->
    @if($content->image)
        <div class="mb-8 rounded-2xl overflow-hidden
                    bg-white dark:bg-gray-900
                    shadow-sm dark:shadow-none
                    ring-1 ring-gray-200 dark:ring-gray-800">
            <img
                src="{{ $content->image->temporary_url }}"
                alt="{{ $content->title }}"
                class="w-full max-h-[420px] object-cover
                       hover:scale-[1.02] transition-transform duration-500"
            >
        </div>
    @endif

    <!-- Excerpt -->
    <section class="mb-8 rounded-xl p-5
                    bg-indigo-50/60 dark:bg-indigo-950/30
                    border border-indigo-100 dark:border-indigo-900/50">
        <h2 class="text-sm font-semibold text-indigo-700 dark:text-indigo-300 mb-2">
            {{ __('Excerpt') }}
        </h2>
        <p class="text-gray-800 dark:text-gray-200 leading-relaxed">
            {{ $content->excerpt }}
        </p>
    </section>

    <!-- Description -->
    <section class="mb-10">
        <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-3">
            {{ __('Description') }}
        </h2>
        <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
            {{ $content->description }}
        </div>
    </section>

    <!-- Audio -->
    @if($content->audio)
        <section class="mb-8">
            <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">
                {{ __('Audio') }}
            </h2>
            <audio controls
                   class="w-full rounded-lg
                          bg-white dark:bg-gray-900
                          ring-1 ring-gray-200 dark:ring-gray-800">
                <source src="{{ $content->audio->temporary_url }}" type="{{ $content->audio->mime_type }}">
            </audio>
        </section>
    @endif

    <!-- Video -->
    @if($content->video)
        <section class="mb-10">
            <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-3">
                {{ __('Video') }}
            </h2>
            <div class="relative pb-[56.25%] h-0 rounded-xl overflow-hidden
                        bg-white dark:bg-gray-900
                        ring-1 ring-gray-200 dark:ring-gray-800">
                <iframe
                    title="Content video"
                    class="absolute inset-0 w-full h-full"
                    src="https://www.aparat.com/video/video/embed/videohash/{{ $content->video->path }}/vt/frame"
                    allowfullscreen>
                </iframe>
            </div>
        </section>
    @endif

    <!-- Comments -->
    <section class="mt-12 pt-8
                    border-t border-gray-200 dark:border-gray-800">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">
            {{ __('Comments') }}
        </h2>

        <livewire:interaction::comment.comment-index :commentable="$content" />

        <div class="mt-6">
            <livewire:interaction::comment.comment-create :commentable="$content" />
        </div>
    </section>

    <!-- Actions -->
    <div class="mt-10 flex flex-wrap gap-3 items-center">
        <x-form.button>
            ← {{ __('Back to contents') }}
        </x-form.button>

        @role('super-admin|admin')
        <x-form.button variant="secondary">
            {{ __('Edit') }}
        </x-form.button>

        <x-form.button variant="danger">
            {{ __('Delete') }}
        </x-form.button>
        @endrole
    </div>

</div>
