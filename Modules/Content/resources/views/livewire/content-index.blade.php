<!-- Content Index Component (Blade + Tailwind) -->
<div class="max-w-5xl mx-auto p-6 sm:p-8 bg-white dark:bg-gray-900 rounded-2xl shadow-lg dark:shadow-xl">

    <h1 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-gray-100 flex items-center justify-between">
        <span>All Contents</span>
        <a href="{{ route('content.create') }}"
           class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm transition">
            + Create New
        </a>
    </h1>

    <!-- Search / Filters -->
    <div class="flex flex-col sm:flex-row gap-4 mb-6">
        <input type="text" wire:model.live="search"
               placeholder="Search content..."
               class="flex-1 px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                      rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-gray-100" />

    </div>

    <!-- Grid List -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($contents as $content)
            <div class="bg-gray-50 dark:bg-[#1a1a1a] border border-gray-200 dark:border-gray-800 rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                <!-- Image -->
                @if($content->image)
                    <img src="{{ asset('storage/'.$content->image) }}" alt="Content Image"
                         class="w-full h-40 object-cover">
                @else
                    <div class="w-full h-40 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 text-sm">
                        No Image
                    </div>
                @endif

                <div class="p-4 space-y-3">
                    <!-- Title -->
                    <h2 class="font-semibold text-lg text-gray-900 dark:text-gray-100 line-clamp-1">
                        {{ $content->title }}
                    </h2>

                    <!-- Excerpt -->
                    <p class="text-gray-700 dark:text-gray-300 text-sm line-clamp-2">
                        {{ $content->excerpt }}
                    </p>

                    <!-- Audio Preview -->
                    @if($content->audio)
                        <audio controls class="w-full mt-2">
                            <source src="{{ asset('storage/'.$content->audio) }}" type="audio/mpeg">
                        </audio>
                    @endif

                    <!-- Video Preview -->
                    @if($content->video_hash)
                        <div class="relative pb-[57%] h-0 rounded-lg overflow-hidden border border-gray-300 dark:border-gray-600 mt-2">
                            <iframe class="absolute inset-0 w-full h-full"
                                    src="https://www.aparat.com/video/video/embed/videohash/{{ $content->video_hash }}/vt/frame"
                                    allowfullscreen>
                            </iframe>
                        </div>
                    @endif

                    <!-- Buttons -->
                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('content.show', $content->id) }}"
                           class="px-3 py-1.5 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition">
                            View
                        </a>

                        <div class="flex gap-2">
                            <a href="{{ route('content.edit', $content->id) }}"
                               class="px-3 py-1.5 text-sm bg-yellow-500 hover:bg-yellow-600 text-white rounded-md transition">
                                Edit
                            </a>
                            <button wire:click="delete({{ $content->id }})"
                                    class="px-3 py-1.5 text-sm bg-red-600 hover:bg-red-700 text-white rounded-md transition">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500 dark:text-gray-300 py-10">No content found.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $contents->links() }}
    </div>
</div>
