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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    
                    @if($company->skala_usaha !== 'Kecil' && $company->skala_usaha !== 'Mikro')
                    
                    <!-- Subkontrak -->
                    <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none transition-all" 
                           :class="type === 'subkontrak' ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-600' : 'border-slate-300 bg-white hover:bg-slate-50'">
                        <input type="radio" name="type" value="subkontrak" x-model="type" class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="block text-sm font-bold text-slate-900">Subkontrak</span>
                                <span class="mt-1 flex items-center text-xs text-slate-500">Pekerjaan spesifik untuk vendor.</span>
                            </span>
                        </span>
                    </label>

                    <!-- Rantai Pasok -->
                    <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none transition-all" 
                           :class="type === 'rantai_pasok' ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-600' : 'border-slate-300 bg-white hover:bg-slate-50'">
                        <input type="radio" name="type" value="rantai_pasok" x-model="type" class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="block text-sm font-bold text-slate-900">Rantai Pasok</span>
                                <span class="mt-1 flex items-center text-xs text-slate-500">Suplai bahan berkelanjutan.</span>
                            </span>
                        </span>
                    </label>

                    <!-- Outsourcing -->
                    <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none transition-all" 
                           :class="type === 'outsourcing' ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-600' : 'border-slate-300 bg-white hover:bg-slate-50'">
                        <input type="radio" name="type" value="outsourcing" x-model="type" class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="block text-sm font-bold text-slate-900">Penyumberluaran</span>
                                <span class="mt-1 flex items-center text-xs text-slate-500">Outsourcing tenaga kerja/jasa.</span>
                            </span>
                        </span>
                    </label>

                    <!-- Konstruksi -->
                    <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none transition-all" 
                           :class="type === 'konstruksi' ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-600' : 'border-slate-300 bg-white hover:bg-slate-50'">
                        <input type="radio" name="type" value="konstruksi" x-model="type" class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="block text-sm font-bold text-slate-900">Konstruksi</span>
                                <span class="mt-1 flex items-center text-xs text-slate-500">Pembangunan sarana prasarana.</span>
                            </span>
                        </span>
                    </label>

                    @endif

                    <!-- KSO (Available to both) -->
                    <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none transition-all" 
                           :class="type === 'kso' ? 'border-emerald-600 bg-emerald-50 ring-1 ring-emerald-600' : 'border-slate-300 bg-white hover:bg-slate-50'">
                        <input type="radio" name="type" value="kso" x-model="type" class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="block text-sm font-bold text-slate-900">KSO / Bagi Hasil</span>
                                <span class="mt-1 flex items-center text-xs text-slate-500">Kerja sama & berbagi keuntungan.</span>
                            </span>
                        </span>
                    </label>

                    @if($company->skala_usaha === 'Kecil' || $company->skala_usaha === 'Mikro')
                    <!-- Perdagangan Umum (UMKM only) -->
                    <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none transition-all" 
                           :class="type === 'perdagangan' ? 'border-purple-600 bg-purple-50 ring-1 ring-purple-600' : 'border-slate-300 bg-white hover:bg-slate-50'">
                        <input type="radio" name="type" value="perdagangan" x-model="type" class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="block text-sm font-bold text-slate-900">Perdagangan Umum</span>
                                <span class="mt-1 flex items-center text-xs text-slate-500">Penjualan barang / pengadaan langsung.</span>
                            </span>
                        </span>
                    </label>
                    @endif
                </div>
                @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Dynamic Form Fields -->
            <div x-show="type !== ''" x-transition.opacity class="space-y-6 pt-6 border-t border-slate-100" style="display: none;">
                
                <!-- Common Fields -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Judul Proyek / Kemitraan</label>
                    <input type="text" name="title" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" placeholder="Misal: Instalasi HVAC Lantai 1-5">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Kemitraan</label>
                    <textarea name="description" rows="3" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" placeholder="Jelaskan gambaran umum kemitraan/proyek ini..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ruang Lingkup Pekerjaan / Kebutuhan Khusus</label>
                    <textarea name="ruang_lingkup" rows="3" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" placeholder="Jelaskan secara detail spesifikasi yang dibutuhkan, ruang lingkup pekerjaan, atau detail operasional..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nilai Anggaran / Kontrak (Opsional)</label>
                        <div class="relative mb-2">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500 font-bold">Rp</span>
                            <input type="number" name="estimated_value" class="block w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" placeholder="0">
                        </div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_negotiable" value="1" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                            <span class="text-sm font-medium text-slate-600">Nilai bersifat negosiasi / bisa didiskusikan</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi (Opsional)</label>
                        <input type="text" name="location" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" placeholder="Misal: Surabaya">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Batas Waktu Penawaran / Pendaftaran</label>
                        <input type="date" name="end_date" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Target Mulai Pelaksanaan (Opsional)</label>
                        <input type="date" name="start_date" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Target Selesai Pelaksanaan (Opsional)</label>
                        <input type="date" name="project_end_date" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors">
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
            if (this.type === 'kso') return 'Aset / Modal yang Kami Siapkan';
            if (this.type === 'perdagangan') return 'Katalog Produk / Jasa Kami';
            if (this.type === 'outsourcing') return 'Fasilitas & Tunjangan Tenaga Kerja';
            if (this.type === 'rantai_pasok') return 'Kemudahan / Dukungan untuk Suplier';
            return 'Fasilitas yang Disediakan Pemberi Tugas';
        },
        
        getOfferingsDesc() {
            if (this.type === 'kso') return 'Sebutkan aset, perizinan, atau modal yang sudah Anda siapkan.';
            if (this.type === 'perdagangan') return 'Sebutkan jenis barang yang Anda jual (kapasitas produksi, spesifikasi).';
            if (this.type === 'outsourcing') return 'Apa yang didapat oleh penyedia jasa outsourcing (misal: area kerja).';
            if (this.type === 'rantai_pasok') return 'Sebutkan dukungan untuk vendor (misal: pembayaran tunai, kontrak jangka panjang).';
            return 'Sebutkan material atau akses yang akan Anda berikan ke pelaksana.';
        },

        getRequirementsTitle() {
            if (this.type === 'kso') return 'Kewajiban Calon Mitra KSO';
            if (this.type === 'perdagangan') return 'Syarat Pembelian / Ketentuan';
            if (this.type === 'outsourcing') return 'Kualifikasi Tenaga Kerja / Jasa';
            if (this.type === 'rantai_pasok') return 'Spesifikasi Barang / Suplai yang Dicari';
            return 'Tanggung Jawab Vendor / Pelaksana';
        },

        getRequirementsDesc() {
            if (this.type === 'kso') return 'Sebutkan apa yang harus disediakan oleh mitra (contoh: modal tambahan, teknologi).';
            if (this.type === 'perdagangan') return 'Sebutkan minimal order, atau kriteria pembeli jika ada.';
            if (this.type === 'outsourcing') return 'Sebutkan sertifikasi, atau jumlah tenaga yang dibutuhkan.';
            if (this.type === 'rantai_pasok') return 'Sebutkan standar kualitas material, jadwal pengiriman, dsb.';
            return 'Sebutkan alat, tenaga kerja, atau standar kerja vendor.';
        }
    }
}
</script>
@endsection
