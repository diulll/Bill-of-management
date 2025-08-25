@extends('app')

@section('content')
<div class="mb-6">
    <a href="{{ route('calculator-logs.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-lg shadow-sm transition-all duration-150 active:scale-95 mb-3">
        <i class="mdi mdi-chevron-left text-lg"></i>
        Kembali ke Daftar Rekap
    </a>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Detail Rekap Kalkulasi</h1>
            <p class="text-slate-500 mt-1">Disimpan pada {{ $calculator_log->created_at->translatedFormat('l, d F Y \p\u\k\u\l H:i') }}</p>
        </div>
        <form action="{{ route('calculator-logs.destroy', $calculator_log) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rekap ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-sm px-4 py-2 rounded-lg transition font-medium border border-red-200">
                <i class="mdi mdi-delete text-lg"></i>
                Hapus Rekap
            </button>
        </form>
    </div>
</div>

<!-- Info Card -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-1">Nama Operator</p>
        <p class="text-lg font-bold text-slate-800">{{ $calculator_log->name }}</p>
    </div>
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-1">Shift</p>
        <p class="text-lg font-bold text-primary">{{ $calculator_log->shift }}</p>
    </div>
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-1">Tanggal</p>
        <p class="text-lg font-bold text-slate-800">{{ $calculator_log->log_date->format('d/m/Y') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <!-- Menu yang Dihitung -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                <i class="mdi mdi-clipboard-text text-xl text-blue-500"></i>
                Menu yang Dihitung
            </h2>
            <p class="text-xs text-slate-400 mt-0.5">{{ count($calculator_log->menus_data) }} menu &bull; {{ collect($calculator_log->menus_data)->sum('qty') }} total porsi</p>
        </div>
        <div class="divide-y divide-slate-100">
            @foreach($calculator_log->menus_data as $menu)
            <div class="px-6 py-3.5 flex items-center justify-between hover:bg-slate-50 transition">
                <span class="font-medium text-slate-700">{{ $menu['name'] }}</span>
                <span class="bg-blue-50 text-blue-600 font-bold px-3 py-1 rounded-full text-sm">{{ $menu['qty'] }}x</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Bahan yang Terpakai -->
    <div class="bg-slate-800 rounded-xl shadow-md border border-slate-700 overflow-hidden text-slate-100">
        <div class="px-6 py-5 border-b border-slate-700 bg-slate-900/50 backdrop-blur-sm">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="mdi mdi-flash text-xl text-yellow-400"></i>
                Bahan yang Terpakai
            </h2>
            <p class="text-xs text-slate-400 mt-1">{{ count($calculator_log->ingredients_data) }} jenis bahan baku</p>
        </div>
        
        <div class="p-0">
            <ul class="divide-y divide-slate-700/50">
                @foreach($calculator_log->ingredients_data as $ing)
                <li class="px-6 py-4 flex justify-between items-center hover:bg-slate-700/30 transition">
                    <span class="font-medium text-slate-200">
                        <span class="text-orange-400 font-bold mr-1">•</span>
                        {{ $ing['name'] }}
                    </span>
                    <span class="font-mono text-emerald-400 font-bold bg-slate-900/50 px-2 py-1 rounded">
                        {{ $ing['amount'] }} <span class="text-xs ml-1 font-sans text-slate-500">{{ $ing['unit'] }}</span>
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
