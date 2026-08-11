<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\ServiceOrder;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['serviceOrder.customer', 'payments'])->latest()->get();
        $bcvRate = CurrencyService::getBcvRate();
        return view('modules.invoices.index', compact('invoices', 'bcvRate'));
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
        
        // Generate invoice number using max ID (never reused, safe after deletions)
        $number = 'FAC-' . now()->format('Y') . '-' . str_pad((Invoice::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        $invoice = Invoice::create([
            'service_order_id' => $order->id,
            'number' => $number,
            'total' => $order->total_amount,
            'status' => 'unpaid',
            'issue_date' => now(),
        ]);

        return redirect()->route('invoices.show', $invoice)->with('status', 'Factura generada con éxito.');
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load(['serviceOrder.customer', 'serviceOrder.vehicle']);
        return view('modules.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:unpaid,partially_paid,paid',
            'issue_date' => 'required|date',
        ], [
            'total.required' => 'El total es obligatorio.',
            'total.numeric' => 'El total debe ser un valor numérico.',
            'total.min' => 'El total mínimo es 0.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',
            'issue_date.required' => 'La fecha de emisión es obligatoria.',
            'issue_date.date' => 'La fecha de emisión no es válida.',
        ]);

        $invoice->update([
            'total' => $validated['total'],
            'status' => $validated['status'],
            'issue_date' => $validated['issue_date'],
        ]);

        return redirect()->route('invoices.show', $invoice)->with('status', 'Factura actualizada con éxito.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->payments()->delete();
        $invoice->delete();
        return redirect()->route('invoices.index')->with('status', 'Factura eliminada con éxito.');
    }

    public function addPayment(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ], [
            'amount.required' => 'El monto es obligatorio.',
            'amount.numeric' => 'El monto debe ser un valor numérico.',
            'amount.min' => 'El monto mínimo es 0.01.',
            'method.required' => 'El método de pago es obligatorio.',
            'reference.max' => 'La referencia no puede exceder 255 caracteres.',
            'notes.max' => 'Las notas no pueden exceder 1000 caracteres.',
        ]);

        Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $validated['amount'],
            'method' => $validated['method'],
            'payment_date' => now(),
            'status' => 'pendiente',
            'reference' => $validated['reference'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return back()->with('status', 'Pago registrado con éxito. Pendiente de confirmación.');
    }

    /**
     * Confirmar un pago pendiente
     */
    public function confirmPayment(Payment $payment)
    {
        $payment->confirm();

        // Recalcular el estado de la factura basado en pagos CONFIRMADOS
        $invoice = $payment->invoice;
        $totalConfirmed = $invoice->payments()->where('status', 'confirmado')->sum('amount');
        
        if ($totalConfirmed >= $invoice->total) {
            $invoice->update(['status' => 'paid']);
        } elseif ($totalConfirmed > 0) {
            $invoice->update(['status' => 'partially_paid']);
        }

        return back()->with('status', 'Pago confirmado exitosamente.');
    }

    /**
     * Rechazar / anular un pago pendiente
     */
    public function rejectPayment(Payment $payment)
    {
        $payment->update(['status' => 'rechazado']);

        // Recalcular el estado de la factura
        $invoice = $payment->invoice;
        $totalConfirmed = $invoice->payments()->where('status', 'confirmado')->sum('amount');
        
        if ($totalConfirmed >= $invoice->total) {
            $invoice->update(['status' => 'paid']);
        } elseif ($totalConfirmed > 0) {
            $invoice->update(['status' => 'partially_paid']);
        } else {
            $invoice->update(['status' => 'unpaid']);
        }

        return back()->with('status', 'Pago rechazado.');
    }

    /**
     * Historial global de pagos
     */
    public function paymentHistory(Request $request)
    {
        $query = Payment::with(['invoice.serviceOrder.customer'])
            ->latest('payment_date');

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filtro por método
        if ($request->filled('method')) {
            $query->where('method', $request->input('method'));
        }

        $payments = $query->get();

        // Estadísticas
        $allPayments = Payment::all();
        $totalRegistered = $allPayments->sum('amount');
        $totalConfirmed = $allPayments->where('status', 'confirmado')->sum('amount');
        $totalPending = $allPayments->where('status', 'pendiente')->sum('amount');
        $totalRejected = $allPayments->where('status', 'rechazado')->sum('amount');

        return view('modules.invoices.payment-history', compact(
            'payments', 'totalRegistered', 'totalConfirmed', 'totalPending', 'totalRejected'
        ));
    }
}
