<?php
use Livewire\Component;

new class extends Component {
    public function with()
    {
        $company = auth()->user()->company;
        $draftProjects = $company->projects()->where('status', 'draft')->latest()->get();
            
        return [
            'draftProjects' => $draftProjects
        ];
    }

    public function placeholder()
    {
        return view('components.dashboard.tabs.skeleton');
    }
};
?>

<div wire:key="dashboard-drafts">
    @forelse($draftProjects as $draft)
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 border-dashed hover:border-slate-300 transition-colors bg-slate-50/50 mb-4">
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-200 text-slate-600 tracking-wide uppercase">Draft</span>
                <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">Diedit terakhir: {{ $draft->updated_at->diffForHumans() }}</span>
            </div>
            <p class="text-lg font-bold text-slate-900 block mb-1">
                {{ $draft->title ?: 'Tanpa Judul' }}
            </p>
            <p class="text-sm text-slate-500 line-clamp-1">{{ Str::limit($draft->description, 100) ?: 'Belum ada deskripsi.' }}</p>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- Form Delete -->
            <div x-data="{ showDeleteDraftModal: false }">
                <button type="button" @click="showDeleteDraftModal = true" class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 text-sm font-bold rounded-lg transition-colors whitespace-nowrap">
                    Hapus Draft
                </button>

                <!-- Modal Hapus Draft -->
                <x-modal.confirm 
                    showProperty="showDeleteDraftModal" 
                    title="Hapus Draf Ini?">
                    <p class="text-left">Apakah Anda yakin ingin menghapus draf <span class="font-bold">"{{ $draft->title ?: 'Tanpa Judul' }}"</span>? Tindakan ini tidak dapat dibatalkan.</p>
                    
                    <x-slot:actions>
                        <form action="{{ route('projects.destroy', $draft->id) }}" method="POST" class="m-0 w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-5 py-2.5 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors shadow-sm">
                                Ya, Hapus
                            </button>
                        </form>
                    </x-slot:actions>
                </x-modal.confirm>
            </div>
            <a wire:navigate href="{{ route('projects.edit', $draft->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                Lanjutkan Edit
            </a>
        </div>
    </div>
    @empty
    <div class="text-center py-10 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10.4 12.6a2 2 0 1 1 3 3L8 21l-4 1 1-4Z"/><path d="M18 18h-2.5c-.83 0-1.5-.67-1.5-1.5V14"/><path d="M12 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6Z"/></svg>
        </div>
        <h3 class="text-slate-900 font-bold mb-1">Tidak ada draf</h3>
        <p class="text-slate-500 text-sm">Anda tidak memiliki draf penawaran atau proyek yang tersimpan.</p>
    </div>
    @endforelse
</div>
