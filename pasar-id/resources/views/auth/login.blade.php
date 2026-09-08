<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Pasar.ID') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Work+Sans:wght@500;600&family=Material+Symbols+Outlined:wght,FILL@0,100..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
        }
        .font-label {
            font-family: 'Work Sans', sans-serif;
        }
        .pattern-overlay {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23154212' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="font-sans text-ink antialiased bg-surface">

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

</body>
</html>