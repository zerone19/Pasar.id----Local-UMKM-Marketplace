<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesanan Masuk</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <p class="mb-4 text-sm text-green-600">{{ session('success') }}</p>
            @endif

            <div class="bg-white rounded shadow-sm divide-y">
                @forelse ($orders as $order)
                    <a href="{{ route('seller.orders.show', $order) }}" class="block p-4 hover:bg-gray-50">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-800">{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-500">{{ $order->buyer->name }} · {{ $order->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="text-right text-sm">
                                <p class="font-semibold text-indigo-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                <p class="text-gray-500">{{ ucfirst($order->order_status) }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="p-4 text-gray-500 text-sm">Belum ada pesanan.</p>
                @endforelse
            </div>

            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
