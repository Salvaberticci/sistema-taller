<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index()
    {
        $parts = Part::latest()->get();
        return view('modules.inventory.index', compact('parts'));
    }

    public function create()
    {
        return view('modules.inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:parts',
            'stock' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'min_stock' => 'required|numeric|min:0',
        ]);

        Part::create($validated);

        return redirect()->route('inventory.index')->with('status', 'Repuesto registrado con éxito.');
    }

    public function edit(Part $part)
    {
        return view('modules.inventory.edit', compact('part'));
    }

    public function update(Request $request, Part $part)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:parts,sku,'.$part->id,
            'stock' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'min_stock' => 'required|numeric|min:0',
        ]);

        $part->update($validated);

        return redirect()->route('inventory.index')->with('status', 'Repuesto actualizado con éxito.');
    }

    public function destroy(Part $part)
    {
        $part->delete();
        return redirect()->route('inventory.index')->with('status', 'Repuesto eliminado con éxito.');
    }
}
