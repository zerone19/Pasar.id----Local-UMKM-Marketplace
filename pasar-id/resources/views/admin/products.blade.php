@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Products</h1>

<div class="bg-white rounded shadow-sm divide-y">
    @forelse ($products as $product)
        <div class="flex justify-between items-center p-4">
            <div>
                <a href="{{ route('admin.products.show', $product) }}" class="font-medium text-gray-800 hover:text-indigo-600">{{ $product->name }}</a>
                <p class="text-sm text-gray-500">{{ $product->store->store_name ?? '-' }} · Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
            <div class="flex items-center gap-2 text-sm">
                <span class="px-2 py-1 rounded text-xs uppercase bg-gray-100">{{ $product->status }}</span>
                <div class="flex gap-1">
                    @foreach (['active', 'inactive', 'draft', 'out_of_stock'] as $s)
                        <form action="{{ route('admin.products.status', [$product, $s]) }}" method="POST">
                            @csrf <button class="px-2 py-1 rounded border text-xs hover:bg-gray-50">{{ ucfirst(str_replace('_', ' ', $s)) }}</button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    @empty
        <p class="p-4 text-gray-500 text-sm">Belum ada produk.</p>
    @endforelse
</div>

{{ $products->links() }}
@endsection
