@extends('app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Kalkulator</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
    <!-- Bagian Kiri: Input Menu -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Daftar Menu Tersedia
            </h2>
            <button type="button" onclick="resetCalculator()" class="text-sm font-medium text-slate-500 hover:text-red-500 transition">Reset Ulang</button>
        </div>
        
        <div class="p-4 bg-slate-50 border-b border-slate-200">
             <input type="text" id="searchInput" placeholder="Cari nama menu..." class="w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm px-4 py-2 border outline-none transition bg-white" onkeyup="filterMenus()">
        </div>

        <div class="divide-y divide-slate-100 max-h-[500px] overflow-y-auto" id="menuList">
            @forelse($menus as $menu)
            <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between hover:bg-slate-50 transition menu-item" data-name="{{ strtolower($menu->name) }}">
                <div class="mb-2 sm:mb-0">
                    <h3 class="font-medium text-slate-800">{{ $menu->name }}</h3>
                    <p class="text-xs text-slate-500 capitalize">{{ $menu->category }} &bull; {{ $menu->ingredients->count() }} Bahan Baku</p>
                </div>
                <div class="flex items-center gap-2 self-start sm:self-auto">
                    <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-red-100 hover:text-red-600 transition" onclick="changeQty({{ $menu->id }}, -1)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                    </button>
                    <input type="number" id="qty_{{ $menu->id }}" value="0" min="0" class="w-16 text-center rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm py-1 border outline-none" onchange="validateQty(this); calculateIngredients()">
                    <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-green-100 hover:text-green-600 transition" onclick="changeQty({{ $menu->id }}, 1)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-slate-500">
                Belum ada menu yang aktif.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Bagian Kanan: Hasil Kalkulasi -->
    <div class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden text-slate-800 relative h-fit sticky top-[70px] lg:top-24 z-40 flex flex-col max-h-[40vh] lg:max-h-none">
        <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none">
             <svg class="w-32 h-32 text-slate-400" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/><path d="M7 12h2v5H7zm4-3h2v8h-2zm4-3h2v11h-2z"/></svg>
        </div>
        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/80 backdrop-blur-sm relative z-10 w-full flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Bahan Yang Terpakai
                </h2>
                <div id="statusQty" class="text-xs text-slate-500 mt-1">Total pesanan: 0</div>
            </div>
            <button type="button" onclick="copyToClipboard()" id="copyBtn" class="bg-primary hover:bg-primary-dark text-white text-xs px-3 py-1.5 rounded transition hidden" title="Salin text">Salin Rekap</button>
        </div>
        
        <div class="p-6 relative z-10 overflow-y-auto">
            <div id="emptyState" class="bg-white p-6 rounded border border-slate-200 text-center flex flex-col items-center gap-3">
                 <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                 <p class="text-sm text-slate-500">Mulai atur quantity pada daftar menu di samping untuk melihat hasil kalkulasi secara <em>real-time</em>.</p>
            </div>

            <div id="resultContainer" class="space-y-4 hidden">
                <!-- Hasil perhitungan akan dimasukkan via Javascript -->
            </div>
        </div>
    </div>
</div>

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

        statusQty.innerText = 'Total Porsi: ' + totalPortions;

        if (Object.keys(ingredients).length === 0) {
            resultContainer.classList.add('hidden');
            emptyState.classList.remove('hidden');
            copyBtn.classList.add('hidden');
            resultContainer.innerHTML = '';
            return;
        }

        emptyState.classList.add('hidden');
        resultContainer.classList.remove('hidden');
        copyBtn.classList.remove('hidden');
        
        let html = '';
        
        // Sorting ke dalam Array biar rapi berdasarkan nama bahan
        const sortedIngredients = Object.keys(ingredients).sort();

        sortedIngredients.forEach(name => {
            const data = ingredients[name];
            html += `
                <div>
                    <div class="flex justify-between items-end mb-1">
                        <span class="font-medium text-slate-800">🍄 ${name}</span>
                        <span class="text-lg font-bold text-orange-500 font-mono result-amount">${data.amount.toLocaleString('id-ID', {maximumFractionDigits: 2})} <span class="text-xs text-slate-500 font-sans ml-0.5 result-unit">${data.unit}</span></span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1">
                        <div class="bg-gradient-to-r from-orange-400 to-orange-500 h-1 rounded-full" style="width: 100%"></div>
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
        document.querySelectorAll('input[id^="qty_"]').forEach(input => input.value = 0);
        calculateIngredients();
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
            const name = div.querySelector('span.text-slate-200').innerText.replace('🍄 ', '');
            const amount = div.querySelector('.result-amount').childNodes[0].nodeValue.trim();
            const unit = div.querySelector('.result-unit').innerText;
            lines.push(`- ${name}: ${amount} ${unit}`);
        });

        const textToCopy = lines.join('\n');
        navigator.clipboard.writeText(textToCopy).then(() => {
            const btn = document.getElementById('copyBtn');
            const ogText = btn.innerText;
            btn.innerText = 'Disalin!';
            btn.classList.replace('bg-primary', 'bg-emerald-600');
            setTimeout(() => {
                btn.innerText = ogText;
                btn.classList.replace('bg-emerald-600', 'bg-primary');
            }, 2000);
        });
    }

</script>
@endpush
@endsection
