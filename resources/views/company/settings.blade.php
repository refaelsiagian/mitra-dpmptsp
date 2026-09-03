@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto pb-10">
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight mb-2">
            Pengaturan Akun
        </h1>
        <p class="text-slate-500">Kelola alamat email dan kata sandi Anda untuk masuk ke sistem.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Ubah Email -->
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 h-fit" x-data="{ showEmailPassword: false }">
            <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                <div class="bg-blue-50 p-2.5 rounded-xl text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                </div>
                <h2 class="text-lg font-bold text-slate-900">Ubah Email</h2>
            </div>

            <form action="{{ route('settings.updateEmail') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Email Saat Ini</label>
                    <input type="text" value="{{ auth()->user()->email }}" disabled class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-sm text-slate-500 cursor-not-allowed">
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Email Baru</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors @error('email') border-red-500 bg-red-50 @enderror">
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="current_password_for_email" class="block text-sm font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input name="current_password_for_email" id="current_password_for_email" required placeholder="Masukkan kata sandi untuk mengonfirmasi" class="w-full px-4 py-2.5 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors @error('current_password_for_email') border-red-500 bg-red-50 @enderror" :type="showEmailPassword ? 'text' : 'password'">
                        <button @click="showEmailPassword = !showEmailPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" type="button">
                            <i class="ph ph-eye text-xl" x-show="showEmailPassword" x-cloak></i>
                            <i class="ph ph-eye-slash text-xl" x-show="!showEmailPassword" x-cloak></i>
                        </button>
                    </div>
                    @error('current_password_for_email')
                        <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl transition-all shadow-sm flex justify-center items-center gap-2">
                        Perbarui Email
                    </button>
                    <p class="text-xs text-slate-500 text-center mt-3 leading-relaxed">
                        Jika Anda mengubah email, Anda akan diminta untuk <strong>memverifikasi ulang</strong> alamat email yang baru.
                    </p>
                </div>
            </form>
        </div>

        <!-- Ubah Password -->
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 h-fit" x-data="{ 
            currentPassword: '',
            password: '', 
            confirmPassword: '', 
            showCurrentPassword: false,
            showPassword: false, 
            showConfirmPassword: false,
            get hasLength() { return this.password.length >= 8; },
            get hasLetter() { return /[a-zA-Z]/.test(this.password); },
            get hasNumber() { return /\d/.test(this.password); },
            get hasSymbol() { return /[\W_]/.test(this.password); },
            get isMatch() { return this.confirmPassword.length > 0 && this.password === this.confirmPassword; }
        }">
            <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                <div class="bg-amber-50 p-2.5 rounded-xl text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <h2 class="text-lg font-bold text-slate-900">Ubah Kata Sandi</h2>
            </div>

            <form action="{{ route('settings.updatePassword') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-semibold text-slate-700 mb-1">Kata Sandi Saat Ini</label>
                    <div class="relative">
                        <input x-model="currentPassword" name="current_password" id="current_password" required class="w-full px-4 py-2.5 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors @error('current_password') border-red-500 bg-red-50 @enderror" :type="showCurrentPassword ? 'text' : 'password'">
                        <button @click="showCurrentPassword = !showCurrentPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" type="button">
                            <i class="ph ph-eye text-xl" x-show="showCurrentPassword" x-cloak></i>
                            <i class="ph ph-eye-slash text-xl" x-show="!showCurrentPassword" x-cloak></i>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Kata Sandi Baru</label>
                    <div class="relative">
                        <input x-model="password" name="password" id="password" required class="w-full px-4 py-2.5 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors @error('password') border-red-500 bg-red-50 @enderror" :type="showPassword ? 'text' : 'password'">
                        <button @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" type="button">
                            <i class="ph ph-eye text-xl" x-show="showPassword" x-cloak></i>
                            <i class="ph ph-eye-slash text-xl" x-show="!showPassword" x-cloak></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
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
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                    <div class="relative">
                        <input x-model="confirmPassword" name="password_confirmation" id="password_confirmation" required class="w-full px-4 py-2.5 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" :type="showConfirmPassword ? 'text' : 'password'">
                        <button @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" type="button">
                            <i class="ph ph-eye text-xl" x-show="showConfirmPassword" x-cloak></i>
                            <i class="ph ph-eye-slash text-xl" x-show="!showConfirmPassword" x-cloak></i>
                        </button>
                    </div>

                    <!-- Match Hint -->
                    <div class="mt-2 text-xs flex items-center gap-1.5 transition-colors" x-show="confirmPassword.length > 0" x-cloak :class="isMatch ? 'text-green-600 font-medium' : 'text-red-500 font-medium'">
                        <i class="ph ph-check-circle fill-green-600 text-sm" x-show="isMatch"></i>
                        <i class="ph ph-x-circle text-sm" x-show="!isMatch"></i>
                        <span x-text="isMatch ? 'Kata sandi cocok' : 'Kata sandi tidak cocok'"></span>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full px-5 py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm rounded-xl transition-all shadow-sm">
                        Perbarui Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
