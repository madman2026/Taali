<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                All Contents
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Manage and review published contents
            </p>
        </div>

        @role('super-admin')
        <x-form.button href="{{ route('content.create') }}" icon="+">
            Create Content
        </x-form.button>
        @endrole
    </div>

    <!-- Search Section -->
    <div class="relative mb-8 max-w-md">
        <div class="relative">
            <input
                type="text"
                wire:model.live.debounce.500ms="search"
                placeholder="Search by title or excerpt..."
                class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 transition-shadow"
            />

            <!-- Search Icon (Static) -->
            <span class="absolute left-3 top-3 text-gray-400 pointer-events-none" wire:loading.remove wire:target="search">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>

            <!-- Loading Spinner -->
            <div wire:loading wire:target="search" class="absolute left-3 top-3">
                <svg class="animate-spin h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </div>

            <!-- Clear Search Button -->
            @if($search)
                <button
                    wire:click="$set('search', '')"
                    class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            @endif
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($contents as $content)
            <div
                wire:key="content-{{ $content->id }}"
                wire:loading.class="opacity-50 pointer-events-none"
                wire:target="approvedContent({{ $content->id }}),rejectContent({{ $content->id }}),deleteContent({{ $content->id }})"
                class="group flex flex-col h-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
            >
                <!-- Image Section -->
                <div class="h-48 shrink-0 bg-gray-100 dark:bg-gray-800 overflow-hidden relative">
                    @if($content->image)
                        {{--
                            نکته مهم: اگر در دیتابیس مسیر فایل ذخیره شده است، از asset('storage/...') استفاده کنید.
                            temporary_url فقط برای فایل‌های در حال آپلود کار می‌کند.
                        --}}
                        <img src="{{ asset('storage/' . $content->image) }}"
                             alt="{{ $content->title }}"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-gray-400 bg-gray-50 dark:bg-gray-800/50">
                            <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-xs font-medium">No Image</span>
                        </div>
                    @endif

                    <!-- Status Badge (Overlay) -->
                    @if($content->status)
                        @role('super-admin')
                        <div class="absolute top-3 right-3">
                                <span @class([
                                    'px-2.5 py-1 rounded-full text-xs font-bold shadow-sm backdrop-blur-md border border-white/20',
                                    'bg-green-100/90 text-green-700' => $content->status->value === 'Approved',
                                    'bg-red-100/90 text-red-700' => $content->status->value === 'Rejected',
                                    'bg-yellow-100/90 text-yellow-700' => $content->status->value === 'Pending',
                                    'bg-gray-100/90 text-gray-700' => !in_array($content->status->value, ['Approved', 'Rejected', 'Pending'])
                                ])>
                                    {{ $content->status->value }}
                                </span>
                        </div>
                        @endrole
                    @endif
                </div>

                <!-- Body Section (Flex Grow) -->
                <div class="p-5 flex flex-col flex-1">
                    <div class="space-y-3 mb-4">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 line-clamp-1" title="{{ $content->title }}">
                            {{ $content->title }}
                        </h2>

                        <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-3 leading-relaxed">
                            {{ $content->excerpt }}
                        </p>
                    </div>

                    <!-- Footer Actions (Mt-Auto pushes this to bottom) -->
                    <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between gap-2">

                        <x-form.button size="xs" variant="ghost" :href="route('content.show', $content->slug)">
                            View
                        </x-form.button>

                        @role('super-admin|admin')
                        <div class="flex items-center gap-1">
                            <!-- Edit -->
                            <x-form.button size="xs" variant="secondary" icon-only :href="route('content.edit', $content->slug)" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            </x-form.button>

                            @role('super-admin')
                            @if($content->status != Modules\Content\Enums\ContentStatusEnum::APPROVED)
                                <!-- Approve -->
                                <x-form.button size="xs" variant="secondary" class="text-green-600 hover:text-green-700 hover:bg-green-50" wire:click="approveContent({{$content->id}})" title="Approve">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </x-form.button>
                            @else
                                <!-- Reject -->
                                <x-form.button size="xs" variant="secondary" class="text-orange-600 hover:text-orange-700 hover:bg-orange-50" wire:click="rejectContent({{$content->id}})" title="Reject">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </x-form.button>
                            @endif
                            @endrole

                            <!-- Delete -->
                            <x-form.button
                                size="xs"
                                variant="danger"
                                icon-only
                                wire:click="deleteContent({{ $content->id }})"
                                wire:confirm="آیا از حذف محتوا اطمینان دارید؟"
                                title="Delete">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </x-form.button>
                        </div>
                        @endrole
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">No content found</h3>
                <p class="text-gray-500 mt-1">Try adjusting your search criteria</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-10">
        {{ $contents->links() }}
    </div>
</div>
