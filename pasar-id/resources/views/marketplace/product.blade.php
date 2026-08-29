@extends('layouts.marketplace')

@section('title', $product->name . ' — Pasar.ID')

@section('content')
<div class="mx-auto max-w-content px-4 sm:px-6 lg:px-8">
    <nav class="py-6 text-sm text-ink-variant">
        <a href="{{ route('products.index') }}" class="hover:text-brand">Beranda</a>
        <span class="mx-1">/</span>
        @if ($product->category)
            <a href="{{ route('categories.show', $product->category) }}" class="hover:text-brand">{{ $product->category->name }}</a>
            <span class="mx-1">/</span>
        @endif
        <span class="text-ink">{{ $product->name }}</span>
    </nav>

    <div class="grid gap-8 md:grid-cols-2">
        {{-- Galeri --}}
        <div class="card overflow-hidden">
            <div class="aspect-square bg-surface-mid">
                @if ($product->thumbnail)
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                @else
                    <div class="grid h-full w-full place-items-center bg-gradient-to-br from-surface-low to-surface-high text-brand/40">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" class="h-16 w-16">
                            <path d="M4 7h16M4 7l1-3h14l1 3M6 7v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M10 11h4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        {{-- Detail --}}
        <div>
            @if ($product->category)
                <span class="chip">{{ $product->category->name }}</span>
            @endif
            <h1 class="mt-3 text-2xl font-bold text-ink sm:text-3xl">{{ $product->name }}</h1>

            <p class="mt-3 text-2xl font-bold text-brand">{{ $product->formatted_price }}</p>
            <p class="mt-1 text-sm text-ink-variant">Tersisa {{ $product->stock }} buah</p>

            {{-- Penjual --}}
            <a href="{{ route('stores.show', $product->store) }}" class="card mt-5 flex items-center gap-3 p-4 transition-colors hover:border-brand">
                <span class="grid h-10 w-10 place-items-center rounded-full bg-leaf-container text-brand">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5">
                        <path d="M3 9l1-4h16l1 4M4 9v11h16V9M9 20v-6h6v6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-ink">{{ $product->store->store_name }}</p>
                    <p class="text-xs text-ink-variant">{{ $product->store->city ?? '—' }}</p>
                </div>
                <span class="text-sm font-semibold text-brand">Kunjungi Toko &rsaquo;</span>
            </a>

            <div class="mt-5 prose text-sm text-ink-variant">
                {!! nl2br(e($product->description)) !!}
            </div>

            {{-- Aksi --}}
            @if ($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="mt-6 flex items-center gap-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                           class="input-field w-20 text-center">
                    <button class="btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                            <path d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13 5.4 5M7 13l-2 5h12" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Tambah ke Keranjang
                    </button>
                </form>
            @else
                <p class="mt-6 rounded-md bg-error-container px-4 py-3 text-sm font-semibold text-error-onContainer">Stok habis</p>
            @endif
        </div>
    </div>

    {{-- Produk serupa --}}
    @if ($product->store->products()->where('id', '!=', $product->id)->where('status','active')->where('stock','>',0)->exists())
    <section class="mt-14">
        <h2 class="mb-5 text-xl font-bold text-ink">Produk Serupa dari UMKM Ini</h2>
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            @foreach ($product->store->products()->where('id', '!=', $product->id)->where('status','active')->where('stock','>',0)->limit(4)->get() as $related)
                @include('marketplace.partials.product-card', ['product' => $related])
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
