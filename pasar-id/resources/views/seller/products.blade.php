<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Produk Saya</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <p class="mb-4 text-sm text-green-600">{{ session('success') }}</p>
            @endif

            <div class="flex justify-end mb-4">
                @if ($store && $store->status === 'active')
                    <a href="{{ route('seller.products.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">+ Produk Baru</a>
                @else
                    <span class="text-sm text-gray-500">Toko harus aktif untuk menambah produk.</span>
                @endif
            </div>

            <div class="bg-white rounded shadow-sm divide-y">
                @forelse ($products as $product)
                    <div class="flex items-center justify-between p-4">
                        <div>
                            <p class="font-medium text-gray-800">{{ $product->name }}</p>
                            <p class="text-sm text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }} · stok {{ $product->stock }} · {{ ucfirst($product->status) }}</p>
                        </div>
                        <div class="flex gap-3 text-sm">
                            <a href="{{ route('seller.products.edit', $product) }}" class="text-indigo-600">Edit</a>
                            <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk?')">
                                @csrf @method('delete')
                                <button class="text-red-500">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-4 text-gray-500 text-sm">Belum ada produk.</p>
                @endforelse
            </div>

            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
