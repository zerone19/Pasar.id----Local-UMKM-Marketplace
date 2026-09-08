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
                <h1 class="text-2xl font-headline font-bold text-primary mb-2">Daftar Akun Baru</h1>
                <p class="text-sm font-body text-on-surface-variant">Lengkapi data diri Anda untuk mulai berbelanja.</p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-label font-semibold text-on-surface mb-1.5" for="name">Nama Lengkap</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">person</span>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                            class="block w-full pl-10 pr-3 py-3 border border-outline-variant rounded-lg bg-surface focus:ring-primary focus:border-primary sm:text-sm transition-colors text-on-surface placeholder:text-outline-variant"
                            placeholder="Nama lengkap">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div>
                    <label class="block text-sm font-label font-semibold text-on-surface mb-1.5" for="email">Alamat Email</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">mail</span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            class="block w-full pl-10 pr-3 py-3 border border-outline-variant rounded-lg bg-surface focus:ring-primary focus:border-primary sm:text-sm transition-colors text-on-surface placeholder:text-outline-variant"
                            placeholder="email@contoh.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-label font-semibold text-on-surface mb-1.5" for="password">Kata Sandi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">lock</span>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                class="block w-full pl-10 pr-3 py-3 border border-outline-variant rounded-lg bg-surface focus:ring-primary focus:border-primary sm:text-sm transition-colors text-on-surface"
                                placeholder="Minimal 8 karakter">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div>
                        <label class="block text-sm font-label font-semibold text-on-surface mb-1.5" for="password_confirmation">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">lock</span>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                class="block w-full pl-10 pr-3 py-3 border border-outline-variant rounded-lg bg-surface focus:ring-primary focus:border-primary sm:text-sm transition-colors text-on-surface"
                                placeholder="Ulangi kata sandi">
                        </div>
                    </div>
                </div>

                <div class="flex items-start gap-2 pt-1">
                    <input id="terms" type="checkbox" name="terms" required
                        class="mt-0.5 h-4 w-4 text-primary focus:ring-primary border-outline-variant rounded">
                    <label class="text-sm text-on-surface-variant" for="terms">
                        Saya menyetujui <a href="#" class="text-primary hover:underline font-bold">Syarat & Ketentuan</a>
                        serta <a href="#" class="text-primary hover:underline font-bold">Kebijikan Privasi</a> Pasar.ID.
                    </label>
                </div>

                <button type="submit"
                    class="w-full py-3 px-4 border border-transparent rounded-full shadow-sm text-sm font-label font-bold text-on-primary bg-primary hover:bg-primary-container focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all">
                    Daftar Sekarang
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
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-label font-bold text-primary hover:underline">Masuk di sini</a>
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