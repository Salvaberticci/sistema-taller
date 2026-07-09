<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehiclePhoto;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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
        $makes = VehicleMake::orderBy('name')->get();
        $models = VehicleModel::with('make')->orderBy('name')->get();
        $mechanics = User::where('role', 'mecanico')->orWhere('role', 'mechanic')->orderBy('name')->get();
        return view('modules.vehicles.create', compact('customers', 'makes', 'models', 'mechanics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'make_id' => 'nullable|exists:vehicle_makes,id',
            'model_id' => 'nullable|exists:vehicle_models,id',
            'make' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:'.(date('Y')+1),
            'license_plate' => 'required|string|min:6|max:8|regex:/^[A-Z0-9-]+$/|unique:vehicles',
            'color' => 'nullable|string|max:50',
            'vin' => ['required', 'size:17', 'regex:/^[A-HJ-NPR-Z0-9]+$/u', 'unique:vehicles'],
            'mileage' => 'nullable|integer|min:0',
            'fuel_level' => 'nullable|in:empty,quarter,half,three_quarters',
            'assigned_mechanic_id' => 'nullable|exists:users,id',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp',
        ], [
            'customer_id.required' => 'El cliente es obligatorio.',
            'customer_id.exists' => 'El cliente seleccionado no es válido.',
            'make.required' => 'La marca del vehículo es obligatoria.',
            'model.required' => 'El modelo del vehículo es obligatorio.',
            'year.required' => 'El año del vehículo es obligatorio.',
            'year.min' => 'El año debe ser como mínimo 1900.',
            'year.max' => 'El año no puede ser mayor a ' . (date('Y') + 1) . '.',
            'license_plate.required' => 'La placa del vehículo es obligatoria.',
            'license_plate.regex' => 'La placa solo puede contener letras mayúsculas, números y guiones.',
            'license_plate.unique' => 'Esta placa ya ha sido registrada.',
            'vin.required' => 'El VIN es obligatorio.',
            'vin.size' => 'El VIN debe tener exactamente 17 caracteres.',
            'vin.regex' => 'El VIN contiene caracteres prohibidos (I, O, Q no están permitidos).',
            'vin.unique' => 'Este VIN ya ha sido registrado.',
            'mileage.integer' => 'El kilometraje debe ser un número entero.',
            'fuel_level.in' => 'Nivel de combustible inválido.',
            'assigned_mechanic_id.exists' => 'El mecánico seleccionado no es válido.',
        ]);

        $vehicle = Vehicle::create(collect($validated)->except(['photos'])->toArray());

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('vehicle-photos/' . $vehicle->id, 'public');
                VehiclePhoto::create([
                    'vehicle_id' => $vehicle->id,
                    'photo_path' => $path,
                    'description' => null,
                ]);
            }
        }

        return redirect()->route('vehicles.index')->with('status', 'Vehículo registrado con éxito.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['customer', 'serviceOrders.workItems', 'photos', 'assignedMechanic', 'vehicleMake', 'vehicleModel']);
        return view('modules.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $vehicle->load('photos');
        $customers = Customer::orderBy('name')->get();
        $makes = VehicleMake::orderBy('name')->get();
        $models = VehicleModel::with('make')->orderBy('name')->get();
        $mechanics = User::where('role', 'mecanico')->orWhere('role', 'mechanic')->orderBy('name')->get();
        return view('modules.vehicles.edit', compact('vehicle', 'customers', 'makes', 'models', 'mechanics'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'make_id' => 'nullable|exists:vehicle_makes,id',
            'model_id' => 'nullable|exists:vehicle_models,id',
            'make' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:'.(date('Y')+1),
            'license_plate' => 'required|string|min:6|max:8|regex:/^[A-Z0-9-]+$/|unique:vehicles,license_plate,'.$vehicle->id,
            'color' => 'nullable|string|max:50',
            'vin' => ['required', 'size:17', 'regex:/^[A-HJ-NPR-Z0-9]+$/u', 'unique:vehicles,vin,'.$vehicle->id],
            'mileage' => 'nullable|integer|min:0',
            'fuel_level' => 'nullable|in:empty,quarter,half,three_quarters',
            'assigned_mechanic_id' => 'nullable|exists:users,id',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp',
        ], [
            'customer_id.required' => 'El cliente es obligatorio.',
            'customer_id.exists' => 'El cliente seleccionado no es válido.',
            'make.required' => 'La marca del vehículo es obligatoria.',
            'model.required' => 'El modelo del vehículo es obligatorio.',
            'year.required' => 'El año del vehículo es obligatorio.',
            'year.min' => 'El año debe ser como mínimo 1900.',
            'year.max' => 'El año no puede ser mayor a ' . (date('Y') + 1) . '.',
            'license_plate.required' => 'La placa del vehículo es obligatoria.',
            'license_plate.regex' => 'La placa solo puede contener letras mayúsculas, números y guiones.',
            'license_plate.unique' => 'Esta placa ya ha sido registrada.',
            'vin.required' => 'El VIN es obligatorio.',
            'vin.size' => 'El VIN debe tener exactamente 17 caracteres.',
            'vin.regex' => 'El VIN contiene caracteres prohibidos (I, O, Q no están permitidos).',
            'vin.unique' => 'Este VIN ya ha sido registrado.',
            'mileage.integer' => 'El kilometraje debe ser un número entero.',
            'fuel_level.in' => 'Nivel de combustible inválido.',
            'assigned_mechanic_id.exists' => 'El mecánico seleccionado no es válido.',
        ]);

        $vehicle->update(collect($validated)->except(['photos'])->toArray());

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('vehicle-photos/' . $vehicle->id, 'public');
                VehiclePhoto::create([
                    'vehicle_id' => $vehicle->id,
                    'photo_path' => $path,
                    'description' => null,
                ]);
            }
        }

        return redirect()->route('vehicles.show', $vehicle->id)->with('status', 'Vehículo actualizado con éxito.');
    }

    public function destroy(Vehicle $vehicle)
    {
        foreach ($vehicle->photos as $photo) {
            Storage::disk('public')->delete($photo->photo_path);
        }
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('status', 'Vehículo eliminado con éxito.');
    }

    public function storePhotos(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'photos' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp',
            'descriptions.*' => 'nullable|string|max:255',
        ], [
            'photos.required' => 'Debe seleccionar al menos una foto para subir.',
            'photos.*.image' => 'El archivo debe ser una imagen válida.',
            'photos.*.mimes' => 'La foto debe ser en formato jpeg, png, jpg, gif o webp.',
            'descriptions.*.string' => 'La descripción debe ser una cadena de texto.',
            'descriptions.*.max' => 'La descripción no puede superar los 255 caracteres.',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('vehicle-photos/' . $vehicle->id, 'public');
                VehiclePhoto::create([
                    'vehicle_id' => $vehicle->id,
                    'photo_path' => $path,
                    'description' => $request->input("descriptions.{$index}"),
                ]);
            }
        }

        return redirect()->back()->with('status', 'Fotos subidas con éxito.');
    }

    public function destroyPhoto(VehiclePhoto $photo)
    {
        Storage::disk('public')->delete($photo->photo_path);
        $photo->delete();

        return redirect()->back()->with('status', 'Foto eliminada con éxito.');
    }

    public function getModelsByMake($makeId)
    {
        $models = VehicleModel::where('vehicle_make_id', $makeId)->orderBy('name')->get();
        return response()->json($models);
    }
}
