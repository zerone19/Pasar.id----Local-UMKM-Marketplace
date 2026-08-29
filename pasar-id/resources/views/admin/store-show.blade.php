@extends('layouts.admin')

@section('content')
<a href="{{ route('admin.sellers') }}" class="text-sm text-indigo-600 hover:underline">&larr; Sellers</a>
<h1 class="text-2xl font-bold text-gray-800 mt-2">{{ $store->store_name }}</h1>

<div class="mt-4 bg-white rounded shadow-sm p-6 space-y-2 text-sm">
    <p><strong>Pemilik:</strong> {{ $store->user->name }} ({{ $store->user->email }})</p>
    <p><strong>Status:</strong> {{ ucfirst($store->status) }}</p>
    <p><strong>Kota:</strong> {{ $store->city ?? '-' }}</p>
    <p><strong>Provinsi:</strong> {{ $store->province ?? '-' }}</p>
    <p><strong>Alamat:</strong> {{ $store->address ?? '-' }}</p>
    <p><strong>Deskripsi:</strong> {{ $store->description ?? '-' }}</p>
    <p><strong>Total produk:</strong> {{ $store->products->count() }}</p>
</div>

<h2 class="text-lg font-semibold mt-6 mb-2">Produk</h2>
<div class="bg-white rounded shadow-sm divide-y">
    @forelse ($store->products as $product)
        <div class="flex justify-between p-3 text-sm">
            <span>{{ $product->name }}</span>
            <span class="text-gray-500">{{ ucfirst($product->status) }}</span>
        </div>
    @empty
        <p class="p-3 text-gray-500 text-sm">Belum ada produk.</p>
    @endforelse
</div>
@endsection
