@extends('layouts.dashboard')

@section('content')
<div class="max-w-5xl mx-auto flex flex-col h-full">
    
    <!-- Header -->
    <div class="mb-6 flex-shrink-0">
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Eksplorasi Vendor</h2>
        <p class="text-slate-500 mt-1 sm:text-lg">Temukan mitra bisnis terverifikasi untuk proyek Anda.</p>
    </div>

    <!-- Filter Toolbar -->
    <div class="bg-white p-3 sm:p-4 rounded-xl border border-slate-200 shadow-sm mb-6 flex-shrink-0 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            
            <!-- Kategori KBLI Dropdown -->
            <div class="relative">
                <select class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-2 pl-4 pr-10 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer hover:bg-slate-100 transition-colors">
                    <option value="" disabled selected>Kategori KBLI</option>
                    <option value="konstruksi">Konstruksi</option>
                    <option value="it">Teknologi Informasi</option>
                    <option value="manufaktur">Manufaktur</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </div>
            </div>

            <!-- Lokasi Dropdown -->
            <div class="relative">
                <select class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-2 pl-4 pr-10 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer hover:bg-slate-100 transition-colors">
                    <option value="" disabled selected>Lokasi</option>
                    <option value="medan">Medan</option>
                    <option value="jakarta">Jakarta</option>
                    <option value="surabaya">Surabaya</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </div>
            </div>

            <!-- Status PKP Dropdown -->
            <div class="relative">
                <select class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-2 pl-4 pr-10 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer hover:bg-slate-100 transition-colors">
                    <option value="" disabled selected>Status PKP</option>
                    <option value="ya">Ya (PKP)</option>
                    <option value="tidak">Tidak</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </div>
            </div>

        </div>

        <!-- Reset Filter -->
        <button class="text-sm font-medium text-slate-500 hover:text-red-600 transition-colors flex items-center gap-1.5 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
            Reset Filter
        </button>
    </div>

    <!-- Feed / List -->
    <div class="flex-1 overflow-y-auto pb-8 pr-2 custom-scrollbar">
        <div class="flex flex-col gap-5">
            <!-- Vendor 1 -->
            @include('components.vendor-card', ['name' => 'PT Teknologi Inovasi Bangsa', 'category' => 'Pengembangan Perangkat Lunak', 'location' => 'Jakarta Selatan, DKI Jakarta'])
            
            <!-- Vendor 2 -->
            @include('components.vendor-card', ['name' => 'CV Baja Nusantara', 'category' => 'Konstruksi Logam & Fabrikasi', 'location' => 'Medan, Sumatera Utara'])
            
            <!-- Vendor 3 -->
            @include('components.vendor-card', ['name' => 'PT Kreatif Media Digital', 'category' => 'Periklanan dan Desain', 'location' => 'Bandung, Jawa Barat'])
            
            <!-- Vendor 4 -->
            @include('components.vendor-card', ['name' => 'Maju Bersama Logistik', 'category' => 'Transportasi dan Pergudangan', 'location' => 'Surabaya, Jawa Timur'])
        </div>
    </div>
</div>

<style>
    /* Subtle custom scrollbar for the feed */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 20px;
    }
</style>
@endsection
