@extends('app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Master Data Menu</h1>
        <p class="text-slate-500 mt-1">Kelola daftar menu dan resep bahan bakunya.</p>
    </div>
    <div>
        <a href="{{ route('menus.create') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 active:scale-95 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2 transition-all duration-150 w-full sm:w-auto">
            <i class="mdi mdi-plus text-lg mr-1"></i>
            Tambah Menu Baru
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50/50 text-xs uppercase text-slate-500 border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold">Nama Menu</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Kategori</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Harga</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">Status</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">Resep (Bahan)</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($menus as $menu)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-800">{{ $menu->name }}</td>
                    <td class="px-6 py-4 capitalize">{{ $menu->category }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($menu->price ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($menu->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full {{ $menu->ingredients_count > 0 ? 'bg-blue-100 text-blue-700 font-bold' : 'bg-red-100 text-red-700' }} text-xs">
                            {{ $menu->ingredients_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('menus.show', $menu) }}" class="text-indigo-600 hover:text-indigo-800 font-medium transition flex items-center gap-1" title="Kelola Resep">
                                <i class="mdi mdi-clipboard-check text-lg text-inherit"></i>
                                Resep
                            </a>
                            <a href="{{ route('menus.edit', $menu) }}" class="text-blue-600 hover:text-blue-800 font-medium transition">
                                Edit
                            </a>
                            <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini beserta resepnya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i class="mdi mdi-book-open-page-variant text-4xl text-slate-300"></i>
                            <p class="text-lg font-medium text-slate-600">Belum ada data menu.</p>
                            <p class="text-sm">Silakan tambah menu baru terlebih dahulu.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($menus->hasPages())
    <div class="px-6 py-4 border-t border-slate-200">
        {{ $menus->links() }}
    </div>
    @endif
</div>
@endsection
