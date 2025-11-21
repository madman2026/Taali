<button type="{{ $type ?? 'submit' }}"
    {{ $attributes->merge([
        'class' => 'w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold
                    rounded-md transition-colors cursor-pointer duration-200 focus:ring focus:ring-indigo-300'
    ]) }}>
    {{ $slot }}
</button>
