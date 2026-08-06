@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto pb-10" x-data="projectForm()">
    
    <a href="{{ route('vendor.show', ['company' => $company->id, 'tab' => 'projects']) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors mb-6 group">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
        <span>Kembali ke Profil</span>
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <div class="p-6 md:p-8 border-b border-slate-100 bg-slate-50">
            <h1 class="text-2xl font-bold text-slate-900">Buat Proyek / Kemitraan Baru</h1>
            <p class="text-slate-500 mt-1">Pilih jenis kemitraan dan lengkapi detail penawaran Anda.</p>
        </div>

        <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8">
            @csrf

            <!-- Type Selection -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-4">Pilih Kategori Kemitraan</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    @if($company->skala_usaha !== 'Kecil' && $company->skala_usaha !== 'Mikro')
                    <!-- Tender (Usaha Besar only) -->
                    <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none" 
                           :class="type === 'tender' ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-600' : 'border-slate-300 bg-white hover:bg-slate-50'">
                        <input type="radio" name="type" value="tender" x-model="type" class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="block text-sm font-bold text-slate-900">Subkontrak & Rantai Pasok (Tender)</span>
                                <span class="mt-1 flex items-center text-xs text-slate-500">Cari vendor untuk proyek spesifik.</span>
                            </span>
                        </span>
                        <svg class="h-5 w-5 text-blue-600" :class="type === 'tender' ? 'opacity-100' : 'opacity-0'" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </label>
                    @endif

                    <!-- KSO (Available to both) -->
                    <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none" 
                           :class="type === 'kso' ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-600' : 'border-slate-300 bg-white hover:bg-slate-50'">
                        <input type="radio" name="type" value="kso" x-model="type" class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="block text-sm font-bold text-slate-900">Kerja Sama Operasional (KSO)</span>
                                <span class="mt-1 flex items-center text-xs text-slate-500">Gabung sumber daya & bagi hasil.</span>
                            </span>
                        </span>
                        <svg class="h-5 w-5 text-blue-600" :class="type === 'kso' ? 'opacity-100' : 'opacity-0'" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </label>

                    @if($company->skala_usaha === 'Kecil' || $company->skala_usaha === 'Mikro')
                    <!-- Offering (UMKM only) -->
                    <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none" 
                           :class="type === 'offering' ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-600' : 'border-slate-300 bg-white hover:bg-slate-50'">
                        <input type="radio" name="type" value="offering" x-model="type" class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="block text-sm font-bold text-slate-900">Penawaran Portofolio (UMKM)</span>
                                <span class="mt-1 flex items-center text-xs text-slate-500">Pamerkan kapasitas ke Usaha Besar.</span>
                            </span>
                        </span>
                        <svg class="h-5 w-5 text-blue-600" :class="type === 'offering' ? 'opacity-100' : 'opacity-0'" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </label>
                    @endif
                </div>
                @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Dynamic Form Fields -->
            <div x-show="type !== ''" x-transition.opacity class="space-y-6 pt-6 border-t border-slate-100" style="display: none;">
                
                <!-- Common Fields -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2" x-text="type === 'offering' ? 'Judul Penawaran' : 'Judul Proyek'"></label>
                    <input type="text" name="title" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" placeholder="Misal: Instalasi HVAC Lantai 1-5">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2" x-text="type === 'offering' ? 'Deskripsi Bisnis & Visi' : 'Deskripsi / Ruang Lingkup (SOW)'"></label>
                    <textarea name="description" rows="4" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" placeholder="Jelaskan secara detail..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2" x-text="type === 'offering' ? 'Minimum Nilai Kontrak (Opsional)' : 'Pagu Anggaran / Modal'"></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500 font-bold">Rp</span>
                            <input type="number" name="estimated_value" class="block w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" placeholder="0">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi (Opsional)</label>
                        <input type="text" name="location" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" placeholder="Misal: Surabaya">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div x-show="type === 'tender'">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Target Mulai</label>
                        <input type="date" name="start_date" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Batas Akhir Penawaran / Pendaftaran</label>
                        <input type="date" name="end_date" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors">
                    </div>
                </div>

                <!-- Dynamic JSON Lists -->
                
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
                </div>

            </div>

            <!-- Submit -->
            <div class="pt-6 border-t border-slate-100 flex justify-end gap-3" x-show="type !== ''" style="display: none;">
                <a href="{{ route('vendor.show', ['company' => $company->id, 'tab' => 'projects']) }}" class="px-6 py-3 border border-slate-300 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/20">
                    Terbitkan
                </button>
            </div>
            
        </form>
    </div>
</div>

<script>
function projectForm() {
    return {
        type: '{{ old('type', '') }}',
        offerings: {!! old('offerings') ? json_encode(old('offerings')) : "['']" !!},
        requirements: {!! old('requirements') ? json_encode(old('requirements')) : "['']" !!},
        
        getOfferingsTitle() {
            if (this.type === 'kso') return 'Apa yang Kami Miliki';
            if (this.type === 'offering') return 'Kapasitas & Kapabilitas Kami';
            return 'Fasilitas yang Disediakan Pemberi Tugas';
        },
        
        getOfferingsDesc() {
            if (this.type === 'kso') return 'Sebutkan aset, perizinan, atau modal yang sudah Anda siapkan.';
            if (this.type === 'offering') return 'Sebutkan sertifikasi, mesin, jumlah karyawan, atau keahlian Anda.';
            return 'Sebutkan material atau akses yang akan Anda berikan ke vendor.';
        },

        getRequirementsTitle() {
            if (this.type === 'kso') return 'Apa yang Kami Cari (Syarat Mitra)';
            if (this.type === 'offering') return 'Skema Kemitraan yang Diharapkan';
            return 'Tanggung Jawab Vendor / Pelaksana';
        },

        getRequirementsDesc() {
            if (this.type === 'kso') return 'Sebutkan apa yang harus disediakan oleh mitra (contoh: modal tambahan, teknologi).';
            if (this.type === 'offering') return 'Sebutkan jenis proyek atau kontrak yang Anda incar dari Usaha Besar.';
            return 'Sebutkan alat, tenaga kerja, atau bahan yang wajib dibawa oleh vendor.';
        }
    }
}
</script>
@endsection
