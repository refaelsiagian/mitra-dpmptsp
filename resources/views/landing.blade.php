<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Kolaborasi Investasi untuk Sumut Berkah - Hubungkan UMKM dan Usaha Besar di Sumatera Utara.">
    <title>KIS Berkah - Kolaborasi Investasi untuk Sumut Berkah</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-2.svg') }}" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <style>
        body {
            font-family: 'Cabin', sans-serif;
            background-color: #f8fafc;
        }
        
        .blob-1 {
            position: absolute;
            top: -10vh;
            left: -10vw;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }
        
        .blob-2 {
            position: absolute;
            bottom: -20vh;
            right: -10vw;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, rgba(79,70,229,0.1) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>
<body class="antialiased text-slate-800 relative overflow-x-hidden selection:bg-blue-600 selection:text-white" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
    
    <!-- Background Elements -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="blob-1"></div>
        <div class="blob-2"></div>
    </div>

    <!-- Navigation -->
    <nav :class="{'bg-white/90 backdrop-blur-md shadow-sm': scrolled, 'bg-transparent': !scrolled}" class="fixed w-full top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo-1.svg') }}" alt="KIS Berkah" class="h-10 w-auto transition-transform hover:scale-105 duration-300">
                    <div class="h-8 w-px bg-slate-300 hidden sm:block"></div>
                    <img src="{{ asset('images/logo-dpmptsp.png') }}" alt="DPMPTSP Sumut" class="h-8 w-auto hidden sm:block transition-transform hover:scale-105 duration-300">
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#fitur" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Fitur</a>
                    <a href="#cara-kerja" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Cara Kerja</a>
                </div>

                <div class="flex items-center space-x-3 sm:space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-slate-700 hover:text-blue-600 transition-colors px-3 py-2">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:text-blue-600 transition-colors px-3 py-2 hidden sm:block">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-600/30 px-5 py-2.5 rounded-full transition-all duration-300 hover:-translate-y-0.5 inline-flex items-center gap-2">
                            Daftar Sekarang
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold text-slate-900 tracking-tight mb-8 leading-[1.1] animate-[fade-in-up_0.7s_ease-out]">
                    Kolaborasi Investasi untuk <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Sumut Berkah</span>
                </h1>
                
                <p class="mt-4 text-lg sm:text-xl text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed animate-[fade-in-up_0.9s_ease-out]">
                    Platform resmi DPMPTSP Provinsi Sumatera Utara yang menghubungkan UMKM lokal dengan Usaha Besar untuk menciptakan ekosistem bisnis yang saling menguntungkan dan berkelanjutan.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4 animate-[fade-in-up_1.1s_ease-out]">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-full shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 hover:-translate-y-1 transition-all duration-300">
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-full shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 hover:-translate-y-1 transition-all duration-300">
                            Mulai Berkolaborasi
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-full shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                            Sudah Punya Akun? Masuk
                        </a>
                    @endauth
                </div>
            </div>
            
            <!-- Stats / Trust Indicators -->
            <div class="mt-20 pt-10 border-t border-slate-200/60 flex flex-wrap justify-center gap-8 sm:gap-16 text-center animate-[fade-in-up_1.3s_ease-out]">
                <div>
                    <div class="text-3xl font-black text-slate-900 mb-1">Transparan</div>
                    <div class="text-sm font-medium text-slate-500">Proses Jelas & Terpantau</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-slate-900 mb-1">Terintegrasi</div>
                    <div class="text-sm font-medium text-slate-500">Database UMKM & Usaha Besar</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-slate-900 mb-1">Terpercaya</div>
                    <div class="text-sm font-medium text-slate-500">Resmi dari DPMPTSP Sumut</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="fitur" class="py-24 bg-white relative z-10 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4">Mengapa Menggunakan KIS Berkah?</h2>
                <p class="text-lg text-slate-600">Platform ini dirancang khusus untuk memfasilitasi dan mempercepat proses kemitraan antara pelaku usaha di Sumatera Utara.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-900/5 transition-all duration-500 hover:-translate-y-2 group">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Untuk UMKM</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Tingkatkan skala bisnis Anda. Buat profil usaha, publikasikan layanan unggulan (katalog), dan temukan peluang proyek kemitraan dari perusahaan besar di wilayah Anda.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:border-indigo-200 hover:shadow-xl hover:shadow-indigo-900/5 transition-all duration-500 hover:-translate-y-2 group">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Untuk Usaha Besar</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Penuhi kewajiban kemitraan investasi dengan mudah. Terbitkan RFP (Request for Proposal), tender, atau cari langsung vendor UMKM terverifikasi di Sumatera Utara.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:border-emerald-200 hover:shadow-xl hover:shadow-emerald-900/5 transition-all duration-500 hover:-translate-y-2 group">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Ekosistem Aman</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Sistem manajemen proposal dan tender yang terstruktur. Evaluasi secara transparan, komunikasi langsung, dan bangun riwayat kemitraan yang kredibel.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- How it works Section -->
    <div id="cara-kerja" class="py-24 bg-slate-50 relative z-10 border-y border-slate-200/60 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4">Cara Kerja Platform</h2>
                <p class="text-lg text-slate-600">Langkah mudah untuk memulai kolaborasi investasi yang menguntungkan.</p>
            </div>
            
            <div class="relative max-w-5xl mx-auto">
                <!-- Connecting Line -->
                <div class="hidden md:block absolute top-8 left-0 w-full h-1 bg-slate-200 -translate-y-1/2 z-0"></div>
                
                <div class="grid md:grid-cols-4 gap-8 relative z-10">
                    <!-- Step 1 -->
                    <div class="text-center group">
                        <div class="w-16 h-16 mx-auto bg-white border-4 border-slate-100 rounded-full flex items-center justify-center text-xl font-black text-slate-400 group-hover:border-blue-200 group-hover:text-blue-600 group-hover:shadow-lg transition-all duration-300 mb-6">
                            1
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">Registrasi Akun</h4>
                        <p class="text-sm text-slate-600">Daftar sebagai UMKM atau Usaha Besar dengan melengkapi data NIB dan identitas perusahaan.</p>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="text-center group">
                        <div class="w-16 h-16 mx-auto bg-white border-4 border-slate-100 rounded-full flex items-center justify-center text-xl font-black text-slate-400 group-hover:border-blue-200 group-hover:text-blue-600 group-hover:shadow-lg transition-all duration-300 mb-6">
                            2
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">Lengkapi Profil</h4>
                        <p class="text-sm text-slate-600">Isi profil perusahaan Anda agar mudah ditemukan dan dipercaya oleh calon mitra.</p>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="text-center group">
                        <div class="w-16 h-16 mx-auto bg-white border-4 border-slate-100 rounded-full flex items-center justify-center text-xl font-black text-slate-400 group-hover:border-blue-200 group-hover:text-blue-600 group-hover:shadow-lg transition-all duration-300 mb-6">
                            3
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">Cari Peluang</h4>
                        <p class="text-sm text-slate-600">Jelajahi proyek/tender dari Usaha Besar, atau cari katalog layanan dari UMKM unggulan.</p>
                    </div>
                    
                    <!-- Step 4 -->
                    <div class="text-center group">
                        <div class="w-16 h-16 mx-auto bg-white border-4 border-slate-100 rounded-full flex items-center justify-center text-xl font-black text-slate-400 group-hover:border-blue-200 group-hover:text-blue-600 group-hover:shadow-lg transition-all duration-300 mb-6">
                            4
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">Jalin Kemitraan</h4>
                        <p class="text-sm text-slate-600">Kirim proposal, lakukan evaluasi, dan mulai proyek kolaborasi bisnis Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-24 relative z-10 overflow-hidden bg-slate-900">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40V0H40" fill="none" stroke="currentColor" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid-pattern)"/>
            </svg>
        </div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-6">Siap Mengembangkan Bisnis Anda di Sumatera Utara?</h2>
            <p class="text-xl text-slate-300 mb-10 max-w-2xl mx-auto">
                Bergabunglah dengan ratusan perusahaan lainnya dalam ekosistem kemitraan investasi yang transparan dan kredibel.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-blue-900 bg-white hover:bg-blue-50 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        Kembali ke Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-blue-900 bg-white hover:bg-blue-50 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        Daftar Gratis Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 pt-16 pb-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 mb-12">
                <div class="md:col-span-5 lg:col-span-4">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('images/logo-1.svg') }}" alt="KIS Berkah" class="h-10 w-auto">
                        <div class="h-8 w-px bg-slate-300"></div>
                        <img src="{{ asset('images/logo-dpmptsp.png') }}" alt="DPMPTSP Sumut" class="h-8 w-auto">
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">
                        Sistem Informasi Kolaborasi Investasi untuk Sumut Berkah (KIS Berkah). Platform resmi pengelolaan kemitraan UMKM dan Usaha Besar di Provinsi Sumatera Utara.
                    </p>
                </div>
                
                <div class="md:col-span-7 lg:col-span-8 grid grid-cols-2 sm:grid-cols-3 gap-8 sm:gap-12 lg:gap-20">
                    <div>
                        <h4 class="text-slate-900 font-bold mb-4">Navigasi</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-slate-500 hover:text-blue-600 transition-colors">Beranda</a></li>
                            <li><a href="#fitur" class="text-sm text-slate-500 hover:text-blue-600 transition-colors">Fitur Utama</a></li>
                            <li><a href="#cara-kerja" class="text-sm text-slate-500 hover:text-blue-600 transition-colors">Cara Kerja</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-slate-900 font-bold mb-4">Akses Platform</h4>
                        <ul class="space-y-3">
                            <li><a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-blue-600 transition-colors">Masuk</a></li>
                            <li><a href="{{ route('register') }}" class="text-sm text-slate-500 hover:text-blue-600 transition-colors">Daftar Akun Baru</a></li>
                            <li><a href="{{ route('password.request') }}" class="text-sm text-slate-500 hover:text-blue-600 transition-colors">Lupa Password</a></li>
                        </ul>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <h4 class="text-slate-900 font-bold mb-4">Kontak</h4>
                        <ul class="space-y-3 text-sm text-slate-500">
                            <li class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-1 shrink-0 text-slate-400"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <span>(061) 4521406</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-1 shrink-0 text-slate-400"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                <span class="max-w-[200px]">DPMPTSP Provinsi Sumatera Utara<br>Jl. K.H. Wahid Hasyim No.8, Medan</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-400">
                    &copy; {{ date('Y') }} DPMPTSP Provinsi Sumatera Utara. Hak Cipta Dilindungi.
                </p>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-semibold text-slate-300">KIS Berkah v1.0</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Simple Animation Styles -->
    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    
    @livewireScripts
</body>
</html>
