@extends('layouts.marketplace')

@section('title', 'Semua Kategori — Pasar.ID')

@section('content')
<div class="mx-auto max-w-content px-4 sm:px-6 lg:px-8">
    <nav class="py-6 text-sm text-ink-variant">
        <a href="{{ route('products.index') }}" class="hover:text-brand">Beranda</a>
        <span class="mx-1">/</span>
        <span class="text-ink">Kategori</span>
    </nav>

    <h1 class="mb-6 text-2xl font-bold text-ink">Semua Kategori</h1>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        @forelse ($categories as $category)
            <a href="{{ route('categories.show', $category) }}"
               class="card group flex flex-col items-center gap-3 p-6 text-center transition-colors hover:border-brand">
                @include('marketplace.partials.category-icon', ['category' => $category])
                <span class="text-sm font-semibold text-ink">{{ $category->name }}</span>
                <span class="text-xs text-ink-variant">{{ $category->products_count }} produk</span>
            </a>
        @empty
            <p class="col-span-full text-sm text-ink-variant">Belum ada kategori.</p>
        @endforelse
    </div>
</div>
@endsection
