@extends('app')

@section('content')
<div class="mb-6">
    <a href="{{ route('sales.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 flex items-center gap-1 w-fit transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Penjualan
    </a>
</div>

<div class="max-w-4xl bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
             Catat Penjualan Baru
        </h2>
    </div>

    <form action="{{ route('sales.store') }}" method="POST" class="p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label for="sale_date" class="block text-sm font-medium text-slate-700 mb-1">Tanggal Penjualan <span class="text-red-500">*</span></label>
                <input type="date" name="sale_date" id="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" required class="w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2 border outline-none transition bg-white">
                @error('sale_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="notes" class="block text-sm font-medium text-slate-700 mb-1">Catatan Tambahan (Opsional)</label>
                <input type="text" name="notes" id="notes" value="{{ old('notes') }}" placeholder="Contoh: Shift Siang, Bazar, dll" class="w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2 border outline-none transition bg-white">
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="bg-slate-50 border border-slate-200 rounded-lg p-5">
            <h3 class="text-md font-semibold text-slate-800 mb-4 border-b border-slate-200 pb-2">Daftar Menu Terjual</h3>
            
            @if($menus->isEmpty())
                <div class="bg-yellow-50 text-yellow-800 p-4 rounded text-sm border border-yellow-200">
                    <p><strong>Belum ada menu yang aktif.</strong> Silakan <a href="{{ route('menus.create') }}" class="underline font-bold">tambah menu</a> terlebih dahulu untuk bisa mencatat penjualan.</p>
                </div>
            @else
                @error('items')
                    <div class="bg-red-50 text-red-700 p-3 rounded mb-4 text-sm border border-red-200">
                        {{ $message }}
                    </div>
                @enderror

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($menus as $index => $menu)
                        <div class="flex items-center justify-between p-3 bg-white border border-slate-200 rounded-lg shadow-sm hover:border-slate-300 transition">
                            <div class="flex flex-col">
                                <span class="font-medium text-slate-800">{{ $menu->name }}</span>
                                <span class="text-xs text-slate-500 capitalize">{{ $menu->category }}</span>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <input type="hidden" name="items[{{ $index }}][menu_id]" value="{{ $menu->id }}">
                                <input type="number" 
                                       name="items[{{ $index }}][quantity]" 
                                       value="{{ old('items.'.$index.'.quantity', 0) }}" 
                                       min="0" 
                                       class="w-20 text-center rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm py-1.5 border outline-none"
                                >
                                <span class="text-xs font-medium text-slate-500">Porsi</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-slate-100">
            <a href="{{ route('sales.index') }}" class="inline-flex justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition">
                Batal
            </a>
            <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent bg-primary px-6 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition" {{ $menus->isEmpty() ? 'disabled' : '' }}>
                Simpan Penjualan
            </button>
        </div>
    </form>
</div>
@endsection
