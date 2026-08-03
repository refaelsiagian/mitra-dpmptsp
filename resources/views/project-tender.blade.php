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
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-sm font-bold border border-blue-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Tender Resmi (RFP)
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 mb-2 leading-tight">Pembangunan Gedung Kantor Tahap 2</h1>
                <a href="#" class="text-blue-600 font-semibold hover:underline text-lg flex items-center gap-1.5 mb-6 inline-flex">
                    PT Inovasi Properti Mandiri
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                </a>
                
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">Wajib PKP</span>
                    <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">KBLI Konstruksi (41011)</span>
                    <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">Lokasi: Jakarta Selatan</span>
                </div>
            </div>
            
            <!-- SOW Section -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">Ruang Lingkup Pekerjaan (SOW)</h2>
                <div class="text-slate-600 leading-relaxed space-y-4">
                    <p>Proyek ini mencakup pembangunan struktur utama Gedung Kantor Tahap 2 yang berlokasi di area CBD Jakarta Selatan. Kontraktor yang terpilih bertanggung jawab penuh atas pengadaan material utama, alat berat, dan tenaga kerja bersertifikat.</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Pekerjaan persiapan dan pembersihan lahan (Clearing & Grubbing).</li>
                        <li>Pekerjaan pondasi dalam (Bored Pile) dan struktur beton bertulang hingga lantai 15.</li>
                        <li>Instalasi fasad kaca (Curtain Wall) sesuai spesifikasi teknis yang dilampirkan.</li>
                        <li>Pekerjaan mekanikal, elektrikal, dan plumbing (MEP) dasar.</li>
                    </ul>
                </div>
            </div>
            
            <!-- Timeline Section -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 mb-6 border-b border-slate-100 pb-3">Linimasa & Termin Pembayaran</h2>
                
                <div class="relative border-l border-slate-200 ml-3 space-y-6">
                    <!-- Termin 1 -->
                    <div class="mb-8 ml-6">
                        <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-4 ring-white">
                            <span class="w-2.5 h-2.5 bg-blue-600 rounded-full"></span>
                        </span>
                        <h3 class="font-bold text-slate-900">Termin 1 - Uang Muka (20%)</h3>
                        <p class="text-sm text-slate-500 font-medium">Dibayarkan 14 hari setelah penandatanganan kontrak dan penyerahan Jaminan Pelaksanaan.</p>
                    </div>
                    <!-- Termin 2 -->
                    <div class="mb-8 ml-6">
                        <span class="absolute flex items-center justify-center w-6 h-6 bg-slate-100 rounded-full -left-3 ring-4 ring-white border border-slate-200"></span>
                        <h3 class="font-bold text-slate-900">Termin 2 - Progress 50% (30%)</h3>
                        <p class="text-sm text-slate-500 font-medium">Dibayarkan setelah pekerjaan struktur mencapai lantai 8, dibuktikan dengan Berita Acara Serah Terima Parsial.</p>
                    </div>
                    <!-- Termin 3 -->
                    <div class="ml-6">
                        <span class="absolute flex items-center justify-center w-6 h-6 bg-slate-100 rounded-full -left-3 ring-4 ring-white border border-slate-200"></span>
                        <h3 class="font-bold text-slate-900">Termin 3 - Retensi (5%)</h3>
                        <p class="text-sm text-slate-500 font-medium">Dibayarkan setelah masa pemeliharaan (6 bulan) berakhir.</p>
                    </div>
                </div>
            </div>
            
            <!-- Document Section -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">Dokumen Lampiran</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:border-blue-300 hover:bg-blue-50 transition-colors group">
                        <div class="p-2 bg-red-100 text-red-600 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900 group-hover:text-blue-700">Spesifikasi_Teknis_v2.pdf</p>
                            <p class="text-xs text-slate-500">2.4 MB • Diperbarui 2 hari lalu</p>
                        </div>
                    </a>
                    
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:border-blue-300 hover:bg-blue-50 transition-colors group">
                        <div class="p-2 bg-green-100 text-green-600 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900 group-hover:text-blue-700">BOQ_Format_Kosong.xlsx</p>
                            <p class="text-xs text-slate-500">1.1 MB • Format Excel standar</p>
                        </div>
                    </a>
                </div>
            </div>
            
        </div>
        
        <!-- Right Column (col-span-1) -->
        <div class="md:col-span-1">
            <div class="sticky top-6 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="text-center mb-6">
                    <p class="text-sm font-medium text-slate-500 mb-1">Nilai Pagu Maksimal (Budget)</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-emerald-600">Rp 45.000.000.000</h3>
                    <p class="text-xs text-slate-400 mt-1">Belum termasuk PPN 11%</p>
                </div>
                
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center justify-center gap-3 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-600"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <div>
                        <p class="text-sm text-amber-800 font-medium leading-none">Batas Pengumpulan</p>
                        <p class="text-lg font-bold text-amber-900 mt-1 leading-none">Ditutup dalam 5 Hari</p>
                    </div>
                </div>
                
                <div class="umkm-only">
                    <button class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-blue-600/20 focus:ring-4 focus:ring-blue-100 focus:outline-none flex justify-center items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9 22 2z"/></svg>
                    Ajukan Penawaran
                </button>
                </div>

                <div class="besar-only">
                    <button disabled class="w-full py-3.5 bg-slate-100 text-slate-400 font-bold rounded-xl cursor-not-allowed border border-slate-200 flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" x2="19.07" y1="4.93" y2="19.07"/></svg>
                        Terbatas Untuk UMKM
                    </button>
                    <p class="text-[11px] text-center text-slate-500 mt-2 font-medium leading-tight px-2">Hanya akun kelas UMKM (Kecil/Mikro) yang dapat berinteraksi pada laman ini.</p>
                </div>
                
                <p class="text-xs text-center text-slate-500 mt-4 px-2">Dengan mengajukan penawaran, Anda menyetujui syarat & ketentuan pengadaan yang berlaku.</p>
            </div>
        </div>
        
    </div>
</div>
@endsection
