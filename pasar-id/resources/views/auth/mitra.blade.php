<x-guest-layout>
    <div class="flex min-h-screen flex-col md:flex-row">
        {{-- Left: branding --}}
        <div class="relative hidden w-1/2 flex-col justify-between overflow-hidden bg-brand p-12 text-brand-on md:flex">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-container/60 to-transparent"></div>
            <div class="relative z-10 flex items-center gap-2">
                <img src="{{ asset('assets/img/logo-pasar-id.png') }}" alt="Pasar.ID" class="h-10 w-10 rounded-full bg-brand-soft object-contain">
                <span class="text-xl font-bold tracking-tight">Pasar.ID</span>
                <span class="ml-2 rounded-full bg-brand-soft px-2 py-0.5 text-xs font-semibold text-brand">Mitra</span>
            </div>
            <div class="relative z-10">
                <h1 class="text-3xl font-bold leading-tight tracking-tight sm:text-4xl">Bergabung Bersama Kami.</h1>
                <p class="mt-4 max-w-md text-brand-on/85">Kembangkan usaha UMKM Anda, jangkau lebih banyak pelanggan, dan jadilah bagian dari ekosistem ekonomi lokal yang berkelanjutan.</p>
                <div class="mt-8 space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-brand-soft text-brand">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5"><path d="M3 9l1-4h16l1 4M4 9v11h16V9M9 20v-6h6v6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                        <div>
                            <p class="font-semibold">Etalase Digital Modern</p>
                            <p class="text-sm text-brand-on/75">Tampilkan produk Anda dengan tampilan profesional.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-brand-soft text-brand">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5"><path d="M12 3c3 3 3 6 0 9-3-3-3-6 0-9ZM12 12c3 3 3 6 0 9-3-3-3-6 0-9Z" stroke-linejoin="round"/></svg>
                        </span>
                        <div>
                            <p class="font-semibold">Dukungan Berkelanjutan</p>
                            <p class="text-sm text-brand-on/75">Akses ke komunitas dan akademi penjual kami.</p>
                        </div>
                    </div>
                </div>
            </div>
            <p class="relative z-10 text-xs text-brand-on/60">© 2026 Pasar.ID — Nurturing Indonesian MSMEs</p>
        </div>

        {{-- Right: form --}}
        <div class="flex w-full items-center justify-center bg-surface px-4 py-10 md:w-1/2 md:p-12">
            <div class="w-full max-w-md">
                <div class="mb-8 text-center md:text-left">
                    <h2 class="text-2xl font-bold text-brand tracking-tight sm:text-3xl">Daftar sebagai Mitra</h2>
                    <p class="mt-1 text-sm text-ink-variant">Lengkapi data untuk membuka toko Anda.</p>
                </div>

                <form method="POST" action="{{ route('mitra.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="label">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name" class="input-field">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <label class="label">Email Aktif</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="input-field">
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="rounded-lg border border-outline-variant bg-surface-container-low p-4 space-y-4">
                        <p class="flex items-center gap-2 text-sm font-semibold text-brand">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-4 w-4"><path d="M3 9l1-4h16l1 4M4 9v11h16V9M9 20v-6h6v6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Detail Toko
                        </p>
                        <div>
                            <label class="label">Nama Toko</label>
                            <input type="text" name="store_name" value="{{ old('store_name') }}" placeholder="Mis: Warung Hijau Berkah" required class="input-field">
                            <x-input-error :messages="$errors->get('store_name')" class="mt-1" />
                        </div>
                        <div>
                            <label class="label">Kategori Utama</label>
                            <select name="category_id" class="input-field">
                                <option value="">Pilih kategori produk...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="label">Kata Sandi</label>
                            <input type="password" name="password" required autocomplete="new-password" class="input-field">
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>
                        <div>
                            <label class="label">Konfirmasi</label>
                            <input type="password" name="password_confirmation" required autocomplete="new-password" class="input-field">
                        </div>
                    </div>

                    <button class="btn-primary w-full justify-center">Daftar Sekarang</button>
                </form>

                <p class="mt-6 text-center text-sm text-ink-variant">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-semibold text-brand hover:underline">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
