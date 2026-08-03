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
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                        Kemitraan Suplai & Offtaker (Usaha Kecil)
                    </span>
                    <span class="text-sm font-semibold text-slate-500 flex items-center gap-1">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Dipublikasikan: 27 Juli 2026
                    </span>
                </div>

                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4">
                    Kontrak Suplai & Offtaker Sayuran Organik Dataran Tinggi Karo (Fixed Price)
                </h1>

                <!-- Initiator Company Info -->
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-bold text-base flex-shrink-0">
                        TJ
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Inisiator Kemitraan (Supply Side):</p>
                        <a href="/vendor/tani-jaya" class="text-sm font-bold text-slate-800 hover:text-blue-600 flex items-center gap-1 transition-colors">
                            Koperasi Produsen Tani Jaya Mandiri
                            <svg class="w-4 h-4 text-blue-500 inline" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </a>
                    </div>
                </div>

                <div class="prose prose-slate max-w-none text-slate-600 space-y-4 text-sm leading-relaxed">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2">Latar Belakang & Tujuan Suplai</h3>
                    <p>
                        Sebagai Koperasi Produsen yang menaungi 50 petani hortikultura di dataran tinggi Karo, kami memiliki kapasitas panen rutin sayuran daun dan umbi-umbian kelas Grade A (supermarket & ekspor). Untuk menjaga stabilitas pasokan dan kepastian pendapatan petani, kami mengundang perusahaan makanan/minuman (F&B), rantai hotel/resort, atau distributor supermarket untuk mengikat kontrak jual-beli tetap (*Offtaker Agreement*).
                    </p>

                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2 mt-6">Komitmen Penjualan & MOQ</h3>
                    <ul class="list-disc pl-5 space-y-1">
                        <li><strong>Komoditas Utama:</strong> Kubis, Wortel Brastagi, Kentang Granola, Brokoli, dan Selada Air.</li>
                        <li><strong>Minimum Order Quantity (MOQ):</strong> 10 Ton per bulan (dapat dikirim bertahap 2,5 ton per minggu).</li>
                        <li><strong>Standar Sortase:</strong> Sudah dicuci bersih, sortase Grade A, dan dikemas dalam krat plastik higienis bersirkulasi udara dingin.</li>
                    </ul>
                </div>
            </div>

            <!-- Skema Harga & Pembayaran Card (Adapted for Supply/Offtaker) -->
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 mb-6 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Skema Harga & Pembayaran (Offtaker Contract)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Penguncian Harga (Fixed Price)</span>
                        <span class="text-2xl font-black text-emerald-700">Rp 15.000 <span class="text-sm font-normal text-slate-500">/ kg (Rata-rata)</span></span>
                        <p class="text-xs text-slate-500 mt-2">Harga dikunci selama 1 tahun kontrak berjalan untuk melindung offtaker dari inflasi atau fluktuasi cuaca.</p>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Termin Pembayaran</span>
                        <span class="text-xl font-bold text-slate-800">NET 14 Hari</span>
                        <p class="text-xs text-slate-500 mt-2">Pembayaran dilakukan via transfer bank 14 hari setelah invoice diterbitkan setiap pengiriman mingguan.</p>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-100 text-sm text-blue-900 flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <strong>Jaminan Kualitas Kepuasan:</strong> Apabila terdapat sayuran yang cacat atau layu saat penerimaan di gudang pembeli, koperasi siap mengganti 100% pada jadwal pengiriman berikutnya.
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
                        <span class="font-bold text-slate-800">Kontrak Suplai & Offtaker Tetap</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs block">Kapasitas Produksi</span>
                        <span class="font-bold text-emerald-700">25 Ton / Bulan (Ready)</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs block">Minimum Order (MOQ)</span>
                        <span class="font-semibold text-slate-800">10 Ton / Bulan</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs block">Durasi Kontrak</span>
                        <span class="font-semibold text-slate-800">1 - 3 Tahun (Dapat Diperpanjang)</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs block">Lokasi Packing House</span>
                        <span class="font-semibold text-slate-800">Berastagi, Kabupaten Karo</span>
                    </div>
                </div>

                <div class="umkm-only">
                    <button class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-sm rounded-xl shadow-sm transition-all flex items-center justify-center gap-2 mb-3">
                    <span>Ajukan Minat Menjadi Offtaker</span>
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
                    <span>Jadwalkan Diskusi Awal</span>
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
