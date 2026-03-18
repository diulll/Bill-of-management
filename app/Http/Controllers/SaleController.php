<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::withCount('items')
                     ->withSum('items', 'quantity')
                     ->orderByDesc('sale_date')
                     ->orderByDesc('created_at')
                     ->paginate(20);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $menus = Menu::active()->orderBy('category')->orderBy('name')->get();
        return view('sales.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_date'          => 'required|date',
            'notes'              => 'nullable|string|max:500',
            'items'              => 'required|array|min:1',
            'items.*.menu_id'    => 'required|exists:menus,id',
            'items.*.quantity'   => 'required|integer|min:0',
        ]);

        // Filter item yang quantity-nya > 0
        $items = collect($request->items)->filter(fn($i) => $i['quantity'] > 0);

        if ($items->isEmpty()) {
            return back()->withInput()
                         ->withErrors(['items' => 'Masukkan minimal 1 menu dengan quantity > 0.']);
        }

        DB::transaction(function () use ($request, $items) {
            $sale = Sale::create([
                'sale_date' => $request->sale_date,
                'notes'     => $request->notes,
            ]);

            foreach ($items as $item) {
                SaleItem::create([
                    'sale_id'  => $sale->id,
                    'menu_id'  => $item['menu_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });

        return redirect()->route('sales.index')
                         ->with('success', 'Data penjualan berhasil disimpan.');
    }

    public function show(Sale $sale)
    {
        $sale->load(['items.menu']);
        $ingredientUsage = $sale->getIngredientUsage();

        return view('sales.show', compact('sale', 'ingredientUsage'));
    }

    public function edit(Sale $sale)
    {
        $sale->load('items');
        $menus = Menu::active()->orderBy('category')->orderBy('name')->get();

        // Map existing items by menu_id untuk pre-fill form
        $existingItems = $sale->items->keyBy('menu_id');

        return view('sales.edit', compact('sale', 'menus', 'existingItems'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'sale_date'          => 'required|date',
            'notes'              => 'nullable|string|max:500',
            'items'              => 'required|array|min:1',
            'items.*.menu_id'    => 'required|exists:menus,id',
            'items.*.quantity'   => 'required|integer|min:0',
        ]);

        $items = collect($request->items)->filter(fn($i) => $i['quantity'] > 0);

        if ($items->isEmpty()) {
            return back()->withInput()
                         ->withErrors(['items' => 'Masukkan minimal 1 menu dengan quantity > 0.']);
        }

        DB::transaction(function () use ($request, $sale, $items) {
            $sale->update([
                'sale_date' => $request->sale_date,
                'notes'     => $request->notes,
            ]);

            // Hapus semua item lama, ganti dengan yang baru
            $sale->items()->delete();

            foreach ($items as $item) {
                SaleItem::create([
                    'sale_id'  => $sale->id,
                    'menu_id'  => $item['menu_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });

        return redirect()->route('sales.show', $sale)
                         ->with('success', 'Data penjualan berhasil diperbarui.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete(); // cascade hapus sale_items
        return redirect()->route('sales.index')
                         ->with('success', 'Data penjualan berhasil dihapus.');
    }
}
