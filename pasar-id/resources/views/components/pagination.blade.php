@php
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();
    $hasPages = $last > 1;
@endphp

@if ($hasPages)
    {{-- Pagination: Pasar.ID Design System --}}
    {{-- "Menempel" — flat, minimalis, no decorative container --}}
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center items-center gap-1 mt-8 mb-4 font-label">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button disabled class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-ink-variant rounded-md border border-outline-variant opacity-50 cursor-not-allowed">
                <span class="material-symbols-outlined text-sm">chevron_left</span>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-ink rounded-md border border-outline-variant transition-colors hover:bg-surface-high" rel="prev">
                <span class="material-symbols-outlined text-sm">chevron_left</span>
            </a>
        @endif

        {{-- Page Links (with window) --}}
        @php
            $start = max(1, $current - 2);
            $end = min($last, $current + 2);
        @endphp

        {{-- First page + ellipsis if needed --}}
        @if ($start > 1)
            <a href="{{ $paginator->url(1) }}" class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-ink rounded-md border border-outline-variant transition-colors hover:bg-surface-high">1</a>
            @if ($start > 2)
                <span class="px-2 py-0.5 text-sm text-ink-variant">…</span>
            @endif
        @endif

        {{-- Page numbers --}}
        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $current)
                <button class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-white bg-brand rounded-md">
                    {{ $i }}
                </button>
            @else
                <a href="{{ $paginator->url($i) }}" class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-ink rounded-md border border-outline-variant transition-colors hover:bg-surface-high">
                    {{ $i }}
                </a>
            @endif
        @endfor

        {{-- Last page + ellipsis if needed --}}
        @if ($end < $last)
            @if ($end < $last - 1)
                <span class="px-2 py-0.5 text-sm text-ink-variant">…</span>
            @endif
            <a href="{{ $paginator->url($last) }}" class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-ink rounded-md border border-outline-variant transition-colors hover:bg-surface-high">
                {{ $last }}
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-ink rounded-md border border-outline-variant transition-colors hover:bg-surface-high" rel="next">
                <span class="material-symbols-outlined text-sm">chevron_right</span>
            </a>
        @else
            <button disabled class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-ink-variant rounded-md border border-outline-variant opacity-50 cursor-not-allowed">
                <span class="material-symbols-outlined text-sm">chevron_right</span>
            </button>
        @endif

    </nav>
@endif
