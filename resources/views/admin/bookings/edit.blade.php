@extends('layouts.admin')

@section('title', 'Edit Booking')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.bookings.show', $booking) }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Booking</a>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Edit Booking {{ $booking->booking_ref }}</h1>
</div>

@if ($errors->any())
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif

<div class="bg-white rounded-xl shadow-sm p-6">
    <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Booking Details</h2>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Package <span class="text-red-500">*</span></label>
                <select name="package_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @foreach ($packages as $package)
                    <option value="{{ $package->id }}" {{ old('package_id', $booking->package_id) == $package->id ? 'selected' : '' }}>{{ $package->name }} — RM{{ number_format($package->discount_price ?? $package->price, 2) }}</option>
                    @endforeach
                </select>
                @error('package_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @foreach (['inquiry','confirmed','deposit_paid','fully_paid','visa_processing','visa_approved','visa_rejected','departed','completed','cancelled','refunded'] as $s)
                    <option value="{{ $s }}" {{ old('status', $booking->status) === $s ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($s)) }}</option>
                    @endforeach
                </select>
                @error('status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Travel Date <span class="text-red-500">*</span></label>
                <input type="date" name="travel_date" value="{{ old('travel_date', $booking->travel_date?->format('Y-m-d')) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                @error('travel_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Return Date <span class="text-red-500">*</span></label>
                <input type="date" name="return_date" value="{{ old('return_date', $booking->return_date?->format('Y-m-d')) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                @error('return_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Adults <span class="text-red-500">*</span></label>
                <input type="number" name="pax_adults" value="{{ old('pax_adults', $booking->pax_adults) }}" min="1" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                @error('pax_adults') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Children</label>
                <input type="number" name="pax_children" value="{{ old('pax_children', $booking->pax_children) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                @error('pax_children') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Infants</label>
                <input type="number" name="pax_infants" value="{{ old('pax_infants', $booking->pax_infants) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                @error('pax_infants') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Room Preference</label>
                <input type="text" name="room_preference" value="{{ old('room_preference', $booking->room_preference) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                @error('room_preference') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Special Requests</label>
                <textarea name="special_requests" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('special_requests', is_array($booking->special_requests) ? ($booking->special_requests['notes'] ?? '') : $booking->special_requests) }}</textarea>
                @error('special_requests') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2 border-t border-gray-200 pt-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Admin Notes</h2>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Admin Notes</label>
                <textarea name="admin_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                @error('admin_notes') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cancellation Reason</label>
                <input type="text" name="cancelled_reason" value="{{ old('cancelled_reason', $booking->cancelled_reason) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                @error('cancelled_reason') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin.bookings.show', $booking) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</a>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700">Update Booking</button>
        </div>
    </form>
</div>
@endsection
