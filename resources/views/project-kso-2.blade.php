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
                        Kemitraan (Suplai & Offtaker)
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 mb-2 leading-tight">Kemitraan Suplai & Kontrak Offtaker Kopi Arabika Gayo Grade 1</h1>
                <a href="#" class="text-blue-600 font-semibold hover:underline text-lg flex items-center gap-1.5 mb-4 inline-flex">
                    PT Agro Kopi Nusantara
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </a>
                
                <p class="text-slate-600 font-medium mb-6 leading-relaxed">
                    Kami membuka kesempatan kemitraan suplai bahan baku kopi berkualitas ekspor secara berkelanjutan untuk menjamin stabilitas produksi bisnis manufaktur dan F&B Anda.
                </p>

                <div class="flex flex-wrap gap-2 pt-4 border-t border-slate-100">
                    <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">Kategori: Pertanian & Komoditas</span>
                    <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">Lokasi: Aceh & Medan</span>
                    <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">Skema: Kontrak Suplai Tetap / Offtaker</span>
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
                            <h4 class="font-bold text-slate-800">Fasilitas Pengolahan & Roastery 50 Ton/Bulan</h4>
                            <p class="text-sm text-slate-600 mt-1">Pabrik pengolahan berteknologi modern dengan kapasitas sortir (color sorter) dan gudang penyimpanan standar ekspor.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 p-1 bg-emerald-50 rounded-full text-emerald-600 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Jaringan 500+ Petani Binaan (Traceability)</h4>
                            <p class="text-sm text-slate-600 mt-1">Kepastian pasokan bahan baku dari kebun binaan langsung dengan sistem pelacakan asal-usul kopi (single origin terjamin).</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 p-1 bg-emerald-50 rounded-full text-emerald-600 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Sertifikasi Organik, Fairtrade, & ISO 22000</h4>
                            <p class="text-sm text-slate-600 mt-1">Standar mutu internasional yang siap memenuhi persyaratan audit ketat dari pasar domestik maupun global.</p>
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
                            <h4 class="font-bold text-slate-800">Perusahaan Manufaktur F&B / Roastery Besar</h4>
                            <p class="text-sm text-slate-600 mt-1">Kami terbuka untuk jaringan kafe eksklusif, pabrik pengolahan minuman, atau roastery yang membutuhkan kepastian suplai kopi konsisten dengan spesifikasi grade khusus.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 bg-white p-4 rounded-xl border border-blue-100 shadow-sm">
                        <div class="mt-0.5 p-1 bg-blue-50 rounded-full text-blue-600 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Distributor Regional & Eksportir (Offtaker)</h4>
                            <p class="text-sm text-slate-600 mt-1">Mitra yang bersedia menjalin kontrak komersial jangka panjang (1-3 tahun) sebagai offtaker tetap untuk mendistribusikan produk ke pasar domestik ataupun mancanegara.</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Skema Harga & Pembayaran (Komitmen Penjualan) -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 mb-6 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <div class="p-1.5 bg-blue-100 text-blue-600 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    Skema Harga & Pembayaran (Komitmen Penjualan)
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-200/80">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <h4 class="font-bold text-slate-900 mb-1">Penguncian Harga (Fixed Price)</h4>
                        <p class="text-sm text-slate-600">Harga material dikunci sebesar <strong>Rp 85.000/kg</strong> selama 1 tahun kontrak berjalan untuk melindungi mitra dari fluktuasi pasar.</p>
                    </div>

                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-200/80">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                        </div>
                        <h4 class="font-bold text-slate-900 mb-1">Minimum Order Quantity (MOQ)</h4>
                        <p class="text-sm text-slate-600">Mitra wajib menyerap atau membeli minimal <strong>5.000 kg (5 ton)</strong> per bulan sesuai jadwal pengiriman terjadwal.</p>
                    </div>

                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-200/80">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                        </div>
                        <h4 class="font-bold text-slate-900 mb-1">Termin Pembayaran</h4>
                        <p class="text-sm text-slate-600">Pembayaran dilakukan dengan skema <strong>Net 30</strong> (dibayar 30 hari setelah invoice diterima) di setiap akhir bulan.</p>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Right Column (col-span-1) -->
        <div class="md:col-span-1">
            <div class="sticky top-6 space-y-6">
                
                <!-- Document Download -->
                <div class="bg-blue-600 p-6 rounded-2xl shadow-sm border border-blue-700 text-white text-center">
                    <h3 class="font-bold mb-1">Katalog & Spesifikasi Produk</h3>
                    <p class="text-blue-100 text-xs mb-4">Sertifikat Uji Lab (COA) & Profil Roastery</p>
                    <button class="px-4 py-2.5 bg-white text-blue-700 hover:bg-blue-50 font-bold rounded-lg transition-colors w-full text-sm flex justify-center items-center gap-2 focus:ring-2 focus:ring-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                        Unduh Spesifikasi Teknis
                    </button>
                </div>

                <!-- Action Card -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 text-center">
                    <h2 class="text-lg font-bold text-slate-900 mb-2">Tertarik menjadi Offtaker?</h2>
                    <p class="text-xs text-slate-500 mb-6">Jadwalkan diskusi kontrak suplai atau kunjungan ke fasilitas pengolahan kami.</p>
                    
                    <div class="flex flex-col gap-3">
                        <button class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-blue-600/20 focus:ring-4 focus:ring-blue-100 focus:outline-none flex justify-center items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Ajukan Diskusi Kontrak Suplai
                        </button>
                        <button class="w-full py-3 bg-white hover:bg-slate-50 text-slate-700 font-bold border border-slate-300 rounded-xl transition-colors focus:ring-4 focus:ring-slate-100 focus:outline-none flex justify-center items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            Kirim Pesan
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
</div>
@endsection
