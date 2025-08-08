@extends('app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Menus -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center transition-transform hover:-translate-y-1 duration-300">
        <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4">
            <i class="mdi mdi-book-open-page-variant text-3xl"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Menu</p>
            <p class="text-2xl font-bold text-slate-800">{{ number_format($totalMenus) }}</p>
        </div>
    </div>

    <!-- Total Ingredients -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center transition-transform hover:-translate-y-1 duration-300">
        <div class="p-3 rounded-full bg-emerald-50 text-emerald-600 mr-4">
            <i class="mdi mdi-package-variant-closed text-3xl"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Bahan Baku</p>
            <p class="text-2xl font-bold text-slate-800">{{ number_format($totalIngredients) }}</p>
        </div>
    </div>

    <!-- Hitung Cepat -->
    <a href="{{ route('calculator.index') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center transition-all hover:-translate-y-1 hover:border-orange-300 hover:shadow-md duration-300 cursor-pointer">
        <div class="p-3 rounded-full bg-orange-50 text-orange-600 mr-4">
            <i class="mdi mdi-calculator-variant text-3xl"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Hitung Cepat</p>
            <p class="text-2xl font-bold text-slate-800">{{ number_format($totalCalculatorLogs) }}</p>
        </div>
    </a>

    <!-- Total Portions -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center transition-transform hover:-translate-y-1 duration-300">
        <div class="p-3 rounded-full bg-purple-50 text-purple-600 mr-4">
            <i class="mdi mdi-cart text-3xl"></i>
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
                <i class="mdi mdi-calculator-variant text-2xl text-emerald-500"></i>
                Rekap Hitung Bahan
            </h2>
            <p class="text-slate-500 mt-1 text-sm">Riwayat bahan baku yang terpakai.</p>
        </div>
        <a href="{{ route('calculator.index') }}" class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm px-4 py-2 rounded-lg transition font-medium shadow-sm">
            <i class="mdi mdi-plus text-lg"></i>
            Hitung Baru
        </a>
    </div>

    @if($calculatorLogs->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-10 text-center">
        <i class="mdi mdi-file-document-outline text-5xl text-slate-300"></i>
        <h3 class="text-base font-semibold text-slate-600 mb-1">Belum Ada Rekap Bahan</h3>
        <p class="text-sm text-slate-400 mb-4">Mulai hitung bahan lalu klik Simpan.</p>
        <a href="{{ route('calculator.index') }}" class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm px-5 py-2.5 rounded-lg transition font-medium">
            Mulai Hitung
            <i class="mdi mdi-arrow-right text-lg"></i>
        </a>
    </div>
    @else
    <div class="space-y-8">
        @foreach($calculatorLogs as $date => $dayLogs)
        <div>
            <!-- Tanggal Header -->
            <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center">
                    <i class="mdi mdi-calendar text-lg text-emerald-500"></i>
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
                                        <i class="mdi mdi-clock-outline text-xs"></i>
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
                            <i class="mdi mdi-chevron-right text-lg text-slate-300 group-hover:text-emerald-500 group-hover:translate-x-0.5 transition-all"></i>
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
