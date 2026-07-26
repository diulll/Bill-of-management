@extends('app')

@section('content')
<div class="mb-6">
    <h1 class="page-heading">Catatan Tim</h1>
    <p class="text-muted mt-1 text-body-sm">Kirim pesan atau catatan yang bisa dilihat oleh seluruh anggota tim.</p>
</div>

<!-- Form Kirim Pesan -->
<div class="card mb-8">
    <div class="card-header">
        <h2 class="text-title-md text-ink flex items-center gap-2">
            <i class="mdi mdi-pencil text-lg text-rausch"></i>
            Tulis Pesan Baru
        </h2>
    </div>
    <form action="{{ route('notes.store') }}" method="POST" class="card-body">
        @csrf
        <textarea 
            name="message" 
            rows="3" 
            required 
            maxlength="2000"
            placeholder="Ketik pesan atau catatan di sini..."
            class="textarea-airbnb"
        >{{ old('message') }}</textarea>
        @error('message')
            <p class="text-error-text text-body-sm mt-1.5">{{ $message }}</p>
        @enderror
        <div class="flex justify-end mt-4">
            <button type="submit" class="btn-primary btn-sm">
                <i class="mdi mdi-send text-lg"></i>
                Kirim Pesan
            </button>
        </div>
    </form>
</div>

<!-- Daftar Pesan -->
@if($notes->isEmpty())
<div class="card">
    <div class="empty-state p-12">
        <i class="mdi mdi-chat-outline empty-state-icon"></i>
        <h3 class="empty-state-title">Belum Ada Pesan</h3>
        <p class="empty-state-text">Jadilah yang pertama menulis catatan untuk tim!</p>
    </div>
</div>
@else
<div class="space-y-4">
    @foreach($notes as $note)
    <div class="card card-hover">
        <div class="px-6 py-4">
            <!-- Header: Nama + Waktu -->
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-rausch flex items-center justify-center text-white font-bold text-body-sm shadow-sm">
                        {{ strtoupper(substr($note->user->name ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-title-md text-ink">{{ $note->user->name ?? 'User Terhapus' }}</h3>
                        <p class="text-caption-sm text-muted">
                            {{ $note->created_at->translatedFormat('l, d F Y') }} &bull; {{ $note->created_at->format('H:i') }} WIB
                        </p>
                    </div>
                </div>
                
                <!-- Tombol Hapus (hanya pemilik atau admin) -->
                @if(auth()->id() === $note->user_id || auth()->user()->is_admin)
                <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-hairline hover:text-rausch transition p-1 rounded-airbnb-sm hover:bg-rausch-light" title="Hapus pesan">
                        <i class="mdi mdi-delete text-lg"></i>
                    </button>
                </form>
                @endif
            </div>
            
            <!-- Isi Pesan -->
            <div class="pl-[52px]">
                <p class="text-body text-body-sm leading-relaxed whitespace-pre-line">{{ $note->message }}</p>
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
<div id="toast" class="fixed bottom-6 right-6 bg-rausch text-white px-5 py-3 rounded-airbnb-sm shadow-airbnb-lg text-body-sm font-medium flex items-center gap-2 z-50">
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
