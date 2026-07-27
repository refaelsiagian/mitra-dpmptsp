<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Mitra DPMPTSP - Verifikasi Usaha</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
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
                    <i class="ph ph-user-circle text-2xl"></i>
                    <span class="hidden sm:block">Akun Baru</span>
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
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="jenis-usaha">Jenis Pelaku Usaha <span class="text-red-500">*</span></label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white" id="jenis-usaha">
                                    <option value="" disabled selected>Pilih Jenis Usaha...</option>
                                    <option value="perorangan">Perorangan</option>
                                    <option value="badan-usaha">Badan Usaha (PT, CV, Firma, dll)</option>
                                    <option value="koperasi">Koperasi</option>
                                    <option value="yayasan">Yayasan</option>
                                </select>
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
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama-pimpinan">Nama Lengkap <span class="text-red-500">*</span></label>
                                        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white" id="nama-pimpinan" type="text" placeholder="Sesuai KTP">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="jabatan-pimpinan">Jabatan <span class="text-red-500">*</span></label>
                                        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white" id="jabatan-pimpinan" type="text" placeholder="Contoh: Direktur Utama / Pemilik">
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
                                    
                                    <div class="relative group mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors cursor-pointer bg-white">
                                        <input id="nib-file" name="nib-file" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".pdf,.jpg,.jpeg,.png">
                                        <div class="space-y-1 text-center">
                                            <i class="ph ph-upload-simple text-3xl text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <span class="font-medium text-blue-600 group-hover:text-blue-700">Upload Dokumen NIB</span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-2">Format PDF/JPG/PNG (Max 5MB)</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- NPWP -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="npwp-number">Nomor NPWP Perusahaan <span class="text-red-500">*</span></label>
                                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 mb-3" id="npwp-number" type="text" placeholder="15 Digit Nomor NPWP">
                                    
                                    <div class="relative group mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors cursor-pointer bg-white">
                                        <input id="npwp-file" name="npwp-file" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".pdf,.jpg,.jpeg,.png">
                                        <div class="space-y-1 text-center">
                                            <i class="ph ph-upload-simple text-3xl text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <span class="font-medium text-blue-600 group-hover:text-blue-700">Upload Kartu NPWP</span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-2">Format PDF/JPG/PNG (Max 5MB)</p>
                                        </div>
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
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white">
                                            <option selected disabled>Pilih Kabupaten...</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white">
                                            <option selected disabled>Pilih Kecamatan...</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Desa/Kelurahan <span class="text-red-500">*</span></label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 bg-white">
                                            <option selected disabled>Pilih Desa...</option>
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
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600">
                                                <option selected disabled>Pilih Kabupaten...</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600">
                                                <option selected disabled>Pilih Kecamatan...</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Desa/Kelurahan <span class="text-red-500">*</span></label>
                                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600">
                                                <option selected disabled>Pilih Desa...</option>
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
                                    <input class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600" type="text" placeholder="-6.200000, 106.816666" id="coordinate-input">
                                    <button type="button" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg border border-gray-300 flex items-center gap-2 transition-colors font-medium text-sm whitespace-nowrap">
                                        <i class="ph ph-map-pin-plus"></i> Ambil Titik Maps
                                    </button>
                                </div>
                                <div class="w-full h-48 bg-gray-100 rounded-lg mt-3 flex flex-col items-center justify-center text-gray-500 border border-gray-300 relative overflow-hidden">
                                    <i class="ph ph-map text-4xl mb-2 opacity-50"></i>
                                    <span class="text-sm">Preview peta akan muncul setelah memilih koordinat</span>
                                    <!-- This div would hold the actual map preview when implemented -->
                                    <!-- <div class="absolute inset-0 bg-cover bg-center" style="..."></div> -->
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
            
            btnNext.addEventListener('click', () => {
                if (currentStep < totalSteps) {
                    // normally validate form fields here
                    
                    // If moving to step 4, populate summary
                    if (currentStep === 3) {
                        document.getElementById('summary-company-name').textContent = document.getElementById('company-name').value || '-';
                        const selectUsaha = document.getElementById('jenis-usaha');
                        document.getElementById('summary-jenis-usaha').textContent = selectUsaha.options[selectUsaha.selectedIndex]?.text || '-';
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
            
            // KBLI Multiselect Logic
            const kbliData = [
                { id: '62019', nama: 'Aktivitas Pemrograman Komputer Lainnya' },
                { id: '47411', nama: 'Perdagangan Eceran Komputer dan Perlengkapannya' },
                { id: '62029', nama: 'Aktivitas Konsultasi Komputer dan Manajemen Fasilitas Komputer Lainnya' },
                { id: '63122', nama: 'Portal Web dan/atau Platform Digital dengan Tujuan Komersial' },
                { id: '46511', nama: 'Perdagangan Besar Komputer dan Perlengkapan Komputer' },
                { id: '70209', nama: 'Aktivitas Konsultasi Manajemen Lainnya' },
                { id: '10799', nama: 'Industri Produk Makanan Lainnya' },
                { id: '56101', nama: 'Restoran dan Penyediaan Makanan Keliling' },
            ];
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
        });
    </script>
</body>
</html>
