<x-guest-layout>
<div class="bg-surface text-on-background font-body antialiased min-h-screen flex flex-col">

    <!-- TopNavBar (Transactional/Login intent) -->
    <header class="bg-surface border-b border-outline-variant w-full relative z-50">
        <div class="flex justify-between items-center w-full px-4 md:px-8 max-w-7xl mx-auto py-4">
            <div class="flex items-center gap-2">
                <img src="{{ asset('assets/img/logo-pasar-id.png') }}" alt="Pasar.ID Logo" class="h-8 w-8 object-contain" />
                <span class="text-headline-md font-bold text-primary tracking-tight">Pasar.ID</span>
                <span class="text-label-sm bg-tertiary-fixed text-on-tertiary-fixed px-2 py-0.5 rounded-full mt-1 hidden md:inline-block">Mitra</span>
            </div>

            <nav class="hidden md:flex gap-6 items-center">
                <a href="#" class="text-on-surface-variant hover:text-primary transition-colors text-label-md">Seller Academy</a>
                <a href="#" class="text-on-surface-variant hover:text-primary transition-colors text-label-md">Support</a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-label-md font-bold text-primary hover:bg-surface-container-high px-4 py-2 rounded-lg transition-colors">Masuk</a>
            </div>
        </div>
    </header>

    <!-- Main Content Area - Split Layout -->
    <main class="flex-grow flex flex-col md:flex-row w-full h-[calc(100vh-73px)]">

        <!-- Left Side: Visual / Branding -->
        <div class="hidden md:flex w-1/2 relative bg-surface-container-low overflow-hidden items-center justify-center woven-texture border-r border-outline-variant">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0 opacity-80 mix-blend-multiply"
                 style="background-image: url('{{ asset('assets/img/hero-pasar.png') }}');"></div>

            <!-- Overlay Content -->
            <div class="relative z-10 p-12 max-w-md bg-surface/90 backdrop-blur-sm rounded-xl soft-shadow border border-surface-container-highest">
                <h1 class="text-headline-xl text-primary mb-4 tracking-tight">Bergabung Bersama Kami.</h1>
                <p class="text-body-lg text-on-surface-variant mb-8">Kembangkan usaha UMKM Anda, jangkau lebih banyak pelanggan, dan jadilah bagian dari ekosistem ekonomi lokal yang berkelanjutan.</p>

                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">storefront</span>
                        <div>
                            <h3 class="font-bold text-on-surface text-body-md">Etalase Digital Modern</h3>
                            <p class="text-body-sm text-on-surface-variant">Tampilkan produk Anda dengan tampilan profesional.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">eco</span>
                        <div>
                            <h3 class="font-bold text-on-surface text-body-md">Dukungan Berkelanjutan</h3>
                            <p class="text-body-sm text-on-surface-variant">Akses ke komunitas dan akademi penjual kami.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Forms Area -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-4 md:p-12 overflow-y-auto bg-surface-bright">
            <div class="w-full max-w-md" id="auth-container">

                <!-- Toggle Tabs -->
                <div class="flex p-1 bg-surface-container-high rounded-lg mb-8 relative">
                    <div class="absolute inset-y-1 left-1 w-[calc(50%-4px)] bg-surface rounded shadow-sm transition-transform duration-300 ease-in-out" id="tab-indicator"></div>
                    <button onclick="switchTab('login')"
                        class="w-1/2 py-2 text-label-md font-bold text-primary relative z-10">Masuk</button>
                    <button onclick="switchTab('register')"
                        class="w-1/2 py-2 text-label-md text-on-surface-variant hover:text-primary relative z-10 transition-colors">Daftar</button>
                </div>

                <!-- Login Form -->
                <div class="space-y-6 block opacity-100 transition-opacity duration-300" id="login-form">
                    <div class="text-center mb-8">
                        <h2 class="text-headline-md text-on-surface mb-2 tracking-tight">Selamat Datang Kembali</h2>
                        <p class="text-body-sm text-on-surface-variant">Masuk untuk mengelola toko Anda.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-label-md text-on-surface mb-1" for="login-email">Email atau No. HP</label>
                            <input id="login-email" type="text" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors placeholder:text-outline-variant"
                                placeholder="contoh@email.com">
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <label class="block text-label-md text-on-surface" for="login-password">Kata Sandi</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-label-sm text-primary hover:underline">Lupa sandi?</a>
                                @endif
                            </div>
                            <input id="login-password" type="password" name="password" required autocomplete="current-password"
                                class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <button type="submit"
                            class="w-full bg-primary text-on-primary font-bold text-label-md py-3 rounded-lg hover:bg-primary-container hover:text-on-primary-container transition-all scale-100 active:scale-95 shadow-sm mt-4">
                            Masuk
                        </button>
                    </form>

                    <div class="relative flex items-center justify-center my-6">
                        <div class="border-t border-outline-variant w-full"></div>
                        <span class="bg-surface-bright px-3 text-label-sm text-outline absolute">ATAU</span>
                    </div>

                    <button type="button"
                        class="w-full bg-surface border border-outline-variant text-on-surface font-bold text-label-md py-3 rounded-lg hover:bg-surface-container transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">account_circle</span>
                        Masuk dengan Google
                    </button>
                </div>

                <!-- Registration Form -->
                <div class="space-y-6 hidden opacity-0 transition-opacity duration-300" id="register-form">
                    <div class="text-center mb-6">
                        <h2 class="text-headline-md text-on-surface mb-2 tracking-tight">Mulai Perjalanan Anda</h2>
                        <p class="text-body-sm text-on-surface-variant">Lengkapi data untuk membuka toko.</p>
                    </div>

                    <form method="POST" action="{{ route('mitra.store') }}" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-label-md text-on-surface mb-1" for="reg-fname">Nama Depan</label>
                                <input id="reg-fname" type="text" name="first_name" required autocomplete="name"
                                    class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                    value="{{ old('first_name') }}">
                                <x-input-error :messages="$errors->get('first_name')" class="mt-1" />
                            </div>
                            <div>
                                <label class="block text-label-md text-on-surface mb-1" for="reg-lname">Nama Belakang</label>
                                <input id="reg-lname" type="text" name="last_name" required autocomplete="family-name"
                                    class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                    value="{{ old('last_name') }}">
                                <x-input-error :messages="$errors->get('last_name')" class="mt-1" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-label-md text-on-surface mb-1" for="reg-email">Email Aktif</label>
                            <input id="reg-email" type="email" name="email" required autocomplete="username"
                                class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors placeholder:text-outline-variant"
                                placeholder="contoh@email.com"
                                value="{{ old('email') }}">
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <!-- Store Details Section -->
                        <div class="bg-surface-container-low p-4 rounded-lg border border-surface-container-highest space-y-4 mt-2">
                            <h3 class="text-label-md font-bold text-primary flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">store</span> Detail Toko
                            </h3>

                            <div>
                                <label class="block text-label-md text-on-surface mb-1" for="reg-store-name">Nama Toko</label>
                                <input id="reg-store-name" type="text" name="store_name" required
                                    class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                    placeholder="Mis: Warung Hijau Berkah"
                                    value="{{ old('store_name') }}">
                                <x-input-error :messages="$errors->get('store_name')" class="mt-1" />
                            </div>

                            <div>
                                <label class="block text-label-md text-on-surface mb-1" for="reg-category">Kategori Utama</label>
                                <select id="reg-category" name="category_id" required
                                    class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih kategori produk...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-label-md text-on-surface mb-1" for="reg-password">Kata Sandi</label>
                            <input id="reg-password" type="password" name="password" required autocomplete="new-password"
                                class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                placeholder="Minimal 8 karakter, gunakan kombinasi huruf dan angka.">
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <div class="flex items-start gap-2 mt-4">
                            <input id="terms" type="checkbox" name="terms" required
                                class="mt-1 rounded border-outline-variant text-primary focus:ring-primary cursor-pointer h-4 w-4">
                            <label class="text-body-sm text-on-surface-variant" for="terms">Saya menyetujui <a href="#" class="text-primary hover:underline font-bold">Syarat & Ketentuan</a> serta <a href="#" class="text-primary hover:underline font-bold">Kebijikan Privasi</a> Mitra Pasar.ID.</label>
                        </div>

                        <button type="submit"
                            class="w-full bg-primary text-on-primary font-bold text-label-md py-3 rounded-lg hover:bg-primary-container hover:text-on-primary-container transition-all scale-100 active:scale-95 shadow-sm mt-4">
                            Daftar Sekarang
                        </button>
                    </form>
                </div>
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

<script>
    function switchTab(tab) {
        const indicator = document.getElementById('tab-indicator');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const buttons = document.querySelectorAll('#auth-container button');

        if (tab === 'login') {
            indicator.style.transform = 'translateX(0)';
            buttons[0].classList.replace('text-on-surface-variant', 'text-primary');
            buttons[0].classList.add('font-bold');
            buttons[1].classList.replace('text-primary', 'text-on-surface-variant');
            buttons[1].classList.remove('font-bold');

            registerForm.classList.remove('opacity-100');
            registerForm.classList.add('opacity-0');

            setTimeout(() => {
                registerForm.classList.add('hidden');
                registerForm.classList.remove('block');
                loginForm.classList.remove('hidden');
                loginForm.classList.add('block');
                setTimeout(() => {
                    loginForm.classList.remove('opacity-0');
                    loginForm.classList.add('opacity-100');
                }, 10);
            }, 300);
        } else {
            indicator.style.transform = 'translateX(100%)';
            buttons[1].classList.replace('text-on-surface-variant', 'text-primary');
            buttons[1].classList.add('font-bold');
            buttons[0].classList.replace('text-primary', 'text-on-surface-variant');
            buttons[0].classList.remove('font-bold');

            loginForm.classList.remove('opacity-100');
            loginForm.classList.add('opacity-0');

            setTimeout(() => {
                loginForm.classList.add('hidden');
                loginForm.classList.remove('block');
                registerForm.classList.remove('hidden');
                registerForm.classList.add('block');
                setTimeout(() => {
                    registerForm.classList.remove('opacity-0');
                    registerForm.classList.add('opacity-100');
                }, 10);
            }, 300);
        }
    }
</script>
</x-guest-layout>