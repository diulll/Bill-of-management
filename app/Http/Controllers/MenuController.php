<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::withCount('ingredients')->orderBy('name')->paginate(20);
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        return view('menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100|unique:menus,name',
            'category'  => 'required|in:minuman,makanan',
            'price'     => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Menu::create($validated);

        return redirect()->route('menus.index')
                         ->with('success', "Menu \"{$validated['name']}\" berhasil ditambahkan.");
    }

    public function show(Menu $menu)
    {
        $menu->load('ingredients');
        $allIngredients = Ingredient::orderBy('name')->get();
        $usedIngredientIds = $menu->ingredients->pluck('id')->toArray();

        return view('menus.show', compact('menu', 'allIngredients', 'usedIngredientIds'));
    }

    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100|unique:menus,name,' . $menu->id,
            'category'  => 'required|in:minuman,makanan',
            'price'     => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $menu->update($validated);

        return redirect()->route('menus.index')
                         ->with('success', "Menu \"{$menu->name}\" berhasil diperbarui.");
    }

    public function destroy(Menu $menu)
    {
        $name = $menu->name;
        $menu->delete(); // cascade hapus menu_ingredients

        return redirect()->route('menus.index')
                         ->with('success', "Menu \"{$name}\" berhasil dihapus.");
    }

    /**
     * Simpan/update komposisi resep untuk satu menu
     */
    public function updateRecipe(Request $request, Menu $menu)
    {
        $request->validate([
            'ingredients'              => 'nullable|array',
            'ingredients.*.id'         => 'required|exists:ingredients,id',
            'ingredients.*.quantity'   => 'required|numeric|min:0.01',
        ]);

        $syncData = [];
        foreach ($request->input('ingredients', []) as $item) {
            $ingredient = Ingredient::find($item['id']);
            $syncData[$item['id']] = [
                'quantity' => $item['quantity'],
                'unit'     => $ingredient->unit,
            ];
        }

        $menu->ingredients()->sync($syncData);

        return redirect()->route('menus.show', $menu)
                         ->with('success', "Resep menu \"{$menu->name}\" berhasil disimpan.");
    }
}
