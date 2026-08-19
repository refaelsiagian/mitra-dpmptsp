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
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
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
            
            @if(isset($company) && $company->status === 'rejected')
                <div class="mb-10 max-w-2xl mx-auto p-4 bg-amber-50 border border-amber-200 rounded-lg flex items-start gap-3">
                    <i class="ph ph-warning text-amber-500 text-xl mt-0.5"></i>
                    <div>
                        <h3 class="text-sm font-bold text-amber-800 mb-1">Data Anda Dikembalikan untuk Direvisi</h3>
                        <p class="text-sm text-amber-700">Mohon perbaiki data Anda berdasarkan catatan revisi yang ditandai dengan kotak berwarna merah muda di bawah ini, kemudian kirimkan ulang form ini.</p>
                    </div>
                </div>
            @endif
            
            @if ($errors->any())
                <div class="mb-10 max-w-2xl mx-auto p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                    <i class="ph ph-warning-circle text-red-500 text-xl mt-0.5"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-red-800 mb-1">Gagal mengirimkan data:</h3>
                        <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            
            @if (session('error'))
                <div class="mb-10 max-w-2xl mx-auto p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                    <i class="ph ph-warning-circle text-red-500 text-xl mt-0.5"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-red-800 mb-1">Terjadi Kesalahan Sistem:</h3>
                        <p class="text-sm text-red-600">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

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
                <form action="{{ route('verify.store') }}" method="POST" id="verify-form" enctype="multipart/form-data" novalidate>
                    @csrf
                    <!-- STEP 1: Profil Usaha -->
                            @include('verify.partials.step1')
                            @include('verify.partials.step2')
                            @include('verify.partials.step3')
                            @include('verify.partials.step4')
                            @include('verify.partials.scripts')
    <x-toast />
</body>
</html>