@props(['pinnedProject'])

@if($pinnedProject)
<div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl p-6 md:p-8 text-white shadow-lg shadow-indigo-900/20 relative overflow-hidden group border border-indigo-500/30">
    <!-- Background Decoration -->
    <svg class="absolute top-0 right-0 text-white/10 w-64 h-64 -mr-16 -mt-16 transform group-hover:scale-110 transition-transform duration-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full group-hover:translate-x-full duration-[1.5s] transition-transform ease-in-out"></div>
    
    <div class="relative z-10">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-400/20 backdrop-blur-sm text-amber-300 rounded-full text-xs font-bold uppercase tracking-wider mb-5 border border-amber-400/30 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
            Proyek Sorotan
        </div>
        
        <h2 class="text-2xl md:text-3xl font-bold mb-3 pr-8 leading-tight">{{ $pinnedProject->title }}</h2>
        
        <p class="text-indigo-100 mb-6 max-w-2xl leading-relaxed text-sm md:text-base line-clamp-3">
            {{ $pinnedProject->description }}
        </p>
        
        <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-8">
            <div class="flex items-center gap-2 text-sm text-indigo-50 font-medium">
                <div class="p-1.5 bg-white/10 rounded-md backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                </div>
                <span>Anggaran: <span class="font-bold text-white">{{ $pinnedProject->estimated_value ? 'Rp ' . number_format($pinnedProject->estimated_value, 0, ',', '.') : 'TBA' }}</span></span>
            </div>
            
            <div class="hidden sm:block w-1.5 h-1.5 rounded-full bg-white/30"></div>
            
            <div class="flex items-center gap-2 text-sm text-indigo-50 font-medium">
                <div class="p-1.5 bg-white/10 rounded-md backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <span>Tenggat: <span class="font-bold text-white">
                    @if($pinnedProject->is_expired)
                        <span class="text-red-300">Berakhir</span>
                    @else
                        {{ $pinnedProject->offer_end_date ? \Carbon\Carbon::parse($pinnedProject->offer_end_date)->format('d M Y') : 'Terbuka' }}
                    @endif
                </span></span>
            </div>
        </div>
        
        <a wire:navigate href="{{ route('projects.show', $pinnedProject->id) }}" class="inline-flex items-center gap-2 bg-white text-indigo-700 hover:bg-indigo-50 font-bold px-6 py-3 rounded-xl transition-all text-sm shadow-md hover:shadow-lg hover:-translate-y-0.5">
            Lihat Detail Proyek
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
    </div>
</div>
@endif
