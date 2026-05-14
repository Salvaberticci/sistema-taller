<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\ServiceOrder;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Customer;
use App\Services\CurrencyService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function inventory()
    {
        $parts = Part::all();
        $rate = CurrencyService::getBcvRate();
        $pdf = Pdf::loadView('pdf.inventory', compact('parts', 'rate'));
        return $pdf->download('reporte-inventario-' . now()->format('d-m-Y') . '.pdf');
    }

    public function orders()
    {
        $orders = ServiceOrder::with(['customer', 'vehicle'])->latest()->get();
        $rate = CurrencyService::getBcvRate();
        $pdf = Pdf::loadView('pdf.orders', compact('orders', 'rate'));
        return $pdf->download('reporte-ordenes-' . now()->format('d-m-Y') . '.pdf');
    }

    public function invoices()
    {
        $invoices = Invoice::with(['serviceOrder.customer'])->latest()->get();
        $rate = CurrencyService::getBcvRate();
        $pdf = Pdf::loadView('pdf.invoices', compact('invoices', 'rate'));
        return $pdf->download('reporte-facturas-' . now()->format('d-m-Y') . '.pdf');
    }

    public function dashboard()
    {
        $monthlySales = Invoice::whereMonth('issue_date', now()->month)->sum('total');
        $ordersCount = ServiceOrder::count();
        $customersCount = Customer::count();
        $criticalStock = Part::where('stock', '<=', \DB::raw('min_stock'))->count();
        $recentOrders = ServiceOrder::with(['customer', 'vehicle'])->latest()->take(10)->get();
        
        $rate = CurrencyService::getBcvRate();
        $pdf = Pdf::loadView('pdf.dashboard', compact('monthlySales', 'ordersCount', 'customersCount', 'criticalStock', 'recentOrders', 'rate'));
        return $pdf->download('reporte-dashboard-' . now()->format('d-m-Y') . '.pdf');
    }

    public function vehicles()
    {
        $vehicles = \App\Models\Vehicle::with('customer')->get();
        $pdf = Pdf::loadView('pdf.vehicles', compact('vehicles'));
        return $pdf->download('reporte-vehiculos-' . now()->format('d-m-Y') . '.pdf');
    }

    public function appointments()
    {
        $appointments = \App\Models\Appointment::with(['customer', 'vehicle'])->orderBy('scheduled_at')->get();
        $pdf = Pdf::loadView('pdf.appointments', compact('appointments'));
        return $pdf->download('reporte-agenda-' . now()->format('d-m-Y') . '.pdf');
    }

    public function staff()
    {
        $staff = User::all();
        $pdf = Pdf::loadView('pdf.staff', compact('staff'));
        return $pdf->download('reporte-personal-' . now()->format('d-m-Y') . '.pdf');
    }

    public function customers()
    {
        $customers = Customer::all();
        $pdf = Pdf::loadView('pdf.customers', compact('customers'));
        return $pdf->download('reporte-clientes-' . now()->format('d-m-Y') . '.pdf');
    }

    // Individual report for an invoice (the actual invoice)
    public function invoice(Invoice $invoice)
    {
        $invoice->load(['serviceOrder.customer', 'serviceOrder.vehicle', 'payments']);
        $rate = CurrencyService::getBcvRate();
        $pdf = Pdf::loadView('pdf.invoice-detail', compact('invoice', 'rate'));
        return $pdf->stream('factura-' . $invoice->number . '.pdf');
    }
}
