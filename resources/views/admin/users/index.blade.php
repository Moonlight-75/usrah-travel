@extends('layouts.admin')

@section('title', 'Users')

@section('content')
@if (session('success'))
<div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Users</h1>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-200" x-data="{ search: '{{ request('search') }}', timeout: null }">
        <form method="GET" action="{{ route('admin.users.index') }}" id="search-form">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" :value="search" @input="search = $event.target.value; clearTimeout(timeout); timeout = setTimeout(() => document.getElementById('search-form').submit(), 300)" placeholder="Search users..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">Search</button>
            @if (request('search'))
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-gray-500 text-sm hover:text-gray-700">Clear</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-500 uppercase">Active</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Phone</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Created</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($users as $user)
                <tr class="hover:bg-gray-50 even:bg-gray-50/50">
                    <td class="px-4 py-3 font-medium text-gray-900">
                        {{ $user->name }}
                        @if (auth()->id() === $user->id)
                        <span class="text-xs text-gray-400">(you)</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        @php $roleColors = ['admin' => 'bg-red-100 text-red-700', 'staff' => 'bg-blue-100 text-blue-700', 'customer' => 'bg-gray-100 text-gray-700']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $user->phone ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('admin.users.edit', $user) }}" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            @if (auth()->id() !== $user->id)
                            <div x-data="{ show: false }">
                                <button @click="show = !show" type="button" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                <div x-show="show" x-cloak class="fixed inset-0 z-40 flex items-center justify-center bg-black/30">
                                    <div class="bg-white rounded-xl p-6 mx-4 max-w-sm w-full shadow-xl">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete User</h3>
                                        <p class="text-sm text-gray-600 mb-4">Are you sure you want to delete "{{ $user->name }}"? This action cannot be undone.</p>
                                        <div class="flex justify-end gap-2">
                                            <button @click="show = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</button>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-gray-500">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-4 py-3 border-t border-gray-200">
        {{ $users->links() }}
    </div>
</div>
@endsection
