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

<!-- Rekap Hitung Cepat -->
<div>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                Rekap Hitung Bahan
            </h2>
            <p class="text-slate-500 mt-1 text-sm">Riwayat bahan baku yang terpakai.</p>
        </div>
        <a href="{{ route('calculator.index') }}" class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm px-4 py-2 rounded-lg transition font-medium shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Hitung Baru
        </a>
    </div>

    @if($calculatorLogs->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-10 text-center">
        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        <h3 class="text-base font-semibold text-slate-600 mb-1">Belum Ada Rekap Bahan</h3>
        <p class="text-sm text-slate-400 mb-4">Mulai hitung bahan lalu klik Simpan.</p>
        <a href="{{ route('calculator.index') }}" class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm px-5 py-2.5 rounded-lg transition font-medium">
            Mulai Hitung
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
        </a>
    </div>
    @else
    <div class="space-y-8">
        @foreach($calculatorLogs as $date => $dayLogs)
        <div>
            <!-- Tanggal Header -->
            <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</h3>
                    <p class="text-xs text-slate-400">{{ $dayLogs->count() }} rekap</p>
                </div>
            </div>

            <!-- List Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($dayLogs as $log)
                <a href="{{ route('calculator-logs.show', $log) }}" class="block group">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-200 overflow-hidden">
                        <!-- Card Header -->
                        <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="font-bold text-slate-800 group-hover:text-emerald-600 transition">{{ $log->name }}</h4>
                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full mt-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $log->shift }}
                                    </span>
                                </div>
                                <span class="text-xs text-slate-400">{{ $log->created_at->format('H:i') }}</span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="px-5 py-3">
                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-2">Menu Dihitung</p>
                            <div class="flex flex-wrap gap-1 mb-3">
                                @foreach(array_slice($log->menus_data, 0, 3) as $menu)
                                    <span class="text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded">{{ $menu['qty'] }}x {{ $menu['name'] }}</span>
                                @endforeach
                                @if(count($log->menus_data) > 3)
                                    <span class="text-xs text-slate-400">+{{ count($log->menus_data) - 3 }} lainnya</span>
                                @endif
                            </div>

                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-1">Bahan Terpakai</p>
                            <p class="text-sm font-semibold text-emerald-600">{{ count($log->ingredients_data) }} jenis bahan</p>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs text-slate-400">Klik untuk detail</span>
                            <svg class="w-4 h-4 text-slate-300 group-hover:text-emerald-500 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
