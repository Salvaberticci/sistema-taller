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
            'scheduled_at' => [
                'required',
                'date',
                'after:now',
                function ($attribute, $value, $fail) {
                    $date = \Carbon\Carbon::parse($value);
                    // No domingos
                    if ($date->isSunday()) {
                        $fail('No se pueden agendar citas los domingos.');
                        return;
                    }
                    // Horario laboral 8am - 5pm
                    $hour = (int) $date->format('H');
                    if ($hour < 8 || $hour >= 17) {
                        $fail('El horario de atención es de 8:00 am a 5:00 pm.');
                    }
                },
            ],
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
