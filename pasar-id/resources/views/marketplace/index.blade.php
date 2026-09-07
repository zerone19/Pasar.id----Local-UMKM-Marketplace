@extends('layouts.marketplace')

@section('title', 'Pasar.ID — Marketplace UMKM Lokal')

@section('content')
<div class="mx-auto max-w-content px-4 sm:px-6 lg:px-8">

    {{-- Hero --}}
    <section class="mt-6 overflow-hidden rounded-lg bg-brand text-brand-on shadow-leaf">
        <div class="grid items-stretch md:grid-cols-2">
            <div class="flex flex-col justify-center gap-5 p-8 md:p-12">
                <span class="chip bg-brand-soft text-brand w-fit">Gotong Royong UMKM</span>
                <h1 class="text-3xl font-bold leading-tight sm:text-4xl">Mendukung UMKM Lokal,<br>Dari Pasar ke Pintu Anda.</h1>
                <p class="max-w-md text-sm text-brand-on/80 sm:text-base">Sayur segar, jajanan pasar, hingga kerajinan tangan — semua dari pengrajin dan pedagang lokal di sekitar Anda.</p>
                <div>
                    <a href="{{ route('products.index') }}" class="btn-leaf">Mulai Belanja &rarr;</a>
                </div>
            </div>
            <div class="relative hidden min-h-[260px] md:block">
                <img src="{{ asset('assets/img/hero-pasar.png') }}?v=2" alt="Pasar tradisional lokal" class="absolute inset-0 h-full w-full rounded-r-lg object-cover">
                <div class="absolute inset-0 rounded-r-lg bg-gradient-to-br from-brand-container/30 to-brand/15"></div>
            </div>
        </div>
    </section>

    {{-- Kategori Pilihan --}}
    <section id="kategori" class="mt-14">
        <div class="flex items-end justify-between mb-5">
            <div>
                <h2 class="text-2xl font-bold text-ink">Kategori Pilihan</h2>
                <p class="text-sm text-ink-variant">Jelajahi kebutuhan harian Anda</p>
            </div>
            <a href="{{ route('categories.index') }}" class="text-sm font-semibold text-brand hover:underline">Lihat Semua &rsaquo;</a>
        </div>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            @forelse ($categories as $category)
                <a href="{{ route('categories.show', $category) }}"
                   class="card group flex flex-col items-center gap-3 p-6 text-center transition-colors hover:border-brand">
                    @include('marketplace.partials.category-icon', ['category' => $category])
                    <span class="text-sm font-semibold text-ink">{{ $category->name }}</span>
                </a>
            @empty
                <p class="col-span-full text-sm text-ink-variant">Belum ada kategori.</p>
            @endforelse
        </div>
    </section>

    {{-- Produk Unggulan --}}
    @if ($featured->isNotEmpty())
    <section class="mt-14">
        <div class="flex items-end justify-between mb-5">
            <div>
                <h2 class="text-2xl font-bold text-ink">Produk Unggulan</h2>
                <p class="text-sm text-ink-variant">Dukung penggerak ekonomi sekitar Anda</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-brand hover:underline">Lihat Semua &rsaquo;</a>
        </div>
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            @foreach ($featured as $product)
                @include('marketplace.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
    @endif

    {{-- Produk Terbaru --}}
    <section class="mt-14">
        <h2 class="mb-5 text-2xl font-bold text-ink">Produk Terbaru</h2>
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            @forelse ($products as $product)
                @include('marketplace.partials.product-card', ['product' => $product])
            @empty
                <p class="col-span-full text-sm text-ink-variant">Belum ada produk yang tersedia.</p>
            @endforelse
        </div>
        <div class="mt-0">
            {{ $products->withQueryString()->links() }}
        </div>
    </section>

    {{-- Toko Populer --}}
    @if ($stores->isNotEmpty())
    <section class="mt-14">
        <h2 class="mb-5 text-2xl font-bold text-ink">Toko Populer</h2>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
            @foreach ($stores as $store)
                <a href="{{ route('stores.show', $store) }}" class="card group flex items-center gap-4 p-5 transition-colors hover:border-brand">
                    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-leaf-container text-brand">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-6 w-6">
                            <path d="M3 9l1-4h16l1 4M4 9v11h16V9M9 20v-6h6v6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <p class="truncate font-semibold text-ink">{{ $store->store_name }}</p>
                        <p class="text-sm text-ink-variant">{{ $store->city ?? '—' }} · {{ $store->products_count }} produk</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection
