<div

    x-data="{ open: @entangle('show') }"
    x-show.transition.opacity="open"
    style="display:none"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-96">
        <h3 class="text-lg font-semibold mb-4">{{ $data['title'] ?? __('Confirm') }}</h3>
        <p class="mb-6 text-gray-600 dark:text-gray-300">{{ $data['message'] ?? '' }}</p>
        <div class="flex justify-end gap-3">
            <button type="button" wire:click="closeModal"
                    class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                {{ $data['cancelButtonText'] ?? __('Cancel') }}
            </button>
            <button type="button" wire:click="confirm"
                    class="px-4 py-2 rounded text-white"
                    :class="`bg-${$data['confirmColor'] ?? 'blue'}-600 hover:bg-${$data['confirmColor'] ?? 'blue'}-700`">
                {{ $data['confirmButtonText'] ?? __('Confirm') }}
            </button>
        </div>
    </div>
</div>
