@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Kategori</h1>

<form method="POST" action="{{ route('admin.categories.update', $category) }}" class="bg-white p-6 rounded shadow-sm space-y-4 max-w-lg">
    @csrf @method('patch')
    <div>
        <label class="block text-sm font-medium">Nama</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="mt-1 w-full rounded border-gray-300">
    </div>
    <div>
        <label class="block text-sm font-medium">Deskripsi</label>
        <textarea name="description" rows="3" class="mt-1 w-full rounded border-gray-300">{{ old('description', $category->description) }}</textarea>
    </div>
    <button class="px-6 py-2 bg-indigo-600 text-white rounded">Perbarui</button>
</form>
@endsection
