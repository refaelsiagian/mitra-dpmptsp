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

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Nama Perusahaan</th>
                        <th class="px-6 py-4 font-semibold">Jenis Pelaku Usaha</th>
                        <th class="px-6 py-4 font-semibold">NIB</th>
                        <th class="px-6 py-4 font-semibold">Tanggal Daftar</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($companies as $company)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $company->name }}</div>
                                <div class="text-xs text-slate-500">{{ $company->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ ucwords(str_replace('-', ' ', $company->pelaku_usaha_type)) }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-700">
                                {{ $company->nib_number }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $company->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($company->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Menunggu
                                    </span>
                                @elseif($company->status === 'verified')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Terverifikasi
                                    </span>
                                @elseif($company->status === 'rejected')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Perlu Revisi
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.review', $company->id) }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white rounded text-sm font-medium transition-colors">
                                    <i class="ph ph-magnifying-glass"></i> Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="ph ph-folder-open text-4xl text-slate-300 mb-3"></i>
                                    <p>Belum ada perusahaan yang mendaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
