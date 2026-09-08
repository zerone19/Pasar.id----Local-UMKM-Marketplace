<x-guest-layout>
<div class="bg-surface text-on-surface flex flex-col min-h-screen font-body">
    <!-- Main Content Area - Split Layout -->
    <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
        <!-- Pattern overlay -->
        <div class="absolute inset-0 pattern-overlay pointer-events-none z-0"></div>

        <div class="max-w-5xl w-full flex flex-col md:flex-row bg-surface-container-lowest rounded-xl shadow-[0_4px_24px_rgba(45,90,39,0.08)] border border-outline-variant/30 overflow-hidden z-10">
            
            <!-- Illustration Side -->
            <div class="hidden md:block w-1/2 bg-surface-container relative">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('assets/img/hero-pasar.png') }}');"></div>
                <div class="absolute inset-0 bg-primary/20 backdrop-blur-[2px]"></div>
                <div class="absolute bottom-12 left-12 right-12 text-surface-container-lowest">
                    <h2 class="text-3xl font-bold font-headline mb-4 tracking-tight">Gotong Royong Modern.</h2>
                    <p class="text-lg font-body leading-relaxed text-surface-container-lowest/90">Bergabung dengan komunitas Pasar.ID. Temukan produk lokal autentik dari ribuan UMKM terpercaya di seluruh Indonesia.</p>
                </div>
            </div>

            <!-- Form Side -->
            <div class="w-full md:w-1/2 p-8 sm:p-12">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-primary font-headline tracking-tight mb-2">Masuk ke Pasar.ID</h1>
                    <p class="text-on-surface-variant font-body text-sm">Selamat datang kembali! Silakan masukkan detail Anda.</p>
                </div>

                <!-- Toggle Email / Nomor HP -->
                <div class="mb-8">
                    <div class="flex border-b border-outline-variant">
                        <button type="button" class="w-1/2 py-3 text-center font-label font-bold text-primary border-b-2 border-primary transition-colors">Email</button>
                        <button type="button" class="w-1/2 py-3 text-center font-label font-semibold text-on-surface-variant hover:text-primary transition-colors">Nomor HP</button>
                    </div>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-label font-semibold text-on-surface mb-2" for="email">Alamat Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">mail</span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                class="block w-full pl-10 pr-3 py-3 border border-outline-variant rounded bg-surface focus:ring-primary focus:border-primary sm:text-sm transition-colors text-on-surface"
                                placeholder="email@contoh.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-sm font-label font-semibold text-on-surface" for="password">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-label-sm text-primary hover:underline">Lupa sandi?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">lock</span>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="block w-full pl-10 pr-3 py-3 border border-outline-variant rounded bg-surface focus:ring-primary focus:border-primary sm:text-sm transition-colors text-on-surface"
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="h-4 w-4 text-primary focus:ring-primary border-outline-variant rounded">
                            <label class="ml-2 block text-sm font-label text-on-surface-variant" for="remember_me">Ingat saya</label>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-label font-bold text-on-primary bg-primary hover:bg-primary-container focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary scale-95 hover:scale-[0.98] transition-all">
                            Masuk
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="my-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-outline-variant border-dashed"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-surface-container-lowest text-on-surface-variant font-label">Atau lanjutkan dengan</span>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="button"
                            class="w-full flex justify-center items-center py-3 px-4 border border-outline-variant rounded-lg bg-surface-container-lowest text-sm font-label font-semibold text-on-surface hover:bg-surface-container-low transition-colors">
                            <span class="material-symbols-outlined mr-2">account_circle</span>
                            Google
                        </button>
                    </div>
                </div>

                <!-- Link to Register / Mitra -->
                <p class="mt-8 text-center text-sm font-body text-on-surface-variant">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-label font-bold text-primary hover:underline decoration-primary">Daftar sekarang</a>
                </p>
                <p class="mt-4 text-center text-sm font-body text-on-surface-variant">
                    <a href="{{ route('mitra.create') }}" class="font-label font-bold text-primary hover:underline decoration-primary">Daftar sebagai Mitra UMKM</a>
                </p>
            </div>
        </div>
    </main>

    <!-- Footer (Minimal for Auth Pages) -->
    <footer class="bg-surface-container border-t border-outline-variant py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-label-sm text-outline">© 2026 Pasar.ID — Nurturing Indonesian MSMEs</p>
        </div>
    </footer>
</div>
</x-guest-layout>