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
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                        Kontrak Suplai / Keagenan (Usaha Kecil)
                    </span>
                    <span class="text-sm font-semibold text-slate-500 flex items-center gap-1">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Dipublikasikan: 27 Juli 2026
                    </span>
                </div>

                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4">
                    Kontrak Suplai Katering Karyawan Pabrik & Kawasan Industri Deli Serdang
                </h1>

                <!-- Initiator Company Info -->
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-amber-600 flex items-center justify-center text-white font-bold text-base flex-shrink-0">
                        KN
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Inisiator Suplai (Supply Side):</p>
                        <a href="/vendor/kuliner-nusantara" class="text-sm font-bold text-slate-800 hover:text-blue-600 flex items-center gap-1 transition-colors">
                            CV Kuliner Nusantara Sejahtera
                            <svg class="w-4 h-4 text-blue-500 inline" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </a>
                    </div>
                </div>

                <div class="prose prose-slate max-w-none text-slate-600 space-y-4 text-sm leading-relaxed">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2">Latar Belakang & Tujuan Kontrak Suplai</h3>
                    <p>
                        CV Kuliner Nusantara Sejahtera mengundang perusahaan manufaktur, perkebunan kelapa sawit, atau rumah sakit di kawasan Deli Serdang dan Medan untuk bermitra dalam layanan penyediaan makan karyawan (*Industrial Catering*).
                    </p>

                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2 mt-6">Komitmen Pelayanan & Menu Gizi</h3>
                    <ul class="list-disc pl-5 space-y-1">
                        <li><strong>Kapasitas Dapur:</strong> 5.000 Porsi per hari (Makan Siang & Makan Malam Shift).</li>
                        <li><strong>Standar Sertifikasi:</strong> Halal MUI, ISO 22000 (Food Safety), dan Sertifikat Laik Higiene Sanitas dari Dinas Kesehatan.</li>
                        <li><strong>Ahli Gizi:</strong> Menu disusun oleh ahli gizi bersertifikat untuk menjamin kecukupan kalori pekerja lapangan/pabrik.</li>
                    </ul>
                </div>
            </div>

            <!-- Skema Harga & Pembayaran Card -->
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 mb-6 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Skema Harga & Pembayaran (Offtaker Contract)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Penguncian Harga (Fixed Price)</span>
                        <span class="text-2xl font-black text-amber-700">Rp 18.000 <span class="text-sm font-normal text-slate-500">/ Porsi (Standard)</span></span>
                        <p class="text-xs text-slate-500 mt-2">Harga dikunci selama 1 tahun kontrak (sudah termasuk buah, air mineral, dan pengiriman ke lokasi pabrik).</p>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Minimum Order Quantity (MOQ)</span>
                        <span class="text-xl font-bold text-slate-800">Min. 500 Porsi / Hari</span>
                        <p class="text-xs text-slate-500 mt-2">Dapat dibagi untuk 2 shift kerja (siang dan malam) dengan pengiriman tepat waktu menggunakan armada boks tertutup.</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column (col-span-1 - Sticky Action Card) -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm sticky top-6">
                <h3 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">Ringkasan Kontrak Suplai</h3>

                <div class="space-y-4 text-sm mb-6">
                    <div>
                        <span class="text-slate-400 text-xs block">Skema Kerja Sama</span>
                        <span class="font-bold text-slate-800">Kontrak Suplai Katering Industri</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs block">Harga Kontrak</span>
                        <span class="font-bold text-amber-700">Rp 18.000 - 25.000 / Porsi</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs block">Minimum Order (MOQ)</span>
                        <span class="font-semibold text-slate-800">500 Porsi / Hari</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs block">Sertifikasi</span>
                        <span class="font-semibold text-slate-800">Halal MUI & ISO 22000</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs block">Jangkauan Pengiriman</span>
                        <span class="font-semibold text-slate-800">Medan & Deli Serdang</span>
                    </div>
                </div>

                <button class="w-full py-3 bg-amber-600 hover:bg-amber-700 active:bg-amber-800 text-white font-bold text-sm rounded-xl shadow-sm transition-all flex items-center justify-center gap-2 mb-3">
                    <span>Minta Quotation & Test Food</span>
                </button>

                <button class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <span>Jadwalkan Kunjungan Dapur</span>
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
