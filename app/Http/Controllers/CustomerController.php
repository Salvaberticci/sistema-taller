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
            'name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'id_card_type' => 'nullable|in:V,J,E,G',
            'id_card' => [
                'nullable',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($request) {
                    $fullIdCard = ($request->id_card_type ?? 'V') . '-' . $value;
                    if (\App\Models\Customer::where('id_card', $fullIdCard)->exists()) {
                        $fail('Este número de cédula / RIF ya está registrado.');
                    }
                },
            ],
            'email' => 'nullable|email:filter|max:255',
            'phone' => ['required', 'string', 'max:20', 'regex:/^\+?58\d{7,10}$/'],
            'address' => 'nullable|string',
        ], [
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'id_card_type.in' => 'Tipo de documento inválido (V, J, E, G).',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'phone.regex' => 'El teléfono debe tener formato internacional (+58...).',
        ]);

        $idCardFull = $validated['id_card']
            ? ($validated['id_card_type'] ?? 'V') . '-' . $validated['id_card']
            : null;

        Customer::create([
            'name' => $validated['name'],
            'id_card' => $idCardFull,
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

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
            'name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'id_card_type' => 'nullable|in:V,J,E,G',
            'id_card' => [
                'nullable',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($request, $customer) {
                    $fullIdCard = ($request->id_card_type ?? 'V') . '-' . $value;
                    if (\App\Models\Customer::where('id_card', $fullIdCard)->where('id', '!=', $customer->id)->exists()) {
                        $fail('Este número de cédula / RIF ya está registrado.');
                    }
                },
            ],
            'email' => 'nullable|email:filter|max:255',
            'phone' => ['required', 'string', 'max:20', 'regex:/^\+?58\d{7,10}$/'],
            'address' => 'nullable|string',
        ], [
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'id_card_type.in' => 'Tipo de documento inválido (V, J, E, G).',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'phone.regex' => 'El teléfono debe tener formato internacional (+58...).',
        ]);

        $idCardFull = $validated['id_card']
            ? ($validated['id_card_type'] ?? 'V') . '-' . $validated['id_card']
            : null;

        $customer->update([
            'name' => $validated['name'],
            'id_card' => $idCardFull,
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('customers.index')->with('status', 'Cliente actualizado con éxito.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('status', 'Cliente eliminado con éxito.');
    }
}
