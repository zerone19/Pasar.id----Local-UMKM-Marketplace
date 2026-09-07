@extends('layouts.marketplace')

@section('title', $store->store_name . ' — Pasar.ID')

@section('content')
<div class="mx-auto max-w-content px-4 sm:px-6 lg:px-8">
    <nav class="py-6 text-sm text-ink-variant">
        <a href="{{ route('products.index') }}" class="hover:text-brand">Beranda</a>
        <span class="mx-1">/</span>
        <span class="text-ink">{{ $store->store_name }}</span>
    </nav>

    <section class="card mb-8 flex flex-col gap-3 p-6 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            @if ($store->logo)
                <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->store_name }}" class="h-14 w-14 rounded-full object-cover border">
            @else
                <span class="grid h-14 w-14 shrink-0 place-items-center rounded-full bg-leaf-container text-brand">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-7 w-7">
                        <path d="M3 9l1-4h16l1 4M4 9v11h16V9M9 20v-6h6v6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            @endif
            <div>
                <h1 class="text-2xl font-bold text-ink">{{ $store->store_name }}</h1>
                <p class="text-sm text-ink-variant">{{ $store->city ?? '—' }}{{ $store->province ? ', ' . $store->province : '' }}</p>
            </div>
        </div>
        @if ($store->description)
            <p class="max-w-xl text-sm text-ink-variant">{{ $store->description }}</p>
        @endif
    </section>

    <h2 class="mb-5 text-xl font-bold text-ink">Produk dari toko ini</h2>
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        @forelse ($products as $product)
            @include('marketplace.partials.product-card', ['product' => $product])
        @empty
            <p class="col-span-full text-sm text-ink-variant">Toko ini belum punya produk.</p>
        @endforelse
    </div>

    <div class="mt-0">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
