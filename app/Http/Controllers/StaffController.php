<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::latest()->get();
        return view('modules.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('modules.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,mecanico,recepcionista'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('staff.index')->with('status', 'Personal registrado con éxito.');
    }

    public function edit(User $staff)
    {
        return view('modules.staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$staff->id],
            'role' => ['required', 'in:admin,mecanico,recepcionista'],
        ]);

        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $staff->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('staff.index')->with('status', 'Perfil actualizado con éxito.');
    }

    public function destroy(User $staff)
    {
        if ($staff->id === auth()->id()) {
            return back()->withErrors(['error' => 'No puedes eliminarte a ti mismo.']);
        }

        $staff->delete();
        return redirect()->route('staff.index')->with('status', 'Personal eliminado del sistema.');
    }
}
