@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto pb-10">
    
    @php $isUMKM = auth()->user()->company?->isUMKM(); @endphp
    
    <!-- Page Header (Welcome Message) -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6 md:mb-8">
        <div>
            <p class="text-sm font-semibold text-slate-500 mb-0.5">
                Selamat datang 👋
            </p>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight mb-1.5">
                {{ auth()->user()->company->name ?? 'Mitra DPMPTSP' }}
            </h1>
            <p class="text-xs font-medium text-slate-400">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </p>
        </div>
        
        <!-- Dynamic Role Buttons (Hidden on Mobile) -->
        <div class="hidden md:block">
            @if($isUMKM)
            <a wire:navigate href="{{ route('projects.create') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Tawarkan Kemitraan
            </a>
            @else
            <a wire:navigate href="{{ route('projects.create') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
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
                <p class="text-2xl font-bold text-slate-900">{{ $quickStats['activeCount'] ?? 0 }}</p>
            </div>
        </div>
        <!-- Stat 2 -->
        <div class="min-w-[280px] sm:min-w-[320px] md:min-w-0 flex-shrink-0 snap-center bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ $isUMKM ? 'Peminat / Kontak Masuk' : 'Total Proposal Masuk' }}</p>
                <p class="text-2xl font-bold text-slate-900">{{ $quickStats['incomingCount'] ?? 0 }}</p>
            </div>
        </div>
        <!-- Stat 3 -->
        <div class="min-w-[280px] sm:min-w-[320px] md:min-w-0 flex-shrink-0 snap-center bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M12 6v6l4 2"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ $isUMKM ? 'Proposal Terkirim' : 'Ketertarikan Terkirim' }}</p>
                <p class="text-2xl font-black text-slate-900">{{ $quickStats['sentCount'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content Area with Tabs -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm relative flex flex-col h-[calc(100vh-16rem)] min-h-[600px] max-h-[800px]">
        
        <!-- Tab Navigation -->
        <div class="shrink-0 z-30 border-b border-slate-200 px-4 md:px-6 flex items-center justify-between gap-4 bg-white/95 backdrop-blur-sm rounded-t-2xl">
            <div class="flex items-center gap-6 md:gap-8 overflow-x-auto hide-scrollbar snap-x flex-1">
                <button id="tab-btn-diterbitkan" onclick="switchRfpTab('diterbitkan')" class="whitespace-nowrap py-4 text-sm font-bold text-blue-700 border-b-2 border-blue-600 flex items-center gap-2 tab-btn snap-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                    {{ $isUMKM ? 'Katalog Penawaran Aktif' : 'Proyek Diterbitkan' }}
                </button>
                <button id="tab-btn-masuk" onclick="switchRfpTab('masuk')" class="whitespace-nowrap py-4 text-sm font-bold text-slate-500 border-b-2 border-transparent hover:text-slate-800 transition-colors flex items-center gap-2 tab-btn snap-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    {{ $isUMKM ? 'Ketertarikan Masuk' : 'Proposal Masuk' }}

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
                <a wire:navigate href="{{ route('projects.create') }}" class="p-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow-sm flex items-center justify-center" title="Tawarkan Kemitraan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                </a>
                @else
                <a wire:navigate href="{{ route('projects.create') }}" class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm flex items-center justify-center" title="Buat Proyek">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                </a>
                @endif
            </div>

        </div>

        <!-- Scrollable Contents Wrapper -->
        <div class="flex-1 min-h-0 overflow-y-auto custom-scrollbar relative rounded-b-2xl">        <!-- Project List Content: Diterbitkan -->
        <div id="content-diterbitkan" class="tab-content p-6 space-y-4 block">
            <livewire:dashboard.tabs.published-projects lazy />
        </div>

        <!-- Project List Content: Proposal Masuk -->
        <div id="content-masuk" class="tab-content p-6 space-y-4 hidden">
            <livewire:dashboard.tabs.incoming-proposals lazy />
        </div>

        <!-- Project List Content: Proposal Terkirim -->
        <div id="content-terkirim" class="tab-content p-6 space-y-4 hidden">
            <livewire:dashboard.tabs.sent-proposals lazy />
        </div>
        
        <!-- Project List Content: Undangan -->
        <div id="content-undangan" class="tab-content p-6 space-y-4 hidden">
            <livewire:dashboard.tabs.invitations lazy />
        </div>

        <!-- Project List Content: Draft Tersimpan -->
        <div id="content-draf" class="tab-content p-6 space-y-4 hidden">
            <livewire:dashboard.tabs.drafts lazy />
        </div>

        <!-- Project List Content: Selesai -->
        <div id="content-selesai" class="tab-content p-6 space-y-4 hidden">
            <livewire:dashboard.tabs.completed-projects lazy />
        </div>
        
        </div> <!-- End Scrollable Wrapper -->

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
    
    // Support filtering from project card click
    function filterProposalsByProject(projectId, title) {
        // Store globally in case the component is currently lazy-loading and misses the event
        window.pendingMasukFilter = title;
        
        switchRfpTab('masuk');
        
        window.dispatchEvent(new CustomEvent('filter-proposals-masuk', { detail: { search: title } }));
        
        document.getElementById('content-masuk').scrollIntoView({ behavior: 'smooth' });
    }
</script>
@endsection
