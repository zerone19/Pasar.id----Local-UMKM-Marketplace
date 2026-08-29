<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Pesanan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('seller.orders') }}" class="text-sm text-indigo-600 hover:underline">&larr; Kembali</a>

            <div class="mt-4 bg-white rounded shadow-sm p-6 space-y-4">
                <div class="flex justify-between border-b pb-3">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $order->order_number }}</p>
                        <p class="text-sm text-gray-500">Pembeli: {{ $order->buyer->name }}</p>
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

                @if ($order->order_status === 'pending')
                    <form method="POST" action="{{ route('seller.orders.status', $order) }}">
                        @csrf @method('patch')
                        <input type="hidden" name="order_status" value="confirmed">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">Konfirmasi Pesanan</button>
                    </form>
                @elseif ($order->order_status === 'confirmed')
                    <form method="POST" action="{{ route('seller.orders.status', $order) }}">
                        @csrf @method('patch')
                        <input type="hidden" name="order_status" value="processing">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">Proses Pesanan</button>
                    </form>
                @elseif ($order->order_status === 'processing')
                    <form method="POST" action="{{ route('seller.orders.status', $order) }}">
                        @csrf @method('patch')
                        <input type="hidden" name="order_status" value="shipped">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">Kirim / Siap Diambil</button>
                    </form>
                @elseif ($order->order_status === 'shipped')
                    <form method="POST" action="{{ route('seller.orders.status', $order) }}">
                        @csrf @method('patch')
                        <input type="hidden" name="order_status" value="completed">
                        <button class="px-4 py-2 bg-green-600 text-white rounded text-sm">Selesaikan Pesanan</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
