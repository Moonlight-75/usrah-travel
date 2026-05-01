@extends('layouts.admin')

@section('title', 'Contacts')

@section('content')
@if (session('success'))
<div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
    {{ session('success') }}
</div>
@endif

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Contact Messages</h1>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-200" x-data="{ search: '{{ request('search') }}', timeout: null }">
        <form method="GET" action="{{ route('admin.contacts.index') }}" id="search-form">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" :value="search" @input="search = $event.target.value; clearTimeout(timeout); timeout = setTimeout(() => document.getElementById('search-form').submit(), 300)" placeholder="Search contacts..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">All Statuses</option>
                <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Replied</option>
                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">Search</button>
            @if (request('search') || request('status'))
            <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 text-gray-500 text-sm hover:text-gray-700">Clear</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Subject</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Message</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Received</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($contacts as $contact)
                <tr class="hover:bg-gray-50 even:bg-gray-50/50 {{ $contact->status === 'new' ? 'bg-blue-50/50' : '' }}">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $contact->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $contact->email }}</td>
                    <td class="px-4 py-3">
                        @php $subjectColors = ['general' => 'bg-gray-100 text-gray-700', 'booking' => 'bg-blue-100 text-blue-700', 'package' => 'bg-emerald-100 text-emerald-700', 'complaint' => 'bg-red-100 text-red-700', 'other' => 'bg-purple-100 text-purple-700']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subjectColors[$contact->subject] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($contact->subject) }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 max-w-[200px] truncate">{{ Str::limit($contact->message, 50) }}</td>
                    <td class="px-4 py-3">
                        @php $contactStatusColors = ['new' => 'bg-blue-100 text-blue-700', 'read' => 'bg-gray-100 text-gray-700', 'replied' => 'bg-emerald-100 text-emerald-700', 'closed' => 'bg-gray-100 text-gray-500']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $contactStatusColors[$contact->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($contact->status) }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $contact->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.contacts.show', $contact) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg inline-flex items-center gap-1 text-xs font-medium">
                            View
                            @if ($contact->status === 'new')
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                            @endif
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-gray-500">No contacts found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-4 py-3 border-t border-gray-200">
        {{ $contacts->links() }}
    </div>
</div>
@endsection
