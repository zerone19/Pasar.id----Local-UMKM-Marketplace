<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Admin — {{ config('app.name', 'Pasar.ID') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="flex min-h-screen">
            <aside class="w-56 bg-gray-900 text-gray-300 flex flex-col">
                <div class="px-4 py-4 font-bold text-white text-lg border-b border-gray-700">Pasar.ID Admin</div>
                <nav class="flex-1 p-2 space-y-1 text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Dashboard</a>
                    <a href="{{ route('admin.users') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Users</a>
                    <a href="{{ route('admin.sellers') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Sellers</a>
                    <a href="{{ route('admin.categories') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Categories</a>
                    <a href="{{ route('admin.products') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Products</a>
                    <a href="{{ route('admin.orders') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Orders</a>
                </nav>
                <div class="p-2 border-t border-gray-700 text-sm">
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-700">← Kembali</a>
                </div>
            </aside>
            <main class="flex-1 p-8">
                @if (session('success'))
                    <p class="mb-4 text-sm text-green-600">{{ session('success') }}</p>
                @endif
                @yield('content')
            </main>
        </div>
    </body>
</html>
