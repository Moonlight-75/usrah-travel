<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Portal\PortalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\ContactController as PublicContactController;
use App\Http\Controllers\Public\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, '__invoke'])->name('home');

Route::get('/packages', [PageController::class, 'packages'])->name('public.packages');
Route::get('/packages/{slug}', [PageController::class, 'packageDetail'])->name('public.packages.show');
Route::get('/about', fn () => view('public.about'))->name('public.about');
Route::get('/gallery', fn () => view('public.gallery'))->name('public.gallery');
Route::get('/contact', fn () => view('public.contact'))->name('public.contact');
Route::post('/contact', [PublicContactController::class, 'store'])->middleware('throttle:5,1')->name('public.contact.store');

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'customer') {
        return redirect()->route('portal.dashboard');
    }

    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:customer'])->prefix('portal')->name('portal.')->group(function () {
    Route::get('/', [PortalController::class, 'dashboard'])->name('dashboard');

    Route::get('/bookings', [PortalController::class, 'bookings'])->name('bookings.index');
    Route::get('/bookings/{id}', [PortalController::class, 'bookingDetail'])->name('bookings.show');
    Route::post('/bookings/{id}/cancel', [PortalController::class, 'cancelBooking'])->name('bookings.cancel');

    Route::get('/documents', [PortalController::class, 'documents'])->name('documents.index');
    Route::post('/documents', [PortalController::class, 'uploadDocument'])->name('documents.upload');
    Route::get('/documents/{id}/download', [PortalController::class, 'downloadDocument'])->name('documents.download');

    Route::get('/payments', [PortalController::class, 'payments'])->name('payments.index');

    Route::get('/profile', [PortalController::class, 'profile'])->name('profile');
    Route::patch('/profile', [PortalController::class, 'updateProfile'])->name('profile.update');
});

Route::middleware(['auth', 'verified', 'role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('packages/create', [PackageController::class, 'create'])->name('packages.create')->middleware('role:admin');
    Route::post('packages', [PackageController::class, 'store'])->name('packages.store')->middleware('role:admin');
    Route::resource('packages', PackageController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit')->middleware('role:admin');
    Route::put('packages/{package}', [PackageController::class, 'update'])->name('packages.update')->middleware('role:admin');
    Route::delete('packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy')->middleware('role:admin');
    Route::patch('packages/{package}/toggle-active', [PackageController::class, 'toggleActive'])->name('packages.toggle-active')->middleware('role:admin');
    Route::patch('packages/{package}/toggle-featured', [PackageController::class, 'toggleFeatured'])->name('packages.toggle-featured')->middleware('role:admin');

    Route::resource('customers', CustomerController::class)->only(['index', 'show', 'edit', 'update']);

    Route::get('bookings/create', [BookingController::class, 'create'])->name('bookings.create')->middleware('role:admin');
    Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store')->middleware('role:admin');
    Route::resource('bookings', BookingController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit')->middleware('role:admin');
    Route::put('bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update')->middleware('role:admin');
    Route::delete('bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy')->middleware('role:admin');
    Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');

    Route::get('payments/create', [PaymentController::class, 'create'])->name('payments.create')->middleware('role:admin');
    Route::post('payments', [PaymentController::class, 'store'])->name('payments.store')->middleware('role:admin');
    Route::resource('payments', PaymentController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::patch('payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify')->middleware('role:admin');

    Route::resource('invoices', InvoiceController::class)->only(['index', 'show']);
    Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');

    Route::get('vendors/create', [VendorController::class, 'create'])->name('vendors.create')->middleware('role:admin');
    Route::post('vendors', [VendorController::class, 'store'])->name('vendors.store')->middleware('role:admin');
    Route::resource('vendors', VendorController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('vendors/{vendor}/edit', [VendorController::class, 'edit'])->name('vendors.edit')->middleware('role:admin');
    Route::put('vendors/{vendor}', [VendorController::class, 'update'])->name('vendors.update')->middleware('role:admin');
    Route::delete('vendors/{vendor}', [VendorController::class, 'destroy'])->name('vendors.destroy')->middleware('role:admin');
    Route::patch('vendors/{vendor}/toggle-active', [VendorController::class, 'toggleActive'])->name('vendors.toggle-active')->middleware('role:admin');

    Route::resource('documents', DocumentController::class)->only(['index']);
    Route::patch('documents/{document}/approve', [DocumentController::class, 'approve'])->name('documents.approve')->middleware('role:admin');
    Route::patch('documents/{document}/reject', [DocumentController::class, 'reject'])->name('documents.reject')->middleware('role:admin');

    Route::resource('contacts', ContactController::class)->only(['index', 'show']);
    Route::patch('contacts/{contact}/status', [ContactController::class, 'updateStatus'])->name('contacts.update-status')->middleware('role:admin');

    Route::get('/tours', TourController::class)->name('tours.index');
    Route::get('/reports', ReportController::class)->name('reports');

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    });
});

require __DIR__.'/auth.php';
