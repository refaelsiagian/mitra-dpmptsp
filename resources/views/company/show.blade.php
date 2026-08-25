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
            <div x-show="activeTab === 'offerings'" x-data="{ activeProjectTab: 'aktif' }" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="space-y-6">
                @php
                    $publishedProjects = $company->projects->where('status', 'published');
                    $closedProjects = $company->projects->where('status', 'closed');
                    $draftProjects = $company->projects->where('status', 'draft');
                    
                    $activeCount = $publishedProjects->count() + $draftProjects->count();
                    $closedCount = $closedProjects->count();
                @endphp

                <div class="flex justify-between items-center mb-6" x-data="{ openDropdown: false }">
                    <h2 class="text-base md:text-lg font-bold text-slate-900">
                        <span x-text="activeProjectTab === 'aktif' ? 'Proyek Aktif' : 'Riwayat Selesai'"></span>
                        <span class="text-slate-400 font-medium text-sm md:text-base ml-1" x-text="activeProjectTab === 'aktif' ? '({{ $activeCount }})' : '({{ $closedCount }})'"></span>
                    </h2>
                    <div class="relative shrink-0">
                        <button type="button" @click="openDropdown = !openDropdown" @click.outside="openDropdown = false" class="inline-flex items-center gap-2 px-3 py-1.5 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-sm font-bold rounded-lg transition-all shadow-sm">
                            <span x-text="activeProjectTab === 'aktif' ? 'Aktif' : 'Selesai'"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-500 transition-transform duration-200" :class="{ 'rotate-180': openDropdown }"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="openDropdown" style="display: none;" class="absolute right-0 top-full mt-2 w-40 bg-white border border-slate-200 rounded-xl shadow-lg py-1 z-10" x-transition>
                            <button type="button" @click="activeProjectTab = 'aktif'; openDropdown = false" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 transition-colors" :class="activeProjectTab === 'aktif' ? 'text-blue-700 font-bold bg-blue-50/50' : 'text-slate-700 font-medium'">
                                Proyek Aktif
                            </button>
                            <button type="button" @click="activeProjectTab = 'selesai'; openDropdown = false" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 transition-colors" :class="activeProjectTab === 'selesai' ? 'text-blue-700 font-bold bg-blue-50/50' : 'text-slate-700 font-medium'">
                                Riwayat Selesai
                            </button>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeProjectTab === 'aktif'" class="space-y-6">
                    @if($activeCount === 0)
                        <div class="text-center p-10 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50 mt-2">
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                            </div>
                            <p class="text-slate-500 mb-1 font-medium">Belum ada proyek aktif.</p>
                            @if(auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id)
                            <p class="text-slate-400 text-sm mb-5">Klik Buat Proyek untuk mulai mencari mitra atau vendor.</p>
                            <a wire:navigate href="{{ route('projects.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-sm transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                Buat Proyek Pertama
                            </a>
                            @endif
                        </div>
                    @else
                        @foreach($publishedProjects->merge($draftProjects) as $project)
                    @php
                        $theme = match($project->type) {
                            'konstruksi' => [
                                'badgeBg' => 'bg-blue-50', 'badgeText' => 'text-blue-700', 'badgeBorder' => 'border-blue-200', 'label' => 'Konstruksi',
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>'
                            ],
                            'subkontrak' => [
                                'badgeBg' => 'bg-purple-50', 'badgeText' => 'text-purple-700', 'badgeBorder' => 'border-purple-200', 'label' => 'Subkontrak',
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>'
                            ],
                            'kso' => [
                                'badgeBg' => 'bg-teal-50', 'badgeText' => 'text-teal-700', 'badgeBorder' => 'border-teal-200', 'label' => 'Kerja Sama Operasional (KSO)',
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
                            ],
                            'rantai_pasok' => [
                                'badgeBg' => 'bg-amber-50', 'badgeText' => 'text-amber-800', 'badgeBorder' => 'border-amber-200', 'label' => 'Rantai Pasok',
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 18H3c-.6 0-1-.4-1-1V7c0-.6.4-1 1-1h10c.6 0 1 .4 1 1v11"/><path d="M14 9h4l4 4v5c0 .6-.4 1-1 1h-2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>'
                            ],
                            'outsourcing' => [
                                'badgeBg' => 'bg-indigo-50', 'badgeText' => 'text-indigo-700', 'badgeBorder' => 'border-indigo-200', 'label' => 'Penyumberluaran (Outsourcing)',
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>'
                            ],
                            'distribusi' => [
                                'badgeBg' => 'bg-cyan-50', 'badgeText' => 'text-cyan-800', 'badgeBorder' => 'border-cyan-200', 'label' => 'Distribusi & Keagenan',
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/></svg>'
                            ],
                            'perdagangan' => [
                                'badgeBg' => 'bg-rose-50', 'badgeText' => 'text-rose-700', 'badgeBorder' => 'border-rose-200', 'label' => 'Perdagangan Umum',
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>'
                            ],
                            default => [
                                'badgeBg' => 'bg-slate-50', 'badgeText' => 'text-slate-700', 'badgeBorder' => 'border-slate-200', 'label' => ucfirst($project->type),
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>'
                            ]
                        };
                    @endphp
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group hover:border-blue-300 transition-colors">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] sm:text-xs font-bold border {{ $theme['badgeBg'] }} {{ $theme['badgeText'] }} {{ $theme['badgeBorder'] }}">
                                {!! $theme['icon'] !!}
                                {{ $theme['label'] }}
                            </div>
                            @if($project->status === 'draft')
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] sm:text-xs font-bold border bg-slate-100 text-slate-600 border-slate-200">
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

                <div x-show="activeProjectTab === 'selesai'" style="display: none;" class="space-y-6">
                    @if($closedCount === 0)
                        <div class="text-center p-10 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50 mt-2">
                            <div class="w-12 h-12 bg-slate-200 text-slate-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            </div>
                            <p class="text-slate-500 mb-1 font-medium">Belum ada riwayat proyek selesai.</p>
                        </div>
                    @else
                        @foreach($closedProjects as $project)
                                @php
                                    $theme = match($project->type) {
                                        'konstruksi' => [
                                            'badgeBg' => 'bg-blue-50', 'badgeText' => 'text-blue-700', 'badgeBorder' => 'border-blue-200', 'label' => 'Konstruksi',
                                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>'
                                        ],
                                        'subkontrak' => [
                                            'badgeBg' => 'bg-purple-50', 'badgeText' => 'text-purple-700', 'badgeBorder' => 'border-purple-200', 'label' => 'Subkontrak',
                                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>'
                                        ],
                                        'kso' => [
                                            'badgeBg' => 'bg-teal-50', 'badgeText' => 'text-teal-700', 'badgeBorder' => 'border-teal-200', 'label' => 'Kerja Sama Operasional (KSO)',
                                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
                                        ],
                                        'rantai_pasok' => [
                                            'badgeBg' => 'bg-amber-50', 'badgeText' => 'text-amber-800', 'badgeBorder' => 'border-amber-200', 'label' => 'Rantai Pasok',
                                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 18H3c-.6 0-1-.4-1-1V7c0-.6.4-1 1-1h10c.6 0 1 .4 1 1v11"/><path d="M14 9h4l4 4v5c0 .6-.4 1-1 1h-2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>'
                                        ],
                                        'outsourcing' => [
                                            'badgeBg' => 'bg-indigo-50', 'badgeText' => 'text-indigo-700', 'badgeBorder' => 'border-indigo-200', 'label' => 'Penyumberluaran (Outsourcing)',
                                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>'
                                        ],
                                        'distribusi' => [
                                            'badgeBg' => 'bg-cyan-50', 'badgeText' => 'text-cyan-800', 'badgeBorder' => 'border-cyan-200', 'label' => 'Distribusi & Keagenan',
                                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/></svg>'
                                        ],
                                        'perdagangan' => [
                                            'badgeBg' => 'bg-rose-50', 'badgeText' => 'text-rose-700', 'badgeBorder' => 'border-rose-200', 'label' => 'Perdagangan Umum',
                                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>'
                                        ],
                                        default => [
                                            'badgeBg' => 'bg-slate-50', 'badgeText' => 'text-slate-700', 'badgeBorder' => 'border-slate-200', 'label' => ucfirst($project->type),
                                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>'
                                        ]
                                    };
                                @endphp
                                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group">
                                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-3">
                                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] sm:text-xs font-bold border {{ $theme['badgeBg'] }} {{ $theme['badgeText'] }} {{ $theme['badgeBorder'] }}">
                                                    {!! $theme['icon'] !!}
                                                    {{ $theme['label'] }}
                                                </div>
                                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] sm:text-xs font-bold border bg-slate-200 text-slate-700 border-slate-300">
                                                    Selesai
                                                </div>
                                            </div>
                                            <h3 class="text-xl font-bold text-slate-900 mb-2">
                                                <a href="{{ route('projects.show', $project->id) }}" class="hover:text-blue-600 transition-colors">{{ $project->title }}</a>
                                            </h3>
                                            <p class="text-slate-600 text-sm mb-0 leading-relaxed line-clamp-2">{{ Str::limit($project->description, 150) }}</p>
                                        </div>
                                        
                                        <!-- Selected Partners -->
                                        <div class="w-full md:w-1/3 bg-white border border-slate-200 rounded-xl p-4 shrink-0">
                                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                                                Mitra Terpilih
                                            </h4>
                                            @if($project->proposals && $project->proposals->count() > 0)
                                                <div class="space-y-3">
                                                    @foreach($project->proposals as $proposal)
                                                        <a href="{{ route('vendor.show', $proposal->company->id) }}" class="flex items-center gap-3 p-2 -mx-2 rounded-lg hover:bg-slate-50 transition-colors group/partner">
                                                            @if($proposal->company->logo)
                                                                <img src="{{ Storage::url($proposal->company->logo) }}" alt="{{ $proposal->company->name }}" class="w-8 h-8 rounded-full object-cover border border-slate-200">
                                                            @else
                                                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs border border-slate-200 shrink-0">
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
                                                <p class="text-sm text-slate-500 italic">Diselesaikan tanpa kemitraan via platform.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    @endif
                </div>
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
