<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMenus       = Menu::count();
        $totalIngredients = Ingredient::count();
        $totalSales       = Sale::count();
        $totalPortions    = SaleItem::sum('quantity');

        // Penjualan 7 hari terakhir
        $recentSales = Sale::withCount('items')
                           ->withSum('items', 'quantity')
                           ->orderByDesc('sale_date')
                           ->take(5)
                           ->get();

        // Top 5 menu terlaris
        $topMenus = DB::table('sale_items as si')
            ->join('menus as m', 'si.menu_id', '=', 'm.id')
            ->select('m.name', DB::raw('SUM(si.quantity) as total_qty'))
            ->groupBy('m.id', 'm.name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Top 5 bahan paling banyak dipakai
        $topIngredients = DB::table('sale_items as si')
            ->join('menu_ingredients as mi', 'si.menu_id', '=', 'mi.menu_id')
            ->join('ingredients as i', 'mi.ingredient_id', '=', 'i.id')
            ->select('i.name', 'i.unit', DB::raw('SUM(si.quantity * mi.quantity) as total_used'))
            ->groupBy('i.id', 'i.name', 'i.unit')
            ->orderByDesc('total_used')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalMenus',
            'totalIngredients',
            'totalSales',
            'totalPortions',
            'recentSales',
            'topMenus',
            'topIngredients'
        ));
    }
}
