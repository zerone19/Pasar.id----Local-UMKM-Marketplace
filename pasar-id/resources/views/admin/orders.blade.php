@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Orders</h1>

<div class="bg-white rounded shadow-sm divide-y">
    @forelse ($orders as $order)
        <a href="{{ route('admin.orders.show', $order) }}" class="flex justify-between items-center p-4 hover:bg-gray-50">
            <div>
                <p class="font-medium text-gray-800">{{ $order->order_number }}</p>
                <p class="text-sm text-gray-500">{{ $order->buyer->name }} → {{ $order->store->store_name }}</p>
            </div>
            <div class="text-right text-sm">
                <p class="font-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                <p class="text-gray-500">{{ ucfirst($order->order_status) }} · {{ ucfirst($order->payment_status) }}</p>
            </div>
        </a>
    @empty
        <p class="p-4 text-gray-500 text-sm">Belum ada order.</p>
    @endforelse
</div>

{{ $orders->links() }}
@endsection
