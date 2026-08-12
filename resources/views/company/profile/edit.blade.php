@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto pb-10" x-data="profileForm()">
    
    <div class="mb-6 md:mb-8">
        <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight mb-1.5">Edit Profil Publik</h1>
        <p class="text-sm md:text-base text-slate-500 font-medium">Lengkapi profil untuk ditampilkan di direktori vendor.</p>
    </div>

    <form action="{{ route('company.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Branding -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-800">Visual & Branding</h2>
            </div>
            <div class="p-6 space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Logo Perusahaan</label>
                    <input type="file" name="logo" class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl bg-slate-50 overflow-hidden file:mr-4 file:py-3 file:px-4 file:border-0 file:border-r file:border-slate-200 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition-colors">
                    @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @if($company->logo)
                        <div class="mt-2"><img src="{{ Storage::url($company->logo) }}" class="h-16 w-16 object-cover rounded-xl border border-slate-200"></div>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Banner Profil</label>
                    <input type="file" name="banner" class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl bg-slate-50 overflow-hidden file:mr-4 file:py-3 file:px-4 file:border-0 file:border-r file:border-slate-200 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition-colors">
                    @error('banner') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @if($company->banner)
                        <div class="mt-2"><img src="{{ Storage::url($company->banner) }}" class="h-24 w-full max-w-md object-cover rounded-xl border border-slate-200"></div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informasi Umum -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-800">Informasi Umum</h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Berdiri</label>
                        <input type="number" name="established_year" value="{{ old('established_year', $company->established_year) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Contoh: 2015">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tagline / Spesialisasi Singkat</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $company->tagline) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Contoh: Konstruksi Logam & Fabrikasi">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Perusahaan (Tentang Perusahaan)</label>
                    <textarea name="description" rows="5" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Ceritakan latar belakang, visi misi, dan layanan utama perusahaan Anda...">{{ old('description', $company->description) }}</textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone', $company->phone) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Contoh: 08123456789">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Website URL (Opsional)</label>
                        <input type="url" name="website" value="{{ old('website', $company->website) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="https://www.perusahaananda.com">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sertifikasi & Lisensi -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-800">Sertifikasi & Lisensi</h2>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-sm text-slate-500">Tambahkan sertifikat ISO, Halal, SMK3, atau lisensi penting lainnya.</p>
                <div class="flex flex-wrap gap-3 mb-3">
                    <template x-for="(cert, index) in certifications" :key="index">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 border border-blue-200 text-blue-700 rounded-lg text-sm font-medium">
                            <span x-text="cert"></span>
                            <input type="hidden" :name="'certifications['+index+']'" :value="cert">
                            <button type="button" @click="removeCert(index)" class="text-blue-400 hover:text-blue-600 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </div>
                    </template>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="text" x-model="newCert" @keydown.enter.prevent="addCert" class="flex-1 px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Contoh: ISO 9001:2015">
                    <button type="button" @click="addCert" class="w-full sm:w-auto px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-colors shrink-0">
                        Tambah
                    </button>
                </div>
            </div>
        </div>

        <!-- (Peluang dan Portofolio telah dipindahkan ke manajemen mandiri di Profil Publik dan RFP Saya) -->

        <!-- Submit -->
        <div class="flex flex-col sm:flex-row sm:justify-end pt-4 gap-3">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('company.profile') }}" class="w-full sm:w-auto justify-center px-6 py-3.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold rounded-xl shadow-sm transition-all flex items-center gap-2 text-base order-2 sm:order-1">
                Batal
            </a>
            <button type="submit" class="w-full sm:w-auto justify-center px-6 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-600/20 transition-all flex items-center gap-2 text-base order-1 sm:order-2">
                Simpan Profil Publik
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('profileForm', () => ({
            certifications: Object.values(@json($company->certifications ?? []) || {}),
            newCert: '',
            
            addCert() {
                if (this.newCert.trim() !== '') {
                    this.certifications.push(this.newCert.trim());
                    this.newCert = '';
                }
            },
            removeCert(index) {
                this.certifications.splice(index, 1);
            }
        }))
    })
</script>
@endsection
