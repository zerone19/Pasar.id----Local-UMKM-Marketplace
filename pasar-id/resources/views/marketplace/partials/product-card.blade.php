@props(['product'])

<a href="{{ route('products.show', $product) }}"
   class="card group flex flex-col overflow-hidden transition-colors hover:border-brand">
    <div class="relative aspect-square bg-surface-mid">
        @if ($product->thumbnail)
            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
        @else
            <div class="grid h-full w-full place-items-center bg-gradient-to-br from-surface-low to-surface-high text-brand/40">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" class="h-12 w-12">
                    <path d="M4 7h16M4 7l1-3h14l1 3M6 7v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M10 11h4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        @endif
        @if ($product->stock <= 0)
            <span class="absolute left-2 top-2 rounded-full bg-error-container px-2 py-0.5 text-xs font-semibold text-error-onContainer">Habis</span>
        @endif
    </div>
    <div class="flex flex-1 flex-col gap-1 p-3">
        @if ($product->category)
            <span class="chip w-fit">{{ $product->category->name }}</span>
        @endif
        <p class="line-clamp-2 text-sm font-semibold text-ink group-hover:text-brand">{{ $product->name }}</p>
        <p class="mt-auto text-base font-bold text-brand">{{ $product->formatted_price ?? 'Rp ' . number_format($product->price, 0, ',', '.') }}</p>
    </div>
</a>
