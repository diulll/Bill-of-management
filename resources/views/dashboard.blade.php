@extends('app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Menus -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center transition-transform hover:-translate-y-1 duration-300">
        <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Menu</p>
            <p class="text-2xl font-bold text-slate-800">{{ number_format($totalMenus) }}</p>
        </div>
    </div>

    <!-- Total Ingredients -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center transition-transform hover:-translate-y-1 duration-300">
        <div class="p-3 rounded-full bg-emerald-50 text-emerald-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Bahan Baku</p>
            <p class="text-2xl font-bold text-slate-800">{{ number_format($totalIngredients) }}</p>
        </div>
    </div>

    <!-- Total Sales -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center transition-transform hover:-translate-y-1 duration-300">
        <div class="p-3 rounded-full bg-orange-50 text-orange-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Transaksi</p>
            <p class="text-2xl font-bold text-slate-800">{{ number_format($totalSales) }}</p>
        </div>
    </div>

    <!-- Total Portions -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center transition-transform hover:-translate-y-1 duration-300">
        <div class="p-3 rounded-full bg-purple-50 text-purple-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Porsi Terjual</p>
            <p class="text-2xl font-bold text-slate-800">{{ number_format($totalPortions) }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Top Menus -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                Menu Terlaris (Top 5)
            </h2>
        </div>
        <div class="p-6">
            @if($topMenus->isEmpty())
                <p class="text-slate-500 text-center py-4">Belum ada data penjualan.</p>
            @else
                <div class="space-y-4">
                    @foreach($topMenus as $key => $menu)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full {{ $key == 0 ? 'bg-yellow-100 text-yellow-700 font-bold' : ($key == 1 ? 'bg-slate-100 text-slate-700 font-bold' : ($key == 2 ? 'bg-orange-100 text-orange-700 font-bold' : 'bg-slate-50 text-slate-500 text-sm')) }}">
                                    {{ $key + 1 }}
                                </span>
                                <span class="font-medium text-slate-700">{{ $menu->name }}</span>
                            </div>
                            <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-sm font-medium border border-green-100">
                                {{ number_format($menu->total_qty) }} Porsi
                            </span>
                        </div>
                        @if(!$loop->last)
                            <hr class="border-slate-100">
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Top Ingredients -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Bahan Baku Dominan (Top 5)
            </h2>
        </div>
        <div class="p-6">
            @if($topIngredients->isEmpty())
                <p class="text-slate-500 text-center py-4">Belum ada data penggunaan bahan.</p>
            @else
                <div class="space-y-4">
                    @foreach($topIngredients as $ingredient)
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-slate-700">{{ $ingredient->name }}</span>
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm font-medium border border-blue-100">
                                {{ number_format($ingredient->total_used, 2) }} {{ $ingredient->unit }}
                            </span>
                        </div>
                        @if(!$loop->last)
                            <hr class="border-slate-100">
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Recent Sales -->
<div class="mt-8 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Penjualan Terakhir
        </h2>
        <a href="{{ route('sales.index') }}" class="text-sm font-medium text-primary hover:text-primary-dark transition">Lihat Semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50/50 text-xs uppercase text-slate-500 border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">Tanggal</th>
                    <th scope="col" class="px-6 py-3 font-medium">Total Menu Item</th>
                    <th scope="col" class="px-6 py-3 font-medium">Total Porsi</th>
                    <th scope="col" class="px-6 py-3 font-medium">Catatan</th>
                    <th scope="col" class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($recentSales as $sale)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-800">{{ $sale->sale_date->format('d M Y') }}</td>
                    <td class="px-6 py-4">{{ $sale->items_count }} Menu</td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">{{ $sale->items_sum_quantity ?? 0 }} Porsi</span></td>
                    <td class="px-6 py-4 text-slate-500 italic max-w-xs truncate">{{ $sale->notes ?: '-' }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('sales.show', $sale) }}" class="text-primary hover:text-primary-dark font-medium transition">Detail Kalkulasi</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <p>Belum ada transaksi penjualan.</p>
                            <a href="{{ route('sales.create') }}" class="mt-4 inline-flex items-center justify-center rounded-lg border border-transparent bg-orange-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition gap-2">Input Penjualan Baru &rarr;</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
