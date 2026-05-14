<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['serviceOrder.customer', 'payments'])->latest()->get();
        return view('modules.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['serviceOrder.customer', 'serviceOrder.vehicle', 'payments']);
        return view('modules.invoices.show', compact('invoice'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_order_id' => 'required|exists:service_orders,id',
        ]);

        $order = ServiceOrder::findOrFail($validated['service_order_id']);
        
        // Generate invoice number
        $number = 'FAC-' . now()->format('Y') . '-' . str_pad(Invoice::count() + 1, 4, '0', STR_PAD_LEFT);

        $invoice = Invoice::create([
            'service_order_id' => $order->id,
            'number' => $number,
            'total' => $order->total_amount,
            'status' => 'unpaid',
            'issue_date' => now(),
        ]);

        return redirect()->route('invoices.show', $invoice)->with('status', 'Factura generada con éxito.');
    }

    public function addPayment(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string',
        ]);

        Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $validated['amount'],
            'method' => $validated['method'],
            'payment_date' => now(),
        ]);

        // Update invoice status
        $totalPaid = $invoice->payments()->sum('amount');
        if ($totalPaid >= $invoice->total) {
            $invoice->update(['status' => 'paid']);
        } elseif ($totalPaid > 0) {
            $invoice->update(['status' => 'partially_paid']);
        }

        return back()->with('status', 'Pago registrado con éxito.');
    }
}
