@extends('layouts.marketplace')

@section('title', 'Pesanan Saya — Pasar.ID')

@section('content')
<div class="mx-auto max-w-content px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="mb-6 text-2xl font-bold text-ink">Pesanan Saya</h1>

    @forelse ($orders as $order)
        <a href="{{ route('orders.show', $order) }}" class="card mb-3 flex items-center justify-between p-4 transition-colors hover:border-brand">
            <div>
                <p class="font-semibold text-ink">{{ $order->order_number }}</p>
                <p class="text-sm text-ink-variant">{{ $order->store->store_name }} · {{ $order->created_at->format('d M Y') }}</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-brand">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                <p class="text-xs text-ink-variant">{{ ucfirst($order->order_status) }} · {{ ucfirst($order->payment_status) }}</p>
            </div>
        </a>
    @empty
        <div class="card p-10 text-center">
            <p class="text-ink-variant">Belum ada pesanan.</p>
            <a href="{{ route('products.index') }}" class="btn-primary mt-4 inline-flex">Mulai Belanja &rarr;</a>
        </div>
    @endforelse

    {{ $orders->links() }}
</div>
@endsection
