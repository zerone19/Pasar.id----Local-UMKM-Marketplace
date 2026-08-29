@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Users</h1>

<div class="bg-white rounded shadow-sm divide-y">
    @forelse ($users as $user)
        <a href="{{ route('admin.users.show', $user) }}" class="flex justify-between items-center p-4 hover:bg-gray-50">
            <div>
                <p class="font-medium text-gray-800">{{ $user->name }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
            <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-600 uppercase">{{ $user->role }}</span>
        </a>
    @empty
        <p class="p-4 text-gray-500 text-sm">Belum ada user.</p>
    @endforelse
</div>

{{ $users->links() }}
@endsection
