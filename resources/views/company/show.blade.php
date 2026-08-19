@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto pb-10" x-data="{ activeTab: '{{ request('tab', 'overview') }}', lightboxOpen: false, lightboxImage: '' }">
    
    <!-- Top padding for layout balance -->
    <div class="pt-2"></div>

    <!-- Hero Section -->
    <x-company.hero :company="$company" />
    
    <div class="flex flex-col lg:flex-row gap-8 mt-6">
        <!-- Left Column: Main Content (2/3 width) -->
        <div class="w-full lg:w-2/3">
            
            <!-- Tabs Navigation -->
            <div class="flex border-b border-slate-200 gap-6 mb-6 overflow-x-auto hide-scrollbar snap-x">
                <button @click="activeTab = 'overview'; window.history.replaceState(null, null, '?tab=overview')" 
                    :class="activeTab === 'overview' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="py-3 px-1 border-b-2 font-semibold text-sm transition-colors whitespace-nowrap snap-start">
                    Ringkasan
                </button>
                @if($company->projects->count() > 0 || (auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id))
                <button @click="activeTab = 'offerings'; window.history.replaceState(null, null, '?tab=offerings')" 
                    :class="activeTab === 'offerings' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="py-3 px-1 border-b-2 font-semibold text-sm transition-colors whitespace-nowrap snap-start">
                    Proyek & Peluang KSO
                </button>
                @endif
                @if($company->portfolios->count() > 0 || (auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id))
                <button @click="activeTab = 'portfolios'; window.history.replaceState(null, null, '?tab=portfolios')" 
                    :class="activeTab === 'portfolios' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="py-3 px-1 border-b-2 font-semibold text-sm transition-colors whitespace-nowrap">
                    Portofolio Proyek
                </button>
                @endif
                
                <!-- Mobile Only Tab -->
                <button @click="activeTab = 'legalitas'; window.history.replaceState(null, null, '?tab=legalitas')" 
                    :class="activeTab === 'legalitas' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="py-3 px-1 border-b-2 font-semibold text-sm transition-colors lg:hidden whitespace-nowrap">
                    Legalitas
                </button>
            </div>

            <!-- Tab Content: Overview -->
            <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                
                @php
                    $pinnedOffering = $company->offerings->where('is_pinned', true)->first();
                @endphp

                <!-- Pinned Offering Box -->
                <x-company.pinned-offering :pinnedOffering="$pinnedOffering" />
                
                <!-- About Description Card -->
                <x-company.about-card :company="$company" />
            </div>

            <!-- Tab Content: Offerings -->
            @if($company->projects->count() > 0 || (auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id))
            <div x-show="activeTab === 'offerings'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="space-y-6">
                @if($company->projects->count() === 0)
                <div class="text-center p-10 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50 mt-2">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                    </div>
                    <p class="text-slate-500 mb-1 font-medium">Belum ada proyek yang dipublikasikan.</p>
                    <p class="text-slate-400 text-sm mb-5">Klik Buat Proyek untuk mulai mencari mitra atau vendor.</p>
                    @if(auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id)
                    <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-sm transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Buat Proyek Pertama
                    </a>
                    @endif
                </div>
                @else
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-base md:text-lg font-bold text-slate-900">
                        Proyek Aktif <span class="text-slate-400 font-medium text-sm md:text-base ml-1">({{ $company->projects->count() }})</span>
                    </h2>
                    @if(auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id)
                    <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs md:text-sm font-bold rounded-lg transition-colors shadow-sm shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="md:w-4 md:h-4"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Buat Proyek
                    </a>
                    @endif
                </div>
                
                    @foreach($company->projects as $project)
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
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group hover:border-blue-300 transition-colors">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] sm:text-xs font-bold uppercase tracking-wider border {!! $badgeClass !!}">
                                {{ $badgeText }}
                            </div>
                            @if($project->status === 'draft')
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] sm:text-xs font-bold uppercase tracking-wider border bg-slate-100 text-slate-600 border-slate-200">
                                    Draf
                                </div>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">
                            <a href="{{ route('projects.show', $project->id) }}" class="hover:text-blue-600 transition-colors">{{ $project->title }}</a>
                        </h3>
                        <p class="text-slate-600 text-sm mb-5 leading-relaxed">{{ Str::limit($project->description, 150) }}</p>
                        
                        <div class="flex flex-wrap items-end justify-between gap-4 mt-auto pt-4 border-t border-slate-100">
                            <div class="flex flex-wrap gap-4">
                                @if($project->estimated_value)
                                <div class="bg-blue-50 px-3 py-2 rounded-lg border border-blue-100">
                                    <span class="block text-xs font-semibold text-blue-600/70 mb-0.5">Nilai</span>
                                    <span class="font-bold text-blue-900">Rp {{ number_format($project->estimated_value, 0, ',', '.') }}</span>
                                </div>
                                @endif
                                <div class="bg-emerald-50 px-3 py-2 rounded-lg border border-emerald-100">
                                    <span class="block text-xs font-semibold text-emerald-600/70 mb-0.5">Status</span>
                                    <span class="font-bold text-emerald-900">Terbuka</span>
                                </div>
                            </div>
                            <a href="{{ route('projects.show', $project->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-lg transition-colors">
                                Lihat Detail
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            @endif

            <!-- Tab Content: Portfolios -->
            <x-company.portfolios :company="$company" />
            
            <!-- Tab Content: Legalitas (Mobile Only) -->
            <div x-show="activeTab === 'legalitas'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="lg:hidden">
                <x-company.legalitas :company="$company" />
            </div>
            
        </div>
        
        <!-- Right Column: Sidebar (1/3 width) -->
        <div class="w-full lg:w-1/3">
            <div class="sticky top-6 flex flex-col gap-6">
                
                <!-- Details Card (Desktop Only) -->
                <x-company.legalitas :company="$company" class="hidden lg:block" />
                
            </div>
        </div>
    </div>
        
    <!-- Lightbox Modal -->
    <div x-show="lightboxOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4" x-transition.opacity style="display: none;">
        <button @click="lightboxOpen = false" class="absolute top-6 right-6 text-white/70 hover:text-white p-2 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        <img :src="lightboxImage" class="max-w-full max-h-[90vh] object-contain rounded-xl shadow-2xl" @click.away="lightboxOpen = false">
    </div>

    <!-- Invite Modal -->
    @include('components.invite-modal')
</div>
@endsection
