@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">+ Kategori</a>
</div>

<div class="bg-white rounded shadow-sm divide-y">
    @forelse ($categories as $category)
        <div class="flex justify-between items-center p-4">
            <div>
                <p class="font-medium text-gray-800">{{ $category->name }}</p>
                <p class="text-sm text-gray-500">{{ $category->products_count }} produk</p>
            </div>
            <div class="flex gap-3 text-sm">
                <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600">Edit</a>
                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori?')">
                    @csrf @method('delete')
                    <button class="text-red-500">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <p class="p-4 text-gray-500 text-sm">Belum ada kategori.</p>
    @endforelse
</div>

{{ $categories->links() }}
@endsection
