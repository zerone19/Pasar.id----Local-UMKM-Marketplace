<x-seller-layout :title="'Tambah Produk'">
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-brand tracking-tight">Tambah Produk</h1>
            <p class="text-sm text-ink-variant">Isi detail produk yang akan dijual.</p>
        </div>

        <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data" class="card p-6 space-y-4">
            @csrf
            <div>
                <label class="label">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="input-field">
            </div>
            <div>
                <label class="label">Kategori</label>
                <select name="category_id" class="input-field">
                    <option value="">— Tanpa kategori —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label">Deskripsi</label>
                <textarea name="description" rows="3" class="input-field">{{ old('description') }}</textarea>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label class="label">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0" step="100" class="input-field">
                </div>
                <div>
                    <label class="label">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0" class="input-field">
                </div>
                <div>
                    <label class="label">Berat (kg)</label>
                    <input type="number" name="weight" value="{{ old('weight') }}" min="0" step="0.1" class="input-field">
                </div>
            </div>
            <div>
                <label class="label">Foto Produk (Thumbnail)</label>
                <input type="file" name="thumbnail" accept="image/*" class="input-field file:input-file file:btn-outline">
                <p class="text-xs text-ink-variant mt-1">Format: JPG, PNG, WEBP — maksimal 2MB</p>
            </div>
            <div>
                <label class="label">Foto Tambahan</label>
                <input type="file" name="images[]" accept="image/*" multiple class="input-field file:input-file file:btn-outline">
                <p class="text-xs text-ink-variant mt-1">Bisa pilih lebih dari satu foto</p>
            </div>
            <button class="btn-primary w-full">Simpan Produk</button>
        </form>
    </div>
</x-seller-layout>
