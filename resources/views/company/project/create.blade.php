@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto pb-10" x-data="projectForm({ 
    type: {{ json_encode(old('type', '')) }},
    title: {{ json_encode(old('title', '')) }},
    description: {{ json_encode(old('description', '')) }},
    ruang_lingkup: {{ json_encode(old('ruang_lingkup', '')) }},
    isUmkm: {{ in_array(strtolower($company->skala_usaha ?? ''), ['mikro', 'kecil']) ? 'true' : 'false' }},
    offerings: [''],
    requirements: [''],
    province_id: {{ json_encode(old('province_id') ?? '') }},
    regency_id: {{ json_encode(old('regency_id') ?? '') }},
    district_id: {{ json_encode(old('district_id') ?? '') }},
    village_id: {{ json_encode(old('village_id') ?? '') }},
    address: {{ json_encode(old('address') ?? '') }},
    regencies: [],
    districts: [],
    villages: [],
    companyLocations: {{ $company->locations->toJson() }},
    isSameAsOffice: {{ $company->is_usaha_same_as_office ? 'true' : 'false' }},
    
    async fetchRegencies() {
        this.regencies = []; this.districts = []; this.villages = [];
        this.regency_id = ''; this.district_id = ''; this.village_id = '';
        if (this.province_id) {
            const res = await fetch('/api/regencies/' + this.province_id);
            this.regencies = await res.json();
        }
    },
    async fetchDistricts() {
        this.districts = []; this.villages = [];
        this.district_id = ''; this.village_id = '';
        if (this.regency_id) {
            const res = await fetch('/api/districts/' + this.regency_id);
            this.districts = await res.json();
        }
    },
    async fetchVillages() {
        this.villages = [];
        this.village_id = '';
        if (this.district_id) {
            const res = await fetch('/api/villages/' + this.district_id);
            this.villages = await res.json();
        }
    },
    async applyLocation(type) {
        const loc = this.companyLocations.find(l => l.type === type);
        if (loc) {
            this.province_id = loc.province_id;
            await this.fetchRegencies();
            this.regency_id = loc.regency_id;
            await this.fetchDistricts();
            this.district_id = loc.district_id;
            await this.fetchVillages();
            this.village_id = loc.village_id;
            this.address = loc.address;
        }
    }
})">
    


    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <div class="p-6 md:p-8 border-b border-slate-100 bg-slate-50">
            @php $isUMKM = in_array(strtolower($company->skala_usaha ?? ''), ['mikro', 'kecil']); @endphp
            <h1 class="text-2xl font-bold text-slate-900">
                {{ $isUMKM ? 'Form Penawaran Kemitraan' : 'Buat Proyek / Pengadaan (RFP)' }}
            </h1>
            <p class="text-slate-500 mt-1">
                {{ $isUMKM ? 'Terbitkan profil produk, jasa, atau proposal KSO Anda agar Usaha Besar dapat menemukan dan berkolaborasi dengan Anda.' : 'Terbitkan kebutuhan pengadaan atau proyek Anda untuk menemukan vendor UMKM yang terkualifikasi.' }}
            </p>
        </div>

        <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8" @submit="validate">
            @csrf

            <!-- Type Selection -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-4">Pilih Kategori Kemitraan</label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <template x-for="cat in availableCategories" :key="cat.id">
                        <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none transition-all" 
                               :class="type === cat.id ? cat.activeClass : 'border-slate-300 bg-white hover:bg-slate-50'">
                            <input type="radio" name="type" :value="cat.id" x-model="type" class="sr-only">
                            <span class="flex flex-1">
                                <span class="flex flex-col">
                                    <span class="block text-sm font-bold text-slate-900" x-text="cat.name"></span>
                                    <span class="mt-1 flex items-center text-xs text-slate-500" x-text="cat.desc"></span>
                                </span>
                            </span>
                        </label>
                    </template>
                </div>
                <template x-if="errors.type">
                    <p class="text-red-500 text-xs mt-1" x-text="errors.type"></p>
                </template>
                @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Dynamic Form Fields -->
            <div x-show="type !== ''" x-transition.opacity class="space-y-6 pt-6 border-t border-slate-100" style="display: none;">
                
                <!-- Common Fields -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Judul Proyek / Kemitraan</label>
                    <input type="text" name="title" x-model="title" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" x-bind:placeholder="getTitlePlaceholder()">
                    <template x-if="errors.title">
                        <p class="text-red-500 text-xs mt-1" x-text="errors.title"></p>
                    </template>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div x-data="{ imageUrl: null }">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Banner / Foto Proyek (Opsional)</label>
                    <template x-if="imageUrl">
                        <div class="mb-4">
                            <img :src="imageUrl" alt="Preview Banner Proyek" class="h-40 rounded-xl object-cover border border-slate-200">
                        </div>
                    </template>
                    <input type="file" name="image" accept="image/*" @change="if($event.target.files.length) imageUrl = URL.createObjectURL($event.target.files[0])" class="block w-full text-sm text-slate-500 bg-slate-50 border border-slate-300 rounded-xl cursor-pointer file:cursor-pointer file:mr-4 file:py-3 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                    <p class="text-xs text-slate-500 mt-1">Gunakan foto beresolusi baik agar terlihat menarik di halaman detail. Maks. 5MB.</p>
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Kemitraan</label>
                    <textarea name="description" x-model="description" rows="3" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" placeholder="Jelaskan gambaran umum kemitraan/proyek ini..."></textarea>
                    <template x-if="errors.description">
                        <p class="text-red-500 text-xs mt-1" x-text="errors.description"></p>
                    </template>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ruang Lingkup Pekerjaan / Kebutuhan Khusus</label>
                    <textarea name="ruang_lingkup" x-model="ruang_lingkup" rows="3" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" placeholder="Jelaskan secara detail spesifikasi yang dibutuhkan, ruang lingkup pekerjaan, atau detail operasional..."></textarea>
                    <template x-if="errors.ruang_lingkup">
                        <p class="text-red-500 text-xs mt-1" x-text="errors.ruang_lingkup"></p>
                    </template>
                    @error('ruang_lingkup') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nilai Anggaran / Kontrak (Opsional)</label>
                        <div class="relative mb-2">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500 font-bold">Rp</span>
                            <input type="number" name="estimated_value" value="{{ old('estimated_value') }}" class="block w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" placeholder="0">
                        </div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_budget_negotiable" value="1" {{ old('is_budget_negotiable') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                            <span class="text-sm font-medium text-slate-600">Nilai bersifat negosiasi / bisa didiskusikan</span>
                        </label>
                    </div>
                </div>

                <!-- Structured Location Fields -->
                <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-3 sm:gap-0">
                        <label class="block text-sm font-bold text-slate-900">Lokasi Proyek (Opsional)</label>
                        <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                            <template x-if="isSameAsOffice">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" id="loc_shortcut_checkbox" @change="if($event.target.checked) { applyLocation('KANTOR_UTAMA') } else { clearLocation() }" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                                    <span class="text-xs font-medium text-slate-600">Sama dengan lokasi perusahaan</span>
                                </label>
                            </template>
                            <template x-if="!isSameAsOffice">
                                <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="loc_shortcut" @change="applyLocation('KANTOR_UTAMA')" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                        <span class="text-xs font-medium text-slate-600">Gunakan lokasi kantor</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="loc_shortcut" @change="applyLocation('LOKASI_USAHA')" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                        <span class="text-xs font-medium text-slate-600">Gunakan lokasi usaha</span>
                                    </label>
                                </div>
                            </template>
                            
                            <!-- Clear button -->
                            <button type="button" @click="clearLocation()" x-show="province_id" style="display: none;" class="flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors border border-red-200 w-full sm:w-auto justify-center sm:justify-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                Kosongkan
                            </button>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Provinsi</label>
                            <select name="province_id" x-model="province_id" @change="fetchRegencies(); uncheckShortcuts()" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="" disabled>Pilih Provinsi...</option>
                                @foreach($provinces as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                                @endforeach
                            </select>
                            @error('province_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kabupaten/Kota</label>
                            <select name="regency_id" x-model="regency_id" @change="fetchDistricts(); uncheckShortcuts()" :disabled="!province_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 disabled:bg-slate-100 disabled:cursor-not-allowed">
                                <option value="" disabled>Pilih Kabupaten/Kota...</option>
                                <template x-for="r in regencies" :key="r.id">
                                    <option :value="r.id" x-text="r.name"></option>
                                </template>
                            </select>
                            @error('regency_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kecamatan</label>
                            <select name="district_id" x-model="district_id" @change="fetchVillages(); uncheckShortcuts()" :disabled="!regency_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 disabled:bg-slate-100 disabled:cursor-not-allowed">
                                <option value="" disabled>Pilih Kecamatan...</option>
                                <template x-for="d in districts" :key="d.id">
                                    <option :value="d.id" x-text="d.name"></option>
                                </template>
                            </select>
                            @error('district_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Desa/Kelurahan</label>
                            <select name="village_id" x-model="village_id" @change="uncheckShortcuts()" :disabled="!district_id" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 disabled:bg-slate-100 disabled:cursor-not-allowed">
                                <option value="" disabled>Pilih Desa/Kelurahan...</option>
                                <template x-for="v in villages" :key="v.id">
                                    <option :value="v.id" x-text="v.name"></option>
                                </template>
                            </select>
                            @error('village_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap</label>
                        <textarea name="address" x-model="address" @input="uncheckShortcuts()" rows="2" class="block w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500" placeholder="Jl. Raya No. 123..."></textarea>
                        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Batas Waktu Penawaran / Pendaftaran (Opsional)</label>
                        <input type="date" name="offer_end_date" value="{{ old('offer_end_date') }}" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors">
                        @error('offer_end_date')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-show="!isUmkm" x-cloak>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Target Mulai Pelaksanaan Proyek (Opsional)</label>
                        <input type="date" name="project_start_date" value="{{ old('project_start_date') }}" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors">
                        @error('project_start_date')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Target Selesai Pelaksanaan Proyek (Opsional)</label>
                        <input type="date" name="project_end_date" value="{{ old('project_end_date') }}" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors">
                        @error('project_end_date')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Offerings -->
                <div class="bg-blue-50/50 p-6 rounded-xl border border-blue-100">
                    <label class="block text-sm font-bold text-blue-900 mb-1" x-text="getOfferingsTitle()"></label>
                    <p class="text-xs text-blue-600 mb-4" x-text="getOfferingsDesc()"></p>
                    
                    <template x-for="(item, index) in offerings" :key="index">
                        <div class="flex gap-2 mb-2">
                            <input type="text" :name="'offerings['+index+']'" x-model="offerings[index]" class="block w-full px-4 py-2 bg-white border border-blue-200 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Ketik disini...">
                            <button type="button" @click="offerings.splice(index, 1)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </div>
                    </template>
                    
                    <button type="button" @click="offerings.push('')" class="mt-2 text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Tambah Item Baru
                    </button>
                    <template x-if="errors.offerings">
                        <p class="text-red-500 text-xs mt-2" x-text="errors.offerings"></p>
                    </template>
                    @error('offerings') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Requirements -->
                <div class="bg-amber-50/50 p-6 rounded-xl border border-amber-100">
                    <label class="block text-sm font-bold text-amber-900 mb-1" x-text="getRequirementsTitle()"></label>
                    <p class="text-xs text-amber-600 mb-4" x-text="getRequirementsDesc()"></p>
                    
                    <template x-for="(item, index) in requirements" :key="index">
                        <div class="flex gap-2 mb-2">
                            <input type="text" :name="'requirements['+index+']'" x-model="requirements[index]" class="block w-full px-4 py-2 bg-white border border-amber-200 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-amber-500 focus:outline-none" placeholder="Ketik disini...">
                            <button type="button" @click="requirements.splice(index, 1)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </div>
                    </template>
                    
                    <button type="button" @click="requirements.push('')" class="mt-2 text-sm font-bold text-amber-600 hover:text-amber-800 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Tambah Item Baru
                    </button>
                    <template x-if="errors.requirements">
                        <p class="text-red-500 text-xs mt-2" x-text="errors.requirements"></p>
                    </template>
                    @error('requirements') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

            </div>

            <!-- Submit -->
            <div class="pt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3" x-show="type !== ''" style="display: none;">
                <a href="{{ route('vendor.show', ['company' => $company->id, 'tab' => 'offerings']) }}" class="w-full sm:w-auto text-center px-6 py-3 border border-slate-300 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" name="status" value="draft" class="w-full sm:w-auto px-6 py-3 border border-slate-300 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors">
                    Simpan sebagai Draf
                </button>
                <button type="submit" name="status" value="published" class="w-full sm:w-auto px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/20">
                    {{ in_array(strtolower($company->skala_usaha ?? ''), ['mikro', 'kecil', 'menengah']) ? 'Tawarkan' : 'Terbitkan' }}
                </button>
            </div>
            
        </form>
    </div>@endsection
