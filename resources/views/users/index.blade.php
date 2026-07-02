@extends('app')

@section('content')
<div class="mb-6">
    <h1 class="page-heading">Kelola User</h1>
    <p class="text-muted mt-1 text-body-sm">Setujui pendaftar baru dan kelola user yang sudah terdaftar.</p>
</div>

{{-- ═══════════════ PENDAFTAR MENUNGGU PERSETUJUAN ═══════════════ --}}
@if($pendingUsers->count() > 0)
<div class="mb-8">
    <div class="flex items-center gap-2 mb-4">
        <span class="relative flex h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rausch opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-rausch"></span>
        </span>
        <h2 class="text-display-sm text-ink">Menunggu Persetujuan</h2>
        <span class="badge-airbnb bg-rausch-light text-rausch border border-rausch/20">
            {{ $pendingUsers->count() }}
        </span>
    </div>

    <div class="card border-rausch/30">
        <div class="overflow-x-auto">
            <table class="table-airbnb">
                <thead class="bg-rausch-light">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Daftar</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingUsers as $user)
                    <tr>
                        <td class="font-medium text-ink">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-rausch text-white flex items-center justify-center text-badge font-bold uppercase">
                                    {{ substr($user->name, 0, 1) }}
                                </span>
                                {{ $user->name }}
                            </div>
                        </td>
                        <td class="text-body">{{ $user->email }}</td>
                        <td class="text-muted">{{ $user->created_at->format('d M Y, H:i') }}</td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('users.approve', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-body-sm font-medium text-green-700 bg-green-50 rounded-airbnb-sm hover:bg-green-100 active:scale-[0.97] transition-all duration-150 border border-green-200">
                                        <i class="mdi mdi-check text-lg"></i>
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('users.reject', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Tolak dan hapus user &quot;{{ $user->name }}&quot;?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-body-sm font-medium text-rausch bg-rausch-light rounded-airbnb-sm hover:bg-red-100 active:scale-[0.97] transition-all duration-150 border border-rausch/20">
                                        <i class="mdi mdi-close text-lg"></i>
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- ═══════════════ USER YANG SUDAH DISETUJUI ═══════════════ --}}
<div class="flex items-center justify-between mb-4">
    <h2 class="text-display-sm text-ink">User Aktif</h2>
    <span class="inline-flex items-center gap-2 rounded-airbnb-sm bg-surface-soft px-4 py-2 text-body-sm font-medium text-ink border border-hairline">
        <i class="mdi mdi-account-group text-lg"></i>
        Total: {{ $approvedUsers->total() }} user
    </span>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="table-airbnb">
            <thead>
                <tr>
                    <th class="w-12 text-center">#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Terdaftar Sejak</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($approvedUsers as $user)
                <tr>
                    <td class="font-medium text-muted text-center">{{ $user->id }}</td>
                    <td class="font-medium text-ink">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-rausch-light text-rausch flex items-center justify-center text-badge font-bold uppercase">
                                {{ substr($user->name, 0, 1) }}
                            </span>
                            <div>
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="ml-1.5 badge-airbnb bg-green-50 text-green-700">Anda</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="text-body">{{ $user->email }}</td>
                    <td>
                        @if($user->is_admin)
                            <span class="badge-airbnb bg-rausch-light text-rausch">Admin</span>
                        @else
                            <span class="badge-airbnb bg-surface-strong text-muted">User</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $user->created_at->format('d M Y, H:i') }}</td>
                    <td class="text-right">
                        @if($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user &quot;{{ $user->name }}&quot;?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-body-sm font-medium text-rausch bg-rausch-light rounded-airbnb-sm hover:bg-red-100 active:scale-[0.97] transition-all duration-150">
                                <i class="mdi mdi-delete text-lg"></i>
                                Hapus
                            </button>
                        </form>
                        @else
                        <span class="text-caption-sm text-muted italic">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <p class="empty-state-title">Belum ada user aktif.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($approvedUsers->hasPages())
    <div class="px-6 py-4 border-t border-hairline">
        {{ $approvedUsers->links() }}
    </div>
    @endif
</div>
@endsection
