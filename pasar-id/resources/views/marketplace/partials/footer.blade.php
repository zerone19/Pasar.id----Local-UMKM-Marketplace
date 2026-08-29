<footer class="mt-16 border-t border-outline-variant/60 bg-surface-mid">
    <div class="mx-auto max-w-content px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col gap-8 md:flex-row md:items-start md:justify-between">
            <div class="max-w-xs">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('assets/img/logo-pasar-id.png') }}" alt="Pasar.ID" class="h-9 w-9 rounded-full bg-brand object-contain">
                    <span class="text-lg font-bold text-brand">Pasar.ID</span>
                </div>
                <p class="mt-3 text-sm text-ink-variant">Gotong Royong Memajukan UMKM Indonesia. Dari pasar ke pintu Anda.</p>
            </div>
            <nav class="grid grid-cols-2 gap-x-10 gap-y-2 text-sm text-ink-variant sm:grid-cols-3">
                <a href="#" class="hover:text-brand">Misi Komunitas</a>
                <a href="{{ route('register') }}" class="hover:text-brand">Daftar Jadi Penjual</a>
                <a href="#" class="hover:text-brand">Pusat Bantuan</a>
                <a href="#" class="hover:text-brand">Syarat & Ketentuan</a>
                <a href="{{ route('products.index') }}" class="hover:text-brand">Jelajahi Produk</a>
                <a href="#" class="hover:text-brand">Tentang Kami</a>
            </nav>
        </div>
        <p class="mt-8 border-t border-outline-variant/40 pt-4 text-xs text-ink-variant">© {{ date('Y') }} Pasar.ID — Marketplace UMKM Lokal.</p>
    </div>
</footer>
