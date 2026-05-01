@extends('layouts.admin')

@section('title', 'Create Payment')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.payments.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Payments</a>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Create Payment</h1>
</div>

@if ($errors->any())
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif

<div class="bg-white rounded-xl shadow-sm p-6">
    <form method="POST" action="{{ route('admin.payments.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Booking <span class="text-red-500">*</span></label>
                <select name="booking_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Select booking</option>
                    @foreach ($bookings as $booking)
                    <option value="{{ $booking->id }}" {{ old('booking_id') == $booking->id ? 'selected' : '' }}>{{ $booking->booking_ref }} — {{ $booking->customer?->user?->name }} ({{ $booking->package?->name }})</option>
                    @endforeach
                </select>
                @error('booking_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                <select name="type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Select type</option>
                    <option value="deposit" {{ old('type') === 'deposit' ? 'selected' : '' }}>Deposit</option>
                    <option value="installment" {{ old('type') === 'installment' ? 'selected' : '' }}>Installment</option>
                    <option value="full" {{ old('type') === 'full' ? 'selected' : '' }}>Full Payment</option>
                    <option value="refund" {{ old('type') === 'refund' ? 'selected' : '' }}>Refund</option>
                </select>
                @error('type') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Amount (RM) <span class="text-red-500">*</span></label>
                <input type="number" name="amount" value="{{ old('amount') }}" min="0" step="0.01" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                @error('amount') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Method <span class="text-red-500">*</span></label>
                <select name="method" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Select method</option>
                    <option value="bank_transfer" {{ old('method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="cash" {{ old('method') === 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="online" {{ old('method') === 'online' ? 'selected' : '' }}>Online</option>
                    <option value="credit_card" {{ old('method') === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                </select>
                @error('method') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                <input type="date" name="due_date" value="{{ old('due_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                @error('due_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <input type="text" name="notes" value="{{ old('notes') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                @error('notes') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</a>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700">Create Payment</button>
        </div>
    </form>
</div>
@endsection
