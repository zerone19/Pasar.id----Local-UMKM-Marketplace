<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Toko Saya' }} — Pasar.ID</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Work+Sans:wght@500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-surface text-ink">

<div class="flex min-h-screen">
    {{-- Sidebar (desktop) --}}
    <aside class="hidden md:flex flex-col w-64 shrink-0 fixed inset-y-0 left-0 bg-surface-container-low border-r border-outline-variant p-4 gap-2 z-50">
        <div class="mb-6 px-2 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-leaf-container bg-leaf-container grid place-items-center shrink-0">
                @if ($store && $store->logo)
                    <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->store_name }}" class="w-full h-full object-cover">
                @else
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5 text-brand"><path d="M3 9l1-4h16l1 4M4 9v11h16V9M9 20v-6h6v6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                @endif
            </div>
            <div class="min-w-0">
                <p class="text-sm font-bold text-brand leading-tight truncate">{{ $store->store_name ?? 'Toko Saya' }}</p>
                <p class="text-xs text-ink-variant">Penjual UMKM</p>
            </div>
        </div>

        <nav class="flex-1 flex flex-col gap-1 text-sm">
            <a href="{{ route('seller.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium {{ request()->routeIs('seller.dashboard') ? 'bg-leaf-container text-brand' : 'text-ink-variant hover:bg-surface-container-high' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" class="h-5 w-5"><path d="M4 13h6V4H4v9ZM14 21h6V4h-6v17ZM4 21h6v-5H4v5Z" stroke-linejoin="round"/></svg>
                Overview
            </a>
            <a href="{{ route('seller.products') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium {{ request()->routeIs('seller.products*') ? 'bg-leaf-container text-brand' : 'text-ink-variant hover:bg-surface-container-high' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" class="h-5 w-5"><path d="M4 7h16M4 7l1-3h14l1 3M6 7v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M10 11h4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Produk
            </a>
            <a href="{{ route('seller.orders') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium {{ request()->routeIs('seller.orders*') ? 'bg-leaf-container text-brand' : 'text-ink-variant hover:bg-surface-container-high' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" class="h-5 w-5"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4M3 6h18M16 10a4 4 0 0 1-8 0" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Pesanan
            </a>
            <a href="{{ route('seller.store.edit') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium {{ request()->routeIs('seller.store.*') ? 'bg-leaf-container text-brand' : 'text-ink-variant hover:bg-surface-container-high' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" class="h-5 w-5"><path d="M3 21V8l9-5 9 5v13M9 21v-6h6v6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Profil Toko
            </a>
        </nav>

        @if ($store && $store->status === 'active')
            <a href="{{ route('seller.products.create') }}" class="mt-4 w-full btn-primary justify-center">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path d="M12 5v14M5 12h14" stroke-linecap="round"/></svg>
                Produk Baru
            </a>
        @endif

        <div class="mt-6 pt-4 border-t border-outline-variant flex flex-col gap-1 text-sm">
            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-ink-variant hover:bg-surface-container-high">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" class="h-5 w-5"><path d="M3 12l9-9 9 9M5 10v10h14V10" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Lihat Toko
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-ink-variant hover:bg-surface-container-high">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" class="h-5 w-5"><path d="M15 12H4m0 0 4-4M4 12l4 4M13 4h6v16h-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Mobile top bar --}}
    <header class="md:hidden sticky top-0 z-40 bg-surface border-b border-outline-variant px-4 py-3 flex justify-between items-center">
        <p class="font-bold text-brand">{{ $store->store_name ?? 'Toko Saya' }}</p>
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="text-brand p-1" aria-label="Menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-6 w-6"><path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round"/></svg>
            </button>
            <div x-show="open" @click.outside="open = false" x-transition style="display:none;"
                 class="absolute right-0 mt-2 w-52 rounded-lg bg-surface p-2 shadow-leaf-sm ring-1 ring-ink/5">
                <a href="{{ route('seller.dashboard') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-ink hover:bg-surface-mid">Overview</a>
                <a href="{{ route('seller.products') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-ink hover:bg-surface-mid">Produk</a>
                <a href="{{ route('seller.orders') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-ink hover:bg-surface-mid">Pesanan</a>
                <a href="{{ route('seller.store.edit') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-ink hover:bg-surface-mid">Profil Toko</a>
                <a href="{{ route('products.index') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-ink hover:bg-surface-mid">Lihat Toko</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="block w-full text-left rounded-md px-3 py-2 text-sm font-medium text-error-onContainer hover:bg-surface-mid">Logout</button></form>
            </div>
        </div>
    </header>

    {{-- Main --}}
    <main class="flex-1 md:ml-64 p-4 md:p-8 min-h-screen">
        @if (session('success'))
            <div class="mb-6 rounded-md bg-leaf-container px-4 py-3 text-sm font-medium text-brand">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-6 rounded-md bg-error-container px-4 py-3 text-sm font-medium text-error-onContainer">{{ session('error') }}</div>
        @endif

        {{ $slot }}
    </main>
</div>

</body>
</html>
