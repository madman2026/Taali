<div class="relative">
    <!-- دکمه پروفایل -->
    <button id="dropdownUserButton"
            data-dropdown-toggle="dropdownUserMenu"
            class="flex items-center gap-3 text-sm font-medium
                   text-gray-900 dark:text-gray-100
                   bg-white dark:bg-[#1A1A1A]
                   border border-gray-200 dark:border-gray-800/70
                   rounded-xl px-4 py-2.5
                   hover:bg-gray-100 dark:hover:bg-[#2A2A2A]
                   transition-all duration-200 shadow-sm">

        @if(Auth::user()->image->first()?->path)
            <img src="{{ asset(Auth::user()->image->first()->path) }}"
                 alt="User Avatar"
                 class="w-8 h-8 rounded-full object-cover
                        ring-1 ring-gray-300 dark:ring-gray-700">
        @else
            <x-heroicon-o-user class="w-6 h-6 opacity-80" />
        @endif

        <span class="font-semibold">
            {{ auth()->user()->name }}
        </span>

        <x-heroicon-o-chevron-down class="w-4 h-4 opacity-70" />
    </button>

    <!-- منوی کشویی -->
    <div id="dropdownUserMenu"
         class="hidden absolute right-0 mt-2 w-56 rounded-xl overflow-hidden z-50
                bg-white dark:bg-[#111]
                shadow-xl shadow-black/40
                border border-gray-200 dark:border-gray-800/70
                divide-y divide-gray-100 dark:divide-gray-800/80">

        <!-- لیست اصلی -->
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
            <li>
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-2.5
                          hover:bg-gray-100 dark:hover:bg-[#2A2A2A]
                          rounded-md mx-1 transition">
                    <x-heroicon-o-home class="w-5 h-5" />
                    داشبورد
                </a>
            </li>

            @hasrole('super-admin')
            <li>
                <a href="{{ route('content.create') }}"
                   class="flex items-center gap-3 px-4 py-2.5
                              hover:bg-gray-100 dark:hover:bg-[#2A2A2A]
                              rounded-md mx-1 transition">
                    <x-heroicon-o-plus-circle class="w-5 h-5" />
                    ایجاد محتوا
                </a>
            </li>

            <li>
                <a href="{{ route('content.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5
                              hover:bg-gray-100 dark:hover:bg-[#2A2A2A]
                              rounded-md mx-1 transition">
                    <x-heroicon-o-numbered-list class="w-5 h-5" />
                    لیست محتوا
                </a>
            </li>

            <li>
                <a href="{{ route('comment.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5
                              hover:bg-gray-100 dark:hover:bg-[#2A2A2A]
                              rounded-md mx-1 transition">
                    <x-heroicon-o-chat-bubble-left-right class="w-5 h-5" />
                    مدیریت دیدگاه‌ها
                </a>
            </li>
            @endhasrole

            <li>
                <a href="{{ route('settings') }}"
                   class="flex items-center gap-3 px-4 py-2.5
                          hover:bg-gray-100 dark:hover:bg-[#2A2A2A]
                          rounded-md mx-1 transition">
                    <x-heroicon-o-cog-6-tooth class="w-5 h-5" />
                    تنظیمات
                </a>
            </li>
        </ul>

        <!-- خروج -->
        <div class="py-2 bg-gray-50 dark:bg-[#0D0D0D]">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm
                               text-red-600 dark:text-red-400
                               hover:bg-gray-100 dark:hover:bg-[#2A2A2A]
                               rounded-md mx-1 transition">
                    <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5" />
                    خروج
                </button>
            </form>
        </div>
    </div>
</div>
