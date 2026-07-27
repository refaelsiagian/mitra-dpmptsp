@extends('layouts.dashboard')

@section('content')
<div class="max-w-5xl mx-auto flex flex-col h-full">
    
    <!-- Header -->
    <div class="mb-6 flex-shrink-0">
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Eksplorasi Vendor & Pemilik Proyek</h2>
        <p class="text-slate-500 mt-1 sm:text-lg">Temukan mitra bisnis terverifikasi yang menawarkan peluang tender, sub-pekerjaan, dan kolaborasi KSO.</p>
    </div>

    <!-- Filter Toolbar -->
    <div class="bg-white p-3 sm:p-4 rounded-xl border border-slate-200 shadow-sm mb-6 flex-shrink-0 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            
            <!-- Kategori KBLI Dropdown -->
            <div class="relative">
                <select class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-2 pl-4 pr-10 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer hover:bg-slate-100 transition-colors">
                    <option value="" disabled selected>Kategori KBLI</option>
                    <option value="konstruksi">Konstruksi & Infrastruktur</option>
                    <option value="pariwisata">Pariwisata & Hospitality</option>
                    <option value="pertanian">Pertanian & Komoditas</option>
                    <option value="logistik">Logistik & Pergudangan</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </div>
            </div>

            <!-- Lokasi Dropdown -->
            <div class="relative">
                <select class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-2 pl-4 pr-10 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer hover:bg-slate-100 transition-colors">
                    <option value="" disabled selected>Lokasi</option>
                    <option value="medan">Sumatera Utara (Medan / Belawan)</option>
                    <option value="jakarta">DKI Jakarta & Sekitarnya</option>
                    <option value="surabaya">Jawa Timur (Surabaya)</option>
                    <option value="aceh">Aceh</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </div>
            </div>

            <!-- Status Proyek Dropdown -->
            <div class="relative">
                <select class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-2 pl-4 pr-10 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer hover:bg-slate-100 transition-colors">
                    <option value="" disabled selected>Peluang Ditawarkan</option>
                    <option value="tender">Tender Resmi (RFP)</option>
                    <option value="subcon">Sub-Pekerjaan</option>
                    <option value="kso">Kemitraan (KSO / JV)</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </div>
            </div>

        </div>

        <!-- Reset Filter -->
        <button class="text-sm font-medium text-slate-500 hover:text-red-600 transition-colors flex items-center gap-1.5 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
            Reset Filter
        </button>
    </div>

    <!-- Feed / List -->
    <div class="flex-1 overflow-y-auto pb-8 pr-2 custom-scrollbar">
        <div class="flex flex-col gap-5">
            
            <!-- Vendor 1: PT Inovasi Properti Mandiri (Tender Resmi) -->
            @include('components.vendor-card', [
                'name' => 'PT Inovasi Properti Mandiri', 
                'category' => 'Konstruksi & Pengembangan Properti', 
                'location' => 'Jakarta Selatan, DKI Jakarta',
                'profileUrl' => '/vendor/inovasi-properti',
                'projectUrl' => '/project/tender',
                'activeProject' => 'Tender Resmi: Pembangunan Gedung Kantor Tahap 2',
                'chips' => ['Properti Mandiri', 'Konstruksi Gedung', 'Manajemen Proyek']
            ])
            
            <!-- Vendor 2: PT Waskita Karya (Persero) Tbk (Sub-Pekerjaan) -->
            @include('components.vendor-card', [
                'name' => 'PT Waskita Karya (Persero) Tbk', 
                'category' => 'Kontraktor Umum & Infrastruktur (BUMN)', 
                'location' => 'Jakarta & Surabaya',
                'profileUrl' => '/vendor/waskita',
                'projectUrl' => '/project/subcon',
                'activeProject' => 'Sub-Pekerjaan: Instalasi Pipa HVAC Lantai 1-5',
                'chips' => ['Infrastruktur', 'HVAC & MEP', 'Kontraktor Utama']
            ])
            
            <!-- Vendor 3: PT Nusantara Wisata (KSO BOT) -->
            @include('components.vendor-card', [
                'name' => 'PT Nusantara Wisata', 
                'category' => 'Pariwisata & Pengembangan Kawasan Resort', 
                'location' => 'Medan, Sumatera Utara',
                'profileUrl' => '/vendor/nusantara-wisata',
                'projectUrl' => '/project/kso',
                'activeProject' => 'KSO (BOT): Pengembangan Kawasan Ekowisata Danau Toba',
                'chips' => ['Ekowisata', 'Hospitality', 'Resort Development', 'BOT Scheme']
            ])

            <!-- Vendor 4: PT Agro Kopi Nusantara (KSO Suplai) -->
            @include('components.vendor-card', [
                'name' => 'PT Agro Kopi Nusantara', 
                'category' => 'Pertanian, Pengolahan Kopi, & Komoditas Ekspor', 
                'location' => 'Aceh & Medan, Sumatera Utara',
                'profileUrl' => '/vendor/agro-kopi',
                'projectUrl' => '/project/kso/2',
                'activeProject' => 'KSO (Suplai): Kopi Arabika Gayo Grade 1 (Fixed Price)',
                'chips' => ['Kopi Arabika', 'Roastery 50 Ton', 'Fairtrade & Organic', 'Offtaker']
            ])

            <!-- Vendor 5: PT Logistik Maritim Nusantara (KSO Eksplorasi) -->
            @include('components.vendor-card', [
                'name' => 'PT Logistik Maritim Nusantara', 
                'category' => 'Logistik Maritim, Pergudangan, & Cold Chain', 
                'location' => 'Kawasan Pelabuhan Belawan, Sumatera Utara',
                'profileUrl' => '/vendor/logistik-maritim',
                'projectUrl' => '/project/kso/3',
                'activeProject' => 'KSO (Eksplorasi): Utilisasi Fasilitas Cold Storage Terpadu',
                'chips' => ['Cold Storage 10k Pallet', '50 Refrigerated Trucks', 'Port Logistics']
            ])
            
            <!-- Vendor 6: CV Baja Nusantara (Standard Vendor without project) -->
            @include('components.vendor-card', [
                'name' => 'CV Baja Nusantara', 
                'category' => 'Konstruksi Logam & Fabrikasi', 
                'location' => 'Medan, Sumatera Utara',
                'profileUrl' => '/vendor-profile',
                'chips' => ['Welding', 'CNC Machining', 'Baja Ringan']
            ])

        </div>
    </div>
</div>

<style>
    /* Subtle custom scrollbar for the feed */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 20px;
    }
</style>
@endsection
