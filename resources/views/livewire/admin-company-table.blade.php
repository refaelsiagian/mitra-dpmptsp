<div>
    <div class="mb-4">
        <div class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="ph ph-magnifying-glass text-slate-400 text-lg"></i>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors shadow-sm" placeholder="Cari perusahaan, NIB, atau email...">
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden relative">
        <!-- Loading Overlay -->
        <div wire:loading.flex class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-white/60 backdrop-blur-[2px]">
            <i class="ph ph-spinner-gap animate-spin text-4xl text-blue-600 mb-2"></i>
            <span class="text-sm font-medium text-slate-600">Memuat data...</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Nama Perusahaan</th>
                        <th class="px-6 py-4 font-semibold">Jenis Pelaku Usaha</th>
                        <th class="px-6 py-4 font-semibold">NIB</th>
                        <th class="px-6 py-4 font-semibold">Tanggal Daftar</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 relative" wire:loading.class="opacity-50 pointer-events-none transition-opacity duration-300">
                    @forelse($companies as $company)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $company->name }}</div>
                                <div class="text-xs text-slate-500">{{ $company->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ ucwords(str_replace('-', ' ', $company->pelaku_usaha_type)) }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-700">
                                {{ $company->nib_number }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $company->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($company->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Menunggu
                                    </span>
                                @elseif($company->status === 'verified')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Terverifikasi
                                    </span>
                                @elseif($company->status === 'rejected')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Perlu Revisi
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($company->status === 'pending')
                                    <a wire:navigate href="{{ route('admin.review', $company->id) }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white rounded text-sm font-medium transition-colors">
                                        <i class="ph ph-magnifying-glass"></i> Review
                                    </a>
                                @else
                                    <a wire:navigate href="{{ route('admin.review', $company->id) }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-50 text-slate-600 hover:bg-slate-200 hover:text-slate-900 rounded text-sm font-medium transition-colors">
                                        <i class="ph ph-eye"></i> Lihat Profil
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="ph ph-magnifying-glass text-4xl text-slate-300 mb-3" x-show="search !== ''"></i>
                                    <i class="ph ph-folder-open text-4xl text-slate-300 mb-3" x-show="search === ''"></i>
                                    <p>{{ $search ? 'Tidak ada perusahaan yang cocok dengan pencarian Anda.' : 'Belum ada perusahaan yang mendaftar.' }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($companies->hasPages())
        <div class="mt-4">
            {{ $companies->links() }}
        </div>
    @endif
</div>
