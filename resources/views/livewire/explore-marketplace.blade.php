<div class="h-full flex flex-col">
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

<div x-data="{ showFilterModal: false }" class="h-full">
<div class="max-w-5xl mx-auto flex flex-col h-full">
    
    <!-- Header Row 1: Title & Tabs -->
    <div class="mb-3 flex-shrink-0 flex flex-col md:flex-row md:items-center justify-between gap-3">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Eksplorasi Peluang & Mitra Bisnis</h2>
        
        <!-- Compact Marketplace Tab Bar -->
        <div class="bg-slate-200/80 p-1 rounded-xl flex items-center gap-1 self-start md:self-auto border border-slate-300/50 w-full sm:w-auto overflow-x-auto custom-scrollbar flex-nowrap">
            <button @click="$wire.activeTab = 'vendors'" 
                :class="$wire.activeTab === 'vendors' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50'"
                class="flex-1 sm:flex-initial min-w-0 justify-center px-2 sm:px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 flex items-center gap-1.5 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
                <span class="truncate">{{ $tab1Label }}</span>
                <span class="flex-shrink-0 px-1.5 py-0.2 rounded-full bg-blue-100 text-blue-700 text-[10px] font-extrabold">{{ $vendors->total() }}</span>
            </button>
            <button @click="$wire.activeTab = 'projects'" 
                :class="$wire.activeTab === 'projects' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50'"
                class="flex-1 sm:flex-initial min-w-0 justify-center px-2 sm:px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 flex items-center gap-1.5 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span class="truncate">{{ $tab2Label }}</span>
                <span class="flex-shrink-0 px-1.5 py-0.2 rounded-full bg-slate-300 text-slate-800 text-[10px] font-extrabold">{{ $projects->total() }}</span>
            </button>
        </div>
    </div>

    <!-- Header Row 2: Search Bar & Filter Button -->
    <div class="mb-4 flex-shrink-0 flex items-center gap-2.5">
        <!-- Search Input -->
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search" class="block w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow bg-white shadow-2xs hover:border-slate-300" placeholder="Cari nama perusahaan, judul proyek, keahlian KBLI, atau lokasi...">
        </div>

        <!-- Filter Toggle Button -->
        <button type="button" @click="showFilterModal = true" class="inline-flex items-center gap-1.5 px-3 sm:px-3.5 py-2 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 transition-colors shadow-2xs flex-shrink-0 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ ($kbli || $province_id || $scheme) ? 'bg-blue-50 border-blue-300 text-blue-700' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            <span class="hidden sm:inline">Filter</span>
            <span class="{{ ($kbli || $province_id || $scheme) ? 'block' : 'hidden' }} w-1.5 h-1.5 rounded-full bg-blue-600 ml-0.5"></span>
        </button>
    </div>

    <!-- TAB FEED 1: VENDORS -->
    <div wire:loading.class="opacity-50 pointer-events-none transition-opacity duration-200" wire:target="search, kbli, scheme, province_id, regency_id, district_id, village_id, resetFilters" x-show="$wire.activeTab === 'vendors'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" id="feed-vendors" class="flex-1 overflow-y-auto pb-8 pr-2 custom-scrollbar relative">
        <!-- Main Loading Spinner -->
        <div wire:loading wire:target="search, kbli, scheme, province_id, regency_id, district_id, village_id, resetFilters" class="absolute inset-0 z-10 flex items-center justify-center">
            <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </div>
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

            <!-- Infinite Scroll Trigger Vendors -->
            @if($vendors->hasMorePages())
                <div x-intersect="$wire.loadMoreVendors()" class="py-6 flex justify-center">
                    <div wire:loading wire:target="loadMoreVendors" class="flex items-center gap-2 text-blue-600 font-medium">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>Memuat lebih banyak...</span>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- TAB FEED 2: PROJECTS & OPPORTUNITIES -->
    <div wire:loading.class="opacity-50 pointer-events-none transition-opacity duration-200" wire:target="search, kbli, scheme, province_id, regency_id, district_id, village_id, resetFilters" x-show="$wire.activeTab === 'projects'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" id="feed-projects" class="flex-1 overflow-y-auto pb-8 pr-2 custom-scrollbar relative">
        <!-- Main Loading Spinner -->
        <div wire:loading wire:target="search, kbli, scheme, province_id, regency_id, district_id, village_id, resetFilters" class="absolute inset-0 z-10 flex items-center justify-center">
            <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </div>
        <div class="flex flex-col gap-4" id="list-projects">
            
            @forelse($projects as $project)
            <div class="card-item">
                @include('components.project-card', [
                    'type' => $project->type,
                    'typeLabel' => ucfirst(str_replace('_', ' ', $project->type)),
                    'title' => $project->title,
                    'company' => $project->company->name,
                    'companyUrl' => route('vendor.show', $project->company->id),
                    'location' => $project->village_id ? ucwords(strtolower($project->district?->name)) . ', ' . ucwords(strtolower($project->regency?->name)) : 'Lokasi belum diset',
                    'valueLabel' => 'Estimasi Nilai',
                    'value' => $project->estimated_value ? 'Rp ' . number_format($project->estimated_value, 0, ',', '.') : 'Sesuai Kesepakatan',
                    'deadline' => $project->offer_end_date ? 'Batas Waktu: ' . $project->offer_end_date->format('d M Y') : 'Terbuka',
                    'url' => route('projects.show', $project->id),
                    'description' => \Illuminate\Support\Str::limit($project->description, 120),
                    'ctaText' => auth()->user()->company?->isUMKM() ? 'Lihat Peluang Proyek' : 'Lihat Tawaran Kemitraan'
                ])
            </div>
            @empty
            <div class="text-center py-10 text-slate-500 bg-white rounded-xl shadow-sm border border-slate-200">
                Tidak ada peluang proyek yang ditemukan.
            </div>
            @endforelse

            <!-- Infinite Scroll Trigger Projects -->
            @if($projects->hasMorePages())
                <div x-intersect="$wire.loadMoreProjects()" class="py-6 flex justify-center">
                    <div wire:loading wire:target="loadMoreProjects" class="flex items-center gap-2 text-blue-600 font-medium">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>Memuat lebih banyak...</span>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

    <!-- Filter Modal -->
    <div x-show="showFilterModal" class="fixed inset-0 z-[100] flex items-center justify-center sm:p-4 p-0" style="display: none;">
        <!-- Backdrop -->
        <div x-show="showFilterModal" x-transition.opacity @click="showFilterModal = false" class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>
        
        <!-- Modal Content -->
        <div x-show="showFilterModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white sm:rounded-2xl w-full max-w-lg h-full sm:h-auto max-h-screen sm:max-h-[85vh] flex flex-col shadow-2xl overflow-hidden">
            
            <!-- Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white shrink-0">
                <h3 class="text-lg font-bold text-slate-900">Filter Eksplorasi</h3>
                <button type="button" @click="showFilterModal = false" class="text-slate-400 hover:text-slate-600 bg-slate-50 hover:bg-slate-100 rounded-full p-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-6 overflow-y-auto custom-scrollbar flex-1">
                <div class="space-y-8">
                    <!-- KBLI Filter -->
                    @if($activeTab !== 'projects')
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Kategori Bidang Usaha</h4>
                        <p class="text-[10px] text-slate-400 font-medium mb-3">Berlaku untuk pencarian pada tab Mitra & Vendor.</p>
                        
                        <!-- KBLI Combobox -->
                        <div x-data="{ 
                            open: false, 
                            search: '',
                            value: @entangle('kbli'),
                            options: {{ Js::from($kblis->map(fn($k) => ['id' => $k->code, 'code' => $k->code, 'name' => $k->name])->values()->all()) }},
                            get filteredOptions() {
                                if (this.search === '') {
                                    return this.options.slice(0, 50); // Show max 50 by default for performance
                                }
                                return this.options.filter(i => 
                                    (i.code + ' ' + i.name).toLowerCase().includes(this.search.toLowerCase())
                                ).slice(0, 50);
                            },
                            get selectedName() {
                                if (!this.value) return 'Pilih KBLI';
                                let option = this.options.find(i => i.id == this.value);
                                return option ? option.code + ' - ' + option.name : 'Pilih KBLI';
                            }
                        }" class="relative" @click.outside="open = false">
                            
                            <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 shadow-sm transition-colors group">
                                <span class="font-medium truncate" :class="value ? 'text-slate-900' : 'text-slate-500'" x-text="selectedName"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 group-hover:text-slate-600 transition-colors shrink-0 ml-2" :class="{'rotate-180': open}"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                            
                            <div x-show="open" style="display: none;" class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg flex flex-col max-h-60" x-transition>
                                <div class="p-2 border-b border-slate-100 shrink-0">
                                    <input type="text" x-model="search" placeholder="Cari KBLI..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
                                </div>
                                <ul class="overflow-y-auto flex-1 p-1 custom-scrollbar">
                                    <li @click="value = ''; open = false" class="px-3 py-2 hover:bg-slate-50 cursor-pointer rounded-lg text-sm font-medium" :class="!value ? 'text-blue-700 bg-blue-50' : 'text-slate-700'">
                                        Semua KBLI
                                    </li>
                                    <template x-for="option in filteredOptions" :key="option.id">
                                        <li @click="value = option.id; open = false" class="px-3 py-2 hover:bg-slate-50 cursor-pointer rounded-lg text-sm" :class="value == option.id ? 'text-blue-700 bg-blue-50 font-medium' : 'text-slate-600'">
                                            <span class="font-bold text-slate-800" x-text="option.code"></span> - <span x-text="option.name"></span>
                                        </li>
                                    </template>
                                    <li x-show="filteredOptions.length === 0" class="px-3 py-4 text-center text-sm text-slate-500">
                                        Tidak ada KBLI yang cocok.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($activeTab !== 'vendors')
                    <!-- Kemitraan Scheme -->
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Skema Kemitraan</h4>
                        <p class="text-[10px] text-slate-400 font-medium mb-3">Berlaku untuk pencarian pada tab Peluang Proyek.</p>
                        <div x-data="{ 
                            open: false, 
                            value: @entangle('scheme'),
                            options: [
                                {value: '', label: 'Semua Skema Kemitraan'},
                                {value: 'subkontrak', label: 'Subkontrak'},
                                {value: 'rantai_pasok', label: 'Rantai Pasok'},
                                {value: 'outsourcing', label: 'Penyumberluaran (Outsourcing)'},
                                {value: 'konstruksi', label: 'Konstruksi'},
                                {value: 'kso', label: 'KSO / Bagi Hasil'},
                                {value: 'distribusi', label: 'Distribusi & Keagenan'},
                                {value: 'perdagangan', label: 'Perdagangan Umum'}
                            ],
                            get selectedLabel() {
                                let opt = this.options.find(o => o.value == this.value);
                                return opt ? opt.label : 'Semua Skema Kemitraan';
                            }
                        }" class="relative" @click.outside="open = false">
                            <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 shadow-sm transition-colors group">
                                <span class="font-medium truncate" :class="value ? 'text-slate-900' : 'text-slate-500'" x-text="selectedLabel"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 group-hover:text-slate-600 transition-colors shrink-0 ml-2" :class="{'rotate-180': open}"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                            
                            <div x-show="open" style="display: none;" class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg flex flex-col max-h-60" x-transition>
                                <ul class="overflow-y-auto flex-1 p-1 custom-scrollbar">
                                    <template x-for="option in options" :key="option.value">
                                        <li @click="value = option.value; open = false" class="px-3 py-2 hover:bg-slate-50 cursor-pointer rounded-lg text-sm" :class="value == option.value ? 'text-blue-700 bg-blue-50 font-medium' : 'text-slate-600'">
                                            <span x-text="option.label"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Hierarchical Location -->
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Area & Lokasi</h4>
                        
                        <div x-data="{
                            province_id: @entangle('province_id'),
                            regency_id: @entangle('regency_id'),
                            district_id: @entangle('district_id'),
                            village_id: @entangle('village_id'),
                            provinces: {{ Js::from($provinces->map(fn($p) => ['id' => (string)$p->id, 'name' => $p->name])->values()->all()) }},
                            regencies: [],
                            districts: [],
                            villages: [],
                            isFetchingRegencies: false,
                            isFetchingDistricts: false,
                            isFetchingVillages: false,
                            
                            async init() {
                                if (this.province_id) await this.fetchRegencies(true);
                                if (this.regency_id) await this.fetchDistricts(true);
                                if (this.district_id) await this.fetchVillages(true);
                            },
                            
                            async fetchRegencies(isInit = false) {
                                if (!isInit) { this.regency_id = ''; this.district_id = ''; this.village_id = ''; }
                                this.regencies = []; this.districts = []; this.villages = [];
                                if (!this.province_id) return;
                                
                                this.isFetchingRegencies = true;
                                try {
                                    let res = await fetch('/api/regencies/' + this.province_id);
                                    this.regencies = await res.json();
                                } finally {
                                    this.isFetchingRegencies = false;
                                }
                            },
                            
                            async fetchDistricts(isInit = false) {
                                if (!isInit) { this.district_id = ''; this.village_id = ''; }
                                this.districts = []; this.villages = [];
                                if (!this.regency_id) return;
                                
                                this.isFetchingDistricts = true;
                                try {
                                    let res = await fetch('/api/districts/' + this.regency_id);
                                    this.districts = await res.json();
                                } finally {
                                    this.isFetchingDistricts = false;
                                }
                            },
                            
                            async fetchVillages(isInit = false) {
                                if (!isInit) { this.village_id = ''; }
                                this.villages = [];
                                if (!this.district_id) return;
                                
                                this.isFetchingVillages = true;
                                try {
                                    let res = await fetch('/api/villages/' + this.district_id);
                                    this.villages = await res.json();
                                } finally {
                                    this.isFetchingVillages = false;
                                }
                            }
                        }" class="space-y-4">
                            
                            <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                                <label class="block text-xs font-bold text-slate-500 mb-1">Provinsi</label>
                                <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 shadow-sm transition-colors group">
                                    <span class="font-medium truncate" :class="province_id ? 'text-slate-900' : 'text-slate-500'" x-text="province_id ? (provinces.find(p => p.id == province_id)?.name || 'Semua Provinsi') : 'Semua Provinsi'"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 group-hover:text-slate-600 transition-colors shrink-0 ml-2" :class="{'rotate-180': open}"><path d="m6 9 6 6 6-6"/></svg>
                                </button>
                                <div x-show="open" style="display: none;" class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg flex flex-col max-h-60" x-transition>
                                    <ul class="overflow-y-auto flex-1 p-1 custom-scrollbar">
                                        <li @click="province_id = ''; fetchRegencies(); open = false" class="px-3 py-2 hover:bg-slate-50 cursor-pointer rounded-lg text-sm" :class="!province_id ? 'text-blue-700 bg-blue-50 font-medium' : 'text-slate-600'">Semua Provinsi</li>
                                        <template x-for="prov in provinces" :key="prov.id">
                                            <li @click="province_id = prov.id; fetchRegencies(); open = false" class="px-3 py-2 hover:bg-slate-50 cursor-pointer rounded-lg text-sm" :class="province_id == prov.id ? 'text-blue-700 bg-blue-50 font-medium' : 'text-slate-600'">
                                                <span x-text="prov.name"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            
                            <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                                <label class="block text-xs font-bold text-slate-500 mb-1">Kabupaten/Kota</label>
                                <button type="button" @click="if(province_id && !isFetchingRegencies) open = !open" class="w-full flex items-center justify-between px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 shadow-sm transition-colors group disabled:bg-slate-50 disabled:text-slate-400 disabled:shadow-none" :disabled="!province_id || isFetchingRegencies">
                                    <span class="font-medium truncate" :class="regency_id ? 'text-slate-900' : 'text-slate-500'" x-text="regency_id ? (regencies.find(r => r.id == regency_id)?.name || 'Semua Kabupaten/Kota') : (isFetchingRegencies ? 'Memuat...' : 'Semua Kabupaten/Kota')"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 group-hover:text-slate-600 transition-colors shrink-0 ml-2" :class="{'rotate-180': open}"><path d="m6 9 6 6 6-6"/></svg>
                                </button>
                                <div x-show="open" style="display: none;" class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg flex flex-col max-h-60" x-transition>
                                    <ul class="overflow-y-auto flex-1 p-1 custom-scrollbar">
                                        <li @click="regency_id = ''; fetchDistricts(); open = false" class="px-3 py-2 hover:bg-slate-50 cursor-pointer rounded-lg text-sm" :class="!regency_id ? 'text-blue-700 bg-blue-50 font-medium' : 'text-slate-600'">Semua Kabupaten/Kota</li>
                                        <template x-for="item in regencies" :key="item.id">
                                            <li @click="regency_id = item.id; fetchDistricts(); open = false" class="px-3 py-2 hover:bg-slate-50 cursor-pointer rounded-lg text-sm" :class="regency_id == item.id ? 'text-blue-700 bg-blue-50 font-medium' : 'text-slate-600'">
                                                <span x-text="item.name"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            
                            <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                                <label class="block text-xs font-bold text-slate-500 mb-1">Kecamatan</label>
                                <button type="button" @click="if(regency_id && !isFetchingDistricts) open = !open" class="w-full flex items-center justify-between px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 shadow-sm transition-colors group disabled:bg-slate-50 disabled:text-slate-400 disabled:shadow-none" :disabled="!regency_id || isFetchingDistricts">
                                    <span class="font-medium truncate" :class="district_id ? 'text-slate-900' : 'text-slate-500'" x-text="district_id ? (districts.find(d => d.id == district_id)?.name || 'Semua Kecamatan') : (isFetchingDistricts ? 'Memuat...' : 'Semua Kecamatan')"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 group-hover:text-slate-600 transition-colors shrink-0 ml-2" :class="{'rotate-180': open}"><path d="m6 9 6 6 6-6"/></svg>
                                </button>
                                <div x-show="open" style="display: none;" class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg flex flex-col max-h-60" x-transition>
                                    <ul class="overflow-y-auto flex-1 p-1 custom-scrollbar">
                                        <li @click="district_id = ''; fetchVillages(); open = false" class="px-3 py-2 hover:bg-slate-50 cursor-pointer rounded-lg text-sm" :class="!district_id ? 'text-blue-700 bg-blue-50 font-medium' : 'text-slate-600'">Semua Kecamatan</li>
                                        <template x-for="item in districts" :key="item.id">
                                            <li @click="district_id = item.id; fetchVillages(); open = false" class="px-3 py-2 hover:bg-slate-50 cursor-pointer rounded-lg text-sm" :class="district_id == item.id ? 'text-blue-700 bg-blue-50 font-medium' : 'text-slate-600'">
                                                <span x-text="item.name"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            
                            <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                                <label class="block text-xs font-bold text-slate-500 mb-1">Desa/Kelurahan</label>
                                <button type="button" @click="if(district_id && !isFetchingVillages) open = !open" class="w-full flex items-center justify-between px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 shadow-sm transition-colors group disabled:bg-slate-50 disabled:text-slate-400 disabled:shadow-none" :disabled="!district_id || isFetchingVillages">
                                    <span class="font-medium truncate" :class="village_id ? 'text-slate-900' : 'text-slate-500'" x-text="village_id ? (villages.find(v => v.id == village_id)?.name || 'Semua Desa/Kelurahan') : (isFetchingVillages ? 'Memuat...' : 'Semua Desa/Kelurahan')"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 group-hover:text-slate-600 transition-colors shrink-0 ml-2" :class="{'rotate-180': open}"><path d="m6 9 6 6 6-6"/></svg>
                                </button>
                                <div x-show="open" style="display: none;" class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg flex flex-col max-h-60" x-transition>
                                    <ul class="overflow-y-auto flex-1 p-1 custom-scrollbar">
                                        <li @click="village_id = ''; open = false" class="px-3 py-2 hover:bg-slate-50 cursor-pointer rounded-lg text-sm" :class="!village_id ? 'text-blue-700 bg-blue-50 font-medium' : 'text-slate-600'">Semua Desa/Kelurahan</li>
                                        <template x-for="item in villages" :key="item.id">
                                            <li @click="village_id = item.id; open = false" class="px-3 py-2 hover:bg-slate-50 cursor-pointer rounded-lg text-sm" :class="village_id == item.id ? 'text-blue-700 bg-blue-50 font-medium' : 'text-slate-600'">
                                                <span x-text="item.name"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-3 bg-slate-50 shrink-0 mt-6">
                    <button type="button" wire:click="resetFilters" @click="showFilterModal = false" class="w-full sm:w-auto px-4 py-2.5 text-sm font-bold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-200 border border-slate-200 rounded-xl transition-colors text-center">
                        Reset Filter
                    </button>
                    <button type="button" wire:click="$refresh" @click="showFilterModal = false" class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors shadow-sm text-center">
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
