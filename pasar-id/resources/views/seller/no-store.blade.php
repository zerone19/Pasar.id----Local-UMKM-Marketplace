<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Toko Belum Dibuat</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <p class="text-gray-600 mb-4">Anda belum memiliki toko. Buat toko untuk mulai menjual produk.</p>
                <a href="{{ route('seller.store.edit') }}" class="px-6 py-2 bg-indigo-600 text-white rounded">Buat Toko</a>
            </div>
        </div>
    </div>
</x-app-layout>
