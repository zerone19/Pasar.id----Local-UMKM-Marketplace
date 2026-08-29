@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>

<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-4 rounded shadow-sm">
        <p class="text-sm text-gray-500">Users</p>
        <p class="text-2xl font-bold">{{ $totalUsers }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow-sm">
        <p class="text-sm text-gray-500">Sellers</p>
        <p class="text-2xl font-bold">{{ $totalSellers }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow-sm">
        <p class="text-sm text-gray-500">Stores</p>
        <p class="text-2xl font-bold">{{ $totalStores }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow-sm">
        <p class="text-sm text-gray-500">Pending Stores</p>
        <p class="text-2xl font-bold text-amber-600">{{ $pendingStores }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow-sm">
        <p class="text-sm text-gray-500">Products</p>
        <p class="text-2xl font-bold">{{ $totalProducts }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow-sm">
        <p class="text-sm text-gray-500">Pending Products</p>
        <p class="text-2xl font-bold text-amber-600">{{ $pendingProducts }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow-sm">
        <p class="text-sm text-gray-500">Orders</p>
        <p class="text-2xl font-bold">{{ $totalOrders }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow-sm">
        <p class="text-sm text-gray-500">Revenue</p>
        <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
    </div>
</div>
@endsection
