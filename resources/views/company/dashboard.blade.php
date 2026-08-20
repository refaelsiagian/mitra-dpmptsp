@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto pb-10">
    
    @php $isUMKM = in_array(strtolower(auth()->user()->company->skala_usaha ?? ''), ['mikro', 'kecil']); @endphp
    
    <!-- Page Header (Welcome Message) -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6 md:mb-8">
        <div>
            <p class="text-sm font-semibold text-slate-500 mb-0.5">
                Selamat datang 👋
            </p>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight mb-1.5">
                {{ auth()->user()->company->name ?? 'Mitra DPMPTSP' }}
            </h1>
            <p class="text-xs font-medium text-slate-400">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </p>
        </div>
        
        <!-- Dynamic Role Buttons (Hidden on Mobile) -->
        <div class="hidden md:block">
            @if($isUMKM)
            <a href="{{ route('projects.create') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Tawarkan Kemitraan
            </a>
            @else
            <a href="{{ route('projects.create') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Buat Proyek
            </a>
            @endif
        </div>
    </div>

    <!-- Quick Stats (Scrollable on Mobile) -->
    <div class="flex overflow-x-auto pb-4 md:pb-0 md:grid md:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-10 snap-x snap-mandatory hide-scrollbar">
        <!-- Stat 1 -->
        <div class="min-w-[280px] sm:min-w-[320px] md:min-w-0 flex-shrink-0 snap-center bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ $isUMKM ? 'Penawaran Aktif' : 'Pengadaan Aktif (Diterbitkan)' }}</p>
                <p class="text-2xl font-black text-slate-900">2</p>
            </div>
        </div>
        <!-- Stat 2 -->
        <div class="min-w-[280px] sm:min-w-[320px] md:min-w-0 flex-shrink-0 snap-center bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ $isUMKM ? 'Peminat / Kontak Masuk' : 'Total Proposal Masuk' }}</p>
                <p class="text-2xl font-black text-slate-900">{{ $receivedProposals->count() }}</p>
            </div>
        </div>
        <!-- Stat 3 -->
        <div class="min-w-[280px] sm:min-w-[320px] md:min-w-0 flex-shrink-0 snap-center bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M12 6v6l4 2"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ $isUMKM ? 'Proposal Terkirim' : 'Ketertarikan Terkirim' }}</p>
                <p class="text-2xl font-black text-slate-900">{{ $sentProposals->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content Area with Tabs -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm relative">
        
        <!-- Tab Navigation -->
        <div class="sticky top-0 z-30 border-b border-slate-200 px-4 md:px-6 flex items-center justify-between gap-4 bg-white/95 backdrop-blur-sm rounded-t-2xl">
            <div class="flex items-center gap-6 md:gap-8 overflow-x-auto hide-scrollbar snap-x flex-1">
                <button id="tab-btn-diterbitkan" onclick="switchRfpTab('diterbitkan')" class="whitespace-nowrap py-4 text-sm font-bold text-blue-700 border-b-2 border-blue-600 flex items-center gap-2 tab-btn snap-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                    {{ $isUMKM ? 'Katalog Penawaran Aktif' : 'Proyek Diterbitkan' }}
                </button>
                <button id="tab-btn-masuk" onclick="switchRfpTab('masuk')" class="whitespace-nowrap py-4 text-sm font-bold text-slate-500 border-b-2 border-transparent hover:text-slate-800 transition-colors flex items-center gap-2 tab-btn snap-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    {{ $isUMKM ? 'Ketertarikan Masuk' : 'Proposal Masuk' }}
                    @if($receivedProposals->count() > 0)
                    <span class="ml-1 bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-[10px] font-black">{{ $receivedProposals->count() }}</span>
                    @endif
                </button>
                <button id="tab-btn-terkirim" onclick="switchRfpTab('terkirim')" class="whitespace-nowrap py-4 text-sm font-bold text-slate-500 border-b-2 border-transparent hover:text-slate-800 transition-colors flex items-center gap-2 tab-btn snap-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                    {{ $isUMKM ? 'Proposal Terkirim' : 'Ketertarikan Terkirim' }}
                </button>
                <button id="tab-btn-draf" onclick="switchRfpTab('draf')" class="whitespace-nowrap py-4 text-sm font-bold text-slate-500 border-b-2 border-transparent hover:text-slate-800 transition-colors flex items-center gap-2 tab-btn snap-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                    Draft Tersimpan
                </button>
            </div>
            
            <!-- Mobile Action Button (Near Tabs) -->
            <div class="md:hidden flex-shrink-0">
                @if($isUMKM)
                <a href="{{ route('projects.create') }}" class="p-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow-sm flex items-center justify-center" title="Tawarkan Kemitraan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                </a>
                @else
                <a href="{{ route('projects.create') }}" class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm flex items-center justify-center" title="Buat Proyek">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                </a>
                @endif
            </div>
        </div>

        <!-- Project List Content: Diterbitkan -->
        <div id="content-diterbitkan" class="tab-content p-6 space-y-4 block">
            
            <!-- Filter & Search Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div class="relative w-full max-w-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input id="search-aktif" type="text" placeholder="{{ $isUMKM ? 'Cari judul penawaran/layanan...' : 'Cari judul pengadaan/proyek...' }}" class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
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

            @forelse($publishedProjects as $project)
            <div class="project-aktif-item">
                <x-dashboard.project-card :project="$project" />
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

        <!-- Project List Content: Proposal Masuk -->
        <div id="content-masuk" class="tab-content p-6 space-y-4 hidden">
            <!-- Filter & Search Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div class="relative w-full max-w-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input id="search-masuk" type="text" placeholder="Cari {{ $isUMKM ? 'ketertarikan' : 'proposal' }} masuk..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>
            </div>

            @forelse($receivedProposals as $proposal)
            @php
                $statusColor = match($proposal->status) {
                    'pending' => 'bg-amber-100 text-amber-700',
                    'reviewed' => 'bg-blue-100 text-blue-700',
                    'negotiating' => 'bg-purple-100 text-purple-700',
                    'accepted' => 'bg-emerald-100 text-emerald-700',
                    'rejected' => 'bg-red-100 text-red-700',
                    default => 'bg-slate-100 text-slate-700',
                };
                
                $statusLabel = match($proposal->status) {
                    'pending' => 'Menunggu Review',
                    'reviewed' => 'Sedang Direview',
                    'negotiating' => 'Tahap Negosiasi',
                    'accepted' => 'Diterima',
                    'rejected' => 'Ditolak',
                    default => 'Tidak Diketahui',
                };
            @endphp
            <!-- Received Proposal Item -->
            <div class="proposal-masuk-item flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group bg-white" data-project-id="{{ $proposal->project_id }}">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $statusColor }} tracking-wide uppercase">{{ $statusLabel }}</span>
                        <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">Diterima: {{ $proposal->created_at->format('d M Y') }}</span>
                    </div>
                    <a href="{{ route('proposals.show', $proposal->id) }}" class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors block mb-1">
                        Dari: {{ $proposal->company->name }}
                    </a>
                    <p class="text-sm text-slate-500 mb-2">Terkait Proyek/Katalog: <a href="{{ route('projects.show', $proposal->project->id) }}" class="font-semibold text-blue-600 hover:underline">{{ $proposal->project->title }}</a></p>
                </div>
                
                <div class="flex items-center gap-6 md:border-l border-slate-200 md:pl-6">
                    <div class="text-center">
                        <p class="text-xs text-slate-400 font-medium mb-0.5">{{ $isUMKM ? 'Anggaran Diajukan' : 'Nilai Penawaran' }}</p>
                        <p class="text-sm font-black text-slate-800">{{ $proposal->estimated_value ? 'Rp ' . number_format($proposal->estimated_value, 0, ',', '.') : 'TBA' }}</p>
                    </div>
                    <a href="{{ route('proposals.show', $proposal->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap">
                        Lihat & Review
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-10 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <h3 class="text-slate-900 font-bold mb-1">Belum ada {{ $isUMKM ? 'Ketertarikan' : 'Proposal' }} Masuk</h3>
                <p class="text-slate-500 text-sm">Belum ada yang mengirimkan penawaran atau ketertarikan pada proyek Anda.</p>
            </div>
            @endforelse
        </div>
<!-- Project List Content: Proposal Terkirim -->
        <div id="content-terkirim" class="tab-content p-6 space-y-4 hidden">
            <!-- Filter & Search Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div class="relative w-full max-w-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input id="search-terkirim" type="text" placeholder="Cari proposal terkirim..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>
                <div class="flex items-center gap-2">
                    <select id="filter-status-terkirim" class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-700 focus:outline-none">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Review">Menunggu Review</option>
                        <option value="Sedang Direview">Sedang Direview</option>
                        <option value="Tahap Negosiasi">Tahap Negosiasi</option>
                        <option value="Diterima">Diterima</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                </div>
            </div>

            @forelse($sentProposals as $proposal)
            @php
                $statusColor = match($proposal->status) {
                    'pending' => 'bg-amber-100 text-amber-700',
                    'reviewed' => 'bg-blue-100 text-blue-700',
                    'negotiating' => 'bg-purple-100 text-purple-700',
                    'accepted' => 'bg-emerald-100 text-emerald-700',
                    'rejected' => 'bg-red-100 text-red-700',
                    default => 'bg-slate-100 text-slate-700',
                };
                
                $statusLabel = match($proposal->status) {
                    'pending' => 'Menunggu Review',
                    'reviewed' => 'Sedang Direview',
                    'negotiating' => 'Tahap Negosiasi',
                    'accepted' => 'Diterima',
                    'rejected' => 'Ditolak',
                    default => 'Tidak Diketahui',
                };
                
                $isKetertarikan = $isUMKM ? false : true;
            @endphp
            <!-- Sent Proposal Item -->
            <div class="proposal-terkirim-item flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group bg-white" data-status="{{ $statusLabel }}">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $statusColor }} tracking-wide uppercase">{{ $statusLabel }}</span>
                        <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">Terkirim: {{ $proposal->created_at->format('d M Y') }}</span>
                    </div>
                    <a href="{{ route('projects.show', $proposal->project->id) }}" class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors block mb-1">
                        {{ $proposal->project->title }}
                    </a>
                    <p class="text-sm text-slate-500 mb-2">Penyelenggara: <span class="font-semibold text-slate-700">{{ $proposal->project->company->name ?? 'Tidak Diketahui' }}</span></p>
                </div>
                
                <div class="flex items-center gap-6 md:border-l border-slate-200 md:pl-6">
                    <div class="text-center">
                        <p class="text-xs text-slate-400 font-medium mb-0.5">{{ $isKetertarikan ? 'Nilai / Anggaran' : 'Penawaran Anda' }}</p>
                        <p class="text-sm font-black text-slate-800">{{ $proposal->estimated_value ? 'Rp ' . number_format($proposal->estimated_value, 0, ',', '.') : 'TBA' }}</p>
                    </div>
                    <a href="{{ route('proposals.show', $proposal->id) }}" class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 text-sm font-bold rounded-lg transition-colors whitespace-nowrap">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-10 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                </div>
                <h3 class="text-slate-900 font-bold mb-1">Belum ada {{ $isUMKM ? 'Proposal' : 'Ketertarikan' }} Terkirim</h3>
                <p class="text-slate-500 text-sm">Anda belum mengirimkan ketertarikan atau penawaran ke proyek manapun.</p>
            </div>
            @endforelse
        </div>

        <!-- Project List Content: Draft Tersimpan -->
        <div id="content-draf" class="tab-content p-6 space-y-4 hidden">
            @forelse($draftProjects as $draft)
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 border-dashed hover:border-slate-300 transition-all bg-slate-50/50">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-200 text-slate-600 tracking-wide uppercase">Draft</span>
                        <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">Diedit terakhir: {{ $draft->updated_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-lg font-bold text-slate-900 block mb-1">
                        {{ $draft->title ?: 'Tanpa Judul' }}
                    </p>
                    <p class="text-sm text-slate-500 line-clamp-1">{{ Str::limit($draft->description, 100) ?: 'Belum ada deskripsi.' }}</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <form action="{{ route('projects.destroy', $draft->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus draf ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 text-sm font-bold rounded-lg transition-colors whitespace-nowrap">
                            Hapus Draft
                        </button>
                    </form>
                    <a href="{{ route('projects.edit', $draft->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                        Lanjutkan Edit
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-10 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10.4 12.6a2 2 0 1 1 3 3L8 21l-4 1 1-4Z"/><path d="M18 18h-2.5c-.83 0-1.5-.67-1.5-1.5V14"/><path d="M12 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6Z"/></svg>
                </div>
                <h3 class="text-slate-900 font-bold mb-1">Tidak ada draf</h3>
                <p class="text-slate-500 text-sm">Anda tidak memiliki draf penawaran atau proyek yang tersimpan.</p>
            </div>
            @endforelse
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

        <script>
            function filterProposalsByProject(projectId, projectTitle) {
                // Switch to the proposal masuk tab
                switchRfpTab('masuk');
                
                // Set the search input value
                const searchInput = document.getElementById('search-masuk');
                if (searchInput) {
                    searchInput.value = projectTitle;
                    // Trigger input event to do the filtering if we had a JS filter, 
                    // or we can just implement the filter right here
                    filterMasukList(projectTitle);
                }
                
                // Scroll to top of list
                document.getElementById('content-masuk').scrollIntoView({ behavior: 'smooth' });
            }

            function filterMasukList(query) {
                const searchLower = query.toLowerCase();
                const items = document.querySelectorAll('.proposal-masuk-item');
                
                items.forEach(item => {
                    const text = item.innerText.toLowerCase();
                    if (text.includes(searchLower)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            function filterAktifList(query) {
                const searchLower = query.toLowerCase();
                const items = document.querySelectorAll('.project-aktif-item');
                
                items.forEach(item => {
                    const text = item.innerText.toLowerCase();
                    if (text.includes(searchLower)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            function filterTerkirimList() {
                const searchInput = document.getElementById('search-terkirim');
                const statusInput = document.getElementById('filter-status-terkirim');
                const searchLower = searchInput ? searchInput.value.toLowerCase() : '';
                const statusFilter = statusInput ? statusInput.value.toLowerCase() : '';
                
                const items = document.querySelectorAll('.proposal-terkirim-item');
                
                items.forEach(item => {
                    const text = item.innerText.toLowerCase();
                    const itemStatus = (item.getAttribute('data-status') || '').toLowerCase();
                    
                    const matchesSearch = text.includes(searchLower);
                    const matchesStatus = statusFilter === '' || itemStatus === statusFilter;
                    
                    if (matchesSearch && matchesStatus) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
            
            // Add event listeners
            document.addEventListener('DOMContentLoaded', function() {
                const searchMasuk = document.getElementById('search-masuk');
                if(searchMasuk) searchMasuk.addEventListener('input', (e) => filterMasukList(e.target.value));

                const searchAktif = document.getElementById('search-aktif');
                if(searchAktif) searchAktif.addEventListener('input', (e) => filterAktifList(e.target.value));

                const searchTerkirim = document.getElementById('search-terkirim');
                const statusTerkirim = document.getElementById('filter-status-terkirim');
                if(searchTerkirim) searchTerkirim.addEventListener('input', filterTerkirimList);
                if(statusTerkirim) statusTerkirim.addEventListener('change', filterTerkirimList);
            });
        </script>
