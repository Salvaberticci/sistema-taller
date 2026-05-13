<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller
{
    public function index()
    {
        $orders = ServiceOrder::with(['customer', 'vehicle'])->latest()->get();
        return view('modules.orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::with('vehicles')->orderBy('name')->get();
        return view('modules.orders.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'description' => 'required|string',
            'estimated_total' => 'nullable|numeric',
        ]);

        $order = ServiceOrder::create([
            'customer_id' => $validated['customer_id'],
            'vehicle_id' => $validated['vehicle_id'],
            'description' => $validated['description'],
            'status' => 'pending',
            'entry_date' => now(),
            'total_amount' => $validated['estimated_total'] ?? 0,
        ]);

        return redirect()->route('orders.index')->with('status', 'Orden #OT-'.$order->id.' abierta con éxito.');
    }

    public function show(ServiceOrder $order)
    {
        $order->load(['customer', 'vehicle', 'workItems']);
        return view('modules.orders.show', compact('order'));
    }
    public function edit(ServiceOrder $order)
    {
        $order->load(['customer', 'vehicle']);
        return view('modules.orders.edit', compact('order'));
    }

    public function update(Request $request, ServiceOrder $order)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'status' => 'required|in:pending,completed,cancelled',
            'total_amount' => 'required|numeric',
        ]);

        $order->update($validated);

        return redirect()->route('orders.show', $order->id)->with('status', 'Orden actualizada con éxito.');
    }
}
