@extends('layouts.marketplace')

@section('title', 'Detail Pesanan — Pasar.ID')

@section('content')
<div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-8">
    <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-brand hover:underline">&larr; Kembali</a>

    <div class="card mt-4 p-6">
        <div class="flex justify-between border-b border-outline-variant/60 pb-3">
            <div>
                <p class="font-bold text-ink">{{ $order->order_number }}</p>
                <p class="text-sm text-ink-variant">Toko: {{ $order->store->store_name }}</p>
            </div>
            <div class="text-right text-sm">
                <p class="font-semibold text-ink">Status: {{ ucfirst($order->order_status) }}</p>
                <p class="text-ink-variant">Pembayaran: {{ ucfirst($order->payment_status) }} ({{ strtoupper($order->payment_method) }})</p>
            </div>
        </div>

        <div class="mt-3 divide-y">
            @foreach ($order->items as $item)
                <div class="flex justify-between py-2 text-sm">
                    <span class="text-ink">{{ $item->product->name ?? 'Produk' }} x {{ $item->quantity }}</span>
                    <span class="font-semibold text-ink">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <div class="flex justify-between border-t pt-3 font-bold text-ink">
            <span>Total</span>
            <span class="text-brand">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
        </div>

        <div class="mt-4 space-y-1 text-sm text-ink-variant">
            <p><span class="font-medium text-ink">Alamat:</span> {{ $order->address }}</p>
            <p><span class="font-medium text-ink">Telepon:</span> {{ $order->phone }}</p>
            @if ($order->notes)
                <p><span class="font-medium text-ink">Catatan:</span> {{ $order->notes }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
