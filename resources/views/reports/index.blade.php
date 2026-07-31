@extends('app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-heading">Laporan Kalkulasi Bahan Baku</h1>
        <p class="text-muted mt-1 text-body-sm">Rekap data total konsumsi bahan berdasarkan rentang waktu penjualan.</p>
    </div>
    
    <!-- Filter Date Form -->
    <div class="card p-1 inline-flex shadow-airbnb">
        <form action="{{ route('reports.index') }}" method="GET" class="flex items-center gap-2">
            <input type="date" name="date_from" value="{{ $dateFrom }}" class="text-body-sm border-0 focus:ring-0 px-3 py-1.5 bg-transparent cursor-pointer font-medium text-ink outline-none">
            <span class="text-hairline">-</span>
            <input type="date" name="date_to" value="{{ $dateTo }}" class="text-body-sm border-0 focus:ring-0 px-3 py-1.5 bg-transparent cursor-pointer font-medium text-ink outline-none">
            <button type="submit" class="search-orb w-9 h-9">
                <i class="mdi mdi-magnify text-lg"></i>
            </button>
        </form>
    </div>
</div>

<!-- Statistik Singkat -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="card p-4">
        <p class="text-body-sm text-muted font-medium">Rentang Waktu</p>
        <p class="text-title-md text-ink mt-1">{{ \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d/m/Y') }}</p>
    </div>
    <div class="card p-4">
        <p class="text-body-sm text-muted font-medium">Banyak Transaksi</p>
        <p class="text-title-md text-ink mt-1">{{ number_format($totalSales) }} <span class="text-caption-sm text-muted font-normal">Sesi/Hari</span></p>
    </div>
    <div class="card p-4">
        <p class="text-body-sm text-muted font-medium">Menu Terjual</p>
        <p class="text-title-md text-ink mt-1">{{ number_format($totalPortions) }} <span class="text-caption-sm text-muted font-normal">Porsi</span></p>
    </div>
    <div class="card p-4">
        <p class="text-body-sm text-muted font-medium">Jenis Bahan Digunakan</p>
        <p class="text-title-md text-ink mt-1">{{ $ingredientUsage->count() }} <span class="text-caption-sm text-muted font-normal">Item</span></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Kolom Utama: Total Keseluruhan Penggunaan Bahan -->
    <div class="lg:col-span-1">
        <div class="card shadow-airbnb sticky top-24">
            <div class="card-header">
                <h2 class="text-display-sm text-ink flex items-center gap-2">
                    <i class="mdi mdi-flash text-xl text-rausch"></i>
                    Total Akumulasi Bahan
                </h2>
                <p class="text-caption-sm text-muted mt-1">Akumulasi total persediaan yang harus disiapkan / telah dikurangi dari stok.</p>
            </div>
            
            <div class="p-0">
                @if($ingredientUsage->isEmpty())
                    <div class="p-6 text-center text-muted text-body-sm">Tidak ada data untuk rentang tanggal ini.</div>
                @else
                    <ul class="divide-y divide-hairline-soft">
                        @foreach($ingredientUsage as $usage)
                            <li class="px-6 py-4 flex justify-between items-center hover:bg-surface-soft transition">
                                <span class="font-medium text-ink">{{ $usage->ingredient_name }}</span>
                                <span class="font-mono text-rausch font-bold bg-rausch-light px-2.5 py-1 rounded-airbnb-sm">
                                    {{ (float) $usage->total_used }} <span class="text-caption-sm ml-1 font-sans text-muted">{{ $usage->unit }}</span>
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
        <div class="card">
            <div class="card-header">
                <h2 class="text-display-sm text-ink flex items-center gap-2">
                    <i class="mdi mdi-view-grid text-xl text-rausch"></i>
                    Rincian (Breakdown) Pemakaian Khusus
                </h2>
                <p class="text-caption-sm text-muted mt-1">Melacak dari mana saja suatu bahan baku termakan habis</p>
            </div>

            <div class="card-body">
                 @if(count($breakdown) == 0)
                    <div class="text-center text-muted py-8 text-body-sm">Tidak ada rincian data.</div>
                 @else
                    <div class="space-y-6">
                        @foreach($breakdown as $ingredientName => $items)
                        <div class="border border-hairline rounded-airbnb-sm overflow-hidden">
                            <div class="bg-surface-soft px-4 py-3 font-bold text-ink flex justify-between items-center text-body-sm">
                                <span>{{ $ingredientName }}</span>
                                @php $unit = $items->first()->unit; $sum = $items->sum('subtotal_used') @endphp
                                <span class="text-body-sm bg-canvas px-2.5 py-0.5 rounded-airbnb-sm border border-hairline text-rausch font-bold">Total: {{ (float) $sum }} {{ $unit }}</span>
                            </div>
                            <table class="w-full text-body-sm text-left text-body">
                                <tbody>
                                    @foreach($items as $item)
                                    <tr class="border-t border-hairline-soft hover:bg-surface-soft text-caption-sm sm:text-body-sm">
                                        <td class="px-4 py-2.5 text-ink w-1/2">{{ $item->menu_name }}</td>
                                        <td class="px-4 py-2.5 text-muted hidden sm:table-cell">{{ $item->total_qty_sold }}x pesan &bull; Resep: {{ (float) $item->recipe_qty }}</td>
                                        <td class="px-4 py-2.5 font-medium text-ink text-right">= {{ (float) $item->subtotal_used }} {{ $unit }}</td>
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
        <div class="card">
            <div class="card-header">
                <h2 class="text-display-sm text-ink flex items-center gap-2">
                    <i class="mdi mdi-shopping text-xl text-rausch"></i>
                    Penyumbang Penjualan (Menu)
                </h2>
            </div>
            
            <table class="table-airbnb">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Kategori</th>
                        <th class="text-right">Porsi Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menuSales as $ms)
                        <tr>
                            <td class="font-medium text-ink">{{ $ms->menu_name }}</td>
                            <td class="capitalize">{{ $ms->category }}</td>
                            <td class="text-right font-bold text-rausch">{{ number_format($ms->total_qty) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-6">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- ══════════════════════════════════════════ -->
<!-- Rekap Hitung Cepat -->
<!-- ══════════════════════════════════════════ -->
<div class="mt-12">
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
            <h3 class="empty-state-title">Belum Ada Rekap</h3>
            <p class="empty-state-text">Mulai hitung bahan lalu klik Simpan.</p>
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
