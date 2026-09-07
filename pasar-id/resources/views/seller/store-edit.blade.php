<x-seller-layout :title="'Profil Toko'">
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-brand tracking-tight">Profil Toko</h1>
            <p class="text-sm text-ink-variant">Perbarui informasi toko Anda.</p>
        </div>

        <form method="POST" action="{{ route('seller.store.update') }}" class="card p-6 space-y-4" enctype="multipart/form-data">
            @csrf

            <div>
                <label class="label">Nama Toko</label>
                <input type="text" name="store_name" value="{{ old('store_name', $store->store_name) }}" required class="input-field">
            </div>

            <div>
                <label class="label">Deskripsi</label>
                <textarea name="description" rows="3" class="input-field">{{ old('description', $store->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="label">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $store->phone) }}" class="input-field">
                </div>
                <div>
                    <label class="label">Kota</label>
                    <input type="text" name="city" value="{{ old('city', $store->city) }}" class="input-field">
                </div>
            </div>

            <div>
                <label class="label">Alamat</label>
                <input type="text" name="address" value="{{ old('address', $store->address) }}" class="input-field">
            </div>

            <div>
                <label class="label">Provinsi</label>
                <input type="text" name="province" value="{{ old('province', $store->province) }}" class="input-field">
            </div>

            <div>
                <label class="label">Logo Toko</label>
                @if ($store->logo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $store->logo) }}" alt="Logo Saat Ini" class="h-20 w-20 rounded-full object-cover border">
                    </div>
                @endif
                <input type="file" name="logo" accept="image/*" class="input-field">
                @error('logo') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label">Banner Toko</label>
                @if ($store->banner)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $store->banner) }}" alt="Banner Saat Ini" class="h-32 w-full rounded object-cover border">
                    </div>
                @endif
                <input type="file" name="banner" accept="image/*" class="input-field">
                @error('banner') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3">
                <button class="btn-primary">Simpan</button>
                @if ($store->exists)
                    <span class="text-sm text-ink-variant">Status: {{ ucfirst($store->status) }}</span>
                @endif
            </div>
        </form>
    </div>
</x-seller-layout>
