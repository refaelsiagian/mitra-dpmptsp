<?php

use Livewire\Component;

new class extends Component {
    public $isUMKM = false;
    public $search = '';
    
    public function with()
    {
        $company = auth()->user()->company;
        $this->isUMKM = in_array(strtolower($company->skala_usaha ?? ''), ['mikro', 'kecil']);
        
        $query = $company->projects()
            ->withCount('proposals')
            ->withCount(['proposals as accepted_proposals_count' => function($q) {
                $q->where('status', 'accepted');
            }])
            ->where('status', 'published');
            
        if ($this->search !== '') {
            $query->where('title', 'like', '%' . $this->search . '%');
        }
            
        $publishedProjects = $query->latest()->get();
            
        return [
            'publishedProjects' => $publishedProjects
        ];
    }

    public function placeholder()
    {
        return view('components.dashboard.tabs.skeleton');
    }
};
?>

<div>
    <!-- Filter & Search Bar -->
    <div class="sticky top-0 z-20 bg-white/95 backdrop-blur-sm -mt-6 pt-6 -mx-6 px-6 pb-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="relative w-full max-w-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input wire:model.live.debounce.300ms="search" id="search-aktif" type="text" placeholder="{{ $isUMKM ? 'Cari judul penawaran/layanan...' : 'Cari judul pengadaan/proyek...' }}" class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
        </div>
    </div>

    <div class="relative min-h-[100px]">
        <!-- Loading Overlay -->
        <div wire:loading class="absolute inset-0 z-10 bg-white/50 backdrop-blur-sm flex items-center justify-center rounded-xl">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        </div>
        
        @forelse($publishedProjects as $project)
        <div class="project-aktif-item mb-4 bg-white">
            <x-dashboard.project-card :project="$project" />
        </div>
        @empty
        <div class="text-center py-10 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 7h10"/><path d="M7 12h10"/><path d="M7 17h10"/></svg>
            </div>
            <h3 class="text-slate-900 font-bold mb-1">
                @if($search !== '')
                    Tidak Ada Hasil
                @else
                    {{ $isUMKM ? 'Belum ada Penawaran' : 'Belum ada Pengadaan' }}
                @endif
            </h3>
            <p class="text-slate-500 text-sm">
                @if($search !== '')
                    Tidak ada proyek yang sesuai dengan pencarian Anda.
                @else
                    {{ $isUMKM ? 'Buat profil layanan/katalog Anda agar mudah ditemukan oleh Usaha Besar.' : 'Terbitkan tender / RFP baru untuk menemukan vendor UMKM.' }}
                @endif
            </p>
        </div>
        @endforelse
    </div>
</div>