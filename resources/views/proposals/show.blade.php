@extends('layouts.dashboard')

@section('content')
@php
    $isSenderUB = in_array(strtolower($proposal->company->skala_usaha ?? ''), ['menengah', 'besar']);
    $isProjectUB = in_array(strtolower($proposal->project->company->skala_usaha ?? ''), ['menengah', 'besar']);
    $isKetertarikan = $isSenderUB && !$isProjectUB;
    
    $statusColor = match($proposal->status) {
        'pending' => 'bg-amber-100 text-amber-700',
        'reviewed' => 'bg-blue-100 text-blue-700',
        'negotiating' => 'bg-purple-100 text-purple-700',
        'accepted' => 'bg-emerald-100 text-emerald-700',
        'rejected' => 'bg-red-100 text-red-700',
        default => 'bg-slate-100 text-slate-700',
    };
    
    $statusLabel = match($proposal->status) {
        'pending' => 'Menunggu Review',
        'reviewed' => 'Sedang Direview',
        'negotiating' => 'Tahap Negosiasi',
        'accepted' => 'Diterima',
        'rejected' => 'Ditolak',
        default => 'Tidak Diketahui',
    };
@endphp

<div class="max-w-5xl mx-auto pb-10">
    <div class="pt-4 mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Detail {{ $isKetertarikan ? 'Ketertarikan' : 'Proposal' }}</h1>
            <p class="text-slate-500 text-sm mt-1">
                Dikirim pada: <span class="font-semibold text-slate-700">{{ $proposal->created_at->format('d M Y, H:i') }}</span>
            </p>
        </div>
        <a href="{{ url()->previous() }}" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl text-sm hover:bg-slate-50 transition-colors shadow-sm">
            Kembali
        </a>
    </div>

    <!-- Status Banner -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm mb-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl {{ str_replace('text', 'bg', $statusColor) }} bg-opacity-20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ explode(' ', $statusColor)[1] ?? 'text-slate-700' }}"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-0.5">Status Saat Ini</p>
                <p class="text-lg font-black text-slate-900">{{ $statusLabel }}</p>
            </div>
        </div>
        
        @if(auth()->user()->company->id === $proposal->project->company_id)
        <!-- Actions for Project Owner -->
        <div class="flex items-center gap-2">
            <form action="{{ route('proposals.updateStatus', $proposal->id) }}" method="POST">
                @csrf
                @method('PUT')
                <select name="status" onchange="this.form.submit()" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="pending" {{ $proposal->status == 'pending' ? 'selected' : '' }}>Menunggu Review</option>
                    <option value="reviewed" {{ $proposal->status == 'reviewed' ? 'selected' : '' }}>Tandai Direview</option>
                    <option value="negotiating" {{ $proposal->status == 'negotiating' ? 'selected' : '' }}>Tahap Negosiasi</option>
                    <option value="accepted" {{ $proposal->status == 'accepted' ? 'selected' : '' }}>Terima</option>
                    <option value="rejected" {{ $proposal->status == 'rejected' ? 'selected' : '' }}>Tolak</option>
                </select>
            </form>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8">
        <div class="lg:col-span-3 space-y-6 lg:space-y-8 flex flex-col">
            <!-- Cover Letter -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex-1">
                <h3 class="text-lg font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">Pesan Pengantar</h3>
                <div class="prose prose-slate max-w-none text-slate-600">
                    {!! nl2br(e($proposal->cover_letter)) !!}
                </div>
            </div>

            <!-- Pinned Portfolios -->
            @if(is_array($proposal->pinned_portfolios) && count($proposal->pinned_portfolios) > 0)
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">Portofolio yang Ditonjolkan</h3>
                <div class="space-y-4">
                    @foreach($proposal->pinned_portfolios as $portfolioId)
                        @php 
                            $portfolio = \App\Models\CompanyPortfolio::find($portfolioId); 
                        @endphp
                        @if($portfolio)
                        <div class="flex items-start gap-4 p-4 rounded-xl border border-slate-100 bg-slate-50">
                            <div class="w-16 h-16 bg-slate-200 rounded-lg x-shrink-0 flex items-center justify-center overflow-hidden">
                                @if($portfolio->image)
                                    <img src="{{ Storage::url($portfolio->image) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">{{ $portfolio->title }}</h4>
                                <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ $portfolio->description }}</p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="lg:col-span-2 space-y-6 lg:space-y-8">
            <!-- Project / Target Info -->
            <div class="bg-slate-900 p-6 rounded-2xl shadow-sm text-white">
                <h3 class="text-sm font-medium text-slate-400 mb-1">Target Proyek:</h3>
                <a href="{{ route('projects.show', $proposal->project->id) }}" class="text-lg font-bold text-white hover:text-blue-400 transition-colors block mb-4">
                    {{ $proposal->project->title }}
                </a>
                
                <h3 class="text-sm font-medium text-slate-400 mb-1">Penyelenggara:</h3>
                <p class="font-semibold text-slate-200 mb-6">{{ $proposal->project->company->name ?? 'Tidak Diketahui' }}</p>

                <div class="pt-4 border-t border-slate-800">
                    <h3 class="text-sm font-medium text-slate-400 mb-1">{{ $isKetertarikan ? 'Anggaran Diajukan' : 'Nilai Penawaran' }}</h3>
                    <p class="text-xl font-black text-white">
                        {{ $proposal->estimated_value ? 'Rp ' . number_format($proposal->estimated_value, 0, ',', '.') : 'TBA / Sesuai Kesepakatan' }}
                    </p>
                </div>
            </div>
            
            <!-- Sender Info -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="text-sm font-medium text-slate-500 mb-1">Pengirim:</h3>
                <p class="font-bold text-slate-900 mb-4">{{ $proposal->company->name }}</p>
                
                @if($proposal->attachment)
                <div class="pt-4 border-t border-slate-100">
                    <h3 class="text-sm font-medium text-slate-500 mb-3">Dokumen Lampiran</h3>
                    <a href="{{ Storage::url($proposal->attachment) }}" target="_blank" class="w-full py-3 px-4 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold rounded-xl transition-colors flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                        Unduh Berkas
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
