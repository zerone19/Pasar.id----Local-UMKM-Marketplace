@extends('layouts.admin')

@section('content')
<a href="{{ route('admin.products') }}" class="text-sm text-indigo-600 hover:underline">&larr; Products</a>
<h1 class="text-2xl font-bold text-gray-800 mt-2">{{ $product->name }}</h1>

<div class="mt-4 bg-white rounded shadow-sm p-6 space-y-2 text-sm">
    <p><strong>Toko:</strong> {{ $product->store->store_name ?? '-' }}</p>
    <p><strong>Kategori:</strong> {{ $product->category->name ?? '-' }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
    <p><strong>Stok:</strong> {{ $product->stock }}</p>
    <p><strong>Status:</strong> {{ ucfirst($product->status) }}</p>
    <p><strong>Deskripsi:</strong> {{ $product->description ?? '-' }}</p>
</div>
@endsection
