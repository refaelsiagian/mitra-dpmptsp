@extends('layouts.dashboard')

@section('content')
@php
    $isSenderUB = in_array(strtolower($proposal->company->skala_usaha ?? ''), ['besar']);
    $isProjectUB = in_array(strtolower($proposal->project->company->skala_usaha ?? ''), ['besar']);
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

<div class="max-w-5xl mx-auto pb-10" x-data="{ showNegotiationModal: false, showAcceptModal: false, showRejectModal: false }">
    <div class="pt-4 mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Detail {{ $isKetertarikan ? 'Ketertarikan' : 'Proposal' }}</h1>
            <p class="text-slate-500 text-sm mt-1">
                Dikirim pada: <span class="font-semibold text-slate-700">{{ $proposal->created_at->format('d M Y, H:i') }}</span>
            </p>
        </div>
        <a wire:navigate href="{{ url()->previous() }}" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl text-sm hover:bg-slate-50 transition-colors shadow-sm">
            Kembali
        </a>
    </div>

    <!-- Status Banner -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm mb-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
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
        <div class="flex flex-col md:flex-row flex-wrap items-stretch md:items-center gap-3 mt-2 md:mt-0 w-full md:w-auto">
            @if(in_array($proposal->status, ['reviewed', 'negotiating']))
                @if($proposal->status === 'negotiating')
                <button type="button" @click="showAcceptModal = true" class="w-full md:w-auto justify-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold transition-colors shadow-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Terima
                </button>
                @endif

                <button type="button" @click="showRejectModal = true" class="w-full md:w-auto justify-center px-5 py-2.5 bg-white border border-red-200 text-red-600 hover:bg-red-50 rounded-xl text-sm font-bold transition-colors shadow-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    Tolak
                </button>
                
                @if($proposal->status === 'reviewed')
                <button type="button" @click="showNegotiationModal = true" class="w-full md:w-auto justify-center px-5 py-2.5 bg-white border border-blue-200 text-blue-600 hover:bg-blue-50 rounded-xl text-sm font-bold transition-colors shadow-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Mulai Negosiasi
                </button>
                @endif
            @endif
        </div>
        @endif
    </div>

    <!-- Chat Banner -->
    @if(in_array($proposal->status, ['negotiating', 'accepted', 'rejected']))
    <div class="bg-blue-50 border border-blue-200 p-4 md:p-5 rounded-2xl shadow-sm mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="w-10 h-10 shrink-0 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-blue-900 text-sm md:text-base">
                    {{ $proposal->status === 'negotiating' ? 'Ruang Negosiasi Aktif' : 'Riwayat Negosiasi' }}
                </h3>
                <p class="text-blue-700 text-xs md:text-sm mt-0.5 leading-snug">
                    {{ $proposal->status === 'negotiating' ? 'Diskusikan detail kesepakatan secara langsung di sini.' : 'Lihat kembali arsip percakapan untuk proposal ini.' }}
                </p>
            </div>
        </div>
        <a href="{{ route('messages.index', ['proposal_id' => $proposal->id]) }}" wire:navigate class="w-full md:w-auto justify-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold transition-colors shadow-sm flex items-center gap-2 shrink-0">
            Buka Chat
        </a>
    </div>
    @endif

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
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm" x-data="{ portfolioModalOpen: false, selectedPortfolio: null, lightboxOpen: false, lightboxImage: '' }">
                <h3 class="text-lg font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">Portofolio yang Ditonjolkan</h3>
                
                <!-- Thumbnail Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($proposal->pinned_portfolios as $portfolioId)
                        @php 
                            $portfolio = \App\Models\CompanyPortfolio::find($portfolioId); 
                        @endphp
                        @if($portfolio)
                            @php $imagePath = $portfolio->image_path ?? $portfolio->image; @endphp
                            <div @click="selectedPortfolio = {{ $portfolio->id }}; portfolioModalOpen = true" class="aspect-video bg-slate-100 rounded-xl overflow-hidden cursor-pointer group relative border border-slate-200 shadow-sm">
                                @if($imagePath)
                                    <img src="{{ Storage::url($imagePath) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                    </div>
                                @endif
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                                    <span class="text-white font-bold text-sm truncate">{{ $portfolio->title }}</span>
                                    <span class="text-white/80 text-xs mt-1 flex items-center gap-1 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg>
                                        Buka Detail
                                    </span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Portfolio Detail Modals -->
                @foreach($proposal->pinned_portfolios as $portfolioId)
                    @php 
                        $portfolio = \App\Models\CompanyPortfolio::find($portfolioId); 
                    @endphp
                    @if($portfolio)
                    <div x-show="portfolioModalOpen && selectedPortfolio === {{ $portfolio->id }}" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" style="display: none;">
                        <!-- Backdrop -->
                        <div x-show="portfolioModalOpen && selectedPortfolio === {{ $portfolio->id }}" x-transition.opacity @click="portfolioModalOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
                        
                        <!-- Modal Content -->
                        <div x-show="portfolioModalOpen && selectedPortfolio === {{ $portfolio->id }}" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             class="relative bg-white rounded-2xl w-full max-w-3xl max-h-[90vh] flex flex-col shadow-2xl overflow-hidden z-10">
                             
                             <!-- Close Button -->
                             <button @click="portfolioModalOpen = false" class="absolute top-4 right-4 z-20 bg-black/50 text-white rounded-full p-2 hover:bg-black/70 transition-colors border border-white/20 shadow-sm backdrop-blur-sm">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                             </button>

                             <!-- Scrollable Area -->
                             <div class="overflow-y-auto custom-scrollbar">
                                 <!-- Cover Image -->
                                 <div class="w-full h-64 sm:h-80 bg-slate-100 relative group cursor-pointer" @click="lightboxImage = '{{ Storage::url($portfolio->image_path ?? $portfolio->image) }}'; lightboxOpen = true">
                                     @php $imagePath = $portfolio->image_path ?? $portfolio->image; @endphp
                                     @if($imagePath)
                                         <img src="{{ Storage::url($imagePath) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover">
                                         <!-- Hover Overlay for Image -->
                                         <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                             <div class="bg-white/20 backdrop-blur-sm p-3 rounded-full text-white shadow-sm border border-white/30">
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg>
                                             </div>
                                         </div>
                                     @else
                                         <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 gap-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                            <span class="text-sm font-medium">Tidak ada gambar</span>
                                         </div>
                                     @endif
                                 </div>
                                 
                                 <!-- Text Content -->
                                 <div class="p-6 sm:p-8">
                                     <h3 class="text-2xl font-bold text-slate-900 mb-4">{{ $portfolio->title }}</h3>
                                     
                                     @if($portfolio->description)
                                     <div class="text-slate-600 text-base leading-relaxed whitespace-pre-wrap">{!! nl2br(e($portfolio->description)) !!}</div>
                                     @endif
                                     
                                     <div class="mt-8 pt-6 border-t border-slate-100 flex items-center text-sm text-slate-500 font-medium">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-slate-400"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                         Ditambahkan pada {{ $portfolio->created_at->format('d M Y') }}
                                     </div>
                                 </div>
                             </div>
                        </div>
                    </div>
                    @endif
                @endforeach

                <!-- Lightbox Modal (Full Image) -->
                <div x-show="lightboxOpen" class="fixed inset-0 z-[110] flex items-center justify-center bg-black/90 p-4" x-transition.opacity style="display: none;">
                    <button @click="lightboxOpen = false" class="absolute top-6 right-6 text-white/70 hover:text-white p-2 transition-colors z-20">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                    <img :src="lightboxImage" class="max-w-full max-h-[90vh] object-contain rounded-xl shadow-2xl relative z-10" @click.away="lightboxOpen = false">
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

    <!-- Negotiation Modal -->
    <x-modal.confirm 
        showProperty="showNegotiationModal" 
        title="Mulai Negosiasi"
        iconBgClass="bg-blue-100"
        iconTextClass="text-blue-600">
        <x-slot:icon>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </x-slot:icon>
        
        <p class="mb-2">Dengan beralih ke <strong>Tahap Negosiasi</strong>, Anda diharapkan untuk menghubungi pihak pengirim secara mandiri di luar platform ini (misal via WhatsApp atau Email) menggunakan informasi kontak yang tersedia di profil mereka.</p>
        <p>Apakah Anda siap untuk melanjutkan?</p>
        
        <x-slot:actions>
            <form action="{{ route('proposals.updateStatus', $proposal->id) }}" method="POST" class="m-0">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="negotiating">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-sm">
                    Lanjutkan & Hubungi
                </button>
            </form>
        </x-slot:actions>
    </x-modal.confirm>

    <!-- Accept Modal -->
    <x-modal.confirm 
        showProperty="showAcceptModal" 
        title="Terima Tawaran"
        iconBgClass="bg-emerald-100"
        iconTextClass="text-emerald-600">
        <x-slot:icon>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </x-slot:icon>
        
        <p class="mb-2">Dengan mengganti status menjadi <strong>Diterima</strong>, ini diartikan bahwa sudah terjadi kesepakatan antara kedua belah pihak di luar platform.</p>
        <p>Lanjutkan untuk menandai tawaran ini sebagai Diterima?</p>
        
        <x-slot:actions>
            <form action="{{ route('proposals.updateStatus', $proposal->id) }}" method="POST" class="m-0">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="accepted">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition-colors shadow-sm">
                    Ya, Terima Tawaran
                </button>
            </form>
        </x-slot:actions>
    </x-modal.confirm>

    <!-- Reject Modal -->
    <x-modal.confirm 
        showProperty="showRejectModal" 
        title="Tolak Tawaran"
        iconBgClass="bg-red-100"
        iconTextClass="text-red-600">
        <x-slot:icon>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </x-slot:icon>
        
        <p class="mb-2">Apakah Anda yakin ingin menolak tawaran ini?</p>
        <p class="font-medium">Tindakan ini tidak dapat dibatalkan dan status akan diubah menjadi Ditolak secara permanen.</p>
        
        <x-slot:actions>
            <form action="{{ route('proposals.updateStatus', $proposal->id) }}" method="POST" class="m-0">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="rejected">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors shadow-sm">
                    Ya, Tolak Tawaran
                </button>
            </form>
        </x-slot:actions>
    </x-modal.confirm>
</div>

@endsection
