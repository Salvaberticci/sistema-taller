<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::withCount('vehicles')->latest()->get();
        return view('modules.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('modules.customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_card' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('status', 'Cliente registrado con éxito.');
    }

    public function show(Customer $customer)
    {
        $customer->load('vehicles.serviceOrders.workItems');
        return view('modules.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('modules.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_card' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('status', 'Cliente actualizado con éxito.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('status', 'Cliente eliminado con éxito.');
    }
}
