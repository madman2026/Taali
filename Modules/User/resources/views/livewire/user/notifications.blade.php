<div class="max-w-3xl mx-auto space-y-4">

    <h2 class="text-xl font-bold">{{__('notifications')}}</h2>

    @forelse ($notifications as $notification)
        <div class="p-4 rounded border shadow-sm bg-white flex justify-between items-start">

            <div>
                <div class="font-semibold
                    {{ $notification->read_at ? 'text-gray-500' : 'text-blue-600' }}">
                    {{ $notification->data['title'] ?? __('new notification') }}
                </div>

                <div class="text-sm text-gray-600 mt-1">
                    {{ $notification->data['message'] ?? '' }}
                </div>

                <div class="text-xs text-gray-400 mt-2">
                    {{ $notification->created_at->ago() }}
                </div>
            </div>

            <div class="flex flex-col gap-2 text-sm">

                @if(!$notification->read_at)
                    <button wire:click="markAsRead('{{ $notification->id }}')"
                            class="text-blue-600 hover:underline">
                        {{__('readed')}}
                    </button>
                @endif

                <button wire:click="deleteNotification('{{ $notification->id }}')"
                        class="text-red-600 hover:underline">
                    {{__('deleted')}}
                </button>
            </div>

        </div>
    @empty
        <div class="p-4 text-center text-gray-500">
            {{__('no notifications found!')}}
        </div>
    @endforelse

    <div>
        {{ $notifications->links() }}
    </div>
</div>
