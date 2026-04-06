@props(['active', 'icon'])

@php
    $classes =
        $active ?? false
            ? 'flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-[0.1em] text-[#FEFAE0] bg-[#BC6C25]/20 border-r-4 border-[#BC6C25] transition-all duration-300'
            : 'flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-[0.1em] text-[#FEFAE0]/60 hover:text-[#FEFAE0] hover:bg-white/5 transition-all duration-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} wire:navigate>
    <svg class="w-5 h-5 {{ $active ? 'text-[#DDA15E]' : 'text-current' }}" fill="none" stroke="currentColor"
        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"></path>
    </svg>
    <span>{{ $slot }}</span>
</a>
