<header class="sticky top-0 z-30 bg-brand text-brand-on shadow-leaf-sm">
    <div class="mx-auto max-w-content px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center gap-4">
            {{-- Logo --}}
            <a href="{{ route('products.index') }}" class="flex items-center gap-2 shrink-0">
                <img src="{{ asset('assets/img/logo-pasar-id.png') }}" alt="Pasar.ID" class="h-9 w-9 rounded-full bg-brand-soft object-contain">
                <span class="text-lg font-bold tracking-tight">Pasar.ID</span>
            </a>

            {{-- Search --}}
            <form action="{{ route('products.index') }}" method="GET" class="hidden flex-1 md:flex max-w-xl">
                <div class="relative w-full">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari produk lokal..."
                           class="w-full rounded-full border-0 bg-brand-on/95 py-2 pl-4 pr-4 text-sm text-ink shadow-sm placeholder:text-ink-variant/60 focus:ring-2 focus:ring-brand-soft">
                </div>
            </form>

            {{-- Nav --}}
            <nav class="ml-auto flex items-center gap-1 sm:gap-3 text-sm">
                <a href="{{ route('products.index') }}" class="hidden sm:inline rounded-full px-3 py-2 font-medium text-brand-on/90 hover:bg-brand-on/10">Produk</a>
                <a href="{{ route('products.index') }}#kategori" class="hidden sm:inline rounded-full px-3 py-2 font-medium text-brand-on/90 hover:bg-brand-on/10">Kategori</a>
                @auth
                    @if (auth()->user()->role === 'seller')
                        <a href="{{ route('seller.dashboard') }}" class="hidden sm:inline rounded-full px-3 py-2 font-medium text-brand-on/90 hover:bg-brand-on/10">Toko Saya</a>
                    @elseif (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline rounded-full px-3 py-2 font-medium text-brand-on/90 hover:bg-brand-on/10">Admin</a>
                    @endif
                    <a href="{{ route('cart.index') }}" class="relative rounded-full p-2 hover:bg-brand-on/10" aria-label="Keranjang">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                            <path d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13 5.4 5M7 13l-2 5h12" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        @php $cartCount = auth()->user()->cartItemsCount ?? 0; @endphp
                        @if ($cartCount > 0)
                            <span class="absolute -right-0.5 -top-0.5 grid h-5 min-w-5 place-items-center rounded-full bg-error px-1 text-[11px] font-bold text-error-on">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <div class="flex items-center gap-2 pl-1">
                        <span class="hidden text-sm font-medium text-brand-on/90 sm:inline">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="rounded-full bg-brand-soft px-3 py-1.5 text-xs font-semibold text-brand hover:brightness-105">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="rounded-full px-3 py-2 font-medium text-brand-on/90 hover:bg-brand-on/10">Login</a>
                    <a href="{{ route('register') }}" class="rounded-full bg-brand-soft px-4 py-1.5 text-sm font-semibold text-brand hover:brightness-105">Daftar</a>
                @endauth
            </nav>
        </div>
    </div>
</header>
