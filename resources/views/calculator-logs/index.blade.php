@extends('app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-heading">Rekap Hitung Cepat</h1>
        <p class="text-muted mt-1 text-body-sm">Riwayat kalkulasi bahan baku yang telah disimpan dari Hitung Cepat.</p>
    </div>
    
    <div class="flex gap-2">
        <!-- Filter Tanggal -->
        <div class="card p-1 shadow-airbnb inline-flex">
            <form action="{{ route('calculator-logs.index') }}" method="GET" class="flex items-center gap-2">
                <input type="date" name="date" value="{{ $dateFilter ?? '' }}" class="text-body-sm border-0 focus:ring-0 px-3 py-1.5 bg-transparent cursor-pointer font-medium text-ink outline-none">
                <button type="submit" class="search-orb w-9 h-9">
                    <i class="mdi mdi-magnify text-lg"></i>
                </button>
                @if($dateFilter)
                <a href="{{ route('calculator-logs.index') }}" class="text-caption-sm text-muted hover:text-rausch transition px-1" title="Hapus filter">&times;</a>
                @endif
            </form>
        </div>
        <a href="{{ route('calculator.index') }}" class="btn-primary btn-sm">
            <i class="mdi mdi-plus text-lg"></i>
            Hitung Baru
        </a>
    </div>
</div>

@if($logs->isEmpty())
<div class="card p-12">
    <div class="empty-state">
        <i class="mdi mdi-file-document-outline empty-state-icon"></i>
        <h3 class="empty-state-title">Belum Ada Rekap</h3>
        <p class="empty-state-text mb-4">Mulai hitung bahan di halaman Hitung Cepat, lalu klik Simpan.</p>
        <a href="{{ route('calculator.index') }}" class="btn-primary btn-sm">
            Mulai Hitung
            <i class="mdi mdi-arrow-right text-lg"></i>
        </a>
    </div>
</div>
@else

<div class="space-y-8">
    @foreach($logs as $date => $dayLogs)
    <div>
        <!-- Tanggal Header -->
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-airbnb-sm bg-rausch-light flex items-center justify-center">
                <i class="mdi mdi-calendar text-xl text-rausch"></i>
            </div>
            <div>
                <h2 class="text-title-md text-ink">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</h2>
                <p class="text-caption-sm text-muted">{{ $dayLogs->count() }} rekap</p>
            </div>
        </div>

        <!-- List Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($dayLogs as $log)
            <a href="{{ route('calculator-logs.show', $log) }}" class="block group">
                <div class="card card-hover">
                    <!-- Card Header -->
                    <div class="px-5 py-4 border-b border-hairline-soft bg-surface-soft">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-title-md text-ink group-hover:text-rausch transition">{{ $log->name }}</h3>
                                <span class="badge-airbnb bg-rausch-light text-rausch mt-1">
                                    <i class="mdi mdi-clock-outline text-xs mr-0.5"></i>
                                    {{ $log->shift }}
                                </span>
                            </div>
                            <span class="text-caption-sm text-muted">{{ $log->created_at->format('H:i') }}</span>
                        </div>
                    </div>

                    <!-- Card Body: Preview bahan -->
                    <div class="px-5 py-3">
                        <p class="text-micro-label uppercase tracking-wider text-muted mb-2">Menu Dihitung</p>
                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach(array_slice($log->menus_data, 0, 3) as $menu)
                                <span class="text-badge bg-surface-strong text-body px-2 py-0.5 rounded-airbnb-sm">{{ $menu['qty'] }}x {{ $menu['name'] }}</span>
                            @endforeach
                            @if(count($log->menus_data) > 3)
                                <span class="text-badge text-muted">+{{ count($log->menus_data) - 3 }} lainnya</span>
                            @endif
                        </div>

                        <p class="text-micro-label uppercase tracking-wider text-muted mb-1">Bahan Terpakai</p>
                        <p class="text-body-sm font-semibold text-rausch">{{ count($log->ingredients_data) }} jenis bahan</p>
                    </div>

                    <!-- Card Footer -->
                    <div class="px-5 py-3 bg-surface-soft border-t border-hairline-soft flex items-center justify-between">
                        <span class="text-caption-sm text-muted">Klik untuk detail</span>
                        <i class="mdi mdi-chevron-right text-lg text-hairline group-hover:text-rausch group-hover:translate-x-0.5 transition-all"></i>
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
