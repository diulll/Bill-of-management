@extends('app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <a href="{{ route('sales.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 flex items-center gap-1 w-fit transition mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
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
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
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
            <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/><path d="M7 12h2v5H7zm4-3h2v8h-2zm4-3h2v11h-2z"/></svg>
        </div>
        <div class="px-6 py-5 border-b border-slate-700 bg-slate-900/50 backdrop-blur-sm relative z-10">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
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
