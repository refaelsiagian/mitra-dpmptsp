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
                    @php
                        $pendingReceivedCount = $receivedProposals->where('status', 'pending')->count();
                    @endphp
                    @if($pendingReceivedCount > 0)
                    <span class="ml-1 bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-[10px] font-black">{{ $pendingReceivedCount }}</span>
                    @endif
                </button>
                <button id="tab-btn-terkirim" onclick="switchRfpTab('terkirim')" class="whitespace-nowrap py-4 text-sm font-bold text-slate-500 border-b-2 border-transparent hover:text-slate-800 transition-colors flex items-center gap-2 tab-btn snap-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                    {{ $isUMKM ? 'Proposal Terkirim' : 'Ketertarikan Terkirim' }}
                </button>
                <button id="tab-btn-undangan" onclick="switchRfpTab('undangan')" class="whitespace-nowrap py-4 text-sm font-bold text-slate-500 border-b-2 border-transparent hover:text-slate-800 transition-colors flex items-center gap-2 tab-btn snap-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    {{ $isUMKM ? 'Undangan Masuk' : 'Undangan Terkirim' }}
                    @php
                        $pendingInvitesCount = $isUMKM ? $receivedInvitations->where('status', 'pending')->count() : 0;
                    @endphp
                    @if($pendingInvitesCount > 0)
                    <span class="ml-1 bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-[10px] font-black">{{ $pendingInvitesCount }}</span>
                    @endif
                </button>
                <button id="tab-btn-draf" onclick="switchRfpTab('draf')" class="whitespace-nowrap py-4 text-sm font-bold text-slate-500 border-b-2 border-transparent hover:text-slate-800 transition-colors flex items-center gap-2 tab-btn snap-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                    Draft Tersimpan
                </button>
                <button id="tab-btn-selesai" onclick="switchRfpTab('selesai')" class="whitespace-nowrap py-4 text-sm font-bold text-slate-500 border-b-2 border-transparent hover:text-slate-800 transition-colors flex items-center gap-2 tab-btn snap-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Proyek Selesai
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
                <div class="relative w-auto shrink-0 self-start sm:self-auto">
                    @php
                        $pendingCount = $receivedProposals->where('status', 'pending')->count();
                        $reviewedCount = $receivedProposals->where('status', 'reviewed')->count();
                        $negotiatingCount = $receivedProposals->where('status', 'negotiating')->count();
                    @endphp
                    <select id="filter-status-masuk" class="w-auto min-w-[200px] appearance-none pl-4 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer text-slate-700 font-medium">
                        <option value="">Semua Status</option>
                        <option value="pending" selected>Menunggu Review {{ $pendingCount > 0 ? "($pendingCount)" : "" }}</option>
                        <option value="reviewed">Sedang Direview {{ $reviewedCount > 0 ? "($reviewedCount)" : "" }}</option>
                        <option value="negotiating">Tahap Negosiasi {{ $negotiatingCount > 0 ? "($negotiatingCount)" : "" }}</option>
                        <option value="accepted">Diterima</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"><path d="m6 9 6 6 6-6"/></svg>
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
            <div class="proposal-masuk-item flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group bg-white" data-project-id="{{ $proposal->project_id }}" data-status="{{ $proposal->status }}">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $statusColor }} tracking-wide uppercase">{{ $statusLabel }}</span>
                        @if($proposal->is_invited)
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-indigo-100 text-indigo-700 tracking-wide uppercase flex items-center gap-1 border border-indigo-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                                Jalur Undangan
                            </span>
                        @endif
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
            
            <!-- JS Filter Empty State -->
            <div id="empty-state-masuk" class="text-center py-10 bg-slate-50 rounded-xl border border-slate-200 border-dashed" style="display: none;">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
                <h3 class="text-slate-900 font-bold mb-1">Tidak Ada Hasil</h3>
                <p class="text-slate-500 text-sm">Tidak ada proposal yang sesuai dengan filter status atau pencarian Anda.</p>
            </div>
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
        
        <!-- Project List Content: Undangan -->
        <div id="content-undangan" class="tab-content p-6 space-y-4 hidden">
            @if($isUMKM)
                <!-- UMKM View: Undangan Masuk -->
                @forelse($receivedInvitations as $invitation)
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group bg-white">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                @if($invitation->status === 'pending')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-700 tracking-wide uppercase">Undangan Baru</span>
                                @elseif($invitation->status === 'accepted')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-700 tracking-wide uppercase">Proposal Dikirim</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-red-100 text-red-700 tracking-wide uppercase">Ditolak</span>
                                @endif
                                <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">{{ $invitation->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors block mb-1">
                                <a href="{{ route('vendor.show', $invitation->invitingCompany->id) }}">{{ $invitation->invitingCompany->name }}</a>
                            </h3>
                            <p class="text-sm text-slate-500 mb-2">Mengundang Anda ke proyek: <a href="{{ route('projects.show', $invitation->project->id) }}" class="font-semibold text-blue-600 hover:underline">{{ $invitation->project->title }}</a></p>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            @if($invitation->status === 'pending')
                                <div x-data="{ showRejectModal: false }">
                                    <button type="button" @click="showRejectModal = true" class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-bold rounded-lg transition-colors whitespace-nowrap">
                                        Tolak
                                    </button>
                                    <!-- Reject Modal -->
                                    <div x-show="showRejectModal" 

                                         style="display: none;" 
                                         class="fixed inset-0 z-[100] flex items-center justify-center p-4">
                                        
                                        <div x-show="showRejectModal" 
                                             x-transition.opacity 
                                             class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" 
                                             @click="showRejectModal = false"></div>
                                        
                                        <div x-show="showRejectModal" 
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                             x-transition:leave="transition ease-in duration-200"
                                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                             class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl p-6 sm:max-w-md w-full border border-slate-200 z-10">
                                            <h3 class="text-lg font-bold text-slate-900 mb-2">Tolak Undangan?</h3>
                                            <p class="text-sm text-slate-500 mb-5">Apakah Anda yakin ingin menolak tawaran proyek "{{ $invitation->project->title }}" dari {{ $invitation->invitingCompany->name }}?</p>
                                            <div class="flex justify-end gap-3">
                                                <button type="button" @click="showRejectModal = false" class="px-4 py-2 text-sm font-bold text-slate-700 bg-white border border-slate-300 rounded-lg shadow-sm hover:bg-slate-50">Batal</button>
                                                <form action="{{ route('invitations.update', $invitation->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="action" value="reject">
                                                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-red-600 border border-transparent rounded-lg shadow-sm hover:bg-red-700">Ya, Tolak</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('proposals.create', $invitation->project->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap">
                                    Buat Penawaran
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                        </div>
                        <h3 class="text-slate-900 font-bold mb-1">Belum ada Undangan Masuk</h3>
                        <p class="text-slate-500 text-sm">Undangan langsung dari Usaha Besar akan muncul di sini.</p>
                    </div>
                @endforelse
            @else
                <!-- UB View: Undangan Terkirim -->
                @forelse($sentInvitations as $invitation)
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group bg-white">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                @if($invitation->status === 'pending')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-700 tracking-wide uppercase">Menunggu Respons</span>
                                @elseif($invitation->status === 'accepted')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-700 tracking-wide uppercase">Proposal Dikirim</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-red-100 text-red-700 tracking-wide uppercase">Ditolak</span>
                                @endif
                                <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">Diundang: {{ $invitation->created_at->format('d M Y') }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors block mb-1">
                                <a href="{{ route('vendor.show', $invitation->invitedCompany->id) }}">{{ $invitation->invitedCompany->name }}</a>
                            </h3>
                            <p class="text-sm text-slate-500 mb-2">Diundang ke proyek: <a href="{{ route('projects.show', $invitation->project->id) }}" class="font-semibold text-blue-600 hover:underline">{{ $invitation->project->title }}</a></p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                        </div>
                        <h3 class="text-slate-900 font-bold mb-1">Belum ada Undangan Terkirim</h3>
                        <p class="text-slate-500 text-sm">Anda belum mengundang UMKM manapun ke proyek Anda.</p>
                    </div>
                @endforelse
            @endif
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

        <!-- Project List Content: Selesai -->
        <div id="content-selesai" class="tab-content p-6 space-y-4 hidden">
            @if($closedProjects->count() > 0)
                <div class="space-y-4">
                    @foreach($closedProjects as $project)
                        @php
                            $badgeClass = 'bg-slate-50 text-slate-700 border-slate-200';
                            $badgeText = ucfirst($project->type);

                            switch($project->type) {
                                case 'subkontrak':
                                    $badgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
                                    $badgeText = 'Subkontrak';
                                    break;
                                case 'rantai_pasok':
                                    $badgeClass = 'bg-indigo-50 text-indigo-700 border-indigo-200';
                                    $badgeText = 'Rantai Pasok';
                                    break;
                                case 'outsourcing':
                                    $badgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
                                    $badgeText = 'Penyumberluaran (Outsourcing)';
                                    break;
                                case 'konstruksi':
                                    $badgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                                    $badgeText = 'Konstruksi';
                                    break;
                                case 'kso':
                                    $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    $badgeText = 'Kerja Sama Operasional (KSO)';
                                    break;
                                case 'perdagangan':
                                    $badgeClass = 'bg-purple-50 text-purple-700 border-purple-200';
                                    $badgeText = 'Perdagangan Umum';
                                    break;
                                case 'distribusi':
                                    $badgeClass = 'bg-teal-50 text-teal-700 border-teal-200';
                                    $badgeText = 'Distribusi & Keagenan';
                                    break;
                            }
                        @endphp
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group">
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] sm:text-xs font-bold uppercase tracking-wider border {!! $badgeClass !!}">
                                            {{ $badgeText }}
                                        </div>
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] sm:text-xs font-bold uppercase tracking-wider border bg-slate-200 text-slate-700 border-slate-300">
                                            Selesai
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 mb-2">
                                        <a href="{{ route('projects.show', $project->id) }}" class="hover:text-blue-600 transition-colors">{{ $project->title }}</a>
                                    </h3>
                                    <p class="text-slate-600 text-sm mb-4 leading-relaxed line-clamp-2">{{ Str::limit($project->description, 150) }}</p>
                                    
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('projects.show', $project->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition-colors shadow-sm">
                                            Lihat Detail Proyek
                                        </a>
                                        
                                        <!-- Toggle Visibility Form -->
                                        @if($project->is_public)
                                            <div x-data="{ showHideModal: false }">
                                                <button type="button" @click="showHideModal = true" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition-colors shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                                                    Sembunyikan
                                                </button>

                                                <!-- Hide Modal -->
                                                <template x-teleport="body">
                                                    <div x-show="showHideModal" 
                                                         x-transition:enter="transition ease-out duration-300"
                                                         x-transition:enter-start="opacity-0"
                                                         x-transition:enter-end="opacity-100"
                                                         x-transition:leave="transition ease-in duration-200"
                                                         x-transition:leave-start="opacity-100"
                                                         x-transition:leave-end="opacity-0"
                                                         class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4"
                                                         style="display: none;">
                                                         
                                                         <div x-show="showHideModal"
                                                              @click.away="showHideModal = false"
                                                              x-transition:enter="transition ease-out duration-300"
                                                              x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                              x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                              x-transition:leave="transition ease-in duration-200"
                                                              x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                              x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                              class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden relative flex flex-col max-h-full">
                                                            <div class="p-6 overflow-y-auto">
                                                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-600"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                                                                </div>
                                                                <h3 class="text-xl font-black text-slate-900 mb-2">Sembunyikan Proyek?</h3>
                                                                <p class="text-slate-600 text-sm mb-4 leading-relaxed">
                                                                    Proyek <span class="font-bold">"{{ $project->title }}"</span> tidak akan lagi ditampilkan di profil publik Anda. Namun, data dan riwayat kemitraan akan tetap tersimpan di dashboard ini.
                                                                </p>
                                                            </div>
                                                            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-3 shrink-0">
                                                                <button type="button" @click="showHideModal = false" class="px-5 py-2.5 text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-200 bg-slate-100 rounded-xl transition-colors">
                                                                    Batal
                                                                </button>
                                                                <form action="{{ route('projects.toggle-visibility', $project->id) }}" method="POST" class="m-0">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit" class="w-full px-5 py-2.5 text-sm font-bold text-white bg-slate-800 hover:bg-slate-900 rounded-xl transition-colors shadow-sm">
                                                                        Ya, Sembunyikan
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        @else
                                            <form action="{{ route('projects.toggle-visibility', $project->id) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-50 border border-blue-200 hover:bg-blue-100 text-blue-700 text-xs font-bold rounded-lg transition-colors shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                                    Tampilkan di Profil
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Selected Partners -->
                                <div class="w-full md:w-1/3 bg-white border border-slate-200 rounded-xl p-4 shrink-0">
                                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                                        Mitra Terpilih
                                    </h4>
                                    @if($project->proposals && $project->proposals->where('status', 'accepted')->count() > 0)
                                        <div class="space-y-3">
                                            @foreach($project->proposals->where('status', 'accepted') as $proposal)
                                                <a href="{{ route('vendor.show', $proposal->company->id) }}" class="flex items-center gap-3 p-2 -mx-2 rounded-lg hover:bg-slate-50 transition-colors group/partner">
                                                    @if($proposal->company->logo)
                                                        <img src="{{ Storage::url($proposal->company->logo) }}" alt="{{ $proposal->company->name }}" class="w-8 h-8 rounded-full object-cover border border-slate-200 shadow-sm">
                                                    @else
                                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs border border-slate-200 shrink-0 shadow-sm">
                                                            {{ substr($proposal->company->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <div class="overflow-hidden">
                                                        <p class="text-sm font-bold text-slate-900 truncate group-hover/partner:text-blue-600 transition-colors">{{ $proposal->company->name }}</p>
                                                        <p class="text-xs text-slate-500 truncate">{{ $proposal->company->kblis->first()->description ?? 'Mitra Usaha' }}</p>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-slate-500 italic mt-2">Selesai tanpa kemitraan terjalin via platform.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-slate-50 border border-slate-200 border-dashed rounded-2xl p-12 text-center">
                    <div class="w-16 h-16 bg-white border border-slate-200 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-400 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Belum ada Proyek Selesai</h3>
                    <p class="text-slate-500 max-w-md mx-auto text-sm">Proyek yang telah Anda tutup akan tampil di sini sebagai riwayat.</p>
                </div>
            @endif
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
            function filterProposalsByProject(projectId, title) {
                // Switch to masuk tab
                switchRfpTab('masuk');
                
                // Set search query to the exact project title
                const searchInput = document.getElementById('search-masuk');
                if (searchInput) {
                    searchInput.value = title;
                }
                
                // Reset status filter to 'Semua Status' so all proposals for this project are visible
                const statusInput = document.getElementById('filter-status-masuk');
                if (statusInput) {
                    statusInput.value = '';
                }
                
                // Trigger input event to run the filter logic
                if (searchInput) {
                    searchInput.dispatchEvent(new Event('input'));
                }
                
                // Scroll to content
                document.getElementById('content-masuk').scrollIntoView({ behavior: 'smooth' });
            }

            function filterMasukList() {
                const searchInput = document.getElementById('search-masuk');
                const statusInput = document.getElementById('filter-status-masuk');
                const searchLower = searchInput ? searchInput.value.toLowerCase() : '';
                const statusFilter = statusInput ? statusInput.value.toLowerCase() : '';
                
                const items = document.querySelectorAll('.proposal-masuk-item');
                let visibleCount = 0;
                
                items.forEach(item => {
                    const text = item.innerText.toLowerCase();
                    const itemStatus = (item.getAttribute('data-status') || '').toLowerCase();
                    
                    const matchesSearch = text.includes(searchLower);
                    const matchesStatus = statusFilter === '' || itemStatus === statusFilter;
                    
                    if (matchesSearch && matchesStatus) {
                        item.style.display = 'flex';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });
                
                const emptyState = document.getElementById('empty-state-masuk');
                if (emptyState && items.length > 0) {
                    emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
                    if (visibleCount === 0) {
                        const statusText = statusInput && statusInput.options[statusInput.selectedIndex] ? statusInput.options[statusInput.selectedIndex].text : '';
                        const typeText = '{{ $isUMKM ? 'Ketertarikan' : 'Proposal' }}';
                        
                        const titleEl = emptyState.querySelector('h3');
                        const descEl = emptyState.querySelector('p');
                        
                        if (searchLower === '') {
                            titleEl.innerText = `Belum ada ${typeText} ${statusText}`;
                            descEl.innerText = `Tidak ada ${typeText.toLowerCase()} yang berada dalam tahap ${statusText}.`;
                        } else {
                            titleEl.innerText = `Pencarian Tidak Ditemukan`;
                            const statusPart = statusFilter === '' ? '' : ` dengan status ${statusText}`;
                            descEl.innerText = `Tidak ada ${typeText.toLowerCase()}${statusPart} yang sesuai dengan pencarian "${searchInput.value}".`;
                        }
                    }
                }
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
                const statusMasuk = document.getElementById('filter-status-masuk');
                if(searchMasuk) searchMasuk.addEventListener('input', filterMasukList);
                if(statusMasuk) statusMasuk.addEventListener('change', filterMasukList);
                
                // Initial filter run for 'masuk' to enforce default 'pending'
                filterMasukList();

                const searchAktif = document.getElementById('search-aktif');
                if(searchAktif) searchAktif.addEventListener('input', (e) => filterAktifList(e.target.value));

                const searchTerkirim = document.getElementById('search-terkirim');
                const statusTerkirim = document.getElementById('filter-status-terkirim');
                if(searchTerkirim) searchTerkirim.addEventListener('input', filterTerkirimList);
                if(statusTerkirim) statusTerkirim.addEventListener('change', filterTerkirimList);
            });
        </script>
