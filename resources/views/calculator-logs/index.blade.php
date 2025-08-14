@extends('app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Rekap Hitung Cepat</h1>
        <p class="text-slate-500 mt-1">Riwayat kalkulasi bahan baku yang telah disimpan dari Hitung Cepat.</p>
    </div>
    
    <div class="flex gap-2">
        <!-- Filter Tanggal -->
        <div class="bg-white p-1 rounded-lg border border-slate-200 shadow-sm inline-flex">
            <form action="{{ route('calculator-logs.index') }}" method="GET" class="flex items-center gap-2">
                <input type="date" name="date" value="{{ $dateFilter ?? '' }}" class="text-sm border-0 focus:ring-0 px-3 py-1.5 bg-transparent cursor-pointer font-medium text-slate-700 outline-none">
                <button type="submit" class="bg-primary text-white p-1.5 rounded-md hover:bg-primary-dark transition">
                    <i class="mdi mdi-magnify text-lg"></i>
                </button>
                @if($dateFilter)
                <a href="{{ route('calculator-logs.index') }}" class="text-xs text-slate-400 hover:text-red-500 transition px-1" title="Hapus filter">&times;</a>
                @endif
            </form>
        </div>
        <a href="{{ route('calculator.index') }}" class="inline-flex items-center gap-1.5 bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-2 rounded-lg transition-all duration-150 font-medium shadow-sm active:scale-95 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2">
            <i class="mdi mdi-plus text-lg"></i>
            Hitung Baru
        </a>
    </div>
</div>

@if($logs->isEmpty())
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
    <i class="mdi mdi-file-document-outline text-6xl text-slate-300 mx-auto mb-4"></i>
    <h3 class="text-lg font-semibold text-slate-600 mb-1">Belum Ada Rekap</h3>
    <p class="text-sm text-slate-400 mb-4">Mulai hitung bahan di halaman Hitung Cepat, lalu klik Simpan.</p>
    <a href="{{ route('calculator.index') }}" class="inline-flex items-center gap-1.5 bg-primary hover:bg-primary-dark text-white text-sm px-5 py-2.5 rounded-lg transition font-medium">
        Mulai Hitung
        <i class="mdi mdi-arrow-right text-lg"></i>
    </a>
</div>
@else

<div class="space-y-8">
    @foreach($logs as $date => $dayLogs)
    <div>
        <!-- Tanggal Header -->
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                <i class="mdi mdi-calendar text-xl text-primary"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-800">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</h2>
                <p class="text-xs text-slate-400">{{ $dayLogs->count() }} rekap</p>
            </div>
        </div>

        <!-- List Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($dayLogs as $log)
            <a href="{{ route('calculator-logs.show', $log) }}" class="block group">
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-primary/30 transition-all duration-200 overflow-hidden">
                    <!-- Card Header -->
                    <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-bold text-slate-800 group-hover:text-primary transition">{{ $log->name }}</h3>
                                <span class="inline-flex items-center gap-1 text-xs font-medium text-primary bg-primary/10 px-2 py-0.5 rounded-full mt-1">
                                    <i class="mdi mdi-clock-outline text-xs"></i>
                                    {{ $log->shift }}
                                </span>
                            </div>
                            <span class="text-xs text-slate-400">{{ $log->created_at->format('H:i') }}</span>
                        </div>
                    </div>

                    <!-- Card Body: Preview bahan -->
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
                        <i class="mdi mdi-chevron-right text-lg text-slate-300 group-hover:text-primary group-hover:translate-x-0.5 transition-all"></i>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

@endif
@endsection
