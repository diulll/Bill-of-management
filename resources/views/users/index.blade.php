@extends('app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Kelola User</h1>
    <p class="text-slate-500 mt-1">Setujui pendaftar baru dan kelola user yang sudah terdaftar.</p>
</div>

{{-- ═══════════════ PENDAFTAR MENUNGGU PERSETUJUAN ═══════════════ --}}
@if($pendingUsers->count() > 0)
<div class="mb-8">
    <div class="flex items-center gap-2 mb-4">
        <span class="relative flex h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
        </span>
        <h2 class="text-lg font-semibold text-slate-800">Menunggu Persetujuan</h2>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
            {{ $pendingUsers->count() }}
        </span>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-amber-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-amber-50/50 text-xs uppercase text-slate-500 border-b border-amber-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">Nama</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Email</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Tanggal Daftar</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-100">
                    @foreach($pendingUsers as $user)
                    <tr class="hover:bg-amber-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-800">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-sm font-bold uppercase">
                                    {{ substr($user->name, 0, 1) }}
                                </span>
                                {{ $user->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-slate-500">{{ $user->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('users.approve', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-green-700 bg-green-50 rounded-lg hover:bg-green-100 active:scale-95 transition-all duration-150 border border-green-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('users.reject', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Tolak dan hapus user &quot;{{ $user->name }}&quot;?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 active:scale-95 transition-all duration-150 border border-red-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
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
    <h2 class="text-lg font-semibold text-slate-800">User Aktif</h2>
    <span class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-600">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        Total: {{ $approvedUsers->total() }} user
    </span>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50/50 text-xs uppercase text-slate-500 border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold w-12 text-center">#</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Nama</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Email</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Role</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Terdaftar Sejak</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($approvedUsers as $user)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-400 text-center">{{ $user->id }}</td>
                    <td class="px-6 py-4 font-medium text-slate-800">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold uppercase">
                                {{ substr($user->name, 0, 1) }}
                            </span>
                            <div>
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="ml-1.5 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Anda</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        @if($user->is_admin)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Admin</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">User</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-500">{{ $user->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4 text-right">
                        @if($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user &quot;{{ $user->name }}&quot;?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 active:scale-95 transition-all duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>
                        </form>
                        @else
                        <span class="text-xs text-slate-400 italic">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                        <p class="text-lg font-medium text-slate-600">Belum ada user aktif.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($approvedUsers->hasPages())
    <div class="px-6 py-4 border-t border-slate-200">
        {{ $approvedUsers->links() }}
    </div>
    @endif
</div>
@endsection
