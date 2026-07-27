@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto pb-10">
    
    <!-- Hero Section -->
    <div class="relative bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 mb-8">
        <div class="h-48 md:h-64 w-full bg-slate-200 relative">
            <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Company Banner" class="w-full h-full object-cover opacity-90">
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
        </div>
        
        <div class="absolute -bottom-8 md:-bottom-12 left-6 md:left-10 w-24 h-24 md:w-32 md:h-32 bg-white rounded-xl shadow-md border-4 border-white overflow-hidden flex items-center justify-center">
             <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-teal-600"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
        </div>
        
        <div class="h-12 md:h-16"></div>
    </div>

    <!-- Main Content Layout (2/3 + 1/3) -->
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Left Column: Main Info (2/3 width) -->
        <div class="flex-1 lg:w-2/3 space-y-8">
            
            <!-- Company Header Info -->
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-3xl font-bold text-slate-900">PT Nusantara Wisata</h1>
                    <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Terverifikasi
                    </span>
                </div>
                <p class="text-slate-500 font-medium">Berdiri sejak 2012 • Pariwisata & Pengembangan Kawasan Resort</p>
            </div>
            
            <!-- Proyek yang Ditawarkan Section -->
            <div class="bg-gradient-to-r from-teal-50/80 via-emerald-50/40 to-white p-6 rounded-2xl border-2 border-teal-200 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between gap-4 mb-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-600 text-white text-xs font-bold shadow-2xs">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Kemitraan (KSO / BOT) Ditawarkan
                    </span>
                    <span class="text-xs font-semibold text-teal-800 bg-teal-100 px-2.5 py-1 rounded-full">Prospek Terbuka</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Pengembangan Kawasan Ekowisata Danau Toba</h3>
                <p class="text-sm text-slate-600 mb-5">Kolaborasi Joint Venture (JV) atau skema Build-Operate-Transfer (BOT) selama 25 tahun untuk pembangunan resort bintang 4 di kawasan strategis Danau Toba dengan modal lahan 2 Hektar dan seed money Rp 15 Miliar.</p>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-teal-200/60">
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Valuasi Lahan & Seed Money</p>
                        <p class="text-lg font-bold text-teal-700">Rp 15.000.000.000+ (Modal Awal)</p>
                    </div>
                    <a href="/project/kso" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl transition-colors shadow-md shadow-teal-500/20 text-sm inline-flex items-center justify-center gap-2">
                        Lihat Detail Kemitraan
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Tentang Perusahaan</h2>
                <p class="text-slate-600 leading-relaxed">
                    PT Nusantara Wisata adalah pionir pengembang destinasi pariwisata berkelanjutan dan akomodasi hospitality kelas atas di Sumatera Utara. Kami mengintegrasikan kekayaan alam dan budaya lokal dengan manajemen perhotelan berstandar global.
                </p>
                <div class="flex flex-wrap gap-4 mt-6">
                    <div class="flex items-center gap-2 text-sm text-slate-600 bg-slate-50 px-3 py-2 rounded-lg border border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-teal-600"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        (061) 452-9988
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-600 bg-slate-50 px-3 py-2 rounded-lg border border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-teal-600"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                        www.nusantarawisata.id
                    </div>
                </div>
            </div>
            
            <!-- Portofolio -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-slate-900">Portofolio Resort & Pariwisata</h2>
                    <a href="#" class="text-blue-600 text-sm font-medium hover:underline">Lihat Semua</a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="group relative bg-slate-100 rounded-xl overflow-hidden aspect-[4/3] border border-slate-200 cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Resort Brastagi" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                            <span class="text-white font-medium text-sm">Highland Resort Brastagi</span>
                        </div>
                    </div>
                    <div class="group relative bg-slate-100 rounded-xl overflow-hidden aspect-[4/3] border border-slate-200 cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Villa Danau" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                            <span class="text-white font-medium text-sm">Lakeview Villas Parapat</span>
                        </div>
                    </div>
                    <div class="group relative bg-slate-100 rounded-xl overflow-hidden aspect-[4/3] border border-slate-200 cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Hotel Boutique" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                            <span class="text-white font-medium text-sm">Boutique Hotel Medan</span>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Right Column: Sidebar (1/3 width) -->
        <div class="w-full lg:w-1/3">
            <div class="sticky top-6 flex flex-col gap-6">
                <button class="w-full flex justify-center items-center gap-2 py-3.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl transition-colors shadow-lg shadow-teal-600/20 focus:ring-4 focus:ring-teal-100 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                    Ajukan Pertemuan Bisnis
                </button>
                
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-900">Informasi Legalitas</h3>
                    </div>
                    
                    <div class="p-6 space-y-5">
                        <div>
                            <p class="text-xs text-slate-500 font-medium mb-1">Nomor Induk Berusaha (NIB)</p>
                            <p class="text-slate-900 font-semibold font-mono">7182930418293</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium mb-1">Status PKP</p>
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-sm font-semibold border border-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                                Aktif (PKP)
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium mb-1">Skala Usaha</p>
                            <p class="text-slate-900 font-medium">Usaha Besar (B)</p>
                            <p class="text-slate-500 text-sm mt-0.5">Estimasi Revenue: > Rp 30 Miliar</p>
                        </div>
                        
                        <div class="border-t border-slate-100 pt-5 mt-5">
                            <p class="text-xs text-slate-500 font-medium mb-3">Sertifikasi & Lisensi</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-sm font-medium text-slate-700">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    CHSE Certified
                                </span>
                                <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-sm font-medium text-slate-700">
                                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                    ISO 14001:2015
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
