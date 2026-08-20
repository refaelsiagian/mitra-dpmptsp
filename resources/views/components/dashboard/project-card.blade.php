@props(['project'])

<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group bg-white">
    <div class="flex-1">
        <div class="flex items-center gap-2 mb-2">
            @php
                $badgeColor = 'bg-slate-100 text-slate-700';
                switch($project->type) {
                    case 'subkontrak': $badgeColor = 'bg-blue-100 text-blue-700'; break;
                    case 'rantai_pasok': $badgeColor = 'bg-indigo-100 text-indigo-700'; break;
                    case 'outsourcing': $badgeColor = 'bg-rose-100 text-rose-700'; break;
                    case 'konstruksi': $badgeColor = 'bg-amber-100 text-amber-700'; break;
                    case 'kso': $badgeColor = 'bg-emerald-100 text-emerald-700'; break;
                    case 'perdagangan': $badgeColor = 'bg-purple-100 text-purple-700'; break;
                    case 'distribusi': $badgeColor = 'bg-teal-100 text-teal-700'; break;
                }
            @endphp
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $badgeColor }} tracking-wide uppercase">
                {{ str_replace('_', ' ', $project->type) }}
            </span>
            <span class="text-xs font-semibold text-slate-400 border-l border-slate-300 pl-2">Dipublikasikan: {{ $project->created_at->format('d M Y') }}</span>
        </div>
        <div class="flex items-center gap-3 mb-1">
            <a href="{{ route('projects.show', $project->id) }}" class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors block">
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
        <div class="flex items-center justify-around md:justify-start gap-6 w-full md:w-auto">
            <div class="text-center">
                <p class="text-xs text-slate-400 font-medium mb-0.5">Proposal Masuk</p>
                <p class="text-xl font-black text-slate-800">{{ $project->proposals_count ?? 0 }}</p>
            </div>
            <div class="text-center">
                <p class="text-xs text-slate-400 font-medium mb-0.5">Sisa Waktu</p>
                <p class="text-sm font-bold text-amber-600">
                    @if($project->offer_end_date)
                        {{ \Carbon\Carbon::parse($project->offer_end_date)->diffForHumans(null, true) }}
                    @else
                        Terbuka
                    @endif
                </p>
            </div>
        </div>
        <div class="flex flex-col gap-2 w-full md:w-auto mt-2 md:mt-0">
            @if(($project->proposals_count ?? 0) > 0)
                <button type="button" onclick="filterProposalsByProject({{ $project->id }}, '{{ addslashes($project->title) }}')" class="w-full md:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                    Lihat {{ $project->proposals_count }} Proposal
                </button>
            @else
                <a href="{{ route('projects.show', $project->id) }}" class="w-full md:w-auto px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                    Lihat Detail
                </a>
            @endif
            <div class="flex items-center gap-2 w-full md:w-auto flex-wrap md:flex-nowrap">
                @if($project->status === 'published')
                <!-- Alpine Modal Wrapper for Tutup Proyek -->
                <div x-data="{ showCloseModal: false }" class="flex-1 md:flex-none">
                    <button type="button" @click="showCloseModal = true" class="w-full px-4 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                        Tutup Proyek
                    </button>

                    <!-- Modal Tutup Proyek -->
                    <template x-teleport="body">
                        <div x-show="showCloseModal" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4"
                             style="display: none;">
                             
                             <div x-show="showCloseModal"
                                  @click.away="showCloseModal = false"
                                  x-transition:enter="transition ease-out duration-300"
                                  x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                  x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                  x-transition:leave="transition ease-in duration-200"
                                  x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                  x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                  class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden relative flex flex-col max-h-full">
                                <div class="p-6 overflow-y-auto">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-600"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 14v1"/><path d="M15 14v1"/><path d="M9 9v1"/><path d="M15 9v1"/></svg>
                                    </div>
                                    <h3 class="text-xl font-black text-slate-900 mb-2">Tutup Proyek Ini?</h3>
                                    <p class="text-slate-600 text-sm mb-4 leading-relaxed">
                                        Apakah Anda yakin ingin menutup proyek <span class="font-bold">"{{ $project->title }}"</span>? 
                                    </p>
                                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                        <p class="text-amber-800 text-xs font-medium leading-relaxed">
                                            Proyek yang ditutup tidak akan menerima tawaran baru dan akan dipindahkan ke tab <span class="font-bold">Riwayat Proyek Selesai</span>. Tindakan ini menandakan proyek telah selesai atau Anda telah mendapatkan mitra yang sesuai.
                                        </p>
                                    </div>
                                </div>
                                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-3 shrink-0">
                                    <button type="button" @click="showCloseModal = false" class="px-5 py-2.5 text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-200 bg-slate-100 rounded-xl transition-colors">
                                        Batal
                                    </button>
                                    <form action="{{ route('projects.close', $project->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="w-full px-5 py-2.5 text-sm font-bold text-white bg-slate-800 hover:bg-slate-900 rounded-xl transition-colors shadow-sm">
                                            Ya, Tutup Proyek
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                @endif
                <a href="{{ route('projects.edit', $project->id) }}" class="flex-1 md:flex-none px-4 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                    Edit
                </a>
                @if($project->proposals()->count() === 0)
                <!-- Form Delete -->
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');" class="flex-1 md:flex-none">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-1.5 bg-white border border-red-200 hover:bg-red-50 text-red-600 text-xs font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                        Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
