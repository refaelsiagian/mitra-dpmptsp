<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Mitra DPMPTSP - Verifikasi Usaha</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
</head>
<body class="font-sans text-text bg-surface-muted antialiased min-h-screen flex flex-col">

    <!-- Top Navigation -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center text-white font-bold">M</div>
                    <span class="font-bold text-xl text-blue-600 hidden sm:block">Mitra DPMPTSP</span>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Verifikasi Data Perusahaan</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 hover:text-red-600 transition-colors">
                            <i class="ph ph-sign-out text-2xl"></i>
                            <span class="hidden sm:block font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow py-8 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Lengkapi Data Usaha</h1>
                <p class="text-gray-500">Mohon isi data berikut dengan benar untuk keperluan verifikasi DPMPTSP.</p>
            </div>

            <!-- Progress Bar -->
            <div class="mb-10 max-w-2xl mx-auto">
                <div class="flex items-center justify-between relative">
                    <!-- Progress Line -->
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-gray-200 z-0 rounded"></div>
                    <div id="progress-line" class="absolute left-0 top-1/2 -translate-y-1/2 w-0 h-1 bg-blue-600 z-0 rounded transition-all duration-500 ease-in-out"></div>
                    
                    <!-- Step 1 Indicator -->
                    <div class="relative z-10 flex flex-col items-center">
                        <div id="indicator-1" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-md border-4 border-blue-100 transition-all duration-300">1</div>
                        <span class="text-xs font-bold mt-2 text-blue-700" id="label-1">Profil Usaha</span>
                    </div>
                    
                    <!-- Step 2 Indicator -->
                    <div class="relative z-10 flex flex-col items-center">
                        <div id="indicator-2" class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-bold shadow-sm border-4 border-white transition-all duration-300">2</div>
                        <span class="text-xs font-medium mt-2 text-gray-400" id="label-2">Legalitas</span>
                    </div>
                    
                    <!-- Step 3 Indicator -->
                    <div class="relative z-10 flex flex-col items-center">
                        <div id="indicator-3" class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-bold shadow-sm border-4 border-white transition-all duration-300">3</div>
                        <span class="text-xs font-medium mt-2 text-gray-400" id="label-3">Lokasi</span>
                    </div>
                    
                    <!-- Step 4 Indicator -->
                    <div class="relative z-10 flex flex-col items-center">
                        <div id="indicator-4" class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-bold shadow-sm border-4 border-white transition-all duration-300">4</div>
                        <span class="text-xs font-medium mt-2 text-gray-400" id="label-4">Konfirmasi</span>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <form action="/review" method="GET" id="verify-form" enctype="multipart/form-data">
                    
                    <!-- STEP 1: Profil Usaha -->
                    <div id="step-1" class="p-6 sm:p-10 step-section">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="ph ph-buildings text-blue-600 text-3xl"></i> Profil Usaha
                        </h2>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="company-name">Nama Perusahaan / Usaha <span class="text-red-500">*</span></label>
                                <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors" id="company-name" type="text" placeholder="Contoh: PT Maju Bersama">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="pelaku-usaha">Pelaku Usaha <span class="text-red-500">*</span></label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white" id="pelaku-usaha">
                                    <option value="" disabled selected>Pilih Pelaku Usaha...</option>
                                    <option value="orang-perseorangan">Orang Perseorangan</option>
                                    <option value="badan-usaha">Badan Usaha</option>
                                    <option value="kantor-perwakilan">Kantor Perwakilan</option>
                                    <option value="badan-usaha-luar-negeri">Badan Usaha Luar Negeri</option>
                                </select>
                            </div>
                            
                            <div id="sub-pelaku-usaha-container" class="hidden">
                                <div id="container-nik" class="hidden mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="nik-perseorangan">NIK <span class="text-red-500">*</span></label>
                                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors" id="nik-perseorangan" type="text" placeholder="Masukkan 16 digit NIK">
                                </div>
                                <div id="container-badan-usaha" class="hidden mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis-badan-usaha">Jenis Badan Usaha <span class="text-red-500">*</span></label>
                                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white" id="jenis-badan-usaha">
                                        <option value="" disabled selected>Pilih Jenis Badan Usaha...</option>
                                        <option value="Perseroan Terbatas (PT)">Perseroan Terbatas (PT)</option>
                                        <option value="Perseroan Terbatas (PT) Perorangan">Perseroan Terbatas (PT) Perorangan</option>
                                        <option value="Persekutuan Komanditer (CV / Commanditaire Vennootschap)">Persekutuan Komanditer (CV / Commanditaire Vennootschap)</option>
                                        <option value="Persekutuan Firma (FA / Venootschap Onder Firma)">Persekutuan Firma (FA / Venootschap Onder Firma)</option>
                                        <option value="Persekutuan Perdata">Persekutuan Perdata</option>
                                        <option value="Perusahaan Umum (Perum)">Perusahaan Umum (Perum)</option>
                                        <option value="Perusahaan Umum Daerah (Perumda)">Perusahaan Umum Daerah (Perumda)</option>
                                        <option value="Badan Hukum Lainnya">Badan Hukum Lainnya</option>
                                        <option value="Koperasi">Koperasi</option>
                                        <option value="Persekutuan dan Perkumpulan">Persekutuan dan Perkumpulan</option>
                                        <option value="Yayasan">Yayasan</option>
                                        <option value="Badan Layanan Umum">Badan Layanan Umum</option>
                                        <option value="BUM Desa">BUM Desa</option>
                                        <option value="BUM Desa Bersama">BUM Desa Bersama</option>
                                        <option value="Bentuk Usaha Tetap (BUT)">Bentuk Usaha Tetap (BUT)</option>
                                    </select>
                                </div>
                                <div id="container-kantor-perwakilan" class="hidden mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis-kantor-perwakilan">Jenis Kantor Perwakilan <span class="text-red-500">*</span></label>
                                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white" id="jenis-kantor-perwakilan">
                                        <option value="" disabled selected>Pilih Jenis Kantor Perwakilan...</option>
                                        <option value="KPPA">KPPA</option>
                                        <option value="KPJPTLA">KPJPTLA</option>
                                        <option value="KP3A">KP3A</option>
                                        <option value="KP3A PMSE">KP3A PMSE</option>
                                        <option value="BUJKA">BUJKA</option>
                                    </select>
                                </div>
                                <div id="container-badan-usaha-luar-negeri" class="hidden mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis-badan-usaha-luar-negeri">Jenis Badan Usaha Luar Negeri <span class="text-red-500">*</span></label>
                                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white" id="jenis-badan-usaha-luar-negeri">
                                        <option value="" disabled selected>Pilih Jenis Badan Usaha Luar Negeri...</option>
                                        <option value="Pemberi Waralaba (STPW)">Pemberi Waralaba (STPW)</option>
                                        <option value="Pedagang Berjangka Asing">Pedagang Berjangka Asing</option>
                                        <option value="PSE Asing">PSE Asing</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode KBLI (Klasifikasi Baku Lapangan Usaha Indonesia) <span class="text-red-500">*</span></label>
                                
                                <div id="kbli-container" class="flex flex-wrap items-center gap-2 w-full p-2 border border-gray-300 rounded-lg bg-white focus-within:ring-2 focus-within:ring-blue-600 focus-within:border-blue-600 transition-colors min-h-[42px] cursor-text">
                                    <div id="kbli-chips" class="flex flex-wrap gap-1.5 items-center"></div>
                                    <input type="text" id="kbli-search" class="flex-grow min-w-[150px] outline-none text-sm bg-transparent py-0.5" placeholder="Cari kode atau nama KBLI...">
                                </div>
                                
                                <div id="kbli-dropdown" class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl hidden max-h-56 overflow-y-auto">
                                    <ul id="kbli-list" class="py-1 text-sm text-gray-700">
                                        <!-- JS will populate this -->
                                    </ul>
                                </div>
                                
                                <p class="text-xs text-gray-500 mt-1.5"><i class="ph ph-info mr-1"></i>Anda dapat memilih lebih dari satu KBLI.</p>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: Legalitas & Pimpinan -->
                    <div id="step-2" class="p-6 sm:p-10 step-section hidden">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="ph ph-file-text text-blue-600 text-3xl"></i> Legalitas & Pimpinan
                        </h2>
                        
                        <div class="space-y-8">
                            <!-- Pimpinan Section -->
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2"><i class="ph ph-user-circle text-xl text-gray-500"></i> Informasi Penanggung Jawab</h3>
                                
                                <!-- WNI/WNA Radio for Kantor Perwakilan / BULN -->
                                <div id="container-kewarganegaraan-radio" class="mb-4 hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kewarganegaraan Penanggung Jawab <span class="text-red-500">*</span></label>
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="kewarganegaraan" value="WNI" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                                            <span class="text-sm text-gray-700">WNI (Warga Negara Indonesia)</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="kewarganegaraan" value="WNA" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="text-sm text-gray-700">WNA (Warga Negara Asing)</span>
                                        </label>
                                    </div>
                                </div>

                                <div id="pimpinan-grid" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama-pimpinan">Nama Lengkap <span class="text-red-500">*</span></label>
                                        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white" id="nama-pimpinan" type="text" placeholder="Sesuai KTP / Paspor">
                                    </div>
                                    <div id="container-jabatan">
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="jabatan-pimpinan">Jabatan <span class="text-red-500">*</span></label>
                                        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white" id="jabatan-pimpinan" type="text" placeholder="Contoh: Direktur Utama / Pemilik">
                                    </div>
                                    <div id="container-nik-pimpinan" class="hidden">
                                        <label class="block text-sm font-medium text-gray-700 mb-1" id="label-nik-pimpinan" for="nik-pimpinan">NIK <span class="text-red-500">*</span></label>
                                        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white" id="nik-pimpinan" type="text" placeholder="16 Digit NIK">
                                    </div>
                                    <div id="container-nationality" class="hidden">
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nationality-pimpinan">Kewarganegaraan (Nationality) <span class="text-red-500">*</span></label>
                                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white" id="nationality-pimpinan">
                                            <option value="" disabled selected>Pilih Negara...</option>
                                            <option value="Malaysia">Malaysia</option>
                                            <option value="Singapura">Singapura</option>
                                            <option value="Jepang">Jepang</option>
                                            <option value="Korea Selatan">Korea Selatan</option>
                                            <option value="Amerika Serikat">Amerika Serikat</option>
                                            <option value="Tiongkok">Tiongkok</option>
                                            <option value="Inggris">Inggris</option>
                                            <option value="Lainnya">Lainnya...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Dokumen Section -->
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2"><i class="ph ph-certificate text-xl text-gray-500"></i> Informasi Legalitas</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- NIB -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="nib-number">Nomor Induk Berusaha (NIB) <span class="text-red-500">*</span></label>
                                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 mb-3" id="nib-number" type="text" placeholder="13 Digit Nomor NIB">
                                    
                                    <div class="mt-1 relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="ph ph-link text-gray-400 text-lg"></i>
                                        </div>
                                        <input type="url" id="nib-link" name="nib-link" class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white transition-colors text-sm" placeholder="Link Google Drive Dokumen NIB">
                                    </div>
                                </div>
                                
                                <!-- NPWP -->
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-sm font-medium text-gray-700" for="npwp-number">Nomor NPWP <span id="label-npwp-perusahaan">Perusahaan </span><span class="text-red-500">*</span></label>
                                        <div id="container-sama-dengan-nik" class="hidden flex items-center">
                                            <input id="sama-dengan-nik" type="checkbox" class="ml-1 h-3 w-3 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                                            <label for="sama-dengan-nik" class="ml-2 block text-xs font-medium text-gray-700 cursor-pointer select-none">
                                                Sama dengan NIK
                                            </label>
                                        </div>
                                    </div>
                                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 mb-3" id="npwp-number" type="text" placeholder="15 Digit Nomor NPWP">
                                    
                                    <div class="mt-1 relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="ph ph-link text-gray-400 text-lg"></i>
                                        </div>
                                        <input type="url" id="npwp-link" name="npwp-link" class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white transition-colors text-sm" placeholder="Link Google Drive Kartu NPWP">
                                    </div>
                                </div>
                            </div>
                            </div>

                        </div>
                    </div>

                    <!-- STEP 3: Lokasi -->
                    <div id="step-3" class="p-6 sm:p-10 step-section hidden">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="ph ph-map-pin text-blue-600 text-3xl"></i> Informasi Lokasi
                        </h2>
                        
                        <div class="space-y-8">
                            <!-- Kantor Utama -->
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2"><i class="ph ph-office-chair text-xl text-gray-500"></i> Alamat Kantor Utama</h3>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Provinsi <span class="text-red-500">*</span></label>
                                        <select id="provinsi-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadRegencies(this.value, 'kabupaten-kantor')">
                                            <option selected disabled value="">Pilih Provinsi...</option>
                                            @foreach($provinces as $prov)
                                                <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                        <select id="kabupaten-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadDistricts(this.value, 'kecamatan-kantor')" disabled>
                                            <option selected disabled value="">Pilih Kabupaten...</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                                        <select id="kecamatan-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadVillages(this.value, 'desa-kantor')" disabled>
                                            <option selected disabled value="">Pilih Kecamatan...</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Desa/Kelurahan <span class="text-red-500">*</span></label>
                                        <select id="desa-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" disabled>
                                            <option selected disabled value="">Pilih Desa...</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                                    <textarea id="alamat-kantor" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" rows="2" placeholder="Detail alamat (Jalan, RT/RW, Gedung, Patokan)"></textarea>
                                </div>
                            </div>

                            <!-- Lokasi Usaha -->
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2"><i class="ph ph-storefront text-xl text-gray-500"></i> Lokasi Usaha/Proyek</h3>
                                <div class="flex items-center mb-4">
                                    <input id="same-as-office" type="checkbox" class="ml-1 h-3 w-3 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                                    <label for="same-as-office" class="ml-2 block text-sm font-medium text-gray-700 cursor-pointer select-none">
                                        Sama dengan kantor utama
                                    </label>
                                </div>
                                
                                <div id="usaha-location-fields" class="transition-opacity duration-300">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Provinsi <span class="text-red-500">*</span></label>
                                            <select id="provinsi-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadRegencies(this.value, 'kabupaten-usaha')">
                                                <option selected disabled value="">Pilih Provinsi...</option>
                                                @foreach($provinces as $prov)
                                                    <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                            <select id="kabupaten-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadDistricts(this.value, 'kecamatan-usaha')" disabled>
                                                <option selected disabled value="">Pilih Kabupaten...</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                                            <select id="kecamatan-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" onchange="loadVillages(this.value, 'desa-usaha')" disabled>
                                                <option selected disabled value="">Pilih Kecamatan...</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Desa/Kelurahan <span class="text-red-500">*</span></label>
                                            <select id="desa-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" disabled>
                                                <option selected disabled value="">Pilih Desa...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Alamat Lengkap Usaha <span class="text-red-500">*</span></label>
                                        <textarea id="alamat-usaha" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white" rows="2" placeholder="Detail alamat usaha/proyek"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Google Maps Coordinate -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Koordinat Maps Lokasi Usaha <span class="text-red-500">*</span></label>
                                <div class="flex gap-2">
                                    <input class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 bg-white" type="text" placeholder="-6.200000, 106.816666" id="coordinate-input">
                                    <button type="button" id="btn-open-map" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg border border-gray-300 flex items-center gap-2 transition-colors font-medium text-sm whitespace-nowrap">
                                        <i class="ph ph-map-pin-plus"></i> Ambil Titik Maps
                                    </button>
                                </div>
                                <div id="map-preview-container" class="w-full h-48 bg-gray-100 rounded-lg mt-3 flex flex-col items-center justify-center text-gray-500 border border-gray-300 relative overflow-hidden z-0">
                                    <div id="map-preview-placeholder" class="flex flex-col items-center justify-center z-10 absolute inset-0 bg-gray-100">
                                        <i class="ph ph-map text-4xl mb-2 opacity-50"></i>
                                        <span class="text-sm">Tekan di sini atau Enter setelah tiap memasukkan koordinat untuk menampilkan preview, atau Ambil Titik Maps</span>
                                    </div>
                                    <div id="map-preview" class="w-full h-full absolute inset-0 opacity-0 z-0 transition-opacity duration-300"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- STEP 4: Konfirmasi -->
                    <div id="step-4" class="p-6 sm:p-10 step-section hidden">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2 flex items-center gap-2">
                            <i class="ph ph-check-square-offset text-blue-600 text-3xl"></i> Konfirmasi Data
                        </h2>
                        <p class="text-gray-500 mb-6 text-sm">Pastikan semua data di bawah ini sudah benar sebelum Anda menyelesaikan registrasi.</p>
                        
                        <div class="space-y-6">
                            <!-- Profil Summary -->
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                                <h3 class="font-semibold text-gray-800 mb-3 border-b border-gray-200 pb-2">Profil Usaha</h3>
                                <div class="grid grid-cols-2 gap-y-3 text-sm">
                                    <div class="text-gray-500">Nama Perusahaan</div>
                                    <div class="font-medium text-gray-900" id="summary-company-name">-</div>
                                    
                                    <div class="text-gray-500">Jenis Pelaku Usaha</div>
                                    <div class="font-medium text-gray-900" id="summary-jenis-usaha">-</div>
                                    
                                    <div class="text-gray-500">Kode KBLI</div>
                                    <div class="font-medium text-gray-900" id="summary-kode-kbli">-</div>
                                </div>
                            </div>
                            
                            <!-- Legalitas Summary -->
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                                <h3 class="font-semibold text-gray-800 mb-3 border-b border-gray-200 pb-2">Legalitas & Pimpinan</h3>
                                <div class="grid grid-cols-2 gap-y-3 text-sm">
                                    <div class="text-gray-500">Penanggung Jawab</div>
                                    <div class="font-medium text-gray-900" id="summary-pimpinan">-</div>
                                    
                                    <div class="text-gray-500">Jabatan</div>
                                    <div class="font-medium text-gray-900" id="summary-jabatan">-</div>
                                    
                                    <div class="text-gray-500">Nomor NIB</div>
                                    <div class="font-medium text-gray-900" id="summary-nib">-</div>
                                    
                                    <div class="text-gray-500">Nomor NPWP</div>
                                    <div class="font-medium text-gray-900" id="summary-npwp">-</div>
                                </div>
                            </div>
                            
                            <!-- Lokasi Summary -->
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                                <h3 class="font-semibold text-gray-800 mb-3 border-b border-gray-200 pb-2">Informasi Lokasi</h3>
                                <div class="grid grid-cols-2 gap-y-3 text-sm">
                                    <div class="text-gray-500">Alamat Kantor Utama</div>
                                    <div class="font-medium text-gray-900" id="summary-alamat-kantor">-</div>
                                    
                                    <div class="text-gray-500">Alamat Lokasi Usaha</div>
                                    <div class="font-medium text-gray-900" id="summary-alamat-usaha">-</div>
                                </div>
                            </div>
                            
                            <!-- Alert/Disclaimer -->
                            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex gap-3 text-sm text-blue-800 mt-2">
                                <i class="ph ph-info mt-0.5 text-xl"></i>
                                <div>
                                    Dengan menekan tombol <strong>Kirim Data Verifikasi</strong>, saya menyatakan bahwa seluruh data dan dokumen yang dilampirkan adalah benar dan sah sesuai dengan peraturan yang berlaku.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center rounded-b-xl">
                        <button type="button" id="btn-prev" class="hidden px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors flex items-center gap-2">
                            <i class="ph ph-arrow-left"></i> Kembali
                        </button>
                        <div class="flex-grow" id="spacer"></div>
                        <button type="button" id="btn-next" class="px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors flex items-center gap-2 ml-auto">
                            Selanjutnya <i class="ph ph-arrow-right"></i>
                        </button>
                        <button type="submit" id="btn-submit" class="hidden px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-green-600 hover:bg-green-700 transition-colors flex items-center gap-2 ml-auto">
                            <i class="ph ph-check-circle text-lg"></i> Kirim Data Verifikasi
                        </button>
                    </div>

                </form>
            </div>
            
            <div class="mt-8 text-center text-sm text-gray-500">
                &copy; 2026 DPMPTSP. Sistem Informasi Manajemen Mitra.
            </div>
            
        </div>
    </main>

    <!-- Map Picker Modal -->
    <div id="map-picker-modal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col h-[80vh] mx-4 relative z-50">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Pilih Titik Koordinat Usaha</h3>
                    <p class="text-sm text-gray-500">Geser peta atau klik pada lokasi untuk menentukan koordinat.</p>
                </div>
                <button type="button" id="btn-close-map" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class="ph ph-x text-2xl"></i>
                </button>
            </div>
            <div class="flex-grow relative bg-gray-200">
                <div id="interactive-map" class="w-full h-full absolute inset-0 z-0"></div>
                <div class="absolute top-4 right-4 z-[400] bg-white px-3 py-2 rounded-lg shadow-md border border-gray-200 text-sm font-medium flex items-center gap-2">
                    <i class="ph ph-crosshair text-blue-600"></i>
                    <span id="temp-coordinate" class="font-mono text-gray-700">-</span>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-white flex justify-end items-center gap-3">
                <button type="button" id="btn-cancel-map" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">Batal</button>
                <button type="button" id="btn-save-map" class="px-6 py-2 bg-blue-600 rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <i class="ph ph-check-circle text-lg"></i> Simpan Lokasi
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            const totalSteps = 4;
            
            const btnNext = document.getElementById('btn-next');
            const btnPrev = document.getElementById('btn-prev');
            const btnSubmit = document.getElementById('btn-submit');
            const progressLine = document.getElementById('progress-line');
            const spacer = document.getElementById('spacer');
            
            function updateUI() {
                // Update sections visibility with a tiny fade effect consideration
                document.querySelectorAll('.step-section').forEach((el, index) => {
                    if (index + 1 === currentStep) {
                        el.classList.remove('hidden');
                    } else {
                        el.classList.add('hidden');
                    }
                });
                
                // Update buttons
                if (currentStep === 1) {
                    btnPrev.classList.add('hidden');
                    spacer.classList.remove('hidden');
                } else {
                    btnPrev.classList.remove('hidden');
                    spacer.classList.add('hidden');
                }
                
                if (currentStep === totalSteps) {
                    btnNext.classList.add('hidden');
                    btnSubmit.classList.remove('hidden');
                } else {
                    btnNext.classList.remove('hidden');
                    btnSubmit.classList.add('hidden');
                }
                
                // Update Progress Bar & Indicators
                const progressWidth = ((currentStep - 1) / (totalSteps - 1)) * 100;
                progressLine.style.width = `${progressWidth}%`;
                
                for(let i = 1; i <= totalSteps; i++) {
                    const indicator = document.getElementById(`indicator-${i}`);
                    const label = document.getElementById(`label-${i}`);
                    
                    if (i < currentStep) {
                        // Completed step
                        indicator.className = "w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-md border-4 border-white transition-all duration-300";
                        indicator.innerHTML = '<i class="ph ph-check text-xl"></i>';
                        label.className = "text-xs font-semibold mt-2 text-blue-600";
                    } else if (i === currentStep) {
                        // Current step
                        indicator.className = "w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg border-4 border-blue-100 transition-all duration-300 transform scale-110";
                        indicator.innerHTML = i;
                        label.className = "text-xs font-bold mt-2 text-blue-700";
                    } else {
                        // Future step
                        indicator.className = "w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-bold shadow-sm border-4 border-white transition-all duration-300";
                        indicator.innerHTML = i;
                        label.className = "text-xs font-medium mt-2 text-gray-400";
                    }
                }
            }
            
            function validateStep(step) {
                let isValid = true;
                
                // Helper to remove all existing errors for a given step
                const stepSection = document.getElementById(`step-${step}`);
                if (!stepSection) return true;
                
                stepSection.querySelectorAll('.error-msg').forEach(el => el.remove());
                stepSection.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
                
                function showError(elementId, message, borderElementId = null) {
                    isValid = false;
                    const el = document.getElementById(borderElementId || elementId);
                    if (el) el.classList.add('border-red-500');
                    
                    const targetEl = document.getElementById(elementId);
                    if (targetEl) {
                        const p = document.createElement('p');
                        p.className = 'text-red-500 text-xs mt-1 error-msg';
                        p.textContent = message;
                        
                        if (elementId === 'nib-link' || elementId === 'npwp-link') {
                            targetEl.parentNode.parentNode.insertBefore(p, targetEl.parentNode.nextSibling);
                        } else if (elementId === 'coordinate-input') {
                            targetEl.parentNode.parentNode.insertBefore(p, targetEl.parentNode.nextSibling);
                        } else if (elementId === 'kbli-search') {
                            const kbliContainer = document.getElementById('kbli-container');
                            kbliContainer.parentNode.insertBefore(p, kbliContainer.nextSibling);
                        } else if (targetEl.nextElementSibling && targetEl.nextElementSibling.classList.contains('custom-search-wrapper')) {
                            targetEl.parentNode.insertBefore(p, targetEl.nextElementSibling.nextSibling);
                        } else {
                            targetEl.parentNode.insertBefore(p, targetEl.nextSibling);
                        }
                    }
                }
                
                if (step === 1) {
                    if (!document.getElementById('company-name').value.trim()) showError('company-name', 'Nama perusahaan wajib diisi');
                    
                    const pelakuUsaha = document.getElementById('pelaku-usaha').value;
                    if (!pelakuUsaha) {
                        showError('pelaku-usaha', 'Pilih jenis pelaku usaha');
                    } else {
                        if (pelakuUsaha === 'orang-perseorangan' && !document.getElementById('nik-perseorangan').value.trim()) {
                            showError('nik-perseorangan', 'NIK wajib diisi');
                        } else if (pelakuUsaha === 'badan-usaha' && !document.getElementById('jenis-badan-usaha').value) {
                            showError('jenis-badan-usaha', 'Pilih jenis badan usaha');
                        } else if (pelakuUsaha === 'kantor-perwakilan' && !document.getElementById('jenis-kantor-perwakilan').value) {
                            showError('jenis-kantor-perwakilan', 'Pilih jenis kantor perwakilan');
                        } else if (pelakuUsaha === 'badan-usaha-luar-negeri' && !document.getElementById('jenis-badan-usaha-luar-negeri').value) {
                            showError('jenis-badan-usaha-luar-negeri', 'Pilih jenis badan usaha luar negeri');
                        }
                    }
                    
                    if (selectedKbli.length === 0) {
                        showError('kbli-search', 'Pilih setidaknya satu kode KBLI', 'kbli-container');
                    }
                }
                else if (step === 2) {
                    const nationality = document.querySelector('input[name="kewarganegaraan"]:checked');
                    
                    if (!document.getElementById('nama-pimpinan').value.trim()) showError('nama-pimpinan', 'Nama pimpinan wajib diisi');
                    if (!document.getElementById('jabatan-pimpinan').value.trim()) showError('jabatan-pimpinan', 'Jabatan pimpinan wajib diisi');
                    
                    if (nationality && nationality.value === 'WNA') {
                        if (!document.getElementById('nik-pimpinan').value.trim()) showError('nik-pimpinan', 'Nomor paspor wajib diisi');
                        if (!document.getElementById('nationality-pimpinan').value) showError('nationality-pimpinan', 'Pilih negara kewarganegaraan');
                    } else {
                        const pimpinanContainer = document.getElementById('container-nik-pimpinan');
                        if (pimpinanContainer && !pimpinanContainer.classList.contains('hidden') && !document.getElementById('nik-pimpinan').value.trim()) {
                            showError('nik-pimpinan', 'NIK wajib diisi');
                        }
                    }
                    
                    if (!document.getElementById('nib-number').value.trim()) showError('nib-number', 'NIB wajib diisi');
                    if (!document.getElementById('nib-link').value.trim()) showError('nib-link', 'Link dokumen NIB wajib diisi');
                    
                    if (!document.getElementById('npwp-number').value.trim()) showError('npwp-number', 'NPWP wajib diisi');
                    if (!document.getElementById('npwp-link').value.trim()) showError('npwp-link', 'Link dokumen NPWP wajib diisi');
                }
                else if (step === 3) {
                    if (!document.getElementById('provinsi-kantor').value) showError('provinsi-kantor', 'Provinsi wajib dipilih');
                    if (!document.getElementById('kabupaten-kantor').value) showError('kabupaten-kantor', 'Kabupaten/Kota wajib dipilih');
                    if (!document.getElementById('kecamatan-kantor').value) showError('kecamatan-kantor', 'Kecamatan wajib dipilih');
                    if (!document.getElementById('desa-kantor').value) showError('desa-kantor', 'Desa/Kelurahan wajib dipilih');
                    if (!document.getElementById('alamat-kantor').value.trim()) showError('alamat-kantor', 'Alamat lengkap wajib diisi');
                    
                    const isSameLocation = document.getElementById('same-as-office').checked;
                    if (!isSameLocation) {
                        if (!document.getElementById('provinsi-usaha').value) showError('provinsi-usaha', 'Provinsi wajib dipilih');
                        if (!document.getElementById('kabupaten-usaha').value) showError('kabupaten-usaha', 'Kabupaten/Kota wajib dipilih');
                        if (!document.getElementById('kecamatan-usaha').value) showError('kecamatan-usaha', 'Kecamatan wajib dipilih');
                        if (!document.getElementById('desa-usaha').value) showError('desa-usaha', 'Desa/Kelurahan wajib dipilih');
                        if (!document.getElementById('alamat-usaha').value.trim()) showError('alamat-usaha', 'Alamat lengkap usaha wajib diisi');
                    }
                    
                    if (!document.getElementById('coordinate-input').value.trim()) showError('coordinate-input', 'Koordinat lokasi wajib diisi');
                }
                
                return isValid;
            }

            btnNext.addEventListener('click', () => {
                if (!validateStep(currentStep)) return;
                
                if (currentStep < totalSteps) {
                    // normally validate form fields here
                    
                    // If moving to step 4, populate summary
                    if (currentStep === 3) {
                        document.getElementById('summary-company-name').textContent = document.getElementById('company-name').value || '-';
                        const pelakuUsahaSelectEl = document.getElementById('pelaku-usaha');
                        const pelakuUsahaVal = pelakuUsahaSelectEl.value;
                        let pelakuUsahaText = pelakuUsahaSelectEl.options[pelakuUsahaSelectEl.selectedIndex]?.text || '-';
                        let detailUsahaText = '';
                        
                        if (pelakuUsahaVal === 'orang-perseorangan') {
                            detailUsahaText = ' (NIK: ' + (document.getElementById('nik-perseorangan').value || '-') + ')';
                        } else if (pelakuUsahaVal === 'badan-usaha') {
                            const detailSelect = document.getElementById('jenis-badan-usaha');
                            detailUsahaText = detailSelect.value ? (' - ' + (detailSelect.options[detailSelect.selectedIndex]?.text || '')) : '';
                        } else if (pelakuUsahaVal === 'kantor-perwakilan') {
                            const detailSelect = document.getElementById('jenis-kantor-perwakilan');
                            detailUsahaText = detailSelect.value ? (' - ' + (detailSelect.options[detailSelect.selectedIndex]?.text || '')) : '';
                        } else if (pelakuUsahaVal === 'badan-usaha-luar-negeri') {
                            const detailSelect = document.getElementById('jenis-badan-usaha-luar-negeri');
                            detailUsahaText = detailSelect.value ? (' - ' + (detailSelect.options[detailSelect.selectedIndex]?.text || '')) : '';
                        }
                        
                        document.getElementById('summary-jenis-usaha').textContent = pelakuUsahaText + detailUsahaText;
                        const kbliSummaryContainer = document.getElementById('summary-kode-kbli');
                        if (selectedKbli.length > 0) {
                            kbliSummaryContainer.innerHTML = selectedKbli.map(k => `<div class="mb-1 leading-tight"><span class="font-semibold">${k.id}</span> - <span class="text-xs text-gray-500 block">${k.nama}</span></div>`).join('');
                        } else {
                            kbliSummaryContainer.textContent = '-';
                        }
                        
                        document.getElementById('summary-pimpinan').textContent = document.getElementById('nama-pimpinan').value || '-';
                        document.getElementById('summary-jabatan').textContent = document.getElementById('jabatan-pimpinan').value || '-';
                        document.getElementById('summary-nib').textContent = document.getElementById('nib-number').value || '-';
                        document.getElementById('summary-npwp').textContent = document.getElementById('npwp-number').value || '-';
                        
                        document.getElementById('summary-alamat-kantor').textContent = document.getElementById('alamat-kantor').value || '-';
                        
                        // Check if same location checkbox is checked
                        const isSame = document.getElementById('same-as-office')?.checked;
                        document.getElementById('summary-alamat-usaha').textContent = isSame ? 
                            (document.getElementById('alamat-kantor').value || '-') : 
                            (document.getElementById('alamat-usaha').value || '-');
                    }
                    
                    currentStep++;
                    updateUI();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
            
            btnPrev.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep--;
                    updateUI();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
            
            // Checkbox logic for same location
            const sameAsOffice = document.getElementById('same-as-office');
            const usahaFields = document.getElementById('usaha-location-fields');
            
            if(sameAsOffice) {
                sameAsOffice.addEventListener('change', function() {
                    if(this.checked) {
                        usahaFields.classList.add('opacity-40', 'pointer-events-none', 'grayscale');
                        // Optional: Clear values or copy values from primary office fields
                    } else {
                        usahaFields.classList.remove('opacity-40', 'pointer-events-none', 'grayscale');
                    }
                });
            }
            
            // Pelaku Usaha Logic
            const pelakuUsahaSelect = document.getElementById('pelaku-usaha');
            const subPelakuUsahaContainer = document.getElementById('sub-pelaku-usaha-container');
            const containerNik = document.getElementById('container-nik');
            const containerBadanUsaha = document.getElementById('container-badan-usaha');
            const containerKantorPerwakilan = document.getElementById('container-kantor-perwakilan');
            const containerBadanUsahaLuarNegeri = document.getElementById('container-badan-usaha-luar-negeri');
            const pimpinanGrid = document.getElementById('pimpinan-grid');
            const containerJabatan = document.getElementById('container-jabatan');
            const containerSamaDenganNik = document.getElementById('container-sama-dengan-nik');
            const labelNpwpPerusahaan = document.getElementById('label-npwp-perusahaan');
            
            // New UI Elements
            const containerKewarganegaraanRadio = document.getElementById('container-kewarganegaraan-radio');
            const containerNikPimpinan = document.getElementById('container-nik-pimpinan');
            const wniRadio = document.querySelector('input[name="kewarganegaraan"][value="WNI"]');
            
            // Kewarganegaraan Logic
            const kewarganegaraanRadios = document.querySelectorAll('input[name="kewarganegaraan"]');
            const labelNikPimpinan = document.getElementById('label-nik-pimpinan');
            const inputNikPimpinan = document.getElementById('nik-pimpinan');
            const containerNationality = document.getElementById('container-nationality');

            function triggerKewarganegaraanChange() {
                const selected = document.querySelector('input[name="kewarganegaraan"]:checked');
                if (!selected) return;
                
                if (selected.value === 'WNA') {
                    if (labelNikPimpinan) labelNikPimpinan.innerHTML = 'Nomor Paspor / Passport <span class="text-red-500">*</span>';
                    if (inputNikPimpinan) inputNikPimpinan.placeholder = 'Nomor Paspor / Passport Number';
                    if (containerNationality) containerNationality.classList.remove('hidden');
                } else {
                    if (labelNikPimpinan) labelNikPimpinan.innerHTML = 'NIK <span class="text-red-500">*</span>';
                    if (inputNikPimpinan) inputNikPimpinan.placeholder = '16 Digit NIK';
                    if (containerNationality) containerNationality.classList.add('hidden');
                }
            }

            if (kewarganegaraanRadios) {
                kewarganegaraanRadios.forEach(radio => {
                    radio.addEventListener('change', triggerKewarganegaraanChange);
                });
            }

            if (pelakuUsahaSelect) {
                pelakuUsahaSelect.addEventListener('change', function() {
                    const val = this.value;
                    
                    subPelakuUsahaContainer.classList.remove('hidden');
                    containerNik.classList.add('hidden');
                    containerBadanUsaha.classList.add('hidden');
                    containerKantorPerwakilan.classList.add('hidden');
                    containerBadanUsahaLuarNegeri.classList.add('hidden');
                    
                    // Reset step 2 fields
                    if (containerJabatan) containerJabatan.classList.remove('hidden');
                    if (pimpinanGrid) pimpinanGrid.classList.add('md:grid-cols-2');
                    if (containerSamaDenganNik) containerSamaDenganNik.classList.add('hidden');
                    if (labelNpwpPerusahaan) labelNpwpPerusahaan.style.display = 'inline';
                    
                    // Reset New UI Elements
                    if (containerKewarganegaraanRadio) containerKewarganegaraanRadio.classList.add('hidden');
                    if (containerNikPimpinan) containerNikPimpinan.classList.add('hidden');
                    if (wniRadio) wniRadio.checked = true;
                    triggerKewarganegaraanChange();
                    
                    if (val === 'orang-perseorangan') {
                        containerNik.classList.remove('hidden');
                        if (containerJabatan) containerJabatan.classList.add('hidden');
                        if (pimpinanGrid) pimpinanGrid.classList.remove('md:grid-cols-2');
                        if (containerSamaDenganNik) containerSamaDenganNik.classList.remove('hidden');
                        if (labelNpwpPerusahaan) labelNpwpPerusahaan.style.display = 'none';
                    } else {
                        // All non-perseorangan have NIK pimpinan
                        if (containerNikPimpinan) containerNikPimpinan.classList.remove('hidden');

                        if (val === 'badan-usaha') {
                            containerBadanUsaha.classList.remove('hidden');
                        } else if (val === 'kantor-perwakilan') {
                            containerKantorPerwakilan.classList.remove('hidden');
                            if (containerKewarganegaraanRadio) containerKewarganegaraanRadio.classList.remove('hidden');
                        } else if (val === 'badan-usaha-luar-negeri') {
                            containerBadanUsahaLuarNegeri.classList.remove('hidden');
                            if (containerKewarganegaraanRadio) containerKewarganegaraanRadio.classList.remove('hidden');
                        }
                    }
                });
            }
            
            // Sama dengan NIK Logic
            const samaDenganNik = document.getElementById('sama-dengan-nik');
            const nikInput = document.getElementById('nik-perseorangan');
            const npwpInput = document.getElementById('npwp-number');

            if (samaDenganNik && nikInput && npwpInput) {
                samaDenganNik.addEventListener('change', function() {
                    if (this.checked) {
                        npwpInput.value = nikInput.value;
                        npwpInput.readOnly = true;
                        npwpInput.classList.add('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
                    } else {
                        npwpInput.value = '';
                        npwpInput.readOnly = false;
                        npwpInput.classList.remove('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
                    }
                });
                
                nikInput.addEventListener('input', function() {
                    if (samaDenganNik.checked) {
                        npwpInput.value = this.value;
                    }
                });
            }

            // Custom Searchable Dropdown Logic
            function makeSearchable(selectId) {
                const select = document.getElementById(selectId);
                if (!select) return;

                select.style.display = 'none';

                const existingWrapper = select.parentNode.querySelector('.custom-search-wrapper');
                if (existingWrapper) {
                    existingWrapper.remove();
                }

                const wrapper = document.createElement('div');
                wrapper.className = 'relative custom-search-wrapper w-full';
                
                const getSelectedText = () => {
                    const opt = select.options[select.selectedIndex];
                    return opt ? opt.text : 'Pilih...';
                };

                const isDisabled = select.disabled;

                wrapper.innerHTML = `
                    <div class="search-select-trigger flex items-center justify-between w-full px-3 py-2 border border-gray-300 rounded-md text-sm transition-colors ${isDisabled ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-white cursor-pointer hover:border-blue-400'}">
                        <span class="truncate display-text">${getSelectedText()}</span>
                        <i class="ph ph-caret-down text-gray-400"></i>
                    </div>
                    <div class="search-select-dropdown absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-xl hidden flex flex-col">
                        <div class="p-2 border-b border-gray-100 sticky top-0 bg-white z-10">
                            <div class="relative">
                                <i class="ph ph-magnifying-glass absolute left-2 top-2 text-gray-400"></i>
                                <input type="text" class="w-full text-sm outline-none pl-7 pr-2 py-1.5 bg-gray-50 rounded border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 search-input" placeholder="Cari...">
                            </div>
                        </div>
                        <ul class="py-1 text-sm text-gray-700 max-h-48 overflow-y-auto option-list">
                        </ul>
                    </div>
                `;

                select.parentNode.insertBefore(wrapper, select.nextSibling);

                const trigger = wrapper.querySelector('.search-select-trigger');
                const dropdown = wrapper.querySelector('.search-select-dropdown');
                const searchInput = wrapper.querySelector('.search-input');
                const optionList = wrapper.querySelector('.option-list');
                const displayText = wrapper.querySelector('.display-text');

                function renderOptions(filter = '') {
                    optionList.innerHTML = '';
                    const lowerFilter = filter.toLowerCase();
                    let hasOptions = false;

                    Array.from(select.options).forEach((opt, index) => {
                        if (opt.disabled || opt.value === '') return;

                        if (opt.text.toLowerCase().includes(lowerFilter)) {
                            hasOptions = true;
                            const li = document.createElement('li');
                            li.className = 'px-3 py-2 hover:bg-blue-50 cursor-pointer transition-colors';
                            if (select.selectedIndex === index) {
                                li.className += ' bg-blue-100 text-blue-700 font-medium';
                            }
                            li.textContent = opt.text;
                            li.addEventListener('mousedown', (e) => {
                                e.preventDefault(); // prevent input blur
                                select.selectedIndex = index;
                                displayText.textContent = opt.text;
                                closeDropdown();
                                select.dispatchEvent(new Event('change'));
                            });
                            optionList.appendChild(li);
                        }
                    });

                    if (!hasOptions) {
                        optionList.innerHTML = '<li class="px-3 py-2 text-gray-400 italic text-center">Tidak ditemukan</li>';
                    }
                }

                function openDropdown() {
                    if (select.disabled) return;
                    dropdown.classList.remove('hidden');
                    renderOptions();
                    searchInput.value = '';
                    setTimeout(() => searchInput.focus(), 10);
                }

                function closeDropdown() {
                    dropdown.classList.add('hidden');
                }

                trigger.addEventListener('click', (e) => {
                    if (dropdown.classList.contains('hidden')) {
                        document.querySelectorAll('.search-select-dropdown:not(.hidden)').forEach(d => d.classList.add('hidden'));
                        openDropdown();
                    } else {
                        closeDropdown();
                    }
                });

                searchInput.addEventListener('input', (e) => {
                    renderOptions(e.target.value);
                });

                document.addEventListener('mousedown', (e) => {
                    if (!wrapper.contains(e.target)) {
                        closeDropdown();
                    }
                });
            }

            // Region Cascading Logic
            const selectIds = [
                'provinsi-kantor', 'kabupaten-kantor', 'kecamatan-kantor', 'desa-kantor',
                'provinsi-usaha', 'kabupaten-usaha', 'kecamatan-usaha', 'desa-usaha'
            ];
            
            // Initialize on load
            selectIds.forEach(id => makeSearchable(id));

            function updateDropdown(id, html, disabled) {
                const el = document.getElementById(id);
                el.innerHTML = html;
                el.disabled = disabled;
                makeSearchable(id);
            }

            window.loadRegencies = async function(provinceId, targetSelectId) {
                updateDropdown(targetSelectId, '<option selected disabled value="">Loading...</option>', true);
                
                let isKantor = targetSelectId.includes('kantor');
                updateDropdown(isKantor ? 'kecamatan-kantor' : 'kecamatan-usaha', '<option selected disabled value="">Pilih Kecamatan...</option>', true);
                updateDropdown(isKantor ? 'desa-kantor' : 'desa-usaha', '<option selected disabled value="">Pilih Desa...</option>', true);
                
                const response = await fetch(`/api/regencies/${provinceId}`);
                const data = await response.json();
                
                let html = '<option selected disabled value="">Pilih Kabupaten...</option>';
                data.forEach(item => html += `<option value="${item.id}">${item.name}</option>`);
                updateDropdown(targetSelectId, html, false);
            };

            window.loadDistricts = async function(regencyId, targetSelectId) {
                updateDropdown(targetSelectId, '<option selected disabled value="">Loading...</option>', true);
                
                let isKantor = targetSelectId.includes('kantor');
                updateDropdown(isKantor ? 'desa-kantor' : 'desa-usaha', '<option selected disabled value="">Pilih Desa...</option>', true);
                
                const response = await fetch(`/api/districts/${regencyId}`);
                const data = await response.json();
                
                let html = '<option selected disabled value="">Pilih Kecamatan...</option>';
                data.forEach(item => html += `<option value="${item.id}">${item.name}</option>`);
                updateDropdown(targetSelectId, html, false);
            };

            window.loadVillages = async function(districtId, targetSelectId) {
                updateDropdown(targetSelectId, '<option selected disabled value="">Loading...</option>', true);
                
                const response = await fetch(`/api/villages/${districtId}`);
                const data = await response.json();
                
                let html = '<option selected disabled value="">Pilih Desa...</option>';
                data.forEach(item => html += `<option value="${item.id}">${item.name}</option>`);
                updateDropdown(targetSelectId, html, false);
            };

            // KBLI Multiselect Logic
            const kbliData = @json($kblis->map(function($kbli) {
                return ['id' => $kbli->code, 'nama' => $kbli->name];
            }));
            let selectedKbli = [];
            
            const kbliContainer = document.getElementById('kbli-container');
            const kbliSearch = document.getElementById('kbli-search');
            const kbliDropdown = document.getElementById('kbli-dropdown');
            const kbliList = document.getElementById('kbli-list');
            const kbliChips = document.getElementById('kbli-chips');
            
            function renderKbliChips() {
                kbliChips.innerHTML = '';
                selectedKbli.forEach(item => {
                    const chip = document.createElement('div');
                    chip.className = 'flex items-center gap-1 bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium border border-blue-200';
                    chip.innerHTML = `
                        <span>${item.id}</span>
                        <button type="button" class="text-blue-600 hover:text-blue-900 focus:outline-none" onclick="window.removeKbli('${item.id}')">
                            <i class="ph ph-x"></i>
                        </button>
                    `;
                    kbliChips.appendChild(chip);
                });
            }
            
            window.removeKbli = function(id) {
                selectedKbli = selectedKbli.filter(item => item.id !== id);
                renderKbliChips();
                renderKbliDropdown();
            };
            
            function renderKbliDropdown(filter = '') {
                kbliList.innerHTML = '';
                const lowerFilter = filter.toLowerCase();
                const filtered = kbliData.filter(item => 
                    (item.id.toLowerCase().includes(lowerFilter) || item.nama.toLowerCase().includes(lowerFilter)) &&
                    !selectedKbli.some(selected => selected.id === item.id)
                );
                
                if (filtered.length === 0) {
                    kbliList.innerHTML = '<li class="px-4 py-2 text-gray-500 italic">Tidak ada hasil ditemukan</li>';
                    return;
                }
                
                filtered.forEach(item => {
                    const li = document.createElement('li');
                    li.className = 'px-4 py-2 hover:bg-blue-50 cursor-pointer flex flex-col border-b border-gray-100 last:border-0';
                    li.innerHTML = `
                        <span class="font-semibold text-blue-700">${item.id}</span>
                        <span class="text-xs text-gray-600">${item.nama}</span>
                    `;
                    li.addEventListener('mousedown', (e) => {
                        e.preventDefault(); // prevent input blur
                        selectedKbli.push(item);
                        renderKbliChips();
                        kbliSearch.value = '';
                        renderKbliDropdown();
                        kbliSearch.focus();
                    });
                    kbliList.appendChild(li);
                });
            }
            
            // Show dropdown on focus or click
            if(kbliSearch) {
                kbliSearch.addEventListener('focus', () => {
                    kbliDropdown.classList.remove('hidden');
                    renderKbliDropdown(kbliSearch.value);
                });
                kbliContainer.addEventListener('click', () => {
                    kbliSearch.focus();
                });
                
                // Filter on input
                kbliSearch.addEventListener('input', (e) => {
                    kbliDropdown.classList.remove('hidden');
                    renderKbliDropdown(e.target.value);
                });
                
                // Hide dropdown on blur
                kbliSearch.addEventListener('blur', () => {
                    kbliDropdown.classList.add('hidden');
                });
            }
            
            // Map Implementation Logic
            let interactiveMap = null;
            let previewMap = null;
            let marker = null;
            let previewMarker = null;
            let currentLat = -0.789275; // Default center (Indonesia)
            let currentLng = 113.921327;
            
            const btnOpenMap = document.getElementById('btn-open-map');
            const mapModal = document.getElementById('map-picker-modal');
            const btnCloseMap = document.getElementById('btn-close-map');
            const btnCancelMap = document.getElementById('btn-cancel-map');
            const btnSaveMap = document.getElementById('btn-save-map');
            const tempCoordinate = document.getElementById('temp-coordinate');
            const coordinateInput = document.getElementById('coordinate-input');
            const previewPlaceholder = document.getElementById('map-preview-placeholder');
            const previewContainer = document.getElementById('map-preview');

            function initMaps() {
                // Initialize Preview Map
                previewMap = L.map('map-preview', {
                    zoomControl: false,
                    scrollWheelZoom: false,
                    doubleClickZoom: false,
                    touchZoom: false,
                    dragging: false
                }).setView([currentLat, currentLng], 5);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(previewMap);

                // Initialize Interactive Map
                interactiveMap = L.map('interactive-map').setView([currentLat, currentLng], 5);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(interactiveMap);

                // Add marker on click
                interactiveMap.on('click', function(e) {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;
                    
                    if (marker) {
                        marker.setLatLng(e.latlng);
                    } else {
                        marker = L.marker(e.latlng).addTo(interactiveMap);
                    }
                    
                    currentLat = lat;
                    currentLng = lng;
                    tempCoordinate.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                });
            }

            function openMapModal() {
                mapModal.classList.remove('hidden');
                
                // Parse existing input if available
                if(coordinateInput.value) {
                    const parts = coordinateInput.value.split(',');
                    if(parts.length === 2) {
                        currentLat = parseFloat(parts[0].trim());
                        currentLng = parseFloat(parts[1].trim());
                        tempCoordinate.textContent = `${currentLat.toFixed(6)}, ${currentLng.toFixed(6)}`;
                    }
                }

                // Leaflet requires invalidateSize when container changes visibility
                setTimeout(() => {
                    interactiveMap.invalidateSize();
                    interactiveMap.setView([currentLat, currentLng], marker ? 15 : 5);
                    if(coordinateInput.value && !marker) {
                        marker = L.marker([currentLat, currentLng]).addTo(interactiveMap);
                    } else if (marker) {
                        marker.setLatLng([currentLat, currentLng]);
                    }
                }, 100);
            }

            function closeMapModal() {
                mapModal.classList.add('hidden');
            }

            function saveCoordinates() {
                if (marker) {
                    coordinateInput.value = `${currentLat.toFixed(6)}, ${currentLng.toFixed(6)}`;
                    
                    // Safe check if summary field exists (it doesn't currently)
                    const summaryKoor = document.getElementById('summary-koordinat');
                    if (summaryKoor) {
                        summaryKoor.textContent = coordinateInput.value;
                    }
                    
                    // Update preview map
                    previewPlaceholder.style.opacity = '0';
                    setTimeout(() => previewPlaceholder.classList.add('hidden'), 300);
                    
                    previewContainer.style.opacity = '1';
                    previewMap.invalidateSize();
                    previewMap.setView([currentLat, currentLng], 15);
                    
                    if (previewMarker) {
                        previewMarker.setLatLng([currentLat, currentLng]);
                    } else {
                        previewMarker = L.marker([currentLat, currentLng]).addTo(previewMap);
                    }
                }
                closeMapModal();
            }

            // Bind Events
            if (btnOpenMap) btnOpenMap.addEventListener('click', openMapModal);
            if (btnCloseMap) btnCloseMap.addEventListener('click', closeMapModal);
            if (btnCancelMap) btnCancelMap.addEventListener('click', closeMapModal);
            if (btnSaveMap) btnSaveMap.addEventListener('click', saveCoordinates);
            
            // Allow manual input formatting
            if (coordinateInput) {
                const processManualInput = function(val) {
                    if(val) {
                        const parts = val.split(',');
                        if(parts.length === 2) {
                            currentLat = parseFloat(parts[0].trim());
                            currentLng = parseFloat(parts[1].trim());
                            if(!isNaN(currentLat) && !isNaN(currentLng)) {
                                coordinateInput.value = `${currentLat.toFixed(6)}, ${currentLng.toFixed(6)}`;
                                
                                // Create or update the real Leaflet marker
                                if (!marker) {
                                    marker = L.marker([currentLat, currentLng]).addTo(interactiveMap);
                                } else {
                                    marker.setLatLng([currentLat, currentLng]);
                                }
                                
                                saveCoordinates();
                            }
                        }
                    }
                };

                coordinateInput.addEventListener('blur', function() {
                    processManualInput(this.value);
                });

                coordinateInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault(); // Prevent form submission
                        processManualInput(this.value);
                    }
                });
            }

            // Initialize maps on load
            initMaps();
        });
    </script>
</body>
</html>
