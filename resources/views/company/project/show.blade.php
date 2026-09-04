@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto pb-10" x-data="projectForm({ type: '{{ $project->type }}', isUmkm: {{ $project->company?->isUMKM() ? 'true' : 'false' }} })">
    
    <!-- Top padding for layout balance -->
    <div class="pt-4"></div>

    @php $isOwner = auth()->check() && auth()->user()->company && auth()->user()->company->id === $project->company_id; @endphp

    @if($project->is_public === false && !$isOwner)
        <div class="bg-white p-10 md:p-16 rounded-3xl shadow-sm border border-slate-200 text-center flex flex-col items-center justify-center min-h-[60vh] max-w-3xl mx-auto">
            <div class="w-24 h-24 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-4">Proyek Privat</h2>
            <p class="text-slate-500 text-base md:text-lg max-w-lg mx-auto mb-10 leading-relaxed">Pemilik proyek telah mengatur proyek ini menjadi privat. Detail proyek, dokumen, dan informasi lainnya tidak lagi tersedia untuk publik.</p>
            <button onclick="window.history.back()" class="px-8 py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl transition-colors shadow-sm inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                Kembali
            </button>
        </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-24 lg:pb-0">
        
        <!-- Left Column (col-span-2) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Draft Banner -->
            @if($project->status === 'draft')
            <div class="bg-slate-100 border border-slate-200 p-4 md:p-5 rounded-2xl shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-slate-700">
                    <div class="bg-white p-2 rounded-full shrink-0 shadow-sm border border-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-500"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg leading-tight">Proyek ini masih berupa draf</h4>
                        <p class="text-sm opacity-90 mt-0.5">Hanya Anda yang dapat melihat halaman ini. Terbitkan proyek agar dapat dilihat publik.</p>
                    </div>
                </div>
                <div class="flex shrink-0 w-full md:w-auto mt-2 md:mt-0">
                    <a href="{{ route('projects.edit', $project->id) }}" wire:navigate class="w-full md:w-auto text-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-colors shadow-sm whitespace-nowrap">Lanjutkan Edit</a>
                </div>
            </div>
            @endif

            <!-- Invitation Banner -->
            @if(isset($invitation) && $invitation->status === 'pending')
            <div class="bg-blue-50 border border-blue-200 p-5 rounded-2xl shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-blue-800">
                    <div class="bg-blue-100 p-2 rounded-full shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg leading-tight">Anda diundang ke proyek ini!</h4>
                        <p class="text-sm opacity-90 mt-0.5">{{ $project->company->name }} telah mengundang Anda secara langsung untuk berpartisipasi.</p>
                    </div>
                </div>
                <div class="flex shrink-0 w-full md:w-auto mt-2 md:mt-0">
                    <span class="text-sm font-medium text-blue-700 bg-blue-100/50 px-3 py-1.5 rounded-lg border border-blue-200 shadow-sm">
                        Kirim Penawaran untuk merespons
                    </span>
                </div>
            </div>
            @elseif(isset($invitation) && $invitation->status === 'rejected' && $invitation->invited_company_id === (auth()->user()->company->id ?? null))
            <div class="bg-slate-50 border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-3">
                <div class="bg-slate-100 p-2 rounded-full shrink-0 text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-700 text-lg leading-tight">Anda menolak tawaran proyek ini</h4>
                </div>
            </div>
            @endif

            <!-- Header Section -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200" x-data="{ lightboxOpen: false, lightboxImage: '' }">
                    @if($project->image)
                        <div class="mb-6 relative group cursor-pointer" @click="lightboxImage = '{{ Storage::url($project->image) }}'; lightboxOpen = true">
                            <img src="{{ Storage::url($project->image) }}" alt="Banner {{ $project->title }}" class="w-full h-48 md:h-64 object-cover rounded-xl border border-slate-200 shadow-sm transition-transform duration-500">
                            <!-- Hover Overlay for Image -->
                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl pointer-events-none flex items-center justify-center">
                                <div class="bg-white/30 backdrop-blur-sm p-3 rounded-full text-white shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Image Lightbox Modal -->
                        <div x-show="lightboxOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 p-4 md:p-10" x-transition.opacity style="display: none;">
                            <button @click="lightboxOpen = false" class="absolute top-4 right-4 md:top-8 md:right-8 text-white/70 hover:text-white p-2 transition-colors z-[110]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                            <img :src="lightboxImage" @click.outside="lightboxOpen = false" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
                        </div>
                    @endif
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
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-lg text-xs sm:text-sm font-bold border mb-3 {{ $theme['badgeBg'] }} {{ $theme['badgeText'] }} {{ $theme['badgeBorder'] }}">
                        {!! $theme['icon'] !!}
                        {{ $theme['label'] }}
                    </span>
                    @if($project->is_expired)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-lg text-xs sm:text-sm font-bold border mb-3 bg-red-50 text-red-700 border-red-200 ml-2">
                        Kadaluarsa
                    </span>
                    @endif
                
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 leading-tight">{{ $project->title }}</h1>
                    @php
                        $acceptedCount = $project->proposals()->where('status', 'accepted')->count();
                    @endphp
                    @if($acceptedCount > 0 && in_array($project->status, ['published', 'closed']))
                        <span class="px-3 py-1 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold rounded-lg flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                            {{ $acceptedCount }} Kemitraan Terjalin
                        </span>
                    @endif
                </div>
                
                <a href="{{ route('vendor.show', $project->company_id) }}" class="text-blue-600 font-semibold hover:underline text-base sm:text-lg flex items-center gap-1.5 mb-5 inline-flex">
                    {{ $project->company->name }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                </a>
                
                <div class="flex flex-wrap gap-2 pt-4 border-t border-slate-100">
                    @if($project->village_id)
                        <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">
                            Lokasi: {{ ucwords(strtolower($project->village?->name)) }}, {{ ucwords(strtolower($project->district?->name)) }}, {{ ucwords(strtolower($project->regency?->name)) }}, {{ ucwords(strtolower($project->province?->name)) }}
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Mobile Budget Info (Hidden on Desktop) -->
            <div class="lg:hidden bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                @if($project->estimated_value)
                <div class="text-center">
                    <p class="text-xs font-medium text-slate-500 mb-1">
                        Nilai Anggaran / Kontrak
                    </p>
                    <h3 class="text-xl font-bold text-emerald-600 mb-2">Rp {{ number_format($project->estimated_value, 0, ',', '.') }}</h3>
                    
                    @if($project->is_budget_negotiable)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 text-[10px] font-bold border border-amber-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 14V2"/><path d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22h0a3.13 3.13 0 0 1-3-3.88Z"/></svg>
                        Bisa Didiskusikan
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold border border-slate-200">
                        Fix / Tetap
                    </span>
                    @endif
                </div>
                @endif
                
                <!-- Mobile Informasi Jadwal -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 mt-4">
                    <h3 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-500"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Informasi Jadwal
                    </h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between items-start gap-4">
                            <span class="text-slate-500">Diterbitkan</span>
                            <span class="font-semibold text-slate-700 text-right">{{ $project->created_at->format('d M Y') }}</span>
                        </li>
                        @if($project->offer_end_date)
                        <li class="flex justify-between items-start gap-4 pt-3 border-t border-slate-200/80">
                            <span class="text-slate-500">Batas Penawaran</span>
                            <div class="text-right">
                                <span class="font-bold text-amber-600 block">{{ \Carbon\Carbon::parse($project->offer_end_date)->format('d M Y') }}</span>
                                <span class="text-[10px] font-bold text-amber-700/70 uppercase tracking-wider">
                                    @if($project->is_expired)
                                        <span class="text-red-600">Berakhir</span>
                                    @else
                                        {{ \Carbon\Carbon::parse($project->offer_end_date)->locale('id')->diffForHumans() }}
                                    @endif
                                </span>
                            </div>
                        </li>
                        @endif
                        @if($project->project_start_date)
                        <li class="flex justify-between items-start gap-4 pt-3 border-t border-slate-200/80">
                            <span class="text-slate-500">Mulai Pelaksanaan</span>
                            <span class="font-semibold text-slate-700 text-right">{{ $project->project_start_date->format('d M Y') }}</span>
                        </li>
                        @endif
                        @if($project->project_end_date)
                        <li class="flex justify-between items-start gap-4 pt-3 border-t border-slate-200/80">
                            <span class="text-slate-500">Selesai Pelaksanaan</span>
                            <span class="font-semibold text-slate-700 text-right">{{ $project->project_end_date->format('d M Y') }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Detail Proyek (Consolidated) -->
            <div class="bg-white p-5 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                
                <!-- Deskripsi -->
                @if($project->description)
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-slate-900 mb-3">
                        Deskripsi Kemitraan
                    </h2>
                    <div class="text-slate-600 leading-relaxed whitespace-pre-wrap text-sm md:text-base">{{ $project->description }}</div>
                </div>
                @endif

                <!-- Ruang Lingkup -->
                @if($project->ruang_lingkup)
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <h2 class="text-lg md:text-xl font-bold text-slate-900 mb-3">
                        Ruang Lingkup Pekerjaan / Kebutuhan
                    </h2>
                    <div class="text-slate-600 leading-relaxed whitespace-pre-wrap text-sm md:text-base">{{ $project->ruang_lingkup }}</div>
                </div>
                @endif

                <!-- Dynamic Lists (Offerings) -->
                @if($project->offerings && count($project->offerings) > 0)
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <h2 class="text-lg md:text-xl font-bold text-slate-900 mb-4 flex items-start sm:items-center gap-3">
                        <div class="p-1.5 bg-emerald-100 text-emerald-600 rounded-lg shrink-0 mt-0.5 sm:mt-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10.5V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.5"/><path d="m9 11 3 3L22 4"/></svg>
                        </div>
                        <span x-text="getOfferingsTitle()" class="leading-snug"></span>
                    </h2>
                    <ul class="space-y-3">
                        @foreach($project->offerings as $item)
                            <li class="flex items-start gap-3">
                                <div class="mt-0.5 p-1 bg-emerald-50 rounded-full text-emerald-600 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                                <span class="text-slate-800 font-medium leading-relaxed text-sm md:text-base">{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Dynamic Lists (Requirements) -->
                @if($project->requirements && count($project->requirements) > 0)
                <div class="mt-6 pt-6">
                    <div class="bg-blue-50/50 p-4 md:p-6 rounded-xl border border-blue-100">
                        <h2 class="text-lg md:text-xl font-bold text-blue-900 mb-4 flex items-start sm:items-center gap-3">
                            <div class="p-1.5 bg-blue-100 text-blue-600 rounded-lg shrink-0 mt-0.5 sm:mt-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            </div>
                            <span x-text="getRequirementsTitle()" class="leading-snug"></span>
                        </h2>
                        <ul class="space-y-3">
                            @foreach($project->requirements as $item)
                                <li class="flex items-start gap-3 bg-white p-3 rounded-lg border border-blue-50 shadow-sm">
                                    <div class="mt-0.5 p-1 bg-blue-50 rounded-full text-blue-600 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                                    </div>
                                    <span class="text-slate-800 font-medium leading-relaxed text-sm md:text-base">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
            
        </div>
        
        <!-- Right Column (col-span-1) -->
        <div class="hidden lg:block lg:col-span-1">
            <div class="sticky top-6 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                
                @if($project->estimated_value)
                <div class="text-center mb-6">
                    <p class="text-sm font-medium text-slate-500 mb-1">
                        Nilai Anggaran / Kontrak
                    </p>
                    <h3 class="text-xl xl:text-2xl font-bold text-emerald-600 mb-2 break-all sm:break-normal">Rp {{ number_format($project->estimated_value, 0, ',', '.') }}</h3>
                    
                    @if($project->is_budget_negotiable)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 14V2"/><path d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22h0a3.13 3.13 0 0 1-3-3.88Z"/></svg>
                        Bisa Didiskusikan
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold border border-slate-200">
                        Fix / Tetap
                    </span>
                    @endif
                </div>
                @endif
                
                <!-- Desktop Informasi Jadwal -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 mb-6">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-500"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Informasi Jadwal
                    </h3>
                    <ul class="space-y-3.5 text-sm">
                        <li class="flex justify-between items-start gap-4">
                            <span class="text-slate-500">Diterbitkan</span>
                            <span class="font-semibold text-slate-700 text-right">{{ $project->created_at->format('d M Y') }}</span>
                        </li>
                        @if($project->offer_end_date)
                        <li class="flex justify-between items-start gap-4 pt-3.5 border-t border-slate-200/80">
                            <span class="text-slate-500">Batas Penawaran</span>
                            <div class="text-right">
                                <span class="font-bold text-amber-600 block">{{ \Carbon\Carbon::parse($project->offer_end_date)->format('d M Y') }}</span>
                                <span class="text-[10px] font-bold text-amber-700/70 uppercase tracking-wider">
                                    @if($project->is_expired)
                                        <span class="text-red-600">Berakhir</span>
                                    @else
                                        {{ \Carbon\Carbon::parse($project->offer_end_date)->locale('id')->diffForHumans() }}
                                    @endif
                                </span>
                            </div>
                        </li>
                        @endif
                        @if($project->project_start_date)
                        <li class="flex justify-between items-start gap-4 pt-3.5 border-t border-slate-200/80">
                            <span class="text-slate-500">Mulai Pelaksanaan</span>
                            <span class="font-semibold text-slate-700 text-right">{{ $project->project_start_date->format('d M Y') }}</span>
                        </li>
                        @endif
                        @if($project->project_end_date)
                        <li class="flex justify-between items-start gap-4 pt-3.5 border-t border-slate-200/80">
                            <span class="text-slate-500">Selesai Pelaksanaan</span>
                            <span class="font-semibold text-slate-700 text-right">{{ $project->project_end_date->format('d M Y') }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
                
                <!-- Calls to Action (Viewer Only) -->
                @if(auth()->check() && auth()->user()->company && auth()->user()->company->id === $project->company_id)
                    <div class="flex gap-3 mt-4 lg:hidden">
                        <a wire:navigate href="{{ route('projects.edit', $project->id) }}" class="flex-1 py-3 bg-white border-2 border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-center transition-colors">Edit</a>
                        <button class="flex-1 py-3 bg-red-50 text-red-600 hover:bg-red-100 font-bold rounded-xl text-center transition-colors">Tutup</button>
                    </div>
                @else
                    @can('submitProposal', $project)
                    <div class="mt-6 hidden lg:block">
                        @php
                            $isViewerUB = auth()->check() && auth()->user()->company ? in_array(strtolower(auth()->user()->company->skala_usaha ?? ''), ['besar']) : false;
                            $buttonTextDesktop = $isViewerUB ? 'Kirim Ketertarikan' : 'Kirim Proposal';
                        @endphp
                        @if($project->status === 'closed')
                        <button disabled class="w-full py-3.5 bg-slate-200 text-slate-500 font-bold rounded-xl flex justify-center items-center gap-2 cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Proyek Telah Ditutup
                        </button>
                        @elseif($project->is_expired)
                        <button disabled class="w-full py-3.5 bg-slate-200 text-slate-500 font-bold rounded-xl flex justify-center items-center gap-2 cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Waktu Penawaran Berakhir
                        </button>
                        @else
                        <a wire:navigate href="{{ route('proposals.create', $project->id) }}" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-blue-600/20 flex justify-center items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9 22 2z"/></svg>
                            {{ $buttonTextDesktop }}
                        </a>
                        @endif
                    </div>
                    @endcan
                @endif
            </div>
        </div>
        
        @can('submitProposal', $project)
        <!-- Mobile & Tablet Sticky CTA Bar (Hidden on Large Desktop) -->
        <div class="lg:hidden fixed bottom-16 md:bottom-0 left-0 md:left-16 right-0 p-4 bg-white border-t border-slate-200 shadow-[0_-10px_20px_-10px_rgba(0,0,0,0.05)] z-40">
            <div class="flex gap-3">
                @php
                    $isViewerUB = auth()->check() && auth()->user()->company ? in_array(strtolower(auth()->user()->company->skala_usaha ?? ''), ['besar']) : false;
                    $buttonTextMobile = $isViewerUB ? 'Kirim Ketertarikan' : 'Kirim Proposal';
                @endphp
                @if($project->status === 'closed')
                <button disabled class="w-full py-3 bg-slate-200 text-slate-500 font-bold rounded-xl text-sm flex justify-center items-center gap-1.5 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Ditutup
                </button>
                @elseif($project->is_expired)
                <button disabled class="w-full py-3 bg-slate-200 text-slate-500 font-bold rounded-xl text-sm flex justify-center items-center gap-1.5 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Berakhir
                </button>
                @else
                <a wire:navigate href="{{ route('proposals.create', $project->id) }}" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-600/20 text-sm transition-colors flex justify-center items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9 22 2z"/></svg>
                    {{ $buttonTextMobile }}
                </a>
                @endif
            </div>
        </div>
        @endcan
    </div>
    @endif
</div>
@endsection
