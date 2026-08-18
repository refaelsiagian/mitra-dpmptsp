<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Mitra DPMPTSP - Login</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="font-sans text-text bg-surface antialiased flex h-screen overflow-hidden">

<!-- BEGIN: Left Section (Form Container) -->
<main class="w-full lg:w-1/2 flex flex-col p-8 sm:p-12 lg:p-16 xl:p-24 bg-white h-full overflow-y-auto relative" data-purpose="login-form-section">
  
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
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Login Akun</h2>
        </div>
        <form action="/login" class="space-y-6" method="POST">
            @csrf
        <!-- Account Credentials Section -->
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
                    <input class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors" id="email" name="email" placeholder="Enter work email" required="" type="email"/>
                </div>
                
                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input class="w-full px-4 py-2 pr-10 border border-gray-300 rounded focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors" id="password" name="password" placeholder="Enter your password" required="" type="password"/>
                        <button class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" data-purpose="toggle-password" type="button">
                            <i class="ph ph-eye-slash text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Forgot Password -->
                <div class="flex items-center justify-between mt-2">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                            Forgot your password?
                        </a>
                    </div>
                </div>
            </fieldset>
            <!-- Submit Button -->
            <div>
                <button class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition-colors" type="submit">
                Log in
                </button>
            </div>
            <div class="text-center text-sm mt-4">
                <span class="text-gray-500">Don't have an account?</span>
                <a class="font-medium text-blue-600 hover:underline" href="/">Register here</a>
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

<!-- Simple script for password toggle functionality -->
<script data-purpose="form-interactions">
    document.addEventListener('DOMContentLoaded', function() {
        const togglePasswordBtn = document.querySelector('[data-purpose="toggle-password"]');
        const passwordInput = document.getElementById('password');
        
        if(togglePasswordBtn && passwordInput) {
            togglePasswordBtn.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle icon
            const icon = this.querySelector('i');
            if (type === 'text') {
                icon.classList.remove('ph-eye-slash');
                icon.classList.add('ph-eye');
            } else {
                icon.classList.remove('ph-eye');
                icon.classList.add('ph-eye-slash');
            }
            });
        }
    });
</script>
</body>
</html>
