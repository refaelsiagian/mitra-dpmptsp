@props(['project'])

<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group bg-white">
    <div class="flex-1">
        <div class="flex items-center gap-2 mb-2">
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
            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $theme['badgeBg'] }} {{ $theme['badgeText'] }} {{ $theme['badgeBorder'] }} tracking-wide">
                {!! $theme['icon'] !!}
                {{ $theme['label'] }}
            </span>
            @if($project->is_expired)
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-red-100 text-red-700 tracking-wide">
                Kadaluarsa
            </span>
            @endif
            <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">Dipublikasikan: {{ $project->created_at->format('d M Y') }}</span>
        </div>
        <div class="flex items-center gap-3 mb-1">
            <a wire:navigate href="{{ route('projects.show', $project->id) }}" class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors block">
                {{ $project->title }}
            </a>
            @if(($project->accepted_proposals_count ?? 0) > 0 && $project->status === 'published')
                <span class="px-2.5 py-1 bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10px] font-bold rounded-lg flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                    {{ $project->accepted_proposals_count }} Kemitraan Terjalin
                </span>
            @endif
        </div>
        <p class="text-sm text-slate-500 line-clamp-1">{{ Str::limit($project->description, 100) }}</p>
    </div>
    
    <div class="flex flex-col md:flex-row md:items-center gap-5 md:gap-6 mt-4 md:mt-0 pt-4 md:pt-0 border-t border-slate-100 md:border-t-0 md:border-l md:border-slate-200 md:pl-6">
        @php 
            $isUMKM = auth()->check() && in_array(strtolower(auth()->user()->company->skala_usaha ?? ''), ['mikro', 'kecil']);
            $proposalLabel = $isUMKM ? 'Ketertarikan' : 'Proposal';
        @endphp
        <div class="flex items-center justify-around md:justify-start gap-6 w-full md:w-auto">
            <div class="text-center">
                <p class="text-xs text-slate-400 font-medium mb-0.5">{{ $proposalLabel }} Masuk</p>
                <p class="text-xl font-black text-slate-800">{{ $project->proposals_count ?? 0 }}</p>
            </div>
            <div class="text-center">
                <p class="text-xs text-slate-400 font-medium mb-0.5">Sisa Waktu</p>
                <p class="text-sm font-bold text-amber-600">
                    @if($project->is_expired)
                        <span class="text-red-600">Berakhir</span>
                    @elseif($project->offer_end_date)
                        {{ \Carbon\Carbon::parse($project->offer_end_date)->locale('id')->diffForHumans(null, true) }}
                    @else
                        Terbuka
                    @endif
                </p>
            </div>
        </div>
        <div class="flex flex-row md:flex-col gap-2 w-full md:w-auto mt-2 md:mt-0">
            <div class="flex-1 md:flex-none w-full">
                @if(($project->proposals_count ?? 0) > 0)
                    <button type="button" onclick="filterProposalsByProject({{ $project->id }}, '{{ addslashes($project->title) }}')" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                        Lihat {{ $project->proposals_count }} {{ $proposalLabel }}
                    </button>
                @else
                    <a wire:navigate href="{{ route('projects.show', $project->id) }}" class="block w-full px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                        Lihat Detail
                    </a>
                @endif
            </div>
            
            <div x-data="{ showCloseModal: false, showDeleteModal: false, openDropdown: false }" class="relative flex items-center justify-end md:justify-start shrink-0 w-full md:w-auto">
                
                <!-- Desktop Full Buttons -->
                <div class="hidden md:flex items-center gap-2">
                    @if($project->status === 'published' && ($project->proposals_count ?? 0) > 0)
                    <button type="button" @click="showCloseModal = true" class="px-4 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                        Tutup Proyek
                    </button>
                    @endif

                    @if($project->proposals()->count() === 0)
                    <button type="button" @click="showDeleteModal = true" class="px-4 py-1.5 bg-white border border-red-200 hover:bg-red-50 text-red-600 text-xs font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                        Hapus
                    </button>
                    @endif
                    
                    <a wire:navigate href="{{ route('projects.edit', $project->id) }}" class="px-4 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                        Edit
                    </a>
                </div>

                <!-- Mobile Three Dots Menu -->
                <div class="md:hidden">
                    <button type="button" @click="openDropdown = !openDropdown" @click.outside="openDropdown = false" class="p-2 h-full min-h-[38px] text-slate-400 hover:text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition-colors flex items-center justify-center aspect-square">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="openDropdown" style="display: none;" class="absolute right-0 bottom-full mb-2 w-48 bg-white rounded-xl shadow-lg border border-slate-200 py-2 z-10" x-transition.opacity>
                        
                        <a wire:navigate href="{{ route('projects.edit', $project->id) }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors w-full text-left font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                            Edit Proyek
                        </a>

                        @if($project->status === 'published' && ($project->proposals_count ?? 0) > 0)
                        <button type="button" @click="openDropdown = false; showCloseModal = true" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors w-full text-left font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 14v1"/><path d="M15 14v1"/><path d="M9 9v1"/><path d="M15 9v1"/></svg>
                            Tutup Proyek
                        </button>
                        @endif

                        @if($project->proposals()->count() === 0)
                        <button type="button" @click="openDropdown = false; showDeleteModal = true" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors w-full text-left font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-400"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                            Hapus Proyek
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Modals -->
                @if($project->status === 'published' && ($project->proposals_count ?? 0) > 0)
                <x-modal.confirm 
                    showProperty="showCloseModal" 
                    title="Tutup Proyek Ini?"
                    iconBgClass="bg-slate-100"
                    iconTextClass="text-slate-600">
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-600"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 14v1"/><path d="M15 14v1"/><path d="M9 9v1"/><path d="M15 9v1"/></svg>
                    </x-slot:icon>
                    
                    <p class="mb-4 text-left">Apakah Anda yakin ingin menutup proyek <span class="font-bold">"{{ $project->title }}"</span>?</p>
                    
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-left">
                        <p class="text-amber-800 text-xs font-medium leading-relaxed">
                            Proyek yang ditutup tidak akan menerima tawaran baru dan akan dipindahkan ke tab <span class="font-bold">Riwayat Proyek Selesai</span>. Tindakan ini menandakan proyek telah selesai atau Anda telah mendapatkan mitra yang sesuai.
                        </p>
                    </div>
                    
                    <x-slot:actions>
                        <form action="{{ route('projects.close', $project->id) }}" method="POST" class="m-0 w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                            <button type="submit" class="w-full px-5 py-2.5 text-sm font-bold text-white bg-slate-800 hover:bg-slate-900 rounded-xl transition-colors shadow-sm">
                                Ya, Tutup Proyek
                            </button>
                        </form>
                    </x-slot:actions>
                </x-modal.confirm>
                @endif

                @if($project->proposals()->count() === 0)
                <x-modal.confirm 
                    showProperty="showDeleteModal" 
                    title="Hapus Proyek Ini?">
                    <p class="text-left">Apakah Anda yakin ingin menghapus proyek <span class="font-bold">"{{ $project->title }}"</span>? Tindakan ini tidak dapat dibatalkan.</p>
                    
                    <x-slot:actions>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="m-0 w-full">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                            <button type="submit" class="w-full px-5 py-2.5 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors shadow-sm">
                                Ya, Hapus
                            </button>
                        </form>
                    </x-slot:actions>
                </x-modal.confirm>
                @endif
            </div>
        </div>
    </div>
</div>
