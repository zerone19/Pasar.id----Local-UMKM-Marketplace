@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Sellers / Stores</h1>

<div class="bg-white rounded shadow-sm divide-y">
    @forelse ($stores as $store)
        <div class="flex justify-between items-center p-4">
            <div>
                <a href="{{ route('admin.sellers.show', $store) }}" class="font-medium text-gray-800 hover:text-indigo-600">{{ $store->store_name }}</a>
                <p class="text-sm text-gray-500">{{ $store->user->name }} · {{ $store->city ?? '-' }}</p>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <span class="px-2 py-1 rounded text-xs uppercase
                    @if($store->status === 'active') bg-green-100 text-green-700
                    @elseif($store->status === 'pending') bg-amber-100 text-amber-700
                    @else bg-red-100 text-red-700 @endif">{{ $store->status }}</span>
                <form action="{{ route('admin.sellers.approve', $store) }}" method="POST">
                    @csrf <button class="text-green-600">Approve</button>
                </form>
                <form action="{{ route('admin.sellers.reject', $store) }}" method="POST">
                    @csrf <button class="text-red-500">Reject</button>
                </form>
                <form action="{{ route('admin.sellers.suspend', $store) }}" method="POST">
                    @csrf <button class="text-gray-500">Suspend</button>
                </form>
            </div>
        </div>
    @empty
        <p class="p-4 text-gray-500 text-sm">Belum ada toko.</p>
    @endforelse
</div>

{{ $stores->links() }}
@endsection
