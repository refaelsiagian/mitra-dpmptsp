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
    
    <div class="flex items-center gap-6 md:border-l border-slate-200 md:pl-6">
        <div class="text-center">
            <p class="text-xs text-slate-400 font-medium mb-0.5">Proposal Masuk</p>
            <p class="text-xl font-black text-slate-800">0</p>
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
        <div class="flex flex-col gap-2">
            <a href="{{ route('projects.show', $project->id) }}" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                Lihat Detail
            </a>
            <a href="{{ route('projects.edit', $project->id) }}" class="w-full px-4 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                Edit Proyek
            </a>
            <!-- Form Delete -->
            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full px-4 py-1.5 bg-white border border-red-200 hover:bg-red-50 text-red-600 text-xs font-bold rounded-lg transition-colors whitespace-nowrap text-center">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
