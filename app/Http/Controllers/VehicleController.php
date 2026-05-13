<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Customer;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('customer')->latest()->get();
        return view('modules.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        return view('modules.vehicles.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'make' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:'.(date('Y')+1),
            'license_plate' => 'required|string|max:20|unique:vehicles',
            'color' => 'nullable|string|max:50',
            'vin' => 'nullable|string|max:50',
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')->with('status', 'Vehículo registrado con éxito.');
    }
    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['customer', 'serviceOrders.workItems']);
        return view('modules.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $customers = Customer::orderBy('name')->get();
        return view('modules.vehicles.edit', compact('vehicle', 'customers'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'make' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:'.(date('Y')+1),
            'license_plate' => 'required|string|max:20|unique:vehicles,license_plate,'.$vehicle->id,
            'color' => 'nullable|string|max:50',
            'vin' => 'nullable|string|max:50',
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.index')->with('status', 'Vehículo actualizado con éxito.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('status', 'Vehículo eliminado con éxito.');
    }
}
