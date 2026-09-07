@extends('layouts.marketplace')

@section('title', $category->name . ' — Pasar.ID')

@section('content')
<div class="mx-auto max-w-content px-4 sm:px-6 lg:px-8">
    <nav class="py-6 text-sm text-ink-variant">
        <a href="{{ route('products.index') }}" class="hover:text-brand">Beranda</a>
        <span class="mx-1">/</span>
        <span class="text-ink">{{ $category->name }}</span>
    </nav>

    <h1 class="mb-6 text-2xl font-bold text-ink">{{ $category->name }}</h1>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        @forelse ($products as $product)
            @include('marketplace.partials.product-card', ['product' => $product])
        @empty
            <p class="col-span-full text-sm text-ink-variant">Belum ada produk di kategori ini.</p>
        @endforelse
    </div>

    <div class="mt-0">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
