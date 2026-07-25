@extends('app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <a href="{{ route('menus.index') }}" class="btn-tertiary text-body-sm text-muted hover:text-ink mb-3 inline-flex">
            <i class="mdi mdi-arrow-left text-lg"></i>
            Kembali ke Daftar Menu
        </a>
        <h1 class="page-heading flex items-center gap-3">
            {{ $menu->name }}
            @if($menu->is_active)
                <span class="badge-airbnb bg-green-50 text-green-700">Aktif</span>
            @else
                <span class="badge-airbnb bg-surface-strong text-muted">Nonaktif</span>
            @endif
        </h1>
        <p class="text-muted mt-1 capitalize text-body-sm">{{ $menu->category }} &bull; Harga: Rp {{ number_format($menu->price ?? 0, 0, ',', '.') }}</p>
    </div>
    <div>
        <a href="{{ route('menus.edit', $menu) }}" class="btn-secondary btn-sm w-full sm:w-auto">
            <i class="mdi mdi-pencil text-lg"></i>
            Edit Informasi Menu
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Kolom Kiri: Form Input Resep -->
    <div class="lg:col-span-1">
        <div class="card sticky top-24">
            <div class="card-header">
                <h2 class="text-display-sm text-ink">Setup Resep Bahan Baku</h2>
                <p class="text-caption-sm text-muted mt-1">Satu porsi menu ini butuh bahan baku apa saja?</p>
            </div>

            <form action="{{ route('menus.recipe.update', $menu) }}" method="POST" id="recipeForm" class="card-body">
                @csrf
                
                <div id="ingredientsContainer" class="space-y-4">
                    <!-- Javascript akan mengisi list bahan baku disini -->
                </div>

                <button type="button" id="addIngredientBtn" class="mt-4 w-full py-2.5 border border-dashed border-hairline rounded-airbnb-sm text-body-sm font-medium text-muted hover:text-rausch hover:border-rausch hover:bg-rausch-light transition flex items-center justify-center gap-2">
                    <i class="mdi mdi-plus text-lg"></i>
                    Tambah Bahan Baku
                </button>

                <hr class="my-6 border-hairline-soft">

                <button type="submit" class="btn-primary w-full">
                    Update Resep
                </button>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Preview Resep Saat Ini -->
    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h2 class="text-display-sm text-ink flex items-center gap-2">
                    <i class="mdi mdi-clipboard-check text-xl text-rausch"></i>
                    Komposisi Resep (Saat Ini)
                </h2>
                <span class="badge-airbnb bg-rausch-light text-rausch">
                    {{ $menu->ingredients->count() }} Bahan Baku
                </span>
            </div>
            
            <div class="p-0">
                @if($menu->ingredients->isEmpty())
                    <div class="empty-state p-12">
                        <i class="mdi mdi-package-variant-closed empty-state-icon"></i>
                        <p class="empty-state-title">Belum ada resep yang di-setup.</p>
                        <p class="empty-state-text">Silakan tambah bahan baku melalui form di samping lalu simpan.</p>
                    </div>
                @else
                    <ul class="divide-y divide-hairline-soft">
                        @foreach($menu->ingredients as $ing)
                            <li class="px-6 py-4 flex items-center justify-between hover:bg-surface-soft transition cursor-default">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-rausch"></div>
                                    <span class="font-medium text-ink">{{ $ing->name }}</span>
                                </div>
                                <div class="font-semibold text-ink bg-surface-strong px-3 py-1 rounded-airbnb-sm border border-hairline">
                                    {{ (float) $ing->pivot->quantity }} <span class="text-caption-sm text-muted font-normal ml-1">{{ $ing->pivot->unit }}</span>
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
        div.className = 'flex items-start gap-2 group p-3 border border-hairline-soft rounded-airbnb-sm bg-surface-soft hover:border-hairline transition relative';
        
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
                    <select name="ingredients[${itemIndex}][id]" required onchange="updateUnit(this)" class="select-airbnb text-body-sm">
                        ${optionsHtml}
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="number" name="ingredients[${itemIndex}][quantity]" value="${quantity}" required min="0.01" step="0.01" placeholder="Takaran..." class="input-airbnb h-10 text-body-sm">
                    <span class="unit-label text-badge font-medium text-muted bg-surface-strong px-2 py-1.5 rounded-airbnb-sm w-16 text-center truncate border border-hairline">-</span>
                </div>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="p-1.5 text-muted hover:text-rausch hover:bg-rausch-light rounded-airbnb-sm transition self-start" title="Hapus baris ini">
                <i class="mdi mdi-close text-lg"></i>
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
