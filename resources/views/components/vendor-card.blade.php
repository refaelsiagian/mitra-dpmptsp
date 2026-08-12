<div class="group bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row gap-6 relative overflow-hidden">
    <!-- Left side: Image & Badge -->
    <div class="relative flex-shrink-0">
        <!-- Thumbnail Placeholder -->
        <div class="w-24 h-24 sm:w-32 sm:h-32 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M12 12v9"/><path d="m8 17 4 4 4-4"/></svg>
        </div>
    </div>

    <!-- Middle: Info -->
    <div class="flex-1 flex flex-col justify-center">
        <h3 class="text-lg sm:text-xl font-bold text-slate-900 group-hover:text-blue-700 transition-colors">
            <a href="{{ $profileUrl ?? '/vendor-profile' }}">{{ $name ?? 'CV Baja Nusantara' }}</a>
        </h3>
        <p class="text-sm text-slate-500 mt-1 font-medium">
            {{ $category ?? 'Konstruksi Logam & Fabrikasi' }}
        </p>
        
        <div class="flex items-center gap-1.5 text-sm text-slate-500 mt-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            <span>{{ $location ?? 'Medan, Sumatera Utara' }}</span>
        </div>

        <!-- Chips -->
        <div class="flex flex-wrap gap-2 mt-3">
            @if(isset($chips) && is_array($chips))
                @foreach($chips as $chip)
                    <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200/60">{{ $chip }}</span>
                @endforeach
            @else
                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200/60">Welding</span>
                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200/60">CNC Machining</span>
                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200/60">Baja Ringan</span>
            @endif
        </div>

        <!-- Active Project Offered Indicator -->
        @if(isset($activeProject))
            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center gap-2">
                <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-200 flex items-center gap-1 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Proyek Aktif:
                </span>
                <a href="{{ $projectUrl ?? '#' }}" class="text-xs font-semibold text-slate-700 hover:text-blue-600 transition-colors truncate max-w-[200px] sm:max-w-md underline decoration-slate-300 underline-offset-2">{{ $activeProject }}</a>
            </div>
        @endif
    </div>

    <!-- Right side: Actions -->
    <div class="flex flex-col items-start sm:items-end justify-between sm:w-48 gap-4 sm:gap-0 border-t sm:border-t-0 sm:border-l border-slate-100 pt-4 sm:pt-0 sm:pl-6 flex-shrink-0">
        <!-- Status -->
        <div class="flex items-center gap-2">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
            </span>
            <span class="text-xs font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">Menerima Proyek</span>
        </div>
        
        <!-- Buttons -->
        <div class="flex flex-row sm:flex-col gap-2 w-full mt-auto">
            <button class="flex-1 sm:flex-none justify-center items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm shadow-blue-200 focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 focus:outline-none flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                Undang
            </button>
            <a href="{{ $profileUrl ?? '/vendor-profile' }}" class="flex-1 sm:flex-none justify-center items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 text-sm font-medium rounded-lg transition-colors focus:ring-2 focus:ring-slate-200 focus:ring-offset-1 focus:outline-none flex text-center">
                Lihat Profil
            </a>
        </div>
    </div>
</div>
