<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Produk</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('seller.products.update', $product) }}" class="bg-white p-6 rounded shadow-sm space-y-4">
                @csrf @method('patch')
                <div>
                    <label class="block text-sm font-medium">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="mt-1 w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium">Kategori</label>
                    <select name="category_id" class="mt-1 w-full rounded border-gray-300">
                        <option value="">— Tanpa kategori —</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Deskripsi</label>
                    <textarea name="description" rows="3" class="mt-1 w-full rounded border-gray-300">{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" step="100" class="mt-1 w-full rounded border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="mt-1 w-full rounded border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Berat (kg)</label>
                        <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" min="0" step="0.1" class="mt-1 w-full rounded border-gray-300">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium">Status</label>
                    <select name="status" class="mt-1 w-full rounded border-gray-300">
                        @foreach (['draft', 'active', 'inactive', 'out_of_stock'] as $s)
                            <option value="{{ $s }}" {{ old('status', $product->status) === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="px-6 py-2 bg-indigo-600 text-white rounded">Perbarui</button>
            </form>
        </div>
    </div>
</x-app-layout>
