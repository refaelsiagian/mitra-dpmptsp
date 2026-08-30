<?php

use Livewire\Component;

new class extends Component {
    public $isUMKM = false;
    public $search = '';
    public $status = 'pending';
    
    // Custom event listener for 'filter-proposals-masuk'
    protected $listeners = ['filter-proposals-masuk' => 'setSearch'];
    
    public function setSearch($search = '')
    {
        $this->search = is_array($search) ? ($search['search'] ?? '') : $search;
        $this->status = ''; // Reset status filter
    }
    
    public function with()
    {
        $company = auth()->user()->company;
        $this->isUMKM = in_array(strtolower($company->skala_usaha ?? ''), ['mikro', 'kecil']);
        
        $query = \App\Models\Proposal::whereHas('project', function($q) use ($company) {
            $q->where('company_id', $company->id);
        })->with(['project', 'company']);
        
        if ($this->status !== '') {
            $query->where('status', $this->status);
        }
        
        if ($this->search !== '') {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('company', function($q2) use ($searchTerm) {
                    $q2->where('name', 'like', $searchTerm);
                })->orWhereHas('project', function($q2) use ($searchTerm) {
                    $q2->where('title', 'like', $searchTerm);
                });
            });
        }
        
        $receivedProposals = $query->latest()->get();
        
        // Count total for dropdown options
        $allProposals = \App\Models\Proposal::whereHas('project', function($q) use ($company) {
            $q->where('company_id', $company->id);
        })->get();
            
        return [
            'receivedProposals' => $receivedProposals,
            'allProposals' => $allProposals
        ];
    }

    public function placeholder()
    {
        return view('components.dashboard.tabs.skeleton');
    }
};
?>

<div @filter-proposals-masuk.window="$wire.setSearch($event.detail)" x-init="if (window.pendingMasukFilter) { $wire.setSearch({ search: window.pendingMasukFilter }); window.pendingMasukFilter = null; }">
    <!-- Filter & Search Bar -->
    <div class="sticky top-0 z-20 bg-white/95 backdrop-blur-sm -mt-6 pt-6 -mx-6 px-6 pb-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="relative w-full max-w-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input wire:model.live.debounce.300ms="search" id="search-masuk" type="text" placeholder="Cari {{ $isUMKM ? 'ketertarikan' : 'proposal' }} masuk..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
        </div>
        <div class="relative w-auto shrink-0 self-start sm:self-auto z-20" x-data="{ 
            open: false, 
            options: {
                '': 'Semua Status',
                'pending': 'Menunggu Review {{ $allProposals->where('status', 'pending')->count() > 0 ? '('.$allProposals->where('status', 'pending')->count().')' : '' }}',
                'reviewed': 'Sedang Direview {{ $allProposals->where('status', 'reviewed')->count() > 0 ? '('.$allProposals->where('status', 'reviewed')->count().')' : '' }}',
                'negotiating': 'Tahap Negosiasi {{ $allProposals->where('status', 'negotiating')->count() > 0 ? '('.$allProposals->where('status', 'negotiating')->count().')' : '' }}',
                'accepted': 'Diterima',
                'rejected': 'Ditolak'
            }
        }">
            <!-- Hidden actual select for JS -->
            <select wire:model.live="status" id="filter-status-masuk" x-ref="select" class="hidden">
                <option value="">Semua Status</option>
                <option value="pending">Menunggu Review</option>
                <option value="reviewed">Sedang Direview</option>
                <option value="negotiating">Tahap Negosiasi</option>
                <option value="accepted">Diterima</option>
                <option value="rejected">Ditolak</option>
            </select>

            <button type="button" @click="open = !open" @click.away="open = false" class="w-full sm:w-auto min-w-[200px] flex items-center justify-between gap-2 px-4 py-2 bg-white border border-slate-200 hover:border-blue-300 hover:ring-1 hover:ring-blue-100 rounded-xl text-sm transition-all text-left text-slate-700 font-medium shadow-sm">
                <span x-text="options[$wire.status] || 'Semua Status'"></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 class="absolute top-full left-0 sm:left-auto sm:right-0 mt-2 w-56 bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden py-1"
                 style="display: none;">
                <template x-for="(label, key) in options" :key="key">
                    <button type="button" @click="$wire.set('status', key); open = false" class="w-full flex items-center px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600 text-left transition-colors" :class="$wire.status === key ? 'bg-blue-50 text-blue-700 font-semibold' : ''">
                        <span x-text="label"></span>
                        <svg x-show="$wire.status === key" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="ml-auto text-blue-600"><polyline points="20 6 9 17 4 12"/></svg>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <div class="relative min-h-[200px]">
        <!-- Loading Overlay -->
        <div wire:loading class="absolute inset-0 z-10 bg-white/50 backdrop-blur-sm flex items-center justify-center rounded-xl">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        </div>
        
        @forelse($receivedProposals as $proposal)
        @php
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
        <!-- Received Proposal Item -->
        <div class="proposal-masuk-item flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 mb-4 rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group bg-white" data-project-id="{{ $proposal->project_id }}" data-status="{{ $proposal->status }}">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $statusColor }} tracking-wide uppercase">{{ $statusLabel }}</span>
                    @if($proposal->is_invited)
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-indigo-100 text-indigo-700 tracking-wide uppercase flex items-center gap-1 border border-indigo-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                            Jalur Undangan
                        </span>
                    @endif
                    <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">Diterima: {{ $proposal->created_at->format('d M Y') }}</span>
                </div>
                <a href="{{ route('proposals.show', $proposal->id) }}" class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors block mb-1">
                    Dari: {{ $proposal->company->name }}
                </a>
                <p class="text-sm text-slate-500 mb-2">Terkait Proyek/Katalog: <a href="{{ route('projects.show', $proposal->project->id) }}" class="font-semibold text-blue-600 hover:underline">{{ $proposal->project->title }}</a></p>
            </div>
            
            <div class="flex items-center gap-6 md:border-l border-slate-200 md:pl-6">
                <div class="text-center">
                    <p class="text-xs text-slate-400 font-medium mb-0.5">{{ $isUMKM ? 'Anggaran Diajukan' : 'Nilai Penawaran' }}</p>
                    <p class="text-sm font-black text-slate-800">{{ $proposal->estimated_value ? 'Rp ' . number_format($proposal->estimated_value, 0, ',', '.') : 'TBA' }}</p>
                </div>
                <a wire:navigate href="{{ route('proposals.show', $proposal->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap">
                    Lihat & Review
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-10 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <h3 class="text-slate-900 font-bold mb-1">Tidak Ada Hasil</h3>
            <p class="text-slate-500 text-sm">Tidak ada {{ $isUMKM ? 'ketertarikan' : 'proposal' }} yang sesuai dengan filter status atau pencarian Anda.</p>
        </div>
        @endforelse
    </div>
</div>
