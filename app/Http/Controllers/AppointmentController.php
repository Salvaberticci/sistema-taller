<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['customer', 'vehicle'])->latest()->get();
        return view('modules.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $customers = Customer::with('vehicles')->get();
        return view('modules.appointments.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'scheduled_at' => 'required|date|after:now',
            'status' => 'required|in:scheduled,confirmed,completed,cancelled',
            'description' => 'nullable|string',
        ]);

        Appointment::create($validated);

        return redirect()->route('appointments.index')->with('status', 'Cita agendada con éxito.');
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,confirmed,completed,cancelled',
        ]);

        $appointment->update($validated);

        return back()->with('status', 'Estado de la cita actualizado.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('status', 'Cita eliminada.');
    }
}
