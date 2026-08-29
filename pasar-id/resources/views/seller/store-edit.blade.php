<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profil Toko</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <p class="mb-4 text-sm text-green-600">{{ session('success') }}</p>
            @endif
            @if (session('error'))
                <p class="mb-4 text-sm text-red-600">{{ session('error') }}</p>
            @endif

            <form method="POST" action="{{ route('seller.store.update') }}" class="bg-white p-6 rounded shadow-sm space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Nama Toko</label>
                    <input type="text" name="store_name" value="{{ old('store_name', $store->store_name) }}" required
                           class="mt-1 w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium">Deskripsi</label>
                    <textarea name="description" rows="3" class="mt-1 w-full rounded border-gray-300">{{ old('description', $store->description) }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $store->phone) }}" class="mt-1 w-full rounded border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Kota</label>
                        <input type="text" name="city" value="{{ old('city', $store->city) }}" class="mt-1 w-full rounded border-gray-300">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium">Alamat</label>
                    <input type="text" name="address" value="{{ old('address', $store->address) }}" class="mt-1 w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium">Provinsi</label>
                    <input type="text" name="province" value="{{ old('province', $store->province) }}" class="mt-1 w-full rounded border-gray-300">
                </div>
                <button class="px-6 py-2 bg-indigo-600 text-white rounded">Simpan</button>
                @if ($store->exists)
                    <span class="text-sm text-gray-500">Status: {{ ucfirst($store->status) }}</span>
                @endif
            </form>
        </div>
    </div>
</x-app-layout>
