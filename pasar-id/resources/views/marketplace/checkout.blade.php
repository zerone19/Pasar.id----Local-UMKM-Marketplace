@extends('layouts.marketplace')

@section('title', 'Checkout — Pasar.ID')

@section('content')
<div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="mb-6 text-2xl font-bold text-ink">Checkout</h1>

    @if (session('error'))
        <p class="mb-4 rounded-md bg-error-container px-4 py-2 text-sm font-semibold text-error-onContainer">{{ session('error') }}</p>
    @endif

    <div class="card mb-6 p-6">
        <h2 class="mb-3 font-semibold text-ink">Ringkasan Pesanan</h2>
        <div class="divide-y">
            @foreach ($items as $item)
                <div class="flex justify-between py-2 text-sm">
                    <span class="text-ink">{{ $item->product->name }} x {{ $item->quantity }}</span>
                    <span class="font-semibold text-ink">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>
        <div class="flex justify-between border-t pt-3 font-bold text-ink">
            <span>Total</span>
            <span class="text-brand">Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>

    <form method="POST" action="{{ route('checkout.store') }}" class="card space-y-4 p-6">
        @csrf
        <div>
            <label class="label">Alamat Pengiriman</label>
            <textarea name="address" rows="3" required class="input-field">{{ old('address', $user->profile->address ?? '') }}</textarea>
        </div>
        <div>
            <label class="label">No. Telepon</label>
            <input type="text" name="phone" required value="{{ old('phone', $user->profile->phone ?? '') }}" class="input-field">
        </div>
        <div>
            <label class="label">Metode Pembayaran</label>
            <select name="payment_method" class="input-field">
                <option value="cod">COD (Bayar di Tempat)</option>
                <option value="transfer">Transfer Bank</option>
            </select>
        </div>
        <div>
            <label class="label">Catatan (opsional)</label>
            <textarea name="notes" rows="2" class="input-field">{{ old('notes') }}</textarea>
        </div>
        <button class="btn-primary w-full">Buat Pesanan</button>
    </form>
</div>
@endsection
