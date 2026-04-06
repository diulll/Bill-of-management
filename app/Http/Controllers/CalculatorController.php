<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class CalculatorController extends Controller
{
    public function index()
    {
        // Ambil semua menu yang aktif beserta resep / bahan bakunya
        $menus = Menu::active()->with('ingredients')->orderBy('name')->get();
        
        return view('calculator.index', compact('menus'));
    }
}
