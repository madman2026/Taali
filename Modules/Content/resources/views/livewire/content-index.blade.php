<!-- Content Grid Experimental (Blade + Tailwind + Alpine + Livewire + AOS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4 sm:mb-0" data-aos="fade-right">
            All Contents
        </h1>

        @role('super-admin')
        <x-form.button href="{{ route('content.create') }}"
           data-aos="fade-left">
            + Create New
    </x-form.button>
        @endrole
    </div>

    <!-- Search -->
    <div class="mb-6">
        <input type="text" wire:model.live="search"
               placeholder="Search content..."
               class="w-full sm:w-1/2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($contents as $content)
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden"
                 data-aos="fade-up">

                <!-- Image Preview -->
                @if($content->image)
                    <div class="h-48 w-full overflow-hidden">
                        <img src="{{ $content->image->temporary_url }}"
                             alt="Content Image"
                             class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                    </div>
                @else
                    <div class="h-48 w-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-300">
                        No Image
                    </div>
                @endif

                <!-- Content Body -->
                <div class="p-4 space-y-3">

                    <!-- Title -->
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 line-clamp-1">
                        {{ $content->title }}
                    </h2>

                    <!-- Excerpt -->
                    <p class="text-gray-700 dark:text-gray-300 text-sm line-clamp-2">
                        {{ $content->excerpt }}
                    </p>

                    <!-- Audio Preview -->
                    @if($content->audio)
                        <audio controls class="w-full mt-2">
                            <source src="{{ $content->audio->temporary_url }}" type="{{ $content->audio->mime_type }}">
                        </audio>
                    @endif

                    <!-- Video Preview -->
                    @if($content->video_hash)
                        <div class="relative pb-[56.25%] h-0 mt-2 rounded-lg overflow-hidden border border-gray-300 dark:border-gray-600">
                            <iframe class="absolute inset-0 w-full h-full"
                                    src="https://www.aparat.com/video/video/embed/videohash/{{ $content->video_hash }}/vt/frame"
                                    allowfullscreen></iframe>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex items-center justify-between mt-4">
                        <x-form.button :href="route('content.show' , $content->slug)">
                            {{ __('Show') }}
                        </x-form.button>

                        <div class="flex gap-2">
                            <x-form.button variant="secondary" :href="route('content.edit' , $content->slug)">
                                {{ __('Edit') }}
                            </x-form.button>

                            <x-form.button variant="danger" wire:click="deleteContent({{ $content->id}})" wire:confirm="آیا از حذف محتوا اطمینان دارید؟">
                                {{ __('Delete') }}
                            </x-form.button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500 dark:text-gray-300 py-10" data-aos="fade-up">
                No content found.
            </p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $contents->links() }}
    </div>
</div>
