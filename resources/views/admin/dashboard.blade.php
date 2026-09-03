@extends('layouts.dashboard')

@section('title', 'Admin Dashboard - Verifikasi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Admin Dashboard</h1>
            <p class="text-slate-500 text-sm mt-1">Daftar Perusahaan Menunggu Verifikasi</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-md">
            <div class="flex items-center">
                <i class="ph ph-check-circle text-green-500 text-xl mr-3"></i>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <livewire:admin-company-table />
</div>
@endsection
