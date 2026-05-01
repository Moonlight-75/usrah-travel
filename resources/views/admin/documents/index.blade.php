@extends('layouts.admin')

@section('title', 'Documents')

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
    <h1 class="text-2xl font-bold text-gray-900">Documents</h1>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-200" x-data="{ search: '{{ request('search') }}', timeout: null }">
        <form method="GET" action="{{ route('admin.documents.index') }}" id="search-form">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" :value="search" @input="search = $event.target.value; clearTimeout(timeout); timeout = setTimeout(() => document.getElementById('search-form').submit(), 300)" placeholder="Search documents..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <select name="type" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">All Types</option>
                @foreach (['passport','visa','insurance','vaccination','photo','ic','other'] as $t)
                <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">Search</button>
            @if (request('search') || request('status') || request('type'))
            <a href="{{ route('admin.documents.index') }}" class="px-4 py-2 text-gray-500 text-sm hover:text-gray-700">Clear</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Booking Ref</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">File</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Size</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Uploaded</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($documents as $document)
                <tr class="hover:bg-gray-50 even:bg-gray-50/50">
                    <td class="px-4 py-3 text-gray-900">{{ $document->customer?->user?->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $document->booking?->booking_ref ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @php $docTypeColors = ['passport' => 'bg-blue-100 text-blue-700', 'visa' => 'bg-emerald-100 text-emerald-700', 'insurance' => 'bg-amber-100 text-amber-700', 'vaccination' => 'bg-cyan-100 text-cyan-700', 'photo' => 'bg-purple-100 text-purple-700', 'ic' => 'bg-indigo-100 text-indigo-700', 'other' => 'bg-gray-100 text-gray-700']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $docTypeColors[$document->type] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($document->type) }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 max-w-[200px] truncate">{{ $document->file_name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $document->file_size ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @php $docStatusColors = ['pending' => 'bg-yellow-100 text-yellow-700', 'approved' => 'bg-emerald-100 text-emerald-700', 'rejected' => 'bg-red-100 text-red-700']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $docStatusColors[$document->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($document->status) }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $document->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1">
                            @if ($document->status === 'pending')
                            <form method="POST" action="{{ route('admin.documents.approve', $document) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-2.5 py-1 text-xs font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg">Approve</button>
                            </form>
                            <div x-data="{ show: false }">
                                <button @click="show = !show" type="button" class="px-2.5 py-1 text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded-lg">Reject</button>
                                <div x-show="show" x-cloak class="fixed inset-0 z-40 flex items-center justify-center bg-black/30">
                                    <div class="bg-white rounded-xl p-6 mx-4 max-w-md w-full shadow-xl">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Reject Document</h3>
                                        <form method="POST" action="{{ route('admin.documents.reject', $document) }}">
                                            @csrf @method('PATCH')
                                            <textarea name="rejection_reason" rows="3" required placeholder="Enter rejection reason..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm mb-3 focus:ring-2 focus:ring-red-500 focus:border-red-500"></textarea>
                                            <div class="flex justify-end gap-2">
                                                <button @click="show = false" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</button>
                                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @elseif ($document->status === 'rejected' && $document->rejection_reason)
                            <span class="text-xs text-red-600" title="{{ $document->rejection_reason }}">{{ Str::limit($document->rejection_reason, 30) }}</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-12 text-center text-gray-500">No documents found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-4 py-3 border-t border-gray-200">
        {{ $documents->links() }}
    </div>
</div>
@endsection
