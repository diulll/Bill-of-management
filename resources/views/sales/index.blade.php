@extends('app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Catat Penjualan Harian</h1>
        <p class="text-slate-500 mt-1">Input data menu yang terjual untuk mengkalkulasi bahan baku.</p>
    </div>
    <div>
        <a href="{{ route('sales.create') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 active:scale-95 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2 transition-all duration-150 w-full sm:w-auto">
            <i class="mdi mdi-plus text-lg mr-1"></i>
            Buat Penjualan Baru
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50/50 text-xs uppercase text-slate-500 border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold w-12 text-center">ID</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">Variasi Menu</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">Total Porsi</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($sales as $sale)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-500 text-center">#{{ $sale->id }}</td>
                    <td class="px-6 py-4 font-medium text-slate-800">
                        {{ $sale->sale_date->format('d M Y') }}
                        @if($sale->notes)
                            <p class="text-xs text-slate-400 font-normal mt-0.5 truncate max-w-[200px]">{{ $sale->notes }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $sale->items_count }} Menu</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">{{ $sale->items_sum_quantity ?? 0 }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('sales.show', $sale) }}" class="text-primary hover:text-primary-dark font-medium transition flex items-center gap-1" title="Lihat Kalkulasi">
                                <i class="mdi mdi-eye text-lg text-inherit"></i>
                                Cek Kalkulasi
                            </a>
                            <a href="{{ route('sales.edit', $sale) }}" class="text-slate-400 hover:text-blue-600 font-medium transition" title="Edit">
                                <i class="mdi mdi-pencil text-xl"></i>
                            </a>
                            <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penjualan tanggal {{ $sale->sale_date->format('d M y') }} ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-red-600 font-medium transition" title="Hapus">
                                     <i class="mdi mdi-delete text-xl"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i class="mdi mdi-file-chart text-4xl text-slate-300"></i>
                            <p class="text-lg font-medium text-slate-600">Belum ada riwayat penjualan.</p>
                            <a href="{{ route('sales.create') }}" class="mt-2 text-sm text-primary font-medium hover:underline">Input penjualan pertama Anda.</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($sales->hasPages())
    <div class="px-6 py-4 border-t border-slate-200">
        {{ $sales->links() }}
    </div>
    @endif
</div>
@endsection
