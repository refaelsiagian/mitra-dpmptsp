@props(['initialData' => null])

<div x-data="rabBuilder({{ $initialData ? json_encode($initialData) : '[]' }})" class="space-y-4">
    <style>
        /* Sembunyikan panah/spinner pada input number */
        .no-spinners::-webkit-inner-spin-button, 
        .no-spinners::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        .no-spinners {
            -moz-appearance: textfield;
        }
    </style>
    
    <!-- Hidden input for form submission -->
    <input type="hidden" name="rab_data" :value="JSON.stringify(categories)">
    
    <!-- We also autofill estimated_value in parent form -->
    <input type="hidden" name="estimated_value" :value="grandTotal">
    
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Rencana Anggaran Biaya (RAB)</h3>
            <p class="text-sm text-slate-500">Buat rincian anggaran biaya proyek Anda di sini. Total otomatis dihitung.</p>
        </div>
        <button type="button" @click="addCategory()" class="shrink-0 px-2 py-2 bg-slate-800 text-white text-sm font-bold rounded-xl hover:bg-slate-900 transition-colors flex items-center gap-2 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Kategori Utama
        </button>
    </div>

    <div class="w-full border border-slate-200 rounded-xl overflow-x-auto bg-white shadow-sm">
        <table class="w-full min-w-[800px] text-sm text-left text-slate-600">
            <thead class="text-xs text-slate-700 uppercase bg-slate-100 border-b border-slate-200">
                <tr>
                    <th class="px-2 py-3 w-12 text-center border-r border-slate-200">No</th>
                    <th class="px-2 py-3 text-center border-r border-slate-200">Nama Komponen</th>
                    <th class="px-2 py-3 w-24 text-center border-r border-slate-200">Volume</th>
                    <th class="px-2 py-3 w-24 text-center border-r border-slate-200">Satuan</th>
                    <th class="px-2 py-3 w-48 text-center border-r border-slate-200">Harga Satuan</th>
                    <th class="px-2 py-3 w-[1%] whitespace-nowrap text-center">Total Harga</th>
                </tr>
            </thead>
            
            <template x-if="categories.length === 0">
                <tbody>
                    <tr>
                        <td colspan="6" class="px-2 py-8 text-center text-slate-400">Belum ada data RAB. Klik "Kategori Utama" untuk mulai.</td>
                    </tr>
                </tbody>
            </template>

            <template x-for="(category, catIndex) in categories" :key="category.id">
                <tbody class="border-b border-slate-200">
                    <!-- Category Header Row -->
                    <tr class="bg-blue-50/50 border-b border-slate-100">
                        <td class="px-2 py-3 text-center font-bold text-blue-700 border-r border-slate-200 relative group">
                            <span x-text="catIndex + 1"></span>
                            <button type="button" @click="removeCategory(catIndex)" class="absolute top-1 right-1 text-red-400 hover:text-red-600 hover:bg-red-50 rounded p-0.5 transition-colors" title="Hapus Kategori">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </td>
                        <td class="px-2 py-3 border-r border-slate-200" colspan="4">
                            <div class="flex items-center gap-2">
                                <input type="text" x-model="category.name" placeholder="Kategori (mis: Persiapan)" class="px-3 py-1.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full font-bold text-slate-700 bg-white shadow-sm">
                                <button type="button" @click="addItem(catIndex)" class="shrink-0 px-2.5 py-1.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-lg hover:bg-blue-200 flex items-center gap-1 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg> Sub
                                </button>
                            </div>
                        </td>
                        <td class="px-2 py-3 text-right font-bold text-blue-700 bg-blue-50/30 border-r border-slate-200 whitespace-nowrap" x-text="formatCurrency(getCategoryTotal(catIndex))"></td>
                    </tr>
                    
                    <!-- Items Row -->
                    <template x-for="(item, itemIndex) in category.items" :key="item.id">
                        <tr class="bg-white border-b border-slate-100 last:border-0 hover:bg-slate-50/50 transition-colors group">
                            <td class="px-2 py-2 text-center text-slate-400 text-xs font-semibold border-r border-slate-100 relative">
                                <span x-text="(catIndex + 1) + '.' + (itemIndex + 1)"></span>
                                <button type="button" @click="removeItem(catIndex, itemIndex)" class="absolute top-1 right-1 text-red-400 hover:text-red-600 hover:bg-red-50 rounded p-0.5 transition-colors" title="Hapus Sub Komponen">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                </button>
                            </td>
                            <td class="px-2 py-2 border-r border-slate-100">
                                <input type="text" x-model="item.name" placeholder="Nama Sub Komponen" class="w-full px-3 py-1.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 shadow-sm">
                            </td>
                            <td class="px-2 py-2 border-r border-slate-100">
                                <input type="number" x-model.number="item.volume" min="0" step="any" class="no-spinners w-full px-3 py-1.5 text-sm text-right border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="0" @wheel="$el.blur()">
                            </td>
                            <td class="px-2 py-2 border-r border-slate-100">
                                <input type="text" x-model="item.unit" placeholder="unit/ls" class="w-full px-3 py-1.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 shadow-sm">
                            </td>
                            <td class="px-2 py-2 relative border-r border-slate-100">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 text-sm">Rp</span>
                                <input type="number" x-model.number="item.unit_price" min="0" step="any" class="no-spinners w-full pl-8 pr-3 py-1.5 text-sm text-right border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="0" @wheel="$el.blur()">
                            </td>
                            <td class="pr-2 pl-8 py-2 text-right font-bold text-slate-700 bg-slate-50/50 whitespace-nowrap" x-text="formatCurrency(item.volume * item.unit_price)"></td>
                        </tr>
                    </template>
                    
                    <!-- If category has no items -->
                    <template x-if="category.items.length === 0">
                        <tr class="bg-white">
                            <td colspan="6" class="px-2 py-3 text-center text-xs text-slate-400">Tidak ada sub komponen. Klik "+ Sub" untuk menambahkan.</td>
                        </tr>
                    </template>
                </tbody>
            </template>
            
        </table>
    </div>

    <!-- Grand Total Section -->
    <div class="mt-6 flex flex-col md:flex-row justify-between items-end md:items-center gap-4">
        <div>
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Rencana Anggaran</p>
            <p class="text-xs text-slate-400">Penjumlahan otomatis dari seluruh kategori utama di atas.</p>
        </div>
        <div class="bg-slate-800 text-white rounded-xl px-6 py-4 shadow-sm border border-slate-700 min-w-[250px] text-right relative overflow-hidden">
            <!-- Decorative Accent -->
            <div class="absolute inset-y-0 left-0 w-1 bg-emerald-500"></div>
            
            <p class="text-xs font-bold text-slate-400 mb-1 uppercase tracking-wider">Grand Total</p>
            <p class="text-xl md:text-2xl font-bold text-emerald-400 tracking-tight" x-text="formatCurrency(grandTotal)"></p>
        </div>
    </div>
</div>
