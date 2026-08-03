@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto pb-10">
    
    <!-- Back to Discovery Hub -->
    <a href="/explore" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors mb-4 group">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
        <span>Kembali ke Direktori Mitra & Vendor</span>
    </a>

    <!-- Hero Section -->
    <div class="relative bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 mb-8">
        <div class="h-48 md:h-64 w-full bg-slate-200 relative">
            <img src="https://images.unsplash.com/photo-1595855759920-86582396756a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Company Banner" class="w-full h-full object-cover opacity-90">
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
            
            <!-- Overlapping Logo -->
            <div class="absolute -bottom-8 md:-bottom-12 left-6 md:left-10 w-24 h-24 md:w-32 md:h-32 bg-white rounded-xl shadow-md border-4 border-white overflow-hidden flex items-center justify-center">
                <div class="w-full h-full bg-emerald-600 flex items-center justify-center text-white font-black text-2xl md:text-3xl">
                    TJ
                </div>
            </div>
        </div>
        
        <!-- Padding to compensate for overlapping logo -->
        <div class="h-12 md:h-16"></div>
    </div>

    <!-- Main Content Layout (2/3 + 1/3) -->
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Left Column: Main Info (2/3 width) -->
        <div class="flex-1 lg:w-2/3 space-y-8">
            
            <!-- Company Header Info -->
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-3xl font-bold text-slate-900">Koperasi Produsen Tani Jaya Mandiri</h1>
                    <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Usaha Kecil (K)
                    </span>
                </div>
                <p class="text-slate-500 font-medium">Pertanian & Komoditas Pangan • Kab. Karo (Berastagi), Sumatera Utara</p>
            </div>
            
            <!-- Proyek yang Ditawarkan Section -->
            <div class="bg-gradient-to-r from-emerald-50/80 via-teal-50/50 to-white p-6 rounded-2xl border-2 border-emerald-200 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between gap-4 mb-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-600 text-white text-xs font-bold shadow-2xs">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Peluang KSO Suplai Terbuka
                    </span>
                    <span class="text-xs font-semibold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full">MOQ: 10 Ton/bln</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Kontrak Suplai & Offtaker Sayuran Organik</h3>
                <p class="text-sm text-slate-600 mb-5">Kami mencari mitra penyuplai tetap (Offtaker) untuk penguncian harga dengan komitmen serapan minimal 10 Ton/bulan selama 1 tahun kontrak.</p>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-emerald-200/60">
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Harga Penguncian (Fixed Price)</p>
                        <p class="text-lg font-bold text-emerald-700">Rp 15.000 / kg</p>
                    </div>
                    <a href="/project/kso/tani" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all text-center">
                        Lihat Peluang KSO
                    </a>
                </div>
            </div>
            
            <!-- Profil Perusahaan Section -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">Profil Koperasi Tani Jaya Mandiri</h3>
                <p class="text-sm text-slate-600 leading-relaxed mb-4">
                    Koperasi Produsen Tani Jaya Mandiri adalah badan usaha milik kelompok tani yang beranggotakan 50 petani hortikultura aktif di kawasan dataran tinggi Karo, Sumatera Utara. Kami fokus pada budidaya sayuran organik dan kelas super seperti kubis, wortel brastagi, kentang granola, brokoli, dan selada air.
                </p>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Dengan fasilitas bangsal pascapanen (packing house) dan gudang pendingin (cold storage mini 20 ton), kami siap menjamin standar sortase grade A untuk pasokan ke hotel, restoran, catering (HORECA), serta jaringan supermarket.
                </p>
            </div>
            
        </div>

        <!-- Right Column: Sidebar (1/3 width) -->
        <div class="w-full lg:w-1/3 space-y-6">

            <div class="besar-only">
                <button onclick="openInviteModal()" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-blue-600/20 focus:ring-4 focus:ring-blue-100 focus:outline-none flex justify-center items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5c-1.1 0-2 .9-2 2v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                    Undang ke Proyek Anda
                </button>
            </div>
            
            <!-- Status Verifikasi OSS -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Status Verifikasi OSS
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-500">Skala Usaha:</span>
                        <span class="font-bold text-emerald-700">Usaha Kecil (K)</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-500">Modal Terdaftar:</span>
                        <span class="font-semibold text-slate-800">Rp 2.450.000.000</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-500">Bentuk Hukum:</span>
                        <span class="font-semibold text-slate-800">Koperasi Produsen</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-slate-500">NIB Terverifikasi:</span>
                        <span class="font-mono text-xs font-semibold bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded">9120381920192</span>
                    </div>
                </div>
            </div>
            
            <!-- Keahlian & Spesialisasi -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Keahlian Utama (KBLI)
                </h3>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition-colors">01131 - Pertanian Hortikultura Sayuran</span>
                    <span class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition-colors">Sayur Organik Bersertifikat</span>
                    <span class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition-colors">Sortase Supermarket</span>
                    <span class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition-colors">Cold Chain</span>
                </div>
            </div>
            
        </div>
    </div>
</div>
@include('components.invite-modal')
@endsection
