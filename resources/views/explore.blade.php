@extends('layouts.dashboard')

@section('content')
<div class="max-w-5xl mx-auto flex flex-col h-full">
    
    <!-- Header Row 1: Title & Tabs -->
    <div class="mb-3 flex-shrink-0 flex flex-col md:flex-row md:items-center justify-between gap-3">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Eksplorasi Peluang & Mitra Bisnis</h2>
        
        <!-- Compact Marketplace Tab Bar -->
        <div class="bg-slate-200/80 p-1 rounded-xl flex items-center gap-1 self-start md:self-auto flex-shrink-0 border border-slate-300/50">
            <button id="tab-btn-vendors" onclick="switchTab('vendors')" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 flex items-center gap-1.5 bg-white text-blue-700 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
                <span>Mitra & Vendor</span>
                <span class="px-1.5 py-0.2 rounded-full bg-blue-100 text-blue-700 text-[10px] font-extrabold">11</span>
            </button>
            <button id="tab-btn-projects" onclick="switchTab('projects')" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 flex items-center gap-1.5 text-slate-600 hover:text-slate-900 hover:bg-white/50">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span>Peluang Proyek (RFP/KSO)</span>
                <span class="px-1.5 py-0.2 rounded-full bg-slate-300 text-slate-800 text-[10px] font-extrabold">10</span>
            </button>
        </div>
    </div>

    <!-- Header Row 2: Search Bar & Filter Button -->
    <div class="mb-4 flex-shrink-0 flex items-center gap-2.5">
        <!-- Live Search Input -->
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <input type="text" id="live-search-input" onkeyup="filterCardsLive()" class="block w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow bg-white shadow-2xs hover:border-slate-300" placeholder="Cari nama perusahaan, judul proyek, keahlian KBLI, atau lokasi...">
        </div>

        <!-- Filter Toggle Button -->
        <button onclick="toggleFilters()" id="filter-toggle-btn" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 transition-colors shadow-2xs flex-shrink-0 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            <span>Filter KBLI / Lokasi</span>
            <span id="filter-badge" class="hidden w-1.5 h-1.5 rounded-full bg-blue-600 ml-0.5"></span>
        </button>
    </div>

    <!-- Collapsible Filter Toolbar (Hidden by default) -->
    <div id="filter-panel" class="hidden bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm mb-4 flex-shrink-0 transition-all duration-300">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-2.5 w-full sm:w-auto">
                
                <!-- Kategori KBLI Dropdown -->
                <div class="relative">
                    <select class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-1.5 pl-3.5 pr-8 rounded-lg text-xs font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer hover:bg-slate-100 transition-colors">
                        <option value="" disabled selected>Kategori KBLI</option>
                        <option value="konstruksi">Konstruksi & Infrastruktur</option>
                        <option value="pariwisata">Pariwisata & Hospitality</option>
                        <option value="pertanian">Pertanian & Komoditas</option>
                        <option value="logistik">Logistik & Pergudangan</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                </div>

                <!-- Lokasi Dropdown -->
                <div class="relative">
                    <select class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-1.5 pl-3.5 pr-8 rounded-lg text-xs font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer hover:bg-slate-100 transition-colors">
                        <option value="" disabled selected>Lokasi</option>
                        <option value="medan">Sumatera Utara (Medan / Belawan)</option>
                        <option value="jakarta">DKI Jakarta & Sekitarnya</option>
                        <option value="surabaya">Jawa Timur (Surabaya)</option>
                        <option value="aceh">Aceh</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                </div>

                <!-- Skema / Peluang Dropdown -->
                <div class="relative">
                    <select class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-1.5 pl-3.5 pr-8 rounded-lg text-xs font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer hover:bg-slate-100 transition-colors">
                        <option value="" disabled selected>Skema Peluang</option>
                        <option value="tender">Tender Resmi (RFP)</option>
                        <option value="subcon">Sub-Pekerjaan</option>
                        <option value="kso">Kemitraan (KSO / JV / Suplai)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                </div>

            </div>

            <!-- Reset Filter -->
            <button onclick="toggleFilters()" class="text-xs font-medium text-slate-500 hover:text-red-600 transition-colors flex items-center gap-1.5 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                Tutup Filter
            </button>
        </div>
    </div>

    <!-- TAB FEED 1: VENDORS -->
    <div id="feed-vendors" class="flex-1 overflow-y-auto pb-8 pr-2 custom-scrollbar transition-opacity duration-300">
        <div class="flex flex-col gap-4" id="list-vendors">
            
            <!-- Vendor 1: PT Inovasi Properti Mandiri -->
            <div class="card-item">
                @include('components.vendor-card', [
                    'name' => 'PT Inovasi Properti Mandiri', 
                    'category' => 'Konstruksi & Pengembangan Properti • Usaha Besar (B)', 
                    'location' => 'Jakarta Selatan, DKI Jakarta',
                    'profileUrl' => '/vendor/inovasi-properti',
                    'projectUrl' => '/project/tender',
                    'activeProject' => 'Tender Resmi: Pembangunan Gedung Kantor Tahap 2',
                    'chips' => ['Properti Mandiri', 'Konstruksi Gedung', 'Manajemen Proyek']
                ])
            </div>
            
            <!-- Vendor 2: PT Waskita Karya -->
            <div class="card-item">
                @include('components.vendor-card', [
                    'name' => 'PT Waskita Karya (Persero) Tbk', 
                    'category' => 'Kontraktor Umum & Infrastruktur (BUMN) • Usaha Besar (B)', 
                    'location' => 'Jakarta & Surabaya',
                    'profileUrl' => '/vendor/waskita',
                    'projectUrl' => '/project/subcon',
                    'activeProject' => 'Sub-Pekerjaan: Instalasi Pipa HVAC Lantai 1-5',
                    'chips' => ['Infrastruktur', 'HVAC & MEP', 'Kontraktor Utama']
                ])
            </div>
            
            <!-- Vendor 3: PT Nusantara Wisata -->
            <div class="card-item">
                @include('components.vendor-card', [
                    'name' => 'PT Nusantara Wisata', 
                    'category' => 'Pariwisata & Pengembangan Kawasan Resort • Usaha Besar (B)', 
                    'location' => 'Medan, Sumatera Utara',
                    'profileUrl' => '/vendor/nusantara-wisata',
                    'projectUrl' => '/project/kso',
                    'activeProject' => 'KSO (BOT): Pengembangan Kawasan Ekowisata Danau Toba',
                    'chips' => ['Ekowisata', 'Hospitality', 'Resort Development', 'BOT Scheme']
                ])
            </div>

            <!-- Vendor 4: PT Agro Kopi Nusantara -->
            <div class="card-item">
                @include('components.vendor-card', [
                    'name' => 'PT Agro Kopi Nusantara', 
                    'category' => 'Pertanian, Pengolahan Kopi, & Komoditas Ekspor • Usaha Menengah (M)', 
                    'location' => 'Aceh & Medan, Sumatera Utara',
                    'profileUrl' => '/vendor/agro-kopi',
                    'projectUrl' => '/project/kso/2',
                    'activeProject' => 'KSO (Suplai): Kopi Arabika Gayo Grade 1 (Fixed Price)',
                    'chips' => ['Kopi Arabika', 'Roastery 50 Ton', 'Fairtrade & Organic', 'Offtaker']
                ])
            </div>

            <!-- Vendor 5: PT Logistik Maritim Nusantara -->
            <div class="card-item">
                @include('components.vendor-card', [
                    'name' => 'PT Logistik Maritim Nusantara', 
                    'category' => 'Logistik Maritim, Pergudangan, & Cold Chain • Usaha Besar (B)', 
                    'location' => 'Kawasan Pelabuhan Belawan, Sumatera Utara',
                    'profileUrl' => '/vendor/logistik-maritim',
                    'projectUrl' => '/project/kso/3',
                    'activeProject' => 'KSO (Eksplorasi): Utilisasi Fasilitas Cold Storage Terpadu',
                    'chips' => ['Cold Storage 10k Pallet', '50 Refrigerated Trucks', 'Port Logistics']
                ])
            </div>
            
            <!-- Vendor 6: CV Baja Nusantara -->
            <div class="card-item">
                @include('components.vendor-card', [
                    'name' => 'CV Baja Nusantara', 
                    'category' => 'Konstruksi Logam & Fabrikasi • Usaha Menengah (M)', 
                    'location' => 'Medan, Sumatera Utara',
                    'profileUrl' => '/vendor-profile',
                    'chips' => ['Welding', 'CNC Machining', 'Baja Ringan']
                ])
            </div>

            <!-- Vendor 7: Koperasi Produsen Tani Jaya Mandiri -->
            <div class="card-item">
                @include('components.vendor-card', [
                    'name' => 'Koperasi Produsen Tani Jaya Mandiri', 
                    'category' => 'Pertanian & Komoditas Pangan • Usaha Kecil (K)', 
                    'location' => 'Berastagi, Kabupaten Karo, Sumatera Utara',
                    'profileUrl' => '/vendor/tani-jaya',
                    'projectUrl' => '/project/kso/tani',
                    'activeProject' => 'KSO (Suplai): Kontrak Offtaker Sayuran Organik Karo',
                    'chips' => ['Sayur Organik Grade A', 'Koperasi 50 Petani', 'Cold Storage 20 Ton', 'Offtaker']
                ])
            </div>

            <!-- Vendor 8: CV Rekayasa Digital Nusantara -->
            <div class="card-item">
                @include('components.vendor-card', [
                    'name' => 'CV Rekayasa Digital Nusantara', 
                    'category' => 'Teknologi Informasi (IT) & Smart System • Usaha Kecil (K)', 
                    'location' => 'Kota Medan, Sumatera Utara',
                    'profileUrl' => '/vendor/rekayasa-digital',
                    'projectUrl' => '/project/kso/digital',
                    'activeProject' => 'KSO (Bagi Hasil): Smart Parking AI & CCTV Analytics (Zero CapEx)',
                    'chips' => ['Smart Parking LPR', 'CCTV AI Analytics', 'Zero CapEx', 'Revenue Share 70:30']
                ])
            </div>

            <!-- Vendor 9: CV Kuliner Nusantara Sejahtera -->
            <div class="card-item">
                @include('components.vendor-card', [
                    'name' => 'CV Kuliner Nusantara Sejahtera', 
                    'category' => 'Industri F&B & Katering Industri • Usaha Kecil (K)', 
                    'location' => 'Deli Serdang & Medan, Sumatera Utara',
                    'profileUrl' => '/vendor/kuliner-nusantara',
                    'projectUrl' => '/project/kso/kuliner',
                    'activeProject' => 'KSO (Suplai): Kontrak Suplai Katering Karyawan Pabrik',
                    'chips' => ['Katering 5.000 Porsi', 'Sertifikasi Halal MUI', 'ISO 22000', 'Ahli Gizi']
                ])
            </div>

            <!-- Vendor 10: UD Kreatif Kemasan Abadi -->
            <div class="card-item">
                @include('components.vendor-card', [
                    'name' => 'UD Kreatif Kemasan Abadi', 
                    'category' => 'Percetakan, Sablon, & Kemasan (Packaging) • Usaha Mikro (Mikro)', 
                    'location' => 'Medan Denai, Kota Medan',
                    'profileUrl' => '/vendor/kreatif-kemasan',
                    'projectUrl' => '/project/kso/kemasan',
                    'activeProject' => 'KSO (Suplai): Suplai Box Kardus & Kemasan Eco-Friendly',
                    'chips' => ['Corrugated Box Custom', 'Kraft Eco-Friendly', 'Sablon Custom', 'MOQ 1.000 Pcs']
                ])
            </div>

            <!-- Vendor 11: Bank Sampah Daur Ulang Mandiri -->
            <div class="card-item">
                @include('components.vendor-card', [
                    'name' => 'Bank Sampah Daur Ulang Mandiri', 
                    'category' => 'Pengolahan Limbah & Daur Ulang Plastik • Usaha Mikro (Mikro)', 
                    'location' => 'Medan Marelan & Belawan, Kota Medan',
                    'profileUrl' => '/vendor/daur-ulang',
                    'projectUrl' => '/project/kso/daurulang',
                    'activeProject' => 'KSO (Suplai): Kontrak Offtaker Cacahan Plastik PET Bersih',
                    'chips' => ['Hot Washed PET Flakes', '15 Ton / Bulan', 'Circular Economy', '200 Pemulung']
                ])
            </div>

        </div>
    </div>

    <!-- TAB FEED 2: PROJECTS & OPPORTUNITIES -->
    <div id="feed-projects" class="flex-1 overflow-y-auto pb-8 pr-2 custom-scrollbar transition-opacity duration-300 hidden">
        <div class="flex flex-col gap-4" id="list-projects">
            
            <!-- Project 1: Tender Resmi Gedung Kantor -->
            <div class="card-item">
                @include('components.project-card', [
                    'type' => 'tender',
                    'typeLabel' => 'Tender Resmi (RFP)',
                    'title' => 'Pembangunan Gedung Kantor Tahap 2',
                    'company' => 'PT Inovasi Properti Mandiri',
                    'companyUrl' => '/vendor/inovasi-properti',
                    'location' => 'Jakarta Selatan, DKI Jakarta',
                    'category' => 'Konstruksi & Properti',
                    'valueLabel' => 'Nilai Pagu Maksimal',
                    'value' => 'Rp 45.000.000.000',
                    'deadline' => 'Ditutup dalam 5 Hari',
                    'url' => '/project/tender',
                    'description' => 'Proyek pembangunan struktur utama Gedung Kantor Tahap 2 di area CBD Jakarta Selatan. Kontraktor terpilih bertanggung jawab penuh atas pengadaan material dan konstruksi hingga lantai 15.'
                ])
            </div>

            <!-- Project 2: Subcon HVAC -->
            <div class="card-item">
                @include('components.project-card', [
                    'type' => 'subcon',
                    'typeLabel' => 'Sub-Pekerjaan (MEP)',
                    'title' => 'Instalasi Pipa HVAC Lantai 1-5',
                    'company' => 'PT Waskita Karya (Persero) Tbk',
                    'companyUrl' => '/vendor/waskita',
                    'location' => 'Surabaya, Jawa Timur',
                    'category' => 'Infrastruktur & MEP',
                    'valueLabel' => 'Estimasi Nilai Sub-kon',
                    'value' => '± Rp 1.200.000.000',
                    'deadline' => 'Batas Waktu: 30 Hari',
                    'url' => '/project/subcon',
                    'description' => 'Dibutuhkan sub-kontraktor spesialis instalasi jaringan pipa HVAC pada proyek rumah sakit umum daerah di Surabaya. Volume pekerjaan mencapai 4.500 m².'
                ])
            </div>

            <!-- Project 3: KSO BOT Danau Toba -->
            <div class="card-item">
                @include('components.project-card', [
                    'type' => 'kso-bot',
                    'typeLabel' => 'Kemitraan (KSO / BOT)',
                    'title' => 'Pengembangan Kawasan Ekowisata Danau Toba',
                    'company' => 'PT Nusantara Wisata',
                    'companyUrl' => '/vendor/nusantara-wisata',
                    'location' => 'Medan / Parapat, Sumatera Utara',
                    'category' => 'Pariwisata & Resort',
                    'valueLabel' => 'Valuasi Lahan & Seed Money',
                    'value' => 'Rp 15.000.000.000+',
                    'deadline' => 'Prospek Terbuka',
                    'url' => '/project/kso',
                    'description' => 'Kolaborasi Joint Venture (JV) atau skema Build-Operate-Transfer (BOT) selama 25 tahun untuk pembangunan resort bintang 4 di kawasan strategis Danau Toba dengan modal lahan 2 Hektar.'
                ])
            </div>

            <!-- Project 4: KSO Suplai Kopi Arabika -->
            <div class="card-item">
                @include('components.project-card', [
                    'type' => 'kso-supply',
                    'typeLabel' => 'Kontrak Suplai & Offtaker',
                    'title' => 'Kemitraan Suplai & Kontrak Offtaker Kopi Arabika Gayo Grade 1',
                    'company' => 'PT Agro Kopi Nusantara',
                    'companyUrl' => '/vendor/agro-kopi',
                    'location' => 'Aceh & Medan, Sumatera Utara',
                    'category' => 'Pertanian & Komoditas',
                    'valueLabel' => 'Harga Kontrak Terkunci',
                    'value' => 'Rp 85.000 / kg (Fixed)',
                    'deadline' => 'MOQ: 5 Ton / bln',
                    'url' => '/project/kso/2',
                    'description' => 'Penguncian harga (Fixed Price) selama 1 tahun untuk menjamin stabilitas pasokan bahan baku roastery atau produsen F&B. Kapasitas suplai mencapai 50 ton/bulan dari kebun binaan langsung.'
                ])
            </div>

            <!-- Project 5: KSO Eksplorasi Cold Storage -->
            <div class="card-item">
                @include('components.project-card', [
                    'type' => 'kso-explore',
                    'typeLabel' => 'Eksplorasi Skema KSO / JV',
                    'title' => 'Utilisasi Fasilitas Rantai Pendingin & Gudang Logistik Terpadu',
                    'company' => 'PT Logistik Maritim Nusantara',
                    'companyUrl' => '/vendor/logistik-maritim',
                    'location' => 'Kawasan Pelabuhan Belawan, Sumatera Utara',
                    'category' => 'Logistik & Cold Chain',
                    'valueLabel' => 'Kapasitas Siap Pakai',
                    'value' => '10.000 Pallet + 3 Ha',
                    'deadline' => 'Skema Terbuka',
                    'url' => '/project/kso/3',
                    'description' => 'Kami mengundang mitra strategis untuk mengoptimalkan kapasitas cold storage (10.000 Pallet Position) dan armada 50 truk refrigerated di kawasan pelabuhan laut Belawan. Skema terbuka dan fleksibel.'
                ])
            </div>

            <!-- Project 6: KSO Suplai Sayuran Organik (Usaha Kecil) -->
            <div class="card-item">
                @include('components.project-card', [
                    'type' => 'kso-supply',
                    'typeLabel' => 'Kontrak Suplai & Offtaker',
                    'title' => 'Kontrak Suplai & Offtaker Sayuran Organik Dataran Tinggi Karo (Fixed Price)',
                    'company' => 'Koperasi Produsen Tani Jaya Mandiri',
                    'companyUrl' => '/vendor/tani-jaya',
                    'location' => 'Berastagi, Kabupaten Karo, Sumatera Utara',
                    'category' => 'Pertanian & Komoditas',
                    'valueLabel' => 'Harga Kontrak Terkunci',
                    'value' => 'Rp 15.000 / kg (Fixed)',
                    'deadline' => 'MOQ: 10 Ton / bln',
                    'url' => '/project/kso/tani',
                    'description' => 'Mencari mitra penyuplai tetap (Offtaker) dari kalangan hotel, restoran, atau supermarket untuk serapan sayuran organik Grade A dengan harga terkunci selama 1 tahun.'
                ])
            </div>

            <!-- Project 7: KSO Bagi Hasil Smart Parking (Usaha Kecil) -->
            <div class="card-item">
                @include('components.project-card', [
                    'type' => 'kso-explore',
                    'typeLabel' => 'Eksplorasi KSO / Bagi Hasil',
                    'title' => 'Kemitraan Bagi Hasil Implementasi Smart Parking & CCTV AI di Kawasan Komersial',
                    'company' => 'CV Rekayasa Digital Nusantara',
                    'companyUrl' => '/vendor/rekayasa-digital',
                    'location' => 'Kota Medan, Sumatera Utara',
                    'category' => 'Teknologi & Smart System',
                    'valueLabel' => 'Proporsi Bagi Hasil',
                    'value' => '70 : 30 (Mitra : Pengelola)',
                    'deadline' => 'Zero CapEx',
                    'url' => '/project/kso/digital',
                    'description' => 'Menawarkan pemasangan palang parkir otomatis tiketless LPR & CCTV analitik tanpa modal awal (Zero CapEx) untuk mall, rumah sakit, dan perkantoran dengan skema Revenue Share.'
                ])
            </div>

            <!-- Project 8: KSO Suplai Katering Pabrik (Usaha Kecil) -->
            <div class="card-item">
                @include('components.project-card', [
                    'type' => 'kso-supply',
                    'typeLabel' => 'Kontrak Suplai & Keagenan',
                    'title' => 'Kontrak Suplai Katering Karyawan Pabrik & Kawasan Industri Deli Serdang',
                    'company' => 'CV Kuliner Nusantara Sejahtera',
                    'companyUrl' => '/vendor/kuliner-nusantara',
                    'location' => 'Deli Serdang & Medan, Sumatera Utara',
                    'category' => 'Industri F&B & Katering',
                    'valueLabel' => 'Harga per Porsi',
                    'value' => 'Rp 18.000 / Porsi (Fixed)',
                    'deadline' => 'MOQ: 500 Porsi / hari',
                    'url' => '/project/kso/kuliner',
                    'description' => 'Penyediaan makan siang/malam karyawan bergizi dan bersertifikat Halal MUI & ISO 22000 untuk pabrik manufaktur dan perkebunan sawit dengan termin pembayaran bulanan.'
                ])
            </div>

            <!-- Project 9: KSO Suplai Kemasan Eco-Friendly (Usaha Mikro) -->
            <div class="card-item">
                @include('components.project-card', [
                    'type' => 'kso-supply',
                    'typeLabel' => 'Kontrak Suplai & Offtaker',
                    'title' => 'Kemitraan Suplai Kardus & Kemasan Ramah Lingkungan (MOQ Fleksibel)',
                    'company' => 'UD Kreatif Kemasan Abadi',
                    'companyUrl' => '/vendor/kreatif-kemasan',
                    'location' => 'Medan Denai, Kota Medan',
                    'category' => 'Percetakan & Kemasan',
                    'valueLabel' => 'Harga Penguncian',
                    'value' => 'Rp 2.500 / Pcs (Mulai dari)',
                    'deadline' => 'MOQ: 1.000 Pcs / bln',
                    'url' => '/project/kso/kemasan',
                    'description' => 'Menawarkan kontrak suplai corrugated box dan paper bag ecofriendly custom untuk UKM kuliner dan roastery dengan gratis jasa desain layout dan penguncian harga kertas.'
                ])
            </div>

            <!-- Project 10: KSO Suplai Plastik PET Bersih (Usaha Mikro) -->
            <div class="card-item">
                @include('components.project-card', [
                    'type' => 'kso-supply',
                    'typeLabel' => 'Kontrak Offtaker & Suplai',
                    'title' => 'Kontrak Offtaker Cacahan Plastik PET Bersih Grade A (Circular Economy)',
                    'company' => 'Bank Sampah Daur Ulang Mandiri',
                    'companyUrl' => '/vendor/daur-ulang',
                    'location' => 'Medan Marelan & Belawan, Kota Medan',
                    'category' => 'Pengolahan Limbah & ESG',
                    'valueLabel' => 'Harga Kontrak Terkunci',
                    'value' => 'Rp 11.500 / kg (Fixed)',
                    'deadline' => 'Suplai: 15 Ton / bln',
                    'url' => '/project/kso/daurulang',
                    'description' => 'Mencari pabrik daur ulang atau tekstil/polyester sebagai pembeli tetap (Offtaker) cacahan botol plastik PET bersih hasil pemberdayaan 200 pemulung lokal.'
                ])
            </div>

        </div>
    </div>
</div>

<!-- JavaScript Controllers -->
<script>
    function toggleFilters() {
        const panel = document.getElementById('filter-panel');
        const btn = document.getElementById('filter-toggle-btn');
        if (panel.classList.contains('hidden')) {
            panel.classList.remove('hidden');
            btn.classList.add('bg-blue-50', 'border-blue-300', 'text-blue-700');
        } else {
            panel.classList.add('hidden');
            btn.classList.remove('bg-blue-50', 'border-blue-300', 'text-blue-700');
        }
    }

    // Live search filter across cards in active tab
    function filterCardsLive() {
        const query = document.getElementById('live-search-input').value.toLowerCase();
        const activeFeed = document.getElementById('feed-vendors').classList.contains('hidden') 
            ? document.getElementById('list-projects') 
            : document.getElementById('list-vendors');
        
        const cards = activeFeed.getElementsByClassName('card-item');
        for (let card of cards) {
            const text = card.textContent || card.innerText;
            if (text.toLowerCase().indexOf(query) > -1) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        }
    }

    function switchTab(tabName) {
        const feedVendors = document.getElementById('feed-vendors');
        const feedProjects = document.getElementById('feed-projects');
        const btnVendors = document.getElementById('tab-btn-vendors');
        const btnProjects = document.getElementById('tab-btn-projects');

        // Reset search filter when switching tabs
        document.getElementById('live-search-input').value = "";
        const allCards = document.getElementsByClassName('card-item');
        for (let card of allCards) {
            card.style.display = "";
        }

        if (tabName === 'projects') {
            feedVendors.classList.add('hidden');
            feedProjects.classList.remove('hidden');
            
            btnProjects.classList.add('bg-white', 'text-blue-700', 'shadow-sm');
            btnProjects.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-white/50');
            
            btnVendors.classList.remove('bg-white', 'text-blue-700', 'shadow-sm');
            btnVendors.classList.add('text-slate-600', 'hover:text-slate-900', 'hover:bg-white/50');

            const url = new URL(window.location);
            url.searchParams.set('tab', 'projects');
            window.history.pushState({}, '', url);
        } else {
            feedProjects.classList.add('hidden');
            feedVendors.classList.remove('hidden');
            
            btnVendors.classList.add('bg-white', 'text-blue-700', 'shadow-sm');
            btnVendors.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-white/50');
            
            btnProjects.classList.remove('bg-white', 'text-blue-700', 'shadow-sm');
            btnProjects.classList.add('text-slate-600', 'hover:text-slate-900', 'hover:bg-white/50');

            const url = new URL(window.location);
            url.searchParams.delete('tab');
            window.history.pushState({}, '', url);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        if (params.get('tab') === 'projects') {
            switchTab('projects');
        }
    });
</script>

<style>
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
