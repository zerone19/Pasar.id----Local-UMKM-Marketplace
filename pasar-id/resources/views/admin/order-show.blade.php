@extends('layouts.admin')

@section('content')
<a href="{{ route('admin.orders') }}" class="text-sm text-indigo-600 hover:underline">&larr; Orders</a>
<h1 class="text-2xl font-bold text-gray-800 mt-2">{{ $order->order_number }}</h1>

<div class="mt-4 bg-white rounded shadow-sm p-6 space-y-4">
    <div class="flex justify-between border-b pb-3">
        <div>
            <p class="text-sm text-gray-500">Buyer: {{ $order->buyer->name }}</p>
            <p class="text-sm text-gray-500">Seller: {{ $order->store->store_name }}</p>
        </div>
        <div class="text-right text-sm">
            <p>{{ ucfirst($order->order_status) }}</p>
            <p class="text-gray-500">{{ strtoupper($order->payment_method) }} · {{ ucfirst($order->payment_status) }}</p>
        </div>
    </div>

    <div class="divide-y">
        @foreach ($order->items as $item)
            <div class="flex justify-between py-2 text-sm">
                <span>{{ $item->product->name ?? 'Produk' }} x {{ $item->quantity }}</span>
                <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
        @endforeach
    </div>

    <div class="flex justify-between pt-3 border-t font-semibold">
        <span>Total</span>
        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
    </div>

    <div class="text-sm text-gray-600">
        <p><strong>Alamat:</strong> {{ $order->address }}</p>
        <p><strong>Telepon:</strong> {{ $order->phone }}</p>
    </div>
</div>
@endsection
