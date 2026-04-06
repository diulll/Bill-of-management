<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', today()->toDateString());
        $dateTo   = $request->input('date_to', today()->toDateString());

        // Query akumulasi penggunaan bahan dalam range tanggal
        $ingredientUsage = DB::table('sale_items as si')
            ->join('sales as s', 'si.sale_id', '=', 's.id')
            ->join('menu_ingredients as mi', 'si.menu_id', '=', 'mi.menu_id')
            ->join('ingredients as i', 'mi.ingredient_id', '=', 'i.id')
            ->whereBetween('s.sale_date', [$dateFrom, $dateTo])
            ->select(
                'i.id',
                'i.name as ingredient_name',
                'i.unit',
                DB::raw('SUM(si.quantity * mi.quantity) as total_used')
            )
            ->groupBy('i.id', 'i.name', 'i.unit')
            ->orderByDesc('total_used')
            ->get();

        // Detail per-menu per-bahan (breakdown)
        $breakdown = DB::table('sale_items as si')
            ->join('sales as s', 'si.sale_id', '=', 's.id')
            ->join('menus as m', 'si.menu_id', '=', 'm.id')
            ->join('menu_ingredients as mi', 'si.menu_id', '=', 'mi.menu_id')
            ->join('ingredients as i', 'mi.ingredient_id', '=', 'i.id')
            ->whereBetween('s.sale_date', [$dateFrom, $dateTo])
            ->select(
                'i.name as ingredient_name',
                'i.unit',
                'm.name as menu_name',
                DB::raw('SUM(si.quantity) as total_qty_sold'),
                DB::raw('mi.quantity as recipe_qty'),
                DB::raw('SUM(si.quantity * mi.quantity) as subtotal_used')
            )
            ->groupBy('i.id', 'i.name', 'i.unit', 'm.id', 'm.name', 'mi.quantity')
            ->orderBy('i.name')
            ->orderByDesc('subtotal_used')
            ->get()
            ->groupBy('ingredient_name');

        // Rekap penjualan per menu dalam range
        $menuSales = DB::table('sale_items as si')
            ->join('sales as s', 'si.sale_id', '=', 's.id')
            ->join('menus as m', 'si.menu_id', '=', 'm.id')
            ->whereBetween('s.sale_date', [$dateFrom, $dateTo])
            ->select('m.name as menu_name', 'm.category', DB::raw('SUM(si.quantity) as total_qty'))
            ->groupBy('m.id', 'm.name', 'm.category')
            ->orderByDesc('total_qty')
            ->get();

        // Stats summary
        $totalSales = Sale::whereBetween('sale_date', [$dateFrom, $dateTo])->count();
        $totalPortions = SaleItem::whereHas('sale', fn($q) => $q->whereBetween('sale_date', [$dateFrom, $dateTo]))
                                  ->sum('quantity');

        return view('reports.index', compact(
            'ingredientUsage',
            'breakdown',
            'menuSales',
            'dateFrom',
            'dateTo',
            'totalSales',
            'totalPortions'
        ));
    }
}
