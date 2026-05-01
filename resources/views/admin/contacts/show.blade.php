@extends('layouts.admin')

@section('title', 'Contact Details')

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
    <a href="{{ route('admin.contacts.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Contacts</a>
</div>

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">Contact from {{ $contact->name }}</h1>
    @php $contactStatusColors = ['new' => 'bg-blue-100 text-blue-700', 'read' => 'bg-gray-100 text-gray-700', 'replied' => 'bg-emerald-100 text-emerald-700', 'closed' => 'bg-gray-100 text-gray-500']; @endphp
    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $contactStatusColors[$contact->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($contact->status) }}</span>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Contact Info</h2>
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Name</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ $contact->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $contact->email }}</dd>
                </div>
                @if ($contact->phone)
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Phone</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $contact->phone }}</dd>
                </div>
                @endif
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Subject</dt>
                    <dd class="mt-1">
                        @php $subjectColors = ['general' => 'bg-gray-100 text-gray-700', 'booking' => 'bg-blue-100 text-blue-700', 'package' => 'bg-emerald-100 text-emerald-700', 'complaint' => 'bg-red-100 text-red-700', 'other' => 'bg-purple-100 text-purple-700']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subjectColors[$contact->subject] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($contact->subject) }}</span>
                    </dd>
                </div>
                @if ($contact->package)
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Package</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $contact->package->name }}</dd>
                </div>
                @endif
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Received</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $contact->created_at->format('d M Y H:i') }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Update Status</h2>
            <div class="space-y-2">
                @if ($contact->status !== 'read' && $contact->status !== 'replied' && $contact->status !== 'closed')
                <form method="POST" action="{{ route('admin.contacts.update-status', $contact) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="read">
                    <button type="submit" class="w-full px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Mark as Read</button>
                </form>
                @endif
                @if ($contact->status !== 'replied' && $contact->status !== 'closed')
                <form method="POST" action="{{ route('admin.contacts.update-status', $contact) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="replied">
                    <button type="submit" class="w-full px-3 py-2 text-sm font-medium text-emerald-700 bg-emerald-50 rounded-lg hover:bg-emerald-100">Mark as Replied</button>
                </form>
                @endif
                @if ($contact->status !== 'closed')
                <form method="POST" action="{{ route('admin.contacts.update-status', $contact) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="closed">
                    <button type="submit" class="w-full px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Mark as Closed</button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Message</h2>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">{{ $contact->message }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
