@extends('app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Laporan Kalkulasi Bahan Baku</h1>
        <p class="text-slate-500 mt-1">Rekap data total konsumsi bahan berdasarkan rentang waktu penjualan.</p>
    </div>
    
    <!-- Filter Date Form -->
    <div class="bg-white p-1 rounded-lg border border-slate-200 shadow-sm inline-flex">
        <form action="{{ route('reports.index') }}" method="GET" class="flex items-center gap-2">
            <input type="date" name="date_from" value="{{ $dateFrom }}" class="text-sm border-0 focus:ring-0 px-3 py-1.5 bg-transparent cursor-pointer font-medium text-slate-700 outline-none">
            <span class="text-slate-300">-</span>
            <input type="date" name="date_to" value="{{ $dateTo }}" class="text-sm border-0 focus:ring-0 px-3 py-1.5 bg-transparent cursor-pointer font-medium text-slate-700 outline-none">
            <button type="submit" class="bg-primary text-white p-1.5 rounded-md hover:bg-primary-dark transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
    </div>
</div>

<!-- Statistik Singkat -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <p class="text-sm text-slate-500 font-medium">Rentang Waktu</p>
        <p class="text-lg font-bold text-slate-800 mt-1">{{ \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d/m/Y') }}</p>
    </div>
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <p class="text-sm text-slate-500 font-medium">Banyak Transaksi</p>
        <p class="text-lg font-bold text-slate-800 mt-1">{{ number_format($totalSales) }} <span class="text-xs text-slate-400 font-normal">Sesi/Hari</span></p>
    </div>
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <p class="text-sm text-slate-500 font-medium">Menu Terjual</p>
        <p class="text-lg font-bold text-slate-800 mt-1">{{ number_format($totalPortions) }} <span class="text-xs text-slate-400 font-normal">Porsi</span></p>
    </div>
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <p class="text-sm text-slate-500 font-medium">Jenis Bahan Digunakan</p>
        <p class="text-lg font-bold text-slate-800 mt-1">{{ $ingredientUsage->count() }} <span class="text-xs text-slate-400 font-normal">Item</span></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Kolom Utama: Total Keseluruhan Penggunaan Bahan -->
    <div class="lg:col-span-1">
        <div class="bg-slate-800 rounded-xl shadow-md border border-slate-700 overflow-hidden text-slate-100 sticky top-24">
            <div class="px-6 py-5 border-b border-slate-700 bg-slate-900/50 backdrop-blur-sm">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Total Akumulasi Bahan
                </h2>
                <p class="text-xs text-slate-400 mt-1">Akumulasi total persediaan yang harus disiapkan / telah dikurangi dari stok.</p>
            </div>
            
            <div class="p-0">
                @if($ingredientUsage->isEmpty())
                    <div class="p-6 text-center text-slate-400">Tidak ada data untuk rentang tanggal ini.</div>
                @else
                    <ul class="divide-y divide-slate-700/50">
                        @foreach($ingredientUsage as $usage)
                            <li class="px-6 py-4 flex justify-between items-center hover:bg-slate-700/30 transition">
                                <span class="font-medium text-slate-200">{{ $usage->ingredient_name }}</span>
                                <span class="font-mono text-emerald-400 font-bold bg-slate-900/50 px-2 py-1 rounded">
                                    {{ (float) $usage->total_used }} <span class="text-xs ml-1 font-sans text-slate-500">{{ $usage->unit }}</span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Breakdown Rincian Bahan / Menu -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Breakdown Pemakaian Bahan Baku di Setiap Menu -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Rincian (Breakdown) Pemakaian Khusus
                </h2>
                <p class="text-xs text-slate-500 mt-1">Melacak dari mana saja suatu bahan baku termakan habis</p>
            </div>

            <div class="p-6">
                 @if(count($breakdown) == 0)
                    <div class="text-center text-slate-500 py-8">Tidak ada rincian data.</div>
                 @else
                    <div class="space-y-6">
                        @foreach($breakdown as $ingredientName => $items)
                        <div class="border border-slate-200 rounded-lg overflow-hidden">
                            <div class="bg-slate-100 px-4 py-2 font-bold text-slate-800 flex justify-between items-center">
                                <span>{{ $ingredientName }}</span>
                                @php $unit = $items->first()->unit; $sum = $items->sum('subtotal_used') @endphp
                                <span class="text-sm bg-white px-2 py-0.5 rounded border border-slate-200 text-primary">Total: {{ (float) $sum }} {{ $unit }}</span>
                            </div>
                            <table class="w-full text-sm text-left text-slate-600">
                                <tbody>
                                    @foreach($items as $item)
                                    <tr class="border-t border-slate-100 hover:bg-slate-50 text-xs sm:text-sm">
                                        <td class="px-4 py-2 text-slate-700 w-1/2">{{ $item->menu_name }}</td>
                                        <td class="px-4 py-2 text-slate-400 hidden sm:table-cell">{{ $item->total_qty_sold }}x pesan &bull; Resep: {{ (float) $item->recipe_qty }}</td>
                                        <td class="px-4 py-2 font-medium text-slate-800 text-right">= {{ (float) $item->subtotal_used }} {{ $unit }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Rekap Menu Terjual -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Penyumbang Penjualan (Menu)
                </h2>
            </div>
            
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/50 text-xs uppercase text-slate-500 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">Menu</th>
                        <th scope="col" class="px-6 py-3 font-medium">Kategori</th>
                        <th scope="col" class="px-6 py-3 font-medium text-right">Porsi Terjual</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($menuSales as $ms)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-3 font-medium text-slate-800">{{ $ms->menu_name }}</td>
                            <td class="px-6 py-3 capitalize">{{ $ms->category }}</td>
                            <td class="px-6 py-3 text-right font-bold text-emerald-600">{{ number_format($ms->total_qty) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-center text-slate-500">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
