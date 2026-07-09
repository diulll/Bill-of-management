@extends('app')

@section('content')
<div class="mb-6">
    <h1 class="page-heading">Kalkulator</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
    <!-- Bagian Kiri: Input Menu -->
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h2 class="text-display-sm text-ink flex items-center gap-2">
                <i class="mdi mdi-plus-circle text-xl text-rausch"></i>
                Daftar Menu Tersedia
            </h2>
            <button type="button" onclick="resetCalculator()" class="text-body-sm font-medium text-muted hover:text-rausch transition">Reset Ulang</button>
        </div>
        
        <div class="p-4 bg-surface-soft border-b border-hairline-soft">
             <input type="text" id="searchInput" placeholder="Cari nama menu..." class="input-airbnb h-10 text-body-sm" onkeyup="filterMenus()">
        </div>

        <div class="divide-y divide-hairline-soft max-h-[500px] overflow-y-auto" id="menuList">
            @forelse($menus as $menu)
            <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between hover:bg-surface-soft transition menu-item" data-name="{{ strtolower($menu->name) }}">
                <div class="mb-2 sm:mb-0">
                    <h3 class="text-title-md text-ink">{{ $menu->name }}</h3>
                    <p class="text-caption-sm text-muted capitalize">{{ $menu->category }} &bull; {{ $menu->ingredients->count() }} Bahan Baku</p>
                </div>
                <div class="flex items-center gap-2 self-start sm:self-auto">
                    <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full bg-surface-strong text-ink hover:bg-rausch-light hover:text-rausch transition" onclick="changeQty({{ $menu->id }}, -1)">
                        <i class="mdi mdi-minus text-lg"></i>
                    </button>
                    <input type="number" id="qty_{{ $menu->id }}" value="0" min="0" class="w-16 text-center rounded-airbnb-sm border-hairline text-body-sm py-1.5 border outline-none focus:border-ink focus:border-2" onchange="validateQty(this); calculateIngredients()">
                    <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full bg-surface-strong text-ink hover:bg-green-50 hover:text-green-600 transition" onclick="changeQty({{ $menu->id }}, 1)">
                        <i class="mdi mdi-plus text-lg"></i>
                    </button>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-muted text-body-sm">
                Belum ada menu yang aktif.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Bagian Kanan: Hasil Kalkulasi -->
    <div id="resultPanel" class="card shadow-airbnb relative h-fit sticky top-[84px] lg:top-24 z-10 flex flex-col max-h-[40vh] lg:max-h-none">
        <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none">
             <i class="mdi mdi-chart-bar text-9xl text-muted"></i>
        </div>
        <div class="card-header relative z-10 w-full flex justify-between items-center">
            <div>
                <h2 class="text-display-sm text-ink flex items-center gap-2">
                    <i class="mdi mdi-flash text-xl text-rausch"></i>
                    Bahan Yang Terpakai
                </h2>
                <div id="statusQty" class="text-caption-sm text-muted mt-1">Total pesanan: 0</div>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="openSaveModal()" id="saveBtn" class="btn-primary btn-sm hidden text-body-sm px-3 py-1.5" title="Simpan Rekap">
                    <i class="mdi mdi-content-save text-sm"></i>
                    Simpan
                </button>
                <button type="button" onclick="copyToClipboard()" id="copyBtn" class="btn-secondary btn-sm hidden text-body-sm px-3 py-1.5" title="Salin text">
                    <i class="mdi mdi-content-copy text-sm"></i>
                    Salin Rekap
                </button>
            </div>
        </div>
        
        <div class="card-body relative z-10 overflow-y-auto">
            <div id="emptyState" class="card p-6 text-center flex flex-col items-center gap-3">
                 <i class="mdi mdi-cursor-default-click text-4xl text-hairline"></i>
                 <p class="text-body-sm text-muted">Mulai atur quantity pada daftar menu di samping untuk melihat hasil kalkulasi secara <em>real-time</em>.</p>
            </div>

            <div id="resultContainer" class="space-y-4 hidden">
                <!-- Hasil perhitungan akan dimasukkan via Javascript -->
            </div>
        </div>
    </div>
</div>


@push('modals')
<!-- Modal Simpan Rekap -->
<div id="saveModal" class="fixed inset-0 z-[9999] hidden" style="position:fixed;">
    <div class="scrim" onclick="closeSaveModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-canvas rounded-airbnb-md shadow-airbnb-lg border border-hairline w-full max-w-md relative">
            <div class="card-header rounded-t-airbnb-md">
                <h3 class="text-display-sm text-ink flex items-center gap-2">
                    <i class="mdi mdi-content-save text-xl text-rausch"></i>
                    Simpan Rekap Kalkulasi
                </h3>
                <p class="text-caption-sm text-muted mt-1">Rekap ini akan tersimpan di halaman Laporan Kalkulator.</p>
            </div>
            <form action="{{ route('calculator-logs.store') }}" method="POST" id="saveForm">
                @csrf
                <div class="card-body space-y-4">
                    <div>
                        <label for="save_name" class="label-airbnb">Nama Operator</label>
                        <input type="text" name="name" id="save_name" required placeholder="Masukkan nama..." class="input-airbnb">
                    </div>
                    <div>
                        <label for="save_shift" class="label-airbnb">Shift</label>
                        <select name="shift" id="save_shift" required class="select-airbnb">
                            <option value="">-- Pilih Shift --</option>
                            <option value="Shift 1">Shift 1</option>
                            <option value="Shift 2">Shift 2</option>
                            <option value="Shift 3">Shift 3</option>
                            <option value="Shift 4">Shift 4</option>
                            <option value="Shift 5">Shift 5</option>
                        </select>
                    </div>
                    <input type="hidden" name="menus_data" id="save_menus_data">
                    <input type="hidden" name="ingredients_data" id="save_ingredients_data">
                </div>
                <div class="px-6 py-4 border-t border-hairline bg-surface-soft rounded-b-airbnb-md flex justify-end gap-3">
                    <button type="button" onclick="closeSaveModal()" class="btn-secondary btn-sm">Batal</button>
                    <button type="submit" class="btn-primary btn-sm">
                        <i class="mdi mdi-check text-lg"></i>
                        Simpan Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    // Inisialisasi JSON berisi data seluruh menu dan ingredients-nya (resep)
    const menusDict = @json($menus->keyBy('id'));

    // Fungsi update kalkulasi utama
    function calculateIngredients() {
        const requiredIngredients = {};
        let totalPortions = 0;

        // Loop melalui setiap menu input
        document.querySelectorAll('input[id^="qty_"]').forEach(input => {
            const qty = parseInt(input.value) || 0;
            if (qty > 0) {
                totalPortions += qty;
                const menuId = input.id.replace('qty_', '');
                const menuData = menusDict[menuId];

                if (menuData && menuData.ingredients) {
                    menuData.ingredients.forEach(ing => {
                        if (!requiredIngredients[ing.name]) {
                            requiredIngredients[ing.name] = {
                                unit: ing.pivot.unit || ing.unit,
                                amount: 0
                            };
                        }
                        // Akumulasi: amount = Porsi * qty di resep
                        requiredIngredients[ing.name].amount += (qty * parseFloat(ing.pivot.quantity));
                    });
                }
            }
        });

        renderOutput(requiredIngredients, totalPortions);
    }

    // Merender ulang panel kiri
    function renderOutput(ingredients, totalPortions) {
        const resultContainer = document.getElementById('resultContainer');
        const emptyState = document.getElementById('emptyState');
        const statusQty = document.getElementById('statusQty');
        const copyBtn = document.getElementById('copyBtn');
        const saveBtn = document.getElementById('saveBtn');

        statusQty.innerText = 'Total Porsi: ' + totalPortions;

        if (Object.keys(ingredients).length === 0) {
            resultContainer.classList.add('hidden');
            emptyState.classList.remove('hidden');
            copyBtn.classList.add('hidden');
            saveBtn.classList.add('hidden');
            resultContainer.innerHTML = '';
            return;
        }

        emptyState.classList.add('hidden');
        resultContainer.classList.remove('hidden');
        copyBtn.classList.remove('hidden');
        saveBtn.classList.remove('hidden');
        
        let html = '';
        
        // Sorting ke dalam Array biar rapi berdasarkan nama bahan
        const sortedIngredients = Object.keys(ingredients).sort();

        sortedIngredients.forEach(name => {
            const data = ingredients[name];
            html += `
                <div>
                    <div class="flex justify-between items-end mb-1">
                        <span class="font-medium text-ink"><span class="text-rausch font-bold text-lg">•</span> ${name}</span>
                        <span class="text-lg font-bold text-rausch font-mono result-amount">${data.amount.toLocaleString('id-ID', {maximumFractionDigits: 2})} <span class="text-caption-sm text-muted font-sans ml-0.5 result-unit">${data.unit}</span></span>
                    </div>
                    <div class="w-full bg-surface-strong rounded-pill h-1">
                        <div class="bg-rausch h-1 rounded-pill" style="width: 100%"></div>
                    </div>
                </div>
            `;
        });

        resultContainer.innerHTML = html;
    }

    // Helpers untuk tombol +/-
    function changeQty(menuId, amount) {
        const el = document.getElementById('qty_' + menuId);
        let val = parseInt(el.value) || 0;
        val += amount;
        if (val < 0) val = 0;
        el.value = val;
        calculateIngredients();
    }

    function validateQty(el) {
        let val = parseInt(el.value);
        if (isNaN(val) || val < 0) el.value = 0;
    }

    function resetCalculator() {
        if(confirm('Mau reset?? Yakin?')) {
            document.querySelectorAll('input[id^="qty_"]').forEach(input => input.value = 0);
            calculateIngredients();
        }
    }

    function filterMenus() {
        const term = document.getElementById('searchInput').value.toLowerCase();
        const items = document.querySelectorAll('.menu-item');
        items.forEach(item => {
            if (item.dataset.name.includes(term)) {
                 item.classList.remove('hidden');
                 item.classList.add('flex');
            } else {
                 item.classList.add('hidden');
                 item.classList.remove('flex');
            }
        });
    }

    function copyToClipboard() {
        const lines = ["REKAP KEBUTUHAN BAHAN BAKU", "========================="];
        
        // Catat Menu 
        const menusSold = [];
        document.querySelectorAll('input[id^="qty_"]').forEach(input => {
            const qty = parseInt(input.value) || 0;
            if (qty > 0) {
                const menuId = input.id.replace('qty_', '');
                menusSold.push(`${qty}x ${menusDict[menuId].name}`);
            }
        });
        if(menusSold.length > 0) {
             lines.push("Order/Menu:");
             lines.push(...menusSold);
             lines.push("-------------------------");
        }

        // Catat Hasil Ingredients
        const resultItems = document.querySelectorAll('#resultContainer > div');
        resultItems.forEach(div => {
            const name = div.querySelector('span.text-ink').innerText.replace('• ', '');
            const amount = div.querySelector('.result-amount').childNodes[0].nodeValue.trim();
            const unit = div.querySelector('.result-unit').innerText;
            lines.push(`- ${name}: ${amount} ${unit}`);
        });

        const textToCopy = lines.join('\n');
        navigator.clipboard.writeText(textToCopy).then(() => {
            const btn = document.getElementById('copyBtn');
            const ogHTML = btn.innerHTML;
            btn.innerHTML = '<i class="mdi mdi-check text-sm"></i> Disalin!';
            setTimeout(() => {
                btn.innerHTML = ogHTML;
            }, 2000);
        });
    }

    // === Modal Simpan ===
    function getCalculationData() {
        const menusData = [];
        const ingredientsData = [];

        document.querySelectorAll('input[id^="qty_"]').forEach(input => {
            const qty = parseInt(input.value) || 0;
            if (qty > 0) {
                const menuId = input.id.replace('qty_', '');
                const menuData = menusDict[menuId];
                menusData.push({ id: menuId, name: menuData.name, qty: qty });
            }
        });

        const resultItems = document.querySelectorAll('#resultContainer > div');
        resultItems.forEach(div => {
            const name = div.querySelector('span.text-ink').innerText.replace('• ', '');
            const amount = div.querySelector('.result-amount').childNodes[0].nodeValue.trim();
            const unit = div.querySelector('.result-unit').innerText;
            ingredientsData.push({ name, amount, unit });
        });

        return { menusData, ingredientsData };
    }

    function openSaveModal() {
        const { menusData, ingredientsData } = getCalculationData();
        document.getElementById('save_menus_data').value = JSON.stringify(menusData);
        document.getElementById('save_ingredients_data').value = JSON.stringify(ingredientsData);
        document.getElementById('resultPanel').style.visibility = 'hidden';
        document.getElementById('saveModal').classList.remove('hidden');
    }

    function closeSaveModal() {
        document.getElementById('saveModal').classList.add('hidden');
        document.getElementById('resultPanel').style.visibility = 'visible';
    }

</script>
@endpush
@endsection
