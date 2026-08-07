@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto pb-10">
    
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            @php $isUMKM = in_array(strtolower(auth()->user()->company->skala_usaha ?? ''), ['mikro', 'kecil']); @endphp
            
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">
                {{ $isUMKM ? 'Manajemen Kemitraan & Penawaran' : 'Manajemen RFP & KSO' }}
            </h1>
            
            @if($isUMKM)
                <p class="text-slate-500 font-medium">Kelola profil penawaran Anda (KSO, Distribusi, Jasa) dan pantau statusnya.</p>
            @else
                <p class="text-slate-500 font-medium">Kelola tender yang Anda terbitkan dan pantau status proposal vendor yang masuk.</p>
            @endif
        </div>
        
        <!-- Dynamic Role Buttons -->
        @if($isUMKM)
        <a href="{{ route('projects.create') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tawarkan Kemitraan / Layanan
        </a>
        @else
        <a href="{{ route('projects.create') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Buat Proyek / Pengadaan (RFP)
        </a>
        @endif
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Stat 1 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ $isUMKM ? 'Penawaran Aktif' : 'Pengadaan Aktif (Diterbitkan)' }}</p>
                <p class="text-2xl font-black text-slate-900">2</p>
            </div>
        </div>
        <!-- Stat 2 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ $isUMKM ? 'Peminat / Kontak Masuk' : 'Total Proposal Masuk' }}</p>
                <p class="text-2xl font-black text-slate-900">14</p>
            </div>
        </div>
        <!-- Stat 3 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M12 6v6l4 2"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Proposal Terkirim (Menunggu)</p>
                <p class="text-2xl font-black text-slate-900">3</p>
            </div>
        </div>
    </div>

    <!-- Main Content Area with Tabs -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Tab Navigation -->
        <div class="border-b border-slate-200 px-6 flex items-center gap-8 bg-slate-50/50">
            <button id="tab-btn-diterbitkan" onclick="switchRfpTab('diterbitkan')" class="py-4 text-sm font-bold text-blue-700 border-b-2 border-blue-600 flex items-center gap-2 tab-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                {{ $isUMKM ? 'Katalog Penawaran Aktif' : 'Proyek (RFP) Diterbitkan' }}
            </button>
            <button id="tab-btn-terkirim" onclick="switchRfpTab('terkirim')" class="py-4 text-sm font-bold text-slate-500 border-b-2 border-transparent hover:text-slate-800 transition-colors flex items-center gap-2 tab-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                Proposal Terkirim
            </button>
            <button id="tab-btn-draf" onclick="switchRfpTab('draf')" class="py-4 text-sm font-bold text-slate-500 border-b-2 border-transparent hover:text-slate-800 transition-colors flex items-center gap-2 tab-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                Draft Tersimpan
            </button>
        </div>

        <!-- Project List Content: Diterbitkan -->
        <div id="content-diterbitkan" class="tab-content p-6 space-y-4 block">
            
            <!-- Filter & Search Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div class="relative w-full max-w-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" placeholder="{{ $isUMKM ? 'Cari judul penawaran/layanan...' : 'Cari judul pengadaan/proyek...' }}" class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>
                <div class="flex items-center gap-2">
                    <select class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-700 focus:outline-none">
                        <option>Semua Status</option>
                        <option>Aktif Bidding</option>
                        <option>Sedang Berjalan</option>
                        <option>Selesai</option>
                    </select>
                </div>
            </div>

            @forelse($projects as $project)
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group bg-white">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        @php
                            $badgeColor = 'bg-slate-100 text-slate-700';
                            switch($project->type) {
                                case 'subkontrak': $badgeColor = 'bg-blue-100 text-blue-700'; break;
                                case 'rantai_pasok': $badgeColor = 'bg-indigo-100 text-indigo-700'; break;
                                case 'outsourcing': $badgeColor = 'bg-rose-100 text-rose-700'; break;
                                case 'konstruksi': $badgeColor = 'bg-amber-100 text-amber-700'; break;
                                case 'kso': $badgeColor = 'bg-emerald-100 text-emerald-700'; break;
                                case 'perdagangan': $badgeColor = 'bg-purple-100 text-purple-700'; break;
                                case 'distribusi': $badgeColor = 'bg-teal-100 text-teal-700'; break;
                            }
                        @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $badgeColor }} tracking-wide uppercase">
                            {{ str_replace('_', ' ', $project->type) }}
                        </span>
                        <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">Dipublikasikan: {{ $project->created_at->format('d M Y') }}</span>
                    </div>
                    <a href="{{ route('projects.show', $project->id) }}" class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors block mb-1">
                        {{ $project->title }}
                    </a>
                    <p class="text-sm text-slate-500 line-clamp-1">{{ Str::limit($project->description, 100) }}</p>
                </div>
                
                <div class="flex items-center gap-6 md:border-l border-slate-200 md:pl-6">
                    <div class="text-center">
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Proposal Masuk</p>
                        <p class="text-xl font-black text-slate-800">0</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Sisa Waktu</p>
                        <p class="text-sm font-bold text-amber-600">
                            @if($project->offer_end_date)
                                {{ \Carbon\Carbon::parse($project->offer_end_date)->diffForHumans(null, true) }}
                            @else
                                Terbuka
                            @endif
                        </p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('projects.show', $project->id) }}" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                            Lihat Detail
                        </a>
                        <a href="{{ route('projects.edit', $project->id) }}" class="w-full px-4 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                            Edit Proyek
                        </a>
                        <!-- Form Delete -->
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-1.5 bg-white border border-red-200 hover:bg-red-50 text-red-600 text-xs font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-10 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 7h10"/><path d="M7 12h10"/><path d="M7 17h10"/></svg>
                </div>
                <h3 class="text-slate-900 font-bold mb-1">{{ $isUMKM ? 'Belum ada Penawaran' : 'Belum ada Pengadaan' }}</h3>
                <p class="text-slate-500 text-sm">{{ $isUMKM ? 'Buat profil layanan/katalog Anda agar mudah ditemukan oleh Usaha Besar.' : 'Terbitkan tender / RFP baru untuk menemukan vendor UMKM.' }}</p>
            </div>
            @endforelse
        </div>

        <!-- Project List Content: Proposal Terkirim -->
        <div id="content-terkirim" class="tab-content p-6 space-y-4 hidden">
            <!-- Filter & Search Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div class="relative w-full max-w-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" placeholder="Cari proposal terkirim..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>
                <div class="flex items-center gap-2">
                    <select class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-700 focus:outline-none">
                        <option>Semua Status</option>
                        <option>Menunggu Review</option>
                        <option>Lolos Seleksi</option>
                        <option>Ditolak</option>
                    </select>
                </div>
            </div>

            <!-- Sent Proposal Item 1 -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group bg-white">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-700 tracking-wide uppercase">Menunggu Review</span>
                        <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">Terkirim: 27 Jul 2026</span>
                    </div>
                    <a href="#" class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors block mb-1">
                        Pengadaan Katering Karyawan Pabrik Cikarang
                    </a>
                    <p class="text-sm text-slate-500 mb-2">Penyelenggara: <span class="font-semibold text-slate-700">PT Astra Manufaktur</span></p>
                </div>
                
                <div class="flex items-center gap-6 md:border-l border-slate-200 md:pl-6">
                    <div class="text-center">
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Penawaran Anda</p>
                        <p class="text-sm font-black text-slate-800">Rp 125.000.000</p>
                    </div>
                    <a href="#" class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 text-sm font-bold rounded-lg transition-colors whitespace-nowrap">
                        Lihat Proposal
                    </a>
                </div>
            </div>
            
            <!-- Sent Proposal Item 2 -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group bg-white">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-700 tracking-wide uppercase">Lolos Seleksi</span>
                        <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">Terkirim: 10 Jul 2026</span>
                    </div>
                    <a href="#" class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors block mb-1">
                        Kemitraan Jasa Pembersihan Area Pabrik (Cleaning Service)
                    </a>
                    <p class="text-sm text-slate-500 mb-2">Penyelenggara: <span class="font-semibold text-slate-700">PT Waskita Karya (Persero)</span></p>
                </div>
                
                <div class="flex items-center gap-6 md:border-l border-slate-200 md:pl-6">
                    <div class="text-center">
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Penawaran Anda</p>
                        <p class="text-sm font-black text-slate-800">Sistem Bagi Hasil / KSO</p>
                    </div>
                    <a href="#" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap">
                        Tindak Lanjut
                    </a>
                </div>
            </div>
        </div>

        <!-- Project List Content: Draft Tersimpan -->
        <div id="content-draf" class="tab-content p-6 space-y-4 hidden">
            <!-- Draft Item 1 -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 border-dashed hover:border-slate-300 transition-all bg-slate-50/50">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-200 text-slate-600 tracking-wide uppercase">Draft</span>
                        <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">Diedit terakhir: 2 jam lalu</span>
                    </div>
                    <p class="text-lg font-bold text-slate-900 block mb-1">
                        Pembuatan Aplikasi Monitoring Limbah B3
                    </p>
                    <p class="text-sm text-slate-500 line-clamp-1">Kelengkapan data: 60%. Menunggu dokumen spesifikasi teknis (TOR) diunggah.</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <button class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 text-sm font-bold rounded-lg transition-colors whitespace-nowrap">
                        Hapus Draft
                    </button>
                    <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                        Lanjutkan Edit
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- JavaScript for Tab Switching -->
<script>
    function switchRfpTab(tabId) {
        // 1. Reset all buttons
        const allBtns = document.querySelectorAll('.tab-btn');
        allBtns.forEach(btn => {
            btn.classList.remove('text-blue-700', 'border-blue-600');
            btn.classList.add('text-slate-500', 'border-transparent');
        });

        // 2. Hide all contents
        const allContents = document.querySelectorAll('.tab-content');
        allContents.forEach(content => {
            content.classList.add('hidden');
            content.classList.remove('block');
        });

        // 3. Activate selected button
        const selectedBtn = document.getElementById('tab-btn-' + tabId);
        if(selectedBtn) {
            selectedBtn.classList.remove('text-slate-500', 'border-transparent');
            selectedBtn.classList.add('text-blue-700', 'border-blue-600');
        }

        // 4. Show selected content
        const selectedContent = document.getElementById('content-' + tabId);
        if(selectedContent) {
            selectedContent.classList.remove('hidden');
            selectedContent.classList.add('block');
        }
    }
</script>
@endsection
