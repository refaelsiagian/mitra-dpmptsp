<?php
use Livewire\Component;

new class extends Component {
    public $isUMKM = false;
    
    public function with()
    {
        $company = auth()->user()->company;
        $this->isUMKM = in_array(strtolower($company->skala_usaha ?? ''), ['mikro', 'kecil']);
        
        $receivedInvitations = collect();
        $sentInvitations = collect();
        
        if ($this->isUMKM) {
            $receivedInvitations = $company->receivedInvitations()->with(['project', 'invitingCompany'])->latest()->get();
        } else {
            $sentInvitations = $company->sentInvitations()->with(['project', 'invitedCompany'])->latest()->get();
        }
            
        return [
            'receivedInvitations' => $receivedInvitations,
            'sentInvitations' => $sentInvitations,
        ];
    }

    public function placeholder()
    {
        return view('components.dashboard.tabs.skeleton');
    }
};
?>

<div>
    @if($isUMKM)
        <!-- UMKM View: Undangan Masuk -->
        @forelse($receivedInvitations as $invitation)
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group bg-white mb-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        @if($invitation->status === 'pending')
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-700 tracking-wide uppercase">Undangan Baru</span>
                        @elseif($invitation->status === 'accepted')
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-700 tracking-wide uppercase">Proposal Dikirim</span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-red-100 text-red-700 tracking-wide uppercase">Ditolak</span>
                        @endif
                        <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">{{ $invitation->created_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors block mb-1">
                        <a href="{{ route('vendor.show', $invitation->invitingCompany->id) }}">{{ $invitation->invitingCompany->name }}</a>
                    </h3>
                    <p class="text-sm text-slate-500 mb-2">Mengundang Anda ke proyek: <a href="{{ route('projects.show', $invitation->project->id) }}" class="font-semibold text-blue-600 hover:underline">{{ $invitation->project->title }}</a></p>
                </div>
                
                <div class="flex items-center gap-3">
                    @if($invitation->status === 'pending')
                        <div x-data="{ showRejectModal: false }">
                            <button type="button" @click="showRejectModal = true" class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-bold rounded-lg transition-colors whitespace-nowrap">
                                Tolak
                            </button>
                            <!-- Reject Modal -->
                            <x-modal.confirm 
                                showProperty="showRejectModal" 
                                title="Tolak Undangan?"
                                iconBgClass="bg-red-100"
                                iconTextClass="text-red-600">
                                <x-slot:icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                </x-slot:icon>
                                
                                <p>Apakah Anda yakin ingin menolak tawaran proyek <span class="font-bold">"{{ $invitation->project->title }}"</span> dari {{ $invitation->invitingCompany->name }}?</p>
                                
                                <x-slot:actions>
                                    <form action="{{ route('invitations.update', $invitation->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="w-full sm:w-auto px-5 py-2.5 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors shadow-sm">
                                            Ya, Tolak
                                        </button>
                                    </form>
                                </x-slot:actions>
                            </x-modal.confirm>
                        </div>
                        <a href="{{ route('proposals.create', $invitation->project->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap">
                            Buat Penawaran
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-10 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                </div>
                <h3 class="text-slate-900 font-bold mb-1">Belum ada Undangan Masuk</h3>
                <p class="text-slate-500 text-sm">Undangan langsung dari Usaha Besar akan muncul di sini.</p>
            </div>
        @endforelse
    @else
        <!-- UB View: Undangan Terkirim -->
        @forelse($sentInvitations as $invitation)
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group bg-white mb-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        @if($invitation->status === 'pending')
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-700 tracking-wide uppercase">Menunggu Respons</span>
                        @elseif($invitation->status === 'accepted')
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-700 tracking-wide uppercase">Proposal Dikirim</span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-red-100 text-red-700 tracking-wide uppercase">Ditolak</span>
                        @endif
                        <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">Diundang: {{ $invitation->created_at->format('d M Y') }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors block mb-1">
                        <a href="{{ route('vendor.show', $invitation->invitedCompany->id) }}">{{ $invitation->invitedCompany->name }}</a>
                    </h3>
                    <p class="text-sm text-slate-500 mb-2">Diundang ke proyek: <a href="{{ route('projects.show', $invitation->project->id) }}" class="font-semibold text-blue-600 hover:underline">{{ $invitation->project->title }}</a></p>
                </div>
            </div>
        @empty
            <div class="text-center py-10 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                </div>
                <h3 class="text-slate-900 font-bold mb-1">Belum ada Undangan Terkirim</h3>
                <p class="text-slate-500 text-sm">Anda belum mengundang UMKM manapun ke proyek Anda.</p>
            </div>
        @endforelse
    @endif
</div>
