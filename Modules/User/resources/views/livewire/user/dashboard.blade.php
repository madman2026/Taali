<div
    x-data="{ sidebarOpen: true }"
    class="flex min-h-screen bg-linear-to-br from-gray-50 via-white to-gray-100
           dark:from-gray-900 dark:via-gray-950 dark:to-gray-900 transition-colors duration-300">

    <!-- Sidebar toggle button (mobile) -->
    <button @click="sidebarOpen = !sidebarOpen"
            x-show='!sidebarOpen'
            class="fixed top-4 right-4 z-50 p-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-500 transition">
        <x-heroicon-o-bars-3 class="w-6 h-6" />
    </button>

    <!-- Sidebar -->
    <aside x-show="sidebarOpen"
           x-transition:enter="transition transform duration-300"
           x-transition:enter-start="translate-x-full opacity-0"
           x-transition:enter-end="translate-x-0 opacity-100"
           x-transition:leave="transition transform duration-300"
           x-transition:leave-start="translate-x-0 opacity-100"
           x-transition:leave-end="translate-x-full opacity-0"
           class="fixed top-0 right-0 w-64 md:w-64 h-full z-40
                  bg-white/95 dark:bg-gray-900/95 border-l border-gray-200 dark:border-gray-700
                  shadow-xl backdrop-blur-md overflow-y-auto
                  scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-700
                  transform transition-transform duration-300 ease-in-out">

        <!-- Sidebar Header -->
        <div class="p-5 flex items-center justify-between border-b border-gray-200 dark:border-gray-700">
            <span class="font-semibold text-lg text-indigo-600 dark:text-indigo-400 tracking-tight">
                {{ config('app.name') }}
            </span>
            <button @click="sidebarOpen = false" class=" text-gray-500 dark:text-gray-400 hover:text-red-500">
                <x-heroicon-o-x-mark class="w-5 h-5" />
            </button>
        </div>

        <!-- Navigation -->
        <nav class="p-4 space-y-2">
            @php
                $links = [
                    ['route'=>'dashboard','icon'=>'home','label'=>__('Dashboard')],
                    ['route'=>'profile','icon'=>'user','label'=>__('Profile')],
                    ['route'=>'settings','icon'=>'cog-6-tooth','label'=>__('Settings')],
                    ['route'=>'password.reset','icon'=>'key','label'=>__('Reset Password')],
                ];
            @endphp

            @foreach ($links as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-700 dark:text-gray-200
                          hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400
                          transition-all duration-200 ease-in-out">
                    <x-dynamic-component :component="'heroicon-o-' . $item['icon']" class="w-5 h-5" />
                    {{ $item['label'] }}
                </a>
            @endforeach

            <div class="border-t border-gray-200 dark:border-gray-700 my-3"></div>

            <!-- Account Status Button -->
            <button type="button"
                wire:click="confirmToggleStatus"
                class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all duration-200 w-full"
                :class="{
                    'text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/30': @js($isActive),
                    'text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/30': !@js($isActive)
                }">
                <x-dynamic-component :component="'heroicon-o-' . ($isActive ? 'pause-circle' : 'play-circle')" class="w-5 h-5" />
                {{ $isActive ? __('Deactivate Account') : __('Activate Account') }}
            </button>

            <!-- Delete Account -->
            <button type="button"
                wire:click="confirmDeleteAccount"
                class="flex items-center gap-3 px-3 py-2 rounded-xl text-red-600 dark:text-red-400
                    hover:bg-red-50 dark:hover:bg-red-900/30 transition-all duration-200 w-full">
                <x-heroicon-o-trash class="w-5 h-5" />
                {{ __('Delete Account') }}
            </button>

            @if(auth()->user()?->hasRole('admin'))
                <div class="border-t border-gray-200 dark:border-gray-700 my-3"></div>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-indigo-600 dark:text-indigo-400
                          hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-all duration-200">
                    <x-heroicon-o-shield-check class="w-5 h-5" />
                    {{ __('Admin Panel') }}
                </a>
                <a href="{{ route('admin.file.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-700 dark:text-gray-200
                          hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                    <x-heroicon-o-folder class="w-5 h-5" />
                    {{ __('File Manager') }}
                </a>
            @endif

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        onclick="return confirm('{{ __('Are you sure you want to logout?') }}')"
                        class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-gray-700 dark:text-gray-200
                               hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                    <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5" />
                    {{ __('Logout') }}
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 transition-all duration-300">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $stats = [
                        ['icon'=>'eye','color'=>'indigo','label'=>__('Views'),'value'=>$views],
                        ['icon'=>'hand-thumb-up','color'=>'green','label'=>__('Likes'),'value'=>$likes],
                        ['icon'=>'chat-bubble-left-ellipsis','color'=>'amber','label'=>__('Comments'),'value'=>$commentsCount],
                        ['icon'=>'document-text','color'=>'purple','label'=>__('Posts'),'value'=>$contentsCount],
                    ];

                    $colors = [
                        'indigo' => 'bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400',
                        'green'  => 'bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400',
                        'amber'  => 'bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400',
                        'purple' => 'bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400',
                    ];
                @endphp

                @foreach ($stats as $s)
                    <div class="group p-5 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700
                                shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex items-center gap-4">
                        <div class="p-3 rounded-xl {{ $colors[$s['color']] }} group-hover:scale-110 transition-transform duration-300">
                            <x-dynamic-component :component="'heroicon-o-' . $s['icon']" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $s['label'] }}</p>
                            <p class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $s['value'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <section class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                             rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold flex items-center gap-2 text-gray-800 dark:text-gray-100">
                        <x-heroicon-o-rectangle-stack class="w-5 h-5 text-indigo-500" />
                        {{ __('Latest Contents') }}
                    </h2>
                    <a href="{{ route('content.index') }}"
                       class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                        {{ __('View All') }}
                    </a>
                </div>

                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($contents ?? [] as $c)
                        <li class="p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-all duration-200">
                            <div>
                                <p class="font-medium text-gray-800 dark:text-gray-100">{{ $c->title }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $c->category->name ?? '-' }}</p>
                            </div>
                            <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                <span class="flex items-center gap-1">
                                    <x-heroicon-o-eye class="w-4 h-4" /> {{ $c->views_count }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <x-heroicon-o-hand-thumb-up class="w-4 h-4" /> {{ $c->likes_count }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="p-6 text-center text-gray-500 dark:text-gray-400">
                            {{ __('No content found.') }}
                        </li>
                    @endforelse
                </ul>
            </section>
        </div>
    </main>
</div>
