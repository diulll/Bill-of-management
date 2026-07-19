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
        <h2 class="text-display-sm text-ink">Edit Bahan Baku</h2>
    </div>

    <form action="{{ route('ingredients.update', $ingredient) }}" method="POST" class="card-body">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label for="name" class="label-airbnb">Nama Bahan Baku <span class="text-rausch">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $ingredient->name) }}" class="input-airbnb" required>
                @error('name')
                    <p class="mt-1.5 text-body-sm text-error-text">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="unit" class="label-airbnb">Satuan Dasar <span class="text-rausch">*</span></label>
                <div class="relative">
                    <select name="unit" id="unit" class="select-airbnb" required>
                        <option value="gram" {{ old('unit', $ingredient->unit) == 'gram' ? 'selected' : '' }}>Gram (g)</option>
                        <option value="ml" {{ old('unit', $ingredient->unit) == 'ml' ? 'selected' : '' }}>Mililiter (ml)</option>
                        <option value="pcs" {{ old('unit', $ingredient->unit) == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                        <option value="slice" {{ old('unit', $ingredient->unit) == 'slice' ? 'selected' : '' }}>Slice / Iris</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-muted">
                        <i class="mdi mdi-chevron-down"></i>
                    </div>
                </div>
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
                Update Bahan Baku
            </button>
        </div>
    </form>
</div>
@endsection
