<x-seller-layout :title="'Riwayat Transaksi'">
    <div class="max-w-7xl mx-auto space-y-6">
        {{-- Header + filters --}}
        <div class="flex flex-col gap-4 border-b border-outline-variant pb-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-brand tracking-tight">Riwayat Transaksi</h1>
                <p class="text-sm text-ink-variant">Kelola dan pantau semua pesanan masuk Anda.</p>
            </div>
            <form method="GET" action="{{ route('seller.orders') }}" class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-variant"><circle cx="11" cy="11" r="7"/><path d="m21 21-4-4" stroke-linecap="round"/></svg>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari no. pesanan / pembeli"
                           class="input-field w-full pl-9 sm:w-56">
                </div>
                <select name="status" onchange="this.form.submit()" class="input-field w-full sm:w-auto">
                    <option value="all" {{ ($status ?? 'all') === 'all' ? 'selected' : '' }}>Semua Status</option>
                    @foreach ($statuses as $s)
                        <option value="{{ $s }}" {{ ($status ?? '') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Table --}}
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-surface-mid text-xs uppercase tracking-wide text-ink-variant">
                        <tr>
                            <th class="px-5 py-3 font-semibold">No. Pesanan</th>
                            <th class="px-5 py-3 font-semibold">Tanggal</th>
                            <th class="px-5 py-3 font-semibold">Pembeli</th>
                            <th class="px-5 py-3 font-semibold text-right">Total</th>
                            <th class="px-5 py-3 font-semibold text-center">Status</th>
                            <th class="px-5 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/40">
                        @forelse ($orders as $order)
                            @php
                                $badge = match($order->order_status) {
                                    'completed' => 'bg-leaf-container text-brand',
                                    'shipped' => 'bg-burlap-container text-burlap-onContainer',
                                    'pending' => 'bg-error-container text-error-onContainer',
                                    'cancelled' => 'bg-surface-container-high text-ink-variant',
                                    default => 'bg-surface-container-high text-ink-variant',
                                };
                            @endphp
                            <tr class="hover:bg-surface-mid">
                                <td class="px-5 py-3 font-semibold text-brand">#{{ $order->order_number }}</td>
                                <td class="px-5 py-3 text-ink-variant">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-leaf-container text-xs font-bold text-brand">
                                            {{ strtoupper(substr($order->buyer->name ?? 'P', 0, 2)) }}
                                        </span>
                                        <span class="text-ink">{{ $order->buyer->name ?? 'Pembeli' }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-right font-semibold text-ink">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-5 py-3 text-center">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $badge }}">{{ ucfirst($order->order_status) }}</span>
                                </td>
                                <td class="px-5 py-3 text-center">
                                    <a href="{{ route('seller.orders.show', $order) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-full text-brand hover:bg-surface-container" title="Lihat Detail">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-ink-variant">Belum ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4 border-t border-outline-variant">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-seller-layout>
