<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 40px; }
        .container { max-width: 800px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 3px solid #059669; }
        .company h1 { font-size: 24px; color: #059669; margin: 0 0 4px 0; }
        .company p { margin: 0; color: #666; font-size: 11px; line-height: 1.5; }
        .invoice-badge { text-align: right; }
        .invoice-badge h2 { font-size: 28px; color: #111827; margin: 0 0 4px 0; }
        .invoice-badge p { margin: 0; color: #666; font-size: 11px; }
        .info-grid { display: flex; gap: 40px; margin-bottom: 30px; }
        .info-block { flex: 1; }
        .info-block h3 { font-size: 10px; text-transform: uppercase; color: #9ca3af; margin: 0 0 8px 0; letter-spacing: 0.5px; }
        .info-block p { margin: 0 0 2px 0; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table thead { background: #f3f4f6; }
        table th { padding: 10px 12px; text-align: left; font-size: 10px; text-transform: uppercase; color: #6b7280; letter-spacing: 0.5px; border-bottom: 2px solid #e5e7eb; }
        table td { padding: 10px 12px; border-bottom: 1px solid #f3f4f6; }
        .text-right { text-align: right; }
        .totals { margin-left: auto; width: 250px; }
        .totals .row { display: flex; justify-content: space-between; padding: 6px 0; }
        .totals .row.total { border-top: 2px solid #111827; padding-top: 10px; margin-top: 6px; font-weight: bold; font-size: 14px; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #e5e7eb; text-align: center; color: #9ca3af; font-size: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="company">
                <h1>Usrah Travel & Tours</h1>
                <p>Jalan Utama, Bandar Baru Bangi<br>Selangor, Malaysia<br>Tel: +603-XXXX XXXX<br>Email: info@usrahtravel.com</p>
            </div>
            <div class="invoice-badge">
                <h2>INVOICE</h2>
                <p>{{ $invoice->invoice_no }}</p>
                <p>{{ $invoice->issue_date?->format('d M Y') }}</p>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-block">
                <h3>Bill To</h3>
                <p><strong>{{ $invoice->booking?->customer?->user?->name ?? 'N/A' }}</strong></p>
                <p>{{ $invoice->booking?->customer?->address ?? '' }}</p>
                <p>{{ $invoice->booking?->customer?->city ?? '' }}, {{ $invoice->booking?->customer?->postcode ?? '' }}</p>
                <p>{{ $invoice->booking?->customer?->state ?? '' }}, {{ $invoice->booking?->customer?->country ?? '' }}</p>
            </div>
            <div class="info-block">
                <h3>Booking Details</h3>
                <p>Booking: <strong>{{ $invoice->booking?->booking_ref ?? 'N/A' }}</strong></p>
                <p>Package: {{ $invoice->booking?->package?->name ?? 'N/A' }}</p>
                <p>Travel: {{ $invoice->booking?->travel_date?->format('d M Y') }} — {{ $invoice->booking?->return_date?->format('d M Y') }}</p>
                <p>Pax: {{ $invoice->booking?->pax_adults ?? 0 }} Adults</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $invoice->booking?->package?->name ?? 'Package' }}</td>
                    <td class="text-right">{{ $invoice->booking?->pax_adults ?? 1 }}</td>
                    <td class="text-right">RM{{ number_format($invoice->subtotal / max(1, $invoice->booking?->pax_adults ?? 1), 2) }}</td>
                    <td class="text-right">RM{{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="totals">
            <div class="row">
                <span>Subtotal</span>
                <span>RM{{ number_format($invoice->subtotal, 2) }}</span>
            </div>
            @if ($invoice->tax > 0)
            <div class="row">
                <span>Tax</span>
                <span>RM{{ number_format($invoice->tax, 2) }}</span>
            </div>
            @endif
            @if ($invoice->discount > 0)
            <div class="row">
                <span>Discount</span>
                <span>-RM{{ number_format($invoice->discount, 2) }}</span>
            </div>
            @endif
            <div class="row total">
                <span>Total</span>
                <span>RM{{ number_format($invoice->total, 2) }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for choosing Usrah Travel & Tours. This is a computer-generated invoice.</p>
            <p>Usrah Travel & Tours &mdash; Your Trusted Travel Partner</p>
        </div>
    </div>
</body>
</html>
