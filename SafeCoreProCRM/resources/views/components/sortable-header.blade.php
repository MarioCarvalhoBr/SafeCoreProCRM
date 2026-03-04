@props(['column', 'label'])

@php
    $currentSort = request('sort_by');
    $currentDir = request('sort_dir', 'asc');
    $isCurrent = $currentSort === $column;
    // Se clicar na mesma coluna, inverte a direção. Se for coluna nova, começa com 'asc'
    $nextDir = $isCurrent && $currentDir === 'asc' ? 'desc' : 'asc';
@endphp

<a href="{{ request()->fullUrlWithQuery(['sort_by' => $column, 'sort_dir' => $nextDir]) }}" class="flex items-center space-x-1 hover:text-blue-500 dark:hover:text-blue-400 transition cursor-pointer">
    <span>{{ $label }}</span>

    @if($isCurrent)
        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            @if($currentDir === 'asc')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /> @else
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /> @endif
        </svg>
    @else
        <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" /> </svg>
    @endif
</a>
