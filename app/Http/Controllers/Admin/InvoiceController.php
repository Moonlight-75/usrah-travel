<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['booking.customer.user']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('invoice_no', 'like', "%{$search}%")
                  ->orWhereHas('booking', function ($q) use ($search) {
                      $q->where('booking_ref', 'like', "%{$search}%");
                  })
                  ->orWhereHas('booking.customer.user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $invoices = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['booking.customer.user', 'booking.package']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        $invoice->load(['booking.customer.user', 'booking.package']);

        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'))
            ->setPaper('A4', 'portrait');

        return $pdf->download("invoice-{$invoice->invoice_no}.pdf");
    }
}
