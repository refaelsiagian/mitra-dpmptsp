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
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-50 text-purple-700 text-sm font-bold border border-purple-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        Sub-Pekerjaan
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 mb-2 leading-tight">Instalasi Pipa HVAC Lantai 1-5</h1>
                <p class="text-lg text-slate-600 font-medium mb-6">Pemberi Tugas: <a href="#" class="text-blue-600 hover:underline font-semibold">PT Waskita Karya (Persero) Tbk</a></p>
                
                <!-- Task Specs in Header -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t border-slate-100">
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Target Mulai</p>
                        <p class="text-sm font-bold text-slate-900">12 Ags 2026</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Volume</p>
                        <p class="text-sm font-bold text-slate-900">4,500 m²</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Lokasi</p>
                        <p class="text-sm font-bold text-slate-900">Surabaya</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Estimasi Nilai</p>
                        <p class="text-sm font-bold text-emerald-600">± Rp 1,2 M</p>
                    </div>
                </div>
            </div>

            <!-- Deskripsi Tugas -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">Deskripsi Tugas</h2>
                <p class="text-slate-600 leading-relaxed">
                    Dibutuhkan sub-kontraktor berpengalaman untuk melakukan instalasi jaringan pipa HVAC (Heating, Ventilation, and Air Conditioning) pada proyek pembangunan rumah sakit umum daerah lantai 1 hingga 5. Pekerjaan meliputi pemasangan ducting, isolasi termal, dan pengujian sistem (testing & commissioning) secara parsial.
                </p>
            </div>

            <!-- Pembagian Tanggung Jawab -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 mb-6 border-b border-slate-100 pb-3">Pembagian Tanggung Jawab</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- List 1 -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            Disediakan Pemberi Tugas
                        </h3>
                        <ul class="space-y-2 text-slate-600 text-sm">
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mt-2 flex-shrink-0"></span>
                                <span>Material utama (Pipa, Seng BJLS, Isolasi Glasswool).</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mt-2 flex-shrink-0"></span>
                                <span>Akses listrik dan air kerja di lokasi.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mt-2 flex-shrink-0"></span>
                                <span>Fasilitas perancah (Scaffolding) statis.</span>
                            </li>
                        </ul>
                    </div>
                    <!-- List 2 -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-500"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            Tanggung Jawab Pelaksana
                        </h3>
                        <ul class="space-y-2 text-slate-600 text-sm">
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-2 flex-shrink-0"></span>
                                <span>Tenaga kerja (Tukang ducting, knopper, helper) lengkap dengan APD.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-2 flex-shrink-0"></span>
                                <span>Peralatan kerja harian (Hand tools, bor, mesin las portabel).</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-2 flex-shrink-0"></span>
                                <span>Bahan habis pakai (Kawat las, mata gerinda).</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Right Column (col-span-1) -->
        <div class="md:col-span-1">
            <div class="sticky top-6 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="text-center mb-6 border-b border-slate-100 pb-6">
                    <p class="text-sm font-medium text-slate-500 mb-1">Batas Waktu Pelaksanaan</p>
                    <h3 class="text-2xl font-bold text-slate-900">30 Hari Kerja</h3>
                </div>
                
                <div class="mb-6">
                    <label for="harga" class="block text-sm font-bold text-slate-700 mb-2">Harga Penawaran Anda</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-slate-500 font-semibold text-sm">Rp</span>
                        </div>
                        <input type="text" id="harga" class="block w-full pl-10 pr-3 py-3 border border-slate-300 rounded-xl text-slate-900 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm bg-white" placeholder="Contoh: 1.150.000.000">
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Harga borongan keseluruhan (Lumpsum). Bisa dinegosiasikan.</p>
                </div>
                
                <div class="umkm-only">
                    <button class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-blue-600/20 focus:ring-4 focus:ring-blue-100 focus:outline-none flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        Lamar Cepat (Quick Apply)
                    </button>
                </div>
                
                <div class="besar-only">
                    <button disabled class="w-full py-3.5 bg-slate-100 text-slate-400 font-bold rounded-xl cursor-not-allowed border border-slate-200 flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" x2="19.07" y1="4.93" y2="19.07"/></svg>
                        Terbatas Untuk UMKM
                    </button>
                    <p class="text-[11px] text-center text-slate-500 mt-2 font-medium leading-tight px-2">Hanya akun kelas UMKM (Kecil/Mikro) yang dapat melamar proyek jenis ini.</p>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
