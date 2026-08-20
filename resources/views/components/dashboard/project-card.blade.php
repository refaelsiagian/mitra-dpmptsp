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
        <a href="{{ route('projects.show', $project->id) }}" class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors block mb-1">
            {{ $project->title }}
        </a>
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
            <div class="flex items-center gap-2 w-full md:w-auto">
                <a href="{{ route('projects.edit', $project->id) }}" class="flex-1 md:flex-none px-4 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                    Edit
                </a>
                <!-- Form Delete -->
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');" class="flex-1 md:flex-none">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-1.5 bg-white border border-red-200 hover:bg-red-50 text-red-600 text-xs font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
