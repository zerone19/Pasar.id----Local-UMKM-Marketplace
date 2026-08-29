<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Seller Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded shadow-sm">
                    <p class="text-sm text-gray-500">Total Produk</p>
                    <p class="text-2xl font-bold">{{ $totalProducts }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow-sm">
                    <p class="text-sm text-gray-500">Produk Aktif</p>
                    <p class="text-2xl font-bold">{{ $activeProducts }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow-sm">
                    <p class="text-sm text-gray-500">Pesanan</p>
                    <p class="text-2xl font-bold">{{ $totalOrders }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow-sm">
                    <p class="text-sm text-gray-500">Pendapatan</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('seller.products') }}" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">Kelola Produk</a>
                <a href="{{ route('seller.store.edit') }}" class="px-4 py-2 bg-white border rounded text-sm">Profil Toko</a>
                <a href="{{ route('seller.orders') }}" class="px-4 py-2 bg-white border rounded text-sm">Pesanan ({{ $pendingOrders }})</a>
            </div>

            <div class="bg-white rounded shadow-sm p-4">
                <h3 class="font-semibold mb-3">Pesanan Terbaru</h3>
                @forelse ($recentOrders as $order)
                    <div class="flex justify-between py-2 border-b text-sm">
                        <span>{{ $order->order_number }} — {{ $order->buyer->name }}</span>
                        <span class="text-gray-500">{{ ucfirst($order->order_status) }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Belum ada pesanan.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
