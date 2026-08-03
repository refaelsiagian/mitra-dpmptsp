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
            
            <!-- Header Section -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                <div class="mb-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-teal-50 text-teal-700 text-sm font-bold border border-teal-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Kemitraan (Eksplorasi Skema)
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 mb-2 leading-tight">Pengembangan & Utilisasi Fasilitas Rantai Pendingin (Cold Storage) Terpadu</h1>
                <a href="#" class="text-blue-600 font-semibold hover:underline text-lg flex items-center gap-1.5 mb-4 inline-flex">
                    PT Logistik Maritim Nusantara
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </a>
                
                <p class="text-slate-600 font-medium mb-6 leading-relaxed">
                    Kami mengundang mitra strategis untuk mengoptimalkan kapasitas cold storage dan infrastruktur rantai pasok kami di koridor pelabuhan utama guna memperluas jaringan distribusi nusantara.
                </p>

                <div class="flex flex-wrap gap-2 pt-4 border-t border-slate-100">
                    <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">Kategori: Logistik & Pergudangan</span>
                    <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">Lokasi: Kawasan Pelabuhan Belawan</span>
                    <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">Skema: Terbuka & Fleksibel</span>
                </div>
            </div>

            <!-- Apa yang Kami Miliki (Kapasitas Kami) -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <div class="p-1.5 bg-emerald-100 text-emerald-600 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10.5V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.5"/><path d="m9 11 3 3L22 4"/></svg>
                    </div>
                    Apa yang Kami Miliki (Kapasitas Kami)
                </h2>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 p-1 bg-emerald-50 rounded-full text-emerald-600 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Cold Storage 10.000 Pallet Position</h4>
                            <p class="text-sm text-slate-600 mt-1">Gudang berpendingin dengan teknologi Blast Freezer dan Chiller serta sistem manajemen pergudangan (WMS) otomatis terintegrasi.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 p-1 bg-emerald-50 rounded-full text-emerald-600 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Armada 50 Truk Refrigerated (Cold Chain)</h4>
                            <p class="text-sm text-slate-600 mt-1">Armada transportasi pendingin komersial bermesin Thermo King dengan pelacakan suhu real-time 24/7 dan izin trayek lengkap.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 p-1 bg-emerald-50 rounded-full text-emerald-600 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Lahan Komersial Siap Ekspansi 3 Hektar</h4>
                            <p class="text-sm text-slate-600 mt-1">Lahan bersertifikat HGB tepat di samping fasilitas gudang saat ini, siap digunakan untuk penambahan kapasitas atau pembangunan fasilitas pengolahan.</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Target Mitra (Target Partner) -->
            <div class="bg-blue-50/50 p-6 md:p-8 rounded-2xl border-2 border-dashed border-blue-200">
                <h2 class="text-xl font-bold text-blue-900 mb-4 border-b border-blue-200/50 pb-3 flex items-center gap-2">
                    <div class="p-1.5 bg-blue-100 text-blue-600 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    Target Mitra (Target Partner)
                </h2>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3 bg-white p-4 rounded-xl border border-blue-100 shadow-sm">
                        <div class="mt-0.5 p-1 bg-blue-50 rounded-full text-blue-600 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Produsen & Eksportir F&B / Komoditas Beku</h4>
                            <p class="text-sm text-slate-600 mt-1">Kami terbuka untuk perusahaan pertambak, produsen seafood, daging beku, atau farmasi yang membutuhkan hub distribusi rantai pendingin modern.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 bg-white p-4 rounded-xl border border-blue-100 shadow-sm">
                        <div class="mt-0.5 p-1 bg-blue-50 rounded-full text-blue-600 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Operator Logistik Global & Investor Infrastruktur</h4>
                            <p class="text-sm text-slate-600 mt-1">Mitra atau investor yang ingin memperluas jaringan koridor logistik laut dan darat di titik strategis kawasan ekonomi khusus Sumatera Utara.</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Ekspektasi Kolaborasi -->
            <div class="bg-gradient-to-br from-white to-slate-50 p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-blue-100/40 rounded-full blur-2xl pointer-events-none"></div>
                
                <h2 class="text-xl font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <div class="p-1.5 bg-blue-100 text-blue-600 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m11 17 2 2a1 1 0 1 0 3-3"/><path d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 4"/><path d="m21 3 1 11h-2"/><path d="M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3"/><path d="M3 4h8"/></svg>
                    </div>
                    Ekspektasi Kolaborasi
                </h2>
                
                <p class="text-slate-700 text-base leading-relaxed mb-6">
                    "Kami terbuka terhadap berbagai skema kerja sama, baik berupa <strong>KSO (Kerja Sama Operasi)</strong>, <strong>penyertaan saham (akuisisi parsial)</strong>, maupun <strong>kontrak keagenan</strong>. Mari jadwalkan diskusi awal untuk mencari skema yang saling menguntungkan."
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="bg-white p-3 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0"></span>
                        <span class="text-xs font-semibold text-slate-700">Kerja Sama Operasi (KSO)</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-teal-500 flex-shrink-0"></span>
                        <span class="text-xs font-semibold text-slate-700">Akuisisi Parsial / Saham</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-purple-500 flex-shrink-0"></span>
                        <span class="text-xs font-semibold text-slate-700">Kontrak Keagenan & Sewa</span>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Right Column (col-span-1) -->
        <div class="md:col-span-1">
            <div class="sticky top-6 space-y-6">
                
                <!-- Document Download -->
                <div class="bg-blue-600 p-6 rounded-2xl shadow-sm border border-blue-700 text-white text-center">
                    <h3 class="font-bold mb-1">Profil Kapasitas & Infrastruktur</h3>
                    <p class="text-blue-100 text-xs mb-4">Masterplan Fasilitas & Sertifikasi ISO/Cold Chain</p>
                    <button class="px-4 py-2.5 bg-white text-blue-700 hover:bg-blue-50 font-bold rounded-lg transition-colors w-full text-sm flex justify-center items-center gap-2 focus:ring-2 focus:ring-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                        Unduh Company Profile
                    </button>
                </div>

                <!-- Action Card -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 text-center">
                    <h2 class="text-lg font-bold text-slate-900 mb-2">Tertarik Menjalin Kolaborasi?</h2>
                    <p class="text-xs text-slate-500 mb-6">Kami mengundang Anda untuk diskusi penjajakan model bisnis atau kunjungan ke lokasi gudang kami.</p>
                    
                    <div class="flex flex-col gap-3">
                        <div class="umkm-only">
                    <button class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-blue-600/20 focus:ring-4 focus:ring-blue-100 focus:outline-none flex justify-center items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Jadwalkan Diskusi Awal
                        </button>
                </div>

                <div class="besar-only">
                    <button disabled class="w-full py-3.5 bg-slate-100 text-slate-400 font-bold rounded-xl cursor-not-allowed border border-slate-200 flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" x2="19.07" y1="4.93" y2="19.07"/></svg>
                        Terbatas Untuk UMKM
                    </button>
                    <p class="text-[11px] text-center text-slate-500 mt-2 font-medium leading-tight px-2">Hanya akun kelas UMKM (Kecil/Mikro) yang dapat berinteraksi pada laman ini.</p>
                </div>
                        <button class="w-full py-3 bg-white hover:bg-slate-50 text-slate-700 font-bold border border-slate-300 rounded-xl transition-colors focus:ring-4 focus:ring-slate-100 focus:outline-none flex justify-center items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            Kirim Pesan Penjajakan
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
</div>
@endsection
