@extends('layouts.portal')

@section('title', 'Documents')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Documents</h1>
    <p class="text-gray-500 mt-1">Upload and manage your travel documents.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">My Documents</h2>
            </div>

            @if($documents->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($documents as $document)
                        <div class="p-4 sm:p-6 hover:bg-gray-50 {{ $loop->even ? 'bg-gray-50/50' : '' }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg
                                        {{ $document->type === 'passport' ? 'bg-blue-100' : ($document->type === 'visa' ? 'bg-purple-100' : ($document->type === 'medical' ? 'bg-red-100' : 'bg-gray-100')) }}
                                        flex items-center justify-center">
                                        <svg class="w-5 h-5
                                            {{ $document->type === 'passport' ? 'text-blue-600' : ($document->type === 'visa' ? 'text-purple-600' : ($document->type === 'medical' ? 'text-red-600' : 'text-gray-600')) }}"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $document->file_name }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ ucfirst($document->type) }}
                                            @if($document->booking)
                                                &middot; {{ $document->booking->booking_ref }}
                                            @endif
                                            &middot; {{ $document->file_size }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 ml-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $document->status === 'approved' ? 'bg-green-100 text-green-800' : ($document->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($document->status) }}
                                    </span>
                                    @if($document->file_path)
                                        <a href="{{ route('portal.documents.download', $document->id) }}"
                                           class="text-gray-400 hover:text-emerald-600 transition-colors" title="Download">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            @if($document->status === 'rejected' && $document->rejection_reason)
                                <div class="mt-3 p-3 bg-red-50 rounded-lg">
                                    <p class="text-xs font-medium text-red-500">Rejection Reason</p>
                                    <p class="text-sm text-red-700 mt-1">{{ $document->rejection_reason }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between">
                    <p class="text-sm text-gray-500">Showing {{ $documents->firstItem() ?? 0 }}-{{ $documents->lastItem() ?? 0 }} of {{ $documents->total() }}</p>
                    {{ $documents->links() }}
                </div>
            @else
                <div class="text-center py-12 text-gray-400 text-sm">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    No documents uploaded yet.
                </div>
            @endif
        </div>
    </div>

    <div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Upload Document</h2>
            <form method="POST" action="{{ route('portal.documents.upload') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Booking</label>
                    <select name="booking_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Select booking</option>
                        @foreach($bookings as $ref => $id)
                            <option value="{{ $id }}">{{ $ref }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Document Type</label>
                    <select name="type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Select type</option>
                        <option value="passport">Passport</option>
                        <option value="visa">Visa</option>
                        <option value="medical">Medical Certificate</option>
                        <option value="insurance">Insurance</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">File</label>
                    <input type="file" name="file" required accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <p class="text-xs text-gray-400 mt-1">PDF, JPG, PNG up to 5MB</p>
                </div>

                <button type="submit" class="w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition-colors">
                    Upload Document
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
            <h3 class="text-sm font-semibold text-gray-800 mb-3">Document Guide</h3>
            <div class="space-y-2 text-xs text-gray-500">
                <div class="flex items-start gap-2">
                    <span class="inline-block w-2 h-2 bg-blue-400 rounded-full mt-1.5 flex-shrink-0"></span>
                    <p><strong class="text-gray-700">Passport</strong> — Copy of valid passport (all pages)</p>
                </div>
                <div class="flex items-start gap-2">
                    <span class="inline-block w-2 h-2 bg-purple-400 rounded-full mt-1.5 flex-shrink-0"></span>
                    <p><strong class="text-gray-700">Visa</strong> — Visa application or approval letter</p>
                </div>
                <div class="flex items-start gap-2">
                    <span class="inline-block w-2 h-2 bg-red-400 rounded-full mt-1.5 flex-shrink-0"></span>
                    <p><strong class="text-gray-700">Medical</strong> — Medical certificate or vaccination record</p>
                </div>
                <div class="flex items-start gap-2">
                    <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-1.5 flex-shrink-0"></span>
                    <p><strong class="text-gray-700">Insurance</strong> — Travel insurance policy</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
