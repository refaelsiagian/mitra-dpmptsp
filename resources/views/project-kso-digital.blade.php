@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto pb-10">
    
    <!-- Back to Discovery Hub -->
    <a href="/explore?tab=projects" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors mb-5 group">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
        <span>Kembali ke Eksplorasi Proyek & KSO</span>
    </a>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Left Column (col-span-2) -->
        <div class="md:col-span-2 space-y-6">
            
            <!-- Project Header Card -->
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800 border border-indigo-200">
                        Kemitraan Bagi Hasil / Kolaborasi (Usaha Kecil)
                    </span>
                    <span class="text-sm font-semibold text-slate-500 flex items-center gap-1">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Dipublikasikan: 27 Juli 2026
                    </span>
                </div>

                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4">
                    Kemitraan Bagi Hasil Implementasi Smart Parking & CCTV AI di Kawasan Komersial
                </h1>

                <!-- Initiator Company Info -->
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-base flex-shrink-0">
                        RD
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Inisiator Kemitraan (Demand Side):</p>
                        <a href="/vendor/rekayasa-digital" class="text-sm font-bold text-slate-800 hover:text-blue-600 flex items-center gap-1 transition-colors">
                            CV Rekayasa Digital Nusantara
                            <svg class="w-4 h-4 text-blue-500 inline" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </a>
                    </div>
                </div>

                <div class="prose prose-slate max-w-none text-slate-600 space-y-4 text-sm leading-relaxed">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2">Konsep & Tujuan Kemitraan</h3>
                    <p>
                        Kami menawarkan solusi modernisasi sistem perparkiran dan keamanan kawasan komersial (Mall, Rumah Sakit, Pusat Perkantoran, atau Pelabuhan) tanpa membebani pengelola dengan investasi perangkat keras (Zero CapEx). CV Rekayasa Digital menyediakan seluruh palang pintu otomatis, kamera LPR (License Plate Recognition), dan software cloud gratis.
                    </p>

                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2 mt-6">Ekspektasi Kolaborasi & Keterbukaan Skema</h3>
                    <p>
                        Kami terbuka terhadap berbagai skema kerja sama, baik berupa KSO Bagi Hasil tiket parkir, kontrak pemeliharaan bulanan (SaaS), maupun penyertaan modal perangkat. Mari jadwalkan diskusi awal untuk mencari skema yang saling menguntungkan.
                    </p>
                </div>
            </div>

            <!-- Ekspektasi Kolaborasi & Bagi Hasil Card -->
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 mb-6 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Ekspektasi Kolaborasi & Skema Revenue Share
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Proporsi Bagi Hasil (Revenue Share)</span>
                        <span class="text-2xl font-black text-indigo-700">70 : 30 <span class="text-sm font-normal text-slate-500">(Mitra : Pengelola)</span></span>
                        <p class="text-xs text-slate-500 mt-2">Mitra menanggung maintenance 100% dan update sistem, pengelola menyediakan lahan dan listrik otonom.</p>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Durasi Kontrak Kerja Sama</span>
                        <span class="text-xl font-bold text-slate-800">3 - 5 Tahun</span>
                        <p class="text-xs text-slate-500 mt-2">Setelah masa kontrak berakhir, seluruh perangkat gerbang parkir dapat dihibahkan menjadi milik pengelola gedung (BOT mini).</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column (col-span-1 - Sticky Action Card) -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm sticky top-6">
                <h3 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">Ringkasan Peluang KSO IT</h3>

                <div class="space-y-4 text-sm mb-6">
                    <div>
                        <span class="text-slate-400 text-xs block">Skema Kerja Sama</span>
                        <span class="font-bold text-slate-800">KSO Bagi Hasil / Revenue Share</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs block">Modal Awal Pengelola (CapEx)</span>
                        <span class="font-bold text-indigo-700">Rp 0 (Zero CapEx)</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs block">Target Mitra Pengelola</span>
                        <span class="font-semibold text-slate-800">Mall, RS, & Perkantoran</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs block">Teknologi</span>
                        <span class="font-semibold text-slate-800">ALPR CCTV AI & QRIS Cloud</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs block">Lokasi Implementasi</span>
                        <span class="font-semibold text-slate-800">Kota Medan & Sekitarnya</span>
                    </div>
                </div>

                <div class="umkm-only">
                    <button class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-bold text-sm rounded-xl shadow-sm transition-all flex items-center justify-center gap-2 mb-3">
                    <span>Ajukan Kerja Sama Lahan/Gedung</span>
                </button>
                </div>

                <div class="besar-only">
                    <button disabled class="w-full py-3.5 bg-slate-100 text-slate-400 font-bold rounded-xl cursor-not-allowed border border-slate-200 flex justify-center items-center gap-2 mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" x2="19.07" y1="4.93" y2="19.07"/></svg>
                        Terbatas Untuk UMKM
                    </button>
                    <p class="text-[11px] text-center text-slate-500 mt-2 font-medium leading-tight px-2">Hanya akun kelas UMKM (Kecil/Mikro) yang dapat berinteraksi pada laman ini.</p>
                </div>

                <button class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <span>Jadwalkan Demo Sistem</span>
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
