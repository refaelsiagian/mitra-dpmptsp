<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Mitra DPMPTSP - Verifikasi Email</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #f8fafc;
            background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%232563eb" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
            background-size: 180px 180px;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="font-['Inter'] text-slate-800 antialiased min-h-screen flex flex-col items-center justify-center p-4 relative overflow-x-hidden">

    <!-- Decorative blobs -->
    <div class="fixed top-[-10%] left-[-5%] w-[40%] h-[40%] bg-blue-400/20 rounded-full blur-3xl pointer-events-none z-[-1]"></div>
    <div class="fixed bottom-[-10%] right-[-5%] w-[40%] h-[40%] bg-blue-400/10 rounded-full blur-3xl pointer-events-none z-[-1]"></div>

    <!-- Header Logo -->
    <div class="absolute top-6 left-6 md:top-8 md:left-10 flex items-center gap-3 z-20">
        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-md">M</div>
        <div class="flex flex-col justify-center">
            <span class="font-bold text-xl text-blue-600 leading-none">Mitra</span>
            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1">DPMPTSP</span>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 max-w-xl w-full p-8 md:p-10 text-center relative z-10">
        
        <div class="relative z-10">
            <!-- Icon -->
            <div class="mx-auto w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mb-6 relative">
                <div class="absolute inset-0 bg-blue-100 rounded-full animate-ping opacity-75" style="animation-duration: 2s;"></div>
                <i class="ph ph-envelope-open text-5xl text-blue-500 relative z-10 animate-bounce" style="animation-duration: 2s;"></i>
            </div>
            
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Cek Email Anda</h2>
            
            <p class="text-gray-600 mb-6 leading-relaxed">
                Kami telah mengirimkan tautan verifikasi ke alamat email Anda. Silakan periksa kotak masuk atau folder spam Anda dan klik tautan tersebut untuk mengaktifkan akun Anda.
            </p>
            
            <div class="bg-amber-50 border border-amber-100 rounded-xl p-5 mb-8 text-left flex gap-4">
                <div class="mt-0.5">
                    <i class="ph ph-info text-2xl text-amber-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-amber-900 mb-1">Penting</h4>
                    <p class="text-sm text-amber-700 leading-relaxed">
                        Anda harus memverifikasi email Anda sebelum dapat melanjutkan ke tahap pengisian profil dan legalitas usaha.
                    </p>
                </div>
            </div>
            
            @if (session('message'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 rounded-lg p-3">
                    {{ session('message') }}
                </div>
            @endif
            
            <div class="flex flex-col sm:flex-row gap-3 justify-center items-center">
                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:text-red-600 transition-colors flex items-center justify-center w-full text-center">
                        <i class="ph ph-sign-out mr-2 text-lg"></i> Logout Akun
                    </button>
                </form>
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors flex items-center justify-center gap-2 w-full sm:w-auto">
                        <i class="ph ph-paper-plane-tilt"></i> Kirim Ulang Email
                    </button>
                </form>
            </div>
            

        </div>
    </div>

    <div class="mt-8 text-center text-sm text-gray-500 font-medium relative z-10">
        &copy; 2026 DPMPTSP. Sistem Informasi Manajemen Mitra.
    </div>

</body>
</html>
