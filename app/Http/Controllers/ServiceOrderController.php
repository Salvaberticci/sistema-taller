<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ServiceOrder;
use App\Models\Part;
use App\Models\User;
use App\Models\WorkItem;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller
{
    public function index()
    {
        $orders = ServiceOrder::with(['customer', 'vehicle', 'invoice'])->latest()->get();
        return view('modules.orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::with('vehicles')->orderBy('name')->get();
        $mechanics = User::where('role', 'mecanico')->orWhere('role', 'mechanic')->orderBy('name')->get();
        return view('modules.orders.create', compact('customers', 'mechanics'));
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
        $order->load(['customer', 'vehicle', 'workItems', 'invoice']);
        $parts = Part::where('stock', '>', 0)->get();
        return view('modules.orders.show', compact('order', 'parts'));
    }

    public function edit(ServiceOrder $order)
    {
        $customers = Customer::with('vehicles')->orderBy('name')->get();
        $mechanics = User::where('role', 'mecanico')->orWhere('role', 'mechanic')->orderBy('name')->get();
        $order->load(['customer', 'vehicle']);
        return view('modules.orders.edit', compact('order', 'customers', 'mechanics'));
    }

    public function update(Request $request, ServiceOrder $order)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'description' => 'required|string',
            'estimated_total' => 'nullable|numeric',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $order->update([
            'customer_id' => $validated['customer_id'],
            'vehicle_id' => $validated['vehicle_id'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'total_amount' => $validated['estimated_total'] ?? $order->total_amount,
        ]);

        return redirect()->route('orders.index')->with('status', 'Orden #OT-'.$order->id.' actualizada con éxito.');
    }

    public function destroy(ServiceOrder $order)
    {
        $order->workItems()->delete();
        $order->delete();
        return redirect()->route('orders.index')->with('status', 'Orden #OT-'.$order->id.' eliminada con éxito.');
    }

    public function addItem(Request $request, ServiceOrder $order)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'type' => 'required|in:part,labor,external_service',
            'quantity' => 'required|numeric|min:0.01',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $total = $validated['quantity'] * $validated['unit_price'];

        WorkItem::create([
            'service_order_id' => $order->id,
            'description' => $validated['description'],
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'unit_price' => $validated['unit_price'],
            'total' => $total,
        ]);

        // Subtract stock if it's a part
        if ($validated['type'] === 'part') {
            $part = Part::where('name', $validated['description'])->first();
            if ($part) {
                $part->decrement('stock', $validated['quantity']);
            }
        }

        // Update order total
        $order->increment('total_amount', $total);

        return back()->with('status', 'Item añadido correctamente.');
    }

    public function removeItem(WorkItem $workItem)
    {
        $order = $workItem->serviceOrder;
        $total = $workItem->total;

        // Restore stock if it was a part
        if ($workItem->type === 'part') {
            $part = Part::where('name', $workItem->description)->first();
            if ($part) {
                $part->increment('stock', $workItem->quantity);
            }
        }

        $workItem->delete();
        $order->decrement('total_amount', $total);

        return back()->with('status', 'Item eliminado.');
    }

    public function updateStatus(Request $request, ServiceOrder $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('status', 'Estado de la orden actualizado.');
    }
}
