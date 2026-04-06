<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::orderBy('name')->paginate(20);
        return view('ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('ingredients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:ingredients,name',
            'unit' => 'required|string|max:20',
        ]);

        Ingredient::create($validated);

        return redirect()->route('ingredients.index')
                         ->with('success', "Bahan baku \"{$validated['name']}\" berhasil ditambahkan.");
    }

    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:ingredients,name,' . $ingredient->id,
            'unit' => 'required|string|max:20',
        ]);

        $ingredient->update($validated);

        return redirect()->route('ingredients.index')
                         ->with('success', "Bahan baku \"{$ingredient->name}\" berhasil diperbarui.");
    }

    public function destroy(Ingredient $ingredient)
    {
        // Cek apakah ingredient dipakai di resep
        if ($ingredient->menus()->count() > 0) {
            return redirect()->route('ingredients.index')
                             ->with('error', "Bahan \"{$ingredient->name}\" tidak bisa dihapus karena masih digunakan di {$ingredient->menus()->count()} resep menu.");
        }

        $name = $ingredient->name;
        $ingredient->delete();

        return redirect()->route('ingredients.index')
                         ->with('success', "Bahan baku \"{$name}\" berhasil dihapus.");
    }
}
