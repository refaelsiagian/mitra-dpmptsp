<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Lupa Kata Sandi - Mitra DPMPTSP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style data-purpose="custom-utilities">
        /* Geometric background pattern for the right side */
        .bg-geometric {
        background-image: url('data:image/svg+xml,%3Csvg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"%3E%3Crect width="50" height="50" fill="%23c4b5fd"/%3E%3Cpath d="M50 0 L100 50 L50 100 L0 50 Z" fill="%23a78bfa"/%3E%3Ccircle cx="75" cy="25" r="25" fill="%238b5cf6"/%3E%3Cpath d="M0 50 A50 50 0 0 1 50 100 L0 100 Z" fill="%237c3aed"/%3E%3Crect x="50" y="50" width="50" height="50" fill="%236d28d9"/%3E%3Cpath d="M100 50 A50 50 0 0 0 50 100 L100 100 Z" fill="%23c4b5fd"/%3E%3C/svg%3E');
        
        /* Menggunakan ukuran tetap (pixel) agar pola mengulang secara alami */
        background-size: 180px 180px;
        background-position: top left;
        background-repeat: repeat;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="font-sans text-gray-900 bg-white antialiased flex h-screen overflow-hidden">

<!-- BEGIN: Left Section (Form Container) -->
<main class="w-full lg:w-1/2 flex flex-col p-8 sm:p-12 lg:p-16 xl:p-24 bg-white h-full overflow-y-auto relative" data-purpose="forgot-password-form-section">
  
    <!-- Logo Section -->
    <div class="mb-8 flex-shrink-0 w-full max-w-md mx-auto">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded flex items-center justify-center text-white font-bold text-xl">M</div>
            <div>
                <h1 class="text-xl font-bold text-blue-600 leading-tight">Mitra</h1>
                <h2 class="text-sm font-semibold text-gray-500 leading-tight uppercase tracking-wide">DPMPTSP</h2>
            </div>
        </div>
    </div>

    <!-- Middle Area: Form Content -->
    <div class="w-full max-w-md mx-auto my-auto">
        <div class="mb-6">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors mb-4 group">
                <i class="ph ph-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                Kembali ke Login
            </a>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Lupa Kata Sandi?</h2>
            <p class="text-gray-500 text-sm">Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>
        </div>
        
        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-start gap-3">
                <i class="ph ph-check-circle text-xl shrink-0 mt-0.5"></i>
                <p class="text-sm font-medium">{{ session('status') }}</p>
            </div>
        @endif

        <form action="{{ route('password.email') }}" class="space-y-6" method="POST">
            @csrf
            
            <fieldset class="space-y-4">
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="p-3 bg-red-50 text-red-600 rounded-lg text-sm">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email Address <span class="text-red-500">*</span></label>
                    <input class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors" id="email" name="email" value="{{ old('email') }}" placeholder="Enter work email" required autofocus type="email"/>
                </div>
            </fieldset>

            <!-- Submit Button -->
            <div class="pt-2">
                <button class="w-full flex justify-center items-center gap-2 py-2.5 px-4 border border-transparent rounded shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition-colors" type="submit">
                    Kirim Tautan Reset
                    <i class="ph ph-paper-plane-right"></i>
                </button>
            </div>
        </form>
    </div>
</main>
<!-- END: Left Section (Form Container) -->

<!-- BEGIN: Right Section (Pattern Background) -->
<aside class="hidden lg:block lg:w-1/2 h-full bg-geometric relative overflow-hidden shadow-inner" data-purpose="hero-pattern-section">
    <!-- Subtle overlay to make it look premium -->
    <div class="absolute inset-0 bg-gradient-to-tr from-white/20 to-transparent mix-blend-overlay"></div>
</aside>
<!-- END: Right Section (Pattern Background) -->

</body>
</html>
