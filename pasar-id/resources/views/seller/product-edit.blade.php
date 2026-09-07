<x-seller-layout :title="'Edit Produk'">
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-brand tracking-tight">Edit Produk</h1>
            <p class="text-sm text-ink-variant">Perbarui detail produk.</p>
        </div>

        <form method="POST" action="{{ route('seller.products.update', $product) }}" enctype="multipart/form-data" class="card p-6 space-y-4">
            @csrf @method('patch')
            <div>
                <label class="label">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="input-field">
            </div>
            <div>
                <label class="label">Kategori</label>
                <select name="category_id" class="input-field">
                    <option value="">— Tanpa kategori —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label">Deskripsi</label>
                <textarea name="description" rows="3" class="input-field">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label class="label">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" step="100" class="input-field">
                </div>
                <div>
                    <label class="label">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="input-field">
                </div>
                <div>
                    <label class="label">Berat (kg)</label>
                    <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" min="0" step="0.1" class="input-field">
                </div>
            </div>
            <div>
                <label class="label">Thumbnail Saat Ini</label>
                @if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail))
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="Thumbnail" class="w-24 h-24 object-cover rounded border">
                @else
                    <span class="text-sm text-ink-variant italic">Belum ada thumbnail</span>
                @endif
            </div>
            <div>
                <label class="label">Ganti Thumbnail</label>
                <input type="file" name="thumbnail" accept="image/*" class="input-field file:input-file file:btn-outline">
                <p class="text-xs text-ink-variant mt-1">Format: JPG, PNG, WEBP — maksimal 2MB</p>
            </div>
            <div>
                <label class="label">Foto Tambahan</label>
                <input type="file" name="images[]" accept="image/*" multiple class="input-field file:input-file file:btn-outline">
                <p class="text-xs text-ink-variant mt-1">Pilih foto baru untuk menambah galeri</p>
            </div>
            <div>
                <label class="label">Status</label>
                <select name="status" class="input-field">
                    @foreach (['draft', 'active', 'inactive', 'out_of_stock'] as $s)
                        <option value="{{ $s }}" {{ old('status', $product->status) === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn-primary w-full">Perbarui</button>
        </form>
    </div>
</x-seller-layout>
