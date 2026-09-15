@props(['rab', 'hideTitle' => false, 'noCard' => false])

@if($rab && $rab->categories->count() > 0)
<div class="{{ $noCard ? '' : 'bg-white p-6 rounded-2xl border border-slate-200 shadow-sm mt-6' }}">
    @if(!$hideTitle)
    <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
        <div>
            <h3 class="text-lg font-bold text-slate-900">{{ $rab->title ?? 'Rencana Anggaran Biaya (RAB)' }}</h3>
            <p class="text-sm text-slate-500">Rincian detail anggaran biaya yang diajukan.</p>
        </div>
    </div>
    @endif
    
    <div class="overflow-x-auto custom-scrollbar rounded-xl border border-slate-200 pb-2">
        <table class="w-full text-sm text-left text-slate-600 min-w-[700px]">
            <thead class="text-xs text-slate-700 uppercase bg-slate-100 border-b border-slate-200">
                <tr>
                    <th class="px-2 py-3 w-12 text-center border-r border-slate-200">No</th>
                    <th class="px-2 py-3 text-center border-r border-slate-200">Nama Komponen</th>
                    <th class="px-2 py-3 w-20 text-center border-r border-slate-200">Volume</th>
                    <th class="px-2 py-3 w-24 text-center border-r border-slate-200">Satuan</th>
                    <th class="px-2 py-3 w-40 text-center border-r border-slate-200">Harga Satuan</th>
                    <th class="px-2 py-3 w-[1%] whitespace-nowrap text-center">Total Harga</th>
                </tr>
            </thead>
            @foreach($rab->categories as $cIndex => $category)
            <tbody class="border-b border-slate-200 last:border-0">
                <tr class="bg-blue-50/50 border-b border-slate-100">
                    <td class="px-2 py-3 text-center font-bold text-blue-700 border-r border-slate-200">{{ $cIndex + 1 }}</td>
                    <td class="px-2 py-3 font-bold text-slate-800 border-r border-slate-200" colspan="4">{{ $category->name }}</td>
                    <td class="px-2 py-3 text-right font-bold text-blue-700 bg-blue-50/30 border-r border-slate-200 whitespace-nowrap">
                        Rp{{ number_format($category->total_amount, 0, ',', '.') }}
                    </td>
                </tr>
                @forelse($category->items as $iIndex => $item)
                <tr class="bg-white border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition-colors">
                    <td class="px-2 py-2 text-center text-slate-400 text-xs font-semibold border-r border-slate-100">{{ $cIndex + 1 }}.{{ $iIndex + 1 }}</td>
                    <td class="px-2 py-2 border-r border-slate-100">{{ $item->name }}</td>
                    <td class="px-2 py-2 text-center border-r border-slate-100">{{ rtrim(rtrim(number_format($item->volume, 2, ',', '.'), '0'), ',') }}</td>
                    <td class="px-2 py-2 text-center border-r border-slate-100">{{ $item->unit }}</td>
                    <td class="px-2 py-2 text-center border-r border-slate-100">Rp{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td class="pr-2 pl-8 py-2 text-right font-medium text-slate-700 border-r border-slate-100 whitespace-nowrap">Rp{{ number_format($item->total_price, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr class="bg-white border-b border-slate-50 last:border-0">
                    <td colspan="6" class="px-2 py-3 text-center text-xs text-slate-400">Tidak ada rincian untuk kategori ini.</td>
                </tr>
                @endforelse
            </tbody>
            @endforeach
        </table>
    </div>

    <!-- Grand Total Section -->
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Rencana Anggaran</p>
            <p class="text-xs text-slate-400">Penjumlahan otomatis dari seluruh kategori utama di atas.</p>
        </div>
        <div class="text-right">
            <p class="text-xs font-bold text-slate-500 mb-0.5 uppercase tracking-wider">Grand Total</p>
            <p class="text-xl md:text-2xl font-black text-slate-800 tracking-tight">Rp{{ number_format($rab->total_amount, 0, ',', '.') }}</p>
        </div>
    </div>
</div>
@endif
