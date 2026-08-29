@extends('layouts.admin')

@section('content')
<a href="{{ route('admin.users') }}" class="text-sm text-indigo-600 hover:underline">&larr; Users</a>
<h1 class="text-2xl font-bold text-gray-800 mt-2">{{ $user->name }}</h1>

<div class="mt-4 bg-white rounded shadow-sm p-6 space-y-2 text-sm">
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
    <p><strong>Verified:</strong> {{ $user->email_verified_at ? 'Ya' : 'Tidak' }}</p>
    @if ($user->profile)
        <p><strong>Phone:</strong> {{ $user->profile->phone ?? '-' }}</p>
        <p><strong>Bio:</strong> {{ $user->profile->bio ?? '-' }}</p>
    @endif
    <p><strong>Stores:</strong> {{ $user->stores->count() }}</p>
</div>
@endsection
