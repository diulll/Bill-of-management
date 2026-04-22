<?php

namespace App\Http\Controllers;

use App\Models\CalculatorLog;
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

        // Rekap Hitung Cepat (Calculator Logs)
        $calculatorLogs = CalculatorLog::orderByDesc('log_date')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn ($log) => $log->log_date->format('Y-m-d'));

        return view('dashboard', compact(
            'totalMenus',
            'totalIngredients',
            'totalSales',
            'totalPortions',
            'calculatorLogs'
        ));
    }
}
