@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto pb-10">
    
    <!-- Back Button -->
    <a href="{{ route('vendor.show', ['company' => $project->company_id, 'tab' => 'projects']) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors mb-5 group">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
        <span>Kembali ke Profil Perusahaan</span>
    </a>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Left Column (col-span-2) -->
        <div class="md:col-span-2 space-y-6">
            
            <!-- Header Section -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                    @php
                        $badgeClass = 'bg-slate-50 text-slate-700 border-slate-200';
                        $badgeText = ucfirst($project->type);
                        $badgeIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>';

                        switch($project->type) {
                            case 'subkontrak':
                                $badgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
                                $badgeText = 'Subkontrak';
                                $badgeIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>';
                                break;
                            case 'rantai_pasok':
                                $badgeClass = 'bg-indigo-50 text-indigo-700 border-indigo-200';
                                $badgeText = 'Rantai Pasok';
                                $badgeIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 17h4V5H2v12h3"/><path d="M20 17h2v-3.34a4 4 0 0 0-1.17-2.83L19 9h-5"/><path d="M14 17h1"/></svg>';
                                break;
                            case 'outsourcing':
                                $badgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
                                $badgeText = 'Penyumberluaran (Outsourcing)';
                                $badgeIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>';
                                break;
                            case 'konstruksi':
                                $badgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                                $badgeText = 'Konstruksi';
                                $badgeIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 22h20"/><path d="M17 22v-5a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v5"/><path d="M12 15V2"/></svg>';
                                break;
                            case 'kso':
                                $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                $badgeText = 'Kerja Sama Operasional (KSO)';
                                $badgeIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 21h8a2 2 0 0 0 2-2v-4.1a2 2 0 0 0-.59-1.41L12 8 6.59 13.41A2 2 0 0 0 6 14.9V19a2 2 0 0 0 2 2Z"/></svg>';
                                break;
                            case 'perdagangan':
                                $badgeClass = 'bg-purple-50 text-purple-700 border-purple-200';
                                $badgeText = 'Perdagangan Umum';
                                $badgeIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>';
                                break;
                            case 'distribusi':
                                $badgeClass = 'bg-teal-50 text-teal-700 border-teal-200';
                                $badgeText = 'Distribusi & Keagenan';
                                $badgeIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>';
                                break;
                        }
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-bold border {!! $badgeClass !!}">
                        {!! $badgeIcon !!}
                        {{ $badgeText }}
                    </span>
                
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 mb-2 leading-tight">{{ $project->title }}</h1>
                
                <a href="{{ route('vendor.show', $project->company_id) }}" class="text-blue-600 font-semibold hover:underline text-lg flex items-center gap-1.5 mb-6 inline-flex">
                    {{ $project->company->name }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                </a>
                
                <div class="flex flex-wrap gap-2 pt-4 border-t border-slate-100">
                    @if($project->location)
                        <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">
                            Lokasi: {{ $project->location }}
                        </span>
                    @endif
                    @if($project->start_date)
                        <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">
                            Target Mulai: {{ $project->start_date->format('d M Y') }}
                        </span>
                    @endif
                    @if($project->project_end_date)
                        <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">
                            Target Selesai: {{ $project->project_end_date->format('d M Y') }}
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Deskripsi -->
            @if($project->description)
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">
                    Deskripsi Kemitraan
                </h2>
                <div class="text-slate-600 leading-relaxed whitespace-pre-wrap">{{ $project->description }}</div>
            </div>
            @endif

            <!-- Ruang Lingkup -->
            @if($project->ruang_lingkup)
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">
                    Ruang Lingkup Pekerjaan / Kebutuhan
                </h2>
                <div class="text-slate-600 leading-relaxed whitespace-pre-wrap">{{ $project->ruang_lingkup }}</div>
            </div>
            @endif

            <!-- Dynamic Lists (Offerings & Requirements) -->
            @if($project->offerings && count($project->offerings) > 0)
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <div class="p-1.5 bg-emerald-100 text-emerald-600 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10.5V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.5"/><path d="m9 11 3 3L22 4"/></svg>
                    </div>
                    @if($project->type === 'kso') Apa yang Kami Miliki
                    @elseif($project->type === 'perdagangan') Katalog Produk / Jasa Kami
                    @elseif($project->type === 'distribusi') Fasilitas Distribusi / Dukungan Keagenan
                    @else Disediakan Pemberi Tugas @endif
                </h2>
                <ul class="space-y-3">
                    @foreach($project->offerings as $item)
                        <li class="flex items-start gap-3">
                            <div class="mt-0.5 p-1 bg-emerald-50 rounded-full text-emerald-600 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <span class="text-slate-800 font-medium leading-relaxed">{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if($project->requirements && count($project->requirements) > 0)
            <div class="bg-blue-50/50 p-6 md:p-8 rounded-2xl border-2 border-dashed border-blue-200">
                <h2 class="text-xl font-bold text-blue-900 mb-4 border-b border-blue-200/50 pb-3 flex items-center gap-2">
                    <div class="p-1.5 bg-blue-100 text-blue-600 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </div>
                    @if($project->type === 'kso') Apa yang Kami Cari (Syarat Mitra)
                    @elseif($project->type === 'perdagangan') Syarat Pembelian / Ketentuan
                    @elseif($project->type === 'distribusi') Syarat Mitra Keagenan / Prinsipal
                    @else Tanggung Jawab Pelaksana @endif
                </h2>
                <ul class="space-y-3">
                    @foreach($project->requirements as $item)
                        <li class="flex items-start gap-3 bg-white p-3 rounded-xl border border-blue-100 shadow-sm">
                            <div class="mt-0.5 p-1 bg-blue-50 rounded-full text-blue-600 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                            </div>
                            <span class="text-slate-800 font-medium leading-relaxed">{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
            
        </div>
        
        <!-- Right Column (col-span-1) -->
        <div class="md:col-span-1">
            <div class="sticky top-6 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                
                @if($project->estimated_value)
                <div class="text-center mb-6">
                    <p class="text-sm font-medium text-slate-500 mb-1">
                        Nilai Anggaran / Kontrak
                    </p>
                    <h3 class="text-2xl font-bold text-emerald-600 mb-2">Rp {{ number_format($project->estimated_value, 0, ',', '.') }}</h3>
                    
                    @if(isset($project->metrics['is_negotiable']) && $project->metrics['is_negotiable'])
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 14V2"/><path d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22h0a3.13 3.13 0 0 1-3-3.88Z"/></svg>
                        Bisa Didiskusikan
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold border border-slate-200">
                        Fix / Tetap
                    </span>
                    @endif
                </div>
                @endif
                
                @if($project->end_date)
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center justify-center gap-3 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-600"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <div>
                        <p class="text-sm text-amber-800 font-medium leading-none">Batas Penawaran</p>
                        <p class="text-lg font-bold text-amber-900 mt-1 leading-none">{{ \Carbon\Carbon::parse($project->end_date)->diffForHumans() }}</p>
                    </div>
                </div>
                @endif
                
                <!-- Calls to Action -->
                @if(auth()->user() && auth()->user()->company && auth()->user()->company->id === $project->company_id)
                    <!-- Owner View -->
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('projects.edit', $project->id) }}" class="w-full py-3 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold rounded-xl transition-colors shadow-sm flex justify-center items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                            Edit Proyek
                        </a>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-3 bg-white hover:bg-red-50 border border-red-200 text-red-600 font-bold rounded-xl transition-colors shadow-sm flex justify-center items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                Hapus Proyek
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Viewer View -->
                    <div class="flex flex-col gap-3">
                        <button class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-blue-600/20 flex justify-center items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9 22 2z"/></svg>
                            Ajukan Penawaran
                        </button>
                        <button class="w-full py-3.5 bg-white hover:bg-slate-50 text-slate-700 font-bold border border-slate-300 rounded-xl transition-colors flex justify-center items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            Kirim Pesan
                        </button>
                    </div>
                @endif
                
            </div>
        </div>
        
    </div>
</div>
@endsection
