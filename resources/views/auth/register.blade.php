<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>KIS Berkah - Registrasi</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-2.svg') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style data-purpose="custom-utilities">
        /* Geometric background pattern for the right side */
        .bg-geometric {
        background-image: url('data:image/svg+xml,%3Csvg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"%3E%3Crect width="50" height="50" fill="%23c4b5fd"/%3E%3Cpath d="M50 0 L100 50 L50 100 L0 50 Z" fill="%23a78bfa"/%3E%3Ccircle cx="75" cy="25" r="25" fill="%238b5cf6"/%3E%3Cpath d="M0 50 A50 50 0 0 1 50 100 L0 100 Z" fill="%237c3aed"/%3E%3Crect x="50" y="50" width="50" height="50" fill="%236d28d9"/%3E%3Cpath d="M100 50 A50 50 0 0 0 50 100 L100 100 Z" fill="%23c4b5fd"/%3E%3C/svg%3E');
        
        /* PERUBAHAN: Menggunakan ukuran tetap (pixel) agar pola mengulang secara alami tanpa celah dan tidak kaku */
        background-size: 180px 180px;
        background-position: top left;
        background-repeat: repeat;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans text-text bg-surface antialiased flex h-screen overflow-hidden">

<!-- BEGIN: Left Section (Form Container) -->
<main class="w-full lg:w-1/2 flex flex-col p-8 sm:p-12 lg:p-16 xl:p-24 bg-white h-full overflow-y-auto relative" data-purpose="registration-form-section">
  
    <!-- Logo Section -->
    <!-- PERUBAHAN: Menambahkan 'w-full max-w-md mx-auto' agar logo sejajar dengan form yang ada di tengah -->
    <div class="mb-8 flex-shrink-0 w-full max-w-md mx-auto">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-1.svg') }}" alt="KIS Berkah" class="h-12 w-auto">
        </div>
    </div>

    <!-- Middle Area: Form Content -->
    <!-- PERUBAHAN: Menghapus class 'xl:mx-0' sehingga 'mx-auto' berlaku di semua ukuran layar (center sumbu X) -->
    <div class="w-full max-w-md mx-auto my-auto" x-data="{ 
        password: '', 
        confirmPassword: '', 
        showPassword: false, 
        showConfirmPassword: false,
        get hasLength() { return this.password.length >= 8; },
        get hasLetter() { return /[a-zA-Z]/.test(this.password); },
        get hasNumber() { return /\d/.test(this.password); },
        get hasSymbol() { return /[\W_]/.test(this.password); },
        get isMatch() { return this.confirmPassword.length > 0 && this.password === this.confirmPassword; }
    }">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Daftar Akun</h2>
        </div>
        <form action="/register" class="space-y-6" method="POST">
            @csrf
        <!-- Account Credentials Section -->
            <fieldset class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Alamat Email <span class="text-red-500">*</span></label>
                    <input class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan alamat email Anda" required="" type="email"/>
                    @error('email')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Kata Sandi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input x-model="password" class="w-full px-4 py-2 pr-10 border border-gray-300 rounded focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors" id="password" name="password" placeholder="Buat kata sandi yang aman" required="" :type="showPassword ? 'text' : 'password'"/>
                        <button @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" type="button">
                            <i class="ph ph-eye text-xl" x-show="showPassword" x-cloak></i>
                            <i class="ph ph-eye-slash text-xl" x-show="!showPassword" x-cloak></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                    
                    <!-- Real-time Password Hints -->
                    <div class="mt-2 grid grid-cols-2 gap-1 text-xs" x-show="password.length > 0" x-cloak>
                        <div class="flex items-center gap-1.5 transition-colors" :class="hasLength ? 'text-green-600 font-medium' : 'text-slate-400'">
                            <i class="ph ph-check-circle fill-green-600 text-sm" x-show="hasLength"></i>
                            <i class="ph ph-circle text-sm" x-show="!hasLength"></i>
                            8+ Karakter
                        </div>
                        <div class="flex items-center gap-1.5 transition-colors" :class="hasLetter ? 'text-green-600 font-medium' : 'text-slate-400'">
                            <i class="ph ph-check-circle fill-green-600 text-sm" x-show="hasLetter"></i>
                            <i class="ph ph-circle text-sm" x-show="!hasLetter"></i>
                            Huruf (a-z)
                        </div>
                        <div class="flex items-center gap-1.5 transition-colors" :class="hasNumber ? 'text-green-600 font-medium' : 'text-slate-400'">
                            <i class="ph ph-check-circle fill-green-600 text-sm" x-show="hasNumber"></i>
                            <i class="ph ph-circle text-sm" x-show="!hasNumber"></i>
                            Angka (0-9)
                        </div>
                        <div class="flex items-center gap-1.5 transition-colors" :class="hasSymbol ? 'text-green-600 font-medium' : 'text-slate-400'">
                            <i class="ph ph-check-circle fill-green-600 text-sm" x-show="hasSymbol"></i>
                            <i class="ph ph-circle text-sm" x-show="!hasSymbol"></i>
                            Simbol (!@#)
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="confirm-password">Konfirmasi Kata Sandi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input x-model="confirmPassword" class="w-full px-4 py-2 pr-10 border border-gray-300 rounded focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors" id="confirm-password" name="confirm-password" placeholder="Konfirmasi kata sandi Anda" required="" :type="showConfirmPassword ? 'text' : 'password'"/>
                        <button @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" type="button">
                            <i class="ph ph-eye text-xl" x-show="showConfirmPassword" x-cloak></i>
                            <i class="ph ph-eye-slash text-xl" x-show="!showConfirmPassword" x-cloak></i>
                        </button>
                    </div>
                    @error('confirm-password')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror

                    <!-- Match Hint -->
                    <div class="mt-2 text-xs flex items-center gap-1.5 transition-colors" x-show="confirmPassword.length > 0" x-cloak :class="isMatch ? 'text-green-600 font-medium' : 'text-red-500 font-medium'">
                        <i class="ph ph-check-circle fill-green-600 text-sm" x-show="isMatch"></i>
                        <i class="ph ph-x-circle text-sm" x-show="!isMatch"></i>
                        <span x-text="isMatch ? 'Kata sandi cocok' : 'Kata sandi tidak cocok'"></span>
                    </div>
                </div>
            </fieldset>
            <div>
                <button class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition-colors" type="submit">
                Daftar
                </button>
            </div>
            <div class="text-center text-sm mt-4">
                <span class="text-gray-500">Sudah punya akun?</span>
                <a wire:navigate class="font-medium text-blue-600 hover:underline" href="/login">Masuk di sini</a>
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
