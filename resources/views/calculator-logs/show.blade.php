@extends('app')

@section('content')
<div class="mb-6">
    <a href="{{ route('calculator-logs.index') }}" class="btn-primary btn-sm mb-4">
        <i class="mdi mdi-chevron-left text-lg"></i>
        Kembali ke Daftar Rekap
    </a>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-heading">Detail Rekap Kalkulasi</h1>
            <p class="text-muted mt-1 text-body-sm">Disimpan pada {{ $calculator_log->created_at->translatedFormat('l, d F Y \p\u\k\u\l H:i') }}</p>
        </div>
        <form action="{{ route('calculator-logs.destroy', $calculator_log) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rekap ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-1.5 bg-rausch-light hover:bg-red-100 text-rausch text-body-sm px-4 py-2 rounded-airbnb-sm transition font-medium border border-rausch/20">
                <i class="mdi mdi-delete text-lg"></i>
                Hapus Rekap
            </button>
        </form>
    </div>
</div>

<!-- Info Card -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="card p-5">
        <p class="text-micro-label text-muted uppercase tracking-wider mb-1">Nama Operator</p>
        <p class="text-title-md text-ink">{{ $calculator_log->name }}</p>
    </div>
    <div class="card p-5">
        <p class="text-micro-label text-muted uppercase tracking-wider mb-1">Shift</p>
        <p class="text-title-md text-rausch">{{ $calculator_log->shift }}</p>
    </div>
    <div class="card p-5">
        <p class="text-micro-label text-muted uppercase tracking-wider mb-1">Tanggal</p>
        <p class="text-title-md text-ink">{{ $calculator_log->log_date->format('d/m/Y') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <!-- Menu yang Dihitung -->
    <div class="card">
        <div class="card-header">
            <h2 class="text-display-sm text-ink flex items-center gap-2">
                <i class="mdi mdi-clipboard-text text-xl text-rausch"></i>
                Menu yang Dihitung
            </h2>
            <p class="text-caption-sm text-muted mt-0.5">{{ count($calculator_log->menus_data) }} menu &bull; {{ collect($calculator_log->menus_data)->sum('qty') }} total porsi</p>
        </div>
        <div class="divide-y divide-hairline-soft">
            @foreach($calculator_log->menus_data as $menu)
            <div class="px-6 py-3.5 flex items-center justify-between hover:bg-surface-soft transition">
                <span class="font-medium text-ink">{{ $menu['name'] }}</span>
                <span class="bg-rausch-light text-rausch font-bold px-3 py-1 rounded-pill text-body-sm">{{ $menu['qty'] }}x</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Bahan yang Terpakai -->
    <div class="card shadow-airbnb">
        <div class="card-header">
            <h2 class="text-display-sm text-ink flex items-center gap-2">
                <i class="mdi mdi-flash text-xl text-rausch"></i>
                Bahan yang Terpakai
            </h2>
            <p class="text-caption-sm text-muted mt-1">{{ count($calculator_log->ingredients_data) }} jenis bahan baku</p>
        </div>
        
        <div class="p-0">
            <ul class="divide-y divide-hairline-soft">
                @foreach($calculator_log->ingredients_data as $ing)
                <li class="px-6 py-4 flex justify-between items-center hover:bg-surface-soft transition">
                    <span class="font-medium text-ink">
                        <span class="text-rausch font-bold mr-1">•</span>
                        {{ $ing['name'] }}
                    </span>
                    <span class="font-mono text-rausch font-bold bg-rausch-light px-2.5 py-1 rounded-airbnb-sm">
                        {{ $ing['amount'] }} <span class="text-caption-sm ml-1 font-sans text-muted">{{ $ing['unit'] }}</span>
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
