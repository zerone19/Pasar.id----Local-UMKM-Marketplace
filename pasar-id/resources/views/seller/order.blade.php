<x-seller-layout :title="'Detail Pesanan'">
    <div class="max-w-3xl mx-auto space-y-6">
        <a href="{{ route('seller.orders') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-brand hover:underline">&larr; Kembali</a>

        <div class="card p-6 space-y-4">
            <div class="flex flex-wrap justify-between gap-3 border-b border-outline-variant pb-3">
                <div>
                    <p class="font-semibold text-ink">{{ $order->order_number }}</p>
                    <p class="text-sm text-ink-variant">Pembeli: {{ $order->buyer->name ?? '—' }}</p>
                </div>
                <div class="text-right text-sm">
                    <p class="font-semibold text-ink">{{ ucfirst($order->order_status) }}</p>
                    <p class="text-ink-variant">{{ strtoupper($order->payment_method ?? '—') }} · {{ ucfirst($order->payment_status) }}</p>
                </div>
            </div>

            <div class="divide-y divide-outline-variant/40">
                @foreach ($order->items as $item)
                    <div class="flex justify-between py-2 text-sm">
                        <span class="text-ink">{{ $item->product->name ?? 'Produk' }} x {{ $item->quantity }}</span>
                        <span class="text-ink-variant">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between pt-3 border-t border-outline-variant font-semibold">
                <span class="text-ink">Total</span>
                <span class="text-brand">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>

            <div class="text-sm text-ink-variant">
                <p><strong class="text-ink">Alamat:</strong> {{ $order->address }}</p>
                <p><strong class="text-ink">Telepon:</strong> {{ $order->phone }}</p>
            </div>

            @if ($order->order_status === 'pending')
                <form method="POST" action="{{ route('seller.orders.status', $order) }}">
                    @csrf @method('patch')
                    <input type="hidden" name="order_status" value="confirmed">
                    <button class="btn-primary">Konfirmasi Pesanan</button>
                </form>
            @elseif ($order->order_status === 'confirmed')
                <form method="POST" action="{{ route('seller.orders.status', $order) }}">
                    @csrf @method('patch')
                    <input type="hidden" name="order_status" value="processing">
                    <button class="btn-primary">Proses Pesanan</button>
                </form>
            @elseif ($order->order_status === 'processing')
                <form method="POST" action="{{ route('seller.orders.status', $order) }}">
                    @csrf @method('patch')
                    <input type="hidden" name="order_status" value="shipped">
                    <button class="btn-primary">Kirim / Siap Diambil</button>
                </form>
            @elseif ($order->order_status === 'shipped')
                <form method="POST" action="{{ route('seller.orders.status', $order) }}">
                    @csrf @method('patch')
                    <input type="hidden" name="order_status" value="completed">
                    <button class="btn-primary">Selesaikan Pesanan</button>
                </form>
            @endif
        </div>
    </div>
</x-seller-layout>
