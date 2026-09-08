<x-guest-layout>
<div class="min-h-screen bg-surface flex flex-col items-center justify-center p-4 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="fixed inset-0 pattern-overlay pointer-events-none z-0"></div>

    <!-- Full-screen Card Container -->
    <div class="relative z-10 w-full max-w-[480px] mx-auto">
        <!-- Card -->
        <div class="bg-surface-container-lowest rounded-[28px] shadow-[0_8px_32px_rgba(45,90,39,0.12)] border border-outline-variant/20 p-8">

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-headline font-bold text-primary mb-2">Daftar sebagai Mitra UMKM</h1>
                <p class="text-sm font-body text-on-surface-variant">Lengkapi data untuk membuka toko Anda.</p>
            </div>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('mitra.store') }}" class="space-y-5">
                @csrf

                <!-- Nama Lengkap -->
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

                <!-- Email -->
                <div>
                    <label class="block text-sm font-label font-semibold text-on-surface mb-1.5" for="email">Email Aktif</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">mail</span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            class="block w-full pl-10 pr-3 py-3 border border-outline-variant rounded-lg bg-surface focus:ring-primary focus:border-primary sm:text-sm transition-colors text-on-surface placeholder:text-outline-variant"
                            placeholder="contoh@email.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Store Details Section -->
                <div class="bg-surface-container-low p-4 rounded-lg border border-surface-container-highest space-y-4">
                    <h3 class="text-label-md font-bold text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">store</span> Detail Toko
                    </h3>

                    <div>
                        <label class="block text-sm font-label font-semibold text-on-surface mb-1.5" for="store_name">Nama Toko</label>
                        <input id="store_name" type="text" name="store_name" required
                            class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors placeholder:text-outline-variant"
                            placeholder="Mis: Warung Hijau Berkah"
                            value="{{ old('store_name') }}">
                        <x-input-error :messages="$errors->get('store_name')" class="mt-1" />
                    </div>

                    <div>
                        <label class="block text-sm font-label font-semibold text-on-surface mb-1.5" for="category_id">Kategori Utama</label>
                        <select id="category_id" name="category_id" required
                            class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors appearance-none cursor-pointer">
                            <option value="" disabled selected>Pilih kategori produk...</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
                    </div>
                </div>

                <!-- Password Fields -->
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

                <!-- Terms Checkbox -->
                <div class="flex items-start gap-2 pt-1">
                    <input id="terms" type="checkbox" name="terms" required
                        class="mt-0.5 h-4 w-4 text-primary focus:ring-primary border-outline-variant rounded">
                    <label class="text-sm text-on-surface-variant" for="terms">
                        Saya menyetujui <a href="#" class="text-primary hover:underline font-bold">Syarat & Ketentuan</a>
                        serta <a href="#" class="text-primary hover:underline font-bold">Kebijikan Privasi</a> Mitra Pasar.ID.
                    </label>
                </div>

                <!-- Submit Button -->
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
                        <svg class="mr-2 w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 7.917-11.303 7.917-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"></path>
                            <path fill="#FF3D00" d="M6.306 14.691l6.571 4.811C14.576 15.09 18.98 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 18.27 4 13.44 6.69 10.539 11.056l-.233.367z"></path>
                            <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.197-5.238C29.011 35.691 26.641 37 24 37c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.019C9.984 38.584 16.556 44 24 44z"></path>
                            <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303c-.794 2.237-2.147 4.163-3.961 5.572.001-.003 6.886 5.218 6.886 5.218C36.051 40.083 40 36 40 31c0-1.341-.138-2.65-.389-3.917z"></path>
                        </svg>
                        Google
                    </button>
                </div>
            </div>

            <!-- Links -->
            <div class="text-center text-sm font-body">
                <p class="text-on-surface-variant">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-label font-bold text-primary hover:underline">Masuk di sini</a>
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