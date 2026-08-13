@props(['pinnedOffering'])

@if($pinnedOffering)
<div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 md:p-8 text-white shadow-lg shadow-blue-900/20 relative overflow-hidden">
    <!-- Background Decoration -->
    <svg class="absolute top-0 right-0 text-white/10 w-48 h-48 -mr-12 -mt-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="m17 5-5-3-5 3v14l5 3 5-3z"/></svg>
    
    <div class="relative z-10">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-bold uppercase tracking-wider mb-4 border border-white/30">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
            {{ $pinnedOffering->category ?? 'Sorotan Utama' }}
        </div>
        <h2 class="text-2xl font-bold mb-2">{{ $pinnedOffering->title }}</h2>
        <p class="text-blue-100 mb-6 max-w-xl leading-relaxed text-sm md:text-base">
            {{ $pinnedOffering->description }}
        </p>
        
        <a href="#" class="inline-flex items-center gap-2 bg-white text-blue-700 hover:bg-blue-50 font-bold px-5 py-2.5 rounded-lg transition-colors text-sm shadow-sm">
            Lihat Detail Proyek
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
    </div>
</div>
@endif
