<x-seller-layout :title="'Overview'">
    <div class="max-w-7xl mx-auto space-y-8">
        {{-- Header --}}
        <div class="flex flex-col gap-1 border-b border-outline-variant pb-5">
            <h1 class="text-2xl font-bold text-brand tracking-tight">Overview</h1>
            <p class="text-sm text-ink-variant">Ringkasan performa toko Anda.</p>
        </div>

        {{-- Stat cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card p-5 flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <span class="grid h-9 w-9 place-items-center rounded-lg bg-leaf-container text-brand">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" class="h-5 w-5"><path d="M4 7h16M4 7l1-3h14l1 3M6 7v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M10 11h4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                </div>
                <p class="text-xs font-semibold uppercase tracking-wide text-ink-variant">Total Produk</p>
                <p class="text-2xl font-bold text-brand">{{ $totalProducts }}</p>
            </div>

            <div class="card p-5 flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <span class="grid h-9 w-9 place-items-center rounded-lg bg-leaf-container text-brand">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" class="h-5 w-5"><path d="M20 7 12 3 4 7v10l8 4 8-4V7Z" stroke-linejoin="round"/><path d="M4 7l8 4 8-4M12 11v10" stroke-linecap="round"/></svg>
                    </span>
                </div>
                <p class="text-xs font-semibold uppercase tracking-wide text-ink-variant">Produk Aktif</p>
                <p class="text-2xl font-bold text-brand">{{ $activeProducts }}</p>
            </div>

            <div class="card p-5 flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <span class="grid h-9 w-9 place-items-center rounded-lg bg-leaf-container text-brand">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" class="h-5 w-5"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4M3 6h18M16 10a4 4 0 0 1-8 0" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    @if ($pendingOrders > 0)
                        <span class="rounded-full bg-error-container px-2 py-0.5 text-xs font-semibold text-error-onContainer">{{ $pendingOrders }} baru</span>
                    @endif
                </div>
                <p class="text-xs font-semibold uppercase tracking-wide text-ink-variant">Pesanan</p>
                <p class="text-2xl font-bold text-brand">{{ $totalOrders }}</p>
            </div>

            <div class="card p-5 flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <span class="grid h-9 w-9 place-items-center rounded-lg bg-leaf-container text-brand">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" class="h-5 w-5"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                </div>
                <p class="text-xs font-semibold uppercase tracking-wide text-ink-variant">Pendapatan</p>
                <p class="text-2xl font-bold text-brand">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('seller.products') }}" class="btn-primary">Kelola Produk</a>
            <a href="{{ route('seller.orders') }}" class="btn-outline">Pesanan ({{ $pendingOrders }})</a>
            <a href="{{ route('seller.store.edit') }}" class="btn-outline">Profil Toko</a>
        </div>

        {{-- Recent orders --}}
        <div class="card overflow-hidden">
            <div class="flex items-center justify-between border-b border-outline-variant px-5 py-4">
                <h2 class="font-bold text-brand">Pesanan Terbaru</h2>
                <a href="{{ route('seller.orders') }}" class="text-sm font-semibold text-brand hover:underline">Lihat Semua</a>
            </div>
            @forelse ($recentOrders as $order)
                <a href="{{ route('seller.orders.show', $order) }}" class="flex items-center justify-between px-5 py-3 hover:bg-surface-mid border-b border-outline-variant/40 last:border-0">
                    <div class="min-w-0">
                        <p class="font-medium text-ink truncate">{{ $order->order_number }} — {{ $order->buyer->name ?? 'Pembeli' }}</p>
                        <p class="text-sm text-ink-variant">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <span class="chip shrink-0">{{ ucfirst($order->order_status) }}</span>
                </a>
            @empty
                <p class="px-5 py-6 text-sm text-ink-variant">Belum ada pesanan.</p>
            @endforelse
        </div>
    </div>
</x-seller-layout>
