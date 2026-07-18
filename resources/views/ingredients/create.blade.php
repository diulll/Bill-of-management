@extends('app')

@section('content')
<div class="mb-6">
    <a href="{{ route('ingredients.index') }}" class="btn-tertiary text-body-sm text-muted hover:text-ink">
        <i class="mdi mdi-arrow-left text-lg"></i>
        Kembali ke Daftar Bahan Baku
    </a>
</div>

<div class="max-w-2xl card">
    <div class="card-header">
        <h2 class="text-display-sm text-ink">Tambah Bahan Baku Baru</h2>
    </div>

    <form action="{{ route('ingredients.store') }}" method="POST" class="card-body">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="name" class="label-airbnb">Nama Bahan Baku <span class="text-rausch">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="input-airbnb" required placeholder="Contoh: Susu Kental Manis (SKM), UHT, Es Batu, dll">
                @error('name')
                    <p class="mt-1.5 text-body-sm text-error-text">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="unit" class="label-airbnb">Satuan Dasar <span class="text-rausch">*</span></label>
                <div class="relative">
                    <select name="unit" id="unit" class="select-airbnb" required>
                        <option value="" disabled selected>Pilih Satuan...</option>
                        <option value="gram" {{ old('unit') == 'gram' ? 'selected' : '' }}>Gram (g) — untuk benda padat/bubuk</option>
                        <option value="ml" {{ old('unit') == 'ml' ? 'selected' : '' }}>Mililiter (ml) — untuk benda cair</option>
                        <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>Pieces (pcs) — satuan utuh</option>
                        <option value="slice" {{ old('unit') == 'slice' ? 'selected' : '' }}>Lbr</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-muted">
                        <i class="mdi mdi-chevron-down"></i>
                    </div>
                </div>
                <p class="mt-2 text-body-sm text-muted flex items-start gap-1.5">
                    <i class="mdi mdi-information-outline text-lg mt-0.5 flex-shrink-0 text-hairline"></i>
                    <span><strong>Tips:</strong> Gunakan satuan paling kecil agar perhitungan resep lebih fleksibel (contoh: gunakan 'gram' bukan 'kg').</span>
                </p>
                @error('unit')
                    <p class="mt-1.5 text-body-sm text-error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-hairline-soft">
            <a href="{{ route('ingredients.index') }}" class="btn-secondary btn-sm">
                Batal
            </a>
            <button type="submit" class="btn-primary btn-sm">
                Simpan Bahan Baku
            </button>
        </div>
    </form>
</div>
@endsection
