@extends('layouts.admin')

@section('title', 'Customers')

@section('content')
@if (session('success'))
<div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
    {{ session('success') }}
</div>
@endif

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Customers</h1>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-200" x-data="{ search: '{{ request('search') }}', timeout: null }">
        <form method="GET" action="{{ route('admin.customers.index') }}" id="search-form">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" :value="search" @input="search = $event.target.value; clearTimeout(timeout); timeout = setTimeout(() => document.getElementById('search-form').submit(), 300)" placeholder="Search by name, email, phone..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">Search</button>
            @if (request('search'))
            <a href="{{ route('admin.customers.index') }}" class="px-4 py-2 text-gray-500 text-sm hover:text-gray-700">Clear</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Phone</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">IC/Passport</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">City</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-500 uppercase">Bookings</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($customers as $customer)
                <tr class="hover:bg-gray-50 even:bg-gray-50/50">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $customer->user?->name ?? 'N/A' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $customer->user?->email ?? 'N/A' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $customer->user?->phone ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $customer->ic_passport_no ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $customer->city ?? '-' }}</td>
                    <td class="px-4 py-3 text-center text-gray-600">{{ $customer->bookings->count() }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg" title="View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('admin.customers.edit', $customer) }}" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-gray-500">No customers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-4 py-3 border-t border-gray-200">
        {{ $customers->links() }}
    </div>
</div>
@endsection
