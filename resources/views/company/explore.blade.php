@extends('layouts.dashboard')

@php
    $userScale = auth()->check() && auth()->user()->company ? auth()->user()->company->skala_usaha : null;
    
    // Default Tab Labels
    $tab1Label = 'Mitra & Vendor';
    $tab2Label = 'Peluang Proyek (RFP/KSO)';

    if ($userScale === 'besar') {
        $tab1Label = 'Mitra UMKM';
        $tab2Label = 'Tawaran Kemitraan';
    } elseif (in_array($userScale, ['mikro', 'kecil', 'menengah'])) {
        $tab1Label = 'Mitra Usaha Besar';
        $tab2Label = 'Proyek Kemitraan';
    }
@endphp

@section('content')
<div class="max-w-5xl mx-auto flex flex-col h-full">
    
    <!-- Header Row 1: Title & Tabs -->
    <div class="mb-3 flex-shrink-0 flex flex-col md:flex-row md:items-center justify-between gap-3">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Eksplorasi Peluang & Mitra Bisnis</h2>
        
        <!-- Compact Marketplace Tab Bar -->
        <div class="bg-slate-200/80 p-1 rounded-xl flex items-center gap-1 self-start md:self-auto border border-slate-300/50 w-full sm:w-auto overflow-x-auto custom-scrollbar flex-nowrap">
            <button id="tab-btn-vendors" onclick="switchTab('vendors')" class="flex-1 sm:flex-initial min-w-0 justify-center px-2 sm:px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 flex items-center gap-1.5 bg-white text-blue-700 shadow-sm text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
                <span class="truncate">{{ $tab1Label }}</span>
                <span class="flex-shrink-0 px-1.5 py-0.2 rounded-full bg-blue-100 text-blue-700 text-[10px] font-extrabold">{{ $vendors->total() }}</span>
            </button>
            <button id="tab-btn-projects" onclick="switchTab('projects')" class="flex-1 sm:flex-initial min-w-0 justify-center px-2 sm:px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 flex items-center gap-1.5 text-slate-600 hover:text-slate-900 hover:bg-white/50 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span class="truncate">{{ $tab2Label }}</span>
                <span class="flex-shrink-0 px-1.5 py-0.2 rounded-full bg-slate-300 text-slate-800 text-[10px] font-extrabold">{{ $projects->total() }}</span>
            </button>
        </div>
    </div>

    <!-- Header Row 2: Search Bar & Filter Button -->
    <form action="{{ route('explore') }}" method="GET" id="explore-form">
        <!-- Preserve Tab State -->
        <input type="hidden" name="tab" value="{{ request('tab') }}" id="form-tab-input">
        
        <div class="mb-4 flex-shrink-0 flex items-center gap-2.5">
            <!-- Search Input -->
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" onchange="document.getElementById('explore-form').submit()" class="block w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow bg-white shadow-2xs hover:border-slate-300" placeholder="Cari nama perusahaan, judul proyek, keahlian KBLI, atau lokasi...">
            </div>

            <!-- Filter Toggle Button -->
            <button type="button" onclick="toggleFilters()" id="filter-toggle-btn" class="inline-flex items-center gap-1.5 px-3 sm:px-3.5 py-2 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 transition-colors shadow-2xs flex-shrink-0 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ (request('kbli') || request('location') || request('scheme')) ? 'bg-blue-50 border-blue-300 text-blue-700' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                <span class="hidden sm:inline">Filter</span>
                <span id="filter-badge" class="{{ (request('kbli') || request('location') || request('scheme')) ? 'block' : 'hidden' }} w-1.5 h-1.5 rounded-full bg-blue-600 ml-0.5"></span>
            </button>
        </div>

    <!-- Collapsible Filter Toolbar (Hidden by default) -->
    <!-- Collapsible Filter Toolbar -->
    <div id="filter-panel" class="{{ (request('kbli') || request('location') || request('scheme')) ? 'block' : 'hidden' }} bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm mb-4 flex-shrink-0 transition-all duration-300">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-2.5 w-full sm:w-auto">
                
                <!-- Kategori KBLI Dropdown (Mitra Only) -->
                <div class="relative {{ request('tab') == 'projects' ? 'hidden' : '' }} z-20" id="filter-kbli" x-data="{ 
                    open: false, 
                    value: '{{ request('kbli') }}', 
                    options: {
                        '': 'Kategori KBLI (Semua)',
                        'konstruksi': 'Konstruksi & Infrastruktur',
                        'pariwisata': 'Pariwisata & Hospitality',
                        'pertanian': 'Pertanian & Komoditas',
                        'logistik': 'Logistik & Pergudangan'
                    }
                }">
                    <input type="hidden" name="kbli" x-ref="input" value="{{ request('kbli') }}">
                    <button type="button" @click="open = !open" @click.away="open = false" class="w-full sm:w-auto min-w-[200px] flex items-center justify-between gap-2 px-4 py-2 bg-white border border-slate-200 hover:border-blue-300 hover:ring-1 hover:ring-blue-100 rounded-xl text-sm transition-all text-left text-slate-700 font-medium shadow-sm">
                        <span x-text="options[value]"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         class="absolute top-full left-0 mt-2 w-64 bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden py-1"
                         style="display: none;">
                        <template x-for="(label, key) in options" :key="key">
                            <button type="button" @click="value = key; $refs.input.value = key; $nextTick(() => document.getElementById('explore-form').submit()); open = false" class="w-full flex items-center px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600 text-left transition-colors" :class="value === key ? 'bg-blue-50 text-blue-700 font-semibold' : ''">
                                <span x-text="label"></span>
                                <svg x-show="value === key" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="ml-auto text-blue-600"><polyline points="20 6 9 17 4 12"/></svg>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Lokasi Dropdown -->
                <div class="relative z-10" x-data="{ 
                    open: false, 
                    value: '{{ request('location') }}', 
                    options: {
                        '': 'Lokasi (Semua)',
                        'medan': 'Sumatera Utara (Medan / Belawan)',
                        'jakarta': 'DKI Jakarta & Sekitarnya',
                        'surabaya': 'Jawa Timur (Surabaya)',
                        'aceh': 'Aceh'
                    }
                }">
                    <input type="hidden" name="location" x-ref="input" value="{{ request('location') }}">
                    <button type="button" @click="open = !open" @click.away="open = false" class="w-full sm:w-auto min-w-[200px] flex items-center justify-between gap-2 px-4 py-2 bg-white border border-slate-200 hover:border-blue-300 hover:ring-1 hover:ring-blue-100 rounded-xl text-sm transition-all text-left text-slate-700 font-medium shadow-sm">
                        <span x-text="options[value]"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         class="absolute top-full left-0 mt-2 w-64 bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden py-1"
                         style="display: none;">
                        <template x-for="(label, key) in options" :key="key">
                            <button type="button" @click="value = key; $refs.input.value = key; $nextTick(() => document.getElementById('explore-form').submit()); open = false" class="w-full flex items-center px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600 text-left transition-colors" :class="value === key ? 'bg-blue-50 text-blue-700 font-semibold' : ''">
                                <span x-text="label"></span>
                                <svg x-show="value === key" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="ml-auto text-blue-600"><polyline points="20 6 9 17 4 12"/></svg>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Skema / Peluang Dropdown (Project Only) -->
                <div class="relative {{ request('tab') == 'projects' ? '' : 'hidden' }} z-0" id="filter-scheme" x-data="{ 
                    open: false, 
                    value: '{{ request('scheme') }}', 
                    options: {
                        '': 'Skema Peluang (Semua)',
                        'konstruksi': 'Konstruksi (RFP)',
                        'subkontrak': 'Sub-Pekerjaan',
                        'kso': 'Kemitraan (KSO)',
                        'rantai_pasok': 'Rantai Pasok (Suplai)'
                    }
                }">
                    <input type="hidden" name="scheme" x-ref="input" value="{{ request('scheme') }}">
                    <button type="button" @click="open = !open" @click.away="open = false" class="w-full sm:w-auto min-w-[200px] flex items-center justify-between gap-2 px-4 py-2 bg-white border border-slate-200 hover:border-blue-300 hover:ring-1 hover:ring-blue-100 rounded-xl text-sm transition-all text-left text-slate-700 font-medium shadow-sm">
                        <span x-text="options[value]"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         class="absolute top-full left-0 mt-2 w-64 bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden py-1"
                         style="display: none;">
                        <template x-for="(label, key) in options" :key="key">
                            <button type="button" @click="value = key; $refs.input.value = key; $nextTick(() => document.getElementById('explore-form').submit()); open = false" class="w-full flex items-center px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600 text-left transition-colors" :class="value === key ? 'bg-blue-50 text-blue-700 font-semibold' : ''">
                                <span x-text="label"></span>
                                <svg x-show="value === key" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="ml-auto text-blue-600"><polyline points="20 6 9 17 4 12"/></svg>
                            </button>
                        </template>
                    </div>
                </div>

            </div>

            <!-- Reset Filter -->
            <a href="{{ route('explore', ['tab' => request('tab')]) }}" class="text-xs font-medium text-slate-500 hover:text-red-600 transition-colors flex items-center gap-1.5 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                Reset Filter
            </a>
        </div>
    </div>
    </form>

    <!-- TAB FEED 1: VENDORS -->
    <div id="feed-vendors" class="flex-1 overflow-y-auto pb-8 pr-2 custom-scrollbar transition-opacity duration-300">
        <div class="flex flex-col gap-4" id="list-vendors">
            
            @forelse($vendors as $vendor)
            <div class="card-item">
                @include('components.vendor-card', [
                    'name' => $vendor->name, 
                    'category' => 'Usaha ' . ucfirst($vendor->skala_usaha ?? 'Lainnya') . ' - ' . ($vendor->pelaku_usaha_detail ?: 'Perorangan'), 
                    'location' => optional(optional($vendor->locations->first())->regency)->name ?? 'Lokasi belum diset',
                    'profileUrl' => route('vendor.show', $vendor->id),
                    'logo' => $vendor->logo,
                    'chips' => $vendor->kblis->pluck('name')->take(3)->toArray()
                ])
            </div>
            @empty
            <div class="text-center py-10 text-slate-500 bg-white rounded-xl shadow-sm border border-slate-200">
                Tidak ada mitra & vendor yang ditemukan.
            </div>
            @endforelse

            <div class="mt-2">
                {{ $vendors->appends(request()->query())->links() }}
            </div>

        </div>
    </div>

    <!-- TAB FEED 2: PROJECTS & OPPORTUNITIES -->
    <div id="feed-projects" class="flex-1 overflow-y-auto pb-8 pr-2 custom-scrollbar transition-opacity duration-300 hidden">
        <div class="flex flex-col gap-4" id="list-projects">
            
            @forelse($projects as $project)
            <div class="card-item">
                @include('components.project-card', [
                    'type' => $project->type,
                    'typeLabel' => ucfirst(str_replace('_', ' ', $project->type)),
                    'title' => $project->title,
                    'company' => $project->company->name,
                    'companyUrl' => route('vendor.show', $project->company->id),
                    'location' => $project->location ?? (optional(optional($project->company->locations->first())->regency)->name ?? 'Lokasi belum diset'),
                    'category' => optional($project->company->kblis->first())->name ?? 'Umum',
                    'valueLabel' => 'Estimasi Nilai',
                    'value' => $project->estimated_value ? 'Rp ' . number_format($project->estimated_value, 0, ',', '.') : 'Sesuai Kesepakatan',
                    'deadline' => $project->offer_end_date ? 'Batas Waktu: ' . $project->offer_end_date->format('d M Y') : 'Terbuka',
                    'url' => route('projects.show', $project->id),
                    'description' => \Illuminate\Support\Str::limit($project->description, 120),
                    'ctaText' => in_array(strtolower(auth()->user()->company->skala_usaha ?? ''), ['mikro', 'kecil', 'menengah']) ? 'Lihat Peluang Proyek' : 'Lihat Tawaran Kemitraan'
                ])
            </div>
            @empty
            <div class="text-center py-10 text-slate-500 bg-white rounded-xl shadow-sm border border-slate-200">
                Tidak ada peluang proyek yang ditemukan.
            </div>
            @endforelse

            <div class="mt-2">
                {{ $projects->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>

<!-- JavaScript Controllers -->
<script>
    function toggleFilters() {
        const panel = document.getElementById('filter-panel');
        const btn = document.getElementById('filter-toggle-btn');
        if (panel.classList.contains('hidden')) {
            panel.classList.remove('hidden');
            btn.classList.add('bg-blue-50', 'border-blue-300', 'text-blue-700');
        } else {
            panel.classList.add('hidden');
            btn.classList.remove('bg-blue-50', 'border-blue-300', 'text-blue-700');
        }
    }



    function switchTab(tabName) {
        const feedVendors = document.getElementById('feed-vendors');
        const feedProjects = document.getElementById('feed-projects');
        const btnVendors = document.getElementById('tab-btn-vendors');
        const btnProjects = document.getElementById('tab-btn-projects');

        // (Search filter is now handled server-side)

        if (tabName === 'projects') {
            document.getElementById('form-tab-input').value = 'projects';
            feedVendors.classList.add('hidden');
            feedProjects.classList.remove('hidden');
            
            btnProjects.classList.add('bg-white', 'text-blue-700', 'shadow-sm');
            btnProjects.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-white/50');
            
            btnVendors.classList.remove('bg-white', 'text-blue-700', 'shadow-sm');
            btnVendors.classList.add('text-slate-600', 'hover:text-slate-900', 'hover:bg-white/50');

            const url = new URL(window.location);
            url.searchParams.set('tab', 'projects');
            window.history.replaceState({}, '', url);
            
            // Toggle filters
            document.getElementById('filter-kbli')?.classList.add('hidden');
            document.getElementById('filter-scheme')?.classList.remove('hidden');
        } else {
            document.getElementById('form-tab-input').value = '';
            feedProjects.classList.add('hidden');
            feedVendors.classList.remove('hidden');
            
            btnVendors.classList.add('bg-white', 'text-blue-700', 'shadow-sm');
            btnVendors.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-white/50');
            
            btnProjects.classList.remove('bg-white', 'text-blue-700', 'shadow-sm');
            btnProjects.classList.add('text-slate-600', 'hover:text-slate-900', 'hover:bg-white/50');

            const url = new URL(window.location);
            url.searchParams.delete('tab');
            window.history.replaceState({}, '', url);
            
            // Toggle filters
            document.getElementById('filter-kbli')?.classList.remove('hidden');
            document.getElementById('filter-scheme')?.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        if (params.get('tab') === 'projects') {
            switchTab('projects');
        }
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 20px;
    }
</style>
@endsection
