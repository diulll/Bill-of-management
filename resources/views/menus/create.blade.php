@extends('app')

@section('content')
<div class="mb-6">
    <a href="{{ route('menus.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 flex items-center gap-1 w-fit transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Menu
    </a>
</div>

<div class="max-w-2xl bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h2 class="text-lg font-semibold text-slate-800">Tambah Menu Baru</h2>
    </div>

    <form action="{{ route('menus.store') }}" method="POST" class="p-6">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Menu <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2 border outline-none transition" required placeholder="Contoh: Butterscotch Latte">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-sm font-medium text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="category" id="category" class="w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2 border outline-none appearance-none transition bg-white" required>
                            <option value="minuman" {{ old('category') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="makanan" {{ old('category') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-slate-700 mb-1">Harga Jual (Opsional)</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-slate-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" step="100" class="w-full rounded-md border-slate-300 pl-10 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2 border outline-none transition" placeholder="0">
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <div class="flex items-center">
                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary">
                    <label for="is_active" class="ml-2 block text-sm text-slate-700 cursor-pointer">
                        Menu aktif (Tersedia untuk dijual)
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-slate-100">
            <a href="{{ route('menus.index') }}" class="inline-flex justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition">
                Batal
            </a>
            <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition">
                Simpan & Lanjut Setup Resep
            </button>
        </div>
    </form>
</div>
@endsection
