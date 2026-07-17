@extends('app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
    <!-- Total Menus -->
    <div class="stat-card">
        <div class="stat-icon bg-rausch-light text-rausch">
            <i class="mdi mdi-book-open-page-variant"></i>
        </div>
        <div>
            <p class="text-body-sm text-muted mb-0.5">Total Menu</p>
            <p class="text-display-sm text-ink">{{ number_format($totalMenus) }}</p>
        </div>
    </div>

    <!-- Total Ingredients -->
    <div class="stat-card">
        <div class="stat-icon bg-green-50 text-green-600">
            <i class="mdi mdi-package-variant-closed"></i>
        </div>
        <div>
            <p class="text-body-sm text-muted mb-0.5">Bahan Baku</p>
            <p class="text-display-sm text-ink">{{ number_format($totalIngredients) }}</p>
        </div>
    </div>

    <!-- Hitung Cepat -->
    <a href="{{ route('calculator.index') }}" class="stat-card group cursor-pointer hover:border-rausch">
        <div class="stat-icon bg-orange-50 text-orange-500 group-hover:bg-rausch-light group-hover:text-rausch transition">
            <i class="mdi mdi-calculator-variant"></i>
        </div>
        <div>
            <p class="text-body-sm text-muted mb-0.5">Hitung Cepat</p>
            <p class="text-display-sm text-ink">{{ number_format($totalCalculatorLogs) }}</p>
        </div>
    </a>

    <!-- Total Portions -->
    <div class="stat-card">
        <div class="stat-icon bg-purple-50 text-purple-600">
            <i class="mdi mdi-cart"></i>
        </div>
        <div>
            <p class="text-body-sm text-muted mb-0.5">Porsi Terjual</p>
            <p class="text-display-sm text-ink">{{ number_format($totalPortions) }}</p>
        </div>
    </div>
</div>

<!-- Rekap Hitung Cepat -->
<div>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="section-heading flex items-center gap-2">
                <i class="mdi mdi-calculator-variant text-2xl text-rausch"></i>
                Rekap Hitung Bahan
            </h2>
            <p class="text-muted mt-1 text-body-sm">Riwayat bahan baku yang terpakai.</p>
        </div>
        <a href="{{ route('calculator.index') }}" class="btn-primary btn-sm">
            <i class="mdi mdi-plus text-lg"></i>
            Hitung Baru
        </a>
    </div>

    @if($calculatorLogs->isEmpty())
    <div class="card p-10">
        <div class="empty-state">
            <i class="mdi mdi-file-document-outline empty-state-icon"></i>
            <h3 class="empty-state-title">Belum Ada Rekap Bahan</h3>
            <p class="empty-state-text">Mulai hitung bahan lalu klik Simpan.</p>
            <a href="{{ route('calculator.index') }}" class="btn-primary btn-sm mt-2">
                Mulai Hitung
                <i class="mdi mdi-arrow-right text-lg"></i>
            </a>
        </div>
    </div>
    @else
    <div class="space-y-8">
        @foreach($calculatorLogs as $date => $dayLogs)
        <div>
            <!-- Tanggal Header -->
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-airbnb-sm bg-rausch-light flex items-center justify-center">
                    <i class="mdi mdi-calendar text-lg text-rausch"></i>
                </div>
                <div>
                    <h3 class="text-title-md text-ink">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</h3>
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
                                    <h4 class="text-title-md text-ink group-hover:text-rausch transition">{{ $log->name }}</h4>
                                    <span class="badge-airbnb bg-rausch-light text-rausch mt-1">
                                        <i class="mdi mdi-clock-outline text-xs mr-0.5"></i>
                                        {{ $log->shift }}
                                    </span>
                                </div>
                                <span class="text-caption-sm text-muted">{{ $log->created_at->format('H:i') }}</span>
                            </div>
                        </div>

                        <!-- Card Body -->
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
</div>
@endsection
