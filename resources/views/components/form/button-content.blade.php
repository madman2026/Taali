@if($loading)
    <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" aria-hidden="true">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>
    </svg>
@elseif($icon && $iconPosition === 'left')
    <span class="shrink-0">{!! $icon !!}</span>
@endif

@if(trim($slot) !== '')
    <span>{{ $slot }}</span>
@endif

@if($icon && !$loading && $iconPosition === 'right')
    <span class="shrink-0">{!! $icon !!}</span>
@endif
