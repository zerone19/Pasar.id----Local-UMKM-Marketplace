@extends('layouts.marketplace')

@section('title', 'Keranjang — Pasar.ID')

@section('content')
<div class="mx-auto max-w-content px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="mb-6 text-2xl font-bold text-ink">Keranjang Belanja</h1>

    @if (session('success'))
        <p class="mb-4 rounded-md bg-leaf-container/60 px-4 py-2 text-sm font-semibold text-brand">{{ session('success') }}</p>
    @endif
    @if (session('error'))
        <p class="mb-4 rounded-md bg-error-container px-4 py-2 text-sm font-semibold text-error-onContainer">{{ session('error') }}</p>
    @endif

    @if ($items->isEmpty())
        <div class="card p-10 text-center">
            <p class="text-ink-variant">Keranjang Anda kosong.</p>
            <a href="{{ route('products.index') }}" class="btn-primary mt-4 inline-flex">Mulai Belanja &rarr;</a>
        </div>
    @else
        <div class="card divide-y">
            @foreach ($items as $item)
                <div class="flex items-center gap-4 p-4">
                    <div class="h-16 w-16 shrink-0 overflow-hidden rounded-md bg-surface-mid">
                        @if ($item->product->thumbnail)
                            <img src="{{ asset('storage/' . $item->product->thumbnail) }}" class="h-full w-full object-cover">
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <a href="{{ route('products.show', $item->product) }}" class="font-semibold text-ink hover:text-brand">{{ $item->product->name }}</a>
                        <p class="text-sm text-ink-variant">{{ $item->product->store->store_name ?? '' }}</p>
                        <p class="text-sm font-semibold text-brand">{{ $item->product->formatted_price ?? 'Rp ' . number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-1">
                        @csrf @method('patch')
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99" class="input-field w-16 text-center">
                        <button class="text-sm font-semibold text-brand">Ubah</button>
                    </form>
                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                        @csrf @method('delete')
                        <button class="text-sm font-semibold text-error">Hapus</button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex items-center justify-between">
            <span class="text-lg font-bold text-ink">Total: Rp {{ number_format($total, 0, ',', '.') }}</span>
            <a href="{{ route('checkout') }}" class="btn-primary">Checkout &rarr;</a>
        </div>
    @endif
</div>
@endsection
