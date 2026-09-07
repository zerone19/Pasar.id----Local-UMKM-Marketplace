@php
    $paginator->appends(request()->query());
@endphp

{{-- Pagination: Pasar.ID Design System --}}
{{-- "Menempel" — flat, minimalis, no decorative container --}}
<div class="flex justify-center items-center gap-1 mt-12 mb-8 font-label">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <button disabled class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-ink-variant rounded-md border border-outline-variant opacity-50 cursor-not-allowed">
            <span class="material-symbols-outlined text-sm">chevron_left</span>
        </button>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-ink rounded-md border border-outline-variant transition-colors hover:bg-surface-high">
            <span class="material-symbols-outlined text-sm">chevron_left</span>
        </a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="px-2 py-0.5 text-sm text-ink-variant">
                {{ $element }}
            </span>
        @endif

        @if (is_array($element))
            @foreach ($element as $url => $page)
                @if ($page->currentPage)
                    <button class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-white bg-brand rounded-md">
                        {{ $page->label }}
                    </button>
                @else
                    <a href="{{ $page->url }}" class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-ink rounded-md border border-outline-variant transition-colors hover:bg-surface-high">
                        {{ $page->label }}
                    </a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-ink rounded-md border border-outline-variant transition-colors hover:bg-surface-high">
            <span class="material-symbols-outlined text-sm">chevron_right</span>
        </a>
    @else
        <button disabled class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-ink-variant rounded-md border border-outline-variant opacity-50 cursor-not-allowed">
            <span class="material-symbols-outlined text-sm">chevron_right</span>
        </button>
    @endif
</div>
