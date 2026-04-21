<?php

namespace App\Http\Controllers;

use App\Models\CalculatorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalculatorLogController extends Controller
{
    /**
     * Simpan hasil kalkulasi dari Hitung Cepat
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'shift'            => 'required|string|max:50',
            'menus_data'       => 'required|json',
            'ingredients_data' => 'required|json',
        ]);

        CalculatorLog::create([
            'name'             => $request->name,
            'shift'            => $request->shift,
            'log_date'         => now()->toDateString(),
            'menus_data'       => json_decode($request->menus_data, true),
            'ingredients_data' => json_decode($request->ingredients_data, true),
            'user_id'          => Auth::id(),
        ]);

        return redirect()->route('calculator-logs.index')
                         ->with('success', 'Rekap kalkulasi berhasil disimpan!');
    }

    /**
     * Halaman Laporan Kalkulator — list per tanggal
     */
    public function index(Request $request)
    {
        $dateFilter = $request->input('date');

        $query = CalculatorLog::orderByDesc('log_date')->orderByDesc('created_at');

        if ($dateFilter) {
            $query->whereDate('log_date', $dateFilter);
        }

        $logs = $query->get()->groupBy(fn ($log) => $log->log_date->format('Y-m-d'));

        return view('calculator-logs.index', compact('logs', 'dateFilter'));
    }

    /**
     * Detail satu log kalkulasi
     */
    public function show(CalculatorLog $calculator_log)
    {
        return view('calculator-logs.show', compact('calculator_log'));
    }

    /**
     * Hapus log kalkulasi
     */
    public function destroy(CalculatorLog $calculator_log)
    {
        $calculator_log->delete();

        return redirect()->route('calculator-logs.index')
                         ->with('success', 'Rekap berhasil dihapus.');
    }
}
