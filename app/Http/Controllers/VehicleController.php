<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\VehiclePhoto;
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
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp',
        ], [
            'customer_id.required' => 'El cliente es obligatorio.',
            'customer_id.exists' => 'El cliente seleccionado no es válido.',
            'make.required' => 'La marca del vehículo es obligatoria.',
            'make.string' => 'La marca debe ser una cadena de texto.',
            'make.max' => 'La marca no puede superar los 100 caracteres.',
            'model.required' => 'El modelo del vehículo es obligatorio.',
            'model.string' => 'El modelo debe ser una cadena de texto.',
            'model.max' => 'El modelo no puede superar los 100 caracteres.',
            'year.required' => 'El año del vehículo es obligatorio.',
            'year.integer' => 'El año debe ser un número entero.',
            'year.min' => 'El año debe ser como mínimo 1900.',
            'year.max' => 'El año no puede ser mayor a ' . (date('Y') + 1) . '.',
            'license_plate.required' => 'La placa del vehículo es obligatoria.',
            'license_plate.string' => 'La placa debe ser una cadena de texto.',
            'license_plate.max' => 'La placa no puede superar los 20 caracteres.',
            'license_plate.unique' => 'Esta placa ya ha sido registrada.',
            'color.string' => 'El color debe ser una cadena de texto.',
            'color.max' => 'El color no puede superar los 50 caracteres.',
            'vin.string' => 'El VIN debe ser una cadena de texto.',
            'vin.max' => 'El VIN no puede superar los 50 caracteres.',
            'photos.array' => 'El formato de las fotos no es válido.',
            'photos.*.image' => 'El archivo debe ser una imagen válida.',
            'photos.*.mimes' => 'La foto debe ser en formato jpeg, png, jpg, gif o webp.',
        ]);

        $vehicle = Vehicle::create(collect($validated)->except(['photos'])->toArray());

        // Handle photo uploads during creation
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
        $vehicle->load(['customer', 'serviceOrders.workItems', 'photos']);
        return view('modules.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $vehicle->load('photos');
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
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp',
        ], [
            'customer_id.required' => 'El cliente es obligatorio.',
            'customer_id.exists' => 'El cliente seleccionado no es válido.',
            'make.required' => 'La marca del vehículo es obligatoria.',
            'make.string' => 'La marca debe ser una cadena de texto.',
            'make.max' => 'La marca no puede superar los 100 caracteres.',
            'model.required' => 'El modelo del vehículo es obligatorio.',
            'model.string' => 'El modelo debe ser una cadena de texto.',
            'model.max' => 'El modelo no puede superar los 100 caracteres.',
            'year.required' => 'El año del vehículo es obligatorio.',
            'year.integer' => 'El año debe ser un número entero.',
            'year.min' => 'El año debe ser como mínimo 1900.',
            'year.max' => 'El año no puede ser mayor a ' . (date('Y') + 1) . '.',
            'license_plate.required' => 'La placa del vehículo es obligatoria.',
            'license_plate.string' => 'La placa debe ser una cadena de texto.',
            'license_plate.max' => 'La placa no puede superar los 20 caracteres.',
            'license_plate.unique' => 'Esta placa ya ha sido registrada.',
            'color.string' => 'El color debe ser una cadena de texto.',
            'color.max' => 'El color no puede superar los 50 caracteres.',
            'vin.string' => 'El VIN debe ser una cadena de texto.',
            'vin.max' => 'El VIN no puede superar los 50 caracteres.',
            'photos.array' => 'El formato de las fotos no es válido.',
            'photos.*.image' => 'El archivo debe ser una imagen válida.',
            'photos.*.mimes' => 'La foto debe ser en formato jpeg, png, jpg, gif o webp.',
        ]);

        $vehicle->update(collect($validated)->except(['photos'])->toArray());

        // Handle photo uploads during update
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
        // Delete all associated photos from storage
        foreach ($vehicle->photos as $photo) {
            Storage::disk('public')->delete($photo->photo_path);
        }
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('status', 'Vehículo eliminado con éxito.');
    }

    /**
     * Upload photos for a vehicle.
     */
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

    /**
     * Delete a specific photo.
     */
    public function destroyPhoto(VehiclePhoto $photo)
    {
        Storage::disk('public')->delete($photo->photo_path);
        $photo->delete();

        return redirect()->back()->with('status', 'Foto eliminada con éxito.');
    }
}
