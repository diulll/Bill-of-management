@extends('app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <a href="{{ route('menus.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition mb-3 w-fit gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Menu
        </a>
        <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
            {{ $menu->name }}
            @if($menu->is_active)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Nonaktif</span>
            @endif
        </h1>
        <p class="text-slate-500 mt-1 capitalize">{{ $menu->category }} &bull; Harga: Rp {{ number_format($menu->price ?? 0, 0, ',', '.') }}</p>
    </div>
    <div>
        <a href="{{ route('menus.edit', $menu) }}" class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition w-full sm:w-auto">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            Edit Informasi Menu
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Kolom Kiri: Form Input Resep -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h2 class="text-lg font-semibold text-slate-800">Setup Resep Bahan Baku</h2>
                <p class="text-xs text-slate-500 mt-1">Satu porsi menu ini butuh bahan baku apa saja?</p>
            </div>

            <form action="{{ route('menus.recipe.update', $menu) }}" method="POST" id="recipeForm" class="p-6">
                @csrf
                
                <div id="ingredientsContainer" class="space-y-4">
                    <!-- Javascript akan mengisi list bahan baku disini -->
                </div>

                <button type="button" id="addIngredientBtn" class="mt-4 w-full py-2 border border-dashed border-slate-300 rounded-lg text-sm font-medium text-slate-600 hover:text-primary hover:border-primary hover:bg-orange-50 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Bahan Baku
                </button>

                <hr class="my-6 border-slate-100">

                <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent bg-orange-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition">
                    Update Resep
                </button>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Preview Resep Saat Ini -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Komposisi Resep (Saat Ini)
                </h2>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $menu->ingredients->count() }} Bahan Baku
                </span>
            </div>
            
            <div class="p-0">
                @if($menu->ingredients->isEmpty())
                    <div class="p-12 text-center text-slate-500 flex flex-col items-center justify-center gap-2">
                        <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <p class="text-lg font-medium text-slate-600">Belum ada resep yang di-setup.</p>
                        <p class="text-sm">Silakan tambah bahan baku melalui form di samping lalu simpan.</p>
                    </div>
                @else
                    <ul class="divide-y divide-slate-100">
                        @foreach($menu->ingredients as $ing)
                            <li class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition cursor-default">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-primary"></div>
                                    <span class="font-medium text-slate-700">{{ $ing->name }}</span>
                                </div>
                                <div class="font-semibold text-slate-800 bg-slate-100 px-3 py-1 rounded-md border border-slate-200">
                                    {{ (float) $ing->pivot->quantity }} <span class="text-xs text-slate-500 font-normal ml-1">{{ $ing->pivot->unit }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const allIngredients = @json($allIngredients);
    const existingRecipe = @json($menu->ingredients);
    const container = document.getElementById('ingredientsContainer');
    const addBtn = document.getElementById('addIngredientBtn');
    
    let itemIndex = 0;

    function renderIngredientRow(ingredientId = '', quantity = '') {
        const div = document.createElement('div');
        div.className = 'flex items-start gap-2 group p-3 border border-slate-100 rounded-lg bg-slate-50/50 hover:border-slate-300 transition relative';
        
        // Buat options untuk select
        let optionsHtml = '<option value="" disabled selected>Pilih Bahan...</option>';
        allIngredients.forEach(i => {
            const isSelected = i.id == ingredientId ? 'selected' : '';
            optionsHtml += `<option value="${i.id}" data-unit="${i.unit}" ${isSelected}>${i.name}</option>`;
        });

        div.innerHTML = `
            <div class="flex-grow space-y-3">
                <div>
                    <label class="sr-only">Bahan Baku</label>
                    <select name="ingredients[${itemIndex}][id]" required onchange="updateUnit(this)" class="w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary text-sm px-3 py-2 border outline-none bg-white">
                        ${optionsHtml}
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="number" name="ingredients[${itemIndex}][quantity]" value="${quantity}" required min="0.01" step="0.01" placeholder="Takaran..." class="w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary text-sm px-3 py-2 border outline-none bg-white">
                    <span class="unit-label text-xs font-medium text-slate-500 bg-slate-200 px-2 py-1.5 rounded w-16 text-center truncate">-</span>
                </div>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded transition self-start" title="Hapus baris ini">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        `;
        
        container.appendChild(div);
        
        // Trigger update unit if already selected
        const select = div.querySelector('select');
        if(select.value) updateUnit(select);
        
        itemIndex++;
    }

    // Fungsi global untuk update label satuan ketika select berubah
    window.updateUnit = function(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const unitLabel = selectElement.parentElement.parentElement.querySelector('.unit-label');
        if (selectedOption && selectedOption.dataset.unit) {
            unitLabel.textContent = selectedOption.dataset.unit;
        } else {
            unitLabel.textContent = '-';
        }
    };

    // Load Data Existing
    if (existingRecipe.length > 0) {
        existingRecipe.forEach(recipe => {
            renderIngredientRow(recipe.pivot.ingredient_id, recipe.pivot.quantity);
        });
    } else {
        // Render 1 baris kosong pertamakali
        renderIngredientRow();
    }

    addBtn.addEventListener('click', () => {
        renderIngredientRow();
    });
</script>
@endpush
@endsection
