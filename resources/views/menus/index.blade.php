@extends('app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-heading">Master Data Menu</h1>
        <p class="text-muted mt-1 text-body-sm">Kelola daftar menu dan resep bahan bakunya.</p>
    </div>
    <div>
        <a href="{{ route('menus.create') }}" class="btn-primary btn-sm w-full sm:w-auto">
            <i class="mdi mdi-plus text-lg"></i>
            Tambah Menu Baru
        </a>
    </div>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="table-airbnb">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Resep (Bahan)</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                <tr>
                    <td class="font-medium text-ink">{{ $menu->name }}</td>
                    <td class="capitalize text-body">{{ $menu->category }}</td>
                    <td class="text-body">Rp {{ number_format($menu->price ?? 0, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if($menu->is_active)
                            <span class="badge-airbnb bg-green-50 text-green-700">Aktif</span>
                        @else
                            <span class="badge-airbnb bg-surface-strong text-muted">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full {{ $menu->ingredients_count > 0 ? 'bg-rausch-light text-rausch' : 'bg-red-50 text-error-text' }} text-badge font-bold">
                            {{ $menu->ingredients_count }}
                        </span>
                    </td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('menus.show', $menu) }}" class="text-rausch hover:text-rausch-active font-medium transition flex items-center gap-1 text-body-sm" title="Kelola Resep">
                                <i class="mdi mdi-clipboard-check text-lg text-inherit"></i>
                                Resep
                            </a>
                            <a href="{{ route('menus.edit', $menu) }}" class="text-ink hover:text-muted font-medium transition text-body-sm">
                                Edit
                            </a>
                            <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini beserta resepnya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-error-text hover:text-red-700 font-medium transition text-body-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="mdi mdi-book-open-page-variant empty-state-icon"></i>
                            <p class="empty-state-title">Belum ada data menu.</p>
                            <p class="empty-state-text">Silakan tambah menu baru terlebih dahulu.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($menus->hasPages())
    <div class="px-6 py-4 border-t border-hairline">
        {{ $menus->links() }}
    </div>
    @endif
</div>
@endsection
