@extends('app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-heading">Master Data Bahan Baku</h1>
        <p class="text-muted mt-1 text-body-sm">Kelola data bahan baku dasar untuk resep menu.</p>
    </div>
    <div>
        <a href="{{ route('ingredients.create') }}" class="btn-primary btn-sm w-full sm:w-auto">
            <i class="mdi mdi-plus text-lg"></i>
            Tambah Bahan Baru
        </a>
    </div>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="table-airbnb">
            <thead>
                <tr>
                    <th>Nama Bahan</th>
                    <th>Satuan Dasar</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ingredients as $ingredient)
                <tr>
                    <td class="font-medium text-ink">{{ $ingredient->name }}</td>
                    <td><span class="badge-airbnb bg-surface-strong text-ink">{{ $ingredient->unit }}</span></td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('ingredients.edit', $ingredient) }}" class="text-ink hover:text-muted font-medium transition flex items-center gap-1 text-body-sm">
                                <i class="mdi mdi-pencil text-lg"></i>
                                Edit
                            </a>
                            <form action="{{ route('ingredients.destroy', $ingredient) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bahan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-error-text hover:text-red-700 font-medium transition flex items-center gap-1 text-body-sm">
                                    <i class="mdi mdi-delete text-lg"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <i class="mdi mdi-cube-outline empty-state-icon"></i>
                            <p class="empty-state-title">Belum ada data bahan baku.</p>
                            <p class="empty-state-text">Silakan tambah bahan baru terlebih dahulu.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($ingredients->hasPages())
    <div class="px-6 py-4 border-t border-hairline">
        {{ $ingredients->links() }}
    </div>
    @endif
</div>
@endsection
