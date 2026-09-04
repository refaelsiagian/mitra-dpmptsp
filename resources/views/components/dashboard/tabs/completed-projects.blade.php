<?php
use Livewire\Component;

new class extends Component {

    public function with()
    {
        $company = auth()->user()->company;
        $isUMKM = $company->isUMKM();
        
        $closedProjects = $company->projects()
            ->withCount('proposals')
            ->withCount(['proposals as accepted_proposals_count' => function($q) {
                $q->where('status', 'accepted');
            }])
            ->with(['proposals' => function($q) {
                $q->where('status', 'accepted')->with('company');
            }])
            ->where('status', 'closed')->latest()->get();
            
        return [
            
            'isUMKM' => $isUMKM,'closedProjects' => $closedProjects
        ];
    }

    public function placeholder()
    {
        return view('components.dashboard.tabs.skeleton');
    }
};
?>

<div wire:key="dashboard-completed">
    @if($closedProjects->count() > 0)
        <div class="space-y-4">
            @foreach($closedProjects as $project)
                @php
                    $theme = match($project->type) {
                        'konstruksi' => [
                            'badgeBg' => 'bg-blue-50', 'badgeText' => 'text-blue-700', 'badgeBorder' => 'border-blue-200', 'label' => 'Konstruksi',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>'
                        ],
                        'subkontrak' => [
                            'badgeBg' => 'bg-purple-50', 'badgeText' => 'text-purple-700', 'badgeBorder' => 'border-purple-200', 'label' => 'Subkontrak',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>'
                        ],
                        'kso' => [
                            'badgeBg' => 'bg-teal-50', 'badgeText' => 'text-teal-700', 'badgeBorder' => 'border-teal-200', 'label' => 'Kerja Sama Operasional (KSO)',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
                        ],
                        'rantai_pasok' => [
                            'badgeBg' => 'bg-amber-50', 'badgeText' => 'text-amber-800', 'badgeBorder' => 'border-amber-200', 'label' => 'Rantai Pasok',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 18H3c-.6 0-1-.4-1-1V7c0-.6.4-1 1-1h10c.6 0 1 .4 1 1v11"/><path d="M14 9h4l4 4v5c0 .6-.4 1-1 1h-2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>'
                        ],
                        'outsourcing' => [
                            'badgeBg' => 'bg-indigo-50', 'badgeText' => 'text-indigo-700', 'badgeBorder' => 'border-indigo-200', 'label' => 'Penyumberluaran (Outsourcing)',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>'
                        ],
                        'distribusi' => [
                            'badgeBg' => 'bg-cyan-50', 'badgeText' => 'text-cyan-800', 'badgeBorder' => 'border-cyan-200', 'label' => 'Distribusi & Keagenan',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/></svg>'
                        ],
                        'perdagangan' => [
                            'badgeBg' => 'bg-rose-50', 'badgeText' => 'text-rose-700', 'badgeBorder' => 'border-rose-200', 'label' => 'Perdagangan Umum',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>'
                        ],
                        default => [
                            'badgeBg' => 'bg-slate-50', 'badgeText' => 'text-slate-700', 'badgeBorder' => 'border-slate-200', 'label' => ucfirst($project->type),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>'
                        ]
                    };
                @endphp
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group">
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-3 flex-wrap">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] sm:text-xs font-bold border {{ $theme['badgeBg'] }} {{ $theme['badgeText'] }} {{ $theme['badgeBorder'] }}">
                                    {!! $theme['icon'] !!}
                                    <span class="tracking-wide">{{ $theme['label'] }}</span>
                                </div>
                                @if(!$project->is_public)
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] sm:text-xs font-bold border bg-slate-200 text-slate-600 border-slate-300" title="Proyek ini disembunyikan dari profil publik Anda">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                                        Privat (Tersembunyi)
                                    </div>
                                @endif
                                <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">Selesai: {{ $project->updated_at->format('d M Y') }}</span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a>
                            </h3>
                            <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ Str::limit($project->description, 150) }}</p>
                            
                            <div class="flex items-center gap-3">
                                <a href="{{ route('projects.show', $project->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition-colors shadow-sm">
                                    Lihat Detail Proyek
                                </a>

                                <!-- Toggle Visibility Form -->
                                @if($project->is_public)
                                    <div x-data="{ showHideModal: false }">
                                        <button type="button" @click="showHideModal = true" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition-colors shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                                            Sembunyikan
                                        </button>

                                        <!-- Hide Modal -->
                                        <x-modal.confirm 
                                            showProperty="showHideModal" 
                                            title="Sembunyikan Proyek?"
                                            iconBgClass="bg-slate-100"
                                            iconTextClass="text-slate-600">
                                            <x-slot:icon>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-600"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                                            </x-slot:icon>
                                            <p class="text-left">Proyek <span class="font-bold">"{{ $project->title }}"</span> tidak akan lagi ditampilkan di profil publik Anda. Namun, data dan riwayat kemitraan akan tetap tersimpan di dashboard ini.</p>
                                            
                                            <x-slot:actions>
                                                <form action="{{ route('projects.toggle-visibility', $project->id) }}" method="POST" class="m-0 w-full sm:w-auto">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="w-full px-5 py-2.5 text-sm font-bold text-white bg-slate-800 hover:bg-slate-900 rounded-xl transition-colors shadow-sm">
                                                        Ya, Sembunyikan
                                                    </button>
                                                </form>
                                            </x-slot:actions>
                                        </x-modal.confirm>
                                    </div>
                                @else
                                    <form action="{{ route('projects.toggle-visibility', $project->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-50 border border-blue-200 hover:bg-blue-100 text-blue-700 text-xs font-bold rounded-lg transition-colors shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                            Tampilkan di Profil
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Selected Partners (Mitra Terpilih) -->
                        <div class="w-full md:w-1/3 bg-white border border-slate-200 rounded-xl p-4 shrink-0">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                                Mitra Terpilih
                            </h4>
                            @if($project->proposals && $project->proposals->where('status', 'accepted')->count() > 0)
                                <div class="space-y-3">
                                    @foreach($project->proposals->where('status', 'accepted') as $proposal)
                                        <div class="flex items-center justify-between p-2 -mx-2 rounded-lg hover:bg-slate-50 transition-colors group/partner">
                                            <a href="{{ route('vendor.show', $proposal->company->id) }}" class="flex items-center gap-3 w-full overflow-hidden">
                                                @if($proposal->company->logo)
                                                    <img src="{{ Storage::url($proposal->company->logo) }}" alt="{{ $proposal->company->name }}" class="w-8 h-8 rounded-full object-cover border border-slate-200 shadow-sm shrink-0">
                                                @else
                                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs border border-slate-200 shrink-0 shadow-sm">
                                                        {{ substr($proposal->company->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div class="overflow-hidden">
                                                    <p class="text-sm font-bold text-slate-900 truncate group-hover/partner:text-blue-600 transition-colors">{{ $proposal->company->name }}</p>
                                                    <p class="text-xs text-slate-500 truncate">{{ $proposal->company->kblis->first()->description ?? 'Mitra Usaha' }}</p>
                                                </div>
                                            </a>
                                            <a wire:navigate href="{{ route('proposals.show', $proposal->id) }}" class="shrink-0 p-1.5 text-blue-600 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors ml-2" title="Lihat Proposal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-slate-500 italic mt-2">Selesai tanpa kemitraan terjalin via platform.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-10 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <h3 class="text-slate-900 font-bold mb-1">Belum ada Proyek Selesai</h3>
            <p class="text-slate-500 text-sm">Proyek yang telah Anda selesaikan atau tutup akan muncul di sini sebagai portofolio.</p>
        </div>
    @endif
</div>