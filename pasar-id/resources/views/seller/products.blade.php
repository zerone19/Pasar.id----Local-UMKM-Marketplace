<x-seller-layout :title="'Produk'">
    <div class="max-w-7xl mx-auto space-y-8">
        {{-- Header --}}
        <div class="flex flex-col gap-1 border-b border-outline-variant pb-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-brand tracking-tight">Produk</h1>
                <p class="text-sm text-ink-variant">Kelola semua produk di toko Anda.</p>
            </div>
            @if ($store && $store->status === 'active')
                <a href="{{ route('seller.products.create') }}" class="btn-primary">+ Produk Baru</a>
            @else
                <span class="text-sm text-ink-variant">Toko harus aktif untuk menambah produk.</span>
            @endif
        </div>

        {{-- Stat strip --}}
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
            <div class="card p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-ink-variant">Total Produk</p>
                <p class="text-xl font-bold text-brand">{{ $products->total() }}</p>
            </div>
            <div class="card p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-ink-variant">Aktif</p>
                <p class="text-xl font-bold text-brand">{{ $products->where('status', 'active')->count() }}</p>
            </div>
            <div class="card p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-ink-variant">Habis</p>
                <p class="text-xl font-bold text-brand">{{ $products->where('stock', 0)->count() }}</p>
            </div>
        </div>

        {{-- Table --}}
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-surface-mid text-xs uppercase tracking-wide text-ink-variant">
                        <tr>
                            <th class="px-5 py-3 font-semibold">Produk</th>
                            <th class="px-5 py-3 font-semibold">Harga</th>
                            <th class="px-5 py-3 font-semibold">Stok</th>
                            <th class="px-5 py-3 font-semibold">Status</th>
                            <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/40">
                        @forelse ($products as $product)
                            <tr class="hover:bg-surface-mid">
                                <td class="px-5 py-3">
                                    <p class="font-medium text-ink">{{ $product->name }}</p>
                                    @if ($product->category)
                                        <p class="text-xs text-ink-variant">{{ $product->category->name }}</p>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-ink">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-5 py-3 text-ink">{{ $product->stock }}</td>
                                <td class="px-5 py-3">
                                    @php
                                        $badge = match($product->status) {
                                            'active' => 'bg-leaf-container text-brand',
                                            'out_of_stock' => 'bg-error-container text-error-onContainer',
                                            'inactive' => 'bg-surface-container-high text-ink-variant',
                                            default => 'bg-error-container text-error-onContainer',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $badge }}">{{ ucfirst(str_replace('_', ' ', $product->status)) }}</span>
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('seller.products.edit', $product) }}" class="font-medium text-brand hover:underline">Edit</a>
                                        <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf @method('delete')
                                            <button class="font-medium text-error-onContainer hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-ink-variant">Belum ada produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4 border-t border-outline-variant">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-seller-layout>
