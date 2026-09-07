<x-guest-layout>
    <div class="flex min-h-screen flex-col md:flex-row">
        {{-- Left: branding --}}
        <div class="relative hidden w-1/2 flex-col justify-between overflow-hidden bg-brand p-12 text-brand-on md:flex">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-container/60 to-transparent"></div>
            <div class="relative z-10 flex items-center gap-2">
                <img src="{{ asset('assets/img/logo-pasar-id.png') }}" alt="Pasar.ID" class="h-10 w-10 rounded-full bg-brand-soft object-contain">
                <span class="text-xl font-bold tracking-tight">Pasar.ID</span>
            </div>
            <div class="relative z-10">
                <h1 class="text-3xl font-bold leading-tight tracking-tight sm:text-4xl">Gotong Royong<br>Memajukan UMKM<br>Indonesia</h1>
                <p class="mt-4 max-w-sm text-brand-on/90">Bergabunglah dengan ribuan pembeli lainnya yang mendukung produk lokal asli Indonesia.</p>
            </div>
            <p class="relative z-10 text-xs text-brand-on/60">© 2026 Pasar.ID — Nurturing Indonesian MSMEs</p>
        </div>

        {{-- Right: form --}}
        <div class="flex w-full items-center justify-center px-4 py-10 md:w-1/2 md:p-12">
            <div class="w-full max-w-md">
                <div class="mb-8 text-center md:text-left">
                    <h2 class="text-2xl font-bold text-brand tracking-tight sm:text-3xl">Masuk ke Pasar.ID</h2>
                    <p class="mt-1 text-sm text-ink-variant">Selamat datang kembali! Silakan masukkan detail Anda.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="label">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="input-field">
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label class="label">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-brand hover:underline">Lupa sandi?</a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="input-field">
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <label class="flex items-center gap-2 text-sm text-ink-variant">
                        <input type="checkbox" name="remember" class="rounded border-outline-variant text-brand focus:ring-brand">
                        Ingat saya
                    </label>

                    <button class="btn-primary w-full justify-center">Masuk</button>
                </form>

                <div class="my-6 flex items-center">
                    <div class="h-px flex-1 bg-outline-variant"></div>
                    <span class="px-3 text-xs text-ink-variant">atau</span>
                    <div class="h-px flex-1 bg-outline-variant"></div>
                </div>

                <div class="flex flex-col gap-3 text-sm">
                    <a href="{{ route('mitra.create') }}" class="btn-outline w-full justify-center">Daftar sebagai Mitra UMKM</a>
                    <p class="text-center text-ink-variant">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-semibold text-brand hover:underline">Daftar pembeli</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
