<x-seller-layout :title="'Toko Belum Dibuat'">
    <div class="max-w-3xl mx-auto">
        <div class="card p-8 text-center">
            <div class="mx-auto mb-4 grid h-14 w-14 place-items-center rounded-full bg-leaf-container text-brand">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-7 w-7"><path d="M3 9l1-4h16l1 4M4 9v11h16V9M9 20v-6h6v6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <p class="text-ink mb-4">Anda belum memiliki toko. Buat toko untuk mulai menjual produk.</p>
            <a href="{{ route('seller.store.edit') }}" class="btn-primary">Buat Toko</a>
        </div>
    </div>
</x-seller-layout>
