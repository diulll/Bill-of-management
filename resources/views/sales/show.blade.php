@extends('app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <a href="{{ route('sales.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 flex items-center gap-1 w-fit transition mb-2">
            <i class="mdi mdi-arrow-left text-lg"></i>
            Kembali ke Daftar Penjualan
        </a>
        <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
            Rekap Penjualan: {{ $sale->sale_date->format('d M Y') }}
        </h1>
        <p class="text-slate-500 mt-1">{{ count($sale->items) }} Varian Menu &bull; Total {{ $sale->total_items }} Porsi Terjual</p>
    </div>
    <div>
        <!-- Aksi tambahan jika diperlukan -->
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
    <!-- Bagian Kiri: Daftar Menu ->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                <i class="mdi mdi-clipboard-check text-xl text-blue-500"></i>
                Menu Terjual
            </h2>
        </div>
        <div class="divide-y divide-slate-100">
            @foreach($sale->items as $item)
            <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition">
                <div>
                    <h3 class="font-medium text-slate-800">{{ $item->menu->name ?? 'Menu Terhapus' }}</h3>
                    <p class="text-xs text-slate-500 capitalize">{{ $item->menu->category ?? '-' }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                        {{ $item->quantity }} Porsi
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Bagian Kanan: Kalkulasi Bahan Baku -->
    <div class="bg-slate-800 rounded-xl shadow-md border border-slate-700 overflow-hidden text-slate-100 relative">
        <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
            <i class="mdi mdi-chart-bar text-9xl text-white"></i>
        </div>
        <div class="px-6 py-5 border-b border-slate-700 bg-slate-900/50 backdrop-blur-sm relative z-10">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="mdi mdi-flash text-xl text-yellow-400"></i>
                Total Konsumsi Bahan Baku
            </h2>
            <p class="text-sm text-slate-400 mt-1">Kalkulasi otomatis berdasarkan parameter resep x quantity terjual.</p>
        </div>
        
        <div class="p-6 relative z-10">
            @if($ingredientUsage->isEmpty())
                <div class="bg-slate-700/50 p-4 rounded border border-slate-600 text-center">
                    Tidak ada penggunaan bahan baku, pastikan menu yang terjual sudah memiliki resep komposisi.
                </div>
            @else
                <div class="space-y-4">
                    @foreach($ingredientUsage as $usage)
                        <div>
                            <div class="flex justify-between items-end mb-1">
                                <span class="font-medium text-slate-200">{{ $usage->name }}</span>
                                <span class="text-lg font-bold text-emerald-400 font-mono">{{ (float) $usage->total_used }} <span class="text-xs text-slate-400 font-sans ml-0.5">{{ $usage->unit }}</span></span>
                            </div>
                            <div class="w-full bg-slate-700 rounded-full h-1.5">
                                <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-1.5 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
