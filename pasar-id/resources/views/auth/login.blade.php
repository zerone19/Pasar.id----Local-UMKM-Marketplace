<x-guest-layout>
<div class="min-h-screen bg-surface flex flex-col items-center justify-center p-4 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="fixed inset-0 pattern-overlay pointer-events-none z-0"></div>

    <!-- Full-screen Card Container -->
    <div class="relative z-10 w-full max-w-[420px] mx-auto">
        <!-- Card -->
        <div class="bg-surface-container-lowest rounded-[28px] shadow-[0_8px_32px_rgba(45,90,39,0.12)] border border-outline-variant/20 p-8">

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-headline font-bold text-primary mb-2">Masuk ke Pasar.ID</h1>
                <p class="text-sm font-body text-on-surface-variant">Selamat datang kembali! Silakan masukkan detail Anda.</p>
            </div>

            <!-- Toggle Email / Nomor HP -->
            <div class="flex mb-6 bg-surface-container-high rounded-full p-1">
                <button type="button"
                    class="flex-1 py-2 px-4 text-sm font-label font-bold text-on-primary bg-primary rounded-full transition-all">
                    Email
                </button>
                <button type="button"
                    class="flex-1 py-2 px-4 text-sm font-label font-semibold text-on-surface-variant hover:text-primary transition-colors rounded-full">
                    Nomor HP
                </button>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-label font-semibold text-on-surface mb-1.5" for="email">Alamat Email</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">mail</span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="block w-full pl-10 pr-3 py-3 border border-outline-variant rounded-lg bg-surface focus:ring-primary focus:border-primary sm:text-sm transition-colors text-on-surface placeholder:text-outline-variant"
                            placeholder="email@contoh.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-sm font-label font-semibold text-on-surface" for="password">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-label text-primary hover:underline">Lupa sandi?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">lock</span>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="block w-full pl-10 pr-3 py-3 border border-outline-variant rounded-lg bg-surface focus:ring-primary focus:border-primary sm:text-sm transition-colors text-on-surface"
                            placeholder="••••••••">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div class="flex items-center gap-2">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="h-4 w-4 text-primary focus:ring-primary border-outline-variant rounded">
                    <label class="text-sm font-label text-on-surface-variant" for="remember_me">Ingat saya</label>
                </div>

                <button type="submit"
                    class="w-full py-3 px-4 border border-transparent rounded-full shadow-sm text-sm font-label font-bold text-on-primary bg-primary hover:bg-primary-container focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all">
                    Masuk
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-outline-variant border-dashed"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-3 bg-surface-container-lowest text-on-surface-variant font-label">Atau lanjutkan dengan</span>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="button"
                        class="w-full flex justify-center items-center py-2.5 px-4 border border-outline-variant rounded-full bg-surface-container-lowest text-sm font-label font-semibold text-on-surface hover:bg-surface-container transition-colors">
                        <span class="material-symbols-outlined mr-2 text-[20px]">account_circle</span>
                        Google
                    </button>
                </div>
            </div>

            <!-- Links -->
            <div class="text-center space-y-3 text-sm font-body">
                <p class="text-on-surface-variant">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-label font-bold text-primary hover:underline">Daftar sekarang</a>
                </p>
                <p>
                    <a href="{{ route('mitra.create') }}" class="font-label font-bold text-primary hover:underline">Daftar sebagai Mitra UMKM</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <p class="mt-6 text-center text-xs text-outline font-body">
            © 2026 Pasar.ID — Nurturing Indonesian MSMEs
        </p>
    </div>
</div>
</x-guest-layout>