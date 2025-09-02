@props([
    'permission',
    'href' => null,
    'type' => 'button',
    'class' => '',
    'disabled' => false
])

@permission($permission)
    @if($href)
        <a href="{{ $href }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 {{ $class }} {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
           @if($disabled) onclick="return false;" @endif>
            {{ $slot }}
        </a>
    @else
        <button type="{{ $type }}" 
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 {{ $class }} {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
                @if($disabled) disabled @endif>
            {{ $slot }}
        </button>
    @endif
@endpermission
