@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto pb-10">
    <!-- Back to Profile -->
    <a href="{{ route('vendor.show', auth()->user()->company->id) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors mb-6 group">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
        <span>Kembali ke Profil Publik</span>
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
            <h1 class="text-xl font-bold text-slate-900">Edit Portofolio Proyek</h1>
            <p class="text-sm text-slate-500 mt-1">Ubah detail portofolio, produk, atau cerita sukses perusahaan Anda.</p>
        </div>

        <form method="POST" action="{{ route('portfolios.update', $portfolio) }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Judul Portofolio / Proyek <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ $portfolio->title }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm" placeholder="Contoh: Pembangunan Fasilitas Gudang 2023">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Foto / Gambar Pendukung</label>
                @if($portfolio->image_path)
                <div class="mb-3">
                    <img src="{{ Storage::url($portfolio->image_path) }}" alt="Current Image" class="w-32 h-24 object-cover rounded-lg border border-slate-200">
                </div>
                @endif
                <input type="file" name="image" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors border border-slate-200 rounded-xl cursor-pointer">
                <p class="text-xs text-slate-500 mt-2">Format: JPG, PNG. Maks: 4MB. Kosongkan jika tidak ingin mengubah gambar.</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi & Cerita Sukses (Opsional)</label>
                <textarea name="description" rows="5" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm" placeholder="Ceritakan tentang tantangan, solusi yang Anda berikan, dan hasil akhirnya...">{{ $portfolio->description }}</textarea>
                <p class="text-xs text-slate-500 mt-2">Semakin detail, semakin meyakinkan calon mitra Anda.</p>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('vendor.show', auth()->user()->company->id) }}" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-blue-600/20">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
