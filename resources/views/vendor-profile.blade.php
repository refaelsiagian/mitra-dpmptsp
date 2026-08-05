@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto pb-10" x-data="{ activeTab: 'overview' }">
    
    <!-- Back to Discovery Hub -->
    <a href="/explore" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors mb-4 group">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
        <span>Kembali ke Direktori Mitra & Vendor</span>
    </a>

    <!-- Hero Section -->
    <div class="relative bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 mb-8">
        <!-- Banner Image Placeholder -->
        <div class="h-48 md:h-64 w-full bg-slate-200 relative group">
            @if($company->banner)
                <img src="{{ Storage::url($company->banner) }}" alt="Company Banner" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity">
            @else
                <img src="https://images.unsplash.com/photo-1541888087588-82cc68dd6279?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Default Banner" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
            
            @if(auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id)
            <!-- Inline Edit Button (Owner Only) -->
            <a href="{{ route('company.profile.edit') }}" class="absolute top-4 right-4 bg-white/90 hover:bg-white text-slate-800 backdrop-blur-sm px-4 py-2 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-2 z-10 border border-white/50">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                Edit Tampilan & Bio
            </a>
            @endif

            <!-- Overlapping Logo -->
            <div class="absolute -bottom-8 md:-bottom-12 left-6 md:left-10 w-24 h-24 md:w-32 md:h-32 bg-white rounded-xl shadow-md border-4 border-white overflow-hidden flex items-center justify-center z-20">
                 @if($company->logo)
                    <img src="{{ Storage::url($company->logo) }}" alt="Logo" class="w-full h-full object-cover">
                 @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                 @endif
            </div>
        </div>
        
        <!-- Padding to compensate for overlapping logo -->
        <div class="h-12 md:h-16"></div>
    </div>

    <!-- Main Content Layout (2/3 + 1/3) -->
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Left Column: Main Info (2/3 width) -->
        <div class="flex-1 lg:w-2/3 space-y-6">
            
            <!-- Company Header Info -->
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-3xl font-bold text-slate-900">{{ $company->name }}</h1>
                    <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Terverifikasi
                    </span>
                </div>
                <p class="text-slate-500 font-medium">
                    @if($company->established_year) Berdiri sejak {{ $company->established_year }} • @endif 
                    {{ $company->tagline ?? ($company->kblis->first()->name ?? 'Bidang Usaha Umum') }}
                </p>
            </div>
            
            <!-- Tabs Navigation -->
            <div class="flex border-b border-slate-200 gap-6 mt-6">
                <button @click="activeTab = 'overview'" 
                    :class="activeTab === 'overview' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="py-3 px-1 border-b-2 font-semibold text-sm transition-colors">
                    Ringkasan
                </button>
                @if($company->offerings->count() > 0 || (auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id))
                <button @click="activeTab = 'offerings'" 
                    :class="activeTab === 'offerings' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="py-3 px-1 border-b-2 font-semibold text-sm transition-colors">
                    Proyek & Peluang KSO
                </button>
                @endif
                @if($company->portfolios->count() > 0 || (auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id))
                <button @click="activeTab = 'portfolios'" 
                    :class="activeTab === 'portfolios' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="py-3 px-1 border-b-2 font-semibold text-sm transition-colors">
                    Portofolio Proyek
                </button>
                @endif
            </div>

            <!-- Tab Content: Overview -->
            <div x-show="activeTab === 'overview'" x-transition class="space-y-6">
                
                @php
                    $pinnedOffering = $company->offerings->where('is_pinned', true)->first();
                @endphp

                <!-- Pinned Offering Box -->
                @if($pinnedOffering)
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 md:p-8 text-white shadow-lg shadow-blue-900/20 relative overflow-hidden">
                    <!-- Background Decoration -->
                    <svg class="absolute top-0 right-0 text-white/10 w-48 h-48 -mr-12 -mt-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="m17 5-5-3-5 3v14l5 3 5-3z"/></svg>
                    
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-bold uppercase tracking-wider mb-4 border border-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
                            {{ $pinnedOffering->category ?? 'Sorotan Utama' }}
                        </div>
                        <h2 class="text-2xl font-bold mb-2">{{ $pinnedOffering->title }}</h2>
                        <p class="text-blue-100 mb-6 max-w-xl leading-relaxed text-sm md:text-base">
                            {{ $pinnedOffering->description }}
                        </p>
                        
                        <a href="#" class="inline-flex items-center gap-2 bg-white text-blue-700 hover:bg-blue-50 font-bold px-5 py-2.5 rounded-lg transition-colors text-sm shadow-sm">
                            Lihat Detail Proyek
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                @endif
                
                <!-- About Description Card -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Tentang Perusahaan</h2>
                    <div class="prose prose-slate max-w-none text-slate-600 prose-p:leading-relaxed text-sm md:text-base">
                        @if($company->description)
                            {!! nl2br(e($company->description)) !!}
                        @else
                            <p class="italic text-slate-400">Belum ada deskripsi profil perusahaan.</p>
                        @endif
                    </div>
                    
                    <!-- Contact & Web -->
                    <div class="flex flex-wrap gap-4 mt-6 pt-6 border-t border-slate-100">
                        @if($company->phone)
                        <div class="flex items-center gap-2 text-sm text-slate-600 bg-slate-50 px-3 py-2 rounded-lg border border-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            {{ $company->phone }}
                        </div>
                        @endif
                        @if($company->website)
                        <div class="flex items-center gap-2 text-sm text-slate-600 bg-slate-50 px-3 py-2 rounded-lg border border-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                            <a href="{{ $company->website }}" target="_blank" class="hover:text-blue-600">{{ str_replace(['http://', 'https://'], '', $company->website) }}</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tab Content: Offerings -->
            @if($company->offerings->count() > 0 || (auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id))
            <div x-show="activeTab === 'offerings'" x-transition style="display: none;" class="space-y-6">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-bold text-slate-900">Semua Proyek & Penawaran KSO</h2>
                    @if(auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id)
                    <a href="/rfp-saya" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Buat Proyek/RFP
                    </a>
                    @endif
                </div>
                
                @if($company->offerings->count() === 0)
                <div class="text-center p-10 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                    </div>
                    <p class="text-slate-500 mb-1 font-medium">Belum ada proyek yang dipublikasikan.</p>
                    <p class="text-slate-400 text-sm">Gunakan RFP Saya untuk mulai mempublikasikan proyek.</p>
                </div>
                @else
                    @foreach($company->offerings as $offering)
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group hover:border-blue-300 transition-colors">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 rounded-md text-xs font-bold text-slate-600 uppercase tracking-wider mb-3">
                            {{ $offering->category ?? 'Peluang' }}
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $offering->title }}</h3>
                        <p class="text-slate-600 text-sm mb-5 leading-relaxed">{{ $offering->description }}</p>
                        
                        <div class="flex flex-wrap gap-4 mt-auto">
                            @if($offering->highlight_metric)
                            <div class="bg-blue-50 px-3 py-2 rounded-lg border border-blue-100">
                                <span class="block text-xs font-semibold text-blue-600/70 mb-0.5">Highlight</span>
                                <span class="font-bold text-blue-900">{{ $offering->highlight_metric }}</span>
                            </div>
                            @endif
                            @if($offering->value_text)
                            <div class="bg-emerald-50 px-3 py-2 rounded-lg border border-emerald-100">
                                <span class="block text-xs font-semibold text-emerald-600/70 mb-0.5">Nilai/Rasio</span>
                                <span class="font-bold text-emerald-900">{{ $offering->value_text }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            @endif

            <!-- Tab Content: Portfolios -->
            @if($company->portfolios->count() > 0 || (auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id))
            <div x-show="activeTab === 'portfolios'" x-transition style="display: none;">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-slate-900">Portofolio Proyek</h2>
                    @if(auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id)
                    <a href="{{ route('portfolios.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Tambah Portofolio
                    </a>
                    @endif
                </div>

                @if($company->portfolios->count() === 0)
                <div class="text-center p-10 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                    </div>
                    <p class="text-slate-500 mb-1 font-medium">Belum ada portofolio yang dibagikan.</p>
                </div>
                @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($company->portfolios as $portfolio)
                    <div class="group relative bg-slate-100 rounded-xl overflow-hidden aspect-[4/3] border border-slate-200">
                        @if($portfolio->image_path)
                            <img src="{{ Storage::url($portfolio->image_path) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-200">No Image</div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
                            <span class="text-white font-bold">{{ $portfolio->title }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endif
            
        </div>
        
        <!-- Right Column: Sidebar (1/3 width) -->
        <div class="w-full lg:w-1/3">
            <div class="sticky top-6 flex flex-col gap-6">
                
                @if(!(auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id))
                <!-- Action CTA -->
                <button class="w-full flex justify-center items-center gap-2 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors shadow-lg shadow-blue-600/20 focus:ring-4 focus:ring-blue-100 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                    Undang ke Proyek
                </button>
                @endif
                
                <!-- Details Card -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-900">Informasi Legalitas</h3>
                    </div>
                    
                    <div class="p-6 space-y-5">
                        
                        <!-- NIB -->
                        <div>
                            <p class="text-xs text-slate-500 font-medium mb-1">Nomor Induk Berusaha (NIB)</p>
                            <div class="flex items-center gap-2">
                                <p class="text-slate-900 font-semibold font-mono">{{ $company->nib_number }}</p>
                            </div>
                        </div>
                        
                        <!-- PKP -->
                        <div>
                            <p class="text-xs text-slate-500 font-medium mb-1">Status PKP (Pengusaha Kena Pajak)</p>
                            @if($company->is_pkp)
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-sm font-semibold border border-blue-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                                    Aktif (PKP)
                                </div>
                            @else
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-500 text-sm font-semibold border border-slate-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" x2="19.07" y1="4.93" y2="19.07"/></svg>
                                    Non PKP
                                </div>
                            @endif
                        </div>
                        
                        <!-- Skala -->
                        <div>
                            <p class="text-xs text-slate-500 font-medium mb-1">Skala Usaha / Kapasitas</p>
                            <p class="text-slate-900 font-medium">{{ ucwords(str_replace('_', ' ', $company->skala_usaha)) }}</p>
                        </div>
                        
                        <!-- KBLI & Certifications -->
                        <div class="border-t border-slate-100 pt-5 mt-5">
                            @if($company->certifications && count($company->certifications) > 0)
                            <p class="text-xs text-slate-500 font-medium mb-3">Sertifikasi & Lisensi</p>
                            <div class="flex flex-wrap gap-2 mb-5">
                                @foreach($company->certifications as $cert)
                                <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-sm font-medium text-slate-700">
                                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                    {{ $cert }}
                                </span>
                                @endforeach
                            </div>
                            @endif

                            <p class="text-xs text-slate-500 font-medium mb-3">Bidang Keahlian (KBLI)</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($company->kblis as $kbli)
                                <span class="px-2.5 py-1 rounded-md bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold" title="{{ $kbli->name }}">
                                    {{ $kbli->code }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
</div>
@endsection
