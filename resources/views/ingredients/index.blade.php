@extends('app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Master Data Bahan Baku</h1>
        <p class="text-slate-500 mt-1">Kelola data bahan baku dasar untuk resep menu.</p>
    </div>
    <div>
        <a href="{{ route('ingredients.create') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 active:scale-95 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2 transition-all duration-150 w-full sm:w-auto">
            <i class="mdi mdi-plus text-lg mr-1"></i>
            Tambah Bahan Baru
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50/50 text-xs uppercase text-slate-500 border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold">Nama Bahan</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Satuan Dasar</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($ingredients as $ingredient)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-800">{{ $ingredient->name }}</td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">{{ $ingredient->unit }}</span></td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('ingredients.edit', $ingredient) }}" class="text-blue-600 hover:text-blue-800 font-medium transition flex items-center gap-1">
                                <i class="mdi mdi-pencil text-lg"></i>
                                Edit
                            </a>
                            <form action="{{ route('ingredients.destroy', $ingredient) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bahan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition flex items-center gap-1">
                                    <i class="mdi mdi-delete text-lg"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i class="mdi mdi-cube-outline text-4xl text-slate-300"></i>
                            <p class="text-lg font-medium text-slate-600">Belum ada data bahan baku.</p>
                            <p class="text-sm">Silakan tambah bahan baru terlebih dahulu.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($ingredients->hasPages())
    <div class="px-6 py-4 border-t border-slate-200">
        {{ $ingredients->links() }}
    </div>
    @endif
</div>
@endsection
