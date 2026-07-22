@extends('app')

@section('content')
<div class="mb-6">
    <a href="{{ route('menus.index') }}" class="btn-tertiary text-body-sm text-muted hover:text-ink">
        <i class="mdi mdi-arrow-left text-lg"></i>
        Kembali ke Daftar Menu
    </a>
</div>

<div class="max-w-2xl card">
    <div class="card-header">
        <h2 class="text-display-sm text-ink">Tambah Menu Baru</h2>
    </div>

    <form action="{{ route('menus.store') }}" method="POST" class="card-body">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="name" class="label-airbnb">Nama Menu <span class="text-rausch">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="input-airbnb" required placeholder="Contoh: Butterscotch Latte">
                @error('name')
                    <p class="mt-1.5 text-body-sm text-error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="label-airbnb">Kategori <span class="text-rausch">*</span></label>
                    <div class="relative">
                        <select name="category" id="category" class="select-airbnb" required>
                            <option value="minuman" {{ old('category') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="makanan" {{ old('category') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-muted">
                            <i class="mdi mdi-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="price" class="label-airbnb">Harga Jual (Opsional)</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-muted text-body-sm">Rp</span>
                        </div>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" step="100" class="input-airbnb pl-10" placeholder="0">
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <div class="flex items-center">
                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 rounded border-hairline text-rausch focus:ring-rausch">
                    <label for="is_active" class="ml-2 block text-body-sm text-body cursor-pointer">
                        Menu aktif (Tersedia untuk dijual)
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-hairline-soft">
            <a href="{{ route('menus.index') }}" class="btn-secondary btn-sm">
                Batal
            </a>
            <button type="submit" class="btn-primary btn-sm">
                Simpan & Lanjut Setup Resep
            </button>
        </div>
    </form>
</div>
@endsection
