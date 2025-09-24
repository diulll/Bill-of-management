@extends('app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Catatan Tim</h1>
    <p class="text-slate-500 mt-1">Kirim pesan atau catatan yang bisa dilihat oleh seluruh anggota tim.</p>
</div>

<!-- Form Kirim Pesan -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h2 class="text-sm font-semibold text-slate-700 flex items-center gap-2">
            <i class="mdi mdi-pencil text-lg text-orange-500"></i>
            Tulis Pesan Baru
        </h2>
    </div>
    <form action="{{ route('notes.store') }}" method="POST" class="p-6">
        @csrf
        <textarea 
            name="message" 
            rows="3" 
            required 
            maxlength="2000"
            placeholder="Ketik pesan atau catatan di sini..."
            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-orange-400 focus:ring-orange-400 sm:text-sm px-4 py-3 border outline-none transition resize-none"
        >{{ old('message') }}</textarea>
        @error('message')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        <div class="flex justify-end mt-3">
            <button type="submit" class="inline-flex items-center gap-1.5 bg-orange-500 hover:bg-orange-600 text-white text-sm px-5 py-2.5 rounded-lg transition-all duration-150 font-medium shadow-sm active:scale-95 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2">
                <i class="mdi mdi-send text-lg"></i>
                Kirim Pesan
            </button>
        </div>
    </form>
</div>

<!-- Daftar Pesan -->
@if($notes->isEmpty())
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
    <i class="mdi mdi-chat-outline text-6xl text-slate-300"></i>
    <h3 class="text-lg font-semibold text-slate-600 mb-1">Belum Ada Pesan</h3>
    <p class="text-sm text-slate-400">Jadilah yang pertama menulis catatan untuk tim!</p>
</div>
@else
<div class="space-y-4">
    @foreach($notes as $note)
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
        <div class="px-6 py-4">
            <!-- Header: Nama + Waktu -->
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        {{ strtoupper(substr($note->user->name ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">{{ $note->user->name ?? 'User Terhapus' }}</h3>
                        <p class="text-xs text-slate-400">
                            {{ $note->created_at->translatedFormat('l, d F Y') }} &bull; {{ $note->created_at->format('H:i') }} WIB
                        </p>
                    </div>
                </div>
                
                <!-- Tombol Hapus (hanya pemilik atau admin) -->
                @if(auth()->id() === $note->user_id || auth()->user()->is_admin)
                <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-slate-300 hover:text-red-500 transition p-1" title="Hapus pesan">
                        <i class="mdi mdi-delete text-lg"></i>
                    </button>
                </form>
                @endif
            </div>
            
            <!-- Isi Pesan -->
            <div class="pl-[52px]">
                <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">{{ $note->message }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $notes->links() }}
</div>
@endif

@if(session('success'))
<div id="toast" class="fixed bottom-6 right-6 bg-emerald-600 text-white px-5 py-3 rounded-lg shadow-lg text-sm font-medium flex items-center gap-2 z-50 animate-bounce">
    <i class="mdi mdi-check text-xl"></i>
    {{ session('success') }}
</div>
@push('scripts')
<script>
    setTimeout(() => {
        const toast = document.getElementById('toast');
        if (toast) toast.style.display = 'none';
    }, 3000);
</script>
@endpush
@endif

@endsection
